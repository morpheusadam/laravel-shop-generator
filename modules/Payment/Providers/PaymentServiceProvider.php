<?php

namespace Modules\Payment\Providers;

use Modules\Payment\Gateways\COD;
use Modules\Payment\Gateways\Paytm;
use Modules\Payment\Facades\Gateway;
use Modules\Payment\Gateways\PayPal;
use Modules\Payment\Gateways\Stripe;
use Modules\Payment\Gateways\PayFast;
use Illuminate\Support\Facades\Route;
use Modules\Payment\Gateways\Iyzico;
use Modules\Payment\Gateways\Paystack;
use Modules\Payment\Gateways\Razorpay;
use Modules\Payment\Gateways\Instamojo;
use Illuminate\Support\ServiceProvider;
use Modules\Payment\Gateways\Flutterwave;
use Modules\Payment\Gateways\MercadoPago;
use Modules\Payment\Gateways\AuthorizeNet;
use Modules\Payment\Gateways\BankTransfer;
use Modules\Payment\Gateways\CheckPayment;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!config('app.installed')) {
            return;
        }

        $this->registerPayPalExpress();
        $this->registerStripe();
        $this->registerPaytm();
        $this->registerRazorpay();
        $this->registerInstamojo();
        $this->registerAuthorizenet();
        $this->registerPaystack();
        $this->registerMercadoPago();
        $this->registerFlutterwave();
        $this->registerPayFast();
        $this->registerIyzico();
        $this->registerCashOnDelivery();
        $this->registerBankTransfer();
        $this->registerCheckPayment();
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }


    private function registerPayPalExpress()
    {
        if ($this->enabled('paypal')) {
            Gateway::register('paypal', new PayPal());
        }
    }


    private function enabled($paymentMethod)
    {
        if (app('inAdminPanel')) {
            return true;
        }

        return setting("{$paymentMethod}_enabled");
    }


    private function registerStripe()
    {
        if ($this->enabled('stripe')) {
            Gateway::register('stripe', new Stripe());
        }
    }


    private function registerPaytm()
    {
        if ($this->enabled('paytm')) {
            Gateway::register('paytm', new Paytm());
        }
    }


    private function registerRazorpay()
    {
        if ($this->enabled('razorpay')) {
            Gateway::register('razorpay', new Razorpay());
        }
    }


    private function registerInstamojo()
    {
        if ($this->enabled('instamojo')) {
            Gateway::register('instamojo', new Instamojo());
        }
    }


    private function registerAuthorizenet()
    {
        if ($this->enabled('authorizenet')) {
            Gateway::register('authorizenet', new AuthorizeNet());
        }
    }


    private function registerPaystack()
    {
        if ($this->enabled('paystack')) {
            Gateway::register('paystack', new Paystack());
        }
    }


    private function registerMercadoPago()
    {
        if ($this->enabled('mercadopago')) {
            Gateway::register('mercadopago', new MercadoPago());
        }
    }


    private function registerFlutterwave()
    {
        if ($this->enabled('flutterwave')) {
            Gateway::register('flutterwave', new Flutterwave());
        }
    }


    private function registerIyzico()
    {
        if ($this->enabled('iyzico')) {
            Gateway::register('iyzico', new Iyzico());
        }
    }


    private function registerPayFast()
    {
        if ($this->enabled('payfast')) {
            Gateway::register('payfast', new PayFast());
        }
    }


    private function registerCashOnDelivery()
    {
        if ($this->enabled('cod')) {
            Gateway::register('cod', new COD());
        }
    }


    private function registerBankTransfer()
    {
        if ($this->enabled('bank_transfer')) {
            Gateway::register('bank_transfer', new BankTransfer());
        }
    }


    private function registerCheckPayment()
    {
        if ($this->enabled('check_payment')) {
            Gateway::register('check_payment', new CheckPayment());
        }
    }
}
