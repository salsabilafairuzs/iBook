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
                    <h5 class="card-title fw-semibold mb-4">Dashboard</h5>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="row">
                                  <div class="col-lg-12">
                                    <div class="card overflow-hidden">
                                      <div class="card-body p-4">
                                        <h5 class="card-title mb-9 fw-semibold">Jumlah Kategori</h5>
                                        <div class="row align-items-center">
                                          <div class="col-8">
                                            <h4 class="fw-semibold mb-3">{{ $kategori }}</h4>
                                            <div class="d-flex align-items-center mb-3">
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          <div class="col-lg-4">
                            <div class="row">
                              <div class="col-lg-12">
                                <div class="card overflow-hidden">
                                  <div class="card-body p-4">
                                    <h5 class="card-title mb-9 fw-semibold">Jumlah Buku</h5>
                                    <div class="row align-items-center">
                                      <div class="col-8">
                                        <h4 class="fw-semibold mb-3">{{ $buku }}</h4>
                                        <div class="d-flex align-items-center mb-3">
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
@endsection