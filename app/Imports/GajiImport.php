<?php

namespace App\Imports;

use App\Slipgaji;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
class GajiImport implements ToModel, WithStartRow,WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cek=Slipgaji::where('bulan',$row[30])->where('tahun',$row[31])->where('nik',$row[1])->count();
        if($cek>0){
            $data=Slipgaji::where('bulan',$row[30])->where('tahun',$row[31])->where('nik',$row[1])->update([
                'gapok'=>$row[2],
                'cutitahunan'=>$row[3],
                'lembur'=>$row[4],
                'rapelan'=>$row[5],
                'perumahan'=>$row[6],
                'transport'=>$row[7],
                'makan'=>$row[8],
                'shift'=>$row[9],
                'pengalaman'=>$row[10],
                'profesi'=>$row[11],
                'risiko'=>$row[12],
                'total'=>$row[13],
                'total_upah'=>$row[14],
                'jht'=>$row[15],
                'simpanan_wajib'=>$row[16],
                'tabungan'=>$row[17],
                'ket_pinjaman'=>$row[18],
                'pinjaman'=>$row[19],
                'bpjs'=>$row[20],
                'bpjs_pensiun'=>$row[21],
                'total_potongan'=>$row[22],
                'bpjs_kesehatan'=>$row[23],
                'jht_jamsostek'=>$row[24],
                'jkk_jamsostek'=>$row[25],
                'kematian'=>$row[26],
                'pensiun'=>$row[27],
                'comp'=>$row[28],
                'dibayar'=>$row[29],
            ]);
        }else{
            return new Slipgaji([
                'nik'=>$row[1],
                'gapok'=>$row[2],
                'cutitahunan'=>$row[3],
                'lembur'=>$row[4],
                'rapelan'=>$row[5],
                'perumahan'=>$row[6],
                'transport'=>$row[7],
                'makan'=>$row[8],
                'shift'=>$row[9],
                'pengalaman'=>$row[10],
                'profesi'=>$row[11],
                'risiko'=>$row[12],
                'total'=>$row[13],
                'total_upah'=>$row[14],
                'jht'=>$row[15],
                'simpanan_wajib'=>$row[16],
                'tabungan'=>$row[17],
                'ket_pinjaman'=>$row[18],
                'pinjaman'=>$row[19],
                'bpjs'=>$row[20],
                'bpjs_pensiun'=>$row[21],
                'total_potongan'=>$row[22],
                'bpjs_kesehatan'=>$row[23],
                'jht_jamsostek'=>$row[24],
                'jkk_jamsostek'=>$row[25],
                'kematian'=>$row[26],
                'pensiun'=>$row[27],
                'comp'=>$row[28],
                'dibayar'=>$row[29],
                'bulan'=>$row[30],
                'tahun'=>$row[31],
            ]);
        }
        

            
        
            
    }

     /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}
