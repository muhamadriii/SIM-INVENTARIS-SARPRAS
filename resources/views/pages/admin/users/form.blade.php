<!--begin::Modal-->
<div class="modal fade" tabindex="-1" id="user-modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <form method="post" action="{{ route('admin.users.store') }}" class="form needs-validation" id="user-form"
            enctype="multipart/form-data" autocomplete="off" novalidate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Users</h5>

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
                        <div class="image-input image-input-outline image-input-empty" data-kt-image-input="true"
                            style="background-image: url('{{ asset('assets/media/avatars/blank.png') }}')">
                            <!--begin::Preview existing avatar-->
                            <div class="image-input-wrapper w-125px h-125px"></div>
                            <!--end::Preview existing avatar-->

                            <!--begin::Label-->
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                <i class="bi bi-pencil-fill fs-7"></i>

                                <!--begin::Inputs-->
                                <input type="file" name="image" id="image" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="avatar_remove" />
                                <!--end::Inputs-->
                            </label>
                            <!--end::Label-->

                            <!--begin::Cancel-->
                            <span
                                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow btn-cancel-img"
                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Cancel-->

                            <!--begin::Remove-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Remove-->
                        </div>
                        <!--end::Image input-->

                        <!--begin::Hint-->
                        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                        <!--end::Hint-->
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="role" class="required form-label">Role</label>
                        <select name="role" id="role" class="form-control form-control-solid form-select mb-2">
                            <option value="" disabled selected>--Choose option--</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="name" class="required form-label">Name</label>
                        <input type="text" class="form-control form-control-solid" name="name" placeholder="Name"
                            required />
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="email" class="required form-label">Email</label>
                        <input type="email" class="form-control form-control-solid" name="email" placeholder="email"
                            required />
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="username" class="required form-label">Username</label>
                        <input type="text" class="form-control form-control-solid" name="username"
                            placeholder="Username" required autocomplete="new-password" />
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control form-control-solid" name="password"
                            placeholder="Password" autocomplete="new-password" />
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control form-control-solid" name="phone"
                            placeholder="Phone" />
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control form-control-solid" name="address" placeholder="Address" id="address"></textarea>
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
