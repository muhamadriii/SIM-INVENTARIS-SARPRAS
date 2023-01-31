<!--begin::Modal-->
<div class="modal fade" tabindex="-1" id="contact-modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <form method="post" action="{{ route('admin.contact-us.store') }}" class="form needs-validation" id="contact-form" autocomplete="off" novalidate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form {{ $view }}</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">

                    <div class="mb-10 fv-row">
                        <label for="name" class="required form-label">Name</label>
                        <input type="text" class="form-control form-control-solid" name="name" placeholder="Name" required/>
                    </div>
                    <div class="mb-10 fv-row">
                        <label for="name" class="required form-label">Email</label>
                        <input type="text" class="form-control form-control-solid" name="email" placeholder="Email" required/>
                    </div>
                    <div class="mb-10 fv-row">
                        <label for="name" class="required form-label">Phone</label>
                        <input type="text" class="form-control form-control-solid" name="phone" placeholder="Phone" required/>
                    </div>
                    <div class="mb-10 fv-row">
                        <label class="required form-label">Message</label>
                        <input type="text" class="form-control form-control-solid" name="message" placeholder="message" required/>
                        {{-- <textarea type="text" name="message" class="form-control form-control-solid" placeholder="Message" cols="30" rows="10"></textarea> --}}
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
