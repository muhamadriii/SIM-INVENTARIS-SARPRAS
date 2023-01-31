{{ $dataTable->scripts() }}
<script>
    $(document).ready(function() {
        let method = 'POST'

        //STORE
        $('#merchant-form').submit(function(e) {
            e.preventDefault()
            const payload = new FormData(this)
            const url = $(this).attr('action')
            const validator = document.getElementById('member-form').checkValidity()

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
                            $('#merchant-modal').modal('hide')
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
                /* Read more about isConfirmed, isDenied below */
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
            const url = '{{ url('admin/merchants') }}/' + $(this).data('id')
            $('#merchant-form').attr('action', url)
            method = 'PUT'

            let data = {}
            $.get(url).done(response => {
                if (response.success) data = response.data
                setForm(data)
                $('#merchant-modal').modal('show')
            })
        })

        function setForm(data) {
            $('input[name=name]').val(data.name)
            $('input[name=email]').val(data.email)
            $('input[name=username]').val(data.username)
            $('input[name=phone]').val(data.phone)
            $('#address').val(data.address)
            $('.image-input-empty').attr('style', 'background-image: url({{ asset("merchants") }}/'+encodeURIComponent(data.image)+')')

        }

        $('.modal').on('hidden.bs.modal', function(event) {
            $('#merchant-form').attr('action', '{{ route('admin.merchants.store') }}')
            method = 'POST'
            $('.image-input-empty').attr('style', 'background-color: #fff }}')
        })

    })
</script>
