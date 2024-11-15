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
                    <h5 class="card-title fw-semibold mb-4">Data Buku</h5>
                    <a onclick="modalBuku()" class="btn btn-primary mb-3" style="display: inline-flex; align-items: center;">
                        <i class="ti ti-plus" style="font-size: 1.3rem; margin-right: 8px;"></i>
                        <span class="fw-semibold">Tambah</span>
                    </a>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle" id="dataBukuTable">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0 text-center" width="2%">No</th>
                                    <th class="border-bottom-0 text-center">Kategori</th>
                                    <th class="border-bottom-0 text-center">Judul</th>
                                    <th class="border-bottom-0 text-center">Penerbit</th>
                                    <th class="border-bottom-0 text-center">Deskripsi</th>
                                    <th class="border-bottom-0 text-center">Foto</th>
                                    <th class="border-bottom-0 text-center">Aksi</th>
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
    <div class="modal fade" id="modalBuku" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetForm()"></button>
                </div>
                <div class="modal-body">
                    <form method="post" class="form-horizontal" enctype="multipart/form-data" id="formBuku">
                        @csrf @method('POST')
                        <input type="hidden" name="id" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">Kategori</label>
                                    <select name="kategori" class="form-control select2">
                                        <option value="">--- Pilih Kategori ---</option>
                                        @foreach ($kategori as $item)
                                            <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger errorKategori"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">Judul Buku</label>
                                    <input type="text" name="judul" class="form-control">
                                    <small class="text-danger errorJudul"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">Penerbit</label>
                                    <input type="text" name="penerbit" class="form-control">
                                    <small class="text-danger errorPenerbit"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark">Deskripsi</label>
                                    <input type="text" name="deskripsi" class="form-control">
                                    <small class="text-danger errorDeskripsi"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
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
                dropdownParent: $('#modalBuku'),
                width: '100%'
            });

            var table = $('#dataBukuTable').DataTable({
                autoWidth: true,
                processing: true,
                serverSide: true,
                ajax: '{{ route('buku.index') }}',
                columns: [
                    {data: 'DT_RowIndex', searchable: false},
                    {data: 'kategori.kategori'},
                    {data: 'judul'},
                    {data: 'penerbit'},
                    {data: 'deskripsi'},
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

        function modalBuku() {
            resetForm();
            $('#modalBuku').modal('show');
            $('.modal-title').text('Tambah Data Buku');
        }

        function simpanData() {
            var data = new FormData($('#formBuku')[0]);
            var id = $('input[name="id"]').val();
            var url = id ? '/buku/' + id : '{{ route('buku.store') }}';

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: data,
                contentType: false,
                processData: false,
            })
            .done(function(response) {
                $('.error, .errorKategori, .errorJudul, .errorPenerbit, .errorDeskripsi, .errorFoto').text('');

                if (response.error) {
                    Object.keys(response.error).forEach(function(key) {
                        if (response.error[key]) {
                            $(`.error${capitalizeFirstLetter(key)}`).text(response.error[key][0]);
                        }
                    });
                }

                if (response.sukses) {
                    $('#formBuku')[0].reset();
                    $('#modalBuku').modal('hide');
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
            $('#modalBuku').modal('show');
            $('.modal-title').text('Edit Data Buku');
            $.ajax({
                url: '/buku/' + id + '/edit',
                type: 'GET',
                dataType: 'json',
            })
            .done(function(data) {
                $('input[name="id"]').val(id);
                $('select[name="kategori"]').val(data.data.kategori_id).trigger('change'); 
                $('input[name="_method"]').val('PATCH')
                $('input[name="judul"]').val(data.data.judul);
                $('input[name="penerbit"]').val(data.data.penerbit);
                $('input[name="deskripsi"]').val(data.data.deskripsi);
            });
        }

        function resetForm() {
            $('#formBuku')[0].reset();
            $('.error, .errorKategori, .errorJudul, .errorPenerbit, .errorDeskripsi, .errorFoto').text('');
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
                    $.get('/buku/' + id + '/delete', function(resp) {
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