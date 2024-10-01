<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\QuizOption;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\WagerTeam;
use App\Models\QuizScore;
use Illuminate\Support\Facades\Auth;

class QuizMob extends Component
{
    public Quiz $quiz;

    public $user;

    public array $answers = [];

    public array $scoreAnswers = [];

    public bool $graded = false;

    public float $percent = 0.0;

    public array $wrongAnswers = [];

    public function mount(Quiz $quiz)
    {
        $this->user = Auth::User();
        $this->quiz = $quiz;
        foreach($this->quiz->questions as $question) {
            $this->answers[$question->id] = '';
            $this->scoreAnswers[$question->id] = '';
        }
    }

    public function updatedAnswers()
    {
       // dd('updated awnswer');
    }

    public function save()
    {
         $this->gradeIt();
        //dd($gg);
    }

    public function gradeIt()
    {
        foreach($this->answers as $k => $v) {
                $question2 = $this->quiz->questions->find($k);
                if(intval($v) === $question2->answer->id) {
                    $this->scoreAnswers[$k] = 1;
                } else {
                    $this->scoreAnswers[$k] = 0;
                    if($v !== '') {
                        $this->wrongAnswers[] = [$question2->question, $question2->options->find($v)->option];
                    } else {
                        $this->wrongAnswers[] = [$question2->question, null];
                    }
                    
                }
                $gg[] = $v; 
        }

        $count = array_count_values($this->scoreAnswers);

        // Now, to get the count of zeros:
        $correctCount = $count[1] ?? 0;  // This uses the null coalescing operator in case 0 wasn't found

        $this->percent = $correctCount / 32 * 100;

        $createScore = QuizScore::UpdateOrCreate(
        [
            'user_id' => $this->user->id,
            'quiz_id' => $this->quiz->id,
        ],
        [
            'user_id' => $this->user->id,
            'quiz_id' => $this->quiz->id,
            'percentage' => $this->percent,
        ]);

        if($createScore->id) {
            $this->graded = true;
        }

    }

    public function render()
    {
        if(!$this->graded) {
            return view('livewire.quiz-mob');
        } else {
            return view('livewire.quiz-mob-graded');
        }
        
    }
}
