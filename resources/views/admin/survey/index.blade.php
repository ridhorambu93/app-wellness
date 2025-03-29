<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modul Survey') }}
        </h2>
    </x-slot>

    <style>
        .dataTables_wrapper {
            border: 1px solid #ddd;
            padding: 10px;
        }

        /* thead>tr>th.sorting {
            font-size: 12px;
        } */
    </style>

    <div class="list-tabel-pertanyaan mt-3 p-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-1 m-2 fw-bold">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="survey">
                                    <button class="nav-link active" id="data-survey-tab" data-bs-toggle="tab"
                                        data-bs-target="#data-survey" type="button" role="tab"
                                        aria-controls="data-survey" aria-selected="false">Master Survey</button>
                                </li>
                                <li class="nav-item" role="data-pertanyaan">
                                    <button class="nav-link" id="data-pertanyaan-tab" data-bs-toggle="tab"
                                        data-bs-target="#data-pertanyaan" type="button" role="tab"
                                        aria-controls="data-pertanyaan" aria-selected="true">Data Pertanyaan</button>
                                </li>
                                <li class="nav-item" role="data-jawaban">
                                    <button class="nav-link" id="data-jawaban-tab" data-bs-toggle="tab"
                                        data-bs-target="#data-jawaban" type="button" role="tab"
                                        aria-controls="data-jawaban" aria-selected="false">Data Jawaban</button>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                {{-- tab master survey --}}
                                <div class="tab-pane fade show active" id="data-survey" role="tabpanel" aria-labelledby="data-survey-tab">
                                    <!-- Add Button -->
                                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addSurveyModal">Add Data</button>
                                    <table id="table-survey" class="table table-striped table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jenis Pertanyaan</th>
                                                <th>Pertanyaan</th>
                                                <th>Jawaban</th>
                                                <th>Nilai</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>

                                <div class="modal fade" id="addSurveyModal" tabindex="-1" aria-labelledby="addSurveyModalLabel" data-bs-backdrop="static">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addSurveyModalLabel">
                                                    @isset($pertanyaan)
                                                        Edit Pertanyaan
                                                    @else
                                                        Tambah Pertanyaan
                                                    @endisset
                                                </h5>
                                                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Menampilkan Pesan Error atau Sukses -->
                                                @if (session('success'))
                                                    <script>
                                                        Swal.fire({
                                                            title: 'Sukses!',
                                                            text: '{{ session('success') }}',
                                                            icon: 'success',
                                                            confirmButtonText: 'OK'
                                                        });
                                                    </script>
                                                @elseif (session('error'))
                                                    <script>
                                                        Swal.fire({
                                                            title: 'Terjadi Kesalahan!',
                                                            text: '{{ session('error') }}',
                                                            icon: 'error',
                                                            confirmButtonText: 'Coba Lagi'
                                                        });
                                                    </script>
                                                @endif

                                                @if ($errors->any())
                                                    <script>
                                                        Swal.fire({
                                                            title: 'Terjadi Kesalahan!',
                                                            text: '@foreach ($errors->all() as $error){{ $error }} @endforeach',
                                                            icon: 'error',
                                                            confirmButtonText: 'Coba Lagi'
                                                        });
                                                    </script>
                                                @endif

                                                <!-- Form untuk Add dan Edit -->
                                                <form action="{{ isset($pertanyaan) ? route('survey.update', $pertanyaan->id) : route('survey.store') }}" method="POST" id="form-pertanyaan">
                                                    @csrf
                                                    @if(isset($pertanyaan))
                                                        @method('PUT') <!-- Menggunakan method PUT untuk update -->
                                                    @endif
                                                    <div class="mb-3">
                                                        <label for="pertanyaan" class="form-label">Pertanyaan</label>
                                                        <textarea class="form-control" id="formPertanyaan" rows="3" name="pertanyaan" required>{{ old('pertanyaan', isset($pertanyaan) ? $pertanyaan->pertanyaan : '') }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="jenis-pertanyaan" class="form-label">Jenis Pertanyaan</label>
                                                        <select id="jenis-pertanyaan" name="jenis_pertanyaan" class="form-select" required>
                                                            <option value="">-- Pilih Jenis Pertanyaan --</option>
                                                            <option value="pekerjaan" {{ old('jenis_pertanyaan', isset($pertanyaan) ? $pertanyaan->jenis_pertanyaan : '') == 'pekerjaan' ? 'selected' : '' }}>Pekerjaan</option>
                                                            <option value="lingkungan_kerja" {{ old('jenis_pertanyaan', isset($pertanyaan) ? $pertanyaan->jenis_pertanyaan : '') == 'lingkungan_kerja' ? 'selected' : '' }}>Lingkungan Kerja</option>
                                                            <option value="kepemimpinan" {{ old('jenis_pertanyaan', isset($pertanyaan) ? $pertanyaan->jenis_pertanyaan : '') == 'kepemimpinan' ? 'selected' : '' }}>Kepemimpinan</option>
                                                            <option value="perusahaan" {{ old('jenis_pertanyaan', isset($pertanyaan) ? $pertanyaan->jenis_pertanyaan : '') == 'perusahaan' ? 'selected' : '' }}>Perusahaan</option>
                                                        </select>
                                                    </div>
                                                    <button class="btn btn-primary">{{ isset($pertanyaan) ? 'Update' : 'Submit' }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- tab pertanyaan --}}
                                <div class="tab-pane fade" id="data-pertanyaan" role="tabpanel" aria-labelledby="data-pertanyaan-tab">
                                    <table id="table-pertanyaan" class="table table-striped table-bordered"
                                        cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jenis Pertanyaan</th>
                                                <th>List Pertanyaan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>

                                {{-- tab jawaban --}}
                                <div class="tab-pane fade" id="data-jawaban" role="tabpanel"
                                    aria-labelledby="data-jawaban-tab">
                                    <table id="table-jawaban" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jawaban</th>
                                                <th>Nilai Jawaban</th>
                                                {{-- <th>Aksi</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                {{-- end tab jawaban --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
$(document).ready(function() {
    // table survey
    const tableSurvey = $('#table-survey').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 5,
        responsive: true,
        ajax: {
            url: '{{ route('admin.survey.getDataSurvey') }}',
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                width: '1%',
            },
            {
                data: 'jenis_pertanyaan',
                name: 'jenis_pertanyaan',
                className: 'dt-head-center dt-body-left',
                width: '10%',
                    render: function(data, type, row) {
                        const jenisPertanyaanMap = {
                            'lingkungan_kerja': 'Lingkungan Kerja',
                            'pekerjaan': 'Pekerjaan',
                            'kepemimpinan': 'Kepemimpinan',
                            'perusahaan': 'Perusahaan',
                        };
                        return jenisPertanyaanMap[data];
                    }
            },
            {
                data: 'pertanyaan',
                name: 'pertanyaan',
                width: '30%'
            },
            {
                data: 'pilihan_jawaban',
                name: 'pilihan_jawaban',
                width: '20%',
            },
           {
                data: 'nilai_jawaban',
                name: 'nilai_jawaban',
                width: '10%',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                width: '12%',
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-info btn-edit" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#addSurveyModal">Edit</button>
                        <button class="btn btn-danger btn-delete" data-id="${row.id}">Delete</button>
                    `;
                },
            }
        ],
    });

    // table pertanyaan
    const tablePertanyaan = $('#table-pertanyaan').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 5,
        responsive: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('admin.survey.getData') }}',
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: 'dt-head-center dt-body-left',
                width: '1%',
            },
            {
                data: 'jenis_pertanyaan',
                name: 'jenis_pertanyaan',
                className: 'dt-head-center dt-body-left text-capitalize',
                render: function(data, type, row) {
                    const jenisPertanyaanMap = {
                        'lingkungan_kerja': 'Lingkungan Kerja',
                        'pekerjaan': 'Pekerjaan',
                        'kepemimpinan': 'Kepemimpinan',
                        'perusahaan': 'Perusahaan',
                    };
                    return jenisPertanyaanMap[data];
                },
            },
            {
                data: 'pertanyaan',
                name: 'pertanyaan',
                className: 'dt-head-center dt-body-left',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                width: '20%',
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-info btn-edit" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#addPertanyaanModal">Edit</button>
                        <button class="btn btn-danger btn-delete" data-id="${row.id}">Delete</button>
                    `;
                },
            }
        ],
    });

    // table jawaban
    const tableJawaban = $('#table-jawaban').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 5,
        responsive: true,
        autoWidth: false,
        ajax: {
            url: '{{ route('admin.survey.getDataJawaban') }}',
        },
        columns: [
            { 
                data: 'DT_RowIndex', 
                name: 'DT_RowIndex', 
                orderable: false, 
                searchable: false, 
                className: 'dt-head-center dt-body-left',
                width: '1%',
            },
            { 
                data: 'jawaban', 
                name: 'jawaban',
                className: 'dt-head-center dt-body-left',
                width: '30%'
            },
            { 
                data: 'nilai_jawaban', 
                name: 'nilai_jawaban',
                className: 'dt-head-center dt-body-left',
                width: '15%'
            },
        ],
        // pengaturan bahasa dalam styling datatable
        // language: {
        //     lengthMenu: 'Tampilkan _MENU_ data',
        //     zeroRecords: 'Tidak ada data',
        //     info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
        //     infoEmpty: 'Tidak ada data',
        //     infoFiltered: '(difilter dari _MAX_ data)',
        //     search: 'Cari:',
        //     paginate: {
        //         first: 'Awal',
        //         last: 'Akhir',
        //         next: 'Selanjutnya',
        //         previous: 'Sebelumnya'
        //     },
        // },
    });

    // Handle Add Data Button Click
    $('#addPertanyaanModal').on('show.bs.modal', function() {
        $('#formPertanyaan').val('');
        $('#jenis-pertanyaan').val('');
        $('#form-pertanyaan').attr('action', '{{ route('survey.store') }}'); // Set action for adding
        $('#form-pertanyaan').find('input[name="_method"]').remove(); // Ensure no hidden input for PUT
    });

    // Form Add
    $('#pertanyaanForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "{{ route('survey.store') }}",
            data: {
                pertanyaan: $('#formPertanyaan').val(),
                jenis_pertanyaan: $('#jenis-pertanyaan').val(),
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                swal("Sukses!", response.success, "success");
                $('#addPertanyaanModal').modal('hide');
                $('#formPertanyaan').val(''); // Reset form
                tablePertanyaan.ajax.reload(); // Reload tabel
            },
            error: function(xhr) {
                const errorMessage = xhr.status === 422 
                    ? xhr.responseJSON.errors.map(err => err.join(', ')).join('\n')
                    : 'Terjadi kesalahan: ' + xhr.responseJSON.error;

                swal("Terjadi Kesalahan!", errorMessage, "error");
            }
        });
    });

    // Form Edit
    $(document).on('click', '.btn-edit', function() {
        var id = $(this).data('id');
            $.ajax({
            url: '/survey/' + id + '/edit',
            method: 'GET',
            success: function(response) {
                if (response.error) {
                    Swal.fire({
                        title: 'Error',
                        text: response.error,
                        icon: 'error',
                        confirmButtonText: 'Tutup'
                    });
                } else {
                    // Populate the modal fields with response data
                    $('#formPertanyaan').val(response.pertanyaan);
                    $('#jenis-pertanyaan').val(response.jenis_pertanyaan);
                    $('#form-pertanyaan').attr('action', '/survey/' + id + '/update');
                    $('#form-pertanyaan').find('input[name="_method"]').remove(); // Remove old hidden input if exists
                    $('#form-pertanyaan').append('<input type="hidden" name="_method" value="PUT">');
                }
            },
            error: function(xhr) {
                Swal.fire({
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal memuat data pertanyaan!',
                    icon: 'error',
                    confirmButtonText: 'Tutup'
                });
            }
        });
    });

    // Delete Data
    $('#table-pertanyaan').on('click', '.btn-delete', function() {
    const id = $(this).data('id');
    Swal.fire({
        title: "Anda Yakin?",
        text: "Data ini akan dihapus secara permanen!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: `{{ url('survey/${id}/hapus-pertanyaan') }}`,
                    data: {
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {
                        Swal.fire("Sukses!", response.success, "success");
                        tablePertanyaan.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire("Terjadi kesalahan!", xhr.responseJSON.error, "error");
                    }
                });
            } else {
                Swal.fire("Penghapusan dibatalkan!");
            }
        });
    });
});
</script>