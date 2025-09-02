<div class="bg-white border-top">
    <div class="container-fluid px-4 px-lg-5">
        <nav class="py-2" aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">ส่วนผู้ดูแล</a></li>
                <li class="breadcrumb-item active text-truncate" aria-current="page">การลงทะเบียน</li>
            </ol>
        </nav>
    </div>
</div>

<section class="container-fluid px-4 px-lg-5 mt-4">
    <div class="modal fade" id="modifyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modifyModalLabel" aria-hidden="true">
        <form method="post" name="modifyForm" class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl needs-validation" novalidate>
            <input type="hidden" name="enrollId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifyModalLabel">แก้ไขข้อมูล</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="fw-bolder mb-3">การลงทะเบียน</h5>
                    <div class="rounded border p-4">
                        <div class="mb-3">
                            <label for="modifyForm_invoiceNo" class="form-label">เลขที่การลงทะเบียน</label>
                            <input type="text" class="form-control" name="invoiceNo" id="modifyForm_invoiceNo" autocomplete="off" required disabled>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 mb-3">
                                <label for="modifyForm_status" class="form-label">สถานะการลงทะเบียน</label>
                                <select class="form-select" name="status" id="modifyForm_status">
                                    <option value="PENDING">รอตรวจสอบ</option>
                                    <option value="PENDING_PAY">รอการชำระเงิน</option>
                                    <option value="CHECKING_PAY">รอตรวจสอบชำระเงิน</option>
                                    <option value="CONFIRM_PAID">ยืนยันการชำระเงิน</option>
                                    <option value="SUCCESS">เสร็จสมบูรณ์</option>
                                    <option value="CANCELED">ยกเลิก</option>
                                    <option value="OTHER">อื่นๆ (โปรดระบุ)</option>
                                </select>
                            </div>
                            <div class="col-lg-9 mb-3">
                                <label for="modifyForm_description" class="form-label">รายละเอียด</label>
                                <input type="text" class="form-control" name="description" id="modifyForm_description" autocomplete="off" disabled>
                            </div>
                        </div>
                    </div>
                    <h5 class="fw-bolder mt-5 mb-3">ข้อมูลผู้สมัครอบรม</h5>
                    <div class="rounded border p-4">
                        <div class="mb-3">
                            <label for="modifyForm_fullnameTha" class="form-label">ชื่อ-นามสกุล ภาษาไทย</label>
                            <input type="text" class="form-control" name="fullnameTha" id="modifyForm_fullnameTha" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_fullnameEng" class="form-label">ชื่อ-นามสกุล ภาษาอังกฤษ</label>
                            <input type="text" class="form-control" name="fullnameEng" id="modifyForm_fullnameEng" autocomplete="off" required>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 mb-3">
                                <label for="modifyForm_birthDate" class="form-label">วันเกิด <span class="text-danger">*</span></label>
                                <select class="form-select text-center" name="birthDate" id="modifyForm_birthDate" required>
                                    <?php
                                    $cBirth = date_create($UserLogged['birth']);
                                    for($d=1; $d<=31; $d++): ?>
                                        <option value="<?= $d; ?>"><?= $d; ?></option>
                                    <?php endfor ?>
                                </select>
                                <div class="invalid-feedback">กรุณาเลือกวันเกิด</div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="modifyForm_birthMonth" class="form-label">เดือน <span class="text-danger">*</span></label>
                                <select class="form-select text-center" name="birthMonth" id="modifyForm_birthMonth" required>
                                    <?php foreach($dateExtension::$month_long_tha as $i => $month): ?>
                                        <option value="<?= ($i+1); ?>"><?= $month; ?></option>
                                    <?php endforeach ?>
                                </select>
                                <div class="invalid-feedback">กรุณาเลือกเดือนเกิด</div>
                            </div>
                            <div class="col-lg-3 mb-3">
                                <label for="modifyForm_birthYear" class="form-label">ปี (พ.ศ.) <span class="text-danger">*</span></label>
                                <select class="form-select text-center" name="birthYear" id="modifyForm_birthYear" required>
                                    <?php for($y=date('Y'); $y>=1950; $y--): ?>
                                        <option value="<?= $y; ?>"><?= ($y+543); ?></option>
                                    <?php endfor ?>
                                </select>
                                <div class="invalid-feedback">กรุณาเลือกปีเกิด (พ.ศ.)</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_idCard" class="form-label">หมายเลขบัตรประชาชน</label>
                            <input type="text" class="form-control text-center" name="idCard" id="modifyForm_idCard" minlength="13" maxlength="13" autocomplete="off" required disabled>
                        </div>
                    </div>
                    <h5 class="fw-bolder mt-5 mb-3">ข้อมูลติดต่อ</h5>
                    <div class="rounded border p-4">
                        <div class="mb-3">
                            <label for="modifyForm_mobile" class="form-label">เบอร์มือถือ</label>
                            <input type="text" class="form-control" name="mobile" id="modifyForm_mobile" minlength="10" maxlength="10" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกเบอร์มือถือ</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_email" class="form-label">อีเมล</label>
                            <input type="email" class="form-control" name="email" id="modifyForm_email" maxlength="100" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกอีเมล</div>
                        </div>
                    </div>
                    <h5 class="fw-bolder mt-5 mb-3">ข้อมูลที่อยู่</h5>
                    <div class="rounded border p-4">
                        <div class="mb-3">
                            <label for="modifyForm_address" class="form-label">รายละเอียดที่อยู่ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="address" id="modifyForm_address" maxlength="200" autocomplete="off" placeholder="ชื่ออาคาร หมู่บ้าน หมู่ ซอย ถนน" required>
                            <div class="invalid-feedback">กรุณากรอกรายละเอียดที่อยู่</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_province" class="form-label">จังหวัด <span class="text-danger">*</span></label>
                            <select class="form-select" name="province" id="modifyForm_province" required>
                                <?php foreach($provinceList as $province): ?>
                                <option value="<?= $province['name']; ?>"><?= $province['name']; ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">กรุณาเลือกจังหวัด</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_district" class="form-label">เขต/อำเภอ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="district" id="modifyForm_district" maxlength="100" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกเขต/อำเภอ</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_subDistrict" class="form-label">แขวง/ตำบล <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="subDistrict" id="modifyForm_subDistrict" maxlength="100" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกแขวง/ตำบล</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_postalCode" class="form-label">รหัสไปรษณีย์ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-center" name="postalCode" id="modifyForm_postalCode" minlength="5" maxlength="5" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกรหัสไปรษณีย์</div>
                        </div>
                    </div>
                    <h5 class="fw-bolder mt-5 mb-3">ที่อยู่ในการออกใบแจ้งหนี้/ใบเสร็จ</h5>
                    <div class="rounded border p-4">
                        <div class="mb-3">
                            <label for="modifyForm_invoiceName" class="form-label">ชื่อผู้รับ/องค์กร/หน่วยงาน <span class="text-danger">*</span></label>
                            <input type="text" class="form-control invoice-locat" name="invoiceName" id="modifyForm_invoiceName" maxlength="250" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกชื่อผู้รับ/องค์กร/หน่วยงาน (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_invoiceTaxId" class="form-label">เลขประจำตัวผู้เสียภาษี <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-center" name="invoiceTaxId" id="modifyForm_invoiceTaxId" minlength="13" maxlength="13" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกเลขประจำตัวผู้เสียภาษี (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_invoiceAddress" class="form-label">รายละเอียดที่อยู่ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="invoiceAddress" id="modifyForm_invoiceAddress" maxlength="200" autocomplete="off" placeholder="ชื่ออาคาร หมู่บ้าน หมู่ ซอย ถนน" required>
                            <div class="invalid-feedback">กรุณากรอกรายละเอียดที่อยู่ (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_invoiceProvince" class="form-label">จังหวัด <span class="text-danger">*</span></label>
                            <select class="form-select" name="invoiceProvince" id="modifyForm_invoiceProvince" required>
                            <?php foreach($provinceList as $province): ?>
                                <option value="<?= $province['name']; ?>"><?= $province['name']; ?></option>
                            <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">กรุณาเลือกจังหวัด (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_invoiceDistrict" class="form-label">เขต/อำเภอ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="invoiceDistrict" id="modifyForm_invoiceDistrict" maxlength="100" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกเขต/อำเภอ (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_invoiceSubDistrict" class="form-label">แขวง/ตำบล <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="invoiceSubDistrict" id="modifyForm_invoiceSubDistrict" maxlength="100" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกแขวง/ตำบล (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_invoicePostalCode" class="form-label">รหัสไปรษณีย์ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-center" name="invoicePostalCode" id="modifyForm_invoicePostalCode" minlength="5" maxlength="5" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกรหัสไปรษณีย์ (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </div>
        </form>
    </div>

    <div class="mb-4">
        <div class="card shadow border-0">
            <div class="card-body pb-0">
                <h3 class="fw-bolder text-center">การลงทะเบียน</h3>
                <select class="form-select w-auto" id="statusEnrollment">
                    <option value="all" selected>สถานะทั้งหมด</option>
                    <option value="pending">รอตรวจสอบ</option>
                    <option value="pending_pay">รอการชำระเงิน</option>
                    <option value="checking_pay">รอตรวจสอบชำระเงิน</option>
                    <option value="confirm_paid">ยืนยันการชำระเงิน/ผ่านการตรวจสอบ</option>
                    <option value="success">เสร็จสมบูรณ์</option>
                    <option value="canceled">ยกเลิก</option>
                    <option value="other">อื่นๆ</option>
                </select>
            </div>
            <table class="table table-hover table-light w-100" id="enrollDT" style="min-width:1800px">
                <thead>
                    <th width="40">#</th>
                    <th width="60">เลขที่</th>
                    <th width="60">สถานะ</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th width="100">เบอร์มือถือ</th>
                    <th width="180">อีเมล</th>
                    <th width="180">หลักสูตรอบรม</th>
                    <th width="100">รอบอบรม</th>
                    <th width="60">ค่าสมัคร</th>
                    <th width="80">วันที่สมัคร</th>
                    <th width="150">ผู้ดำเนินการ</th>
                    <th width="100"></th>
                </thead>
            </table>

            <script>
                (function () {
                    'use strict';
                    const fs = document.querySelectorAll('.needs-validation');
                    Array.prototype.slice.call(fs).forEach(f => {
                        f.addEventListener('submit', e => {
                            if (!f.checkValidity()) {
                                e.preventDefault();
                                e.stopPropagation();
                            }
                            f.classList.add('was-validated');
                        }, false);
                    });
                })();

                $(d => {
                    let enrollDT = $('#enrollDT').DataTable({
                        ajax: {
                            url: '<?= base_url(); ?>/api/get/enroll/dt/all',
                            method: 'POST',
                            error: e => {
                                Swal.fire({
                                    title: 'เกิดข้อผิดพลาด',
                                    text: JSON.stringify(e),
                                    icon: 'error'
                                });
                            }
                        },
                        order: [[0,'asc']],
                        fixedColumns: {right: 1},
                        columnDefs: [{
                            targets: [0,1,4,7,8,9],
                            className: 'text-center'
                        }, {
                            targets: 2,
                            className: 'text-center',
                            createdCell: (td, cellData, rowData, row, col) => {
                                let c = '';
                                switch(cellData) {
                                    case 'PENDING': c='<span class="badge bg-or-1">รอตรวจสอบ</span>'; break;
                                    case 'PENDING_PAY': c='<span class="badge bg-or-4">รอการชำระเงิน</span>'; break;
                                    case 'CHECKING_PAY': c='<span class="badge bg-or-1">รอตรวจสอบชำระเงิน</span>'; break;
                                    case 'CONFIRM_PAID': c='<span class="badge bg-primary">'+(rowData[18] > 0 ? 'ยืนยันการชำระเงิน' : 'ผ่านการตรวจสอบ')+'</span>'; break;
                                    case 'SUCCESS': c='<span class="badge bg-or-conts">เสร็จสมบูรณ์</span>'; break;
                                    case 'CANCELED': c='<span class="badge bg-or-2">ยกเลิก</span>'; break;
                                    case 'OTHER': c='<span class="badge bg-dark">อื่นๆ</span>'; break;
                                }
                                $(td).html(c);
                            }
                        }, {
                            targets: 3,
                            createdCell: (td, cellData, rowData, row, col) => {
                                if (rowData[15]=='1') $(td).addClass('fw-bold');
                            }
                        }, {
                            targets: 6,
                            createdCell: (td, cellData, rowData, row, col) => {
                                $(td).html('<a href="<?= base_url(); ?>/course/'+rowData[12]+'" target="_blank">'+cellData+'</a>');
                            }
                        }, {
                            targets: 11,
                            searchable: false,
                            orderable: false,
                            createdCell: (td, cellData, rowData, row, col) => {
                                $(td).append('<button class="btn btn-light btn-sm '+(rowData[15]=='1' ? 'green-website-3-hex ' : '')+'handler-alert" data-id="'+rowData[12]+'" title="'+(rowData[15]=='1' ? 'ตั้งว่าอ่านแล้ว' : 'ตั้งยังไม่ได้อ่าน')+'">'+(rowData[15]=='1' ? '<i class="fa-solid fa-check">' : '<i class="fa-solid fa-bell">')+'</i></button>');
                                $(td).append('<button class="btn btn-light btn-sm handler-mod" data-id="'+rowData[12]+'" title="แก้ไข"><i class="fa-solid fa-pen-to-square"></i></button>');
                                $(td).append('<button class="btn btn-light orange-theme-2 btn-sm handler-del" data-id="'+rowData[12]+'" title="ลบ"><i class="fa-solid fa-trash"></i></button>');
                            }
                        }]
                    });

                    $('select#statusEnrollment').on('change', e => enrollDT.ajax.url('<?= base_url(); ?>/api/get/enroll/dt/'+$(e.currentTarget).val()).load());

                    $('form[name="modifyForm"] select[name="status"]').on('change', e => {
                        $('form[name="modifyForm"] input[name="description"]').attr('disabled', $(e.currentTarget).val()!='OTHER');
                    });

                    const modifyModal = new bootstrap.Modal(document.getElementById('modifyModal'));
                    $(d).on('click', 'button.handler-mod', e => {
                        e.preventDefault();
                        const id = $(e.currentTarget).data('id');
                        $.ajax({
                            url: '<?= base_url(); ?>/api/get/enroll/'+id,
                            type: 'GET',
                            dataType: 'json',
                            success: r => {
                                if (r.success) {
                                    const data = r.data;
                                    const f = $('form[name="modifyForm"]');
                                    $('input[name="enrollId"]', f).val(data.enroll_id);
                                    $('input[name="invoiceNo"]', f).val(data.invoice_no);
                                    $('select[name="status"]', f).val(data.status);
                                    $('input[name="description"]', f).attr('disabled', data.status!='OTHER').val(data.description);
                                    $('input[name="fullnameTha"]', f).val(data.fullname_tha);
                                    $('input[name="fullnameEng"]', f).val(data.fullname_eng);
                                    const birth = new Date(data.birth);
                                    $('select[name="birthDate"]', f).val(birth.getDate());
                                    $('select[name="birthMonth"]', f).val(birth.getMonth()+1);
                                    $('select[name="birthYear"]', f).val(birth.getFullYear());
                                    $('input[name="idCard"]', f).val(data.id_card);
                                    $('input[name="mobile"]', f).val(data.mobile);
                                    $('input[name="email"]', f).val(data.email);
                                    $('input[name="address"]', f).val(data.address);
                                    $('select[name="province"]', f).val(data.province);
                                    $('input[name="district"]', f).val(data.district);
                                    $('input[name="subDistrict"]', f).val(data.sub_district);
                                    $('input[name="postalCode"]', f).val(data.postal_code);
                                    $('input[name="invoiceName"]', f).val(data.invoice_name);
                                    $('input[name="invoiceTaxId"]', f).val(data.invoice_tax_id);
                                    $('input[name="invoiceAddress"]', f).val(data.invoice_address);
                                    $('select[name="invoiceProvince"]', f).val(data.invoice_province);
                                    $('input[name="invoiceDistrict"]', f).val(data.invoice_district);
                                    $('input[name="invoiceSubDistrict"]', f).val(data.invoice_sub_district);
                                    $('input[name="invoicePostalCode"]', f).val(data.invoice_postal_code);
                                    if (data.status=='SUCCESS' || data.status=='CANCELED')
                                        $('select[name="status"]', f).prop('disabled', true);
                                    enrollDT.ajax.reload(null, false);
                                    modifyModal.show();
                                } else {
                                    Swal.fire({
                                        title: 'แจ้งเตือน',
                                        html: r.message,
                                        icon: 'warning',
                                        timerProgressBar: true,
                                        timer: 3000
                                    });
                                }
                            },
                            error: e => {
                                Swal.fire({
                                    title: 'เกิดข้อผิดพลาด',
                                    text: JSON.stringify(e),
                                    icon: 'error'
                                });
                            },
                            beforeSend: _ => waitingModal.show(),
                            complete: _ => waitingModal.hide()
                        });
                    });

                    $(d).on('submit', 'form[name="modifyForm"]', e => {
                        e.preventDefault();
                        const f = $(e.currentTarget);
                        $.ajax({
                            url: '<?= base_url(); ?>/api/modify/enroll',
                            type: 'POST',
                            data: f.serialize(),
                            dataType: 'json',
                            success: r => {
                                if (r.success) {
                                    Swal.fire({
                                        title: 'บันทึกข้อมูลสำเร็จ',
                                        html: r.message,
                                        icon: 'success',
                                        timerProgressBar: true,
                                        timer: 2000
                                    }).then(() => enrollDT.ajax.reload(null, false));
                                    f[0].reset();
                                    modifyModal.hide();
                                } else {
                                    Swal.fire({
                                        title: 'แจ้งเตือน',
                                        html: r.message,
                                        icon: 'warning',
                                        timerProgressBar: true,
                                        timer: 3000
                                    });
                                }
                            },
                            error: e => {
                                Swal.fire({
                                    title: 'เกิดข้อผิดพลาด',
                                    text: JSON.stringify(e),
                                    icon: 'error'
                                });
                            },
                            beforeSend: _ => waitingModal.show(),
                            complete: _ => waitingModal.hide()
                        });
                    });

                    $(d).on('click', 'button.handler-alert', e => {
                        e.preventDefault();
                        const id = $(e.currentTarget).data('id');
                        $.ajax({
                            url: '<?= base_url(); ?>/api/modify/enroll/alert',
                            type: 'POST',
                            data: {enrollId: id},
                            dataType: 'json',
                            success: r => {
                                if (r.success)
                                    enrollDT.ajax.reload(null, false);
                                else {
                                    Swal.fire({
                                        title: 'แจ้งเตือน',
                                        html: r.message,
                                        icon: 'warning',
                                        timerProgressBar: true,
                                        timer: 3000
                                    });
                                }
                            },
                            error: e => {
                                Swal.fire({
                                    title: 'เกิดข้อผิดพลาด',
                                    text: JSON.stringify(e),
                                    icon: 'error'
                                });
                            },
                            beforeSend: _ => waitingModal.show(),
                            complete: _ => waitingModal.hide()
                        });
                    });

                    $(d).on('click', 'button.handler-del', e => {
                        e.preventDefault();
                        const id = $(e.currentTarget).data('id');
                        Swal.fire({
                            title: 'ยืนยันการลบข้อมูล',
                            text: 'คุณมั่นใจที่จะลบการลงทะเบียนดังกล่าวหรือไม่ ?',
                            icon: 'question',
                            showCancelButton: true
                        }).then(res => {
                            if (res.isConfirmed) {
                                $.ajax({
                                    url: '<?= base_url(); ?>/api/delete/enroll/'+id,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: r => {
                                        if (r.success) {
                                            Swal.fire({
                                                title: 'ลบข้อมูลสำเร็จ',
                                                html: r.message,
                                                icon: 'success',
                                                timerProgressBar: true,
                                                timer: 2000
                                            }).then(() => enrollDT.ajax.reload(null, false));
                                        } else {
                                            Swal.fire({
                                                title: 'แจ้งเตือน',
                                                html: r.message,
                                                icon: 'warning',
                                                timerProgressBar: true,
                                                timer: 3000
                                            });
                                        }
                                    },
                                    error: e => {
                                        Swal.fire({
                                            title: 'เกิดข้อผิดพลาด',
                                            text: JSON.stringify(e),
                                            icon: 'error'
                                        });
                                    },
                                    beforeSend: _ => waitingModal.show(),
                                    complete: _ => waitingModal.hide()
                                });
                            }
                        });
                    });
                });
            </script>
        </div>
    </div>
</section>