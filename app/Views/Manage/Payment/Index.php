<div class="bg-white border-top">
    <div class="container-fluid px-4 px-lg-5">
        <nav class="py-2" aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">ส่วนผู้ดูแล</a></li>
                <li class="breadcrumb-item active text-truncate" aria-current="page">การชำระเงิน</li>
            </ol>
        </nav>
    </div>
</div>

<section class="container-fluid px-4 px-lg-5 mt-4">
    <div class="modal fade" id="modifyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modifyModalLabel" aria-hidden="true">
        <form method="post" name="modifyForm" class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl needs-validation" novalidate>
            <input type="hidden" name="paymentId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifyModalLabel">แก้ไขข้อมูล</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="fw-bolder mb-3">สถานะการชำระ</h5>
                    <div class="rounded border p-4">
                        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-3 g-4 mb-3">
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="status" id="modifyForm_statusPending" autocomplete="off" value="PENDING" checked>
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="modifyForm_statusPending">รอตรวจสอบชำระเงิน</label>
                            </div>
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="status" id="modifyForm_statusSuccess" autocomplete="off" value="SUCCESS">
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="modifyForm_statusSuccess">ชำระเงินสำเร็จ</label>
                            </div>
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="status" id="modifyForm_statusCanceled" autocomplete="off" value="CANCELED">
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="modifyForm_statusCanceled">ยกเลิกการชำระ</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_inspector" class="form-label">ผู้ดำเนินการ</label>
                            <input type="text" class="form-control" name="inspector" id="modifyForm_inspector" autocomplete="off" maxlength="250" readonly>
                        </div>
                    </div>
                    <h5 class="fw-bolder mt-5 mb-3">ข้อมูลการชำระเงิน</h5>
                    <div class="rounded border p-4">
                        <div class="mb-3">
                            <label for="modifyForm_fullname" class="form-label">ชื่อ-นามสกุล</label>
                            <input type="text" class="form-control" name="fullname" id="modifyForm_fullname" autocomplete="off" maxlength="250" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_invoiceNo" class="form-label">เลขที่</label>
                            <input type="text" class="form-control text-center" name="invoiceNo" id="modifyForm_invoiceNo" autocomplete="off" maxlength="6" readonly>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="modifyForm_date" class="form-label">วันที่ชำระเงิน</label>
                                <input type="date" class="form-control text-center" name="date" id="modifyForm_date" autocomplete="off" readonly>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="modifyForm_time" class="form-label">เวลาชำระเงิน</label>
                                <input type="time" class="form-control text-center" name="time" id="modifyForm_time" autocomplete="off" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_amount" class="form-label">จำนวนเงิน</label>
                            <input type="number" class="form-control text-center" name="amount" id="modifyForm_amount" min="0" step="0.01" autocomplete="off" placeholder="0.00" readonly>
                        </div>
                        <div>
                            <label class="form-label">รูปหลักฐานการชำระเงิน</label>
                            <div>
                                <img src="" class="img-fluid rounded border" id="modifyForm_image" style="max-width:600px">
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
                <h3 class="fw-bolder text-center">การชำระเงิน</h3>
                <div class="d-flex justify-content-between">
                    <select class="form-select w-auto" id="statusPayment">
                        <option value="all" selected>สถานะทั้งหมด</option>
                        <option value="pending">รอตรวจสอบชำระเงิน</option>
                        <option value="success">ยืนยันการชำระเงิน</option>
                        <option value="canceled">ยกเลิก</option>
                        <option value="other">อื่นๆ</option>
                    </select>
                </div>
            </div>
            <table class="table table-hover table-light w-100" id="paymentDT" style="min-width:1200px">
                <thead>                                   
                    <th width="40">#</th>
                    <th width="60">เลขที่</th>
                    <th width="60">สถานะ</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>หลักสูตร</th>
                    <th width="80">วันที่ชำระ</th>
                    <th width="60">เวลาชำระ</th>
                    <th width="80">จำนวนเงิน</th>
                    <th width="80">วันที่แจ้ง</th>
                    <th width="150">ผู้ตรวจสอบ</th>
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

                $(d => {
                    let paymentDT = $('#paymentDT').DataTable({
                        ajax: {
                            url: '<?= base_url(); ?>/api/get/payment/dt/all',
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
                            targets: [0,1,5,6,7,8],
                            className: 'text-center'
                        }, {
                            targets: 2,
                            className: 'text-center',
                            createdCell: (td, cellData, rowData, row, col) => {
                                let c = '';
                                switch(cellData) {
                                    case 'PENDING': c='<span class="badge bg-or-1">รอตรวจสอบชำระเงิน</span>'; break;
                                    case 'SUCCESS': c='<span class="badge bg-or-conts">ยืนยันการชำระเงิน</span>'; break;
                                    case 'CANCELED': c='<span class="badge bg-or-2">ยกเลิก</span>'; break;
                                    case 'OTHER': c='<span class="badge bg-dark">อื่นๆ</span>'; break;
                                }
                                $(td).html(c);
                            }
                        }, {
                            targets: 4,
                            createdCell: (td, cellData, rowData, row, col) => {
                                $(td).html('<a href="<?= base_url(); ?>/course/'+rowData[12]+'" target="_blank">'+cellData+'</a>');
                            }
                        }, {
                            targets: 10,
                            searchable: false,
                            orderable: false,
                            createdCell: (td, cellData, rowData, row, col) => {
                                $(td).append('<button class="btn btn-light btn-sm handler-mod" data-id="'+rowData[11]+'" title="แก้ไข"><i class="fa-solid fa-pen-to-square"></i></button>');
                                $(td).append('<button class="btn btn-light orange-theme-2 btn-sm handler-del" data-id="'+rowData[11]+'" title="ลบ"><i class="fa-solid fa-trash"></i></button>');
                            }
                        }]
                    });

                    $('select#statusPayment').on('change', e => paymentDT.ajax.url('<?= base_url(); ?>/api/get/payment/dt/'+$(e.currentTarget).val()).load());

                    const modifyModal = new bootstrap.Modal(document.getElementById('modifyModal'));
                    $(d).on('click', 'button.handler-mod', e => {
                        e.preventDefault();
                        const id = $(e.currentTarget).data('id');
                        $.ajax({
                            url: '<?= base_url(); ?>/api/get/payment/'+id,
                            type: 'GET',
                            dataType: 'json',
                            success: r => {
                                if (r.success) {
                                    const data = r.data;
                                    const f = $('form[name="modifyForm"]');
                                    $('input[name="paymentId"]', f).val(data.payment_id);
                                    $('input[name="status"][value="'+data.status+'"]', f).prop('checked', true);
                                    $('input[name="inspector"]', f).val(data.inspector_fullname);
                                    $('input[name="invoiceNo"]', f).val(data.enroll_invoice_no);
                                    $('input[name="fullname"]', f).val(data.enroll_fullname_tha);
                                    $('input[name="date"]', f).val(data.slip_date);
                                    $('input[name="time"]', f).val(data.slip_time);
                                    $('input[name="amount"]', f).val(data.slip_amount);
                                    $('input[name="status"]', f).prop('disabled', data.enroll_status=='SUCCESS');
                                    $('button[type="submit"]', f).prop('disabled', data.enroll_status=='SUCCESS');
                                    $('img#modifyForm_image').attr('src', '<?= base_url(); ?>/'+data.slip_image);
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
                            url: '<?= base_url(); ?>/api/modify/payment',
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
                                    }).then(() => paymentDT.ajax.reload(null, false));
                                    f[0].reset();
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
                            text: 'คุณมั่นใจที่จะลบการลงทะเบียนดังกล่าวหรือไม่ ?',
                            icon: 'question',
                            showCancelButton: true
                        }).then(res => {
                            if (res.isConfirmed) {
                                $.ajax({
                                    url: '<?= base_url(); ?>/api/delete/payment/'+id,
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
                                            }).then(() => paymentDT.ajax.reload(null, false));
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