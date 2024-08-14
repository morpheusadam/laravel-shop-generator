<div class="steps-wrap">
    <div class="container">
        <ul class="list-inline step-tabs">
            <li class="step-tab {{ request()->routeIs('cart.index') ? 'active' : '' }}">
                @if (request()->routeIs('checkout.create'))
                    <a href="{{ route('cart.index') }}" class="step-tab-link">
                        <span class="step-tab-text">
                            {{ trans('storefront::cart.my_cart') }}
                            <span class="bg-text">{{ trans('storefront::cart.01') }}</span>
                        </span>
                    </a>
                @else
                    <span class="step-tab-text">
                        {{ trans('storefront::cart.my_cart') }}
                        <span class="bg-text">{{ trans('storefront::cart.01') }}</span>
                    </span>
                @endif
            </li>

            <li class="step-tab {{ request()->routeIs('checkout.create') ? 'active' : '' }}">
                @if (request()->routeIs('cart.index'))
                    <a href="{{ route('checkout.create') }}" class="step-tab-link">
                        <span class="step-tab-text">
                            {{ trans('storefront::cart.checkout') }}
                            <span class="bg-text">{{ trans('storefront::cart.02') }}</span>
                        </span>
                    </a>
                @else
                    <span class="step-tab-text">
                        {{ trans('storefront::cart.checkout') }}
                        <span class="bg-text">{{ trans('storefront::cart.02') }}</span>
                    </span>
                @endif
            </li>

            <li class="step-tab {{ request()->routeIs('checkout.complete.show') ? 'active' : '' }}">
                <span class="step-tab-text">
                    {{ trans('storefront::cart.order_complete') }}
                    <span class="bg-text">{{ trans('storefront::cart.03') }}</span>
                </span>
            </li>
        </ul>
    </div>
</div>
