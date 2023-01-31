<!--begin::Modal-->
<div class="modal fade" tabindex="-1" id="merchant-modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <form method="post" action="{{ route('admin.merchants.store') }}" enctype="multipart/form-data"
            class="form needs-validation" id="merchant-form" autocomplete="off" novalidate>
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

                <div class="fv-row mb-10">
                    <!--begin::Label-->
                    <label class="d-block fw-semibold fs-6 mb-5">Image Input</label>
                    <!--end::Label-->

                    <!--begin::Image input-->
                    <table class="table table-responsive table-rounded border gy-5 gs-5">
                        <thead>
                            <tr class="fw-semibold border-bottom">
                                <th class="col-md-9">Upload Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="file" name="image" class="form-control" placeholder="image">
                                </td>
                              
                            </tr>
                        </tbody>
                    </table>
                    <!--end::Image input-->

                    <!--begin::Hint-->
                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                    <!--end::Hint-->
                </div>

                {{-- <table class="table table-responsive table-rounded border gy-5 gs-5">
                    <thead>
                        <tr class="fw-semibold border-bottom">
                            <th class="col-md-9">Upload Image</th>
                            <th class="col-md-1">Action</th>
                        </tr>
                    </thead>
                </table> --}}
                <div class="mb-10 fv-row">
                    <label for="name" class="required form-label">Name</label>
                    <input type="text" class="form-control form-control-solid" name="name" placeholder="Name" required/>
                </div>

                <div class="mb-10 fv-row">
                    <label for="email" class="required form-label">Email</label>
                    <input type="email" class="form-control form-control-solid" name="email" placeholder="email" required/>
                </div>

                <div class="mb-10 fv-row">
                    <label for="username" class="required form-label">Username</label>
                    <input type="text" class="form-control form-control-solid" name="username" placeholder="Username" required autocomplete="new-password"/>
                </div>

                <div class="mb-10 fv-row">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control form-control-solid" name="password" placeholder="Password" autocomplete="new-password"/>
                </div>

                <div class="mb-10 fv-row">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control form-control-solid" name="phone" placeholder="Phone"/>
                </div>

                <div class="mb-10 fv-row">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control form-control-solid" name="address" placeholder="Address" id="address"></textarea>
                </div>
                </div>

                <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button  class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--end::Modal-->
