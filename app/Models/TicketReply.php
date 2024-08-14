<?php

namespace App\Models;

//use App\Events\Support\NewTicketReply;
//use App\Exceptions\RequestException;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketReply extends Model
{
    use HasUuids, HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $guarded = [];

    /**
     * Persisting new Ticket Reply in ticket
     *
     * @param Ticket $ticket
     * @param $message
     */
    public static function postReply(Ticket $ticket, $message)
    {
        /*
        if(!auth()->check())
            throw new RequestException("There is no logged user!");

        throw_if($ticket->solved, new RequestException("Ticket is solved, you can't post any messages!"));
            */

        // if logged user is not the one who posted it
        if(auth()->user()->id != $ticket->user->id){
            // mark the title as ansered
            $ticket->answered = true;
            $ticket->save();
        }

        $newReply = new TicketReply;
        $newReply->text = $message;
        $newReply->ticket_id = $ticket->id;
        $newReply->user_id = auth()->user()->id;

        $newReply->save();
        if ($newReply->ticket->user->id !== $newReply->user_id){
            //event(new NewTicketReply($newReply));
        }

    }

    /**
     * Relationship with the User who posted reply
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Ticket that is owning this reply
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
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

    public function isCreator(): bool
    {
        return $this->ticket->user_id == $this->user_id ? true : false;
    }
}
