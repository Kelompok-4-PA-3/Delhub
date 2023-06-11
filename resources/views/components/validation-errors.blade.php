@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-medium text-red-600">Gagal login</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            <i>Password atau email anda salah!</i>
            {{-- @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach --}}
        </ul>
    </div>
@endif
