<div class="social-share">
    <label>{{ trans('storefront::product.share') }}</label>

    <ul class="list-inline social-links d-flex">
        <li>
            <a :href="`https://www.facebook.com/sharer/sharer.php?u=${productUrl}`"
                title="{{ trans('storefront::product.facebook') }}" target="_blank">
                <i class="lab la-facebook"></i>
            </a>
        </li>

        <li>
            <a :href="`https://twitter.com/share?url=${productUrl}&text={{ $product->name }}`"
                title="{{ trans('storefront::product.twitter') }}" target="_blank">
                <svg class="twitter-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" width="30px"
                    height="30px">
                    <path
                        d="M26.37,26l-8.795-12.822l0.015,0.012L25.52,4h-2.65l-6.46,7.48L11.28,4H4.33l8.211,11.971L12.54,15.97L3.88,26h2.65 l7.182-8.322L19.42,26H26.37z M10.23,6l12.34,18h-2.1L8.12,6H10.23z" />
                </svg>
            </a>
        </li>

        <li>
            <a :href="`https://www.linkedin.com/shareArticle?mini=true&url=${productUrl}`"
                title="{{ trans('storefront::product.linkedin') }}" target="_blank">
                <i class="lab la-linkedin"></i>
            </a>
        </li>

        <li>
            <a :href="`https://www.tumblr.com/share?v=3&u=${productUrl}`"
                title="{{ trans('storefront::product.tumblr') }}" target="_blank">
                <i class="lab la-tumblr"></i>
            </a>
        </li>
    </ul>
</div>
