@extends('main')

@section('title')
    <title>Manajemen Konfigurasi</title>
@endsection

@push('datatable_js')
    <script src="{{ asset('/assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/datatables_api.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/form_select2.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
@endpush

@section('breadscrumb')
    <span href="/krs" class="breadcrumb-item active py-2"><i class="ph-list-dashes"></i>&nbsp;Manajemen Konfigurasi</span>
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Tambah Konfigurasi</h5>
            <div class="ms-auto">
                <label class="form-check form-switch form-check-reverse">
                    <a class="btn btn-primary btn-sm fw-bold" data-bs-toggle="offcanvas" data-bs-target="#panel_footer"><i class="ph-plus-circle"></i>&nbsp; TAMBAH KONFIGURASI</a>
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
                        <th>Tahun Aktif</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Tahun Aktif</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($config as $c)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="">{{ $c->tahun_aktif}}</td>
                            <td >{{$c->semester == '1' ? 'Gasal' : 'Genap'}}</td>
                            <td>
                                @if(!$c->active)
                                    <span class="badge bg-danger bg-opacity-10 text-danger">Nonactive</span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success">Active</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex ms-auto p-2">
                                    <div class="btn-group dropstart">
                                        <a href="#" class="text-body" data-bs-popup="tooltip" title="Ubah status" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ph-gear"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <div class="p-3">
                                            @if (!$c->active)
                                                <div class="px-1">
                                                    <i>
                                                        Apakah anda yakin ingin mengaktifkan konfigurasi ini?
                                                    </i>
                                                    <form action="/config/update/status/{{$c->id}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="status" value="active">
                                                        <button class="btn btn-sm btn-success border-0">Active</button>
                                                    </form>
                                                </div>
                                            @else
                                                <div class="px-1">
                                                    <i>
                                                        Apakah anda yakin ingin menonaktifkan konfigurasi ini?
                                                    </i>
                                                    <form action="/config/update/status/{{$c->id}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="status" value="nonactive">
                                                        <button class="btn btn-sm btn-danger border-0">Nonactive</button>
                                                    </form>
                                                </div>
                                            @endif
                                            </div>
                                        </ul>
                                    </div>&nbsp;&nbsp;
                                    <a href="#" class="text-body" data-bs-popup="tooltip" title="Ubah"
                                        data-bs-toggle="offcanvas" data-bs-target="#form-edit{{ $c->id }}">
                                        <i class="ph-pen"></i>
                                    </a>
                                    <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus"
                                        data-bs-toggle="modal" data-bs-target="#modal_hapus{{ $c->id }}">
                                        <i class="ph-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Delete Modal -->
                        <div id="modal_hapus{{ $c->id }}" class="modal fade" tabindex="-1">
                            <div class="modal-dialog modal-xs">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        Apakah anda yakin ingin menghapus data <span
                                            class="fw-semibold">{{ $c->name }}</span> ?
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                        <form action="/config/{{ $c->id }}" method="post">
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
                        <div id="form-edit{{ $c->id }}"
                            class="offcanvas offcanvas-end  {{-- @error('name_edit') show @enderror @error('guard_name_edit') show @enderror" --}} tabindex="-1">
                            {{-- @if ($errors->any()) show @endif --}}
                            <div class="offcanvas-header border-bottom">
                                <h5 class="offcanvas-title fw-semibold">Edit Role</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                            </div>

                            <div class="offcanvas-body">
                                <form action="/config/{{$c->id}}" method="post">
                                    @method('put')
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <div>
                                                <label class="form-label">Tahun Aktif</label>
                                                <select name="tahun_aktif" id="" class="form-control" required> 
                                                    <option value="">Pilih tahun aktif</option>
                                                    @foreach ($years as $y)     
                                                        <option value="{{$y}}" {{old('tahun_aktif',$y) == $c->tahun_aktif ? 'selected' : ''}} >{{$y}}</option>
                                                    @endforeach
                                                </select>
                                                @error('tahun-aktif')
                                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div>
                                                <label class="form-label">Semester</label>
                                                <select name="semester" class="form-control" id="semester_select" required placeholder="Masukkan guard name disini">
                                                    <option value="">Pilih Semester</option>
                                                    <option @if (old('semester',$c->semester) == '1') selected @endif value="1">Gasal</option>
                                                    <option @if (old('semester',$c->semester) == '2') selected @endif value="2">Genap</option>
                                                </select>
                                                @error('semester')
                                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}</div>
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
    <div id="panel_footer" class="offcanvas offcanvas-end  " tabindex="-1">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-semibold">Tambah Konfigurasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body">
            <form action="/config" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <div>
                            <label class="form-label">Tahun Aktif</label>
                            <select name="tahun_aktif" id="" class="form-control" required> 
                                <option value="">Pilih tahun aktif</option>
                                @foreach ($years as $y)      
                                    <option {{old('tahun_aktif') == $y ? 'selected' : ''}} value="{{$y}}">{{$y}}</option>
                                @endforeach
                            </select>
                            {{-- <input type="text" name="name" value="{{ old('name') }}" class="form-control" required placeholder="Masukkan name disini"> --}}
                            @error('tahun-aktif')
                                <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label class="form-label">Semester</label>
                            <select name="semester" class="form-control" id="semester_select" required placeholder="Masukkan guard name disini">
                                <option value="">Pilih Semester</option>
                                <option {{ old('semester') == '1' ? 'selected' : '' }} value="1">Gasal</option>
                                <option {{ old('semester') == '2' ? 'selected' : '' }} value="2">Genap</option>
                            </select>
                            @error('semester')
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

    {{-- <select id="mySelect">
        <option value="option1">Option 1</option>
        <option value="option2">Option 2</option>
        <option value="option3">Option 3</option>
      </select> --}}

    <script>
        var selectElem = document.getElementById("guard_name_select");
        var selectPermission = document.getElementById("permission_select");
        var options = selectPermission.options;

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
    </script>
@endsection
