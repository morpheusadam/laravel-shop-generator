<?php

namespace FleetCart\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Http\Requests\Request;

class InstallRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'db_host' => 'required',
            'db_port' => 'required',
            'db_username' => 'required',
            'db_password' => 'nullable',
            'db_database' => 'required',
            'admin_first_name' => 'required',
            'admin_last_name' => 'required',
            'admin_email' => 'required|email',
            'admin_phone' => 'required',
            'admin_password' => 'required|confirmed|min:6',
            'store_name' => 'required',
            'store_email' => 'required|email',
            'store_phone' => 'required',
            'store_search_engine' => ['required', Rule::in(['mysql', 'algolia', 'meilisearch'])],
            'algolia_app_id' => 'required_if:store_search_engine,algolia',
            'algolia_secret' => 'required_if:store_search_engine,algolia',
            'meilisearch_host' => 'required_if:store_search_engine,meilisearch',
            'meilisearch_key' => 'required_if:store_search_engine,meilisearch',
        ];
    }


    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'db_host' => 'host',
            'db_port' => 'port',
            'db_username' => 'username',
            'db_password' => 'password',
            'db_database' => 'datbase',
            'admin_first_name' => 'first name',
            'admin_last_name' => 'last name',
            'admin_email' => 'email',
            'admin_phone' => 'phone',
            'admin_password' => 'password',
            'store_name' => 'store name',
            'store_email' => 'store email',
            'store_phone' => 'store phone',
            'store_search_engine' => 'search engine',
            'algolia_app_id' => 'algolia application id',
            'algolia_secret' => 'algolia admin api key',
            'meilisearch_host' => 'meilisearch host',
            'meilisearch_key' => 'meilisearch key',
        ];
    }
}
