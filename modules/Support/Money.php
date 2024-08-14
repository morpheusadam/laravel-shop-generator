<?php

namespace Modules\Support;

use NumberFormatter;
use JsonSerializable;
use InvalidArgumentException;
use Modules\Currency\Currency;
use Modules\Currency\Entities\CurrencyRate;

class Money implements JsonSerializable
{
    private $amount;
    private $currency;


    public function __construct($amount, $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }


    public static function inDefaultCurrency($amount)
    {
        return new self($amount, setting('default_currency'));
    }


    public static function inCurrentCurrency($amount)
    {
        return new self($amount, currency());
    }


    public function amount()
    {
        return $this->amount;
    }


    public function currency()
    {
        return $this->currency;
    }


    public function isZero()
    {
        return $this->amount == 0;
    }


    public function add($addend)
    {
        $addend = $this->convertToSameCurrency($addend);

        return $this->newInstance($this->amount + $addend->amount);
    }


    public function isNotSameCurrency($other)
    {
        return !$this->isSameCurrency($other);
    }


    public function isSameCurrency($other)
    {
        return $this->currency === $other->currency;
    }


    public function convertToDefaultCurrency()
    {
        $currencyRate = CurrencyRate::for($this->currency);

        if (is_null($currencyRate)) {
            throw new InvalidArgumentException('Cannot convert the money to the default currency.');
        }

        return new self($this->amount / $currencyRate, setting('default_currency'));
    }


    public function subtract($subtrahend)
    {
        $subtrahend = $this->convertToSameCurrency($subtrahend);

        return $this->newInstance($this->amount - $subtrahend->amount);
    }


    public function multiply($multiplier)
    {
        return $this->newInstance($this->amount * $multiplier);
    }


    public function divide($divisor)
    {
        return $this->newInstance($this->amount / $divisor);
    }


    public function lessThan($other)
    {
        return $this->amount < $other->amount;
    }


    public function lessThanOrEqual($other)
    {
        return $this->amount <= $other->amount;
    }


    public function greaterThan($other)
    {
        return $this->amount > $other->amount;
    }


    public function greaterThanOrEqual($other)
    {
        return $this->amount >= $other->amount;
    }


    public function round($precision = null, $mode = null)
    {
        if (is_null($precision)) {
            $precision = Currency::subunit($this->currency);
        }

        $amount = round($this->amount, $precision, $mode);

        return $this->newInstance($amount);
    }


    public function subunit()
    {
        $fraction = 10 ** Currency::subunit($this->currency);

        return (int)round($this->amount * $fraction);
    }


    public function ceil()
    {
        return $this->newInstance(ceil($this->amount));
    }


    public function floor()
    {
        return $this->newInstance(floor($this->amount));
    }


    public function jsonSerialize(): mixed
    {
        return array_merge($this->toArray(), [
            'inCurrentCurrency' => $this->convertToCurrentCurrency()->toArray(),
        ]);
    }


    public function toArray()
    {
        return [
            'amount' => $this->amount,
            'formatted' => $this->format(),
            'currency' => $this->currency,
        ];
    }


    public function format($currency = null, $locale = null)
    {
        $currency = $currency ?: currency();
        $locale = $locale ?: locale();

        $numberFormatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);

        $amount = $numberFormatter->formatCurrency($this->amount, $currency);

        /**
         * Fix: Hungarian Forint outputs wrong currency format
         */
        if (currency() === 'HUF') {
            $amount = str_replace(',00', '', $amount);
        }

        return $amount;
    }


    public function KMBTFormat($currency = null, $locale = null, $precision = 2)
    {
        $kmbt = null;
        $currency = $currency ?: currency();
        $locale = $locale ?: locale();

        if ($this->amount < 1000) {
            $amount = number_format($this->amount);
            $kmbt = '';
        } else if ($this->amount < 1000_000) {
            $amount = number_format($this->amount / 1000, $precision);
            $kmbt = 'K';
        } else if ($this->amount < 1000_000_000) {
            $amount = number_format($this->amount / 1000000, $precision);
            $kmbt = 'M';
        } else if ($this->amount < 1000_000_000_00) {
            $amount = number_format($this->amount / 1000_000_000, $precision);
            $kmbt = 'B';
        } else {
            $amount = number_format($this->amount / 1000_000_000_00, $precision);
            $kmbt = 'T';
        }

        //$numberFormatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
        //$amount = $numberFormatter->formatCurrency($amount, $currency);

        return $amount.$kmbt;
    }


    public function convertToCurrentCurrency($currencyRate = null)
    {
        return $this->convert(currency(), $currencyRate);
    }


    public function convert($currency, $currencyRate = null)
    {
        $currencyRate = $currencyRate ?: CurrencyRate::for($currency);

        if (is_null($currencyRate)) {
            throw new InvalidArgumentException("Cannot convert the money to currency [$currency].");
        }

        return new self($this->amount * $currencyRate, $currency);
    }


    public function __toString()
    {
        return (string)$this->amount;
    }


    private function convertToSameCurrency($other)
    {
        if ($this->isNotSameCurrency($other)) {
            $other = $other->convertToDefaultCurrency();
        }

        $this->assertSameCurrency($other);

        return $other;
    }


    private function assertSameCurrency($other)
    {
        if ($this->isNotSameCurrency($other)) {
            throw new InvalidArgumentException('Mismatch money currency.');
        }
    }


    private function newInstance($amount)
    {
        return new self($amount, $this->currency);
    }
}
