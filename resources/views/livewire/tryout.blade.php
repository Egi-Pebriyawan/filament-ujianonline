<div>
    <div class="container mt-4">
        <div class="row">
            <!-- Script untuk html pertanyaan dan jawaban -->
            <div class="col-md-8">
                <div id="question-container">
                    <div class="card question-card">
                        <div class="countdown-timer mb-4 text-success text-center" id="countdown"> 
                            Waktu tersisa : <span id="time">00:00:00</span></div>
                        <div class="card-body"> <!-- Perbaiki di menjadi div -->
                            <h5 class="card-title">Soal Nomor 1</h5>
                            <p class="card-text">Apa Warna Langit di siang hari?</p>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question" value="1">
                                <label class="form-check-label">Merah</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question" value="2">
                                <label class="form-check-label">Biru</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question" value="3">
                                <label class="form-check-label">Hijau</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question" value="4">
                                <label class="form-check-label">Kuning</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="question" value="5">
                                <label class="form-check-label">Ungu</label>
                            </div>        
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
                            <button type="button" class="btn btn-outline-primary">1</button>
                            <button type="button" class="btn btn-outline-primary">2</button>
                            <button type="button" class="btn btn-outline-primary">3</button>
                        </div>
                       <button type="button" class="btn btn-primary mt-3 w-100">Submit</button>
                     </div>
                </div>
            </div>
        </div>
    </div>
    <!--Function javascript untuk countdown-->
    <script>
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

        // Function DOM untuk memanipulasi element di HTML terutama di countdown
        window.onload = function(){
        const duration = 60 *60;
        const display = document.querySelector('#time');
        startCountdown(duration, display);
    }
    </script>
</div>
