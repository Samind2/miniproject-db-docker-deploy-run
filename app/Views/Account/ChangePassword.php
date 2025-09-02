<div class="bg-white border-top">
    <div class="container-fluid px-4 px-lg-5">
        <nav class="py-2" aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">หน้าแรก</a></li>
                <li class="breadcrumb-item active text-truncate" aria-current="page">เปลี่ยนรหัสผ่าน</li>
            </ol>
        </nav>
    </div>
</div>

<section class="container mt-4">
    <div class="mb-4">
        <div class="card border-0 shadow p-4">
            <h3 class="fw-bolder my-4 text-center">เปลี่ยนรหัสผ่าน</h3>
            <form method="post" class="card-body needs-validation" novalidate>
                <div class="mb-3">
                    <label for="curPassword" class="form-label">รหัสผ่านเดิม</label>
                    <input type="password" class="form-control" name="curPassword" id="curPassword" minlength="8" maxlength="30" autocomplete="off" required>
                    <div class="invalid-feedback">กรุณากรอกรหัสผ่านเดิม</div>
                </div>
                <div class="mb-3">
                    <label for="newPassword" class="form-label">รหัสผ่านใหม่</label>
                    <input type="password" class="form-control" name="newPassword" id="newPassword" minlength="8" maxlength="30" autocomplete="off" required>
                    <div class="invalid-feedback">กรุณากรอกรหัสผ่านใหม่</div>
                </div>
                <div class="mb-3">
                    <label for="cnfPassword" class="form-label">ยืนยันรหัสผ่านใหม่</label>
                    <input type="password" class="form-control" name="cnfPassword" id="cnfPassword" minlength="8" maxlength="30" autocomplete="off" required>
                    <div class="invalid-feedback">กรุณากรอกการยืนยันรหัสผ่านใหม่</div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg">ยืนยัน</button>
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
                        title: 'เปลี่ยนรหัสผ่านสำเร็จ',
                        text: '<?= $res['message']; ?>',
                        icon: 'success',
                        timerProgressBar: true,
                        timer: 2000
                    }).then(() => location.href = '<?= base_url(); ?>/account/changepwd');
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