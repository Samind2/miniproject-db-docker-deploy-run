<style>
    @media print {
        .print-content div {
            width: 100%;
            display: flex;
            justify-content: center;
            break-inside: avoid;
        }
    }
</style>
<h3 class="text-center"><?= $course['title'].' ('.$dateExtension::thai_range_format('d M Y', $course['course_batch_start_classroom'], $course['course_batch_end_classroom']).')'; ?></h3>
<div class="print-content">
    <?php foreach($paymentList as $payment): ?>
        <div style="display:inline-block;width:350px;padding:1rem;border:1px #000 solid;font-size:.9em">
            <p style="margin-bottom:.3rem"><strong>ผู้สมัคร:</strong> <?= $payment['enroll_fullname_tha']; ?></p>
            <p style="margin-bottom:.3rem"><strong>วันเวลาที่ชำระ:</strong> <?= $dateExtension::thai_format('d M Y H:i', $payment['created']); ?></p>
            <p style="margin-bottom:.3rem"><strong>ยืนยันการตรวจสอบ:</strong> ▢ ถูกต้อง&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;▢ ไม่ถูกต้อง</p>
            <img src="<?= base_url() . '/' . $payment['slip_image'];?>" width="250" height="380">
        </div>
    <?php endforeach ?>
</div>
<script>window.print()</script>