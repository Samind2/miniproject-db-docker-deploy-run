<section class="container mt-4">
    <div class="mb-4">
        <div class="card border-0 shadow p-4">
            <h3 class="fw-bolder my-4 text-center">รีเซ็ตรหัสผ่าน</h3>
            <form method="post" class="card-body needs-validation" novalidate>
                <input type="hidden" name="token" value="<?php if(isset($token)) echo $token; ?>">
                <div class="mb-3">
                    <label for="newPassword" class="form-label">รหัสผ่านใหม่ <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="newPassword" id="newPassword" minlength="8" maxlength="30" autocomplete="off" required placeholder="a-z, A-Z, 0-9, 8 อักขระขึ้นไป">
                    <div class="invalid-feedback">กรุณากรอกรหัสผ่านใหม่ 8 ตัวอักษรขึ้นไป</div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">ยืนยัน</button>
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

            <?php if($res['submit']):
                if($res['success']): ?>
                    Swal.fire({
                        title: 'รีเซ็ตรหัสผ่านสำเร็จแล้ว',
                        text: '<?= $res['message']; ?>',
                        icon: 'success'
                    }).then(() => location.href = '<?= base_url(); ?>');
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