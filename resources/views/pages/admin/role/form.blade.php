<!--begin::Modal-->
<div class="modal fade" tabindex="-1" id="role-modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <form method="post" action="{{ route($route.'.store') }}" class="form needs-validation" id="role-form"
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
                            <div class="d-flex fv-row">
                                <div class="form-check form-check-custom form-check-solid me-10">
                                    <input class="form-check-input h-30px w-30px" type="radio" name="guard_name" value="web" id="flexCheckbox30" />
                                    <label class="form-check-label" for="flexCheckbox30">Web</label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid me-10">
                                    <input class="form-check-input h-30px w-30px" type="radio" name="guard_name" value="admin" id="flexCheckbox40" />
                                    <label class="form-check-label" for="flexCheckbox40">Admin</label>
                                </div>
                                
                            </div>
                        </div>

                        <div class="mb-10 fv-row">
                            <label for="permission" class="required form-label">Permission</label>
                            <div class="d-flex row">
                                @foreach($permissions as $permission)
                                <div class="form-check form-check-custom form-check-solid me-10 col-3 my-2">
                                    <input class="form-check-input h-30px w-30px box-permission" type="checkbox" name="permission[]" value="{{ $permission->name }}" id="{{ $permission->id }}" />
                                    <label class="form-check-label" for="flexPerms{{ $permission->id }}">{{ $permission->name }}</label>
                                </div>
                                @endforeach
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
