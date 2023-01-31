<!--begin::Modal-->
<div class="modal fade" tabindex="-1" id="member-modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <form method="post" action="{{ route('admin.member.store') }}" class="form needs-validation" id="member-form"
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

                    <div class="mb-10 fv-row">
                        <label class="required form-label">Name</label>
                        <input type="text" class="form-control form-control-solid" name="name" placeholder="Name"
                            required />
                    </div>

                    <div class="mb-10 fv-row">
                        <label class="required form-label">Email</label>
                        <input type="email" class="form-control form-control-solid" name="email" placeholder="Email"
                            required />
                    </div>

                    <div class="mb-10 fv-row">
                        <label class="required form-label">Phone</label>
                        <input type="text" class="form-control form-control-solid" name="phone" placeholder="Phone"
                            required />
                    </div>

                    <div class="mb-10 fv-row">
                        <label class="required form-label">ID Card</label>
                        <input type="text" class="form-control form-control-solid" name="id_card" placeholder="ID Card"
                            required />
                    </div>

                    <div class="mb-10 fv-row">
                        <label class="form-label">Leader Code</label>
                        <input type="text" class="form-control form-control-solid" name="code" placeholder="Leader Code"/>
                    </div>

                    <div class="mb-10 fv-row">
                        <label class="form-label">Password</label>
                        <input type="text" class="form-control form-control-solid" name="password"
                            placeholder="password" />
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


