<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\WagerOption;

class BeforeWagerQuestionStart implements Rule
{
    protected $wagerOptionID;
    protected $timeNow;

    public function __construct($wagerOptionID)
    {
        $this->wagerOptionID = WagerOption::Where('id', $wagerOptionID)->with('question')->first();
        $this->timeNow = Carbon::now();
    }

    public function passes($attribute, $value)
    {
        if (!$this->wagerOptionID) {
            return false;
        }

        return Carbon::parse($this->timeNow)->lessThan(Carbon::parse($this->wagerOptionID->question->starts_at));
    }

    public function message()
    {
        return $this->wagerOptionID->question->question.' has already started! '.str_replace(['after', 'before'], 'ago', $this->wagerOptionID->question->starts_at->since($this->timeNow));
    }
}