@extends('main')

@push('select_js')
    <script src="{{asset('/assets/js/jquery/jquery.min.js')}}"></script>
	<script src="{{asset('/assets/js/vendor/forms/selects/select2.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/form_layouts.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('/assets/demo/pages/datatables_api.js')}}"></script>
    <script src="{{asset('/assets/js/vendor/tables/datatables/extensions/buttons.min.js')}}"></script>
@endpush

@section('content')

        {{-- <div class="row"> --}}

            <div class="card">
                <div class="card-header">
                    <h5>Data Detail Bimbingan</h5>
                </div>
                <div class="p-2">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><small> Nama Kelompok </small></th>
                                <th><small> Jumlah Bimbingan </small></th>
                                {{-- @if ($regulasi->seminar > 0) --}}
                                    <th class="text-center"><small> Seminar ({{$regulasi->seminar}})</small></th>
                                {{-- @endif --}}
                                {{-- @if($regulasi->prasidang > 0) --}}
                                    <th class="text-center"><small> Proposal ({{$regulasi->proposal}})</small></th>
                                {{-- @endif --}}
                                {{-- @if($regulasi->proposal > 0) --}}
                                    <th class="text-center"><small> Prasidang ({{$regulasi->prasidang}})</small></th>
                                {{-- @endif --}}
                                {{-- @if($regulasi->sidang > 0) --}}
                                    <th class="text-center"><small> Sidang ({{$regulasi->sidang}})</small></th>
                                    <th class="text-center"><small> Action </small></th>
                                {{-- @endif --}}
                            </tr>
                        </thead>
                        <tbody> 
                            @foreach ($kelompok as $k)

                                @php
                                    $seminar = false;
                                    $proposal = false;
                                    $prasidang = false;
                                    $sidang = false;
                                    $bimbingan = $k->bimbingan->count();
                                @endphp
                                <tr>
                                    <td><small> {{$k->nama_kelompok}} </small></td>
                                    <td><small> {{$k->bimbingan->count()}} </small></td>
                                    @if($regulasi->seminar > 0)
                                        @if ($bimbingan > 0)
                                            @php
                                                $bimbingan -= $regulasi->seminar;
                                            @endphp
                                             @if ($bimbingan >= 0)
                                                <td class="text-center"><small> <i class="ph-check text-success"></i> </small></td>
                                               @php
                                                    $seminar = true;
                                               @endphp
                                            @else
                                                <td class="text-center"><small> <b class="text-muted">{{$bimbingan + $regulasi->seminar }}</b> /  {{$regulasi->seminar}}</small></td>
                                                @php
                                                    $bimbingan = 0;   
                                                @endphp
                                            @endif
                                        @else
                                            <td class="text-center"><small> <b class="text-muted">{{$bimbingan}}</b> /  {{$regulasi->seminar}}</small></td>
                                        @endif
                                    @else
                                        <td class="text-center"><small><i class="ph-minus"></i></small></td>
                                    @endif
                                    @if($regulasi->proposal > 0)
                                        @if ($bimbingan > 0)    
                                            @php
                                                $bimbingan -= $regulasi->proposal;
                                            @endphp
                                            @if ($bimbingan >= 0)
                                                <td class="text-center"><small> <i class="ph-check text-success"></i> </small></td>
                                                @php
                                                    $proposal = true;
                                                @endphp
                                            @else
                                                <td class="text-center"><small> <b class="text-muted">{{$bimbingan + $regulasi->proposal }}</b> /  {{$regulasi->proposal}}</small></td>
                                                @php
                                                    $bimbingan = 0;   
                                                @endphp
                                            @endif
                                        @else
                                            <td class="text-center"><small> <b class="text-muted">{{$bimbingan}}</b> /  {{$regulasi->proposal}}</small></td>
                                        @endif
                                    @else
                                        <td class="text-center"><small><i class="ph-minus"></i></small></td>
                                    @endif
                                    @if($regulasi->prasidang > 0)
                                        @if ($bimbingan > 0)
                                            @php
                                                $bimbingan -= $regulasi->prasidang;
                                            @endphp
                                             @if ($bimbingan >= 0)
                                                <td class="text-center"><small> <i class="ph-check text-success"></i> </small></td>
                                                @php
                                                    $prasidang = true;
                                                @endphp
                                            @else
                                                <td class="text-center"><small> <b class="text-muted">{{$bimbingan + $regulasi->prasidang }}</b> /  {{$regulasi->prasidang}}</small></td>
                                                @php
                                                    $bimbingan = 0;   
                                                @endphp
                                            @endif
                                        @else
                                             <td class="text-center"><small> <b class="text-muted">{{$bimbingan}}</b> /  {{$regulasi->prasidang}}</small></td>
                                        @endif
                                    @else
                                        <td class="text-center"><small><i class="ph-minus"></i></small></td>
                                    @endif
                                    @if($regulasi->sidang > 0)
                                        @if ($bimbingan > 0)
                                            @php
                                                $bimbingan -= $regulasi->sidang;
                                            @endphp
                                            @if ($bimbingan >= 0)
                                                <td class="text-center"><small> <i class="ph-check text-success"></i></small></td>
                                                @php
                                                    $sidang = true;
                                                @endphp
                                            @else
                                                <td class="text-center"><small> <b class="text-muted">{{$bimbingan + $regulasi->sidang }}</b> /  {{$regulasi->sidang}}</small></td>
                                                @php
                                                    $bimbingan = 0;   
                                                @endphp
                                            @endif
                                        @else
                                            <td class="text-center"><small> <b class="text-muted">{{$bimbingan}}</b> /  {{$regulasi->sidang}}</small></td>
                                        @endif
                                    @else
                                        <td class="text-center"><small><i class="ph-minus"></i></small></td>
                                    @endif
                                    <td>
                                        {{-- <form action="">
                                            @if (!$seminar && !$proposal && !$prasidang && !$sidang)
                                                <h4 class="text-center">🔒</h4>
                                            @else
                                                <form action="">
                                                    <div>
                                                        @if ($seminar)
                                                            <a class="btn btn-sm btn-success">Seminar</a>
                                                        @endif
                                                        
                                                        <a class="btn btn-sm btn-success">Proposal</a>
                                                        <a class="btn btn-sm btn-success">Prasidang</a>
                                                        <a class="btn btn-sm btn-success">Sidangr</a>

                                                    </div>
                                                </form>
                                            @endif
                                        </form> --}}
                                    </td>
                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        <script>
            $create = document.getElementById('btn-buat-regulasi');
            $index = document.getElementById('btn-regulasi');
            $index.style.display = "none";
            $create.style.display = "block";
            console.log($create);
            $create.onclick = (e) => {
                $index.style.display = 'block';
                e.target.style.display = 'none';
            }
            $index.onclick = (e) => {
                $create.style.display = 'block';
                e.target.style.display = 'none';
            }
        </script>
@endsection