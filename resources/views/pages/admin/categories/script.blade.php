{{$dataTable->scripts()}}
<script>

    $(document).ready(function() {
        let method = 'POST'

        $(document).on('click', '.image-modal', function(){
            var index = $(".image-modal").index(this);
            $('.modal-show-image').attr('src',$(".image-modal").eq(index).attr('src'));  
            $('.modal-image-preview').modal('show');
        });

        //STORE
        $('#category-form').submit(function(e) {
            e.preventDefault()
            const payload = new FormData(this)
            const url = $(this).attr('action')
            const validator = document.getElementById('category-form').checkValidity()

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
                            $('#category-modal').modal('hide')
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
                    const url = '{{ url("admin/categories") }}/' + $(this).data('id')
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
            const url = '{{ url("admin/categories") }}/' + $(this).data('id')
            $('#category-form').attr('action', url)
            method = 'PUT'

            let data = {}
            $.get(url).done(response => {
                if(response.success) data = response.data
                setForm(data)
                $('#category-modal').modal('show')
            })
        })

        function setForm(data) {
            $('input[name=name]').val(data.name)
            $('input[name=code]').val(data.code)
        }

        $('.modal').on('hidden.bs.modal', function (event) {
            $('#category-form').attr('action', '{{ route("admin.categories.store") }}')
            method = 'POST'
        })

    })

</script>