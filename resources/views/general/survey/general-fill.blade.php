<x-app-layout>
    <x-slot name="header">
            <a href="{{ url('/menu-survey') }}" style="text-decoration: none" class="btn-back d-flex justify-content-end">
                <svg class="w-16 h-6 text-yellow-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m17 16-4-4 4-4m-6 8-4-4 4-4"/>
                </svg>
                <span class="text-sm font-weight-bold text-yellow-700">Back To Survey List</span>
            </a>
    </x-slot>
    @foreach($pertanyaans as $index => $p)
        <div class="card-body bg-warning p-2 m-2">
            <h4 class="font-weight-bold p-1 mb-2">{{ $index + 1 }}. {{ $p->pertanyaan }}</h4> <hr>
            <ul>
                @foreach($p->skalaJawaban as $jawaban)
                    <li class="font-weight-bold ml-3 p-1">{{ $jawaban->nama_skala }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach
</x-app-layout>