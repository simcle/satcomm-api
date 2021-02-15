<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $data = DB::table('measurements')
            ->select(DB::raw('avg(ph) as ph, avg(tmp) as tmp, avg(cod) as cod, avg(tss) as tss, avg(debit) as debit'))
            ->where('user_id',$user_id)
            ->where('created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 3 DAY)'))
            ->first();
        return response()->json($data);

    }
}
