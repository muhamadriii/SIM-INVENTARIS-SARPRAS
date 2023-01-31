@extends('layouts.admin.app')
@section('content')
    <!--begin::Container-->
    <div id="container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header border-0 pt-6 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary btn btn-primary btn-hover-scale" data-bs-toggle="modal"
                        data-bs-target="#member-address-modal">
                        <i class="la la-plus"></i> Create
                    </button>
                </div>
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <div class="table-responsive">
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
    @include($view . '.form')
@endsection

@push('scripts')
    @include($view . '.script')
@endpush
