<div class="bg-white border-top">
    <div class="container-fluid px-4 px-lg-5">
        <nav class="py-2" aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">หน้าแรก</a></li>
                <li class="breadcrumb-item active text-truncate" aria-current="page">ประวัติการลงทะเบียน</li>
            </ol>
        </nav>
    </div>
</div>

<section class="container-fluid mt-4">
    <div class="mb-4">
        <div class="card border-0 shadow p-4">
            <div class="card-body">
                <h3 class="fw-bolder text-center">ประวัติการลงทะเบียน</h3>
            </div>
            <div class="table-responsive-lg">
                <table class="table table-hover table-light w-100" style="min-width:1000px">
                    <thead>
                        <tr>
                            <th class="text-center" width="60">เลขที่</th>
                            <th>ชื่อหลักสูตร</th>
                            <th class="text-center" width="130">สถานะ</th>
                            <th class="text-end" width="80">ค่าสมัคร</th>
                            <th class="text-center" width="120">วันที่สมัคร</th>
                            <th class="text-center" width="180">วันที่อบรม</th>
                            <th>สถานที่</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($enrollList as $enroll): ?>
                            <tr>
                                <td class="text-center"><?= $enroll['invoice_no']; ?></td>
                                <td>
                                    <a href="<?= base_url(); ?>/course/<?= $enroll['course_id']; ?>" target="_blank"><?= $enroll['course_title']; ?></a>
                                </td>
                                <td class="text-center">
                                    <?php switch($enroll['status']):
                                        case 'PENDING': echo 'รอตรวจสอบ'; break;
                                        case 'PENDING_PAY': echo 'รอการชำระเงิน'; break;
                                        case 'CHECKING_PAY': echo 'รอตรวจสอบชำระเงิน'; break;
                                        case 'CONFIRM_PAID': echo 'ยืนยันการชำระเงิน'; break;
                                        case 'SUCCESS': echo 'เสร็จสมบูรณ์'; break;
                                        case 'CANCELED': echo 'ยกเลิก'; break;
                                        case 'OTHER': echo 'อื่นๆ'; break;
                                    endswitch ?>
                                </td>
                                <td class="text-end"><?= number_format($enroll['regis_fee'], 0); ?></td>
                                <td class="text-center"><?= $dateExtension::thai_format('d M y', $enroll['enrolled']); ?></td>
                                <td class="text-center"><?= $dateExtension::thai_range_format('d M y', $enroll['course_batch_start_classroom'], $enroll['course_batch_end_classroom']); ?></td>
                                <td><?= $enroll['course_location']; ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <?= $enrollPaging; ?>
        </div>
    </div>
</section>