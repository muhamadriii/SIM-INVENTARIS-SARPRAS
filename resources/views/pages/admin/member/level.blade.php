@extends('layouts.admin.app')
@section('content')
<style>
    .bg-yellow{
        background-color: yellow;
    }
</style>
    <!--begin::Container-->
    <div id="container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Level</th>
                                <th>Member</th>
                                <th>Total Member/Pack</th>
                                <th>Total Member Per Jenjang</th>
                                <th>Belanja Per Bulan (Rp)</th>
                                <th>Total Omzet</th>
                                <th>Komisi Per Level </th>
                                <th>Komisi Per Level</th>
                                <th>Total Pemb Komisi</th>
                                <th>Asumsi Untung 20</th>
                                <th>Pendapatan dari ADM</th>
                                <th>Akumulasi dari Total Pemb Komisi Pendapatan ADM </th>
                            </tr>
                            @foreach ($levels as $level)
                            <tr class="{{ $level->level == $member->level ? 'bg-yellow' : '' }}">
                                <td>{{ $level->level }}</td>
                                <td>{{ $level->total_member }}</td>
                                <td>{{ $level->total_member_pack }}</td>
                                <td>{{ $level->total_member_level }}</td>
                                <td>{{ $level->shopping_month }}</td>
                                <td>{{ $level->total_turnover }}</td>
                                <td>{{ $level->commission_level_percent }}</td>
                                <td>{{ $level->commission_level_nominal }}</td>
                                <td>{{ $level->total_commission }}</td>
                                <td>{{ $level->profit_assumption }}</td>
                                <td>{{ $level->income_administration }}</td>
                                <td>{{ $level->accumulation_administrative_income }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Post-->
    </div>
@endsection
