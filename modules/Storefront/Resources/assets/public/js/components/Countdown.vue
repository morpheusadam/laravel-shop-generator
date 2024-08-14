<template>
    <div class="daily-deals-countdown countdown clearfix">
        <span class="countdown-row">
            <span class="countdown-section">
                <span class="countdown-amount">{{ date.days }}</span>

                <span class="countdown-period">
                    {{ $trans("storefront::product_card.days") }}
                </span>
            </span>

            <span class="countdown-section">
                <span class="countdown-amount">{{ date.hours }}</span>

                <span class="countdown-period">
                    {{ $trans("storefront::product_card.hours") }}
                </span>
            </span>

            <span class="countdown-section">
                <span class="countdown-amount">{{ date.minutes }}</span>

                <span class="countdown-period">
                    {{ $trans("storefront::product_card.minutes") }}
                </span>
            </span>

            <span class="countdown-section">
                <span class="countdown-amount">{{ date.seconds }}</span>

                <span class="countdown-period">
                    {{ $trans("storefront::product_card.seconds") }}
                </span>
            </span>
        </span>
    </div>
</template>

<script>
import countdown from 'countdown';

export default {
    props: ["endDate"],

    data() {
        return {
            date: {},
            countdown: null,
        };
    },

    mounted() {
        if (new Date() > new Date(this.endDate)) {
            this.setInitialDate();

            return;
        }

        this.countdown = this.initCountdown();
    },

    methods: {
        initCountdown() {
            return countdown(
                new Date(this.endDate),
                ({ days, hours, minutes, seconds }) => {
                    if (new Date() > new Date(this.endDate)) {
                        this.setInitialDate();
                        window.clearInterval(this.countdown);

                        return;
                    }

                    this.date = Object.assign({}, this.date, {
                        days: this.leadingZero(days),
                        hours: this.leadingZero(hours),
                        minutes: this.leadingZero(minutes),
                        seconds: this.leadingZero(seconds),
                    });
                },
                countdown.DAYS |
                    countdown.HOURS |
                    countdown.MINUTES |
                    countdown.SECONDS
            );
        },

        setInitialDate() {
            this.date = Object.assign({}, this.date, {
                days: "00",
                hours: "00",
                minutes: "00",
                seconds: "00",
            });
        },

        leadingZero(value) {
            return value < 10 ? "0" + value : value;
        },
    },
};
</script>
