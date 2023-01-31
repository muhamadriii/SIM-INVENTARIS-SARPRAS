@extends('layouts.admin.app')
@section('content')
    <!--begin::Container-->
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Order details page-->
            <div class="d-flex flex-column gap-7 gap-lg-10">
                <!--begin::Order summary-->
                <div class="d-flex flex-column flex-xl-row gap-7 gap-lg-10">
                    <!--begin::Order details-->
                    <div class="card card-flush py-4 flex-row-fluid">

                        <div class="card-body pt-0">
                            <div class="card-title">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3 class="mt-2">Payment Detail</h3>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('admin.payment-pdf', $id) }}"
                                                class="btn btn-secondary btn-sm"><i class="fa fa-download"></i>
                                                Print
                                                PDF</a>
                                            <a href="#" onclick="history.back()"
                                                class="btn btn-sm btn-primary">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 gy-3">

                                    <tbody>
                                        <tr>
                                            <td class="col-md-2"><b>Name</b></td>
                                            <td>: {{ $payment->member->name }}</td>
                                            <td>

                                                {{-- @if ($payment->member->status == 1)
                                                @endif --}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Phone Number </b> </td>
                                            <td>: {{ $payment->member->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Email</b></td>
                                            <td>: {{ $payment->member->email }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Code</b></td>
                                            <td>: {{ $payment->member->code }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>



                            <hr>
                            <div class="table-responsive mt-5">
                                <table class="table table-hover table-rounded table-striped border fs-4 gy-4 gs-3"
                                    id="tbtb">

                                    <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                            <td>Tahun</td>
                                            <td>Bulan</td>
                                            <td>Total</td>
                                            <td>Status</td>
                                            <td>Bukti Pembayaran</td>
                                            <td>Approve Payment</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $payment->year }}</td>
                                            <td>{{ $months[$payment['month']] }}</td>
                                            <td>Rp. {{ number_format($payment->amount) }}</td>
                                            @if ($payment->status == 2)
                                                <td class="text-success">
                                                    <b>{{ $status[$payment['status']] }}</b>
                                                </td>
                                            @elseif($payment->status == 1)
                                                <td><b class="text-warning">{{ $status[$payment['status']] }}</b>
                                                </td>
                                            @elseif($payment->status == 0)
                                                <td><b class="text-danger">{{ $status[$payment['status']] }}</b>
                                                </td>
                                            @endif
                                            <td>
                                                @if ($payment['image'] === null)
                                                    -
                                                @else
                                                    @if ($payment['status'] === '2')
                                                        <a target="_blank" class="btn btn-warning btn-sm"
                                                            href="{{ env('APP_URL') . '/storage/payments/' . $payment['image'] }}">View</a>
                                                    @else
                                                        <a target="_blank" class="btn btn-warning btn-sm"
                                                            href="{{ env('APP_URL') . '/storage/payments/' . $payment['image'] }}">View</a>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if ($payment->status == '1')
                                                    <a class="btn btn-sm btn-success status-btn ml-2 mr-2"
                                                        data-id="{{ $id }}" href="#">Approve</a>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Order details-->
                    <!--end::Customer details-->
                </div>
                <!--end::Order summary-->
                <!--begin::Tab content-->

                <!--end::Tab content-->
            </div>
            <!--end::Order details page-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->

    <script>
        $(document).ready(function() {

            $(document).on('click', '.status-btn', function() {
                $.ajax({
                        url: '{{ url('admin/payment/update-status') }}/' + $(this).data('id'),
                        method: 'GET'
                    })
                    .done(response => {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            })
                            // $('.dataTable').DataTable().ajax.reload()
                            window.location.href = "{{ route('admin.payment.show', $id) }}";

                        }
                    })
                    .fail(response => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.responseJSON.message
                        })
                    })

            })

        })
    </script>
@endsection
