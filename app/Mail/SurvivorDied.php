<?php

namespace App\Mail;

use App\Models\Survivor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Pool;

class SurvivorDied extends Mailable
{
    use Queueable, SerializesModels;

    public array $gameResult;
    /**
     * Create a new message instance.
     */
    public function __construct(public Survivor $survivor)
    {
        $this->survivor = $survivor;
        $score = [$this->survivor->results->home_score, $this->survivor->results->away_score];
        rsort($score);

        $this->gameResult = [
            'game' => $this->survivor->results->question->question,
            'score' => $score[0] .' - '.$score[1],
            'summary' => 'the ' . $this->survivor->selection.' lost to the '.$this->survivor->results->result->option.' '.$score[0] .' - '.$score[1],
        ];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

        return new Envelope(
            subject: $this->survivor->pool->pool->name.': ' . "Down goes ".ucfirst($this->survivor->user->name).' in week '. $this->survivor->week .'!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        $gg = [
            "Womp womp, looks like you didn't quite make the cut this time. Better luck next time!",
            "Sorry champ, you're not the winner. Maybe try again and bring your A game!",
            "Well, well, well, looks like someone's not taking home the gold medal today. Keep practicing!",
            "Oof, tough break. Maybe next time you'll have better luck. Keep your head up!",
            "Unfortunately, you've been defeated in the battle of wits. But hey, at least you tried!",
            "And the award for not winning goes to...you! Better luck next time, pal.",
            "Looks like the universe decided it wasn't your day to shine. Keep on keepin' on!",
            "Sorry to break it to you, but you didn't quite hit the jackpot this time. Keep playing!",
            "You may not have won this round, but hey, practice makes perfect. Don't give up!",
            "Ouch, tough loss. But hey, losing builds character, right? So you're basically winning in life now.",
        ];


        return new Content(
            view: 'emails.survivor-died',
            with: [
                'name' => ucfirst($this->survivor->user->name),
                'survivor' => $this->survivor,
                'pool' => $this->survivor->pool->pool,
                'week' => $this->survivor->week,
                'gg' => $gg[array_rand($gg)],
                'gameSummary' => $this->gameResult,
                'pickemLink' => route('pool.show', ['pool' => array_key_last(Pool::DummyPrizes)]),
                'email' => $this->survivor->user->email,


            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}