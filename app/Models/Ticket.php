<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $guarded = [];

    /**
     * Opens new ticket with the title, of logged user
     *
     * @param string $title
     * @return Ticket
     * @throws RequestException
     */
    public static function openTicket(string $title) : Ticket
    {

        $newTicket = new Ticket;
        $newTicket->subject = $title;
        $newTicket->answered = false;
        $newTicket->user_id = auth()->user()->id;
        $newTicket->save();

        return $newTicket;
    }


    /**
     * Relationship of the user who made a Ticket
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relationship to attached Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment()
    {
        return $this->hasOne(Payment::class, 'payment_id', 'id');
    }

    /**
     * Relationship with the Ticket replies
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(TicketReply::class, 'ticket_id', 'id');
    }

    public function model()
    {
        return $this->morphTo()->withDefault();
    }

    /**
     * Time passed
     *
     * @return string
     */
    public function getTimePassedAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}
