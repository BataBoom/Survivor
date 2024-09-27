<?php

namespace App\Http\Services;

class BettingOdds
{

    public float $bettingAmount;
    public float $odds;
    public bool $sign;
    private const PLUS_SIGN = '+';

    /**
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * @return string
     */
    public function getOdds() : string
    {
        $sign = '';

        if ($this->odds > 0) {
            $sign = self::PLUS_SIGN;
        }

        return $sign . $this->odds;
    }

    /**
     * @return float
     */
    public function toDecimal()
    {
        $value = 1;

        if ($this->odds > 0) {
            $value = $this->odds / 100 + 1;
        } elseif ($this->odds < 0) {
            $value = -100 / $this->odds + 1;
        }

        $value = round($value, 2);

        return $value;
    }


    /**
     * @return array
     */
    public function toPayout(): array
    {
        $potenitalPayout = $this->bettingAmount * $this->toDecimal();
        $impliedPropability = 1 / $this->toDecimal() * 100;

        return [
            'total' => $potenitalPayout,
            'profit' => $potenitalPayout - $this->bettingAmount,
            'probability' => $impliedPropability
        ];
    }
}
