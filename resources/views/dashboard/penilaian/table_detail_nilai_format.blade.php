    <table>
            <tr>
                <th rowspan="2">Kelompok</th>
                <th rowspan="2">NIM</th>
                <th rowspan="2">Mahasiswa</th>
                @foreach ($penilaian->role_group_penilaian as $pkp)
                    <th colspan="{{$penilaian->komponen_penilaian->count()}}">{{$pkp->role_group->nama}}</th>
                @endforeach
                <th rowspan="2">Nilai akhir</th>
            </tr>
            <tr>
                @foreach ($penilaian->role_group_penilaian as $pgp)
                    @foreach ($penilaian->komponen_penilaian as $pkp)
                    <th>
                        N{{$loop->iteration}}<br>{{$pkp->bobot}} %
                    </th>
                        
                    @endforeach
                @endforeach
            </tr>
        
            @foreach ($krs->kelompok_mahasiswa as $kk)
                <tr>
                    <td>{{$kk->nama_kelompok}}</td>
                    <td>{{$kk->nim}}</td>
                    @foreach ($kk->kelompok_mahasiswa->where('nim',$kk->nim) as $kkm)
                        @php
                            $total_nilai = 0;
                        @endphp
                        <td>{{$kkm->mahasiswa->user->nama}}</td>
                        @foreach ($penilaian->role_group_penilaian as $pgp)
                            @if ($penilaian->komponen_penilaian->count() > 0)
                                
                            @foreach ($penilaian->komponen_penilaian as $pkp)
                                @php
                                    $nilai_komponen_mahasiswa = $pkp->detail_nilai_mahasiswa()
                                        ->where('nilai_mahasiswas.kelompok_id',$kk->kelompok_id)
                                        ->where('komponen_id', $pkp->id)
                                        ->where('nim', $kkm->mahasiswa->nim)
                                        ->where('role_kelompoks.role_group_id', $pgp->role_group->id);
                                @endphp
    
                                <td>
                                    @if ( $nilai_komponen_mahasiswa->first() != NULL)
                                        @php
                                            $total_nilai += $nilai_komponen_mahasiswa->first()->nilai * ($pkp->bobot / 100);    
                                        @endphp
                                        {{  $nilai_komponen_mahasiswa->first()->nilai / ($pkp->bobot / 100) }}
                                    @else
                                        -
                                    @endif
                                </td>
    
                            @endforeach
                            @else 
                               <td>nilai belum tersedia</td>
                            @endif
                        @endforeach
                        <td>
                            {{number_format( $penilaian->nilai_mahasiswa($kkm->mahasiswa->nim, $kk->id)->where('approved_status',true)->sum('nilai'), 2, '.', '')}}
                        </td>
                    @endforeach
                </tr>
            @endforeach
    
    </table>

