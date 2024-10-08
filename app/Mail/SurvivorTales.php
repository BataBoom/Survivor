<?php

namespace App\Mail;

use App\Models\Survivor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SurvivorTales extends Mailable
{
    use Queueable, SerializesModels;

    public array $gameResult;

    public bool $gameTied;

    /**
     * Create a new message instance.
     */
    public function __construct(public Survivor $survivor)
    {
        $this->survivor = $survivor;
        $this->gameTied = $this->survivor->results->winner === 35 ? true : false;

        $score = [$this->survivor->results->home_score, $this->survivor->results->away_score];
        rsort($score);

        if($this->gameTied) {
            $this->gameResult = [
            'game' => $this->survivor->results->question->question,
            'score' => $score[0] .' - '.$score[1],
            'summary' => 'the ' . $this->survivor->selection.' tied the '.$this->survivor->results->teams->where('team_id','!==', $this->survivor->selection_id)->first()->option.' '.$score[0] .' - '.$score[1],
            ];
        } else {
            $this->gameResult = [
            'game' => $this->survivor->results->question->question,
            'score' => $score[0] .' - '.$score[1],
            'summary' => 'the ' . $this->survivor->selection.' defeated the '.$this->survivor->results->teams->where('team_id','!==', $this->survivor->selection_id)->first()->option.' '.$score[0] .' - '.$score[1],
            ];
        }

        
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if($this->gameTied) {
        $varys = [
            "Wow! So close. Just another 17(or so) weeks to push through.",
            'Wow! So close. You survived to tell the tale, yet more games lay ahead.',
            "Wow! So close.",
            ];
        } else {
            $varys = [
            "You've passed the first hurdle! Just another 17(or so) weeks to push through.",
            'You survived to tell the tale, yet more games lay ahead.',
            "You've come out the other side, but there's more in store for you.",
            "You've survived to recount your experience, but there are further obstacles on the horizon.",
            "You made it through to share your story, but there are still challenges ahead.",
            ];
        }
        
        
        if($this->survivor->week == 1) {
            $subject = $this->survivor->pool->pool->name.': '.$varys[0];
        } else {
            $subject = $this->survivor->pool->pool->name.': '.$varys[rand(1, array_key_last($varys))];
        }
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if($this->gameTied) {
            $gg = [
                 "Close call, you may not be so lucky next time! You may want to attend Pick'em to sharpen your skills",
            ];
        } else {
            $gg = [
                 "Great job, well played!",
                 "Congratulations on a hard-fought game!",
                 "Good game, you guys really brought your A-game tonight!",
            ];
        }


        return new Content(
            view: 'emails.survivor-tales',
            with: [
                'name' => ucfirst($this->survivor->user->name),
                'survivor' => $this->survivor,
                'pool' => $this->survivor->pool->pool,
                'week' => $this->survivor->week,
                'gg' => $gg[array_rand($gg)],
                'gameSummary' => $this->gameResult,
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