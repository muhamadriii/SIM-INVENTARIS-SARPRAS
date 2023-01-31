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
                        data-bs-target="#gallery-modal">
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
    <div class="modal fade modal-image-preview" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
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

            //STORE
            $('#gallery-form').submit(function(e) {
                e.preventDefault()
                const payload = new FormData(this)
                const url = $(this).attr('action')
                const validator = document.getElementById('gallery-form').checkValidity()

                if (method != 'POST')
                    payload.append('_method', 'PUT');

                if (validator) {
                    $.ajax({
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            method: method,
                            method: 'POST',
                            data: payload,
                            async: false,
                            cache: false,
                            contentType: false,
                            enctype: 'multipart/form-data',
                            processData: false,
                        })
                        .done(response => {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message
                                })

                                $('.dataTable').DataTable().ajax.reload()
                                $('#gallery-modal').modal('hide')
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
            $(document).on('click', '.delete-btn', function() {
                Swal.fire({
                    title: 'Are you sure',
                    icon: 'info',
                    showDenyButton: true,
                    confirmButtonText: 'Yes',
                    denyButtonText: `No`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        const url = '{{ url('admin/gallery') }}/' + $(this).data('id')
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


            $(document).on('click', '.edit-btn', function() {
                const url = '{{ url('admin/gallery') }}/' + $(this).data('id')
                $('#gallery-form').attr('action', url)
                method = 'PUT'

                let data = {}
                $.get(url).done(response => {
                    if (response.success) data = response.data
                    setForm(data)
                    $('#gallery-modal').modal('show')
                })
            })

            function setForm(data) {
                $('input[name=name]').val(data.name)
                $('input[name=title_name]').val(data.title_name)
                $('input[name=description]').val(data.description)
                $('input[name=url]').val(data.url)
                $('.image-input-empty').attr('style', 'background-image: url({{ asset('galleries') }}/' +
                    encodeURIComponent(data.image) + ')')
            }

            $('.modal').on('hidden.bs.modal', function(event) {
                $('#gallery-form').attr('action', '{{ route('admin.gallery.store') }}')
                method = 'POST'
                $('.image-input-empty').attr('style', 'background-color: #fff }}')
            })


        })
    </script>
@endpush
