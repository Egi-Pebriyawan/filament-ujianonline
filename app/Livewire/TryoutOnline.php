<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\Package;
use App\Models\Question;
class TryoutOnline extends Component
{
     // Membuat halaman tryout sesuai dengan package question
     public $package;
     public $currentPackageQuestion;
     public $questions;

     public function mount($id){
        $this->package = Package::with('questions.question.options')->find($id);
// validasi dan ambil data dari sql database
        if($this->package){
            $this->questions = $this->package->questions;
            if($this->questions->isNotEmpty()){
                $this->currentPackageQuestion = $this->questions->first();
            }
        }
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

    }

    // membuat function untuk save answer
    public function saveAnswer ($questionId, $optionId)
    {
        
    }
}
