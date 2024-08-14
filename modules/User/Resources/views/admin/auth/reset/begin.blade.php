@extends('user::admin.auth.layout')

@section('title', trans('user::auth.reset_password'))

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
        <a href="{{ route('admin.login') }}" class="back-to" title="{{ trans('user::auth.back_to_login') }}">
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
                    <a href="{{ route('admin.login') }}" class="back-to" title="{{ trans('user::auth.back_to_login') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M6.37992 3.95337L2.33325 8.00004L6.37992 12.0467" stroke="#0E1E3E" stroke-width="1.5"
                                stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M13.6668 8H2.44678" stroke="#0E1E3E" stroke-width="1.5" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>

                    <div class="auth-form-header-content">
                        <div class="auth-form-header-top">
                            <a href="{{ route('home') }}" class="auth-form-header-logo">
                                @if (is_null($logo))
                                    <h3>{{ setting('store_name') }}</h3>
                                @else
                                    <img src="{{ $logo }}" alt="Logo">
                                @endif
                            </a>

                            @include('user::admin.partials.language_picker')
                        </div>

                        <h2>{{ trans('user::auth.reset_password') }}</h2>

                        <p>{{ trans('user::auth.enter_email') }}</p>
                    </div>
                </div>

                @include('user::admin.partials.notification')

                <form class="auth-form-body" method="POST" action="{{ route('admin.reset.post') }}">
                    {{ csrf_field() }}

                    <div>
                        <div class="auth-form-body-top">
                            <a href="{{ route('home') }}" class="auth-form-header-logo">
                                @if (is_null($logo))
                                    <h3>{{ setting('store_name') }}</h3>
                                @else
                                    <img src="{{ $logo }}" alt="Logo">
                                @endif
                            </a>
    
                            @include('user::admin.partials.language_picker')
                        </div>

                        <div class="form-group">
                            <label 
                                for="email"
                                class="input-label" 
                            >
                                {{ trans('user::auth.email') }} <span>*</span>
                            </label>

                            <div 
                                x-data
                                class="input-group" 
                            >
                                <input 
                                    type="text"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control"
                                    id="email"
                                    placeholder="{{ trans('user::auth.enter_your_email') }}" 
                                    autofocus
                                >

                                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 20 20" fill="none">
                                    <path
                                        d="M14.167 17.0832H5.83366C3.33366 17.0832 1.66699 15.8332 1.66699 12.9165V7.08317C1.66699 4.1665 3.33366 2.9165 5.83366 2.9165H14.167C16.667 2.9165 18.3337 4.1665 18.3337 7.08317V12.9165C18.3337 15.8332 16.667 17.0832 14.167 17.0832Z"
                                        stroke="#A0AEC0" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M14.1663 7.5L11.558 9.58333C10.6997 10.2667 9.29134 10.2667 8.433 9.58333L5.83301 7.5"
                                        stroke="#A0AEC0" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>

                            {!! $errors->first('email', '<span class="help-block text-red">:message</span>') !!}
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
                        {{ trans('user::auth.reset_password') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
