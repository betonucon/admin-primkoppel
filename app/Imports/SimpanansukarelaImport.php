<?php

namespace App\Imports;

use App\Simpanansukarela;
use App\Transaksi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SimpanansukarelaImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cekdata=Simpanansukarela::where('tahun',$row[3])->where('bulan',$row[2])->where('nik',$row[0])->count();
        if($cekdata>0){
            
        }else{
            $cekcount=Simpanansukarela::where('tahun',$row[3])->count();
            if($cekcount>0){
                $cek=Simpanansukarela::where('tahun',$row[3])->orderBy('id','Desc')->firstOrfail();
                $urutan = (int) substr($cek['nomortransaksi'], 8, 5);
                $urutan++;
                $nomor='SS'.date('Ym').sprintf("%05s", $urutan);
                
            }else{
                $nomor='SS'.date('Ym').sprintf("%05s", 1);
            }
            $record=Simpanansukarela::create([
                'nomortransaksi'=>$nomor,
                'nik'=>$row[0],
                'bulan'=>$row[2],
                'tahun'=>$row[3],
                'nominal'=>$row[1],
            ]);

            if($record){
                $transaksi=Transaksi::create([
                    'kodetransaksi'=>$record['nomortransaksi'],
                    'kategori_id'=>3,
                    'name'=>'Simpanan Sukarela '.$row[0],
                    'bulan'=>$row[2],
                    'tahun'=>$row[3],
                    'tanggal'=>date('Y-m-d'),
                    'nominal'=>$row[1],
                    'margin'=>0,
                    'sts'=>1,
                ]);
            }

            
        }

        return $transaksi;
            
    }

     /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}
