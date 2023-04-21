<body style="margin: 30px auto;" data-new-gr-c-s-check-loaded="14.1101.0" data-gr-ext-installed="">
    <table style="width: 100%">
        <tbody>
            <tr>
                <td>
                    <table style="background-color: #f6f7fb; width: 100%">
                        <tbody>
                            <tr>
                                <td>
                                    <table style="width: 650px; margin: 0 auto; margin-bottom: 30px">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <img alt="Logo"
                                                        src="https://demo.interface.club/limitless/demo/template/assets/images/logo_icon.svg" />
                                                </td>
                                                <td style="text-align: right; color:#999">
                                                    <span>Permintaan Bimbingan</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width: 650px; margin: 0 auto; background-color: #fff; border-radius: 8px">
                        <tbody>
                            <tr>
                                <td style="padding: 30px">
                                    <div style="padding-bottom: 30px; font-size: 17px;">
                                        Permintaan bimbingan anda telah {{ $status->value }}
                                        <br>
                                        olen dosen pembimbing pada tanggal
                                        {{ \Carbon\Carbon::now()->format('d F Y') }}.
                                    </div>
                                    <div style="padding-bottom: 30px; font-size: 17px;">
                                        <a href="{{ route('bimbingan.show', $bimbingan->id) }}"
                                            class="btn btn-primary">Klik
                                            disini</a> untuk melihat detail permintaan bimbingan anda.
                                    </div>
                                    <div style="padding-bottom: 10px">Kind regards,
                                        <br>The Delhub Team.
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width: 650px; margin: 0 auto; margin-top: 30px">
                        <tbody>
                            <tr style="text-align: center">
                                <td>
                                    <p style="color: #999; margin-bottom: 0">Indonesia</p>
                                    </p>
                                    <p style="color: #999; margin-bottom: 0">Copyright ©
                                        <a href="{{ config('app.url') }}" rel="noopener" target="_blank">Delhub</a>.
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
