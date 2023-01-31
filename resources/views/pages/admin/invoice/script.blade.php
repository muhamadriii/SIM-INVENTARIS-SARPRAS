{{$dataTable->scripts()}}
<script>

    $(document).ready(function() {
        let method = 'POST'

        //STORE
        $('#invoice-form').submit(function(e) {
            e.preventDefault()
            const payload = $(this).serialize()
            const url = $(this).attr('action')
            const validator = document.getElementById('invoice-form').checkValidity()

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
                        $('#invoice-modal').modal('hide')
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
                    const url = '{{ url("admin/invoice") }}/' + $(this).data('id')
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
            const url = '{{ url("admin/invoice") }}/' + $(this).data('id')
            $('#invoice-form').attr('action', url)
            method = 'PUT'

            let data = {}
            $.get(url).done(response => {
                if(response.success) data = response.data
                setForm(data)
                $('#invoice-modal').modal('show')
            })
        })

        function setForm(data) {
            $('input[name=no_policy]').val(data.no_policy)
            $('input[name=no_police]').val(data.no_police)
            $('input[name=transportation_type]').val(data.transportation_type)
            $('input[name=sales_name]').val(data.sales_name)
            $('input[name=bank_name]').val(data.bank_name)
            $('input[name=account_number]').val(data.account_number)
            $('input[name=premium_amount]').val(data.premium_amount)
            $('input[name=fee_amount]').val(data.fee_amount)
        }

        $('.modal').on('hidden.bs.modal', function (event) {
            $('#invoice-form').attr('action', '{{ route("admin.invoice.store") }}')
            method = 'POST'
        })

    })

</script>