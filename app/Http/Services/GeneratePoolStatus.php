<?php
namespace App\Http\Services;

use App\Enums\PoolStatus;
use App\Models\Pool;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class GeneratePoolStatus
{
    /**
     * @var Pool
     */
    private $Pool;

    public function __construct(Pool $Pool)
    {
        $this->Pool = $Pool;
    }

    public function createStatus()
    {
        $this->Pool->status_emum = $this->getStatus();
        return $this->Pool->save();
    }

    public function createStatusObserver()
    {
        $this->Pool->status_emum = $this->getStatus();
        $this->Pool->save();
    }

    public function getStatus()
    {
        if ($this->isTerminated()) {
            return PoolStatus::terminated()->getStatus();
        }
        if ($this->isFresh()) {

            return PoolStatus::pending()->getStatus();
        }
        if ($this->hasUnPaidEntrtyFee()) {
            return PoolStatus::unfulfilled()->getStatus();
        }
        if ($this->isWarning()) {
            return PoolStatus::terminating()->getStatus();
        }
        if ($this->isRegistering()) {
            return PoolStatus::registering()->getStatus();
        }
        if ($this->isProgress()) {
            return PoolStatus::progress()->getStatus();
        }
        if ($this->isComplete()) {
            return PoolStatus::complete()->getStatus();
        }

        //throw new \Exception("Can't generate status for Pool: " . $this->Pool->id);
        return 'error';
    }

    public function isFresh(): bool
    {
        if($this->Pool->created_at->toDateTimeString() >= now()->addHours(1)->toDateTimeString()) return true;

        return false;
    }

    public function hasUnPaidEntrtyFee(): bool
    {

        $createdAtPlus7Days = Carbon::CreateFromDate($this->Pool->created_at->toDateTimeString())->addDays(7);

        if($this->Pool->entry_cost > 0 && is_null($this->Pool->ticket_id) && $createdAtPlus7Days > now()) return true;

        return false;
    }

    public function isWarning(): bool
    {
        $createdAtPlus7Days = Carbon::CreateFromDate($this->Pool->updated_at->toDateTimeString())->addDays(7);

        if($this->Pool->entry_fee > 0 && is_null($this->Pool->ticket_id) && $createdAtPlus7Days > now()) return true;

        return false;
    }

    public function isTerminated(): bool
    {

        if($this->Pool->created_at >= config::get('survivor.start_date')) {
            return true;
        }

        $createdAtPlus10Days = Carbon::CreateFromDate($this->Pool->created_at->toDateTimeString())->addDays(10);

        if($this->Pool->entry_fee > 0 && is_null($this->Pool->ticket_id) && $createdAtPlus7Days > now()) return true;

        return false;

    }

    public function isRegistering(): bool
    {
        if(now()->greaterThan(config::get('survivor.start_date'))) {
            return false;
        }

        return true;
    }

    public function isProgress(): bool
    {
        if(now()->greaterThan(config::get('survivor.start_date'))) {
            return true;
        }

        return false;

    }

    public function isComplete(): bool
    {
        return false;
    }
}