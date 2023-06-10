@extends('main')
   
@section('title')
    <title>Hasil Nilai {{$krs->kategori->nama_mk}}</title>
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

@section('breadscrumb')
    @if (Auth::user()->dosen->nidn == $krs->dosen_mk || Auth::user()->dosen->nidn == $krs->dosen_mk_2)
        <a href="/koordinator/myproject" class="breadcrumb-item py-2"><i class="ph-house me-2"></i> Koordinator</a>
        <a href="/koordinator/proyeksaya/{{$krs->id}}" class="breadcrumb-item py-2">{{$krs->kategori->nama_singkat}}</a>
    @endif
    <span class="breadcrumb-item active py-2">Hasil Penilaian</span>
@endsection

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                <h5 class="py-sm-2 my-sm-1">Nilai Mahasiswa</h5><br>
                <div class="mt-2 mt-sm-0 ms-sm-auto">
                    @if ($pembimbing_kelompok != NULL)
                        <a class="fw-semibold" href="/kelompok/{{$pembimbing_kelompok}}"><i class="ph-arrow-circle-left"></i> Kembali </a>
                    @endif
                </div>
            </div>  
            <div class="card-body table-responsive">
               <table class="table datatable-hasil-nilai w-100 scrollable-table table-bordered">
                    <thead>
                        <tr>
                            <th>Kelompok</th>
                            <th>NIM</th>
                            <th class="" style="width: 300px;">Mahasiswa</th>
                            @foreach ($krs->poin_penilaian as $kpp)
                                <th>
                                    @if ($pembimbing_kelompok != NULL)
                                    <form action="/krs/{{$krs->id}}/hasil_penilaian/penilaian/{{$kpp->id}}" method="get">
                                        <input type="hidden" name="kelompok" value="{{$pembimbing_kelompok}}">
                                        <button class="text-primary bg-transparent border-0 fw-semibold p-0" class="link" href="/krs/{{$krs->id}}/hasil_penilaian/penilaian/{{$kpp->id}}">{{$kpp->nama_poin}}</button>
                                    </form>
                                    @else
                                        <a class="link" href="/krs/{{$krs->id}}/hasil_penilaian/penilaian/{{$kpp->id}}">{{$kpp->nama_poin}}</a><br>
                                    @endif
                                    <small class="fw-light">{{$kpp->bobot}} %</small></th>
                            @endforeach
                            <th >Nilai akhir</th>
                        </tr>
                        <tr>
                            <th>Kelompok</th>
                            <th>NIM</th>
                            <th class="" style="width: 300px;">Mahasiswa</th>
                            @foreach ($krs->poin_penilaian as $kpp)
                                <th>{{$kpp->nama_poin}}</th>
                            @endforeach
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $krs_hasil_penilaian = $krs->kelompok_mahasiswa->where('deleted_at',NULL);
                            if ($pembimbing_kelompok != NULL) {
                                $krs_hasil_penilaian = $krs->kelompok_mahasiswa->where('deleted_at',NULL)->where('kelompok_id',$pembimbing_kelompok);
                            }
                        @endphp
                        @foreach ($krs_hasil_penilaian as $kk)
                            <tr>
                                <td class="fw-semibold"><small>{{$kk->nama_kelompok}}</small></td>
                                <td><small>{{$kk->nim}}</small></td>
                                @foreach ($kk->kelompok_mahasiswa->where('nim',$kk->nim) as $kkm)
                                    @php
                                        $total_nilai = 0;
                                    @endphp
                                    <td><small>{{$kkm->mahasiswa->user->nama}}</small></td>
                                    @foreach ($krs->poin_penilaian as $kpp)
                                        @php
                                            $total_nilai += $kpp->nilai_mahasiswa($kkm->mahasiswa->nim, $kk->id)->where('approved_status',true)->sum('nilai') * ($kpp->bobot / 100);
                                        @endphp
                                        <td>
                                            {{number_format($kpp->nilai_mahasiswa($kkm->mahasiswa->nim, $kk->id)->where('approved_status',true)->sum('nilai'), 2, '.', '')}}
                                            {{-- {{$kpp->nilai_mahasiswa($kkm->mahasiswa->nim, $kk->id)->where('approved_status',true)->pluck('id')}} --}}
                                        </td>
                                    @endforeach 
                                    <td>
                                        {{number_format($total_nilai, 2, '.', '')}}
                                    </td>
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
