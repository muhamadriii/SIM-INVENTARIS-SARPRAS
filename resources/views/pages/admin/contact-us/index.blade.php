@extends('layouts.admin.app')
@section('content')
<!--begin::Container-->
<div id="container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <!--begin::Post-->
    <div class="content flex-row-fluid">
        <!--begin::Card-->
        <div class="card">
            <div class="card-header border-0 pt-6 d-flex justify-content-end">
                <button type="button" class="btn btn-primary btn btn-primary btn-hover-scale" data-bs-toggle="modal" data-bs-target="#contact-modal">
                    <i class="la la-plus"></i>  Create
                </button>
            </div>
            <!--begin::Card body-->
            <div class="card-body py-4">
                <!--begin::Table-->
                <div class="table-responsive">
                    {{$dataTable->table()}}
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
@include("pages.".$path.".".$view.'.form')

@endsection
@push('scripts')
    {{$dataTable->scripts()}}
    <script>

        $(document).ready(function() {
            let method = 'POST'

            //STORE
            $('#contact-form').submit(function(e) {
                e.preventDefault()
                const payload = $(this).serialize()
                const url = $(this).attr('action')
                const validator = document.getElementById('contact-form').checkValidity()

                if(validator) {
                    $.ajax({
                        url: url,
                        method: method,
                        data: payload
                    })
                    .done(response => {
                        if(response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            })

                            $('.dataTable').DataTable().ajax.reload()
                            $('#contact-modal').modal('hide')
                        }
                    })
                    .fail(response => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.responseJSON.message
                        })
                    })
                }

            })


            //DELETE
            $(document).on('click', '.delete-btn', function(){
                Swal.fire({
                    title: 'Are you sure',
                    icon: 'info',
                    showDenyButton: true,
                    confirmButtonText: 'Yes',
                    denyButtonText: `No`,
                    }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        const url = '{{ url("admin/contact-us") }}/' + $(this).data('id')
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
            $(document).on('click', '.edit-btn', function(){
                const url = '{{ url("admin/contact-us") }}/' + $(this).data('id')
                $('#contact-form').attr('action', url)
                method = 'PUT'

                let data = {}
                $.get(url).done(response => {
                    if(response.success) data = response.data
                    setForm(data)
                    $('#contact-modal').modal('show')
                })
            })

            function setForm(data) {
                $('input[name=name]').val(data.name)
                $('input[name=email]').val(data.email)
                $('input[name=phone]').val(data.phone)
                $('input[name=message]').val(data.message)
            }

            $('.modal').on('hidden.bs.modal', function (event) {
                $('#contact-form').attr('action', '{{ route("admin.contact-us.store") }}')
                method = 'POST'
            })

        })

    </script>
@endpush
