@extends('main')
   
@section('title')
    <title>Manajemen Mahasiswa</title>
@endsection

@push('datatable_js')
    <script src="{{asset('/assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('/assets/demo/pages/datatables_api.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js')}}"></script>
    <script src="{{asset('/assets/demo/pages/extra_fab.js')}}"></script>
    <script src="{{asset('/assets/demo/pages/form_select2.js')}}"></script>
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script src="{{asset('/assets/js/vendor/editors/ckeditor/ckeditor_classic.js')}}"></script>
    <script src="{{asset('/assets/demo/pages/editor_ckeditor_classic.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/forms/selects/select2.min.js')}}"></script>
@endpush

@section('breadscrumb', Breadcrumbs::render('pengguna'))

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                <h5 class="py-sm-2 my-sm-1">Nilai Mahasiswa</h5><br>
                <div class="mt-2 mt-sm-0 ms-sm-auto">
                </div>
            </div>  
            <div class="card-body table-responsive">
               <table class="table datatable-hasil-nilai w-100 scrollable-table table-bordered" style="">
                    <thead>
                        <tr>
                            <th>Kelompok</th>
                            <th class="" style="width: 300px;">Mahasiswa</th>
                            @foreach ($krs->poin_penilaian as $kpp)
                                <th><a class="link" href="/krs/10/hasil_penilaian/{{$kpp->id}}">{{$kpp->nama_poin}}</a><br><small class="fw-light">{{$kpp->bobot}} %</small></th>
                            @endforeach
                            <th>Nilai akhir
                                <div class="mt-1">
                                    <form action="">
                                        <button class="badge bg-success fw-light border-0">approve</button>
                                    </form>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($krs->kelompok as $kk)
                            <tr>
                                <td rowspan="{{$kk->kelompok_mahasiswa->count() + 1}}"><small>{{$kk->nama_kelompok}}</small></td>
                                @foreach ($kk->kelompok_mahasiswa as $kkm)
                                @php
                                    $total_nilai = 0;
                                @endphp
                                <tr>
                                    <td class=""><small>{{$kkm->mahasiswa->user->nama}}</small></td>    
                                    @foreach ($krs->poin_penilaian as $kpp)
                                        @php
                                            $total_nilai += $kpp->nilai_mahasiswa($kkm->mahasiswa->nim, $kk->id)->sum('nilai') * ($kpp->bobot / 100);
                                        @endphp
                                        <td>
                                            {{number_format($kpp->nilai_mahasiswa($kkm->mahasiswa->nim, $kk->id)->sum('nilai'), 2, '.', '')}}
                                        </td>
                                    @endforeach
                                    <td class=" bg-warning bg-opacity-10 text-center fw-semibold text-warning">
                                        {{number_format($total_nilai, 2, '.', '')}}
                                    </td>
                                </tr>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>

               </table>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card">
             
            </div>
        </div>


        <div class="col-xl-4">

        </div>

    </div>

@endsection
