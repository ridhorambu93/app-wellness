<x-app-layout>
    <x-slot name="header">
            <a href="{{ url('/menu-survey') }}" style="text-decoration: none" class="btn-back d-flex justify-content-end">
                <svg class="w-16 h-6 text-yellow-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m17 16-4-4 4-4m-6 8-4-4 4-4"/>
                </svg>
                <span class="text-sm font-weight-bold text-yellow-700">Back To Survey List</span>
            </a>
    </x-slot>
    <div class="card p-3">
        <div class="card-body">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum incidunt eum modi vitae totam repudiandae labore maiores, esse temporibus repellat. Sapiente nesciunt magnam dolorem deserunt.
        </div>
    </div>
</x-app-layout>