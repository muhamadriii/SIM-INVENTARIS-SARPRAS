@extends('layouts.admin.app')
@section('content')
<!--begin::Container-->
<div id="container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <!--begin::Post-->
    <div class="content flex-row-fluid">
        <!--begin::Card-->
        <div class="card">
            <div class="card-header border-3 pt-6">
                <h4>Order Status : Paid </h4>
            </div>
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <div class="table table-hover table-rounded table-striped border gy-7 gs-7">
                    {{ $dataTable->table() }}
                </div>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Post-->
</div>
<!--end::Container-->
@endsection
@push('scripts')
    {{$dataTable->scripts()}}
@endpush


