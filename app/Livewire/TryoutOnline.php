<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\Package;
use App\Models\Question;
use App\Models\Tryout;
use App\Models\TryoutAnswer;
use App\Models\QuestionOption;
use Auth;

class TryoutOnline extends Component
{
     // Membuat halaman tryout sesuai dengan package question
     public $package;
     public $currentPackageQuestion;
     public $tryOut;
     public $questions;
     public $timeLeft;
     public $tryOutAnswers;
     public $selectedAnswers = [];

    //mount adalah sesuatu yang bakal dirender pertama kali oleh livewire
     public function mount($id){
        $this->package = Package::with('questions.question.options')->find($id);
// validasi dan ambil data dari sql database
        if($this->package){
            $this->questions = $this->package->questions;
            if($this->questions->isNotEmpty()){
                $this->currentPackageQuestion = $this->questions->first();
            }
        }
//  membuat insert ke tryout table dan tryout answer
            $this->tryOut = TryOut::where('user_id', Auth::id())
            ->where('package_id', $this->package->id)
            ->whereNull('finished_at')
            ->first();

            if (!$this->tryOut) {
                $startedAt = now();
                $durationInSecond = $this->package->duration * 60;

                $this->tryOut = TryOut::create([
                    'user_id' => Auth::id(),
                    'package_id'=> $this->package->id,
                    'duration' => $durationInSecond,
                    'started_at' => $startedAt
                ]);

                foreach ($this->questions as $question){
                    TryOutAnswer::Create([
                        'tryout_id' => $this->tryOut->id,
                        'question_id' => $question->question_id,
                        'option_id'=> null,
                        'score' => 0
                    ]);
                }
            }
            $this->tryOutAnswers = TryOutAnswer::where('tryout_id', $this->tryOut->id)->get();
// function untuk menampung jawaban sebelum disubmit.

            foreach($this->tryOutAnswers as $answer) {
                $this->selectedAnswers[$answer->question_id] = $answer->option_id;
    
            }
          

            $this->calculateTimeLeft();
        }
     



    public function render()
    {
        return view('livewire.tryout');
    }
    // membuat function untuk ketika di klik navbar soal dia pindah ke soal yang dimaksud
    public function goToQuestion($package_question_id)
    {
        $this->currentPackageQuestion = $this->questions->where('id', $package_question_id)->first();
    }

    //menghitung calculate time left 
    protected function calculateTimeLeft()
    {
        if ($this->tryOut->finished_at) {
            $this->timeLeft = 0;
            
        } else {
            $now = time();
            $startedAt = strtotime($this->tryOut->started_at);
    
            $sisaWaktu = $now - $startedAt;
            if ($sisaWaktu < 0) {
                $this->timeLeft = 0;
            } else {
                $this->timeLeft = max(0, $this->tryOut->duration - $sisaWaktu);
            }
        }
    }

    // membuat function untuk save answer
    public function saveAnswer ($questionId, $optionId)
    {
     
        $option = QuestionOption::find($optionId);
        $score = $option->score ?? 0;
        $tryOutAnswer = TryoutAnswer::where('tryout_id', $this->tryOut->id)
                        ->where('question_id', $questionId)
                        ->first();
         if ($tryOutAnswer){
            $tryOutAnswer->update([
                'option_id' => $optionId,
                'score' => $score
            ]);
         }     
         $this->tryOutAnswers = TryOutAnswer::where('tryout_id', $this->tryOut->id)->get();          
         $this->calculateTimeLeft();
    }
}
