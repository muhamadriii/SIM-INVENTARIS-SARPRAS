{{$dataTable->scripts()}}
<script>

    $(document).ready(function() {
        let method = 'POST'

        //STORE
        $('#fee-form').submit(function(e) {
            e.preventDefault()
            const payload = $(this).serialize()
            const url = $(this).attr('action')
            const validator = document.getElementById('fee-form').checkValidity()

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
                        $('#fee-modal').modal('hide')
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
                    const url = '{{ url("admin/fee") }}/' + $(this).data('id')
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
            const url = '{{ url("admin/fee") }}/' + $(this).data('id')
            $('#fee-form').attr('action', url)
            method = 'PUT'

            let data = {}
            $.get(url).done(response => {
                if(response.success) data = response.data
                setForm(data)
                $('#fee-modal').modal('show')
            })
        })

        function setForm(data) {
            $('input[name=receipent_name]').val(data.receipent_name)
            $('input[name=account_number]').val(data.account_number)
            $('input[name=fee]').val(data.fee)
        }

        $('.modal').on('hidden.bs.modal', function (event) {
            $('#fee-form').attr('action', '{{ route("admin.fee.store") }}')
            method = 'POST'
        })

    })

</script>