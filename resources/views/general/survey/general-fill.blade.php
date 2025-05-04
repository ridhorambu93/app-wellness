<x-app-layout>
    <style>
        /* Gaya tambahan jika diperlukan */
    </style>

    <!-- Banner Survei -->
    <div id="surveyBanner" class="fixed top-0 left-0 right-0 bg-white shadow-lg z-50 p-4" style="display: none;">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-900 p-8 rounded-lg">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">Kami Menghargai Masukan Anda!</h2>
                <p class="text-lg font-normal text-gray-600 dark:text-gray-400 mb-6">
                    Kuesioner ini tidak hanya digunakan untuk tujuan penelitian, tetapi juga sebagai masukan berharga untuk perbaikan di masa depan.
                    Kami sangat menghargai waktu Anda untuk mengisi survei ini, mencerminkan pengalaman dan wawasan Anda.
                </p>
                <p class="text-lg font-normal text-gray-600 dark:text-gray-400 mb-6">
                    Setiap jawaban yang Anda berikan adalah bantuan yang sangat berharga untuk penelitian ini.
                    Terima kasih atas kontribusi Anda!
                </p>
                <p class="text-lg font-bold text-gray-800 dark:text-gray-200">Hormat kami,<br>Tim Survei</p>
            </div>
        </div>
    </div>

    <!-- Formulir Survei -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form id="surveyForm" class="space-y-4">
                @csrf
                <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">

                @foreach($pertanyaans as $index => $pertanyaan)
                    <div class="card-body bg-white dark:bg-gray-900 rounded-md p-4">
                        <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-2">
                            {{ $index + 1 }}. {{ $pertanyaan->pertanyaan }}
                        </h4>
                        <hr class="my-2 border-gray-300 dark:border-gray-700">

                        <input type="hidden" name="id_pertanyaan[]" value="{{ $pertanyaan->id }}">

                        @if($pertanyaan->type === 'essai')
                            <textarea name="jawaban[]" class="form-control w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 focus:outline-none focus:ring-blue-500 focus:border-blue-500" rows="4" placeholder="Jelaskan jawaban Anda" required></textarea>
                        @else
                            <ul class="list-none space-y-2">
                                @foreach($pertanyaan->skalaJawaban as $jawaban)
                                    <li>
                                        <label class="flex items-center space-x-2">
                                            <input type="radio" name="jawaban[{{ $index }}]" id="jawaban_{{ $index }}_{{ $loop->index }}" value="{{ $jawaban->nilai }}" class="form-radio h-5 w-5 text-blue-600 dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500" required>
                                            <span class="text-gray-700 dark:text-gray-300">{{ $jawaban->nama_skala }}</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach

                <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Submit
                </button>
            </form>
        </div>
    </div>

    <!-- Modal untuk Menampilkan Pesan Respon (Jika Anda masih ingin menggunakannya) -->
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

    @push('scripts')
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
    @endpush
</x-app-layout>