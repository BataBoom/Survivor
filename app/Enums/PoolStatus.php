<?php

namespace App\Enums;

use Exception;

class PoolStatus
{
    private const PENDING = 'fresh pool';
    private const UNFULFILLED = 'Pool marked as private until deposit is complete';
    private const TERMINATING = 'Pool hasnt met deposit stardards, deleting in 72 hours';
    private const TERMINDATED = 'Pool can be deleted';
    private const REGISTERING = 'pool is registering';
    private const PROGRESS = 'pool is in progress';
    private const COMPLETE = 'pool is finished';

    /**
     * @var PoolStatus[]
     */
    private static $values = null;
    /**
     * @var string
     */
    private $status;
    /**
     * @var string
     */
    private $displayValue;

    public function __construct(string $status, string $displayValue = null)
    {
        $this->status = $status;
        $this->displayValue = $displayValue;
    }

    /**
     * @param string $status
     * @return PoolStatus
     * @throws Exception
     */
    public static function fromStatus(string $status): PoolStatus
    {
        foreach (self::values() as $PoolStatus) {
            if ($PoolStatus->getStatus() === $status) {
                return $PoolStatus;
            }
        }
        throw new Exception('Unknown status: ' . $status);
    }

    /**
     * @param string $displayValue
     * @return PoolStatus
     * @throws Exception
     */
    public static function fromDisplayValue($displayValue)
    {
        foreach (self::values() as $PoolStatus) {
            if ($PoolStatus->getDisplayValue() === $displayValue) {
                return $PoolStatus;
            }
        }
        throw new Exception('Unknown status display value: ' . $displayValue);
    }

    /**
     * @return PoolStatus[]
     */
    public static function values(): array
    {
        if (is_null(self::$values)) {
            self::$values = [
                self::PENDING => new PoolStatus(self::PENDING, 'pending'),
                self::UNFULFILLED => new PoolStatus(self::UNFULFILLED, 'unfulfilled'),
                self::TERMINATING => new PoolStatus(self::TERMINATING, 'terminating'),
                self::TERMINDATED => new PoolStatus(self::TERMINDATED, 'terminated'),
                self::REGISTERING => new PoolStatus(self::REGISTERING, 'registering'),
                self::PROGRESS => new PoolStatus(self::PROGRESS, 'progress'),
                self::COMPLETE => new PoolStatus(self::COMPLETE, 'complete'),

            ];
        }
        return self::$values;
    }

    /**
     * @return string
     */
    public static function pending(): PoolStatus
    {
        return self::values()[self::PENDING];
    }

    /**
     * @return string
     */
    public static function unfulfilled(): PoolStatus
    {
        return self::values()[self::UNFULFILLED];
    }

    /**
     * @return string
     */
    public static function terminating(): PoolStatus
    {
        return self::values()[self::TERMINATING];
    }

    /**
     * @return string
     */
    public static function terminated(): PoolStatus
    {
        return self::values()[self::TERMINDATED];
    }

    /**
     * @return string
     */
    public static function registering(): PoolStatus
    {
        return self::values()[self::REGISTERING];
    }

    /**
     * @return string
     */
     public static function progress(): PoolStatus
     {
         return self::values()[self::PROGRESS];
     }


     /**
     * @return string
     */
     public static function complete(): PoolStatus
     {
         return self::values()[self::COMPLETE];
     }



    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getDisplayValue(): string
    {
        return $this->displayValue;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->status;
    }
}