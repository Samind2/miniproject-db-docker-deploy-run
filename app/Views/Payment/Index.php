<div class="bg-white border-top">
    <div class="container-fluid px-4 px-lg-5">
        <nav class="py-2" aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">หน้าแรก</a></li>
                <li class="breadcrumb-item active text-truncate" aria-current="page">แจ้งการชำระเงิน</li>
            </ol>
        </nav>
    </div>
</div>

<section class="container mt-4">
    <div class="mb-4">
        <div class="card border-0 shadow p-4">
            <h3 class="fw-bolder my-4 text-center">แจ้งการชำระเงิน</h3>
            <form method="post" class="card-body needs-validation" enctype="multipart/form-data" novalidate>
                <div class="mb-3">
                    <label for="enroll" class="form-label">รายการค้างชำระ <span class="text-danger">*</span></label>
                    <select class="form-select" name="enroll" id="enroll" required>
                        <?php $i = 0;
                        foreach($enrollList as $enroll):
                            if($enroll['paid_count']==0):
                                $i++; ?>
                                <option value="<?= $enroll['enroll_id']; ?>"<?php if(isset($form['enroll']) && $enroll['enroll_id']==$form['enroll']) echo ' selected'; ?>><?= '#' . $enroll['invoice_no'] . ' (ยอดชำระ ' . number_format($enroll['regis_fee'], 2) . ' THB)'; ?></option>
                            <?php endif;
                        endforeach;
                        if($i==0): ?>
                            <option value="null">** ไม่พบรายการค้างชำระ **</option>
                        <?php endif ?>
                    </select>
                    <div class="invalid-feedback">กรุณาเลือกการสมัครที่ต้องการชำระ</div>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <label for="date" class="form-label">วันที่ชำระเงิน <span class="text-danger">*</span></label>
                        <input type="date" class="form-control text-center" name="date" id="date" autocomplete="off" value="<?= isset($form['date']) ? $form['date'] : date('Y-m-d'); ?>" required>
                        <div class="invalid-feedback">กรุณากรอกวันที่ชำระเงิน</div>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="time" class="form-label">เวลาชำระเงิน <span class="text-danger">*</span></label>
                        <input type="time" class="form-control text-center" name="time" id="time" autocomplete="off" value="<?= isset($form['time']) ? $form['time'] : '00:00'; ?>" required>
                        <div class="invalid-feedback">กรุณากรอกเวลาชำระเงิน</div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="amount" class="form-label">จำนวนเงิน <span class="text-danger">*</span></label>
                    <input type="number" class="form-control text-center" name="amount" id="amount" min="0" step="0.01" autocomplete="off" value="<?php if(isset($form['amount'])) echo $form['amount']; ?>" placeholder="0.00" required>
                    <div class="invalid-feedback">กรุณากรอกจำนวนเงิน</div>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">รูปหลักฐานการชำระเงิน <span class="text-danger">*</span></label>
                    <input type="file" class="form-control" id="image" name="image" aria-label="Upload" accept="<?= join(',', $fileImage['accept']); ?>" required>
                    <small class="text-muted">รองรับไฟล์ประเภท <?= join(', ', $fileImage['extension']); ?> : ขนาดไม่เกิน <?= number_to_size($fileImage['maxSize']); ?></small>
                    <div class="invalid-feedback">กรุณาอัปโหลดรูปหลักฐานการชำระเงิน</div>
                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary btn-lg">ยืนยันการส่งหลักฐาน</button>
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

            $('input[name="image"]').on('change', e => {
                const c = $(e.currentTarget);
                let oversize = false;
                $.each(c[0].files, function(i, d) {
                    if (d.size > parseInt('<?= $fileImage['maxSize']; ?>')) {
                        oversize = true;
                        return false;
                    }
                });
                if (oversize) {
                    Swal.fire({
                        title: 'แจ้งเตือน',
                        html: 'ไฟล์มีขนาดเกินกว่า <?= number_to_size($fileImage['maxSize']); ?>',
                        icon: 'warning'
                    }).then(() => c.val(null));
                }
            });

            <?php if($res['submit']):
                if($res['success']): ?>
                    Swal.fire({
                        title: 'บันทึกข้อมูลสำเร็จ',
                        text: '<?= $res['message']; ?>',
                        icon: 'success',
                        timerProgressBar: true,
                        timer: 2000
                    }).then(() => location.href = '<?= base_url(); ?>/payment');
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