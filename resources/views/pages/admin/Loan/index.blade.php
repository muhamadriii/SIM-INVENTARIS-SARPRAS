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
                        data-bs-target="#loan-modal">
                        <i class="la la-plus"></i> Create
                    </button>
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
    <div class="modal fade modal-image-preview" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <img src="" class="modal-show-image img img-responsive">
            </div>
        </div>
    </div>
    @include('pages.' . $path . '.' . $view . '.form')
@endsection
@push('scripts')
    @include('pages.' . $path . '.' . $view . '.script')
@endpush
