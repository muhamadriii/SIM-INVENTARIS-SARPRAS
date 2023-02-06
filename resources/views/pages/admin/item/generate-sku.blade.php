@push('style')
<style>
    .qrcode-image{
        border: 3px solid lightgray;
        width: 150px;
        height: 150px;
    }
    .dishable{
        cursor:not-allowed !important;
    }
</style>
@endpush

<!--begin::Modal-->
<div class="modal fade" tabindex="-1" id="generate-item-modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-scrollable modal-lg">
        <form method="post" action="{{ route('admin.items.index') }}" class="form needs-validation" id="generate-item-form"
            enctype="multipart/form-data" autocomplete="off" novalidate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Generate SKU</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa fa-xmark"></i>
                        {{-- <span class="svg-icon svg-icon-2x"></span> --}}
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">

                    <div class="row mb-10">
                        <div class="col-4 col-xl-2 col-lg-3">
                            <div class="image-input image-input-outline image-input-empty" data-kt-image-input="true"
                                    style="background-image: url('{{ asset('assets/media/avatars/blank.png') }}')">
                                    <div class="image-input-wrapper w-125px h-125px"></div>
                            </div>
                        </div>
                        <div class="col-8 col-xl-9 col-lg-9">
                            <table class="mt-1">
                                <tr>
                                    <th>Name</th>
                                    <td>:</td>
                                    <td class="name">data not found</td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td>:</td>
                                    <td class="category">data not found</td>
                                </tr>
                                <tr>
                                    <th>Harga</th>
                                    <td>:</td>
                                    <td class="price">data not found</td>
                                </tr>
                                <tr>
                                    <th>Stock</th>
                                    <td>:</td>
                                    <td class="stock">data not found</td>
                                </tr>
                                <tr>
                                    <th>suplier</th>
                                    <td>:</td>
                                    <td class="suplier">data not found</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mb-5 fv-row">
                        <label for="color" class="required form-label">color</label>
                        <input type="text" class="form-control form-control-solid" name="color" placeholder="color" required />
                    </div>

                    <div class="mb-5 fv-row">
                        <label for="status" class="required form-label">status</label>
                        <select name="status" id="status" class="form-control form-control-solid form-select mb-2">
                            {{-- <option value="" disabled selected>--Choose option--</option> --}}
                            <option value="0">SKU Baru</option>
                            <option value="1">Generate Ulang QR-Code</option>
                        </select>
                    </div>

                    <div class="mb-10 fv-row input-sku">
                    
                    </div>

                    <div class="result"></div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary generate-qrcode-btn">Generate</button>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <div class="button-action">
                        {{-- <button type="button" class="btn btn-outline-danger">Cetak Lagi</button> --}}
                        <button type="button" class="btn btn-warning">Print</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!--end::Modal-->
