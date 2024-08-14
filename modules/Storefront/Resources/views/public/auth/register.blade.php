@extends('storefront::public.auth.layout')

@section('title', trans('user::auth.register'))

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
        <a href="{{ route('login') }}" class="back-to" title="{{ trans('user::auth.back_to_login') }}">
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

            <div class="auth-form-overflow">
                <div class="auth-form">
                    <div class="auth-form-header">
                        <a href="{{ route('login') }}" class="back-to" title="{{ trans('user::auth.back_to_login') }}">
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

                                @include('storefront::public.auth.partials.language_picker')
                            </div>

                            <h2>{{ trans('user::auth.register') }}</h2>
    
                            <p>{{ trans('user::auth.enter_your_create_account_details') }}</p>
                        </div>
                    </div>
    
                    @include('storefront::public.auth.partials.notification')
    
                    <form class="auth-form-body" method="POST" action="{{ route('register.post') }}">
                        @csrf
                        @honeypot

                        <div class="auth-form-body-top">
                            <a href="{{ route('home') }}" class="auth-form-header-logo">
                                @if (is_null($logo))
                                    <h3>{{ setting('store_name') }}</h3>
                                @else
                                    <img src="{{ $logo }}" alt="Logo">
                                @endif
                            </a>

                            @include('storefront::public.auth.partials.language_picker')
                        </div>
    
                        <div>
                            <div class="form-group">
                                <label 
                                    for="first-name"
                                    class="input-label" 
                                >
                                    {{ trans('user::auth.first_name') }} <span>*</span>
                                </label>
    
                                <div 
                                    x-data
                                    class="input-group" 
                                >
                                    <input 
                                        name="first_name" 
                                        value="{{ old('first_name') }}" 
                                        id="first-name"
                                        type="text"
                                        class="form-control"
                                        placeholder="{{ trans('user::auth.first_name') }}"
                                        autofocus
                                    >
    
                                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="#292D32" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M20.5899 22C20.5899 18.13 16.7399 15 11.9999 15C7.25991 15 3.40991 18.13 3.40991 22" stroke="#292D32" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
    
                                {!! $errors->first('first_name', '<span class="help-block text-red">:message</span>') !!}
                            </div>
    
                            <div class="form-group">
                                <label 
                                    for="last-name"
                                    class="input-label" 
                                >
                                    {{ trans('user::auth.last_name') }} <span>*</span>
                                </label>
    
                                <div 
                                    x-data
                                    class="input-group" 
                                >
                                    <input 
                                        name="last_name" 
                                        value="{{ old('last_name') }}" 
                                        id="last-name"
                                        type="text"
                                        class="form-control"
                                        placeholder="{{ trans('user::auth.last_name') }}"
                                    >
    
                                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="#292D32" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M20.5899 22C20.5899 18.13 16.7399 15 11.9999 15C7.25991 15 3.40991 18.13 3.40991 22" stroke="#292D32" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
    
                                {!! $errors->first('last_name', '<span class="help-block text-red">:message</span>') !!}
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
    
                            <div class="form-group">
                                <label 
                                    for="phone"
                                    class="input-label" 
                                >
                                    {{ trans('user::auth.phone') }} <span>*</span>
                                </label>
    
                                <div 
                                    x-data
                                    class="input-group" 
                                >
                                    <input 
                                        type="text"
                                        name="phone" 
                                        value="{{ old('phone') }}" 
                                        id="phone"
                                        class="form-control"
                                        placeholder="{{ trans('user::auth.phone') }}"
                                    >
    
                                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M21.97 18.33C21.97 18.69 21.89 19.06 21.72 19.42C21.55 19.78 21.33 20.12 21.04 20.44C20.55 20.98 20.01 21.37 19.4 21.62C18.8 21.87 18.15 22 17.45 22C16.43 22 15.34 21.76 14.19 21.27C13.04 20.78 11.89 20.12 10.75 19.29C9.6 18.45 8.51 17.52 7.47 16.49C6.44 15.45 5.51 14.36 4.68 13.22C3.86 12.08 3.2 10.94 2.72 9.81C2.24 8.67 2 7.58 2 6.54C2 5.86 2.12 5.21 2.36 4.61C2.6 4 2.98 3.44 3.51 2.94C4.15 2.31 4.85 2 5.59 2C5.87 2 6.15 2.06 6.4 2.18C6.66 2.3 6.89 2.48 7.07 2.74L9.39 6.01C9.57 6.26 9.7 6.49 9.79 6.71C9.88 6.92 9.93 7.13 9.93 7.32C9.93 7.56 9.86 7.8 9.72 8.03C9.59 8.26 9.4 8.5 9.16 8.74L8.4 9.53C8.29 9.64 8.24 9.77 8.24 9.93C8.24 10.01 8.25 10.08 8.27 10.16C8.3 10.24 8.33 10.3 8.35 10.36C8.53 10.69 8.84 11.12 9.28 11.64C9.73 12.16 10.21 12.69 10.73 13.22C11.27 13.75 11.79 14.24 12.32 14.69C12.84 15.13 13.27 15.43 13.61 15.61C13.66 15.63 13.72 15.66 13.79 15.69C13.87 15.72 13.95 15.73 14.04 15.73C14.21 15.73 14.34 15.67 14.45 15.56L15.21 14.81C15.46 14.56 15.7 14.37 15.93 14.25C16.16 14.11 16.39 14.04 16.64 14.04C16.83 14.04 17.03 14.08 17.25 14.17C17.47 14.26 17.7 14.39 17.95 14.56L21.26 16.91C21.52 17.09 21.7 17.3 21.81 17.55C21.91 17.8 21.97 18.05 21.97 18.33Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10"/>
                                    </svg>
                                </div>
    
                                {!! $errors->first('phone', '<span class="help-block text-red">:message</span>') !!}
                            </div>
    
                            <div class="form-group">
                                <label 
                                    for="password"
                                    class="input-label" 
                                >
                                    {{ trans('user::auth.password') }} <span>*</span>
                                </label>
    
                                <div 
                                    x-data="{ showPassword: false }" 
                                    class="input-group"
                                >
                                    <div 
                                        class="password-toggle-icon" 
                                        :data-tooltip="showPassword ? '{{ trans('user::auth.hide_password') }}' : '{{ trans('user::auth.show_password') }}'"
                                        @click="showPassword = !showPassword"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M12.9833 9.99993C12.9833 11.6499 11.6499 12.9833 9.99993 12.9833C8.34993 12.9833 7.0166 11.6499 7.0166 9.99993C7.0166 8.34993 8.34993 7.0166 9.99993 7.0166C11.6499 7.0166 12.9833 8.34993 12.9833 9.99993Z"
                                                x-bind:stroke="showPassword ? '#0E1E3E' : '#A0AEC0'" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M9.99987 16.8918C12.9415 16.8918 15.6832 15.1584 17.5915 12.1584C18.3415 10.9834 18.3415 9.00843 17.5915 7.83343C15.6832 4.83343 12.9415 3.1001 9.99987 3.1001C7.0582 3.1001 4.31654 4.83343 2.4082 7.83343C1.6582 9.00843 1.6582 10.9834 2.4082 12.1584C4.31654 15.1584 7.0582 16.8918 9.99987 16.8918Z"
                                                x-bind:stroke="showPassword ? '#0E1E3E' : '#A0AEC0'" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        
                                        <div class="show-password" :class="showPassword ? 'animate-show' : ''"></div>
                                    </div>
    
                                    <input 
                                        :type="showPassword ? 'text' : 'password'"
                                        name="password"
                                        id="password" 
                                        placeholder="{{ trans('user::attributes.users.password') }}"
                                        class="form-control"
                                    >
    
                                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20" fill="none">
                                        <path
                                            d="M9.18301 16.25H6.24967C5.73301 16.25 5.27467 16.2333 4.86634 16.175C2.67467 15.9333 2.08301 14.9 2.08301 12.0833V7.91667C2.08301 5.1 2.67467 4.06667 4.86634 3.825C5.27467 3.76667 5.73301 3.75 6.24967 3.75H9.13301"
                                            stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M12.5166 3.75H13.7499C14.2666 3.75 14.7249 3.76667 15.1333 3.825C17.3249 4.06667 17.9166 5.1 17.9166 7.91667V12.0833C17.9166 14.9 17.3249 15.9333 15.1333 16.175C14.7249 16.2333 14.2666 16.25 13.7499 16.25H12.5166"
                                            stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M12.5 1.6665V18.3332" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M9.2451 10.0002H9.25258" stroke="#A0AEC0" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M5.91209 10.0002H5.91957" stroke="#A0AEC0" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
    
                                {!! $errors->first('password', '<span class="help-block text-red">:message</span>') !!}
                            </div>
    
                            <div class="form-group">
                                <label 
                                    for="password_confirmation"
                                    class="input-label" 
                                >
                                    {{ trans('user::auth.confirm_password') }} <span>*</span>
                                </label>
    
                                <div 
                                    x-data="{ showPassword: false }"
                                    class="input-group"
                                >
                                    <div 
                                        class="password-toggle-icon" 
                                        :data-tooltip="showPassword ? '{{ trans('user::auth.hide_password') }}' : '{{ trans('user::auth.show_password') }}'"
                                        @click="showPassword = !showPassword"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M12.9833 9.99993C12.9833 11.6499 11.6499 12.9833 9.99993 12.9833C8.34993 12.9833 7.0166 11.6499 7.0166 9.99993C7.0166 8.34993 8.34993 7.0166 9.99993 7.0166C11.6499 7.0166 12.9833 8.34993 12.9833 9.99993Z"
                                                x-bind:stroke="showPassword ? '#0E1E3E' : '#A0AEC0'" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M9.99987 16.8918C12.9415 16.8918 15.6832 15.1584 17.5915 12.1584C18.3415 10.9834 18.3415 9.00843 17.5915 7.83343C15.6832 4.83343 12.9415 3.1001 9.99987 3.1001C7.0582 3.1001 4.31654 4.83343 2.4082 7.83343C1.6582 9.00843 1.6582 10.9834 2.4082 12.1584C4.31654 15.1584 7.0582 16.8918 9.99987 16.8918Z"
                                                x-bind:stroke="showPassword ? '#0E1E3E' : '#A0AEC0'" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        
                                        <div class="show-password" :class="showPassword ? 'animate-show' : ''"></div>
                                    </div>
    
                                    <input 
                                        :type="showPassword ? 'text' : 'password'"
                                        name="password_confirmation" 
                                        id="password_confirmation"
                                        placeholder="{{ trans('user::auth.confirm_password') }}"
                                        class="form-control" 
                                    >
    
                                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20" fill="none">
                                        <path
                                            d="M9.18301 16.25H6.24967C5.73301 16.25 5.27467 16.2333 4.86634 16.175C2.67467 15.9333 2.08301 14.9 2.08301 12.0833V7.91667C2.08301 5.1 2.67467 4.06667 4.86634 3.825C5.27467 3.76667 5.73301 3.75 6.24967 3.75H9.13301"
                                            stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M12.5166 3.75H13.7499C14.2666 3.75 14.7249 3.76667 15.1333 3.825C17.3249 4.06667 17.9166 5.1 17.9166 7.91667V12.0833C17.9166 14.9 17.3249 15.9333 15.1333 16.175C14.7249 16.2333 14.2666 16.25 13.7499 16.25H12.5166"
                                            stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M12.5 1.6665V18.3332" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M9.2451 10.0002H9.25258" stroke="#A0AEC0" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M5.91209 10.0002H5.91957" stroke="#A0AEC0" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
    
                                {!! $errors->first('password_confirmation', '<span class="help-block text-red">:message</span>') !!}
                            </div>

                            @if (setting('google_recaptcha_enabled'))
                                <div class="form-group p-t-5 captcha-field">
                                    <div class="g-recaptcha" data-sitekey="{{ setting('google_recaptcha_site_key') }}"></div>

                                    @error('g-recaptcha-response')
                                        <span class="help-block text-red">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
    
                            <div class="checkbox-group add-privacy-policy">
                                <div class="checkbox">
                                    <input type="hidden" name="privacy_policy" value="0">
    
                                    <input 
                                        type="checkbox"
                                        name="privacy_policy"
                                        class="checkbox-element" 
                                        id="terms"
                                        value="1" 
                                        {{ old('privacy_policy', false) ? 'checked' : '' }}
                                    >
    
                                    <label class="checkbox-label" for="terms">
                                        <span>
                                            <svg width="12px" height="10px" viewbox="0 0 12 10">
                                                <polyline points="1.5 6 4.5 9 12.5 1"></polyline>
                                            </svg>
                                        </span>
    
                                        <span>{{ trans('user::auth.i_agree_to_the') }}</span>
                                    </label>
                                </div>
            
                                <a href="{{ $privacyPageUrl }}" class="forgot-password">
                                    {{ trans('user::auth.privacy_policy') }}
                                </a>

                                {!! $errors->first('privacy_policy', '<span class="help-block text-red">:message</span>') !!}
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
                            {{ trans('user::auth.create_account') }}
                        </button>
                    </form>
    
                    @include('storefront::public.auth.partials.social_login')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('globals')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush
