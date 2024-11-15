@extends('template.template')
@section('konten')
    <style>
        .table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #dee2e6;
        }

        .table th,
        .table td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: center;
        }

        .table th {
            background-color: #f8f9fa;
        }

        .select2-container--bootstrap-5 .select2-selection {
            border: 1px solid #ced4da; 
            border-radius: 0.25rem; 
            height: calc(2.25rem + 2px); 
            box-shadow: none; 
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            line-height: 2.25rem; 
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
            height: 2.25rem; 
        }

        .select2-container--bootstrap-5 .select2-selection--multiple {
            border: 1px solid #ced4da; 
            border-radius: 0.25rem; 
            padding: 0.375rem; 
        }
    </style>
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Data Pegawai</h5>
                    <a onclick="modalPegawai()" class="btn btn-primary mb-3" style="display: inline-flex; align-items: center;">
                        <i class="ti ti-plus" style="font-size: 1.3rem; margin-right: 8px;"></i>
                        <span class="fw-semibold">Tambah</span>
                    </a>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle" id="dataPegawaiTable">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0" width="2%">No</th>
                                    <th class="border-bottom-0">NIP</th>
                                    <th class="border-bottom-0">Nama</th>
                                    <th class="border-bottom-0">Departemen</th>
                                    <th class="border-bottom-0">Jabatan</th>
                                    <th class="border-bottom-0">Jenis Kelamin</th>
                                    <th class="border-bottom-0">Tanggal Lahir</th>
                                    <th class="border-bottom-0">Email</th>
                                    <th class="border-bottom-0">No Telepon</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Foto</th>
                                    <th class="border-bottom-0">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalPegawai" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetForm()"></button>
                </div>
                <div class="modal-body">
                    <form method="post" class="form-horizontal" enctype="multipart/form-data" id="formPegawai">
                        @csrf @method('POST')
                        <input type="hidden" name="id" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">NIP</label>
                                    <input type="text" name="nip" class="form-control">
                                    <small class="text-danger errorNIP"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">Nama</label>
                                    <input type="text" name="nama" class="form-control">
                                    <small class="text-danger errorNama"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">Departemen</label>
                                    <select name="departemen" class="form-control select2">
                                        <option value="">--- Pilih Departemen ---</option>
                                        @foreach ($departemen as $item)
                                            <option value="{{ $item->id }}">{{ $item->departemen }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger errorDepartemen"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">Jabatan</label>
                                    <select name="jabatan" class="form-control select2">
                                        <option value="">--- Pilih Jabatan ---</option>
                                        @foreach ($jabatan as $item)
                                            <option value="{{ $item->id }}">{{ $item->jabatan }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger errorJabatan"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control">
                                        <option value="Laki-laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <small class="text-danger errorKelamin"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">Tgl Lahir</label>
                                    <input type="text" name="tgl_lahir" class="form-control datepicker">
                                    <small class="text-danger errorLahir"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">Email</label>
                                    <input type="text" name="email" class="form-control">
                                    <small class="text-danger errorEmail"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">No Telepon</label>
                                    <input type="text" name="telepon" class="form-control">
                                    <small class="text-danger errorTelepon"></small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">Status</label>
                                    <select name="status" class="form-control select2">
                                        <option value="">--- Pilih Status ---</option>
                                        <option value="Kontrak">Kontrak</option>
                                        <option value="Karyawan-Tetap">Karyawan Tetap</option>
                                        <option value="Part-Time">Part-Time</option>
                                        <option value="Magang">Magang</option>
                                    </select>
                                    <small class="text-danger errorStatus"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">Foto</label>
                                    <input type="file" name="foto" class="form-control">
                                    <small class="text-danger errorFoto"></small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" onclick="resetForm()">Batal</button>
                    <button type="button" class="btn btn-success btn-sm" onclick="simpanData()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Baru --}}
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#modalPegawai'),
                width: '100%'
            });

            var table = $('#dataPegawaiTable').DataTable({
                autoWidth: true,
                processing: true,
                serverSide: true,
                ajax: '{{ route('pegawai.index') }}',
                columns: [
                    {data: 'DT_RowIndex', searchable: false},
                    {data: 'NIP'},
                    {data: 'nama'},
                    {data: 'departemen.departemen'},
                    {data: 'jabatan.jabatan'},
                    {data: 'jenis_kelamin'},
                    {data: 'tgl_lahir'},
                    {data: 'email'},
                    {data: 'telepon'},
                    {data: 'status'},
                    {data: 'foto2'},
                    {data: 'edit', searchable: false},
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).find('td').each(function(index) {
                        if (index > 0) { 
                            $(this).addClass('text-center');
                        }
                    });
                }
            });
        });

        function modalPegawai() {
            resetForm();
            $('#modalPegawai').modal('show');
            $('.modal-title').text('Tambah Data Pegawai');
        }

        function simpanData() {
            var data = new FormData($('#formPegawai')[0]);
            var id = $('input[name="id"]').val();
            var url = id ? '/pegawai/' + id : '{{ route('pegawai.store') }}';

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: data,
                contentType: false,
                processData: false,
            })
            .done(function(response) {
                $('.errorNIP, .errorNama, .errorDepartemen, .errorJabatan, .errorKelamin, .errorLahir, .errorEmail, .errorTelepon, .errorStatus, .errorFoto').text('');

                if (response.error) {
                    Object.keys(response.error).forEach(function(key) {
                        if (response.error[key]) {
                            $(`.error${capitalizeFirstLetter(key)}`).text(response.error[key][0]);
                        }
                    });
                }

                if (response.sukses) {
                    $('#formPegawai')[0].reset();
                    $('#modalPegawai').modal('hide');
                    Swal.fire({
                        position: 'middle',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 800
                    }).then(() => {
                        // table.ajax.reload();
                        location.reload();
                    });
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Error:', textStatus, errorThrown);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan saat mengirim data!',
                });
            });
        }

        function editForm(id) {
            resetForm();
            $('#modalPegawai').modal('show');
            $('.modal-title').text('Edit Data Pegawai');
            $.ajax({
                url: '/pegawai/' + id + '/edit',
                type: 'GET',
                dataType: 'json',
            })
            .done(function(data) {
                $('input[name="id"]').val(id);
                $('input[name="nip"]').val(data.data.NIP);
                $('input[name="_method"]').val('PATCH')
                $('input[name="nama"]').val(data.data.nama);
                $('select[name="departemen"]').val(data.data.departemen_id).trigger('change'); 
                $('select[name="jabatan"]').val(data.data.jabatan_id).trigger('change'); 
                $('select[name="jenis_kelamin"]').val(data.data.jenis_kelamin);
                $('input[name="tgl_lahir"]').val(data.data.tgl_lahir);
                $('input[name="email"]').val(data.data.email);
                $('input[name="telepon"]').val(data.data.telepon);
                $('select[name="status"]').val(data.data.status).trigger('change'); 
            });
        }

        function resetForm() {
            $('#formPegawai')[0].reset();
            $('.errorNIP, .errorNama, .errorDepartemen, .errorJabatan, .errorKelamin, .errorLahir, .errorEmail, .errorTelepon, .errorStatus, .errorFoto').text('');
        }

        function hapus(id) {
            Swal.fire({
                title: 'Yakin Data Akan di Hapus?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.get('/pegawai/' + id + '/delete', function(resp) {
                        Swal.fire({
                            icon: resp.sukses ? 'success' : 'error',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 800
                        }).then(() => {
                            // table.ajax.reload();
                            location.reload();
                        });
                    });
                }
            });
        }
    </script>
@endsection