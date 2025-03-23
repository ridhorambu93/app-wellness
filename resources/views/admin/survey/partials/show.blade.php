<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Form Add Survey') }}
        </h2>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

<h1>{{ $pertanyaan->pertanyaan }}</h1>

<ul>
    @foreach($pilihanJawabans as $pilihanJawaban)
        <li>{{ $pilihanJawaban->pilihan }}</li>
    @endforeach
</ul>
</section>