<x-app-layout>
    <!-- Formulir Survei -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form id="surveyForm" class="space-y-4" method="POST">
                @csrf
                <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
                <input type="hidden" name="survey_id" value="{{ $surveys->id }}">

                @foreach($surveys->pertanyaan as $index => $pertanyaan)
                    <div class="card-body bg-white dark:bg-gray-900 rounded-md p-4">
                        <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-2">
                            {{ $index + 1 }}. {{ $pertanyaan->pertanyaan }}
                        </h4>
                        <hr class="my-2 border-gray-300 dark:border-gray-700">
                        <input type="hidden" name="id_pertanyaan[]" value="{{ $pertanyaan->id }}">
                        @if($pertanyaan->type !== 'essai')
                        <ul class="list-none space-y-2">
                            @foreach($pertanyaan->skalaJawaban as $jawaban)
                                <li>
                                    <label class="flex items-center space-x-2">
                                        <input type="radio" name="jawaban[{{ $index }}]" id="jawaban_{{ $index }}_{{ $loop->index }}" value="{{ $jawaban->nama_skala }}" class="form-radio h-5 w-5 text-blue-600 dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500" required>
                                        <span class="text-gray-700 dark:text-gray-300">{{ $jawaban->nama_skala }}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    @if($pertanyaan->type === 'essai')
                        <textarea name="jawaban[{{ $index }}]" class="form-control w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 focus:outline-none focus:ring-blue-500 focus:border-blue-500" rows="4" placeholder="Jelaskan jawaban Anda" required></textarea>
                    @endif
                    </div>
                @endforeach

                <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Submit
                </button>
            </form>
        </div>
    </div>

    <script>
        $('#surveyForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah pengiriman form default

            const formData = $(this).serialize(); // Serialize data

            $.ajax({
                url: '/submit-survey', // Route untuk menyimpan jawaban
                type: 'POST',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = response.redirect; // Redirect setelah sukses
                    });
                },
                error: function(jqXHR) {
                    const errors = jqXHR.responseJSON.errors;

                    if (errors) {
                        let errorMessage = 'Please correct the following errors:\n';
                        $.each(errors, function(key, value) {
                            errorMessage += value.join(', ') + '\n'; // Gabungkan beberapa kesalahan untuk field yang sama
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
    </script>
</x-app-layout>