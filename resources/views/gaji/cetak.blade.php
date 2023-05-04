<html>
    <head>
        <title>SLIPGAJI</title>
        <style>
            body{
                font-family: sans-serif;
            }
            p{
                margin:0px;
            }
            .thdr{
                font-size:14px;
                font-weight:bold;
            }
            .thd{
                font-size:12px;
                font-weight:bold;
                text-transform:uppercase;
            }
            .tdd{
                font-size:12px;
            }
            .thl{
                font-size:12px;
                text-align:right;
            }
            .thll{
                font-size:12px;
                text-align:right;
                border-bottom:solid 1px #000;
            }
        </style>
    </head>
    <body>
        <table width="100%" >
            <tr>
                <td width="15%"><img src="{{public_path('img/koper.png')}}" width="80%"></td>
                <td width="93%" class="thdr">
                    <p>KOPERASI MITRA SEJAHTERA</p>							
                    <p>No. Badan Hukum : 115/KEP/KWK.10/IV/1997 - tanggal 8 April 1997</p>									
                    <p>Gedung Krakatau IT Jl. Raya Anyer Km. 3 Cilegon 42441 Banten	</p>								

                </td>

            </tr>
        </table><hr style="border-top: 4px double #000;">
        <table width="100%" >
            <tr>
                <td width="10%" class="thd">NIK</td>
                <td width="5%" class="thd">:</td>
                <td width="30%" class="thd">{{$data->nik}}</td>
                <td width="10%" class="thd">BULAN</td>
                <td width="5%" class="thd">:</td>
                <td  class="thd">{{bulan($data->bulan)}} {{$data->tahun}}</td>

            </tr>
            <tr>
                <td class="thd">NAMA</td>
                <td class="thd">:</td>
                <td class="thd">{{$data->usernya['name']}}</td>
                <td class="thd">JABATAN</td>
                <td class="thd">:</td>
                <td  class="thd"></td>

            </tr>
        </table><hr>
        <table width="100%"  >
            <tr>
                <td width="3%" class="thd">A.</td>
                <td width="25%" class="thd">PENDAPATAN</td>
                <td width="15%" class="thl"></td>
                <td width="3%" class="thd"></td>
                <td width="3%" class="thd">C.</td>
                <td class="thd">KONTRIBUSI PERUSAHAAN</td>
                <td  width="15%" class="thl"></td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">GAJI POKOK</td>
                <td class="thl">{{uang($data->gapok)}}</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd">PPh 21</td>
                <td  class="thl">0</td>

            </tr>
            
            <tr>
                <td class="tdd"></td>
                <td class="tdd">T.RUMAH </td>
                <td class="thl">{{uang($data->perumahan)}}</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd">BPJS KESEHATAN</td>
                <td  class="thl">{{uang($data->bpjs_kesehatan)}}</td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">T.TRANSPORT </td>
                <td class="thl">{{uang($data->transport)}}</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd">JHT JAMSOSTEK</td>
                <td  class="thl">{{uang($data->jht_jamsostek)}}</td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">T.UANG MAKAN  </td>
                <td class="thl">{{uang($data->makan)}}</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd">JKK JAMSOSTEK</td>
                <td  class="thl">{{uang($data->jkk_jamsostek)}}</td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">T.LEMBUR  </td>
                <td class="thl">{{uang($data->lembur)}}</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd">JKM JAMSOSTEK</td>
                <td  class="thl">{{uang($data->kematian)}}</td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">T.SHIFT  </td>
                <td class="thl">{{uang($data->shift)}}</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd">BPJS PENSIUN</td>
                <td  class="thll">{{uang($data->pensiun)}}</td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">T.PENGALAMAN KERJA  </td>
                <td class="thl">{{uang($data->pengalaman)}}</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td  class="thl">{{uang($data->comp)}}</td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">T.PROFESI  </td>
                <td class="thl">{{uang($data->profesi)}}</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td  class="tdd"></td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">T.RESIKO KERJA  </td>
                <td class="thl">{{uang($data->risiko)}}</td>
                <td class="tdd"></td>
                <td class="thd">E</td>
                <td class="thd">TOTAL PENGELUARAN PERUSAHAAN</td>
                <td  class="thl"></td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">T.LAINNYA  </td>
                <td class="thl">0</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td  class="thl"></td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">&nbsp;</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td  class="thll"></td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">&nbsp;</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd">(A+C)</td>
                <td  class="thl">{{uang($data->total_upah+$data->comp)}}</td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">&nbsp;</td>
                <td class="thll"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td  class="thl"></td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">&nbsp;</td>
                <td class="thl">{{uang($data->total_upah)}}</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td  class="tdd"></td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">&nbsp;</td>
                <td class="thl"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td  class="thl"></td>

            </tr>
            <tr>
                <td class="thd">B.</td>
                <td class="thd">POTONGAN </td>
                <td class="thl"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td  class="thl"></td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">P.ABSEN </td>
                <td class="thl">0</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td  class="thl"></td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">P.JAMSOSTEK / JHT </td>
                <td class="thl">{{uang($data->jht)}}</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td  class="thl"></td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">P.BPJS KESEHATAN </td>
                <td class="thl">{{uang($data->bpjs)}}</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td  class="thl"></td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">P.BPJS PENSIUN </td>
                <td class="thl">{{uang($data->bpjs_pensiun)}}</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td  class="thl"></td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">P.SIMPANAN WAJIB KOP </td>
                <td class="thl">{{uang($data->simpanan_wajib)}}</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td  class="thl"></td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">P.PINJ.UANG KOP @if($data->pinjaman!=0) ({{$data->ket_pinjaman}}) @endif</td>
                <td class="thl">{{uang($data->pinjaman)}}</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td  class="thl"></td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">P.SIMPANAN SUKARELA </td>
                <td class="thl">{{uang($data->tabungan)}}</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td  class="thl"></td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd">&nbsp;</td>
                <td class="thll"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td  class="thl"></td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="thl">{{uang($data->total_potongan)}}</td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td  class="thl"></td>

            </tr>
            <tr>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="thl"></td>
                <td class="tdd"></td>
                <td class="tdd"></td>
                <td class="thd" style="text-align:right">DITERIMA (A+B)</td>
                <td  class="thl"><b>{{uang($data->total_upah-$data->total_potongan)}}</b></td>

            </tr>
        </table>
    </body>
<html>