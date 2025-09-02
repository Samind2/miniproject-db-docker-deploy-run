<div class="bg-white border-top">
    <div class="container-fluid px-4 px-lg-5">
        <nav class="py-2" aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">ส่วนผู้ดูแล</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url() ?>/manage/courses">หลักสูตรอบรม</a></li>
                <li class="breadcrumb-item active text-truncate" aria-current="page">หมวดหลักสูตร</li>
            </ol>
        </nav>
    </div>
</div>

<section class="container-fluid px-4 px-lg-5 mt-4">
    <div class="modal fade" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <form method="post" name="createForm" class="modal-dialog modal-dialog-centered modal-dialog-scrollable needs-validation" novalidate>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">เพิ่มใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="createForm_title" class="form-label">ชื่อหมวดหลักสูตร <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" id="createForm_title" maxlength="180" autocomplete="off" required>
                        <div class="invalid-feedback">กรุณากรอกชื่อหมวดหลักสูตร</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">เพิ่มใหม่</button>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="modifyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modifyModalLabel" aria-hidden="true">
        <form method="post" name="modifyForm" class="modal-dialog modal-dialog-centered modal-dialog-scrollable needs-validation" novalidate>
            <input type="hidden" name="courseCategoryId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifyModalLabel">แก้ไขข้อมูล</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="modifyForm_title" class="form-label">ชื่อหมวดหลักสูตร <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" id="modifyForm_title" maxlength="180" autocomplete="off" required>
                        <div class="invalid-feedback">กรุณากรอกชื่อหมวดหลักสูตร</div>
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
                <h3 class="fw-bolder text-center">หมวดหลักสูตร</h3>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">เพิ่มใหม่</button>
            </div>
            <table class="table table-hover table-light w-100" id="courseCategoriesDT" style="min-width:800px">
                <thead>
                    <th width="40">#</th>
                    <th>ชื่อหมวดหลักสูตร</th>
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
                    let courseCategoriesDT = $('#courseCategoriesDT').DataTable({
                        ajax: {
                            url: '<?= base_url(); ?>/api/get/course/category/dt',
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
                            targets: 0,
                            className: 'text-center'
                        }, {
                            targets: 2,
                            searchable: false,
                            orderable: false,
                            createdCell: (td, cellData, rowData, row, col) => {
                                $(td).append('<button class="btn btn-light btn-sm handler-mod" data-id="'+rowData[3]+'" title="แก้ไข"><i class="fa-solid fa-pen-to-square"></i></button>');
                                $(td).append('<button class="btn btn-light orange-theme-2 btn-sm handler-del" data-id="'+rowData[3]+'" title="ลบ"><i class="fa-solid fa-trash"></i></button>');
                            }
                        }]
                    });

                    const createModal = new bootstrap.Modal(document.getElementById('createModal'));
                    $(d).on('submit', 'form[name="createForm"]', e => {
                        e.preventDefault();
                        const f = $(e.currentTarget);
                        $.ajax({
                            url: '<?= base_url(); ?>/api/create/course/category',
                            type: 'POST',
                            data: f.serialize(),
                            dataType: 'json',
                            success: r => {
                                if (r.success) {
                                    Swal.fire({
                                        title: 'เพิ่มข้อมูลสำเร็จ',
                                        html: r.message,
                                        icon: 'success',
                                        timerProgressBar: true,
                                        timer: 2000
                                    }).then(() => courseCategoriesDT.ajax.reload(null, false));
                                    f[0].reset();
                                    createModal.hide();
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

                    const modifyModal = new bootstrap.Modal(document.getElementById('modifyModal'));
                    $(d).on('click', 'button.handler-mod', e => {
                        e.preventDefault();
                        const id = $(e.currentTarget).data('id');
                        $.ajax({
                            url: '<?= base_url(); ?>/api/get/course/category/'+id,
                            type: 'GET',
                            dataType: 'json',
                            success: r => {
                                if (r.success) {
                                    const data = r.data;
                                    const f = $('form[name="modifyForm"]');
                                    $('input[name="courseCategoryId"]', f).val(data.course_category_id);
                                    $('input[name="title"]', f).val(data.title);
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
                            url: '<?= base_url(); ?>/api/modify/course/category',
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
                                    }).then(() => courseCategoriesDT.ajax.reload(null, false));
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
                            html: 'คำเตือน: หลักสูตรอบรมในหมวดนี้จะถูกลบทั้งหมด<br>คุณมั่นใจที่จะลบหมวดหลักสูตรดังกล่าวหรือไม่ ?',
                            icon: 'question',
                            showCancelButton: true
                        }).then(res => {
                            if (res.isConfirmed) {
                                $.ajax({
                                    url: '<?= base_url(); ?>/api/delete/course/category/'+id,
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
                                            }).then(() => courseCategoriesDT.ajax.reload(null, false));
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