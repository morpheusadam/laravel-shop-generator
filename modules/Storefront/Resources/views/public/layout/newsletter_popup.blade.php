@if (setting('newsletter_enabled') && json_decode(Cookie::get('show_newsletter_popup', true)))
    <newsletter-popup inline-template>
        <div class="modal newsletter-wrap fade" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="newsletter-inner">
                            
                            <div class="newsletter-right" style="background-image: url({{ $newsletterBgImage }})"></div>

                            <div class="newsletter-left">
                                <h1 class="title">
                                    {{ trans('storefront::layout.subscribe_to_our_newsletter') }}
                                </h1>

                                <p class="sub-title">
                                    {{ trans('storefront::layout.subscribe_to_our_newsletter_subtitle') }}
                                </p>

                                <form @submit.prevent="subscribe" class="newsletter-form">
                                    <div class="form-group">
                                        <input
                                            type="text"
                                            v-model="email"
                                            class="form-control"
                                            placeholder="{{ trans('storefront::layout.enter_your_email_address') }}"
                                            @input="subscribed = false"
                                        >

                                        <span class="error-message" v-if="error" v-text="error"></span>
                                    </div>

                                    <div class="d-flex flex-column">
                                        <button class="btn btn-primary btn-subscribe" v-if="subscribed">
                                            <i class="las la-check"></i>
                                            {{ trans('storefront::layout.subscribed') }}
                                        </button>

                                        <button
                                            class="btn btn-primary btn-subscribe"
                                            :class="{ 'btn-loading': subscribing }"
                                            v-else
                                        >
                                            {{ trans('storefront::layout.subscribe') }}
                                        </button>
                                        
                                        <button class="btn btn-link btn-no-thanks" @click="disableNewsletterPopup">
                                            {{ trans('storefront::layout.no_thanks') }}
                                        </button>
                                    </div>
                                </form>

                                <p class="info-text">
                                    {{ trans('storefront::layout.by_subscribing') }} <a href="{{ $privacyPageUrl }}">{{ trans('storefront::layout.privacy_policy') }}</a>
                                </p>
                            </div>

                            <button type="button" class="close" @click="closeNewsletterPopup">
                                <i class="las la-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </newsletter-popup>
@endif
