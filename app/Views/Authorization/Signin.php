<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
        <div class="col-lg-7 text-center text-lg-start">
            <h2 class="display-4 fw-bold lh-1 mb-3">ลงชื่อเข้าใช้</h2>
            <p class="col-lg-10 fs-4 fw-bold">หลักสูตรระยะสั้น คณะวิทยาศาสตร์และเทคโนโลยี<br>มหาวิทยาลัยราชภัฏนครปฐม</p>
        </div>
        <div class="col-md-10 mx-auto col-lg-5">
            <form method="post" class="signin-card p-4 p-md-5 rounded shadow bg-white needs-validation" novalidate>
                <?php if(!empty($callback)) echo '<input type="hidden" name="callback" value="'.$callback.'">'; ?>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" name="username" id="username" placeholder="อีเมล" maxlength="100" required>
                    <label for="username"><i class="fa-solid fa-id-card me-2"></i>อีเมล</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="รหัสผ่าน" minlength="8" maxlength="30" required>
                    <label for="password"><i class="fa-solid fa-lock me-2"></i>รหัสผ่าน</label>
                </div>
                <div class="mb-3"><a href="<?= base_url(); ?>/forgotpwd" class="fs-sm">ลืมรหัสผ่านใช่หรือไม่?</a></div>
                <button class="btn btn-primary btn-lg w-100" type="submit">เข้าสู่ระบบ</button>
                <a href="<?= base_url(); ?>/signup" class="btn bg-light btn-lg mt-3 w-100">ลงทะเบียน</a>
            </form>
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
                            title: 'เข้าสู่ระบบสำเร็จ',
                            text: '<?= $res['message']; ?>',
                            icon: 'success',
                            timerProgressBar: true,
                            timer: 2000
                        }).then(() => location.href = '<?= base_url().(empty($callback) ? '' : '/course/'.base64_decode($callback)); ?>');
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
    </div>
</div>