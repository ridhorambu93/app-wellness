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
                                    <button class="nav-link active" id="data-pertanyaan-tab" data-bs-toggle="tab" data-bs-target="#data-pertanyaan" type="button" role="tab" aria-controls="data-pertanyaan" aria-selected="true">Data Pertanyaan</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="data-jawaban-tab" data-bs-toggle="tab" data-bs-target="#data-jawaban" type="button" role="tab" aria-controls="data-jawaban" aria-selected="false">Data Jawaban</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="data-survey-tab" data-bs-toggle="tab" data-bs-target="#data-survey" type="button" role="tab" aria-controls="data-survey" aria-selected="false">Data Survey</button>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="card-body" id="cardTable bg-danger">
                            <div class="tab-content" id="myTabContent">
                                <div class="float-left m-3">
                                    <select id="jenis-pertanyaan" class="form-select">
                                        <option class="pilihan">Pilih Jenis Pertanyaan</option>
                                        <option value="all">Semua Jenis Pertanyaan</option>
                                        <option value="pekerjaan">Pekerjaan</option>
                                        <option value="lingkungan_kerja">Lingkungan Kerja</option>
                                        <option value="kepemimpinan">Kepemimpinan</option>
                                        <option value="perusahaan">Perusahaan</option>
                                    </select>
                                </div>

                                <div class="tab-pane fade show active" id="data-pertanyaan" role="tabpanel" aria-labelledby="data-pertanyaan-tab">
                                    <table id="table-pertanyaan" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
                                <div class="tab-pane fade" id="data-jawaban" role="tabpanel" aria-labelledby="data-jawaban-tab">
                                    <table id="table-jawaban" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead class="bg-danger">
                                            <tr>
                                                <th>No</th>
                                                <th>Jawaban</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                {{-- end tab jawaaban --}}

                                {{-- start tab survey --}}
                                <div class="tab-pane fade" id="data-survey" role="tabpanel" aria-labelledby="data-survey-tab">
                                    <table id="table-survey" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script type="text/javascript">
$(document).ready(function() {
        var table = $('#table-pertanyaan').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 3,
            responsive: true,
            ajax: {
                url: '{{ route('admin.survey.getData') }}',
                data: function(d) {
                    d.jenis_pertanyaan = $('#jenis-pertanyaan').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'pertanyaan', name: 'pertanyaan' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
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

        $('#jenis-pertanyaan').on('change', function() {
            if ($(this).val() !== '') {
                $('#cardTable').css('display', 'block')
                $('.pilihan').attr('disabled', true);
                $('#table-pertanyaan').show();
                table.draw();
            } else {
                $('#table-pertanyaan').hide();
            }
        });

        $('.nav-link').on('click', function() {
            if ($(this).attr('id') != 'data-pertanyaan-tab') {
                $('#jenis-pertanyaan').hide();
            } else {
                $('#jenis-pertanyaan').show();
            }
        });

    });    

</script>