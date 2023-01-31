{{$dataTable->scripts()}}
<script>

    $(document).ready(function() {
        let method = 'POST'

        //STORE
        $('#level-form').submit(function(e) {
            e.preventDefault()
            const payload = new FormData(this)
            const url = $(this).attr('action')
            const validator = document.getElementById('level-form').checkValidity()

            if(validator) {
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
                    if(response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        })

                        $('.dataTable').DataTable().ajax.reload()
                        $('#level-modal').modal('hide')
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
                if (result.isConfirmed) {
                    const url = '{{ url("admin/levels") }}/' + $(this).data('id')
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
            const url = '{{ url("admin/levels") }}/' + $(this).data('id')
            $('#level-form').attr('action', url)
            method = 'PUT'

            let data = {}
            $.get(url).done(response => {
                if(response.success) data = response.data
                setForm(data)
                $('#level-modal').modal('show')
            })
        })

        function setForm(data) {
            $('input[name=level]').val(data.level)
            $('input[name=total_member]').val(data.total_member)
            $('input[name=total_member_pack]').val(data.total_member_pack)
            $('input[name=total_member_level]').val(data.total_member_level)
            $('input[name=shopping_month]').val(data.shopping_month)
            $('input[name=total_turnover]').val(data.total_turnover)
            $('input[name=commission_level_percent]').val(data.commission_level_percent)
            $('input[name=commission_level_nominal]').val(data.commission_level_nominal)
            $('input[name=total_commission]').val(data.total_commission)
            $('input[name=profit_assumption]').val(data.profit_assumption)
            $('input[name=income_administration]').val(data.income_administration)
            $('input[name=accumulation_administrative_income]').val(data.accumulation_administrative_income)
        }

        $('.modal').on('hidden.bs.modal', function (event) {
            $('#level-form').attr('action', '{{ route("admin.users.store") }}')
            //hapus gambar ketika modal ditutup
            $('.btn-cancel-img').click()
            method = 'POST'
        })

    })

</script>