@extends('layouts.web')

@section('isinya')  
<div id="content-kedua" class="content">
    <div class="profile">
        <div class="profile-header">
            <div class="profile-header-cover"></div>
            <div class="profile-header-content">
                <div class="profile-header-img">
                    <img src="{{url('img/kopkar.png')}}" alt="">
                </div>
                <div class="profile-header-info">
                    <h4 class="mt-0 mb-1">{{Auth::user()->name}}</h4>
                    <p class="mb-2">Anggota Koperasi Mitra Sejahtera</p>
                    <h5 class="mt-0 mb-1">PINJAMAN SAAT INI :</h5>
                    <h5 class="mt-0 mb-1">Rp.10.000.000</h5>
                    <!-- <a href="#" class="btn btn-xs btn-yellow">Edit Profile</a> -->
                </div>
            </div>
            
        </div>
    </div>  
    <div class="panel panel-success" data-sortable-id="ui-widget-11" style="border-top:solid 2px #000;border-radius: 0px;">
        
        <div class="panel-body">
            
            <table id="datafixedheader" class="table table-striped table-bordered table-td-valign-middle">
                <thead>
                    <tr>
                        <th width="5%">NO</th>
                        <th width="5%">Bulan</th>
                        <th class="text-nowrap">Periode Angsuran</th>
                        <th class="text-nowrap">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @for($bulan=1;$bulan<20;$bulan++)
                        <tr class="odd gradeX">
                            <td>{{$bulan}}</td>
                            <td>10</td>
                            <td>Jan/21 s/d Okt/21</td>
                            <td>10.000.000</td>
                        </tr>
                    @endfor
                    
                    
                </tbody>
            </table>

        </div>
        
    </div>
</div>
@endsection

@push('ajax')
    <script>
        var handleDataTableFixedHeader = function() {
            "use strict";
            
            if ($('#datafixedheader').length !== 0) {
                $('#datafixedheader').DataTable({
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    responsive: true,
                    langth: false,
                    paging: false,
                    order: false,
                    info: false,
                });
            }
        };

        var TableManageFixedHeader = function () {
            "use strict";
            return {
                //main function
                init: function () {
                    handleDataTableFixedHeader();
                }
            };
        }();

        $(document).ready(function() {
            TableManageFixedHeader.init();
        });
    </script>

@endpush