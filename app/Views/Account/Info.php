<div class="bg-white border-top">
    <div class="container-fluid px-4 px-lg-5">
        <nav class="py-2" aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">หน้าแรก</a></li>
                <li class="breadcrumb-item active text-truncate" aria-current="page">ข้อมูลผู้ใช้งาน</li>
            </ol>
        </nav>
    </div>
</div>

<section class="container mt-4">
    <div class="mb-4">
        <div class="card border-0 shadow p-4">
            <h3 class="fw-bolder my-4 text-center">ข้อมูลผู้ใช้งาน</h3>
            <form method="post" class="card-body needs-validation" novalidate>
                <h5 class="fw-bolder mb-3">ข้อมูลทั่วไป</h5>
                <div class="rounded border p-4">
                    <div class="row">
                        <div class="col-lg-2 mb-3">
                            <label for="nameTitleTha" class="form-label">คำนำหน้า <span class="text-danger">*</span></label>
                            <select class="form-select" name="nameTitleTha" id="nameTitleTha" required>
                                <option value="นาย"<?php if($UserLogged['name_title_tha']=='นาย') echo ' selected'; ?>>นาย</option>
                                <option value="นาง"<?php if($UserLogged['name_title_tha']=='นาง') echo ' selected'; ?>>นาง</option>
                                <option value="นางสาว"<?php if($UserLogged['name_title_tha']=='นางสาว') echo ' selected'; ?>>นางสาว</option>
                            </select>
                            <div class="invalid-feedback">กรุณาเลือกคำนำหน้า</div>
                        </div>
                        <div class="col-lg-5 mb-3">
                            <label for="firstnameTha" class="form-label">ชื่อ ภาษาไทย <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="firstnameTha" id="firstnameTha" maxlength="100" autocomplete="off" value="<?= $UserLogged['firstname_tha']; ?>" required>
                            <div class="invalid-feedback">กรุณากรอกชื่อ ภาษาไทย</div>
                        </div>
                        <div class="col-lg-5 mb-3">
                            <label for="lastnameTha" class="form-label">นามสกุล ภาษาไทย <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="lastnameTha" id="lastnameTha" maxlength="100" autocomplete="off" value="<?= $UserLogged['lastname_tha']; ?>" required>
                            <div class="invalid-feedback">กรุณากรอกนามสกุล ภาษาไทย</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 mb-3">
                            <label for="nameTitleEng" class="form-label">คำนำหน้า <span class="text-danger">*</span></label>
                            <select class="form-select" name="nameTitleEng" id="nameTitleEng" required>
                                <option value="Mr."<?php if($UserLogged['name_title_eng']=='Mr.') echo ' selected'; ?>>Mr.</option>
                                <option value="Mrs."<?php if($UserLogged['name_title_eng']=='Mrs.') echo ' selected'; ?>>Mrs.</option>
                                <option value="Ms."<?php if($UserLogged['name_title_eng']=='Ms.') echo ' selected'; ?>>Ms.</option>
                            </select>
                            <div class="invalid-feedback">กรุณาเลือกคำนำหน้า</div>
                        </div>
                        <div class="col-lg-5 mb-3">
                            <label for="firstnameEng" class="form-label">ชื่อ ภาษาอังกฤษ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="firstnameEng" id="firstnameEng" maxlength="100" autocomplete="off" value="<?= $UserLogged['firstname_eng']; ?>" required>
                            <div class="invalid-feedback">กรุณากรอกชื่อ ภาษาอังกฤษ</div>
                        </div>
                        <div class="col-lg-5 mb-3">
                            <label for="lastnameEng" class="form-label">นามสกุล ภาษาอังกฤษ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="lastnameEng" id="lastnameEng" maxlength="100" autocomplete="off" value="<?= $UserLogged['lastname_eng']; ?>" required>
                            <div class="invalid-feedback">กรุณากรอกนามสกุล ภาษาอังกฤษ</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 mb-3">
                            <label for="birthDate" class="form-label">วันเกิด <span class="text-danger">*</span></label>
                            <select class="form-select text-center" name="birthDate" id="birthDate" required>
                                <?php for($d=1; $d<=31; $d++): ?>
                                    <option value="<?= $d; ?>"<?php if(date_format(date_create($UserLogged['birth']), 'd')==$d) echo ' selected'; ?>><?= $d; ?></option>
                                <?php endfor ?>
                            </select>
                            <div class="invalid-feedback">กรุณาเลือกวันเกิด</div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="birthMonth" class="form-label">เดือน <span class="text-danger">*</span></label>
                            <select class="form-select text-center" name="birthMonth" id="birthMonth" required>
                                <?php foreach($dateExtension::$month_long_tha as $i => $month): ?>
                                    <option value="<?= ($i+1); ?>"<?php if(date_format(date_create($UserLogged['birth']), 'm')==($i+1)) echo ' selected'; ?>><?= $month; ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">กรุณาเลือกเดือนเกิด</div>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label for="birthYear" class="form-label">ปี (พ.ศ.) <span class="text-danger">*</span></label>
                            <select class="form-select text-center" name="birthYear" id="birthYear" required>
                                <?php for($y=date('Y')-15; $y>=1950; $y--): ?>
                                    <option value="<?= $y; ?>"<?php if(date_format(date_create($UserLogged['birth']), 'Y')==$y) echo ' selected'; ?>><?= ($y+543); ?></option>
                                <?php endfor ?>
                            </select>
                            <div class="invalid-feedback">กรุณาเลือกปีเกิด (พ.ศ.)</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="idCard" class="form-label">หมายเลขบัตรประชาชน <span class="text-danger">*</span></label>
                        <input type="text" class="form-control text-center" name="idCard" id="idCard" minlength="13" maxlength="13" autocomplete="off" value="<?= $UserLogged['id_card']; ?>" required placeholder="ไม่ต้องใส่อักขระขีดและเว้นวรรค" disabled>
                        <div class="invalid-feedback">กรุณากรอกหมายเลขบัตรประชาชน</div>
                    </div>
                </div>
                <h5 class="fw-bolder mt-5 mb-3">ข้อมูลติดต่อ</h5>
                <div class="rounded border p-4">
                    <div class="mb-3">
                        <label for="mobile" class="form-label">เบอร์มือถือ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="mobile" id="mobile" minlength="10" maxlength="10" autocomplete="off" value="<?= $UserLogged['mobile']; ?>" required placeholder="ไม่ต้องใส่อักขระขีด" disabled>
                        <div class="invalid-feedback">กรุณากรอกเบอร์มือถือ</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">อีเมล <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="email" maxlength="100" autocomplete="off" value="<?= $UserLogged['email']; ?>" required placeholder="example@email.com">
                        <div class="invalid-feedback">กรุณากรอกอีเมล</div>
                    </div>
                </div>
                <h5 class="fw-bolder mt-5 mb-3">ข้อมูลที่อยู่</h5>
                <div class="rounded border p-4">
                    <div class="mb-3">
                        <label for="address" class="form-label">รายละเอียดที่อยู่ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="address" id="address" maxlength="200" autocomplete="off" value="<?= $UserLogged['address']; ?>" placeholder="ชื่ออาคาร หมู่บ้าน หมู่ ซอย ถนน" required>
                        <div class="invalid-feedback">กรุณากรอกรายละเอียดที่อยู่</div>
                    </div>
                    <div class="mb-3">
                        <label for="province" class="form-label">จังหวัด <span class="text-danger">*</span></label>
                        <select class="form-select" name="province" id="province" required>
                            <?php foreach($provinceList as $province): ?>
                                <option value="<?= $province['name']; ?>"<?php if($UserLogged['province']==$province['name']) echo ' selected'; ?>><?= $province['name']; ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback">กรุณาเลือกจังหวัด</div>
                    </div>
                    <div class="mb-3">
                        <label for="district" class="form-label">เขต/อำเภอ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="district" id="district" maxlength="100" autocomplete="off" value="<?= $UserLogged['district']; ?>" required>
                        <div class="invalid-feedback">กรุณากรอกเขต/อำเภอ</div>
                    </div>
                    <div class="mb-3">
                        <label for="subDistrict" class="form-label">แขวง/ตำบล <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="subDistrict" id="subDistrict" maxlength="100" autocomplete="off" value="<?= $UserLogged['sub_district']; ?>" required>
                        <div class="invalid-feedback">กรุณากรอกแขวง/ตำบล</div>
                    </div>
                    <div class="mb-3">
                        <label for="postalCode" class="form-label">รหัสไปรษณีย์ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control text-center" name="postalCode" id="postalCode" minlength="5" maxlength="5" autocomplete="off" value="<?= $UserLogged['postal_code']; ?>" required>
                        <div class="invalid-feedback">กรุณากรอกรหัสไปรษณีย์</div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary btn-lg">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
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
            const nameTitleTha = document.getElementById('nameTitleTha');
            const nameTitleEng = document.getElementById('nameTitleEng');
            nameTitleTha.addEventListener('change', () => nameTitleEng.options.selectedIndex = nameTitleTha.options.selectedIndex);
            nameTitleEng.addEventListener('change', () => nameTitleTha.options.selectedIndex = nameTitleEng.options.selectedIndex);
            <?php if($res['submit']):
                if($res['success']): ?>
                    Swal.fire({
                        title: 'บันทึกข้อมูลสำเร็จ',
                        text: '<?= $res['message']; ?>',
                        icon: 'success',
                        timerProgressBar: true,
                        timer: 2000
                    }).then(() => location.href = '<?= base_url(); ?>/account/info');
                <?php else: ?>
                    Swal.fire({
                        title: 'เกิดข้อผิดพลาด',
                        html: '<?= $res['message']; ?>',
                        icon: 'error'
                    });
                <?php endif;
            endif ?>
        </script>
    </div>
</section>