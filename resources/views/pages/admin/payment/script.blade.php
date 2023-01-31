<script>
        {{$dataTable->scripts()}}

        $(document).ready(function() {
            let method = 'POST'

            //STORE
            $('#product-form').submit(function(e) {
                e.preventDefault()
                const payload = $(this).serialize()
                const url = $(this).attr('action')
                const validator = document.getElementById('product-form').checkValidity()

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
                        const url = '{{ url("admin/products") }}/' + $(this).data('id')
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
                const url = '{{ url("admin/products") }}/' + $(this).data('id')
                $('#product-form').attr('action', url)
                method = 'PUT'

                let data = {}
                $.get(url).done(response => {
                    if(response.success) data = response.data
                    setForm(data)
                    $('#product-modal').modal('show')
                })
            })

            function setForm(data) {
                $('input[name=name]').val(data.name)
                $('input[name=email]').val(data.email)
                $('input[name=username]').val(data.username)
                $('input[name=phone]').val(data.phone)
                $('input[name=address]').val(data.address)
            }

            $('.modal').on('hidden.bs.modal', function (event) {
                $('#user-form').attr('action', '{{ route("admin.users.store") }}')
                method = 'POST'
            })

        })

    </script>
