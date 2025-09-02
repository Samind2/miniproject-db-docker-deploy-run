<nav class="navbar navbar-expand-lg navbar-main navbar-light bg-white">
    <div class="container-fluid px-4 px-lg-5">
        <a class="navbar-brand" href="<?= base_url() ?>">
            <img src="<?= base_url() ?>/assets/images/logo.png" class="navbar-logo" style="height:60px" />
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <form method="get" action="<?= base_url() ?>/course" class="my-3 my-sm-3 my-md-3 mt-lg-0 d-lg-none">
                <div class="input-group">
                    <input type="search" class="form-control" name="k" placeholder="ค้นหาหลักสูตร" value="<?php if(isset($fKeyword)) echo $fKeyword; ?>">
                    <button type="submit" class="btn btn-color-search i-translate-y--2"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="http://sc.npru.ac.th/" target="_blank"><i class="fa-solid fa-atom"></i>คณะวิทยาศาสตร์และเทคโนโลยี</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>/course"><i class="fa-solid fa-apple-whole"></i>หลักสูตรอบรม</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>/calendar"><i class="fa-solid fa-calendar-days"></i>ปฏิทินอบรม</a>
                </li>
                <?php if(session()->get('LOGGED_IN') && !empty($UserLogged)): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="<?= $UserLogged['fullname_tha']; ?>">
                            <i class="fa-solid fa-user"></i><?= mb_substr($UserLogged['firstname_tha'], 0, 18, 'utf8');
                            if($UserLogged['pending_pay_alert']>0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                    <span class="visually-hidden">มีแจ้งเตือนใหม่</span>
                                </span>
                            <?php endif ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow" aria-labelledby="accountDropdown">
                            <li><a class="dropdown-item" href="<?= base_url() ?>/enroll">ประวัติการลงทะเบียน</a></li>
                            <li><a class="dropdown-item" href="<?= base_url() ?>/payment">แจ้งชำระเงิน
                                <?php if($UserLogged['pending_pay_alert']>0): ?>
                                    <span class="badge rounded-pill bg-danger"><?= number_format($UserLogged['pending_pay_alert'], 0); ?></span>
                                <?php endif ?>
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= base_url() ?>/account/info">ข้อมูลผู้ใช้งาน</a></li>
                            <li><a class="dropdown-item" href="<?= base_url() ?>/account/changepwd">เปลี่ยนรหัสผ่าน</a></li>
                            <li><a class="dropdown-item" href="<?= base_url() ?>/signout">ออกจากระบบ</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>/signin"><i class="fa-solid fa-right-to-bracket"></i>ลงชื่อเข้าใช้</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>/signup"><i class="fa-solid fa-clipboard-list"></i>ลงทะเบียน</a>
                    </li>
                <?php endif ?>
                <li class="nav-item dropdown d-none d-lg-block">
                    <a class="nav-link" href="#" id="searchDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="ค้นหาหลักสูตร"><i class="fa-solid fa-magnifying-glass"></i></a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-end border-0 shadow" aria-labelledby="searchDropdown">
                        <form method="get" action="<?= base_url() ?>/course">
                            <div class="input-group">
                                <input type="search" class="form-control" name="k" placeholder="ค้นหาหลักสูตร" value="<?php if(isset($fKeyword)) echo $fKeyword; ?>">
                                <button type="submit" class="btn btn-color-search i-translate-y--2"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php if(session()->get('LOGGED_IN') && !empty($UserLogged) && in_array($UserLogged['user_level'], ['OFFICER','ADMINISTRATOR'])): ?>
    <nav class="navbar navbar-expand-lg navbar-manage navbar-dark bg-or-4">
        <div class="container-fluid px-4 px-lg-5">
            <span class="navbar-brand"><i class="fa-solid fa-user-tie"></i> <?php echo $UserLogged['user_level']==='ADMINISTRATOR' ? 'ส่วนผู้ดูแล' : 'ส่วนเจ้าหน้าที่'; ?></span>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdministration" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarAdministration">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-lg-4">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>/manage/courses">หลักสูตรอบรม</a></li>
                    <?php if($UserLogged['user_level']==='ADMINISTRATOR'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>/manage/courses/categories">หมวดหลักสูตร</a></li>
                    <?php endif ?>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>/manage/lecturer">วิทยากร</a></li>
                    <?php if($UserLogged['user_level']==='ADMINISTRATOR'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>/manage/faculty">คณะ/สาขาวิชา</a></li>
                    <?php endif ?>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>/manage/enrollment">การลงทะเบียน</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>/manage/payment">การชำระเงิน</a></li>
                    <?php if($UserLogged['user_level']==='ADMINISTRATOR'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>/manage/users">บัญชีผู้ใช้</a></li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>
<?php endif ?>