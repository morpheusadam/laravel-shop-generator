@extends('user::admin.auth.layout')

@section('title', 'FleetCart Activation')

@section('content')
    <div class="bg-shape-layer"></div>

    <div class="bg-yellow-shape">
        <svg xmlns="http://www.w3.org/2000/svg" width="120" height="125" viewBox="0 0 120 125" fill="none">
            <path
                d="M125.143 158.853C47.8652 155.266 13.5195 136.007 6.00644 126.826C-20.7831 33.0517 48.5091 3.20269 86.504 0C-0.433365 64.0537 221.74 163.337 125.143 158.853Z"
                fill="#FFAD00" />
        </svg>
    </div>

    <div class="bg-green-shape">
        <svg xmlns="http://www.w3.org/2000/svg" width="148" height="71" viewBox="0 0 148 71" fill="none">
            <g filter="url(#filter0_d_2414_189)">
                <path
                    d="M4.74654 103C0.139535 55.1211 14.6977 -30.3244 109.786 10.9251C204.875 52.1747 79.3801 89.4957 4.74654 103Z"
                    fill="#00BC65" />
            </g>
            <defs>
                <filter id="filter0_d_2414_189" x="0" y="0" width="148" height="111"
                    filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix" />
                    <feColorMatrix in="SourceAlpha" type="matrix"
                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                    <feOffset dy="4" />
                    <feGaussianBlur stdDeviation="2" />
                    <feComposite in2="hardAlpha" operator="out" />
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0" />
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2414_189" />
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2414_189" result="shape" />
                </filter>
            </defs>
        </svg>
    </div>

    <div class="auth-wrapper">
        <a href="{{ route('home') }}" class="back-to" title="{{ trans('user::auth.back_to_home') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M6.37992 3.95337L2.33325 8.00004L6.37992 12.0467" stroke="#0E1E3E" stroke-width="1.5"
                    stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M13.6668 8H2.44678" stroke="#0E1E3E" stroke-width="1.5" stroke-miterlimit="10"
                    stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>

        <div class="auth-left">
        </div>

        <div class="auth-right">
            <div class="bg-grid-shape"></div>

            <div class="bg-shape-layer"></div>

            <div class="bg-yellow-shape">
                <svg xmlns="http://www.w3.org/2000/svg" width="120" height="125" viewBox="0 0 120 125" fill="none">
                    <path
                        d="M125.143 158.853C47.8652 155.266 13.5195 136.007 6.00644 126.826C-20.7831 33.0517 48.5091 3.20269 86.504 0C-0.433365 64.0537 221.74 163.337 125.143 158.853Z"
                        fill="#FFAD00" />
                </svg>
            </div>

            <div class="bg-green-shape">
                <svg xmlns="http://www.w3.org/2000/svg" width="148" height="71" viewBox="0 0 148 71" fill="none">
                    <g filter="url(#filter0_d_2414_189)">
                        <path
                            d="M4.74654 103C0.139535 55.1211 14.6977 -30.3244 109.786 10.9251C204.875 52.1747 79.3801 89.4957 4.74654 103Z"
                            fill="#00BC65" />
                    </g>
                    <defs>
                        <filter id="filter0_d_2414_189" x="0" y="0" width="148" height="111"
                            filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix" />
                            <feColorMatrix in="SourceAlpha" type="matrix"
                                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                            <feOffset dy="4" />
                            <feGaussianBlur stdDeviation="2" />
                            <feComposite in2="hardAlpha" operator="out" />
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0" />
                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2414_189" />
                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2414_189" result="shape" />
                        </filter>
                    </defs>
                </svg>
            </div>

            <div class="auth-form">
                <div class="auth-form-header"> 
                    <a href="{{ route('home') }}" class="back-to" title="{{ trans('user::auth.back_to_home') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M6.37992 3.95337L2.33325 8.00004L6.37992 12.0467" stroke="#0E1E3E" stroke-width="1.5"
                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M13.6668 8H2.44678" stroke="#0E1E3E" stroke-width="1.5" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>

                    <div class="auth-form-header-content">
                        <h2>Activation</h2>

                        <p>Activate and amplify your FleetCart experience!</p>
                    </div>
                </div>

                @include('user::admin.partials.notification')

                <form class="auth-form-body" method="POST" action="{{ route('license.store') }}">
                    @csrf

                    <div>
                        <div class="form-group">
                            <label 
                                for="email"
                                class="input-label" 
                            >
                                Purchase Code <span>*</span>
                            </label>

                            <div 
                                x-data
                                class="input-group" 
                            >
                                <input 
                                    type="text"
                                    name="purchase_code"
                                    class="form-control"
                                    placeholder="Enter your purchase code" 
                                    autofocus
                                >

                                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M19.79 14.93C17.73 16.98 14.78 17.61 12.19 16.8L7.48002 21.5C7.14002 21.85 6.47002 22.06 5.99002 21.99L3.81002 21.69C3.09002 21.59 2.42002 20.91 2.31002 20.19L2.01002 18.01C1.94002 17.53 2.17002 16.86 2.50002 16.52L7.20002 11.82C6.40002 9.22001 7.02002 6.27001 9.08002 4.22001C12.03 1.27001 16.82 1.27001 19.78 4.22001C22.74 7.17001 22.74 11.98 19.79 14.93Z" stroke="#A0AEC0" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6.89001 17.49L9.19001 19.79" stroke="#A0AEC0" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M14.5 11C15.3284 11 16 10.3284 16 9.5C16 8.67157 15.3284 8 14.5 8C13.6716 8 13 8.67157 13 9.5C13 10.3284 13.6716 11 14.5 11Z" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>

                            {!! $errors->first('purchase_code', '<span class="help-block text-red">:message</span>') !!}
                        </div>
                    </div>

                    <button 
                        type="submit"
                        x-data="{ formSubmitting: false }"
                        :class="formSubmitting ? 'btn-loading' : ''" 
                        class="btn btn-primary"
                        :disabled="formSubmitting"
                        @click="formSubmitting = true; $el.parentElement.submit()"
                    >
                        Activate
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

