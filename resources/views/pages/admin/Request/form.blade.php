@push('style')
    <style>
        .card-item{
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        }
        .img-item{
            width:40px;
            max-height:40px; 
        }
    </style>
@endpush
<!--begin::Modal-->
<div class="modal fade" tabindex="-1" id="request-modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollble">
        
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title ">Form Permintaan Barang</h5>

                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="fa fa-xmark"></span>
                    </div>
                </div>

                <div class="modal-body">
                    <form id="request-form" method="post" action="{{ route('admin.requests.store') }}" enctype="multipart/form-data"
                        class="form needs-validation" id="merchant-form" autocomplete="off" novalidate>
                        @csrf
                        <div class="mb-5 fv-row">
                            <label for="name" class="required form-label">Nama</label>
                            <input type="text" id="input-name" class="form-control form-control-solid" name="name" placeholder="Name"
                                required/>
                        </div>

                        <div class="mb-5 fv-row">
                            <label for="phone_number" class="required form-label">No HP</label>
                            <input type="number" class="form-control form-control-solid" name="phone_number"
                                placeholder="phone_number" required />
                        </div>

                        <div class="mb-5 fv-row">
                            <label for="email" class="required form-label">Email</label>
                            <input type="email" class="form-control form-control-solid" name="email"
                                placeholder="email" required />
                        </div>

                        <div class="mb-5 fv-row">
                            <label for="necessity" class="required form-label">Keperluan</label>
                            <input type="text" class="form-control form-control-solid" name="necessity" placeholder="necessity"
                                required />
                        </div>
                        <h5 class="mt-10"> Barang Yang dipinta </h5>
                        <hr>

                        <div class="container-item">
                            {{-- <div class="mb-5 fv-row">
                                <div class="card card-item mt-5">
                                    <div class="card-body p-3 d-flex justify-content-between">
                                        <div class="d-flex">
                                            <img class="rounded img-item" src="http://127.0.0.1:8000/storage/images/user/7d5f1609bffe011b2a7cc589c0f6ac95-picsay.jpg" alt="">
                                            <div class="ms-2">
                                                <h3 class="m-0 p-0">Laptop</h3>
                                                <p class="m-0">(non inventaris)</p>
                                            </div>
                                        </div>
                                        <div class="text-center me-3">
                                            <h1 class="mb-0 mt-2">25</h1>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="d-grid gap-2 mt-10 ">
                            <input type="text" style="border:1px solid grey;" class="form-control form-control-solid" id="result-qrcode" placeholder="ketik atau scan sku disini!"
                                onkeypress="return (event.key!='Enter')" />
                            <button class="btn btn-warning scan-btn" type="submit">Submit</button>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
    </div>
</div>
<!--end::Modal-->

<!--begin::Modal-->
<div class="modal fade" tabindex="-1" id="resi-modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <form method="put" action="" enctype="multipart/form-data" class="form needs-validation" id="resi-form"
            autocomplete="off" novalidate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Resi {{ $view }} Form</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="mb-10 fv-row">
                        <label for="resi" class="required form-label">Resi</label>
                        <input type="text" class="form-control form-control-solid" name="resi"
                            placeholder="resi" required />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--end::Modal-->
