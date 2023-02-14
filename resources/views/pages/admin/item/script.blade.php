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
            $('#parent-item-form').submit(function(e) {
                e.preventDefault()
                const payload = new FormData(this)
                const url = $(this).attr('action')
                const validator = document.getElementById('parent-item-form').checkValidity()

                if (validator) {
                    $.ajax({
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        // method: method,
                        method: 'post', //HARDCODE KE POST KARENA FormData (upload gambar)
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
                            $('#parent-item-modal').modal('hide')
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
                        const url = '{{ url('admin/items') }}/' + $(this).data('id')
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

            // EDIT
            $(document).on('click', '.edit-btn', function() {
                const url = '{{ url('admin/items') }}/' + $(this).data('id')
                $('#parent-item-form').attr('action', url)
                method = 'PUT'
                let data = {}

                $.get(url).done(response => {
                    if (response.success) data = response.data
                    setForm(data)
                    $('#parent-item-modal').modal('show')
                })
            })

            function setForm(data) {
                $('input[name=name]').val(data.name)
                $('input[name=suplier]').val(data.suplier)
                $('input[name=description]').val(data.description)
                $('input[name=price]').val(data.price)
                $('input[name=stock]').val(data.stock)

                $('#category_id').val(data.category_id).change()
                $('#unit_id').val(data.unit_id).change()

                $('.image-input-empty').attr('style', 'background-image: url({{ asset('storage/images/item') }}/' +
                encodeURIComponent(data.image) + ')')

                // for generate barcode
                $('.price').html(data.price)
                $('.name').html(data.name)
                $('.suplier').html(data.suplier)
                $('.stock').html(data.stock)
                $('.category').html(data.category.name)
            }

            $('.modal').on('hidden.bs.modal', function(event) {
                $('#parent-item-form').attr('action', '{{ route('admin.items.store') }}')
                //hapus gambar ketika modal ditutup
                $('.image_parent-item').remove()
                $('.btn-cancel-img').click()
                method = 'POST'
            })

             // Modal create qr-code
            $(document).on('click', '.generate-btn', function() {
                const url = '{{ url('admin/items') }}/' + $(this).data('id')
                const urlGenerate = '{{ url('admin/generate-items') }}/' + $(this).data('id')
                $('#generate-item-form').attr('action', urlGenerate)

                let data = {}

                $.get(url).done(response => {
                    if (response.success) data = response.data
                    setForm(data)
                    $('#generate-item-modal').modal('show')
                })
            })

            // ajax generate sku
            $(document).on('submit', '#generate-item-form', function(e) {
                e.preventDefault()
                const payload = new FormData(this)
                const url = $(this).attr('action')
                const validator = document.getElementById('parent-item-form').checkValidity()

                if (validator) {
                    $.ajax({
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        method: 'post', //HARDCODE KE POST KARENA FormData (only create)
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
                            console.log(response.data)
                            $('.dataTable').DataTable().ajax.reload()
                            $('.result').children().remove()
                            $('.result').append(`
                            <div class="d-flex justify-content-center">
                                <img class="qrcode-image" src="${response.url}" alt="">
                            </div>
                            <div class="d-flex justify-content-center my-3">
                                <span class="fw-bold">${response.data.sku}</span>
                            </div>
                            `)
                            $('.generate-qrcode-btn').removeClass('btn-primary').addClass(['btn-secondary', 'dishable'])
                            $('.generate-qrcode-btn').attr('type','button')
                            $('.button-action').children('.reset-btn').remove()
                            $('.button-action').prepend(`
                                <button type="reset" class="btn reset-btn btn-outline-danger">Cetak Lagi</button>
                            `)
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

            $('.modal').on('hidden.bs.modal', function(event) {
                $('.result').children().remove()
                $('.generate-qrcode-btn').removeClass(['btn-secondary', 'dishable']).addClass('btn-primary')
                $('.generate-qrcode-btn').attr('type','submit')
                $('.button-action').children('.reset-btn').remove()
            })

            $(document).on('click', '.reset-btn', function() {
                $('.generate-qrcode-btn').removeClass(['btn-secondary', 'dishable']).addClass('btn-primary')
                $('.generate-qrcode-btn').attr('type','submit')
                $('.result').children().remove()
                $('.input-sku').children().remove()
                $('.button-action').children('.reset-btn').remove()
                $(this).remove()
            })
            
            // add input sku
            $(document).on('change', '#status', function() {
                if ($(this).val() == 1) {
                    $('.input-sku').append(`
                    <label for="sku" class="required form-label">sku</label>
                    <input type="text" class="form-control form-control-solid" name="sku" placeholder="sku" required />
                    `)
                } else {
                    $('.input-sku').children().remove()
                }
            })

        })
        // window.onload = function() {
        //     var img = window.open("me-smiling.png");
        //     img.print();
        // }
    </script>