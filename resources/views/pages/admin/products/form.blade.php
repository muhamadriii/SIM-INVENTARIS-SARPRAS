<!--begin::Modal-->
<div class="modal fade" tabindex="-1" id="product-modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <form method="post" action="{{ route('admin.products.store') }}" class="form needs-validation" id="product-form"
            enctype="multipart/form-data" autocomplete="off" novalidate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form {{ $view }}</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">

                    <div class="mb-10 fv-row">
                        <label for="sku" class="required form-label">SKU</label>
                        <input type="text" value="{{ code_sku() }}" readonly
                            class="form-control form-control-solid" name="sku" placeholder="sku" required />
                    </div>

                    <table class="table table-responsive table-rounded border gy-5 gs-5">
                        <thead>
                            <tr class="fw-semibold border-bottom">
                                <th class="col-md-9">Upload Image</th>
                                <th class="col-md-1">Action</th>
                            </tr>
                        </thead>
                        <tbody id="DynamicTable">
                            <tr>
                                <td>
                                    <input type="file" name="image[]" class="form-control" placeholder="image">
                                </td>
                                <td>
                                    <button type="button" id="add" class="btn btn-icon btn-success"><span
                                            class="fa-solid fa-plus"></span></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- <form id="dropzoneForm" class="dropzone" action="">
                        @csrf
                    </form> --}}
                    {{-- <div align="center">
                        <button type="button" class="btn btn-info" id="submit-all">Upload</button>
                    </div> --}}

                    <div class="mb-10 fv-row">
                        <label for="category_id" class="required form-label">Category</label>
                        <select name="category_id" id="category_id"
                            class="form-control form-control-solid form-select mb-2">
                            <option value="" disabled selected>--Choose option--</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="user_id" class="required form-label">Merchant</label>
                        <select name="user_id" id="user_id" class="form-control form-control-solid form-select mb-2">
                            <option value="" disabled selected>--Choose option--</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="unit_id" class="required form-label">Satuan Unit</label>
                        <select name="unit_id" id="unit_id" class="form-control form-control-solid form-select mb-2">
                            <option value="" disabled selected>--Choose option--</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="name" class="required form-label">Name</label>
                        <input type="text" class="form-control form-control-solid" name="name" placeholder="Name"
                            required />
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="description" class="required form-label">Description</label>
                        <input type="text" class="form-control form-control-solid" name="description"
                            placeholder="Description" required />
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="short_description" class="required form-label">Short Description</label>
                        <input type="text" class="form-control form-control-solid" name="short_description"
                            placeholder="Short Description" required />
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="price" class="required form-label">Price</label>
                        <input type="number" class="form-control form-control-solid" name="price" placeholder="Price"
                            required />
                    </div>

                    {{-- <div class="mb-10 fv-row">
                        <label for="discount" class="required form-label">Discount</label>
                        <input type="text" class="form-control form-control-solid" name="discount"
                            placeholder="Discount" required />
                    </div> --}}

                    <div class="mb-10 fv-row">
                        <label for="stock" class="required form-label">Stock</label>
                        <input type="text" class="form-control form-control-solid" name="stock"
                            placeholder="Stock Awal" required />
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
