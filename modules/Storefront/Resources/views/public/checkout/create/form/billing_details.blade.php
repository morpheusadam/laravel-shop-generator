<div class="billing-details">
    <h4 class="section-title">{{ trans('storefront::checkout.billing_details') }}</h4>

    <div class="address-card-wrap" v-if="hasAddress" v-cloak>
        <div class="row">
            <div class="col d-flex" v-for="address in addresses" :key="address.id">
                <address
                    class="address-card"
                    :class="{
                        active: form.billingAddressId === address.id && !form.newBillingAddress
                    }"
                    @click="changeBillingAddress(address)"
                >
                    <svg class="address-card-selected-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2ZM16.78 9.7L11.11 15.37C10.97 15.51 10.78 15.59 10.58 15.59C10.38 15.59 10.19 15.51 10.05 15.37L7.22 12.54C6.93 12.25 6.93 11.77 7.22 11.48C7.51 11.19 7.99 11.19 8.28 11.48L10.58 13.78L15.72 8.64C16.01 8.35 16.49 8.35 16.78 8.64C17.07 8.93 17.07 9.4 16.78 9.7Z" fill="#292D32"/>
                    </svg>    

                    <span class="badge" v-if="defaultAddress.address_id === address.id">
                        {{ trans('storefront::checkout.default') }}
                    </span>
                    
                    <div class="address-card-data">
                        <span v-text="address.full_name"></span>
                        <span v-text="address.address_1"></span>
                        <span v-if="address.address_2" v-text="address.address_2"></span>
                        <span v-html="`${address.city}, ${address.state_name} ${address.zip}`"></span>
                        <span v-text="address.country_name"></span>
                    </div>
                </address>
            </div>
        </div>

        <span class="error-message" v-if="!form.newBillingAddress && errors.has('billing.address_1')">
            {{ trans('storefront::checkout.you_must_select_an_address') }}
        </span>
    </div>

    <div class="add-new-address-wrap" v-cloak>
        <button v-if="hasAddress" type="button" class="btn btn-add-new-address" @click="addNewBillingAddress">
            @{{ form.newBillingAddress ? '-' : '+'}} {{ trans('storefront::checkout.add_new_address') }}
        </button>

        <div class="add-new-address-form" v-show="!hasAddress || form.newBillingAddress">
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="billing-first-name">
                            {{ trans('checkout::attributes.billing.first_name') }}<span>*</span>
                        </label>

                        <input type="text" name="billing[first_name]" v-model="form.billing.first_name"
                            id="billing-first-name" class="form-control">

                        <span class="error-message" v-if="errors.has('billing.first_name')"
                            v-text="errors.get('billing.first_name')">
                        </span>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="form-group">
                        <label for="billing-last-name">
                            {{ trans('checkout::attributes.billing.last_name') }}<span>*</span>
                        </label>

                        <input type="text" name="billing[last_name]" v-model="form.billing.last_name"
                            id="billing-last-name" class="form-control">

                        <span class="error-message" v-if="errors.has('billing.last_name')"
                            v-text="errors.get('billing.last_name')">
                        </span>
                    </div>
                </div>

                <div class="col-md-18">
                    <div class="form-group">
                        <label for="billing-address-1">
                            {{ trans('checkout::attributes.street_address') }}<span>*</span>
                        </label>

                        <input type="text" name="billing[address_1]" v-model="form.billing.address_1"
                            id="billing-address-1" class="form-control"
                            placeholder="{{ trans('checkout::attributes.billing.address_1') }}">

                        <span class="error-message" v-if="errors.has('billing.address_1')"
                            v-text="errors.get('billing.address_1')">
                        </span>
                    </div>

                    <div class="form-group">
                        <input type="text" name="billing[address_2]" v-model="form.billing.address_2"
                            class="form-control" placeholder="{{ trans('checkout::attributes.billing.address_2') }}">
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="form-group">
                        <label for="billing-city">
                            {{ trans('checkout::attributes.billing.city') }}<span>*</span>
                        </label>

                        <input type="text" name="billing[city]" :value="form.billing.city" id="billing-city"
                            class="form-control" @change="changeBillingCity($event.target.value)">

                        <span class="error-message" v-if="errors.has('billing.city')"
                            v-text="errors.get('billing.city')">
                        </span>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="form-group">
                        <label for="billing-zip">
                            {{ trans('checkout::attributes.billing.zip') }}<span>*</span>
                        </label>

                        <input type="text" name="billing[zip]" :value="form.billing.zip" id="billing-zip"
                            class="form-control" @change="changeBillingZip($event.target.value)">

                        <span class="error-message" v-if="errors.has('billing.zip')" v-text="errors.get('billing.zip')">
                        </span>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="form-group">
                        <label for="billing-country">
                            {{ trans('checkout::attributes.billing.country') }}<span>*</span>
                        </label>

                        <select name="billing[country]" id="billing-country" class="form-control arrow-black"
                            @change="changeBillingCountry($event.target.value)">
                            <option value="">{{ trans('storefront::checkout.please_select') }}</option>

                            <option v-for="(name, code) in countries" :value="code" v-text="name">
                            </option>
                        </select>

                        <span class="error-message" v-if="errors.has('billing.country')"
                            v-text="errors.get('billing.country')">
                        </span>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="form-group">
                        <label for="billing-state">
                            {{ trans('checkout::attributes.billing.state') }}<span>*</span>
                        </label>

                        <input type="text" name="billing[state]" id="billing-state" class="form-control"
                            v-if="!hasBillingStates" v-model="form.billing.state">

                        <select name="billing[state]" id="billing-state" class="form-control arrow-black"
                            @change="changeBillingState($event.target.value)" v-else>
                            <option value="">{{ trans('storefront::checkout.please_select') }}</option>

                            <option v-for="(name, code) in states.billing" :value="code" v-html="name">
                            </option>
                        </select>

                        <span class="error-message" v-if="errors.has('billing.state')"
                            v-text="errors.get('billing.state')">
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
