<!--begin::Modal-->
<div class="modal fade" tabindex="-1" id="level-modal" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <form method="post" action="{{ route($route.'.store') }}" class="form needs-validation" id="level-form" enctype="multipart/form-data" autocomplete="off" novalidate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form {{ $title }}</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="mb-10 fv-row">
                        <label for="level" class="required form-label">Level</label>
                        <input type="number" class="form-control form-control-solid" name="level" placeholder="Level" required/>
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="total_member" class="required form-label">Total Member</label>
                        <input type="number" class="form-control form-control-solid" name="total_member" placeholder="Total Member" required/>
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="total_member_pack" class="required form-label">Total Member/Pack</label>
                        <input type="number" class="form-control form-control-solid" name="total_member_pack" placeholder="Total Member/Pack" required/>
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="total_member_level" class="required form-label">Total Member Per Jenjang</label>
                        <input type="number" class="form-control form-control-solid" name="total_member_level" placeholder="Total Member Per Jenjang" required/>
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="shopping_month" class="required form-label">Belanja Per Bulan (Rp)</label>
                        <input type="number" class="form-control form-control-solid" name="shopping_month" placeholder="Belanja Per Bulan (Rp)" required/>
                    </div>
                    
                    <div class="mb-10 fv-row">
                        <label for="total_turnover" class="required form-label">Total Omzet</label>
                        <input type="number" class="form-control form-control-solid" name="total_turnover" placeholder="Total Omzet" required/>
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="commission_level_percent" class="required form-label">Komisi Per Level (%)</label>
                        <input type="number" class="form-control form-control-solid" name="commission_level_percent" placeholder="Komisi Per Level (%)" required/>
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="commission_level_nominal" class="required form-label">Komisi Per Level</label>
                        <input type="number" class="form-control form-control-solid" name="commission_level_nominal" placeholder="Komisi Per Level" required/>
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="total_commission" class="required form-label">Total Pemb Komisi</label>
                        <input type="number" class="form-control form-control-solid" name="total_commission" placeholder="Total Pemb Komisi" required/>
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="profit_assumption" class="required form-label">Asumsi Untung 20%</label>
                        <input type="number" class="form-control form-control-solid" name="profit_assumption" placeholder="Asumsi Untung 20%" required/>
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="income_administration" class="required form-label">Pendapatan dari ADM</label>
                        <input type="number" class="form-control form-control-solid" name="income_administration" placeholder="Pendapatan dari ADM" required/>
                    </div>

                    <div class="mb-10 fv-row">
                        <label for="accumulation_administrative_income" class="required form-label">Akumulasi dari Total Pemb Komisi Pendapatan ADM </label>
                        <input type="number" class="form-control form-control-solid" name="accumulation_administrative_income" placeholder="Akumulasi dari Total Pemb Komisi Pendapatan ADM " required/>
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
