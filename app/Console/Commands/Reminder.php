<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Reminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get all request bimbingan today with status approved
        // remind all mahasiswa and dosen that have request bimbingan 10 minutes or less before the request time
        $requests = DB::table('requests')
            ->join('kelompoks', 'requests.kelompok_id', '=', 'kelompoks.id')
            ->join('role_kelompoks', 'kelompoks.id', '=', 'role_kelompoks.kelompok_id')
            ->join('role_group_kelompoks', 'role_kelompoks.role_group_id', '=', 'role_group_kelompoks.id')
            ->join('kategori_roles', 'role_group_kelompoks.kategori_id', '=', 'kategori_roles.id')
            ->where('kategori_roles.nama', 'pembimbing')
            ->whereDate('requests.waktu', Carbon::today())
            ->where('requests.status', 5)
            ->where('requests.deleted_at', null)
            ->where('requests.is_done', false)
            ->where('kelompoks.deleted_at', null)
            ->where('role_kelompoks.deleted_at', null)
            ->where('role_group_kelompoks.deleted_at', null)
            ->where('kategori_roles.deleted_at', null)
            ->select('requests.*')
            ->get();

        // convert to eloquent model
        $requests = \App\Models\Request::hydrate($requests->toArray())->load('ruangan', 'reference', 'kelompok.mahasiswas.user', 'kelompok.pembimbings.user')->sortByDesc('waktu');

        $tokens = [];
        foreach ($requests as $request) {
            $waktu = Carbon::parse($request->waktu);
            $waktu->subMinutes(10);
            $now = Carbon::now();
            // remind all mahasiswa and dosen that have request bimbingan 10 minutes or less before the request time
            if ($waktu->lessThanOrEqualTo($now)) {
                sendPushNotification('Pengingat Bimbingan', 'Bimbingan akan dimulai dalam 10 menit lagi di ruangan ' . $request->ruangan->nama, $request->kelompok->mahasiswas->pluck('user.firebase_token')->toArray(), $request);
                sendPushNotification('Pengingat Bimbingan', 'Bimbingan akan dimulai dalam 10 menit lagi di ruangan ' . $request->ruangan->nama, $request->kelompok->pembimbings->pluck('user.firebase_token')->toArray(), $request);
            }
        }

        // $tokens = array_merge(...$tokens);

        $this->info('Sending notification to ' . count($tokens) . ' devices');
    }
}
