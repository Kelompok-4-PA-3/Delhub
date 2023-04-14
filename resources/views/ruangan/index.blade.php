@extends('main')

@section('title')
    <title>Manajemen Ruangan</title>
@endsection

@push('datatable_js')
    <script src="{{ asset('/assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/datatables_api.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/form_select2.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
@endpush

@section('breadscrumb', Breadcrumbs::render('pengguna'))

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Tambah Ruangan</h5>
            <div class="ms-auto">
                <label class="form-check form-switch form-check-reverse">
                    <a class="btn btn-primary btn-sm fw-bold" data-bs-toggle="offcanvas" data-bs-target="#panel_footer"><i
                            class="ph-plus-circle"></i>&nbsp; TAMBAH RUANGAN</a>
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
            <table class="table datatable-users">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Active</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Nama</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ruangans as $r)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $r->nama }}</td>
                            <td>{{ $r->active }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <a href="#" class="text-body" data-bs-popup="tooltip" title="Ubah"
                                        data-bs-toggle="offcanvas" data-bs-target="#form-edit{{ $r->id }}">
                                        <i class="ph-pen"></i>
                                    </a>
                                    <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus"
                                        data-bs-toggle="modal" data-bs-target="#modal_hapus{{ $r->id }}">
                                        <i class="ph-trash"></i>
                                    </a>
                                    <a href="#" class="text-body" data-bs-popup="tooltip" data-bs-toggle="modal"
                                        data-bs-target="#modal_small" title="Lihat">
                                        <i class="ph-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Small modal -->
                        <div id="modal_small" class="modal fade" tabindex="-1">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail ruangan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <b class="fw-semibold">Nama : </b>
                                        <p>{{ $r->nama }}</p>
                                        <b class="fw-semibold">Active : </b>
                                        <p>{{ $r->active }}</p>

                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /small modal -->

                        <!-- Delete Modal -->
                        <div id="modal_hapus{{ $r->id }}" class="modal fade" tabindex="-1">
                            <div class="modal-dialog modal-xs">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        Apakah anda yakin ingin menghapus data <span
                                            class="fw-semibold">{{ $r->nama }}</span> ?
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <form action="/ruangan/{{ $r->id }}" method="post">
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
                        <div id="form-edit{{ $r->id }}"
                            class="offcanvas offcanvas-end  {{-- @error('nama') show @enderror @error('guard_name_edit') show @enderror" --}} tabindex="-1">
                            {{-- @if ($errors->any()) show @endif --}}
                            <div class="offcanvas-header border-bottom">
                                <h5 class="offcanvas-title fw-semibold">Edit Ruangan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                            </div>

                            <div class="offcanvas-body">
                                <form action="/ruangan/{{ $r->id }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <div>
                                            </div>
                                            <div>
                                                <label class="form-label">Nama</label>
                                                <input type="text" name="nama"
                                                    value="{{ old('nama', $r->nama) }}" class="form-control" required
                                                    placeholder="Masukkan nama disini">
                                                @error('nama')
                                                    <div class="text-danger text-sm p-1"><i
                                                            class="ph-warning-circle"></i>{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                            </div>
                            <div class="border-top p-3">
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </div>
                            </form>
                        </div>
                        <!-- /sticky footer -->
                    @endforeach
                </tbody>
            </table>
            <br>
        </div>
        <div class="chart position-relative" id="traffic-sources"></div>
    </div>

    <!-- Vertical form modal -->
    <div id="modal_tambah_ruangans" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Ruangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="/ruangan" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="nama" value="{{ old('nama') }}"
                                        class="form-control" required>
                                    @error('nama')
                                        <div class="text-danger text-sm p-1"><i
                                                class="ph-warning-circle"></i>{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit <i
                                class="ph-paper-plane-tilt ms-2"></i></button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- /vertical form modal -->

    <!-- Sticky footer -->
    <div id="panel_footer" class="offcanvas offcanvas-end  " tabindex="-1">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-semibold">Tambah ruangan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body">
            <form action="/ruangan" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <div>
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" class="form-control"
                                required placeholder="Masukkan nama disini">
                            @error('nama')
                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>


                    </div>
                </div>
        </div>
        <div class="border-top p-3">
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </div>
        </form>
    </div>
    <!-- /sticky footer -->

    {{-- <select id="mySelect">
        <option value="option1">Option 1</option>
        <option value="option2">Option 2</option>
        <option value="option3">Option 3</option>
      </select> --}}

    <script>
        var selectElem = document.getElementById("guard_name_select");
        var selectPermission = document.getElementById("permission_select");
        var options = selectPermission.options;

        // var selectElem_edit = document.getElementById("guard_name_select_edit");
        // var selectPermission_edit = document.getElementById("permission_select_edit");
        // var options_edit = selectPermission_edit.options;

        selectElem.onchange = function() {
            var selectedValue = selectElem.options[selectElem.selectedIndex].value;
            for (let i = 0; i < options.length; i++) {
                if (options[i].className == selectedValue) {
                    options[i].removeAttribute('disabled');
                } else {
                    options[i].setAttribute('disabled', '');
                    options[i].selected = false;
                }
            }
            console.log(selectedValue);
        }

        // selectElem_edit.onchange = function() {
        // var selectedValue = selectElem_edit.options[selectElem_edit.selectedIndex].value;
        //   for (let i = 0; i < options_edit.length; i++) {
        //         if(options_edit[i].className == selectedValue){
        //            options_edit[i].removeAttribute('disabled');
        //         }else{
        //             options_edit[i].setAttribute('disabled','');
        //             options_edit[i].selected = false;
        //         }
        //   }
        //   console.log(selectedValue);
        // }
    </script>
@endsection
