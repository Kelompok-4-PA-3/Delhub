@extends('main')

@push('select_js')
    <script src="{{asset('../../../assets/js/jquery/jquery.min.js')}}"></script>
	<script src="{{asset('../../../assets/js/vendor/forms/selects/select2.min.js')}}"></script>
	<script src="{{asset('../../../assets/demo/pages/form_layouts.js')}}"></script>
@endpush

@section('content')

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Buat Regulasi</h5>
        </div>
        <div class="card-body">
            <div>
                <small><i class="text-muted">Anda belum membuat regulasi!</i></small>
            </div>
            <table class="" cellpadding="5">
                <tr>
                    <td><small class="fw-semibold">Jumlah Bimbingan</small></td>
                    <td>  </td>
                    <td> 10 </td>
                </tr>
                    <tr><td></td></tr>
                <tr>
                    <td><small class="text-muted">Rincian</small></td>
                    <td><small class="text-muted">Minimum</small></td>
                </tr>
                <tr >
                    <td><small class="fw-semibold">Proposal</small></td>
                    <td class="text-start"> 5 </td>
                </tr>
                <tr>
                    <td><small class="fw-semibold">Sidang</small></td>
                    <td> 5 </td>
                </tr>
            </table>
        </div>
    </div>

         
@endsection