@extends('main')

@push('select_js')
    <script src="{{asset('../../../assets/js/jquery/jquery.min.js')}}"></script>
	<script src="{{asset('../../../assets/js/vendor/forms/selects/select2.min.js')}}"></script>
	<script src="{{asset('../../../assets/demo/pages/form_layouts.js')}}"></script>
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Tambah Pengguna</h5>
        </div>

        <div class="card-body pb-0">
            <div class="card">
                <div class="card-body border-top">
                    <form action="/users" method="post">
                        @csrf
                        <fieldset class="mb-3">
                            {{-- <legend class="fs-base fw-bold border-bottom pb-2 mb-3">Mandatory fields</legend> --}}

                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input name="nama" type="text" class="form-control" placeholder="Masukkan nama disini" required>
                                @error('nama')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input name="username" type="text" class="form-control" placeholder="Masukkan username disini">
                                @error('username')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input name="email" type="text" class="form-control" placeholder="Masukkan email disini">
                                @error('email')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input name="password" type="password" class="form-control" placeholder="Masukkan password disini">
                                @error('password')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password disini">
                                @error('password_confirmation')
                                    <div class="text-danger text-sm p-1"><i class="ph-warning-circle"></i>{{$message}}</div>
                                @enderror
                            </div>
                        </fieldset>

                        {{-- <fieldset class="mb-3">
                            <legend class="fs-base fw-bold border-bottom pb-2 mb-3">Optional fields</legend>

                            <div class="mb-3">
                                <label class="form-label">Your state:</label>
                                <select class="form-control form-control-select2">
                                    <optgroup label="Alaskan/Hawaiian Time Zone">
                                        <option value="AK">Alaska</option>
                                        <option value="HI">Hawaii</option>
                                    </optgroup>
                                    <optgroup label="Pacific Time Zone">
                                        <option value="CA">California</option>
                                        <option value="NV">Nevada</option>
                                        <option value="WA">Washington</option>
                                    </optgroup>
                                    <optgroup label="Mountain Time Zone">
                                        <option value="AZ">Arizona</option>
                                        <option value="CO">Colorado</option>
                                        <option value="WY">Wyoming</option>
                                    </optgroup>
                                    <optgroup label="Central Time Zone">
                                        <option value="AL">Alabama</option>
                                        <option value="AR">Arkansas</option>
                                        <option value="KY">Kentucky</option>
                                    </optgroup>
                                    <optgroup label="Eastern Time Zone">
                                        <option value="CT">Connecticut</option>
                                        <option value="DE">Delaware</option>
                                        <option value="FL">Florida</option>
                                    </optgroup>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gender:</label>
                                <div>
                                    <label class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="gender" checked>
                                        <span class="form-check-label">Male</span>
                                    </label>

                                    <label class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" name="gender">
                                        <span class="form-check-label">Female</span>
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Your avatar:</label>
                                <input type="file" class="form-control">
                                <div class="form-text text-muted">Accepted formats: gif, png, jpg. Max file size 2Mb</div>
                            </div>
                        </fieldset> --}}

                        {{-- <fieldset>
                            <legend class="fs-base fw-bold border-bottom pb-2 mb-3">Additional information</legend>

                            <div class="mb-3">
                                <label class="form-label">Tags:</label>
                                <select multiple="multiple" data-placeholder="Enter tags" class="form-control form-control-select2-icons">
                                    <option value="slack" data-icon="slack-logo" selected>Slack</option>
                                    <option value="instagram" data-icon="instagram-logo" selected>Instagram</option>
                                    <option value="telegram" data-icon="telegram-logo">Telegram</option>
                                    <option value="whatsapp" data-icon="whatsapp-logo">Whatsapp</option>
                                    <option value="twitter" data-icon="twitter-logo">Twitter</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Your message:</label>
                                <textarea rows="3" cols="3" class="form-control" placeholder="Enter your message here"></textarea>
                            </div>
                        </fieldset> --}}

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Kirim <i class="ph-paper-plane-tilt ms-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="chart position-relative" id="traffic-sources"></div>
    </div>
@endsection