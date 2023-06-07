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
        // remind all mahasiswa and dosen that have request bimbingan 10 minutes before the request time

        $requests = DB::table('requests')
            ->join('kelompoks', 'requests.kelompok_id', '=', 'kelompoks.id')
            ->join('role_kelompoks', 'kelompoks.id', '=', 'role_kelompoks.kelompok_id')
            ->join('role_group_kelompoks', 'role_kelompoks.role_group_id', '=', 'role_group_kelompoks.id')
            ->join('kategori_roles', 'role_group_kelompoks.kategori_id', '=', 'kategori_roles.id')
            ->where('kategori_roles.nama', 'pembimbing')
            ->whereDate('requests.waktu', Carbon::today())
            ->where('requests.status', 5)
            ->select('requests.*')
            ->get();

        // convert to eloquent model
        $requests = \App\Models\Request::hydrate($requests->toArray())->load('ruangan', 'reference', 'kelompok');

        $tokens = [];
        foreach ($requests as $request) {
            $waktu = Carbon::parse($request->waktu);
            $waktu->subMinutes(10);
            $now = Carbon::now();
            if ($now->diffInMinutes($waktu) == 0) {
                sendPushNotification('Pengingat Bimbingan', 'Bimbingan akan dimulai dalam 10 menit lagi di ruangan ' . $request->ruangan->nama, $request->kelompok->mahasiswa->pluck('user.firebase_token')->toArray());
                sendPushNotification('Pengingat Bimbingan', 'Bimbingan akan dimulai dalam 10 menit lagi di ruangan ' . $request->ruangan->nama, $request->kelompok->dosen->pluck('user.firebase_token')->toArray());
            }
        }

        // $tokens = array_merge(...$tokens);

        $this->info('Sending notification to ' . count($tokens) . ' devices');


    }
}