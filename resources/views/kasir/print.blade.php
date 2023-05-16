<html>
    <head>
        <title>CETAK</title>
        <style>
            html{
                color:#000;
                margin:5px 5px 5px 5px;
                font-family: sans-serif;
            }
            
            table{
                border-collapse:collapse;
            }
            .tth{
                text-align:center;
                font-size:20px;
                background:#fff;
            }
            .tthl{
                text-align:left;
                font-size:{{setting_font_print()}}px;
                background:#fff;
            }
            .tthlg{
                text-align:left;
                font-weight:bold;
                font-size:{{setting_font_print()}}px;
                background:#fff;
            }
            .tthlb{
                text-align:left;
                font-size:{{setting_font_print()}}px;
                background:#fff;
            }
            .ttd{
                border:solid 1px #000;
                padding:0px 4px 0px 4px;
                font-size:{{setting_font_print()}}px;
                background:#fff;
            }
            .ttdr{
                border:solid 1px #000;
                padding:0px 4px 0px 4px;
                font-size:{{setting_font_print()}}px;
                text-align:right;
                background:#fff;
            }
            .ttdro{
                border-right:solid 1px #000;
                padding:0px 4px 0px 4px;
                font-size:{{setting_font_print()}}px;
                text-align:right;
                background:#fff;
            }
            .ttdc{
                border:solid 1px #000;
                padding:0px 4px 0px 4px;
                font-size:{{setting_font_print()}}px;
                text-align:center;
                background:#fff;
            }
            .ttdh{
                text-align:center;
                text-transform:uppercase;
                background:#fff;
                border:solid 1px #000;
                padding:4px 4px 4px 4px;
                font-size:{{setting_font_print()}}px;
                background:#fff;
               
            }
            .boody{
                width:97%;
                border:solid 1px #fff;
                height:500px;
                display:block;
                padding:2px 2px 2px 2px;
            }
        </style>
    </head>
    <body>
        @for($x=1;$x<=$ford;$x++)
        <div class="boody">
            <table width="97%" style="margin-left:3%">
                <tr>
                    <td class="tth" rowspan="2" style="text-align:center;font-size:17px"><b>PRIMKOPPEL STORE</b></td>
                    <td class="tthlg" width="15%">NOMOR</td>
                    <td class="tthlb"  width="24%">: {{$order->no_order}}</td>
                </tr>
                <tr>
                    <td class="tthlg">KONSUMEN</td>
                    <td class="tthlb">: {{$order->konsumen}}</td>
                </tr>
                <tr>
                    <td class="tth" style="text-align:center;font-size:14px">JL. Cendrawasih No.05 Kota Serang - Banten</td>
                    <td class="tthlg">TANGGAL</td>
                    <td class="tthlb">: {{tanggal_eng($order->created_at)}}</td>
                </tr>    
                <tr>    
                    <td class="tth" style="text-align:center;font-size:14px">Tlpn. 082118127033/087787234834</td>
                    <td class="tthlg" >BAYAR </td>
                    <td class="tthlb" >: {{$order->akses_bayar}}</td>
                </tr>
                <!-- <tr>
                    <td class="tthlg" width="8%">NOMOR</td>
                    <td class="tthlb"  width="14%">: {{$order->no_order}}</td>
                    <td class="tthlg">KONSUMEN</td>
                    <td class="tthlb">: {{$order->konsumen}}</td>
                    <td class="tthlg">TANGGAL</td>
                    <td class="tthlb"  width="18%">: {{tanggal_eng($order->waktu)}}</td>
                    <td class="tthlg" width="9%" style="text-align:right">BAYAR :</td>
                    <td class="tthlb" style="text-align:right"> {{$order->mstatuskeuangan['status_keuangan']}}</td>
                </tr> -->
                
            </table>
            <table width="99%" style="margin-left:3%" >
                <tr>
                    <td class="ttdh" width="5%">No</td>
                    <td class="ttdh">Barang</td>
                    <td class="ttdh"  width="8%">Qty</td>
                    <td class="ttdh"  width="8%">Satuan</td>
                    <td class="ttdh"  width="14%">Harga</td>
                    <td class="ttdh"  width="13%">Discon</td>
                    <td class="ttdh"  width="14%">Total</td>
                </tr>
                <?php
                    $csum=0;
                ?>
                @foreach(cetak_item_kasir($order->no_order,$x) as $no=>$o)
                <?php
                    $csum+=$o->total_jual;
                ?>
                <tr>
                    <td class="ttdc">{{$o->urut}}</td>
                    <td class="ttd">{{$o->nama_barang}} {{$o->satuan}}</td>
                    <td class="ttdr">{{$o->qty}}</td>
                    <td class="ttd">{{$o->nama_satuan}}</td>
                    <td class="ttdr">{{uang($o->harga_jual)}}</td>
                    <td class="ttdr">{{uang($o->diskon)}}%</td>
                    <td class="ttdr">{{uang($o->total)}}</td>
                </tr>
                @endforeach
                @if($ford==$x)
                <tr>
                    <td class="ttdro" colspan="6">TOTAL HALAMAN {{$x}}</td>
                    <td class="ttdr">{{uang($csum)}}</td>
                </tr>
                <tr>
                    <td class="ttdro" colspan="6">SUB TOTAL</td>
                    <td class="ttdr">{{uang(sum_item_order_kasir($order->no_order))}}</td>
                </tr>
                
                @else
                <tr>
                    <td class="ttdro" colspan="6">TOTAL HALAMAN {{$x}}</td>
                    <td class="ttdr">{{uang($csum)}}</td>
                </tr>
                @endif
            </table>
        </div><br>
        @endfor
    </body>
</html>