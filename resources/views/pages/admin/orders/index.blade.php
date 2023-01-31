@extends('layouts.admin.app')
@section('content')
    <!--begin::Container-->
    <div id="container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header border-0 pt-6 d-flex justify-content-end">
                    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary"> Create </a>
                    <!-- <button type="button" class="btn btn-primary btn btn-primary btn-hover-scale" data-bs-toggle="modal" data-bs-target="#product-modal">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <i class="la la-plus"></i>  gi Create -->
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
    {{ $dataTable->scripts() }}
    <script>
        $(document).ready(function() {
            let method = 'POST'

            $(document).on('click', '.image-modal', function() {
                var index = $(".image-modal").index(this);
                $('.modal-show-image').attr('src', $(".image-modal").eq(index).attr('src'));
                $('.modal-image-preview').modal('show');
            });

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
                        const url = '{{ url('admin/orders/destroy') }}/' + $(this).data('id')
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
            $(document).on('click', '.resi-btn', function() {
                const url = '{{ url('admin/orders/edit-resi') }}/' + $(this).data('id')
                $('#resi-form').attr('action', url)
                method = 'PUT'

                let data = {}
                $.get(url).done(response => {
                    if (response.success) data = response.data
                    setForm(data)
                    $('#resi-modal').modal('show')
                })
            })

            function setForm(data) {
                $('input[name=resi]').val(data.resi)
            }

            $('#resi-form').submit(function(e) {
                e.preventDefault()
                const payload = $(this).serialize()
                const url = $(this).attr('action')
                const method = $(this).attr('method')

                $.ajax({
                        url: url,
                        method: method,
                        data: payload
                    })
                    .done(response => {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            })
                            $('#resi-modal').modal('hide')
                            // window.location.href = "{{ route('admin.orders.index') }}";
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

            $('.modal').on('hidden.bs.modal', function(event) {
                $('#resi-form').attr('action', '{{ route('admin.orders.store') }}')
                method = 'POST'
            })

            $(document).on('click', '.status-btn', function() {
                $.ajax({
                        url: '{{ url('admin/orders/update-status') }}/' + $(this).data('id'),
                        method: 'GET'
                    })
                    .done(response => {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            })
                            // window.location.href = "{{ route('admin.orders.index') }}";
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
