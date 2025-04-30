<x-app-layout>
    <style>
        #surveyBanner {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #f0f0f0;
            padding: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.5s ease-in-out;
        }

        .close-btn {
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
        }
    </style>
    <div class="banner fixed top-0 left-0 right-0 bg-white shadow-lg z-50 p-4" id="surveyBanner" style="display: none;">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-900 p-8 rounded-lg">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">Kami Menghargai Masukan Anda!</h2>
                <p class="text-lg font-normal text-gray-600 lg:text-xl dark:text-gray-400 mb-6">
                    Kuesioner ini tidak hanya digunakan untuk tujuan penelitian, tetapi juga sebagai masukan berharga untuk perbaikan di masa depan. 
                    Kami sangat menghargai waktu Anda untuk mengisi survei ini, mencerminkan pengalaman dan wawasan Anda.
                </p>
                <p class="text-lg font-normal text-gray-600 lg:text-xl dark:text-gray-400 mb-6">
                    Setiap jawaban yang Anda berikan adalah bantuan yang sangat berharga untuk penelitian ini. 
                    Terima kasih atas kontribusi Anda!
                </p>
                <p class="text-lg font-bold text-gray-800 dark:text-gray-200">Hormat kami,<br>Tim Survei</p>
                {{-- <button onclick="closeBanner()" class="mt-4 bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition duration-300">Tutup</button> --}}
            </div>
        </div>
    </div>

    <form id="surveyForm">
        <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
        @foreach($pertanyaans as $index => $p)
            <div class="card-body bg-white dark:bg-gray-900 rounded-md p-2 m-3">
                <h4 class="font-weight-bold p-1 mb-2">{{ $index + 1 }}. {{ $p->pertanyaan }}</h4>
                <hr>
                <ul>
                    <input type="hidden" name="id_pertanyaan[]" value="{{ $p->id }}">
                    @if($p->type === 'essai')
                        <li class="font-weight-bold ml-3 p-1">
                            <textarea name="jawaban[]" class="form-control" id="jawaban_{{ $index }}" rows="10" placeholder="Jelaskan jawaban Anda" required></textarea>
                        </li>
                    @else
                        @foreach($p->skalaJawaban as $jawaban)
                            <li class="font-weight-bold ml-3 p-1">
                                <input type="radio" name="jawaban[{{ $index }}]" id="jawaban_{{ $index }}_{{ $loop->index }}" value="{{ $jawaban->nilai }}" required>
                                <label for="jawaban_{{ $index }}_{{ $loop->index }}">{{ $jawaban->nama_skala }}</label>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        @endforeach
        <button type="submit" class="m-3 p-3 mb-4 bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition duration-300">Submit</button>
    </form>

    <!-- Modal untuk Menampilkan Pesan Respon -->
    <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="responseModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="responseModalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>

<script>
window.onload = function() {
  const surveyBanner = document.getElementById('surveyBanner');
  surveyBanner.style.display = 'block';
  surveyBanner.style.opacity = 0;
  surveyBanner.style.transform = 'translateY(-20px)';
  setTimeout(function() {
    surveyBanner.style.opacity = 1;
    surveyBanner.style.transform = 'translateY(0)';
    surveyBanner.style.transition = 'all 0.5s ease-in-out';
  }, 100);

  setTimeout(function() {
    closeBanner();
  }, 2000);
};

function closeBanner() {
  const surveyBanner = document.getElementById('surveyBanner');
  surveyBanner.style.opacity = 0;
  surveyBanner.style.transform = 'translateY(-20px)';
  surveyBanner.style.transition = 'all 0.5s ease-in-out';
  setTimeout(function() {
    surveyBanner.style.display = 'none';
  }, 500);
}

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('#surveyForm').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize() + '&id_user=' + $('input[name="id_user"]').val();
        $.ajax({
            url: '/submit-survey',
            type: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = response.redirect; // Redirect after showing success
                });
            },
            error: function(jqXHR) {
                const errors = jqXHR.responseJSON.errors;

                if (errors) {
                    let errorMessage = 'Please correct the following errors:\n';
                    $.each(errors, function(key, value) {
                        errorMessage += value.join(', ') + '\n'; // Join multiple errors for the same field
                    });
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An unexpected error occurred. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });
});
</script>