@extends('layouts.admin.app')
@section('content')
    <!--begin::Container-->
    <div id="container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header border-0 pt-6 d-flex justify-content-end">
                    <a href="{{ route('admin.payment-generate') }}" name="action" class="btn btn-primary">Generate
                        Payment</a>
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
    @include('pages.' . $path . '.' . $view . '.form')
@endsection
@push('scripts')
    {{ $dataTable->scripts() }}
    <script>
        $(document).ready(function() {
            let method = 'POST'

            //DELETE
            $(document).on('click', '.delete-btn', function() {
                // console.log($(this).data('id'))
                Swal.fire({
                    title: 'Are you sure',
                    icon: 'info',
                    showDenyButton: true,
                    confirmButtonText: 'Yes',
                    denyButtonText: `No`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        const url = '{{ url('admin/payment/destroy') }}/' + $(this).data('id')
                        $.ajax({
                            url: url,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }).done(response => {
                            console.log(response)
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                message: response.message
                            })
                            $('.dataTable').DataTable().ajax.reload()
                        })
                    }
                })
            })

            //EDIT
            $(document).on('click', '.edit-btn', function() {
                const url = '{{ url('admin/products') }}/' + $(this).data('id')
                $('#product-form').attr('action', url)
                method = 'PUT'

                let data = {}
                $.get(url).done(response => {
                    if (response.success) data = response.data
                    setForm(data)
                    $('#product-modal').modal('show')
                })
            })

            function setForm(data) {
                $('input[name=category_id]').val(data.category_id)
                $('input[name=name]').val(data.name)
                $('input[name=description]').val(data.description)
                $('input[name=price]').val(data.price)
            }

            $('.modal').on('hidden.bs.modal', function(event) {
                $('#product-form').attr('action', '{{ route('admin.products.store') }}')
                method = 'POST'
            })

            $(document).on('click', '.status-btn', function() {
                $.ajax({
                        url: '{{ url('admin/payment/update-status') }}/' + $(this).data('id'),
                        method: 'GET'
                    })
                    .done(response => {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            })
                            $('.dataTable').DataTable().ajax.reload()
                        }
                    })
                    .fail(response => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.responseJSON.message
                        })
                    })

            })

        })
    </script>
@endpush
