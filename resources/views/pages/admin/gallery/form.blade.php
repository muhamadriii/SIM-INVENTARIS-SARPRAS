<!--begin::Modal-->
<div class="modal fade" tabindex="-1" id="gallery-modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <form method="post" action="{{ route('admin.gallery.store') }}" class="form needs-validation" id="gallery-form"
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
                        <div class="image-input image-input-outline image-input-empty" data-kt-image-input="true"
                            style="background-image: url('{{ asset('assets/media/avatars/blank.png') }}')">
                            <!-- <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true"> -->
                            <!--begin::Preview existing image-->
                            <div class="image-input-wrapper w-150px h-150px"></div>
                            <!--end::Preview existing image-->
                            <!--begin::Label-->
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change image"
                                data-kt-initialized="1">
                                <i class="bi bi-pencil-fill fs-7"></i>
                                <!--begin::Inputs-->
                                <input type="file" name="image" accept=".png, .jpg, .jpeg">
                                <!--end::Inputs-->
                            </label>
                            <!--end::Label-->
                            <!--begin::Cancel-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel image"
                                data-kt-initialized="1">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Cancel-->
                            <!--begin::Remove-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove image"
                                data-kt-initialized="1">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Remove-->
                        </div>
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="name" class="required form-label">Title 1</label>
                        <input type="text" class="form-control form-control-solid" name="name"
                            placeholder="Title 1" required />
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="title_name" class="required form-label">Title 2</label>
                        <input type="text" class="form-control form-control-solid" name="title_name"
                            placeholder="Title 2" required />
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="description" class="required form-label">Short Description</label>
                        <input type="text" class="form-control form-control-solid" name="description"
                            placeholder="Short Description" required />
                    </div>


                    <div class="mb-10 fv-row">
                        <label for="url" class="required form-label">Url</label>
                        <input type="text" class="form-control form-control-solid" name="url" placeholder="url"
                            required />
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
