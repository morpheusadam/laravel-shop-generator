<?php

namespace Modules\Sms\Gateways;

use Exception;
use Twilio\Rest\Client;
use Modules\Sms\GatewayInterface;
use Modules\Sms\Exceptions\SmsException;
use Twilio\Exceptions\ConfigurationException;

class Twilio implements GatewayInterface
{
    /**
     * @throws SmsException
     */
    public function send(string $to, string $message)
    {
        try {
            $this->client()->messages->create(
                $to,
                [
                    'from' => setting('sms_from'),
                    'body' => $message,
                ]
            );
        } catch (Exception $e) {
            throw new SmsException('Twilio: ' . $e->getMessage());
        }
    }


    /**
     * @throws ConfigurationException
     */
    public function client()
    {
        return new Client(setting('twilio_sid'), setting('twilio_token'));
    }
}
