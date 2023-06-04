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

@section('breadscrumb', Breadcrumbs::render('jadwal'))

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Daftar Jadwal</h5>
            <div class="ms-auto">
                <label class="form-check form-switch form-check-reverse">
                   <a href="/jadwal/create" class="btn btn-primary btn-sm fw-bold"><i class="ph-plus-circle"></i>&nbsp; TAMBAH JADWAL</a>
                </label>
            </div>
        </div>

        <div class="card-body pb-0">
        @if (session()->has('success'))
        <div class="alert alert-success alert-icon-start alert-dismissible fade show">
            <span class="alert-icon bg-success text-white">
                <i class="ph-check-circle"></i>
            </span>
            <span class="fw-semibold">Berhasil!</span> {{session('success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- /individual column searching (text inputs) -->
        <table class="table datatable-users">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Jadwal</th>
                    <th>URL</th>
                    <th class="text-center">Actions</th>
                </tr>
                <tr>
                    <th></th>
                    <th>Nama Jadwal</th>
                    <th>URL</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($jadwals as $jadwal)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$jadwal->nama_jadwal}}</td>
                    <td><a href="{{ $jadwal->url }}">{{ $jadwal->url }}</a></td>
                    <td class="text-center">
                        <div class="d-inline-flex">
                            <a href="#" class="text-body" data-bs-popup="tooltip" title="Ubah" data-bs-toggle="modal" data-bs-target="#modal_ubah{{$jadwal->id}}">
                                <i class="ph-pen"></i>
                            </a>
                            <a href="#" class="text-body mx-2" data-bs-popup="tooltip" title="hapus" data-bs-toggle="modal" data-bs-target="#modal_hapus{{$jadwal->id}}">
                                <i class="ph-trash"></i>
                            </a>
                            <a href="#" class="text-body" data-bs-popup="tooltip" title="Lihat">
                                <i class="ph-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>

                 <!-- Vertical form modal -->
                <div id="modal_ubah{{$jadwal->id}}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Jadwal</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <form action="/jadwal/{{$jadwal->id}}" method="post">
                                @csrf
                                @method('put')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="form-label">Nama Jadwal</label>
                                                <input type="text" name="nama_jadwal" value="{{$jadwal->nama_jadwal}}" class="form-control" required>
                                                @error('nama_jadwal')
                                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                                @enderror
                                            </div>
                                         </div>
                                        </div>
                                        <div class="mb-3">
                                                <label class="form-label">URL</label>
                                                <input type="text" name="url" value="{{$jadwal->url}}" class="form-control" required>
                                                @error('url')
                                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                                @enderror
                                            </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit <i class="ph-paper-plane-tilt ms-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /vertical form modal -->

                <!-- Delete Modal -->
                <div id="modal_hapus{{$jadwal->id}}" class="modal fade" tabindex="-1">
                    <div class="modal-dialog modal-xs">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="ph-warning text-warning"></i> Konfirmasi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                               Apakah anda yakin ingin menghapus data <span class="fw-semibold">{{$jadwal->nama_jadwal}}</span> ?
                            </div>

                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                <form action="/jadwal/{{$jadwal->id}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-primary">Ya</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
	            <!-- /Delete Modal -->

                @endforeach
            </tbody>
        </table>
        <br>
    </div>
    <!-- /individual column searching (text inputs) -->

		<!-- /individual column searching (text inputs) -->
        <div class="chart position-relative" id="traffic-sources"></div>
    </div>

    {{-- datatable_js --}}
	{{-- <script>
        $(document).ready(function() {
            $('.datatable-column-search-inputs thead tr:eq(1) th').not(':last-child').each(function () {
                const title = $(this).text();
                $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
            });

            $('#user-table').DataTable( {
                orderCellsTop: true,
                initComplete: function () {
                    this.api()
                        .columns()
                        .every(function (index) {
                            const that = this;

                            $('input').on('keyup change clear', function () {
                                if (that.search() !== this.value) {
                                    that.column($(this).parent().index() + ':visible').search(this.value).draw();
                                }
                            });
                        });
                },
                "ajax": "/data/user",
                "columns": [
                    { data: "nama_jadwal", name: "nama_jadwal" },
                    { data: "url", name: "url" },
                    {
                        data: "aksi",
                        render: function(data, type, row, meta){
                            return '<div class="row"><div class="col" data-toggle="modal" data-target="#detail(${row.id})" ><button  class="btn btn-outline-info"><span class="fas fa-eye"></button></div><div class="col"><a href="/pasar/edit/${row.id}" class="btn btn-outline-warning"><span class="fas fa-edit"></a></div><div class="col"><button class="btn btn-outline-danger" onclick="deleteDataPasar(${row.id})"><span class="fas fa-trash"></button></div></div>';
                        }
                    }
                ]
            });
    } );
	</script> --}}
@endsection