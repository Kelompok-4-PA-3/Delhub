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
            <div class="card-body">
               <table class="table">
                    <tr>
                        <th>Kelompok</th>
                        <th>Mahasiswa</th>
                        @foreach ($krs->krs_role as $krl)
                            <th>{{$krl->nama}}<br><small class="fw-light">{{$krl->bobot}} %</small></th>
                        @endforeach
                    </tr>
                    @foreach ($krs->kelompok as $kk)
                        <tr>
                            <td rowspan="{{$kk->kelompok_mahasiswa->count() + 1}}">{{$kk->nama_kelompok}}</td>
                            @foreach ($kk->kelompok_mahasiswa as $kkm)
                            <tr>
                                <td>{{$kkm->mahasiswa->user->nama}}</td>
                                {{-- @php
                                    $nilai_mahasiswa = 
                                @endphp --}}
                                @foreach ($krs->krs_role as $krl)
                                    <td>
                                        @if ($kkm->mahasiswa->hasil_nilai_mahasiswa($krl->id, $kk->id)->sum('nilai'))
                                            @php
                                                $total = 0;
                                                foreach ($kkm->mahasiswa->hasil_nilai_mahasiswa($krl->id, $kk->id) as $nilai_per_komponen) {
                                                    $nilai = $nilai_per_komponen->nilai * ($nilai_per_komponen->poin_penilaian->bobot / 100);
                                                    $total += $nilai;
                                                    $nilai = 0;
                                                }
                                            @endphp
                                            {{-- {{number_format($total / $kkm->mahasiswa->hasil_nilai_mahasiswa($krl->id, $kk->id)-count(), 2, '.', '')}} --}}
                                            {{$total}}
                                        @else 
                                            0
                                        @endif
                                    </td>
                                @endforeach
                                {{-- <td>{{$kkm->mahasiswa->nilai_mahasiswa($ro)}}</td> --}}
                            </tr>
                            @endforeach
                            {{-- @foreach ($kk->role_kelompok as $kkr)
                                <td rowspan="{{$kk->kelompok_mahasiswa->count() + 1}}">{{$kkr->dosen->nama_singkat}}</td>
                            @endforeach --}}
                        </tr>
                    @endforeach
                    {{-- @foreach ($krs->krs_role as $krl)
                        <td>{{$krl->}}</td>
                    @endforeach --}}
                    {{-- <tr>    
                        <td rowspan="3">kelompok1</td>
                        <td>
                            <tr>
                                <td>dasdas</td>
                            </tr>
                            <tr>
                                <td>dasdas</td>
                            </tr>
                        </td>
                    </tr>
                    <tr>
                        <td>kelompok1</td>
                    </tr>
                    <tr>
                        <td>kelompok1</td>
                    </tr> --}}
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
