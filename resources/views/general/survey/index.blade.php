<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modul Survey Karyawan') }}
        </h2>
    </x-slot>

    <div class="container">
        <div class="card m-3 p-3">
            <div class="row">

            @foreach ($surveys as $data)
            @php $isFilled = $respondens->contains($data->id); @endphp
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                            @if ($data->status_survey == 'aktif')
                                <div class="card-header bg-gray-100 dark:bg-gray-700 p-2 border-b border-gray-200 dark:border-gray-600">
                                    <h5 class="text-base font-bold tracking-tight text-gray-900 dark:text-white text-capitalize">
                                        Status : {{ $data->status_survey }}
                                    </h5>
                                </div>
                                <div class="card-body fw-bold p-2">
                                    <a href="#" style="text-decoration: none;" class="text-center block max-w-sm p-2" data-bs-toggle="modal" data-bs-target="#modal-{{ $data->id }}">
                                        <h5 class="mb-2 text-base font-bold tracking-tight text-gray-900 dark:text-white">{{$data->nama_survey}}</h5>
                                    </a>
                                </div>
                                <div class="card-footer bg-gray-100 dark:bg-gray-700 p-2 border-t border-gray-200 dark:border-gray-600">
                                    <small class="font-italic text-gray-600 dark:text-gray-400">Start : {{$data->tanggal_mulai}}</small> 
                                    <small class="font-italic text-gray-600 dark:text-gray-400 float-right p-1">Finish :  {{$data->tanggal_akhir}}</small>
                                </div>
                            @else
                                <div class="card-header bg-red-100 dark:bg-gray-700 p-2 border-b border-black-200 dark:border-gray-600">
                                    <h5 class="text-base font-bold tracking-tight text-red-900 dark:text-white text-capitalize">
                                        Status : {{ $data->status_survey }}
                                    </h5>
                                </div>
                                 <div class="card-body fw-bold p-2 bg-red-100">
                                    <a href="#" style="text-decoration: none;" class="text-center block max-w-sm p-2">
                                        <h5 class="mb-2 text-base font-bold tracking-tight text-red-900 dark:text-white">{{$data->nama_survey}}</h5>
                                    </a>
                                </div>
                                <div class="card-footer bg-red-100 dark:bg-gray-700 p-2 border-t border-black-200 dark:border-gray-600">
                                    <small class="font-italic text-gray-600 dark:text-gray-400"> - </small>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="modal-{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title font-bold text-capitalize" id="exampleModalLabel">{{$data->nama_survey}}</h5>
                                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>{{$data->deskripsi_survey}}</p>
                                </div>
                                <div class="modal-footer">
                                    @if ($isFilled)
                                        <div class="btn btn-success">Anda sudah mengisi survey ini</div>
                                    @else
                                        <a href="{{ route('survey.fill', $data->id) }}" class="btn btn-primary">Isi Survey</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>