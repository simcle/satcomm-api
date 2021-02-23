<?php

namespace App\Http\Controllers;

use App\Measurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MeasurementController extends Controller
{
    public function index() {
        $user_id = 1;
        $data = DB::table('measurements')
            ->where('user_id',$user_id)
            ->orderBy('id','DESC')
            ->limit(10)
            ->get();
        return response()->json($data);
    }
    public function store(Request $request)
    {
        $data = new Measurement();
        $data->user_id  = $request['user_id'];
        $data->ph       = $request['ph'];
        $data->tmp      = $request['tmp'];
        $data->cod      = $request['cod'];
        $data->tss      = $request['tss'];
        $data->nh3n     = $request['nh3n'];
        $data->debit    = $request['debit'];
        $data->save();

        return response()->json(["SUCCESS"]);
    }

}
