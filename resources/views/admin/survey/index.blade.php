<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modul Survey') }}
        </h2>
    </x-slot>

    <div class="list-tabel-pertanyaan mt-3 p-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="data-pertanyaan-tab" data-bs-toggle="tab"
                                        data-bs-target="#data-pertanyaan" type="button" role="tab"
                                        aria-controls="data-pertanyaan" aria-selected="true">Data Pertanyaan</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="data-jawaban-tab" data-bs-toggle="tab"
                                        data-bs-target="#data-jawaban" type="button" role="tab"
                                        aria-controls="data-jawaban" aria-selected="false">Data Jawaban</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="data-survey-tab" data-bs-toggle="tab"
                                        data-bs-target="#data-survey" type="button" role="tab"
                                        aria-controls="data-survey" aria-selected="false">Data Survey</button>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <!-- Display Flash Messages -->
                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <!-- Display Validation Errors -->
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="data-pertanyaan" role="tabpanel"
                                    aria-labelledby="data-pertanyaan-tab">
                                    <!-- Add Button -->
                                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPertanyaanModal">Add Data</button>
                                    <table id="table-pertanyaan" class="table table-striped table-bordered"
                                        cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Pertanyaan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                {{-- start tab jawaban --}}
                                <div class="tab-pane fade" id="data-jawaban" role="tabpanel"
                                    aria-labelledby="data-jawaban-tab">
                                    <table id="table-jawaban" class="table table-striped table-bordered" cellspacing="0"
                                        width="100%">
                                        <thead class="bg-danger">
                                            <tr>
                                                <th>No</th>
                                                <th>Jawaban</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                {{-- end tab jawaban --}}

                                {{-- start tab survey --}}
                                <div class="tab-pane fade" id="data-survey" role="tabpanel"
                                    aria-labelledby="data-survey-tab">
                                    <table id="table-survey" class="table table-striped table-bordered" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jawaban</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                {{-- end tab survey --}}
                            </div>
                        </div>

                        <!-- Modal Add Pertanyaan -->
                        <div class="modal fade" id="addPertanyaanModal" tabindex="-1" aria-labelledby="addPertanyaanModalLabel" aria-hidden="true" data-bs-backdrop="static">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addPertanyaanModalLabel">Form Pertanyaan</h5>
                                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form for adding a new question -->
                                        <form action="{{ route('survey.store') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="pertanyaan" class="form-label">Pertanyaan</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="pertanyaan" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <select id="jenis-pertanyaan" name="jenis_pertanyaan" class="form-select" required>
                                                    <option>-- Pilih Jenis Pertanyaan --</option>
                                                    <option value="pekerjaan">Pekerjaan</option>
                                                    <option value="lingkungan_kerja">Lingkungan Kerja</option>
                                                    <option value="kepemimpinan">Kepemimpinan</option>
                                                    <option value="perusahaan">Perusahaan</option>
                                                </select>
                                            </div>
                                            <button class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#table-pertanyaan').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 5,
            responsive: true,
            ajax: {
                 url: '{{ route('admin.survey.getData') }}',
                data: function (d) {
                    d.jenis_pertanyaan = $('#jenis-pertanyaan').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'pertanyaan',
                    name: 'pertanyaan'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            responsive: true,
            layout: {
                topStart: {
                    pageLength: {
                        menu: [10, 25, 50, 100]
                    }
                },
                topStart: 'info',
                topEnd: {
                    search: {
                        placeholder: 'Type search here'
                    }
                },
                bottomEnd: {
                    paging: {
                        numbers: 3
                    }
                }
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#table-jawaban').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 5,
            responsive: true,
            ajax: {
                url: '{{ route('admin.survey.getDataJawaban') }}', // Pastikan ini sesuai dengan route yang benar
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'pertanyaan', // Kolom untuk pertanyaan
                    name: 'pertanyaan'
                },
                {
                    data: 'jawaban', // Kolom untuk pilihan jawaban
                    name: 'jawaban'
                },
            ],
            responsive: true,
        });
    });
</script>
