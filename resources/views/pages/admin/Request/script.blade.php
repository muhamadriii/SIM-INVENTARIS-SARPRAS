    
{{ $dataTable->scripts() }}
<script>
    $(document).ready(function() {

        $(document).on('keyup', '#result-qrcode', function(){
                let url = '{{ url('').'/admin/sku-items/'}}'+$(this).val()
                if ( $(this).val().length >= 14 ) {
                    $.ajax({
                        url: url,
                        method: 'GET',
                        data: null
                    })
                    .done(response => {
                        if(response.success) {
                            //if sku is exist
                            if ( !$('#'+response.data.sku).length ){
                                //if item id is exist
                                if ( !$('#'+response.data.parent_id).length ) {
                                    $('.container-item').append(`
                                    <div class="mb-5 fv-row" id="${response.data.parent_id}">
                                        <div class="card card-item mt-5">
                                            <div class="card-body p-3 d-flex justify-content-between">
                                                <div class="d-flex">
                                                    <img class="rounded img-item" src="http://127.0.0.1:8000/storage/images/user/7d5f1609bffe011b2a7cc589c0f6ac95-picsay.jpg" alt="">
                                                    <div class="ms-2">
                                                        <h3 class="m-0 p-0">${response.data.parent.name}</h3>
                                                        <p class="m-0">(${response.data.parent.category.name})</p>
                                                    </div>
                                                </div>
                                                <div class="text-center me-3">
                                                    <h1 class="mb-0 mt-2 qty-${response.data.parent_id}">1</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-sku-${response.data.parent_id}">
                                            <input type="hidden" name="sku_item[]" id="${response.data.sku}" value="${response.data.sku}">
                                        </div>
                                    </div>
                                    `)
                                    $(this).val('')
                                //if item id not exist
                                } else {
                                    $('.input-sku-'+response.data.parent_id).append(`
                                        <input type="hidden" name="sku_item[]" id="${response.data.sku}" value="${response.data.sku}">
                                    `)
                                    let bqty = $('.qty-'+response.data.parent_id).html()
                                    let qty = parseInt(bqty) + 1
                                    $('.qty-'+response.data.parent_id).html(qty)
                                    $(this).val('')
                                }
                            //if sku not exist
                            }else{
                                // alert('sudah ada')
                            }

                            // Swal.fire({
                            //     icon: 'success',
                            //     title: 'Success',
                            //     text: response.message
                            // })
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
                // return
        })

         //STORE
        $('#request-form').submit(function(e) {
            e.preventDefault()
            const payload = $(this).serialize()
            const url = $(this).attr('action')
            const validator = document.getElementById('request-form').checkValidity()

            if(validator) {
                $.ajax({
                    url: url,
                    // method: method,
                    method: 'POST',
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
                        $('#request-modal').modal('hide')
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
        
        $('.modal').on('hidden.bs.modal', function (event) {
            $('.container-item').children().remove()
        })

    })
</script>
