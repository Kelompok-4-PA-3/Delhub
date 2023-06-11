<table class="table  w-100 scrollable-table table-bordered" style="">
    <thead>
        <tr>
            <th rowspan="2">Kelompok</th>
            <th rowspan="2">NIM</th>
            <th class="" style="width: 300px;" rowspan="2">Mahasiswa</th>
            @foreach ($penilaian->role_group_penilaian as $pkp)
                <th class="text-center" colspan="{{ $penilaian->komponen_penilaian->count() }}">
                    {{ $pkp->role_group->nama }}</th>
            @endforeach
            <th class="" rowspan="2">Nilai akhir</th>
        </tr>
        <tr>
            @foreach ($penilaian->role_group_penilaian as $pgp)
                @foreach ($penilaian->komponen_penilaian as $pkp)
                    <th>
                        <a href="" data-bs-toggle="modal" data-bs-target="#detail_komponen_{{ $pkp->id }}">
                            N{{ $loop->iteration }}
                        </a><br>
                        <small class="fw-light">{{ $pkp->bobot }} %</small>
                    </th>

                    <!-- Modal with h5 -->
                    <div id="detail_komponen_{{ $pkp->id }}" class="modal fade" tabindex="-1">
                        <div class="modal-dialog modal-xs">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Penilaian {{ $penilaian->nama_poin }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <small class="fw-bold">Komponen penilaian : </small>
                                        <p>{!! $pkp->nama_komponen !!}</p>
                                        <hr>
                                        <small class="fw-bold">Bobot : </small>
                                        <p>{!! $pkp->bobot !!} %</p>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /modal with h5 -->
                @endforeach
            @endforeach
        </tr>
    </thead>
    <tbody>
        {{-- @foreach ($krs->kelompok as $kk)
            <tr>
                <td rowspan="{{$kk->kelompok_mahasiswas->count() + 1}}"><small>{{$kk->nama_kelompok}}</small></td>
                @foreach ($kk->kelompok_mahasiswas as $kkm)
                @php
                    $total_nilai = 0;
                @endphp
                <tr>
                    <td class=""><small>{{$kkm->mahasiswa->user->nama}}</small></td>
                    @foreach ($krs->poin_penilaian as $kpp)
                        @php
                            $total_nilai += $kpp->nilai_mahasiswa($kkm->mahasiswa->nim, $kk->id)->where('approved_status',true)->sum('nilai') * ($kpp->bobot / 100);
                        @endphp
                        <td>
                            {{number_format($kpp->nilai_mahasiswa($kkm->mahasiswa->nim, $kk->id)->where('approved_status',true)->sum('nilai'), 2, '.', '')}}
                        </td>
                    @endforeach
                    <td class=" bg-warning bg-opacity-10 text-center fw-semibold text-warning">
                        {{number_format($total_nilai, 2, '.', '')}}
                    </td>
                </tr>
                @endforeach
            </tr>
        @endforeach --}}
        @foreach ($krs->kelompok_mahasiswas->where('deleted_at', null) as $kk)
            <tr>
                <td class="fw-semibold"><small>{{ $kk->nama_kelompok }}</small></td>
                <td><small>{{ $kk->nim }}</small></td>
                {{-- <td><small>{{$kk->kelompok_mahasiswas}}</small></td> --}}
                @foreach ($kk->kelompok_mahasiswas->where('nim', $kk->nim) as $kkm)
                    @php
                        $total_nilai = 0;
                    @endphp
                    <td><small>{{ $kkm->mahasiswa->user->nama }}</small></td>
                    @foreach ($penilaian->role_group_penilaian as $pgp)
                        @if ($penilaian->komponen_penilaian->count() > 0)
                            @foreach ($penilaian->komponen_penilaian as $pkp)
                                @php
                                    $nilai_komponen_mahasiswa = $pkp
                                        ->detail_nilai_mahasiswa()
                                        ->where('nilai_mahasiswas.kelompok_id', $kk->kelompok_id)
                                        ->where('komponen_id', $pkp->id)
                                        ->where('nim', $kkm->mahasiswa->nim)
                                        // ->where('role_group_id', $pgp->id)
                                        ->where('role_kelompoks.role_group_id', $pgp->role_group->id);
                                @endphp
                                {{-- {{$nilai_komponen_mahasiswa}} --}}
                                {{-- @foreach ($nilai_komponen_mahasiswa->get() as $nkm)
                                <td>{{$nkm->nilai / ($pkp->bobot / 100)}}</td>
                            @endforeach --}}

                                <td>
                                    {{-- {{ $nilai_komponen_mahasiswa->pluck('role_kelompoks.role_group_id') }}
                                {{ $pgp->role_group_id }} --}}
                                    {{-- {{ $nilai_komponen_mahasiswa->first()->nilai_mahasiswa->role_kelompok->role_group->nama}} --}}

                                    @if ($nilai_komponen_mahasiswa->first() != null)
                                        @php
                                            $total_nilai += $nilai_komponen_mahasiswa->first()->nilai * ($pkp->bobot / 100);
                                        @endphp
                                        {{ $nilai_komponen_mahasiswa->first()->nilai / ($pkp->bobot / 100) }}
                                    @else
                                        -
                                    @endif
                                </td>
                            @endforeach
                        @else
                            <td><small></small><i>nilai belum tersedia</i></td>
                        @endif
                    @endforeach
                    <td class=" bg-warning bg-opacity-10 text-center fw-semibold text-warning">
                        {{ number_format($penilaian->nilai_mahasiswa($kkm->mahasiswa->nim, $kk->id)->where('approved_status', true)->sum('nilai'),2,'.','') }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>

</table>
