<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoomCollection;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(){
        $rooms = Ruangan::all();
        return ResponseFormatter::success(new RoomCollection($rooms), 'Data berhasil diambil');
    }
}
