{{ $dataTable->scripts() }}
<script>
    $(document).ready(function() {
        let method = 'POST'

        // STORE ADDRESS MEMBER
        $('#member-address-form').submit(function(e) {
            e.preventDefault()
            const payload = $(this).serialize()
            const url = $(this).attr('action')
            const validator = document.getElementById('member-address-form').checkValidity()

            if (validator) {
                $.ajax({
                        url: url,
                        method: method,
                        data: payload,
                    })
                    .done(response => {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            })

                            $('.dataTable').DataTable().ajax.reload()
                            $('#member-address-modal').modal('hide')
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
            console.log($(this).data('id'))
            Swal.fire({
                title: 'Are you sure',
                icon: 'info',
                showDenyButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `No`,
            }).then((result) => {
                if (result.isConfirmed) {
                    const url = '{{ url('admin/member/member-address/destroy') }}/' + $(this).data('id')
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
            const url = '{{ url('admin/member/member-address/show') }}/' + $(this).data('id')
            const urlUpdate = '{{ url('admin/member/member-address/update') }}/' + $(this).data('id')
            $('#member-address-form').attr('action', urlUpdate)
            method = 'PUT'
            
            let data = {}
            $.get(url).done(response => {
                if (response.success) data = response.data
                setForm(data)
                $('#member-address-modal').modal('show')
            })
        })

        function setForm(data) {
            $('#member_address').val(data.member_address)
        }

        $('.modal').on('hidden.bs.modal', function(event) {
            $('#member-address-form').attr('action', '{{ route("admin.member.member-address.store", $member_id) }}')
            method = 'POST'
        })

    })
</script>
