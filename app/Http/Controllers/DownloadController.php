<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;



class DownloadController extends Controller
{
    public function test()
    {
        $result = DB::table('users')->count(); // atau tabel lain yang sudah ada
        return response()->json(['count' => $result]);
    }
}
