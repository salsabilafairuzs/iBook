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
    </style>
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Data Departemen</h5>
                    <a onclick="modalDepartemen()" class="btn btn-primary mb-3"
                        style="margin-top: -10px; display: inline-flex; align-items: center;">
                        <i class="ti ti-plus" style="font-size: 1.3rem; margin-right: 8px; height: 1.5rem; width: 1rem;"></i>
                        <span class="fw-semibold">Tambah</span>
                    </a>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0" width="2%">
                                        No
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 text-center">Departemen</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0 text-center">Aksi</h6>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modal baru --}}
    <div class="modal fade" id="modalDepartemen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetForm()"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="form-horizontal" id="formDepartemen">
                    @csrf @method('POST')
                    <input type="text" name="id" value="" hidden>
                    <div class="form-group">
                        <label class="text-dark">Departemen</label>
                        <div class="mb-3">
                        <input type="text" name="departemen" class="form-control">
                            <small class="text-danger errorDepartemen"></small>
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
{{-- end modal baru --}}
@endsection
@section('script')
    <script>
        var table = $('.table').DataTable({
    autoWidth: true,
    processing: true,
    serverSide: true,
    ajax: '{{ route('departemen.index') }}',
    columns: [
        {data: 'DT_RowIndex', searchable: false},
        {data: 'departemen'},
        {data: 'edit', searchable: false},
        ],
        createdRow: function (row, data, dataIndex) {
            $(row).find('td:eq(1)').addClass('text-center');
        }
    });

        function modalDepartemen(){
            $('#modalDepartemen').modal('show')
            $('.modal-title').text('Tambah Data Departemen')
        }

        function simpanData() {
            var data = $('#formDepartemen').serialize();
            // alert(data)
            var id = $('input[name="id"]').val();

            if (id != '') {
                url = '/departemen/'+id
            } else {
                url = '{{ route('departemen.store') }}'
                $('input[name="_method"]').val('POST')
            }
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: data,
            })
            .done(function(data) {
                if (data.error) {
                    if (data.error.departemen) {
                        $('.errorDepartemen').text(data.error.departemen[0])
                    }
                }

                if (data.sukses == true) {
                    $('#formDepartemen')[0].reset()
                    $('#modalDepartemen').modal('hide')
                    Swal.fire({
                    position: 'middle',
                    icon: 'success',
                    type: 'success',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 800
                    }).then(()=>{
                        table.ajax.reload()
                    })
                }
            });
        }
        function editForm(id) {
            resetForm()
            $('#modalDepartemen').modal('show')
            $('.modal-title').text('Edit Data Departemen')
            $.ajax({
                url: '/departemen/'+id+'/edit',
                type: 'GET',
                dataType: 'json',
            })
            .done(function(data) {
                $('input[name="id"]').val(id)
                $('input[name="_method"]').val('PATCH')
                $('input[name="departemen"]').val(data.data.departemen)
            });
        }
        
        function resetForm() {
            $('#formDepartemen')[0].reset();
            $('.errorDepartemen').text('')
        }

        function hapus(id){
                Swal.fire({
                    title: 'Yakin Data Akan di Hapus ?',
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then(function (e){
                    if (e.value === true) {
                        $.get('/departemen/'+id+'/delete', function(resp){
                            if(resp.sukses == false){
                                $('#formDepartemen')[0].reset()
                                Swal.fire({
                                    showConfirmButton: false,
                                    type: 'error',
                                    icon: 'error',
                                    title: resp.message,
                                    timer: 800
                                }).then(()=>{
                                    table.ajax.reload()
                                })
                            }

                            if(resp.sukses == true){
                                $('#formDepartemen')[0].reset()
                                Swal.fire({
                                    showConfirmButton: false,
                                    type: 'success',
                                    icon: 'success',
                                    title: resp.message,
                                    timer: 800
                                }).then(()=>{
                                    table.ajax.reload()
                                })
                            }
                        })
                    } else {
                        return false;
                    }
                })
            }
    </script>
@endsection
