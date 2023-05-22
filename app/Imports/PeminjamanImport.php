<?php

namespace App\Imports;

use App\Pinjaman;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PeminjamanImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cekanggota=Anggota::where('nama',$row[1])->count();
        if($cekanggota>0){
            $anggota=Anggota::where('nama',$row[1])->count();
            
                $cekcount=Simpananwajib::where('tahun',$row[3])->count();
                if($cekcount>0){
                    $cek=Simpananwajib::where('tahun',$row[3])->orderBy('id','Desc')->firstOrfail();
                    $urutan = (int) substr($cek['nomortransaksi'], 8, 5);
                    $urutan++;
                    $nomor='SW'.date('Ym').sprintf("%05s", $urutan);
                    
                }else{
                    $nomor='SW'.date('Ym').sprintf("%05s", 1);
                }
                $record=Simpananwajib::create([
                    'nomortransaksi'=>$nomor,
                    'nik'=>$row[0],
                    'bulan'=>$row[2],
                    'tahun'=>$row[3],
                    'nominal'=>$row[1],
                ]);

                if($record){
                    $transaksi=Transaksi::create([
                        'kodetransaksi'=>$record['nomortransaksi'],
                        'kategori_id'=>4,
                        'name'=>'Simpanan Wajib '.$row[0],
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
        }else{

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
