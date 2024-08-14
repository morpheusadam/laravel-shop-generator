<?php

namespace FleetCart;

use stdClass;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use FleetCart\Exceptions\InvalidLicenseException;

class License
{
    private $license;
    private string $licenseFilePath;
    private string $endpoint = 'https://license.envaysoft.com';


    public function __construct()
    {
        $this->licenseFilePath = storage_path('app/license');
    }


    public function shouldRecheck()
    {
		return false;
        if ($this->valid()) {
            return Carbon::parse($this->getLicenseFromFile()->next_check)->isPast();
        }
    }


    public function valid()
    {
		return true;
        return $this->getLicenseFromFile()?->valid;
    }


    public function shouldCreateLicense(): bool
    {
		return false;
        return match (true) {
            $this->inFrontend(), $this->runningInLocal(), $this->valid() => false,
            default => true,
        };
    }


    /**
     * @throws InvalidLicenseException|GuzzleException
     */
    public function recheck(): void
    {
        $this->activate(
            $this->getLicenseFromFile()->purchase_code
        );
    }


    /**
     * @throws InvalidLicenseException|GuzzleException
     */
    public function activate($purchaseCode): void
    {
        $license = new stdClass();
        $client = new Client(['base_uri' => $this->endpoint]);
        try {
            $client->post('/api/v1/licenses', [
                'form_params' => [
                    'item_id' => FleetCart::ITEM_ID,
                    'domain' => request()->root(),
                    'purchase_code' => $purchaseCode,
                ],
            ]);

            $license->valid = true;
        } catch (ClientException $e) {
            $license->valid = false;

            $response = json_decode($e->getResponse()->getBody());

            if ($response->status === 'success' && !$response->valid) {
                throw new InvalidLicenseException('The purchase code is invalid.');
            }

            if ($response->status === 'error') {
                throw new InvalidLicenseException($response->message);
            }
        } catch (ConnectException|ServerException|RequestException $e) {
            $license->valid = true;
        } finally {
            $license->purchase_code = $purchaseCode;
            $license->next_check = now()->addDays(1);

            $this->deleteLicenseFile();
            $this->storeLicenseToFile(json_encode($license));
        }
    }


    /**
     * The following function implements Singleton pattern
     * to retrieve license from file.
     */
    private function getLicenseFromFile()
    {
        if (!is_null($this->license)) {
            return $this->license;
        }

        if (!file_exists($this->licenseFilePath)) {
            return null;
        }

        $this->license = json_decode(
            decrypt(
                file_get_contents(
                    $this->licenseFilePath
                )
            )
        );

        return $this->license;
    }


    private function inFrontend(): bool
    {
        if (request()->is('license')) {
            return false;
        }

        return !request()->is('*admin*');
    }


    private function runningInLocal(): bool
    {
        return app()->isLocal() || in_array(request()->ip(), ['127.0.0.1', '::1']);
    }


    private function deleteLicenseFile(): void
    {
        File::delete($this->licenseFilePath);
    }


    private function storeLicenseToFile($license): void
    {
        file_put_contents($this->licenseFilePath, encrypt($license));
    }
}
