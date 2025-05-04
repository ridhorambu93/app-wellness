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
                                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addSurveyModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </button>
                                    <table id="table-survey" class="table table-striped table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Survey</th>
                                                <th>Deskripsi Survey</th>
                                                <th>Mulai</th>
                                                <th>Berakhir</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>

                                <div class="modal fade" id="addSurveyModal" tabindex="-1" aria-hidden="true" aria-labelledby="addSurveyModalLabel" data-bs-backdrop="static">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addSurveyModalLabel">
                                                    @isset($pertanyaan)
                                                        Edit Survey
                                                    @else
                                                        Tambah Survey
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
                                                {{-- <form action="{{ isset($pertanyaan) ? route('survey.update', $pertanyaan->id) : route('survey.store') }}" method="POST" id="form-pertanyaan">
                                                    @csrf
                                                    @if(isset($pertanyaan))
                                                        @method('PUT') <!-- Menggunakan method PUT untuk update -->
                                                    @endif
                                                    <div class="mb-3">
                                                        <label for="pertanyaan" class="form-label">Pertanyaan</label>
                                                        <textarea class="form-control" id="formPertanyaan" rows="3" name="pertanyaan" required>{{ old('pertanyaan', isset($pertanyaan) ? $pertanyaan->pertanyaan : '') }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="kategori-jawaban" class="form-label">Kategori</label>
                                                        <select id="kategoriJawaban" name="id_kategori_jawaban" class="form-select">
                                                            <option value="">-- Pilih Kategori --</option>
                                                        @foreach ($kategori_jawaban as $data)
                                                            <option value="<?= $data->id; ?>"><?= $data->nama_kategori; ?></option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <div id="listJawaban"></div>
                                                    </div>
                                                    <button class="btn btn-primary">{{ isset($pertanyaan) ? 'Update' : 'Submit' }}</button>
                                                </form> --}}

                                                <form method="POST" action="{{ route('survey.store') }}">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="pertanyaan">Nama Survey <span class="text-danger">*</span> </label>
                                                        <input type="text" class="form-control" id="namaSurvey" name="nama_survey" required>
                                                        {{-- {{ old('nama_survey') }} --}}
                                                        </input>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="pertanyaan">Deskripsi Survey <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" id="deskripsiSurvey" name="deskripsi_survey" required>
                                                            {{-- {{ old('deskripsi_survey') }} --}}
                                                        </textarea>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="tanggal_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" id="tanggalMulai" name="tanggal_mulai" /*value="{{ old('tanggal_mulai') }}"*/ required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="tanggal_berakhir">Tanggal Berakhir <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" id="tanggalAkhir" name="tanggal_akhir" /*value="{{ old('tanggal_akhir') }}"*/ required>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label for="status" class="form-label">Jenis Skala Pertanyaan</label>
                                                            <select id="Status" name="skala_jawaban" class="form-select">
                                                                <option>-- Pilih  Jenis Skala --</option>
                                                            @foreach ($kategori_jawaban as $data_kategori)
                                                                <option value="{{ $data_kategori->id }}">{{ $data_kategori->nama_kategori }}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select id="Status" name="status_survey" class="form-select">
                                                            <option>-- Pilih  Status --</option>
                                                            <option value="aktif">Aktif</option>
                                                            <option value="nonaktif">Nonaktif</option>
                                                        </select>
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary">Simpan</button>
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
                                                <th>List Pertanyaan</th>
                                                <th>Type Pertanyaan</th>
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

   $('#kategoriJawaban').on('change', function() {
    const id_kategori_jawaban = $(this).val();
    const skala_jawaban = @json($skala_jawaban);
    const selectedSkalaJawaban = skala_jawaban[id_kategori_jawaban];
    $('#listJawaban').html(`<div class="form-group">
            <label for="pilihan_jawaban">Pilihan Jawaban</label>
            ${selectedSkalaJawaban.map(skala => `
            <div>
                <input type="checkbox" id="pilihan_jawaban_${skala.id}" name="pilihan_jawaban[]" value="${skala.id}">
                <label for="pilihan_jawaban_${skala.id}">${skala.nama_skala}</label>
            </div>`).join('')}
        </div>`);
    });

    // table survey
    const tableSurvey = $('#table-survey').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 5,
        responsive: true,
        ajax: {
        url: '{{ route('admin.survey.getDataSurvey') }}',
            error: function(xhr, error, thrown) {
                // console.log(xhr.responseText);
                // console.log(tableSurvey.ajax.json());
            }
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                title: 'No',
                orderable: false,
                searchable: false,
                width: '1%',
            },
            {
                data: 'nama_survey',
                name: 'nama_survey',
                width: '20%'
            },
            {
                data: 'deskripsi_survey',
                name: 'deskripsi_survey',
                className: 'dt-head-center dt-body-left',
                width: '50%',
            },
            {
                data: 'tanggal_mulai',
                name: 'tanggal_mulai',
                width: '8%',
            },
            {
                data: 'tanggal_akhir',
                name: 'tanggal_akhir',
                width: '8%',
            },
            {
                data: 'status_survey',
                name: 'status_survey',
                className: 'dt-body-center',
                width: '3%',
                render: function(data, type, row) {
                var status = {
                        'aktif': '<span class="badge badge-success">Aktif</span>',
                        'nonaktif': '<span class="badge badge-danger">Nonaktif</span>'};
                        return status[data] || data;
                }
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                width: '8%',
                render: function(data, type, row) {
                    return `<button class="btn btn-sm rounded-lg btn-info btn-edit text-white bg-info-700 hover:bg-dark-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-info-600 dark:hover:bg-info-700 dark:focus:ring-info-800" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#addSurveyModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg>
                            </button>
                            <button class="btn btn-danger btn-sm rounded-lg btn-delete text-white bg-danger-700 hover:bg-dark-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-danger-600 dark:hover:bg-danger-700 dark:focus:ring-danger-800" data-id="${row.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                </svg>
                            </button>`;
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
            // {
            //     data: 'jenis_pertanyaan',
            //     name: 'jenis_pertanyaan',
            //     className: 'dt-head-center dt-body-left text-capitalize',
            //     render: function(data, type, row) {
            //         const jenisPertanyaanMap = {
            //             'lingkungan_kerja': 'Lingkungan Kerja',
            //             'pekerjaan': 'Pekerjaan',
            //             'kepemimpinan': 'Kepemimpinan',
            //             'perusahaan': 'Perusahaan',
            //         };
            //         return jenisPertanyaanMap[data];
            //     },
            // },
            {
                data: 'pertanyaan',
                name: 'pertanyaan',
                className: 'dt-head-center dt-body-left',
            },
            {
                data: 'type',
                name: 'type',
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