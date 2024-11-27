<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\Package;
use App\Models\Question;
class Tryout extends Component
{
     // Membuat halaman tryout sesuai dengan package question
     public $package;
     public $currentQuestion;
     public $questions;

     public function mount($id){
        $this->package = Package::with('questions.question.options')->find($id);
// validasi dan ambil data dari sql database
        if($this->package){
            $this->questions = $this->package->questions;
            if($this->questions->isNotEmpty()){
                $this->currentQuestion = $this->questions->first();
            }
        }
     }



    public function render()
    {
        return view('livewire.tryout');
    }
    // membuat function untuk ketika di klik navbar soal dia pindah ke soal yang dimaksud
    public function goToQuestion($index)
    {
        $this->currentQuestion = $this->questions[$index];
    }
}
