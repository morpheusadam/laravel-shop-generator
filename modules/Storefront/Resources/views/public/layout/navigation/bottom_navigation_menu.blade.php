<section class="bottom-navigation-wrap d-lg-none">
    <div class="container">
        <ul class="bottom-navigation-items">
            <li>
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    @if (request()->routeIs('home'))
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M20.83 8.01002L14.28 2.77002C13 1.75002 11 1.74002 9.72999 2.76002L3.17999 8.01002C2.23999 8.76002 1.66999 10.26 1.86999 11.44L3.12999 18.98C3.41999 20.67 4.98999 22 6.69999 22H17.3C18.99 22 20.59 20.64 20.88 18.97L22.14 11.43C22.32 10.26 21.75 8.76002 20.83 8.01002ZM12.75 18C12.75 18.41 12.41 18.75 12 18.75C11.59 18.75 11.25 18.41 11.25 18V15C11.25 14.59 11.59 14.25 12 14.25C12.41 14.25 12.75 14.59 12.75 15V18Z" fill="#292D32"/>
                        </svg>
                    @else
                        <svg class="svg-stroke-color" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M12 18V15" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.07 2.81997L3.13999 8.36997C2.35999 8.98997 1.85999 10.3 2.02999 11.28L3.35999 19.24C3.59999 20.66 4.95999 21.81 6.39999 21.81H17.6C19.03 21.81 20.4 20.65 20.64 19.24L21.97 11.28C22.13 10.3 21.63 8.98997 20.86 8.36997L13.93 2.82997C12.86 1.96997 11.13 1.96997 10.07 2.81997Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    @endif

                    <span>{{ trans('storefront::layout.home') }}</span>
                </a>
            </li>

            <li>
                <a href="{{ route('compare.index') }}" class="{{ request()->routeIs('compare.index') ? 'active' : '' }}">
                    @if (request()->routeIs('compare.index'))
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M17.4201 4.40994H5.39008L7.27008 2.52994C7.56008 2.23994 7.56008 1.75994 7.27008 1.46994C6.98008 1.17994 6.50008 1.17994 6.21008 1.46994L3.05008 4.62994C2.98008 4.69994 2.93008 4.77994 2.89008 4.86994C2.85008 4.95994 2.83008 5.05994 2.83008 5.15994C2.83008 5.25994 2.85008 5.35994 2.89008 5.44994C2.93008 5.53994 2.98008 5.61994 3.05008 5.68994L6.21008 8.84994C6.36008 8.99994 6.55008 9.06994 6.74008 9.06994C6.93008 9.06994 7.12008 8.99994 7.27008 8.84994C7.56008 8.55994 7.56008 8.07994 7.27008 7.78994L5.39008 5.90994H17.4201C18.6601 5.90994 19.6701 6.91994 19.6701 8.15994V11.4799C19.6701 11.8899 20.0101 12.2299 20.4201 12.2299C20.8301 12.2299 21.1701 11.8899 21.1701 11.4799V8.15994C21.1701 6.08994 19.4901 4.40994 17.4201 4.40994Z" fill="#292D32"/>
                            <path d="M21.1701 18.84C21.1701 18.74 21.1501 18.64 21.1101 18.55C21.0701 18.46 21.0201 18.38 20.9501 18.31L17.7901 15.15C17.5001 14.86 17.0201 14.86 16.7301 15.15C16.4401 15.44 16.4401 15.92 16.7301 16.21L18.6101 18.09H6.58008C5.34008 18.09 4.33008 17.08 4.33008 15.84V12.52C4.33008 12.11 3.99008 11.77 3.58008 11.77C3.17008 11.77 2.83008 12.11 2.83008 12.52V15.84C2.83008 17.91 4.51008 19.59 6.58008 19.59H18.6101L16.7301 21.47C16.4401 21.76 16.4401 22.24 16.7301 22.53C16.8801 22.68 17.0701 22.75 17.2601 22.75C17.4501 22.75 17.6401 22.68 17.7901 22.53L20.9501 19.37C21.0201 19.3 21.0701 19.22 21.1101 19.13C21.1501 19.04 21.1701 18.94 21.1701 18.84Z" fill="#292D32"/>
                        </svg>
                    @else
                        <svg class="svg-stroke-color" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M3.58008 5.15991H17.4201C19.0801 5.15991 20.4201 6.49991 20.4201 8.15991V11.4799" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6.74008 2L3.58008 5.15997L6.74008 8.32001" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M20.4201 18.84H6.58008C4.92008 18.84 3.58008 17.5 3.58008 15.84V12.52" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M17.26 21.9999L20.42 18.84L17.26 15.6799" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    @endif

                    <span>{{ trans('storefront::layout.compare') }}</span>

                    <span class="count" v-text="compareCount">{{ count($compareList) }}</span>
                </a>
            </li>

            <li>
                <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.index') ? 'active' : '' }}">
                    @if (request()->routeIs('categories.index'))
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M18.6699 2H16.7699C14.5899 2 13.4399 3.15 13.4399 5.33V7.23C13.4399 9.41 14.5899 10.56 16.7699 10.56H18.6699C20.8499 10.56 21.9999 9.41 21.9999 7.23V5.33C21.9999 3.15 20.8499 2 18.6699 2Z" fill="#292D32"/>
                            <path d="M7.24 13.43H5.34C3.15 13.43 2 14.58 2 16.76V18.66C2 20.85 3.15 22 5.33 22H7.23C9.41 22 10.56 20.85 10.56 18.67V16.77C10.57 14.58 9.42 13.43 7.24 13.43Z" fill="#292D32"/>
                            <path d="M6.29 10.58C8.6593 10.58 10.58 8.6593 10.58 6.29C10.58 3.9207 8.6593 2 6.29 2C3.9207 2 2 3.9207 2 6.29C2 8.6593 3.9207 10.58 6.29 10.58Z" fill="#292D32"/>
                            <path d="M17.71 22C20.0793 22 22 20.0793 22 17.71C22 15.3407 20.0793 13.42 17.71 13.42C15.3407 13.42 13.42 15.3407 13.42 17.71C13.42 20.0793 15.3407 22 17.71 22Z" fill="#292D32"/>
                        </svg>
                    @else
                        <svg class="svg-stroke-color" xmlns="http://www.w3.org/2000/svg" width="29" height="28" viewBox="0 0 29 28" fill="none">
                            <path d="M20.3333 11.6667H22.6667C25 11.6667 26.1667 10.5 26.1667 8.16668V5.83334C26.1667 3.50001 25 2.33334 22.6667 2.33334H20.3333C18 2.33334 16.8333 3.50001 16.8333 5.83334V8.16668C16.8333 10.5 18 11.6667 20.3333 11.6667Z" stroke="#626F84" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6.33334 25.6667H8.66668C11 25.6667 12.1667 24.5 12.1667 22.1667V19.8333C12.1667 17.5 11 16.3333 8.66668 16.3333H6.33334C4.00001 16.3333 2.83334 17.5 2.83334 19.8333V22.1667C2.83334 24.5 4.00001 25.6667 6.33334 25.6667Z" stroke="#626F84" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M7.50001 11.6667C10.0773 11.6667 12.1667 9.57734 12.1667 7.00001C12.1667 4.42268 10.0773 2.33334 7.50001 2.33334C4.92268 2.33334 2.83334 4.42268 2.83334 7.00001C2.83334 9.57734 4.92268 11.6667 7.50001 11.6667Z" stroke="#626F84" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M21.5 25.6667C24.0773 25.6667 26.1667 23.5773 26.1667 21C26.1667 18.4227 24.0773 16.3333 21.5 16.3333C18.9227 16.3333 16.8333 18.4227 16.8333 21C16.8333 23.5773 18.9227 25.6667 21.5 25.6667Z" stroke="#626F84" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    @endif

                    <span>{{ trans('storefront::layout.categories') }}</span>
                </a>
            </li>

            <li>
                <a href="{{ route('cart.index') }}" class="bottom-navigation-cart {{ request()->routeIs('cart.index') ? 'active' : '' }}">
                    @if (request()->routeIs('cart.index'))
                        <svg class="cart-fill-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20" fill="none">
                            <path d="M16.96 6.96002C16.29 6.22002 15.28 5.79002 13.88 5.64002V4.88002C13.88 3.51002 13.3 2.19002 12.28 1.27002C11.25 0.330022 9.90999 -0.109978 8.51999 0.0200224C6.12999 0.250022 4.11999 2.56002 4.11999 5.06002V5.64002C2.71999 5.79002 1.70999 6.22002 1.03999 6.96002C0.0699899 8.04002 0.09999 9.48002 0.20999 10.48L0.90999 16.05C1.11999 18 1.90999 20 6.20999 20H11.79C16.09 20 16.88 18 17.09 16.06L17.79 10.47C17.9 9.48002 17.92 8.04002 16.96 6.96002ZM8.65999 1.41002C9.65999 1.32002 10.61 1.63002 11.35 2.30002C12.08 2.96002 12.49 3.90002 12.49 4.88002V5.58002H5.50999V5.06002C5.50999 3.28002 6.97999 1.57002 8.65999 1.41002ZM5.41999 11.15H5.40999C4.85999 11.15 4.40999 10.7 4.40999 10.15C4.40999 9.60002 4.85999 9.15002 5.40999 9.15002C5.96999 9.15002 6.41999 9.60002 6.41999 10.15C6.41999 10.7 5.96999 11.15 5.41999 11.15ZM12.42 11.15H12.41C11.86 11.15 11.41 10.7 11.41 10.15C11.41 9.60002 11.86 9.15002 12.41 9.15002C12.97 9.15002 13.42 9.60002 13.42 10.15C13.42 10.7 12.97 11.15 12.42 11.15Z" fill="#292D32"/>
                            <path class="cart-fill-color" d="M4.4955 10H15.5045" stroke="#0068e1" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path class="cart-fill-color" d="M8.49451 12H8.50349" stroke="#0068e1" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    @else
                        <svg class="svg-stroke-color" xmlns="http://www.w3.org/2000/svg" width="29" height="28" viewBox="0 0 29 28" fill="none">
                            <path d="M9.25 8.94834V7.81668C9.25 5.19168 11.3617 2.61334 13.9867 2.36834C17.1133 2.06501 19.75 4.52668 19.75 7.59501V9.20501" stroke="#626F84" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M11 25.6667H18C22.69 25.6667 23.53 23.7883 23.775 21.5017L24.65 14.5017C24.965 11.655 24.1483 9.33334 19.1667 9.33334H9.83334C4.85168 9.33334 4.03501 11.655 4.35001 14.5017L5.22501 21.5017C5.47001 23.7883 6.31001 25.6667 11 25.6667Z" stroke="#626F84" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    @endif

                    <span>{{ trans('storefront::layout.cart') }}</span>

                    <span class="count" v-text="cart.quantity">{{ $cart->toArray()['quantity'] }}</span>
                </a>
            </li>

            <li>
                <a href="{{ route('login') }}" class="{{ request()->routeIs('login') || request()->routeIs('account.*') ? 'active' : '' }}">
                    @if (request()->routeIs('login') || request()->routeIs('account.*'))
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" fill="#292D32"/>
                            <path d="M11.9999 14.5C6.98991 14.5 2.90991 17.86 2.90991 22C2.90991 22.28 3.12991 22.5 3.40991 22.5H20.5899C20.8699 22.5 21.0899 22.28 21.0899 22C21.0899 17.86 17.0099 14.5 11.9999 14.5Z" fill="#292D32"/>
                        </svg>
                    @else
                        <svg class="svg-stroke-color" xmlns="http://www.w3.org/2000/svg" width="29" height="28" viewBox="0 0 29 28" fill="none">
                            <path d="M14.5 14C17.7217 14 20.3334 11.3883 20.3334 8.16668C20.3334 4.94502 17.7217 2.33334 14.5 2.33334C11.2784 2.33334 8.66669 4.94502 8.66669 8.16668C8.66669 11.3883 11.2784 14 14.5 14Z" stroke="#626F84" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M24.5217 25.6667C24.5217 21.1517 20.03 17.5 14.5 17.5C8.97 17.5 4.47833 21.1517 4.47833 25.6667" stroke="#626F84" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    @endif

                    <span>{{ trans('storefront::layout.account') }}</span>
                </a>
            </li>
        </ul>
    </div>
</section>