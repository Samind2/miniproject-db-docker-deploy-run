<div class="bg-white border-top">
    <div class="container-fluid px-4 px-lg-5">
        <nav class="py-2" aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">ส่วนผู้ดูแล</a></li>
                <li class="breadcrumb-item active text-truncate" aria-current="page">บัญชีผู้ใช้</li>
            </ol>
        </nav>
    </div>
</div>

<section class="container-fluid px-4 px-lg-5 mt-4">
    <div class="modal fade" id="modifyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modifyModalLabel" aria-hidden="true">
        <form method="post" name="modifyForm" class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl needs-validation" novalidate>
            <input type="hidden" name="userId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifyModalLabel">แก้ไขข้อมูล</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="fw-bolder mb-3">ข้อมูลทั่วไป</h5>
                    <div class="rounded border p-4">
                        <div class="row">
                            <div class="col-lg-2 mb-3">
                                <label for="modifyForm_nameTitleTha" class="form-label">คำนำหน้า <span class="text-danger">*</span></label>
                                <select class="form-select" name="nameTitleTha" id="modifyForm_nameTitleTha" required>
                                    <option value="นาย">นาย</option>
                                    <option value="นาง">นาง</option>
                                    <option value="นางสาว">นางสาว</option>
                                </select>
                                <div class="invalid-feedback">กรุณาเลือกคำนำหน้า</div>
                            </div>
                            <div class="col-lg-5 mb-3">
                                <label for="modifyForm_firstnameTha" class="form-label">ชื่อ ภาษาไทย <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="firstnameTha" id="modifyForm_firstnameTha" maxlength="100" autocomplete="off" required>
                                <div class="invalid-feedback">กรุณากรอกชื่อ ภาษาไทย</div>
                            </div>
                            <div class="col-lg-5 mb-3">
                                <label for="modifyForm_lastnameTha" class="form-label">นามสกุล ภาษาไทย <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="lastnameTha" id="modifyForm_lastnameTha" maxlength="100" autocomplete="off" required>
                                <div class="invalid-feedback">กรุณากรอกนามสกุล ภาษาไทย</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2 mb-3">
                                <label for="modifyForm_nameTitleEng" class="form-label">คำนำหน้า <span class="text-danger">*</span></label>
                                <select class="form-select" name="nameTitleEng" id="modifyForm_nameTitleEng" required>
                                    <option value="Mr.">Mr.</option>
                                    <option value="Mrs.">Mrs.</option>
                                    <option value="Ms.">Ms.</option>
                                </select>
                                <div class="invalid-feedback">กรุณาเลือกคำนำหน้า</div>
                            </div>
                            <div class="col-lg-5 mb-3">
                                <label for="modifyForm_firstnameEng" class="form-label">ชื่อ ภาษาอังกฤษ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="firstnameEng" id="modifyForm_firstnameEng" maxlength="100" autocomplete="off" required>
                                <div class="invalid-feedback">กรุณากรอกชื่อ ภาษาอังกฤษ</div>
                            </div>
                            <div class="col-lg-5 mb-3">
                                <label for="modifyForm_lastnameEng" class="form-label">นามสกุล ภาษาอังกฤษ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="lastnameEng" id="modifyForm_lastnameEng" maxlength="100" autocomplete="off" required>
                                <div class="invalid-feedback">กรุณากรอกนามสกุล ภาษาอังกฤษ</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 mb-3">
                                <label for="modifyForm_birthDate" class="form-label">วันเกิด <span class="text-danger">*</span></label>
                                <select class="form-select text-center" name="birthDate" id="modifyForm_birthDate" required>
                                    <?php for($d=1; $d<=31; $d++): ?>
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
                                    <?php for($y=date('Y')-15; $y>=1950; $y--): ?>
                                        <option value="<?= $y; ?>"><?= ($y+543); ?></option>
                                    <?php endfor ?>
                                </select>
                                <div class="invalid-feedback">กรุณาเลือกปีเกิด (พ.ศ.)</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_idCard" class="form-label">หมายเลขบัตรประชาชน <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-center" name="idCard" id="modifyForm_idCard" minlength="13" maxlength="13" autocomplete="off" required placeholder="ไม่ต้องใส่อักขระขีดและเว้นวรรค" disabled>
                            <div class="invalid-feedback">กรุณากรอกหมายเลขบัตรประชาชน</div>
                        </div>
                    </div>
                    <h5 class="fw-bolder mt-5 mb-3">ข้อมูลติดต่อ</h5>
                    <div class="rounded border p-4">
                        <div class="mb-3">
                            <label for="modifyForm_mobile" class="form-label">เบอร์มือถือ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="mobile" id="modifyForm_mobile" minlength="10" maxlength="10" autocomplete="off" required placeholder="ไม่ต้องใส่อักขระขีด">
                            <div class="invalid-feedback">กรุณากรอกเบอร์มือถือ</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_email" class="form-label">อีเมล <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="modifyForm_email" maxlength="100" autocomplete="off" required placeholder="example@email.com">
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
                    <h5 class="fw-bolder mt-5 mb-3">ข้อมูลบัญชี</h5>
                    <div class="rounded border p-4">
                        <div class="row row-cols-3 g-4 mb-3">
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="userLevel" id="modifyForm_userLevelUser" autocomplete="off" value="USER" checked>
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="modifyForm_userLevelUser">ผู้ใช้ทั่วไป</label>
                            </div>
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="userLevel" id="modifyForm_userLevelOfficer" autocomplete="off" value="OFFICER">
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="modifyForm_userLevelOfficer"></i>เจ้าหน้าที่</label>
                            </div>
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="userLevel" id="modifyForm_userLevelAdmin" autocomplete="off" value="ADMINISTRATOR">
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="modifyForm_userLevelAdmin"></i>ผู้ดูแล</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_password" class="form-label">เปลี่ยนรหัสผ่าน</label>
                            <input type="password" class="form-control" name="password" id="modifyForm_password" minlength="8" maxlength="30" autocomplete="off" placeholder="a-z, A-Z, 0-9, 8 อักขระขึ้นไป">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="TRUE" name="authorized" id="modifyForm_authorized">
                                <label class="form-check-label" for="modifyForm_authorized">เปิดใช้งานบัญชีผู้ใช้</label>
                            </div>
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
                <h3 class="fw-bolder text-center">บัญชีผู้ใช้</h3>
            </div>
            <table class="table table-hover table-light w-100" id="usersDT" style="min-width:900px">
                <thead>
                    <th width="40">#</th>
                    <th>ชื่อ นามสกุล</th>
                    <th>เลขที่ประชาชน</th>
                    <th>อีเมล</th>
                    <th>เบอร์มือถือ</th>
                    <th width="70">ระดับผู้ใช้</th>
                    <th width="80">สิทธิ์อนุญาต</th>
                    <th width="70"></th>
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
                const nameTitleTha = document.getElementById('modifyForm_nameTitleTha');
                const nameTitleEng = document.getElementById('modifyForm_nameTitleEng');
                nameTitleTha.addEventListener('change', () => nameTitleEng.options.selectedIndex = nameTitleTha.options.selectedIndex);
                nameTitleEng.addEventListener('change', () => nameTitleTha.options.selectedIndex = nameTitleEng.options.selectedIndex);

                $(d => {
                    let usersDT = $('#usersDT').DataTable({
                        ajax: {
                            url: '<?= base_url(); ?>/api/get/user/dt',
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
                            targets: [0,2,4],
                            className: 'text-center'
                        }, {
                            targets: 5,
                            className: 'text-center',
                            createdCell: (td, cellData, rowData, row, col) => {
                                let style = 'or-conts';
                                let text = 'ผู้ใช้ทั่วไป';
                                switch (cellData) {
                                    case 'ADMINISTRATOR':
                                        style = 'or-3';
                                        text = 'ผู้ดูแล';
                                        break;
                                    case 'OFFICER':
                                        style = 'or-1';
                                        text = 'เจ้าหน้าที่';
                                        break;
                                    default:
                                        style = 'or-conts';
                                        text = 'ผู้ใช้ทั่วไป';
                                        break;
                                }
                                $(td).html('<span class="badge bg-'+style+'">'+text+'</span>');
                            }
                        }, {
                            targets: 6,
                            className: 'text-center',
                            createdCell: (td, cellData, rowData, row, col) => {
                                $(td).html('<span class="badge bg-'+(cellData=='FALSE' ? 'or-2' : 'or-conts')+'">'+(cellData=='FALSE' ? 'ไม่อนุญาต' : 'อนุญาต')+'</span>');
                            }
                        }, {
                            targets: 7,
                            searchable: false,
                            orderable: false,
                            createdCell: (td, cellData, rowData, row, col) => {
                                $(td).append('<button class="btn btn-light btn-sm handler-mod" data-id="'+rowData[8]+'" title="แก้ไข"><i class="fa-solid fa-pen-to-square"></i></button>');
                                if(rowData[8] != '<?= $UserLogged['user_id']; ?>')
                                    $(td).append('<button class="btn btn-light orange-theme-2 btn-sm handler-del" data-id="'+rowData[8]+'" title="ลบ"><i class="fa-solid fa-trash"></i></button>');
                            }
                        }]
                    });

                    const modifyModal = new bootstrap.Modal(document.getElementById('modifyModal'));
                    $(d).on('click', 'button.handler-mod', e => {
                        e.preventDefault();
                        const id = $(e.currentTarget).data('id');
                        $.ajax({
                            url: '<?= base_url(); ?>/api/get/user/'+id,
                            type: 'GET',
                            dataType: 'json',
                            success: r => {
                                if (r.success) {
                                    const data = r.data;
                                    const f = $('form[name="modifyForm"]');
                                    $('input[name="userId"]', f).val(data.user_id);
                                    $('select[name="nameTitleTha"]', f).val(data.name_title_tha);
                                    $('input[name="firstnameTha"]', f).val(data.firstname_tha);
                                    $('input[name="lastnameTha"]', f).val(data.lastname_tha);
                                    $('select[name="nameTitleEng"]', f).val(data.name_title_eng);
                                    $('input[name="firstnameEng"]', f).val(data.firstname_eng);
                                    $('input[name="lastnameEng"]', f).val(data.lastname_eng);
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
                                    $('input[name="userLevel"][value="'+data.user_level+'"]', f).prop('checked', true);
                                    $('input[name="authorized"]', f).prop('checked', data.authorized=='TRUE');
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
                            url: '<?= base_url(); ?>/api/modify/user',
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
                                    }).then(() => usersDT.ajax.reload(null, false));
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

                    $(d).on('click', 'button.handler-del', e => {
                        e.preventDefault();
                        const id = $(e.currentTarget).data('id');
                        Swal.fire({
                            title: 'ยืนยันการลบข้อมูล',
                            text: 'คุณมั่นใจที่จะลบผู้ใช้งานดังกล่าวหรือไม่ ?',
                            icon: 'question',
                            showCancelButton: true
                        }).then(res => {
                            if (res.isConfirmed) {
                                $.ajax({
                                    url: '<?= base_url(); ?>/api/delete/user/'+id,
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
                                            }).then(() => usersDT.ajax.reload(null, false));
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