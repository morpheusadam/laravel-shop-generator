<aside class="localization">
    <div class="localization-header">
        <h3>{{ trans('storefront::layout.language_and_currency') }}</h3>

        <div class="localization-cross-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M4.00073 11.9996L12 4.00037" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 11.9996L4.00073 4.00037" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </div>

    <div class="localization-form">
        <div class="form-group">
            <label for="language">{{ trans('storefront::layout.language') }}</label> 
            
            <div class="input-group">
                <select name="language" id="language" class="form-control" onchange="location = this.value">
                    @foreach (supported_locales() as $locale => $language)
                        <option value="{{ localized_url($locale) }}" {{ locale() === $locale ? 'selected' : '' }}>
                            {{ $language['name'] }}
                        </option>
                    @endforeach
                </select>

                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M8.17454 10.2597C8.14888 10.1312 7.26507 5.71216 7.23704 5.57213C7.19326 5.35303 7.00085 5.19531 6.77741 5.19531H5.83991C5.61648 5.19531 5.42407 5.35303 5.38029 5.57213C5.35182 5.71453 4.4671 10.1381 4.44279 10.2596C4.39201 10.5135 4.55666 10.7604 4.81051 10.8112C5.06435 10.862 5.31132 10.6973 5.36207 10.4435L5.6617 8.94531H6.95563L7.25526 10.4435C7.30604 10.6975 7.5531 10.862 7.80682 10.8112C8.06066 10.7604 8.22532 10.5135 8.17454 10.2597ZM5.8492 8.00781L6.2242 6.13281H6.39313L6.76813 8.00781H5.8492Z" fill="#A0AEC0"/>
                    <path d="M15.6836 8.94531H14.2773V8.47656C14.2773 8.21769 14.0675 8.00781 13.8086 8.00781C13.5497 8.00781 13.3398 8.21769 13.3398 8.47656V8.94531H11.9336C11.6747 8.94531 11.4648 9.15519 11.4648 9.41406C11.4648 9.67294 11.6747 9.88281 11.9336 9.88281H12.047C12.3141 10.7457 12.7162 11.408 13.1587 11.9388C12.7986 12.2682 12.4342 12.5383 12.1095 12.798C11.9074 12.9598 11.8746 13.2547 12.0363 13.4569C12.1982 13.6591 12.4932 13.6917 12.6952 13.5301C13.0216 13.2689 13.4129 12.9787 13.8086 12.6156C14.2046 12.9789 14.5966 13.2697 14.922 13.5301C15.1242 13.6918 15.4192 13.659 15.5808 13.4569C15.7426 13.2547 15.7098 12.9597 15.5077 12.798C15.1839 12.5389 14.819 12.2685 14.4584 11.9388C14.9009 11.408 15.3031 10.7457 15.5702 9.88281H15.6836C15.9425 9.88281 16.1523 9.67294 16.1523 9.41406C16.1523 9.15519 15.9425 8.94531 15.6836 8.94531ZM13.8086 11.2498C13.5094 10.8742 13.2402 10.4259 13.0372 9.87969H14.5799C14.377 10.4259 14.1078 10.8742 13.8086 11.2498Z" fill="#A0AEC0"/>
                    <path d="M16.5938 4.84375H9.83122L9.63028 3.23181C9.5425 2.52956 8.94263 2 8.23491 2H3.40625C2.63084 2 2 2.63084 2 3.40625V13.75C2 14.5254 2.63084 15.1562 3.40625 15.1562H7.35884L7.55722 16.7682C7.64484 17.469 8.24472 18 8.95262 18H16.5938C17.3692 18 18 17.3692 18 16.5938V6.25C18 5.47459 17.3692 4.84375 16.5938 4.84375ZM3.40625 14.2188C3.14778 14.2188 2.9375 14.0085 2.9375 13.75V3.40625C2.9375 3.14778 3.14778 2.9375 3.40625 2.9375H8.23491C8.47081 2.9375 8.67078 3.114 8.7 3.34794C8.76794 3.89281 9.98775 13.6783 10.0551 14.2188H3.40625ZM8.46012 16.4297L8.30341 15.1562H9.56103L8.46012 16.4297ZM17.0625 16.5938C17.0625 16.8522 16.8522 17.0625 16.5938 17.0625H9.15231L10.9368 14.9983C11.0282 14.8953 11.0691 14.7585 11.0502 14.6226L9.94809 5.78125H16.5938C16.8522 5.78125 17.0625 5.99153 17.0625 6.25V16.5938Z" fill="#A0AEC0"/>
                </svg>
            </div>    
        </div>
        
        <div class="form-group">
            <label for="currency">{{ trans('storefront::layout.currency') }}</label> 

            <div class="input-group">
                <select name="currency" id="currency" class="form-control" onchange="location = this.value">
                    @foreach (setting('supported_currencies') as $currency)
                        <option
                            value="{{ route('current_currency.store', ['code' => $currency]) }}"
                            {{ currency() === $currency ? 'selected' : '' }}
                        >
                            {{ $currency }}
                        </option>
                    @endforeach
                </select>
    
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M7.22656 11.9415C7.22656 13.0165 8.05156 13.8832 9.07656 13.8832H11.1682C12.0599 13.8832 12.7849 13.1249 12.7849 12.1915C12.7849 11.1749 12.3432 10.8165 11.6849 10.5832L8.32656 9.41654C7.66823 9.18321 7.22656 8.82487 7.22656 7.80821C7.22656 6.87487 7.95156 6.11654 8.84323 6.11654H10.9349C11.9599 6.11654 12.7849 6.98321 12.7849 8.05821" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10 5V15" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10.0001 18.3333C14.6025 18.3333 18.3334 14.6024 18.3334 10C18.3334 5.39762 14.6025 1.66666 10.0001 1.66666C5.39771 1.66666 1.66675 5.39762 1.66675 10C1.66675 14.6024 5.39771 18.3333 10.0001 18.3333Z" stroke="#A0AEC0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
    </div>
</aside>