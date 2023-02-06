{{ $dataTable->scripts() }}
<script>
    $(document).ready(function() {
        let method = 'POST'

        //STORE
        $('#role-form').submit(function(e) {
            e.preventDefault()
            const payload = $(this).serialize()
            const url = $(this).attr('action')
            const validator = document.getElementById('role-form').checkValidity()

            if (validator) {
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
                            
                            $('.dataTable').DataTable().ajax.reload()
                            $('#role-modal').modal('hide')
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
                    const url = '{{ url('admin/roles') }}/' + $(this).data('id')
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
            const url = '{{ url('admin/roles') }}/' + $(this).data('id')
            $('#role-form').attr('action', url)
            method = 'PUT'

            let data = {}
            $.get(url).done(response => {
                if (response.success) data = response.data
                setForm(data)
                console.log(data)
                $('#role-modal').modal('show')
            })
        })

        function setForm(data) {
            $('input[name=name]').val(data.name)
            $('input[name=guard_name][value='+data.guard_name+']').prop("checked",true)
            
            $.each(data.permission, function(index) {
                $('[id='+index+']').prop("checked",true)
            });
        }

        $('.modal').on('hidden.bs.modal', function(event) {
            $('#role-form').attr('action', '{{ route('admin.roles.store') }}')
            method = 'POST'
        })

    })
</script>