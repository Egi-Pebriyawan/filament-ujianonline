<div>
    <style>
        .active-question {
            border: 2px solid darkblue;
        }
        .no-hover:hover {
            background-color: transparent !important;
            color: inherit !important;
            .disabled-radio {
                cursor: not-allowed;
            }
            .disable-button {
                pointer-events: none;
                opacity: 0.6;
            }
        }
    </style>
    <div class="container mt-4">
        <div class="row">
            <h4>{{$package->name}}</h4>
            <!-- Script untuk html pertanyaan dan jawaban -->
            <div class="col-md-8">
                <div id="question-container">
                    <div class="card question-card">
                        @if ($tryOut->finished_at == null)
                        <div class="countdown-timer mb-4 text-success text-center" id="countdown"> 
                            Waktu tersisa : <span id="time">00:00:00</span></div>
                            @endif
                        <div class="card-body"> <!-- Perbaiki di menjadi div -->
                       
                            <p class="card-text">{!! $currentPackageQuestion->question->question !!}</p>
                            @foreach ($currentPackageQuestion->question->options as $item)
                            <div class="form-check">
                                <input class="form-check-input"
                                wire:model="selectedAnswers.{{$currentPackageQuestion->question_id}}"
                                wire:click="saveAnswer({{$currentPackageQuestion->question_id}}, {{$item->id}})"
                                 type="radio" 
                                 @if ($timeLeft <=0)
                                 disabled
                                 class = "disabled-radio"
                                 @endif

                                 name="question" 
                                 value="{{$item->id}}"
                                 @if($tryOutAnswers->isEmpty() || !$tryOutAnswers->contains ('option_id', $item->id))
                                 @else
                                    checked
                                 @endif>
                                <label class="form-check-label">{!! $item->option_text !!}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigasi Question -->
            <div class="col-md-4">
                <div class="card question-navigation">
                    <div class="card-body">
                        <h5 class="card-title">Navigasi</h5> 
                        <div class="btn-group-flex" role="group">
                            <!-- membuat agar navigasi di klik dan pindah halaman -->
                            @foreach ($questions as $index => $item)
                            @php
                                $isAnswered = isset ( $selectedAnswers[$item->question_id]) && !is_null(($selectedAnswers[$item->question_id]));
                                $isActive = $currentPackageQuestion->question->id === $item->question_id;
                            @endphp
                            <div class="col-2 mb">                           
                            <button type="button" 
                            @if($timeLeft <=0)
                                 disabled
                                 @endif
                            wire:click="goToQuestion({{$item->id}})" 
                            class="btn {{$isAnswered ? 'btn-primary' : 'btn-outline-primary no-hover'}} {{$isActive ? 'active-question' : ''}}">{{$index+1}}</button>
                            </div>
                            @endforeach
                        </div>
                       <button type="button" wire:click="submit" onclick="return confirm ('Apakah anda yakin ingin mengirim jawaban ini?')"
                       class="btn btn-primary mt-3 w-100">Submit</button>
                     </div>
                </div>
            </div>
        </div>
    <!-- panggil fungsi submit -->
     @if (session()->has ('message'))
     <div class="alert alert-success text-center">
        {{session('message')}} <a href="{{url('admin/tryouts')}}"> Lihat Hasil Pengerjaan</a>
     </div>
     @endif
    </div>
    <!--Function javascript untuk countdown-->
    <script>

// Memanggil variable global dari php di TryoutOnline livewire ke javascript untuk count down menggunakan server time
document.addEventListener('DOMContentLoaded', function() {
            let timeLeft = {{$timeLeft}};
            startCountdown(timeLeft, document.getElementById('time'));
        });
        


        function startCountdown (duration, display) {
        let timer = duration, hours, minutes, seconds;
        console.log(timer);
        const interval = setInterval(() => {
        hours = Math.floor(timer / 3600);
        minutes = Math.floor((timer % 3600) / 60);
        seconds = timer % 60;
        hours = hours < 10 ? "0" + hours : hours;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        display.textContent = hours + ":" + minutes + ":" + seconds;
        if (--timer < 0) {
            clearInterval(interval);
            display.textContent = "Time's up!";
        }
    }, 1000);}

    </script>
</div>
