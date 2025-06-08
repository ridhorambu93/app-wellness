<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                    <h1>This is Super Admin dashboard!</h1>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 mt-3 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col md:flex-row justify-between p-4 gap-4">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold mb-4">Statistik Survei</h2>
                        <canvas id="surveyChart" class="w-full h-64"></canvas>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold mb-4">Rata-rata Skor</h2>
                        <canvas id="averageScoreChart" class="w-full h-64"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 mt-3 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col md:flex-row gap-4 p-4">
                    <div class="flex-1">
                        <canvas id="respondentTrendChart" class="w-full h-64"></canvas>
                    </div>
                    <div class="flex-1">
                        <canvas id="respondentsPerSurveyChart" class="w-full h-64"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Survey Pie Chart
        const ctxSurvey = document.getElementById('surveyChart').getContext('2d');
        const surveyChart = new Chart(ctxSurvey, {
            type: 'pie',
            data: {
                labels: ['Survey 1', 'Survey 2', 'Survey 3'],
                datasets: [{
                    label: 'Jumlah Survei',
                    data: [10, 5, 15],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Data Survei'
                    }
                }
            }
        });

        // Average Score Bar Chart
        const ctxAverageScore = document.getElementById('averageScoreChart').getContext('2d');
        const averageScoreChart = new Chart(ctxAverageScore, {
            type: 'bar',
            data: {
                labels: ['Pertanyaan 1', 'Pertanyaan 2', 'Pertanyaan 3'],
                datasets: [{
                    label: 'Rata-rata Skor',
                    data: [4, 3, 5],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Rata-rata Skor Pertanyaan'
                    }
                }
            }
        });

        // Respondent Trend Line Chart
        const ctxRespondentTrend = document.getElementById('respondentTrendChart').getContext('2d');
        const respondentTrendChart = new Chart(ctxRespondentTrend, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'],
                datasets: [{
                    label: 'Jumlah Responden',
                    data: [10, 15, 20, 25, 30],
                    fill: false,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Tren Partisipasi Responden'
                    }
                }
            }
        });

        // Respondents per Survey Bar Chart
        const ctxRespondentsPerSurvey = document.getElementById('respondentsPerSurveyChart').getContext('2d');
        const respondentsPerSurveyChart = new Chart(ctxRespondentsPerSurvey, {
            type: 'bar',
            data: {
                labels: ['Survey 1', 'Survey 2', 'Survey 3'],
                datasets: [{
                    label: 'Jumlah Responden',
                    data: [50, 30, 70],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Jumlah Responden per Survey'
                    }
                }
            }
        });
    </script>
</x-app-layout>