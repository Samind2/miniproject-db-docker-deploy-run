<div class="bg-white border-top">
    <div class="container-fluid px-4 px-lg-5">
        <nav class="py-2" aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">ส่วนผู้ดูแล</a></li>
                <li class="breadcrumb-item active text-truncate" aria-current="page">วิทยากร</li>
            </ol>
        </nav>
    </div>
</div>

<section class="container-fluid px-4 px-lg-5 mt-4">
    <div class="modal fade" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <form method="post" name="createForm" class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable needs-validation" novalidate>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">เพิ่มใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="fw-bolder mb-3">ข้อมูลทั่วไป</h5>
                    <div class="rounded border p-4">
                        <div class="mb-3">
                            <label for="createForm_firstname" class="form-label">ชื่อวิทยากร <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="firstname" id="createForm_firstname" maxlength="200" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกชื่อวิทยากร</div>
                        </div>
                        <div class="mb-3">
                            <label for="createForm_lastname" class="form-label">นามสกุลวิทยากร <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="lastname" id="createForm_lastname" maxlength="200" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกนามสกุลวิทยากร</div>
                        </div>
                        <div class="mb-3">
                            <label for="createForm_url" class="form-label">URL Address</label>
                            <input type="text" class="form-control" name="url" id="createForm_url" autocomplete="off" placeholder="https://www.example.com">
                        </div>
                        <div class="mb-3">
                            <label for="createForm_image" class="form-label">รูปภาพ <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="createForm_image" name="image" aria-label="Upload" accept="<?= join(',', $fileImage['accept']); ?>" required>
                            <small class="text-muted">รองรับไฟล์ประเภท <?= join(', ', $fileImage['extension']); ?> : ขนาดไม่เกิน <?= number_to_size($fileImage['maxSize']); ?></small>
                            <div class="invalid-feedback">กรุณาอัปโหลดรูปภาพ</div>
                        </div>
                    </div>
                    <h5 class="fw-bolder mt-5 mb-3">ภายใต้สังกัด</h5>
                    <div class="rounded border p-4">
                        <div class="row row-cols-2 g-4 mb-3">
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="isInternal" id="createForm_isInternalTrue" autocomplete="off" value="TRUE" checked>
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="createForm_isInternalTrue">บุคคลภายใน</label>
                            </div>
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="isInternal" id="createForm_isInternalFalse" autocomplete="off" value="FALSE">
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="createForm_isInternalFalse"></i>บุคคลภายนอก</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="createForm_branch" class="form-label">สังกัด <span class="text-danger">*</span></label>
                            <select class="form-select" name="branch" id="createForm_branch" size="0" required>
                                <?php foreach($branchOptions as $branchOption): ?>
                                    <optgroup label="<?= $branchOption['label']; ?>">
                                        <?php foreach($branchOption['options'] as $option): ?>
                                            <option value="<?= $option['branch_id']; ?>"><?= $option['code'].' '.$option['name_tha']; ?></option>
                                        <?php endforeach ?>
                                    </optgroup>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">กรุณาเลือกสังกัด</div>
                        </div>
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
        <form method="post" name="modifyForm" class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable needs-validation" novalidate>
            <input type="hidden" name="lecturerId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifyModalLabel">แก้ไขข้อมูล</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="fw-bolder mb-3">ข้อมูลทั่วไป</h5>
                    <div class="rounded border p-4">
                        <div class="mb-3">
                            <label for="modifyForm_firstname" class="form-label">ชื่อวิทยากร <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="firstname" id="modifyForm_firstname" maxlength="200" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกชื่อวิทยากร</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_lastname" class="form-label">นามสกุลวิทยากร <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="lastname" id="modifyForm_lastname" maxlength="200" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกนามสกุลวิทยากร</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_url" class="form-label">URL Address</label>
                            <input type="text" class="form-control" name="url" id="modifyForm_url" autocomplete="off" placeholder="https://www.example.com">
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_image" class="form-label">เปลี่ยนรูปภาพ</label>
                            <input type="file" class="form-control" id="modifyForm_image" name="image" aria-label="Upload" accept="<?= join(',', $fileImage['accept']); ?>">
                            <small class="text-muted">รองรับไฟล์ประเภท <?= join(', ', $fileImage['extension']); ?> : ขนาดไม่เกิน <?= number_to_size($fileImage['maxSize']); ?></small>
                            <div class="mt-3" preview="image"></div>
                        </div>
                    </div>
                    <h5 class="fw-bolder mt-5 mb-3">ภายใต้สังกัด</h5>
                    <div class="rounded border p-4">
                        <div class="row row-cols-2 g-4 mb-3">
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="isInternal" id="modifyForm_isInternalTrue" autocomplete="off" value="TRUE" checked>
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="modifyForm_isInternalTrue">บุคคลภายใน</label>
                            </div>
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="isInternal" id="modifyForm_isInternalFalse" autocomplete="off" value="FALSE">
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="modifyForm_isInternalFalse"></i>บุคคลภายนอก</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_branch" class="form-label">สังกัด <span class="text-danger">*</span></label>
                            <select class="form-select" name="branch" id="modifyForm_branch" size="0" required>
                                <?php foreach($branchOptions as $branchOption): ?>
                                    <optgroup label="<?= $branchOption['label']; ?>">
                                        <?php foreach($branchOption['options'] as $option): ?>
                                            <option value="<?= $option['branch_id']; ?>"><?= $option['code'].' '.$option['name_tha']; ?></option>
                                        <?php endforeach ?>
                                    </optgroup>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">กรุณาเลือกสังกัด</div>
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
                <h3 class="fw-bolder text-center">วิทยากร</h3>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">เพิ่มใหม่</button>
            </div>
            <table class="table table-hover table-light w-100" id="lecturerDT" style="min-width:800px">
                <thead>
                    <th>#</th>
                    <th width="80">รูปภาพ</th>
                    <th>ชื่อวิทยากร</th>
                    <th width="80">ประเภท</th>
                    <th>สังกัด</th>
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
                    let lecturerDT = $('#lecturerDT').DataTable({
                        ajax: {
                            url: '<?= base_url(); ?>/api/get/lecturer/dt',
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
                            targets: 1,
                            className: 'text-center',
                            createdCell: (td, cellData, rowData, row, col) => {
                                $(td).html('<img src="<?= base_url(); ?>/'+cellData+'" class="border rounded-circle" width="50" height="50" />');
                            }
                        }, {
                            targets: 2,
                            createdCell: (td, cellData, rowData, row, col) => {
                                if(rowData[7]!=='') $(td).append('<a href="'+rowData[7]+'" class="ms-2" target="_blank" title="ข้อมูลวิทยากร"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>');
                            }
                        }, {
                            targets: 3,
                            className: 'text-center',
                            createdCell: (td, cellData, rowData, row, col) => {
                                $(td).html('<span class="badge bg-'+(cellData=='TRUE' ? 'or-conts' : 'or-2')+'">'+(cellData=='TRUE' ? 'บุคคลภายใน' : 'บุคคลภายนอก')+'</span>');
                            }
                        }, {
                            targets: 5,
                            searchable: false,
                            orderable: false,
                            createdCell: (td, cellData, rowData, row, col) => {
                                $(td).append('<button class="btn btn-light btn-sm handler-mod" data-id="'+rowData[6]+'" title="แก้ไข"><i class="fa-solid fa-pen-to-square"></i></button>');
                                $(td).append('<button class="btn btn-light orange-theme-2 btn-sm handler-del" data-id="'+rowData[6]+'" title="ลบ"><i class="fa-solid fa-trash"></i></button>');
                            }
                        }]
                    });

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

                    const createModal = new bootstrap.Modal(document.getElementById('createModal'));
                    $(d).on('submit', 'form[name="createForm"]', e => {
                        e.preventDefault();
                        const f = $(e.currentTarget);
                        $.ajax({
                            url: '<?= base_url(); ?>/api/create/lecturer',
                            type: 'POST',
                            dataType: 'json',
                            data: new FormData(e.currentTarget),
                            cache: false,
                            processData: false,
                            contentType: false,
                            success: r => {
                                if (r.success) {
                                    Swal.fire({
                                        title: 'บันทึกข้อมูลสำเร็จ',
                                        html: r.message,
                                        icon: 'success',
                                        timerProgressBar: true,
                                        timer: 2000
                                    }).then(() => lecturerDT.ajax.reload(null, false));
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
                            url: '<?= base_url(); ?>/api/get/lecturer/'+id,
                            type: 'GET',
                            dataType: 'json',
                            success: r => {
                                if (r.success) {
                                    const previewImage = $('[preview="image"]');
                                    const data = r.data;
                                    const f = $('form[name="modifyForm"]');
                                    previewImage.html('');
                                    $('input[name="lecturerId"]', f).val(data.lecturer_id);
                                    $('input[name="firstname"]', f).val(data.firstname);
                                    $('input[name="lastname"]', f).val(data.lastname);
                                    $('input[name="url"]', f).val(data.url);
                                    $('input[name="isInternal"][value="'+data.is_internal+'"]', f).prop('checked', true);
                                    $('select[name="branch"]', f).val(data.branch_id);
                                    if (data.image != '')
                                        previewImage.append($('<img/>').attr({src: '<?= base_url(); ?>/'+data.image, class: 'rounder', width: '200'}));
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
                            url: '<?= base_url(); ?>/api/modify/lecturer',
                            type: 'POST',
                            dataType: 'json',
                            data: new FormData(e.currentTarget),
                            cache: false,
                            processData: false,
                            contentType: false,
                            success: r => {
                                if (r.success) {
                                    Swal.fire({
                                        title: 'บันทึกข้อมูลสำเร็จ',
                                        html: r.message,
                                        icon: 'success',
                                        timerProgressBar: true,
                                        timer: 2000
                                    }).then(() => lecturerDT.ajax.reload(null, false));
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
                            text: 'คุณมั่นใจที่จะลบวิทยากรดังกล่าวหรือไม่ ?',
                            icon: 'question',
                            showCancelButton: true
                        }).then(res => {
                            if (res.isConfirmed) {
                                $.ajax({
                                    url: '<?= base_url(); ?>/api/delete/lecturer/'+id,
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
                                            }).then(() => lecturerDT.ajax.reload(null, false));
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