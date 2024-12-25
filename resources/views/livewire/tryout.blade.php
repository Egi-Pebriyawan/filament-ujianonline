<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="md:col-span-2 bg-white shadow-md rounded-lg p-6">
        @if($tryOut->finished_at == null)
            <div class="text-center mb-4">
                <h2 class="text-xl font-bold mb-2">Sisa Waktu</h2>
                <div class="text-gray-700 text-lg" id="time">
                    {{ $timeLeft >= 0 ? '00:00:00' : 'HABIS' }}
                </div>
            </div>
        @endif
        <h2 class="text-2xl font-bold mb-4">{{ $package->name }}</h2>
        <p class="text-gray-700">{!! $currentPackageQuestion->question->question !!}</p>
        <div class="mt-4">
            @foreach($currentPackageQuestion->question->options as $item)
                @php
                    $answer = $tryOutAnswers->where('question_id', $currentPackageQuestion->question_id)->first();
                    $isSelected = $answer ? $answer->option_id == $item->id : false;
                @endphp
                <label class="flex items-center gap-x-4 mb-2">
                    <input
                        id="option_{{ $currentPackageQuestion->question_id }}_{{ $item->id }}"
                        type="radio"
                        name="option"
                        class="mr-4"
                        wire:click="saveAnswer({{ $currentPackageQuestion->question_id }}, {{ $item->id }})"
                        value="{{ $item->id }}"
                        @if($timeLeft <= 0) disabled @endif
                        @if($isSelected) checked @endif>
                    {!! $item->option_text !!}
                </label>
            @endforeach
        </div>
    </div>
    <div class="md:col-span-1 bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Navigasi Soal</h2>
        <p class="text-gray-700 mb-4">Pilih tombol dibawah ini untuk berganti soal.</p>
        @foreach($questions as $index => $item)
            @php 
                $isAnswered = isset($selectedAnswers[$item->question_id]) && !is_null($selectedAnswers[$item->question_id]); 
                $isActive = $currentPackageQuestion->id === $item->id; 
            @endphp
            <x-filament::button 
                wire:click="goToQuestion({{ $item->id }})" 
                class="mb-2" 
                color="{{ $isActive ? 'warning' : ($isAnswered ? 'success' : 'gray') }}">
                {{ $index + 1 }}
            </x-filament::button>
        @endforeach
        @if($tryOut->finished_at == null)
            <x-filament::button 
                wire:click="submit" 
                onclick="return confirm('Apakah anda yakin ingin mengirim jawaban ini?')" 
                class="btn w-full bg-blue-500 text-white py-2 rounded mt-3">
                Submit
            </x-filament::button>
        @endif
    </div>
    @if($tryOut->finished_at != null)
        <div class="bg-green-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <a href="{{ url('/admin/tryouts') }}" class="underline">Lihat Hasil Pengerjaan</a>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let timeLeft = {{ $timeLeft }};
        startCountdown(timeLeft, document.getElementById('time'));
        window.addEventListener('refreshComponent', () => {
            Livewire.emit('refreshComponent');
        });
    });

    function startCountdown(duration, display) {
        let timer = duration, hours, minutes, seconds;
        setInterval(function() {
            hours = parseInt(timer / 3600, 10);
            minutes = parseInt((timer % 3600) / 60, 10);
            seconds = parseInt(timer % 60, 10);
            display.textContent = [hours, minutes, seconds].map(v => v < 10 ? "0" + v : v).join(":");
            if (--timer < 0) {
                timer = 0;
            }
        }, 1000);
    }
</script>
