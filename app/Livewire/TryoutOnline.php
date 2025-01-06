<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Package;
use Auth;
use Carbon\Carbon;
use App\Models\TryOut;
use App\Models\QuestionOption;
use App\Models\TryOutAnswer;
use Filament\Notifications\Notification;

class TryoutOnline extends Component
{
    public $package;
    public $questions;
    public $currentPackageQuestion;
    public $tryOut;
    public $tryOutAnswers;
    public $timeLeft;
    public $selectedAnswers = [];

    public function mount($packageId)
    {
        $this->package = Package::with('questions.question.options')->find($packageId);
        if ($this->package) {
            $this->questions = $this->package->questions;
            $this->currentPackageQuestion = $this->questions->first();
        }

        $this->initializeTryOut($packageId);
        $this->loadTryOutAnswers();
        $this->calculateTimeLeft();
    }

    protected function initializeTryOut($packageId)
    {
        $this->tryOut = TryOut::where('user_id', Auth::id())
            ->where('package_id', $packageId)
            ->whereNull('finished_at')
            ->first();

        if (!$this->tryOut) {
            $this->createNewTryOut($packageId);
        }
    }

    protected function createNewTryOut($packageId)
    {
        $startedAt = Carbon::now();
        $durationInSeconds = $this->package->duration * 60;

        $this->tryOut = TryOut::create([
            'user_id' => Auth::id(),
            'package_id' => $this->package->id,
            'duration' => $durationInSeconds,
            'started_at' => $startedAt
        ]);

        foreach ($this->questions as $question) {
            TryOutAnswer::create([
                'tryout_id' => $this->tryOut->id,
                'question_id' => $question->question_id,
                'option_id' => null,
                'score' => 0,
            ]);
        }
    }

    protected function loadTryOutAnswers()
    {
        $this->tryOutAnswers = TryOutAnswer::where('tryout_id', $this->tryOut->id)->get();
        foreach ($this->tryOutAnswers as $answer) {
            $this->selectedAnswers[$answer->question_id] = $answer->option_id;
        }
    }

    public function goToQuestion($package_question_id)
    {
        $this->currentPackageQuestion = $this->questions->where('id', $package_question_id)->first();
        $this->calculateTimeLeft();
    }

    protected function calculateTimeLeft()
    {
        if ($this->tryOut->finished_at) {
            $this->timeLeft = 0;
            return;
        }

        $now = time();
        $startedAt = strtotime($this->tryOut->started_at);
        $elapsedTime = $now - $startedAt;

        $this->timeLeft = max(0, $this->tryOut->duration - $elapsedTime);
    }

    public function submit()
    {
        $this->tryOut->update(['finished_at' => now()]);
        $this->calculateTimeLeft();
        Notification::make()
            ->title('Sukses mengakhiri Try Out!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.tryout');
    }

    public function saveAnswer($questionId, $optionId)
    {
        $option = QuestionOption::find($optionId);
        $score = $option->score ?? 0;

        $tryOutAnswer = TryOutAnswer::where('tryout_id', $this->tryOut->id)
            ->where('question_id', $questionId)
            ->first();

        if ($tryOutAnswer) {
            $tryOutAnswer->update([
                'option_id' => $optionId,
                'score' => $score,
            ]);
        }

        $this->selectedAnswers[$questionId] = $optionId;
        $this->loadTryOutAnswers();
        $this->dispatch('refreshComponent');
    }
    
}
