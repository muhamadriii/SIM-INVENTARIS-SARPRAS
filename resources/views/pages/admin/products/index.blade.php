@extends('layouts.admin.app')
@section('content')
    <!--begin::Container-->
    <div id="container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        {{-- {{dd($categories)}} --}}
        <div class="content flex-row-fluid">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header border-0 pt-6 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary btn btn-primary btn-hover-scale" data-bs-toggle="modal"
                        data-bs-target="#product-modal">
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
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body" id="image-body">
                    <!-- <input type="text" id="test"> -->
                    <img src="" class="modal-show-image img img-responsive">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

        </div>
    </div>
    <a href=""></a>

    @include('pages.' . $path . '.' . $view . '.form')
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
    <script>
        $(document).ready(function() {
            let method = 'POST'

            $(document).on('click', '.image-modal', function() {
                var index = $(".image-modal").index(this);

                // $('#test').val($(this).data('id'));
                const url = '{{ url('admin/products/product-images') }}/' + $(this).data('id')
                $.ajax({
                    url: url,
                    method: 'GET',

                }).done(response => {
                    console.log(response.data)
                    var image = [];
                    $('#image-body').empty();
                    $(response.data).each(function(index, item) {
                        image.push(
                            `
                                <div class="row d-flex justify-content-center">
                                    <div class="col-lg-8 col-md-12 mb-4 mb-lg-0">
                                        <img
                                        src="{{ asset('products') }}/${item.image}"
                                        class="w-100 shadow-1-strong rounded mb-4"
                                        />
                                    </div>
                                </div>`
                        );
                    });

                    $('#image-body').append(image);

                    $('.modal-image-preview').modal('show');
                })
            });


            //STORE
            $('#product-form').submit(function(e) {
                e.preventDefault()
                const payload = new FormData(this)
                const url = $(this).attr('action')
                const validator = document.getElementById('product-form').checkValidity()

                if (validator) {
                    $.ajax({
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            // method: method,
                            method: 'POST', //HARDCODE KE POST KARENA FormData (upload gambar)
                            data: payload,
                            processData: false,
                            contentType: false,
                        })
                        .done(response => {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message
                                })

                                $('.dataTable').DataTable().ajax.reload()
                                $('#product-modal').modal('hide')
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

            var i = 0;
            $(document).on('click', '#add', function() {
                i++;
                // $('#cart-subtotal').text(getGrandTotal());

                $('#DynamicTable').append('<tr id="row' + i +
                    '"><td><input type="file" name="image[]" class="form-control" id="image' + i +
                    '" placeholder="Upload Image"></td><td><button type="button" id="' +
                    i +
                    '" class="btn btn-icon btn-danger remove_row"><i class="fa-solid fa-minus"></i></button></td></tr>'
                );

            });
            $(document).on('click', '.remove_row', function() {
                var row_id = $(this).attr("id");
                $('#row' + row_id).remove();
            });

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
                        const url = '{{ url('admin/products') }}/' + $(this).data('id')
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
                $('input[name=name]').val(data.name)
                $('input[name=description]').val(data.description)
                $('input[name=short_description]').val(data.short_description)
                $('input[name=price]').val(data.price)
                $('input[name=sku]').val(data.sku)
                $('input[name=discount]').val(data.discount)
                $('input[name=stock]').val(data.stock)

                $('#category_id').val(data.category_id).change()
                $('#unit_id').val(data.unit_id).change()
                $('#user_id').val(data.user_id).change()
                let html = ''

                data.product_images.forEach((image, i) => {
                    html +=
                        `
                            <tr id="row${i}">
                                <td>
                                    <img class="img-thumbnail mx-auto d-block image_product mb-2" style="height:100px;" src="{{ asset('products') }}/${image.image}"></img>
                                    <div class="text-center">
                                        <p>Image Before, name file : ${image.image}</p>
                                    </div>
                                    <input type="file" name="image[]" class="form-control" id="image${i}" placeholder="Upload Image" value="${image.image}">
                                </td>
                                <td>
                                    <button type="button" id="${i < 1 ? 'add' : i}" class="btn btn-icon btn-${i == 0 ? 'success' : 'danger'} ${i == 0 ? '' : 'remove_row'}"><i class="fa-solid ${i == 0 ? 'fa-plus' : 'fa-minus'}"></i></button>
                                </td>
                            </tr>
                        `
                });

                if (html != '') {
                    $('#DynamicTable').html(html)
                }
            }

            $('.modal').on('hidden.bs.modal', function(event) {
                $('#product-form').attr('action', '{{ route('admin.products.store') }}')
                //hapus gambar ketika modal ditutup
                $('.image_product').remove()
                $('.btn-cancel-img').click()
                method = 'POST'
            })




        })
    </script>

    {{-- droppzone --}}
    <script>
        var myDropzone = new Dropzone("#kt_dropzonejs_example_1", {
            url: "https://keenthemes.com/scripts/void.php", // Set the url for your upload script location
            paramName: "image", // The name that will be used to transfer the file
            maxFiles: 10,
            maxFilesize: 5, // MB
            addRemoveLinks: true,
            accept: function(file, done) {
                if (file.name == "wow.jpg") {
                    done("Naha, you don't.");
                } else {
                    done();
                }
            }
        });
    </script>
@endpush
