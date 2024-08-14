@extends('storefront::public.account.layout')

@section('title', trans('storefront::account.pages.my_addresses'))

@push('globals')
    <script>
        FleetCart.langs['storefront::account.addresses.confirm'] = '{{ trans('storefront::account.addresses.confirm') }}';
    </script>
@endpush

@section('panel')
    <my-addresses
        :initial-addresses="{{ $addresses }}"
        :initial-default-address="{{ $defaultAddress }}"
        :countries="{{ json_encode($countries) }}"
        inline-template
    >
        <div class="panel">
            <div class="panel-header">
                <h4>{{ trans('storefront::account.pages.my_addresses') }}</h4>
            </div>

            <div class="panel-body" v-cloak>
                <div class="my-addresses">
                    <div class="address-card-wrap" v-if="hasAddress && ! formOpen">
                        <div class="row">
                            <div class="col-xl-6 col-lg-9 d-flex" v-for="address in addresses" :key="address.id">
                                <address
                                    class="address-card d-flex flex-column justify-content-between"
                                    :class="{
                                        active: defaultAddress.address_id === address.id
                                    }"
                                    @click="changeDefaultAddress(address)"
                                >
                                    <svg class="address-card-selected-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2ZM16.78 9.7L11.11 15.37C10.97 15.51 10.78 15.59 10.58 15.59C10.38 15.59 10.19 15.51 10.05 15.37L7.22 12.54C6.93 12.25 6.93 11.77 7.22 11.48C7.51 11.19 7.99 11.19 8.28 11.48L10.58 13.78L15.72 8.64C16.01 8.35 16.49 8.35 16.78 8.64C17.07 8.93 17.07 9.4 16.78 9.7Z" fill="#292D32"/>
                                    </svg>  
                                    
                                    <span class="badge" v-if="defaultAddress.address_id === address.id">
                                        {{ trans('storefront::account.addresses.default') }}
                                    </span> 

                                    <div class="address-card-data">
                                        <span v-text="address.full_name"></span>
                                        <span v-text="address.address_1"></span>
                                        <span v-if="address.address_2" v-text="address.address_2"></span>
                                        <span v-html="`${address.city}, ${address.state_name} ${address.zip}`"></span>
                                        <span v-text="address.country_name"></span>
                                    </div>

                                    <div class="address-card-actions">
                                        <button type="button" class="btn btn-edit-address" @click.stop="edit(address)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M16.04 3.02001L8.16 10.9C7.86 11.2 7.56 11.79 7.5 12.22L7.07 15.23C6.91 16.32 7.68 17.08 8.77 16.93L11.78 16.5C12.2 16.44 12.79 16.14 13.1 15.84L20.98 7.96001C22.34 6.60001 22.98 5.02001 20.98 3.02001C18.98 1.02001 17.4 1.66001 16.04 3.02001Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M14.91 4.1499C15.58 6.5399 17.45 8.4099 19.85 9.0899" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            {{ trans('storefront::account.addresses.edit') }}
                                        </button>

                                        <button type="button" class="btn btn-delete-address" @click.stop="remove(address)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M21 5.97998C17.67 5.64998 14.32 5.47998 10.98 5.47998C9 5.47998 7.02 5.57998 5.04 5.77998L3 5.97998" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M8.5 4.97L8.72 3.66C8.88 2.71 9 2 10.69 2H13.31C15 2 15.13 2.75 15.28 3.67L15.5 4.97" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M18.85 9.14001L18.2 19.21C18.09 20.78 18 22 15.21 22H8.79C6 22 5.91 20.78 5.8 19.21L5.15 9.14001" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M10.33 16.5H13.66" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M9.5 12.5H14.5" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            {{ trans('storefront::account.addresses.delete') }}
                                        </button>
                                    </div>

                                </address>
                            </div>

                            <div class="col-md-18">
                                <button
                                    type="button"
                                    class="btn btn-lg btn-default btn-add-new-address"
                                    @click="formOpen = true"
                                >
                                    {{ trans('storefront::account.addresses.add_new_address') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <form @submit.prevent="save" @input="errors.clear($event.target.name)" v-else>
                        <div class="add-new-address-form">
                            <h5 class="section-title">
                                {{ trans('storefront::account.addresses.new_address') }}
                            </h5>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="first-name">
                                            {{ trans('storefront::account.addresses.first_name') }}<span>*</span>
                                        </label>

                                        <input v-model="form.first_name" name="first_name" type="text" id="first-name"
                                            class="form-control">

                                        <span class="error-message" v-if="errors.has('first_name')"
                                            v-text="errors.get('first_name')">
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="last-name">
                                            {{ trans('storefront::account.addresses.last_name') }}<span>*</span>
                                        </label>

                                        <input v-model="form.last_name" name="last_name" type="text" id="last-name"
                                            class="form-control">

                                        <span class="error-message" v-if="errors.has('last_name')"
                                            v-text="errors.get('last_name')">
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-18">
                                    <div class="form-group">
                                        <label for="address-1">
                                            {{ trans('storefront::account.addresses.street_address') }}<span>*</span>
                                        </label>

                                        <input v-model="form.address_1" name="address_1" type="text" id="address-1"
                                            placeholder="{{ trans('storefront::account.addresses.address_line_1') }}"
                                            class="form-control">

                                        <span class="error-message" v-if="errors.has('address_1')"
                                            v-text="errors.get('address_1')">
                                        </span>
                                    </div>

                                    <div class="form-group">
                                        <input v-model="form.address_2" name="address_2" type="text" id="address-2"
                                            placeholder="{{ trans('storefront::account.addresses.address_line_2') }}"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="city">
                                            {{ trans('storefront::account.addresses.city') }}<span>*</span>
                                        </label>

                                        <input v-model="form.city" name="city" type="text" id="city"
                                            class="form-control">

                                        <span class="error-message" v-if="errors.has('city')" v-text="errors.get('city')">
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="zip">
                                            {{ trans('storefront::account.addresses.zip') }}<span>*</span>
                                        </label>

                                        <input v-model="form.zip" name="zip" type="text" id="zip"
                                            class="form-control">

                                        <span class="error-message" v-if="errors.has('zip')" v-text="errors.get('zip')">
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="country">
                                            {{ trans('storefront::account.addresses.country') }}<span>*</span>
                                        </label>

                                        <select
                                            :value="form.country"
                                            name="country"
                                            id="country"
                                            class="form-control arrow-black"
                                            @change="changeCountry($event.target.value)"
                                        >
                                            <option v-for="(name, code) in countries" :value="code" v-text="name">
                                            </option>
                                        </select>

                                        <span class="error-message" v-if="errors.has('country')"
                                            v-text="errors.get('country')">
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="state">
                                            {{ trans('storefront::account.addresses.state') }}<span>*</span>
                                        </label>

                                        <input v-model="form.state" name="state" type="text" id="state"
                                            class="form-control" v-if="hasNoStates">

                                        <select v-model="form.state" name="state" id="state"
                                            class="form-control arrow-black" v-else>
                                            <option value="">
                                                {{ trans('storefront::account.addresses.please_select') }}
                                            </option>

                                            <option v-for="(name, code) in states" :value="code" v-html="name">
                                            </option>
                                        </select>

                                        <span class="error-message" v-if="errors.has('state')"
                                            v-text="errors.get('state')">
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-18">
                                    <button
                                        type="button"
                                        class="btn btn-lg btn-default btn-cancel"
                                        v-if="hasAddress"
                                        @click="cancel"
                                    >
                                        {{ trans('storefront::account.addresses.cancel') }}
                                    </button>

                                    <button
                                        type="submit"
                                        class="btn btn-lg btn-primary btn-save-address"
                                        :class="{ 'btn-loading': loading }"
                                    >
                                        {{ trans('storefront::account.addresses.save_address') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </my-addresses>
@endsection
