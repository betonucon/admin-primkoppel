<?php

namespace App\Exports;
 
use App\Vtagihan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
class PinjamanExport implements FromCollection,WithHeadings,WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    

    function __construct($tanggal) {
            $this->tanggal = $tanggal;
    }
    public function collection()
    {
        return Vtagihan::where('berikutnya',$this->tanggal)->get();
    }
    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 30,            
            'C' => 20,            
            'D' => 20,            
            'E' => 20,              
            'F' => 15,              
        ];
    }
    public function headings(): array
    {
        return ["NIK", "NAMA", "NOMOR PINJAMAN","TAGIHAN","PERIODE","CICILAN-KE"];
    }
}