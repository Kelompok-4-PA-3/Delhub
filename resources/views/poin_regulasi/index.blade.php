@extends('main')

@section('title')
    <title>Manajemen Poin Regulasi</title>
@endsection

@push('datatable_js')
    <script src="{{ asset('/assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/datatables_api.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/form_select2.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
@endpush

@section('breadscrumb')
    <span class="breadcrumb-item active py-2"><i class="ph-squares-four"></i>&nbsp;Manajemen Regulasi</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Tambah Poin Regulasi</h5>
            <div class="ms-auto">
                <label class="form-check form-switch form-check-reverse">
                    <a class="btn btn-primary btn-sm fw-bold" data-bs-toggle="offcanvas" data-bs-target="#panel_footer"><i class="ph-plus-circle"></i>&nbsp; TAMBAH KATEGORI PROYEK</a>
                </label>
            </div>
        </div>

        <div class="card-body pb-0">

            @if (session()->has('success'))
                <div class="alert alert-success alert-icon-start alert-dismissible fade show">
                    <span class="alert-icon bg-success text-white">
                        <i class="ph-check-circle"></i>
                    </span>
                    <span class="fw-semibold">Berhasil!</span> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @elseif(session()->has('failed'))
                <div class="alert alert-success alert-icon-start alert-dismissible fade show">
                    <span class="alert-icon bg-success text-white">
                        <i class="ph-check-circle"></i>
                    </span>
                    <span class="fw-semibold">Gagal!</span> {{ session('failed') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- /individual column searching (text inputs) -->
            <table class="table datatable-users w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Poin</th>
                        <th>Jenis Regulasi</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Nama</th>
                        <th>Poin</th>
                        <th>Jenis Regulasi</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($poin_regulasi as $pr)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pr->nama }}</td>
                            <td>{{ $pr->poin }}</td>
                            <td>{{ $pr->kategori_proyek->nama }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <a href="#" class="text-body" data-bs-popup="tooltip" title="Ubah"
                                        data-bs-toggle="offcanvas" data-bs-target="#form-edit{{ $pr->id }}">
                                        <i class="ph-pen"></i>
                                    </>
                                    <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus"
                                        data-bs-toggle="modal" data-bs-target="#modal_hapus{{ $pr->id }}">
                                        <i class="ph-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Delete Modal -->
                        <div id="modal_hapus{{ $pr->id }}" class="modal fade" tabindex="-1">
                            <div class="modal-dialog modal-xs">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        Apakah anda yakin ingin menghapus data <span
                                            class="fw-semibold">{{ $pr->nama }}</span> ?
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <form action="/poin_regulasi/{{ $pr->id }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-primary">Ya</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Delete Modal -->

                        <!-- Sticky footer -->
                        <div id="form-edit{{ $pr->id }}" class="offcanvas offcanvas-end" tabindex="-1">
                            <div class="offcanvas-header border-bottom">
                                <h5 class="offcanvas-title fw-semibold">Edit Poin Regulasi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                            </div>

                            <div class="offcanvas-body">
                                <form action="/poin_regulasi/{{ $pr->id }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <div class="mt-2">
                                                <label class="form-label">Nama</label>
                                                <input type="text" name="nama_edit"
                                                    value="{{ old('nama_edit', $pr->nama) }}" class="form-control" required
                                                    placeholder="Masukkan name disini">
                                                @error('nama_edit')
                                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mt-2">
                                                <label class="form-label">Poin</label>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                        <i class="ph-minus ph-sm"></i>
                                                    </button>
                                                    <input class="form-control form-control-sm form-control-number text-center" type="number" name="poin" value="{{old('poin',$pr->poin)}}" min="0">
                                                    <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                        <i class="ph-plus ph-sm"></i>
                                                    </button>
                                                </div>
                                                @error('poin')
                                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mt-2">
                                                <label class="form-label">Kategori Proyek</label>
                                                <select type="text" name="kategori_id" class="form-control" required placeholder="Masukkan kategori_id disini">
                                                    <option value="">Pilih kategori proyek</option>
                                                    @foreach ($kategori_proyek as $kp)
                                                        <option value="{{$kp->id}}" {{$kp->id == $pr->kategori_id ? 'selected' : ''}}>{{$kp->nama}}</option>
                                                    @endforeach
                                                </select>
                                                @error('nama')
                                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            </div>
                                     </div>
                                    <div class="border-top p-3">
                                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /sticky footer -->

                    @endforeach
                </tbody>
            </table>
            <br>
        </div>
        <div class="chart position-relative" id="traffic-sources"></div>
    </div>



    <!-- Sticky footer -->
    <div id="panel_footer" class="offcanvas offcanvas-end" tabindex="-1">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-semibold">Tambah Poin Regulasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body">
            <form action="/poin_regulasi" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="mt-2">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" class="form-control" required placeholder="Masukkan nama disini">
                            @error('nama')
                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Poin</label>
                            <div class="d-flex">
                                <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                    <i class="ph-minus ph-sm"></i>
                                </button>
                                <input class="form-control form-control-sm form-control-number text-center" type="number" name="poin" value="{{old('poin',0)}}" min="0">
                                <button type="button" class="btn btn-sm btn-light btn-icon" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                    <i class="ph-plus ph-sm"></i>
                                </button>
                            </div>
                            @error('poin')
                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label class="form-label">Kategori Proyek</label>
                            <select type="text" name="kategori_id" value="{{ old('kategori_id') }}" class="form-control" required placeholder="Masukkan kategori_id disini">
                                <option value="">Pilih kategori proyek</option>
                                @foreach ($kategori_proyek as $kp)
                                    <option value="{{$kp->id}}">{{$kp->nama}}</option>
                                @endforeach
                            </select>
                            @error('nama')
                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="border-top p-3">
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection
