<?php

namespace App\Http\Controllers;


use App\Exports\MeasurementExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date;
        $label = $request->label;

        $user_id = Auth::user()->id;
        $data = DB::table('measurements')
            ->where('user_id',$user_id)
            ->orderBy('id','DESC');

        if($label == 'Hari ini') {
            $range = date('Y-m-d');
            $data->whereDate('created_at', $range);
        }
        if($label == '7 hari terakhir') {
            $data->where('created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 7 DAY)'));
        }

        if($label == 'Bulan ini') {
            $data->whereMonth('created_at','=', date('m'))
                ->whereYear('created_at','=', date('Y'));
        }
        if($label == 'Per Hari') {
            $range = date('Y-m-d', strtotime($date));
            $data->whereDate('created_at','=', $range);
        }
        if($label == 'Per Bulan') {
            $range = explode('-', $date);
            $month = $range[0];
            $year = $range[1];
            $data->whereMonth('created_at','=',$month)
                ->whereYear('created_at','=',$year);
        }
        if($label == 'Per Tahun') {
            $data->whereYear('created_at',$date);
        }
        return response()->json($data->paginate(20));
    }

    public function export(Request $request)
    {
        $date = $request->date;
        $label = $request->label;

        $user_id = Auth::user()->id;
        $export = new MeasurementExport();
        $export->userId($user_id);
        $export->forLabel($label);
        if($label == 'Hari ini') {
            $export->toDay(date('Y-m-d'));
            return Excel::download($export,'laporan.xlsx');
        }

        if($label == '7 hari terakhir') {
            $export->sevenDay(DB::raw('DATE_SUB(NOW(), INTERVAL 7 DAY)'));
            return Excel::download($export, 'laporan.xlsx');
        }

        if($label == 'Bulan ini') {
            $export->thisMonth(date('m'));
            return Excel::download($export, 'laporan.xlsx');
        }
        if($label == 'Per Hari') {
            $range = date('Y-m-d', strtotime($date));
            $export->forDay($range);
            return Excel::download($export, 'laporan.xlsx');
        }
        if($label == 'Per Bulan') {
            $range = explode('-', $date);
            $month = $range[0];
            $year = $range[1];
            $export->forMonth($month);
            $export->forYear($year);
            return Excel::download($export, 'laporan.xlsx');
        }
    }
}
