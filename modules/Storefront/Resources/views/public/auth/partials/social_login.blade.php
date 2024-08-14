
<div class="auth-form-footer">
    @if (count($providers) !== 0)
        <div class="auth-form-or">
            <span>{{ trans('user::auth.or') }}</span>
        </div>

        <div class="auth-form-social-links">
            @if (setting('google_login_enabled'))
                <a href="{{ route('login.redirect', ['provider' => 'google']) }}" class="sign-in-google">
                    <img src="{{ asset('build/assets/google.png') }}" alt="Google icon">
                    <span>{{ trans('user::auth.sign_in_with_google') }}</span>
                </a>
            @endif

            @if (setting('facebook_login_enabled'))
                <a href="{{ route('login.redirect', ['provider' => 'facebook']) }}" class="sign-in-facebook">
                    <img src="{{ asset('build/assets/facebook.png') }}" alt="Facebook icon">
                    <span>{{ trans('user::auth.sign_in_with_facebook') }}</span>
                </a>
            @endif
        </div>
    @endif

    <div class="do-not-have-account">
        @if (request()->routeIs('login'))
            <span>{{ trans('user::auth.do_not_have_an_account') }}</span> 

            <a href="{{ route('register') }}">{{ trans('user::auth.sign_up') }}</a>
        @else

            <span>{{ trans('user::auth.already_have_an_account') }}</span> 

            <a href="{{ route('login') }}">{{ trans('user::auth.sign_in') }}</a>
        @endif
    </div>
</div>

