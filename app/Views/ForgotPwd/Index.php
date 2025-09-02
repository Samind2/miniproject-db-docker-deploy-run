<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5">
        <div class="col-lg-7 text-center text-lg-start">
            <h2 class="display-4 fw-bold lh-1 mb-3">กู้คืนบัญชีของคุณ</h2>
            <p class="col-lg-10 fs-4 fw-bold">หลักสูตรระยะสั้น คณะวิทยาศาสตร์และเทคโนโลยี<br>มหาวิทยาลัยราชภัฏนครปฐม</p>
        </div>
        <div class="col-md-10 mx-auto col-lg-5">
            <form method="post" action="<?= base_url(); ?>/forgotpwd/action" class="signin-card p-4 p-md-5 rounded shadow bg-white needs-validation" novalidate>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" name="username" id="username" placeholder="บัญชีอีเมล" maxlength="100" required>
                    <label for="username"><i class="fa-solid fa-id-card me-2"></i>บัญชีอีเมล</label>
                </div>
                <button class="btn btn-primary btn-lg w-100" type="submit">ยืนยัน</button>
                <a href="<?= base_url(); ?>/signin" class="btn bg-light mt-3 w-100">ฉันทราบรหัสผ่าน</a>
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
            </script>
        </div>
    </div>
</div>