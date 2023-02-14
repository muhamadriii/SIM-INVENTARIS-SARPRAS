@extends('layouts.admin.app')
@section('content')
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Form-->
            <form method="post" action="{{ route('admin.orders.update', $order->id) }}" enctype="multipart/form-data" class="form d-flex flex-column flex-lg-row form needs-validation" id="order-edit-form" autocomplete="off" novalidate>
            <!-- <form id="kt_ecommerce_edit_order_form" class="" data-kt-redirect="/metronic8/demo20/../demo20/apps/ecommerce/sales/listing.html"> -->
                <!--begin::Aside column-->
                @csrf
                <div class="w-100 flex-lg-row-auto w-lg-300px mb-7 me-7 me-lg-10">
                    <!--begin::Order details-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Order Details</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <div class="d-flex flex-column gap-10">
                                <div class="fv-row">
                                  
                                    <label class="form-label">Order Code</label>
                                    <div class="fw-bold fs-3">#{{ $order->order_code }}</div> 
                                    <input  type="hidden" name="order_code" value="{{ $order->order_code }}"/>
                                </div>
                          
                                <div class="fv-row">
                                    <label class="form-label">Member</label>
                                    <select  name="member_id" id="member_id" class="form-select mb-4" data-control="select2" data-placeholder="Select an member">
                                        <option value="" disabled selected>Select a member</option>
                                            @foreach ($members as $member)
                                                <option value="{{ $member->id }}" {{ $order->member_id == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                            @endforeach
                                    </select>
                                    <div class="text-muted fs-7">Set the member of the order to process.</div>
                                </div>

                                <div class="fv-row">
                                    <label class="form-label">Address</label>
                                    <select  name="member_address_id" id="member_address_id" class="form-select mb-4" data-control="select2" data-placeholder="Select an member">
                                        <option value="{{ $order->member_address_id }}" selected>{{ $order->member_address->member_address }}</option>
                                    </select>
                                    <div class="text-muted fs-7">Set the member of the order to process.</div>
                                </div>
                               
                                <div class="fv-row">
                           
                                    <label class="form-label">Order Date</label>
                                    <input type="date" name="date" placeholder="Select a date" class="form-control mb-2" value="{{ $order->date }}" />
                                    <div class="text-muted fs-7">Set the date of the order to process.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="d-flex flex-column flex-lg-row-fluid gap-7 gap-lg-10">
       
                    <div class="card card-flush py-4">
              
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Select Products</h2>
                            </div>
                        </div>
                 
                        <div class="card-body pt-0">
                            <div class="d-flex flex-column gap-10">
                                <div>
                                    <label class="form-label">Add products to this order</label>
                                    <div class="row row-cols-1 row-cols-xl-3 row-cols-md-2 border border-dashed rounded pt-3 pb-1 px-2 mb-5 mh-300px overflow-scroll" id="kt_ecommerce_edit_order_selected_products">
                                        <span class="w-100 text-muted">Select one or more products from the list</span>
                                    </div>
                                    <div class="fv-row">
                                                <table class="table table-responsive table-rounded border gy-5 gs-5">
                                            <thead>
                                                <tr class="fw-semibold border-bottom">
                                                    <th class="col-md-9">Name Product</th>
                                                    <th class="col-md-2">Qty</th>
                                                    <th class="col-md-1">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="DynamicTable">
                                                @foreach ($order->order_details as $key => $detail)
                                                <tr>
                                                    <td>
                                                        <select name="product_id[]" class="form-select" data-control="select2" data-placeholder="Select an product">   
                                                            <option value="" disabled selected>Select an product</option>
                                                            @foreach ($products as $product)
                                                                <option value="{{ $product->id }}" {{ $detail->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }} | Rp. {{ number_format($product->price) }} </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="qty[]" class="form-control" id="qty" value="{{ $detail->qty }}"
                                                            placeholder="Qty">
                                                    </td>
                                                    @if ($key == 0)
                                                    <td>
                                                        <button type="button" id="add"
                                                            class="btn btn-icon btn-success"><span class="fa-solid fa-plus"></span></button>
                                                    </td>
                                                    @else
                                                    <td>
                                                        <button type="button" id="{{ $key }}" class="btn btn-icon btn-danger remove_row"><i class="fa-solid fa-minus"></i></button>
                                                    </td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="separator"></div>

                                    <div class="d-flex justify-content-end mt-4">
                                        <div class="fw-bold fs-2">Total Rp : 
                                        <span id="">0.00</span></div>
                                    </div>
                                </div>
                                <div class="separator"></div>
                            </div>
                        </div>
                    </div>
               
                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Delivery Details</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            {{-- <div class="fv-row">
                                <label class="form-label mt-2">Address</label>
                                <textarea class="form-control mb-2" id="" name="address" rows="2"></textarea>
                                <div class="text-muted fs-7 mb-4">Set the address of the order to process.</div>

                            </div> --}}

                            <div class="fv-row">
                                <label class="form-label mt-2">Description</label>
                                <textarea class="form-control mb-2" id="" name="description" rows="3">{{ $order->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <!--end::Order details-->
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.orders.index') }}"  class="btn btn-light me-5">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
                <!--end::Main column-->
            </form>
            <!--end::Form-->
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            $('#order-edit-form').submit(function(e) {
                e.preventDefault()
                const payload = $(this).serialize()
                const url = $(this).attr('action')
                const validator = document.getElementById('order-edit-form').checkValidity()

                if(validator) {
                    $.ajax({
                        url: url,
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
                            window.location.href = "{{ route('admin.orders.index') }}";
                            // $('.dataTable').DataTable().ajax.reload()
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

            var i = {{ $key ? $key : 1 }};
            $('#add').click(function() {
                i++;
                $('#DynamicTable').append('<tr id="row' + i +
                    '"><td> <select name="product_id[]" class="form-select select2-multiple" data-placeholder="Select an product"><option value="" disabled selected>Select an product</option>@foreach ($products as $product) <option value="{{ $product->id }}">{{ $product->name }} | Rp. {{ number_format($product->price) }}</option> @endforeach </select></td><td><input type="number" name="qty[]" class="form-control" id="qty" placeholder="Qty"></td><td><button type="button" id="' +
                    i + '" class="btn btn-icon btn-danger remove_row"><i class="fa-solid fa-minus"></i></button></td></tr>');

                $('.select2-multiple').select2();


            });
            $(document).on('click', '.remove_row', function() {
                // var row_id = $(this).attr("id");
                // $('#row' + row_id + '').remove();
                $('.remove_row').eq($('.remove_row').index(this)).parent().parent().remove();
            });

            $("#member_id").on('change', function() {
                var member_id = $(this).val();
                if(member_id){
                    $.ajax ({
                        type: 'get',
                        url: '{{ route("admin.orders.get-address") }}',
                        data: { member_id : member_id },
                        success : function(response) {
                            let option = [];
                            response.forEach(function(item) {
                                option.push(`
                                    <option value="${item.id}">${item.member_address}</option>
                                `);
                            });
                            $('#member_address_id').html(option);
                            console.log(response);
                        }
                    });
                }
            });

        });
    </script>
@endpush
