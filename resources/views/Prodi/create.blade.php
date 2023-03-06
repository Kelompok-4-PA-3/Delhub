@extends('main')

@section('content')

<!-- Content area -->
<div class="content">

<form enctype="multipart/form-data" action="{{ route('prodi.store') }}" method="POST">
@csrf
<!-- Input fields -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Tambah Program Studi</h5>
    </div>

    <div class="card-body">
        <div class="mb-4">
            <!-- Default input -->
            <div class="row mb-3">
                <label class="col-form-label col-lg-3">Program Studi</label>
                <div class="col-lg-9">
                    <input type="text" name="nama" class="form-control" placeholder="Nama Program Studi">
                    @error('nama')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <!-- /default input -->

      <!-- Sizing -->
      <div class="row">
                <label class="col-form-label col-lg-3">Fakultas</label>
                <div class="col-lg-9">
                    <div class="mb-3">
                        <select class="form-select">
                            @foreach ($fakultas as $f)
                                <option value="{{  $f->nama }}">{{  $f->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- /sizing -->

 <!-- Sizing -->
 <div class="row">
                <label class="col-form-label col-lg-3">Status</label>
                <div class="col-lg-9">
                    <div class="mb-3">
                        <select class="form-select">
                            @foreach ($prodis as $prodi)
                                <option value="{{  $prodi->status }}">{{  $prodi->status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-end align-items-center">
                         <a href="{{ route('prodi.store') }}" class="btn btn-md btn-primary mb-3" id="f">KIRIM</a>
					</div>
                </div>
            </div>
            <!-- /sizing -->
        </div>
        </div>
    </div>
</div>
<!-- /input fields -->
</form>
</div>
<!-- /content area -->

@endsection
