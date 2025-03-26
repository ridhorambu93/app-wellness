<x-app-layout>
    <section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Form Add Survey') }}
        </h2>
    </header>
<form action="{{ route('survey.store') }}" method="post">
    <label for="pertanyaan_id">Pertanyaan:</label>
    <button type="submit">Simpan</button>
</form>
</section>
</x-app-layout>
