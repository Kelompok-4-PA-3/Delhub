@extends('main')

@section('title')
    <title>Kelola Jadwal</title>
@endsection

@push('datatable_js')
    <script src="{{ asset('/assets/js/vendor/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/datatables_api.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js') }}"></script>
    <script src="{{ asset('/assets/demo/pages/form_select2.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
@endpush

@section('breadscrumb', Breadcrumbs::render('jadwal'));

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Tambah Jadwal</h5>
            <div class="ms-auto">
                <!-- <label class="form-check form-switch form-check-reverse">
                    <a class="btn btn-primary btn-sm fw-bold" href="{{ route('jadwal.create') }}">
                        <i class="ph-plus-circle"></i>&nbsp;
                        Kelola Jadwal
                    </a>
                </label> -->

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
                    <th>Kelompok</th>
                    <th>Judul</th>
                    <th>Pembimbing I</th>
                    <th>Pembimbing II</th>
                    <th>Penguji I</th>
                    <th>Penguji II</th>
                    <th>Ruangan</th>
                    <th>Jadwal</th>
                    <th>Pukul</th>
                    <th class="text-center">Actions</th>
                </tr>
                <tr>
                    <th></th>
                    <th>Kelompok</th>
                    <th>Judul</th>
                    <th>Pembimbing I</th>
                    <th>Pembimbing II</th>
                    <th>Penguji I</th>
                    <th>Penguji II</th>
                    <th>Ruangan</th>
                    <th>Jadwal</th>
                    <th>Pukul</th>
                    <th></th>
                </tr>
            </thead>
                @foreach($kelompoks as $k)
                @if($k->pembimbings != NULL || $k->pengujis != NULL)
                <tbody>
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$k->nama_kelompok}}</td>
                    <td>{{$k->topik}}</td>
                    <td>{{$k->pembimbings->pembimbing_1_dosen->user->nama}}</td>
                    <td>{{$k->pembimbings->pembimbing_2_dosen->user->nama}}</td>
                    <td>{{$k->pengujis->penguji_1_dosen->user->nama}}</td>
                    <td>{{$k->pengujis->penguji_2_dosen->user->nama}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-center">
                        <div class="d-inline-flex">
                        <a href="#" class="text-body" data-bs-popup="tooltip" title="Tambah Jadwal"
                            data-bs-toggle="offcanvas" data-bs-target="#form-edit{{ $k->id }}">
                            <i class="ph-pen"></i>
                        </a>
                            <!-- <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus" data-bs-toggle="modal" data-bs-target="#modal_hapus{{$k->id}}">
                                <i class="ph-trash"></i>
                            </a> -->
                        </div>
                    </td>
                </tr>
                </tbody>
                @endif

                <!-- Sticky footer -->
                <div id="form-edit{{ $k->id }}"
                            class="offcanvas offcanvas-end" tabindex="-1">

                            <div class="offcanvas-header border-bottom">
                                <h5 class="offcanvas-title fw-semibold">Tambah Jadwal</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                            </div>

                            <div class="offcanvas-body">
                                <form action="/jadwal/{{ $k->id }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Kelompok</label>
                                                <input name="nama_kelompok" type="name" class="form-control" disabled value="{{$k->nama_kelompok}}">
                                                @error('tanggal')
                                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Jadwal</label>
                                                <input name="tanggal" type="date" class="form-control" placeholder="Masukkan tanggal" required>
                                                @error('tanggal')
                                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Waktu</label>
                                                <input name="waktu" type="time" class="form-control" placeholder="Masukkan waktu" required>
                                                @error('waktu')
                                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Ruangan</label>
                                                <select class="form-select" name="ruangan_id">
                                                    @foreach ($ruangans as $r)
                                                        <option value="{{  $r->id }}">{{  $r->nama }}</option>
                                                    @endforeach
                                                </select>
                                                @error('ruangan')
                                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                                @enderror
                                            </div>


                                        </div>
                                    </div>
                            </div>

                            <div class="border-top p-3">
                                <button type="submit" class="btn btn-primary w-100">Submit</button><br><br>
                                <button type="submit" class="btn btn-success w-100">Publish</button>
                            </div>

                            </form>
                        </div>
                        <!-- /sticky footer -->
                @endforeach
            </table>
        </div>

        </div>

<script>
    var selectAll = document.getElementById('select-all');
    var checkboxes = document.getElementsByName('jadwal[]');

    selectAll.onclick = function() {
        checkboxes.forEach((checkbox) => {
            checkbox.checked = this.checked;
        });
    };
</script>
@endsection
