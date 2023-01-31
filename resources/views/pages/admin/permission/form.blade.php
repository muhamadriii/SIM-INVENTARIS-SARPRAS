<!--begin::Modal-->
<div class="modal fade" tabindex="-1" id="permission-modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <form method="post" action="{{ route($route.'.store') }}" class="form needs-validation" id="permission-form"
            autocomplete="off" novalidate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form {{ $title }}</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">

                    <div class="fv-row mb-10">
                        <div class="mb-10 fv-row">
                            <label for="name" class="required form-label">Name</label>
                            <input type="text" class="form-control form-control-solid" name="name"
                                placeholder="Name" required />
                        </div>

                        <div class="mb-10 fv-row">
                            <label for="guard_name" class="required form-label">Guard Name</label>
                            <input type="text" class="form-control form-control-solid" name="guard_name"
                                placeholder="Guard Name" required />
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
