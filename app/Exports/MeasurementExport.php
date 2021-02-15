<?php

namespace App\Exports;

use App\Measurement;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class MeasurementExport implements FromCollection, WithColumnFormatting, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function map($export): array
    {
        return [
            DATE::dateTimeToExcel($export->created_at),
            DATE::dateTimeToExcel($export->created_at),
            $export->ph,
            $export->tmp,
            $export->cod,
            $export->tss,
            $export->debit,
        ];
    }
    public function columnFormats(): array
    {
        return [
            'A'=>NumberFormat::FORMAT_DATE_DDMMYYYY,
            'B'=>NumberFormat::FORMAT_DATE_TIME2
        ];
    }
    public function headings(): array
    {
        return ["TANGGAL","JAM","pH",'Temperature',"COD (ml/g)","TSS (ml/g)","Debit (m3/h)"];
    }

    public function userId(int $user_id)
    {
        $this->user_id = $user_id;
    }
    public function forLabel($label) {
        $this->label = $label;
    }
    public function toDay($today) {
        $this->today = $today;
    }
    public function sevenDay($sevenday) {
        $this->sevenday = $sevenday;
    }
    public function thisMonth($thismonth) {
        $this->thismonth = $thismonth;
    }
    public function forDay($forday) {
        $this->forday = $forday;
    }
    public function forMonth($formonth) {
        $this->formonth = $formonth;
    }
    public function forYear($foryear) {
        $this->foryear = $foryear;
    }
    public function collection()
    {
        if($this->label == 'Hari ini') {
            return Measurement::where('user_id', $this->user_id)
                ->whereDate('created_at', $this->today)->get();
        }
        if($this->label == '7 hari terakhir') {
            return Measurement::where('user_id', $this->user_id)
                ->where('created_at', '>=', $this->sevenday)->get();
        }
        if($this->label == 'Bulan ini') {
            return Measurement::where('user_id', $this->user_id)
                ->whereMonth('created_at', $this->thismonth)
                ->whereYear('created_at', date('Y'))->get();
        }
        if($this->label == 'Per Hari') {
            return Measurement::where('user_id', $this->user_id)
                ->whereDate('created_at', $this->forday)->get();
        }
        if($this->label == 'Per Bulan') {
            return Measurement::where('user_id',$this->user_id)
                ->whereMonth('created_at', $this->formonth)
                ->whereYear('created_at', $this->foryear)->get();
        }
    }
}
