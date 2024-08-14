<?php

namespace Modules\Currency\Services;

use Swap\Swap;
use Exchanger\Exception\Exception;

class CurrencyRateExchanger
{
    /**
     * Instance of swap.
     *
     * @var Swap
     */
    private $swap;


    /**
     * Create a new CurrencyRateExchanger instance.
     *
     * @param Swap $swap
     */
    public function __construct(Swap $swap)
    {
        $this->swap = $swap;
    }


    /**
     * Exchange to the latest currency rate.
     *
     * @param string $fromCurrency
     * @param string $toCurrency
     *
     * @return float|null
     */
    public function exchange($fromCurrency, $toCurrency)
    {
        try {
            return $this->swap->latest("{$fromCurrency}/{$toCurrency}")->getValue();
        } catch (Exception) {
            return 1;
        }
    }
}
