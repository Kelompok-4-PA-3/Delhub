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
                                                    <img alt="Logo" height="75px" width="75px"
                                                        src="https://upload.wikimedia.org/wikipedia/commons/e/e2/Del_Institute_of_Technology_Logo.png" />
                                                </td>
                                                <td style="text-align: left; color:#999">
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
                                        Dear kelompok {{ $bimbingan->kelompok->nama_kelompok }}<br><br>
                                        Permintaan bimbingan dari kelompok Anda telah di- {{ $status }}
                                        oleh dosen pembimbing pada tanggal {{ \Carbon\Carbon::now()->format('d F Y') }}.
                                        <br>
                                        Berikut detail bimbingan Anda.<br>
                                        Tanggal : {{ \Carbon\Carbon::parse($bimbingan->tanggal)->format('d F Y') }}<br>
                                        Pukul : {{ \Carbon\Carbon::parse($bimbingan->jam)->format('H:i') }}<br>
                                        Ruangan : {{ $bimbingan->ruangan->nama }}<br>
                                        Deskripsi : {{ $bimbingan->description }}<br>

                                    </div>

                                    <a href="{{ url('/') }}">
                                        <button
                                            style="font-size: 15px;
                                        background: #6495ED; color: white; border: white 3px solid; border-radius: 5px;
                                        padding: 12px 20px; margin-left: 150px;">Kunjungi
                                            Website</button></a>


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
