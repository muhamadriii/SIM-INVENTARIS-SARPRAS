{{ $dataTable->scripts() }}
<script>
    $(document).ready(function() {
        let method = 'POST'

        //STORE
        $('#member-form').submit(function(e) {
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
                        method: 'POST',
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
                            $('#member-modal').modal('hide')
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
                    const url = '{{ url('admin/member') }}/' + $(this).data('id')
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
            const url = '{{ url('admin/member') }}/' + $(this).data('id')
            $('#member-form').attr('action', url)
            method = 'PUT'

            let data = {}
            $.get(url).done(response => {
                if (response.success) data = response.data
                setForm(data)
                $('#member-modal').modal('show')
            })
        })

        function setForm(data) {
            $('input[name=name]').val(data.name)
            $('input[name=email]').val(data.email)
            $('input[name=membername]').val(data.membername)
            $('input[name=phone]').val(data.phone)
            $('input[name=address]').val(data.address)
        }

        $('.modal').on('hidden.bs.modal', function(event) {
            $('#member-form').attr('action', '{{ route('admin.member.store') }}')
            //hapus gambar ketika modal ditutup
            $('.btn-cancel-img').click()
            method = 'POST'
        })

    })
</script>
