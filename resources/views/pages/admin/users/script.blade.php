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
        $('#user-form').submit(function(e) {
            e.preventDefault()
            const payload = new FormData(this)
            const url = $(this).attr('action')
            const validator = document.getElementById('user-form').checkValidity()

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
                            $('#user-modal').modal('hide')
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
                    const url = '{{ url('admin/users') }}/' + $(this).data('id')
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
            const url = '{{ url('admin/users') }}/' + $(this).data('id')
            $('#user-form').attr('action', url)
            method = 'PUT'

            let data = {}
            $.get(url).done(response => {
                if (response.success) data = response.data
                setForm(data)
                $('#user-modal').modal('show')
            })
        })

        function setForm(data) {
            $('#role').val(data.type).change()
            $('input[name=name]').val(data.name)
            $('input[name=email]').val(data.email)
            $('input[name=username]').val(data.username)
            $('input[name=phone]').val(data.phone)
            $('select[name=role]').val(data.type).change()
            $('#address').val(data.address)
            $('.image-input-empty').attr('style', 'background-image: url({{ asset('storage/images/user') }}/' +
                encodeURIComponent(data.image) + ')')
        }

        $('.modal').on('hidden.bs.modal', function(event) {
            $('#user-form').attr('action', '{{ route('admin.users.store') }}')
            //hapus gambar ketika modal ditutup
            $('.btn-cancel-img').click()
            method = 'POST'
            $('.image-input-empty').attr('style', 'background-color: #fff }}')
        })

    })
</script>
