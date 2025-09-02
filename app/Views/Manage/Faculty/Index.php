<div class="bg-white border-top">
    <div class="container-fluid px-4 px-lg-5">
        <nav class="py-2" aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">ส่วนผู้ดูแล</a></li>
                <li class="breadcrumb-item active text-truncate" aria-current="page">คณะ/สาขาวิชา</li>
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
                        <label for="createForm_nameTha" class="form-label">ชื่อภาษาไทย <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nameTha" id="createForm_nameTha" maxlength="180" autocomplete="off" required>
                        <div class="invalid-feedback">กรุณากรอกชื่อภาษาไทย</div>
                    </div>
                    <div class="mb-3">
                        <label for="createForm_nameEng" class="form-label">ชื่อภาษาอังกฤษ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nameEng" id="createForm_nameEng" maxlength="180" autocomplete="off" required>
                        <div class="invalid-feedback">กรุณากรอกชื่อภาษาอังกฤษ</div>
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
        <form method="post" name="modifyForm" class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <input type="hidden" name="facultyId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifyModalLabel">แก้ไขข้อมูล</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="modifyForm_nameTha" class="form-label">ชื่อภาษาไทย <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nameTha" id="modifyForm_nameTha" maxlength="180" autocomplete="off" required>
                        <div class="invalid-feedback">กรุณากรอกชื่อภาษาไทย</div>
                    </div>
                    <div class="mb-3">
                        <label for="modifyForm_nameEng" class="form-label">ชื่อภาษาอังกฤษ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nameEng" id="modifyForm_nameEng" maxlength="180" autocomplete="off" required>
                        <div class="invalid-feedback">กรุณากรอกชื่อภาษาอังกฤษ</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="branchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="branchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="branchModalLabel">สาขาวิชา</h5>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary me-2" data-bs-target="#createBranchModal" data-bs-toggle="modal" data-bs-dismiss="modal">เพิ่มใหม่</button>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-light w-100" id="branchDT">
                        <thead>
                            <th>#</th>
                            <th>รหัสสาขาวิชา</th>
                            <th>ชื่อภาษาไทย</th>
                            <th>ชื่อภาษาอังกฤษ</th>
                            <th width="70"></th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createBranchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createBranchModalLabel" aria-hidden="true">
        <form method="post" name="createBranchForm" class="modal-dialog modal-dialog-centered modal-dialog-scrollable needs-validation" novalidate>
            <input type="hidden" name="faculty">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createBranchModalLabel">เพิ่มใหม่</h5>
                    <button type="button" class="btn-close" data-bs-target="#branchModal" data-bs-toggle="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="createBranchForm_code" class="form-label">รหัสสาขาวิชา <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="code" id="createBranchForm_code" min="1000" max="9999" step="1" value="1000" autocomplete="off" required>
                        <div class="invalid-feedback">รหัสสาขาวิชา</div>
                    </div>
                    <div class="mb-3">
                        <label for="createBranchForm_nameTha" class="form-label">ชื่อภาษาไทย <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nameTha" id="createBranchForm_nameTha" maxlength="180" autocomplete="off" required>
                        <div class="invalid-feedback">กรุณากรอกชื่อภาษาไทย</div>
                    </div>
                    <div class="mb-3">
                        <label for="createBranchForm_nameEng" class="form-label">ชื่อภาษาอังกฤษ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nameEng" id="createBranchForm_nameEng" maxlength="180" autocomplete="off" required>
                        <div class="invalid-feedback">กรุณากรอกชื่อภาษาอังกฤษ</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-target="#branchModal" data-bs-toggle="modal" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">เพิ่มใหม่</button>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="modifyBranchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modifyBranchModalLabel" aria-hidden="true">
        <form method="post" name="modifyBranchForm" class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <input type="hidden" name="branchId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifyBranchModalLabel">แก้ไขข้อมูล</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="modifyBranchForm_code" class="form-label">รหัสสาขาวิชา <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="code" id="modifyBranchForm_code" min="1000" max="9999" step="1" value="1000" autocomplete="off" required>
                        <div class="invalid-feedback">รหัสสาขาวิชา</div>
                    </div>
                    <div class="mb-3">
                        <label for="modifyBranchForm_nameTha" class="form-label">ชื่อภาษาไทย <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nameTha" id="modifyBranchForm_nameTha" maxlength="180" autocomplete="off" required>
                        <div class="invalid-feedback">กรุณากรอกชื่อภาษาไทย</div>
                    </div>
                    <div class="mb-3">
                        <label for="modifyBranchForm_nameEng" class="form-label">ชื่อภาษาอังกฤษ <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nameEng" id="modifyBranchForm_nameEng" maxlength="180" autocomplete="off" required>
                        <div class="invalid-feedback">กรุณากรอกชื่อภาษาอังกฤษ</div>
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
                <h3 class="fw-bolder text-center">คณะ/สาขาวิชา</h3>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">เพิ่มใหม่</button>
            </div>
            <table class="table table-hover table-light w-100" id="facultyDT" style="min-width:800px">
                <thead>
                    <th width="40">#</th>
                    <th>ชื่อภาษาไทย</th>
                    <th>ชื่อภาษาอังกฤษ</th>
                    <th width="80">สาขาที่สังกัด</th>
                    <th width="100"></th>
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
                    let facultyDT = $('#facultyDT').DataTable({
                        ajax: {
                            url: '<?= base_url(); ?>/api/get/faculty/dt',
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
                            targets: [0,3],
                            className: 'text-center'
                        }, {
                            targets: 4,
                            searchable: false,
                            orderable: false,
                            createdCell: (td, cellData, rowData, row, col) => {
                                $(td).append('<button class="btn btn-light btn-sm handler-branch" data-id="'+rowData[5]+'" title="สาขาวิชา"><i class="fa-solid fa-bars"></i></button>');
                                $(td).append('<button class="btn btn-light btn-sm handler-mod" data-id="'+rowData[5]+'" title="แก้ไข"><i class="fa-solid fa-pen-to-square"></i></button>');
                                $(td).append('<button class="btn btn-light orange-theme-2 btn-sm handler-del" data-id="'+rowData[5]+'" title="ลบ"><i class="fa-solid fa-trash"></i></button>');
                            }
                        }]
                    });

                    const createModal = new bootstrap.Modal(document.getElementById('createModal'));
                    $(d).on('submit', 'form[name="createForm"]', e => {
                        e.preventDefault();
                        const f = $(e.currentTarget);
                        $.ajax({
                            url: '<?= base_url(); ?>/api/create/faculty',
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
                                    }).then(() => facultyDT.ajax.reload(null, false));
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
                            url: '<?= base_url(); ?>/api/get/faculty/'+id,
                            type: 'GET',
                            dataType: 'json',
                            success: r => {
                                if (r.success) {
                                    const data = r.data;
                                    const f = $('form[name="modifyForm"]');
                                    $('input[name="facultyId"]', f).val(data.faculty_id);
                                    $('input[name="nameTha"]', f).val(data.name_tha);
                                    $('input[name="nameEng"]', f).val(data.name_eng);
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
                            url: '<?= base_url(); ?>/api/modify/faculty',
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
                                    }).then(() => facultyDT.ajax.reload(null, false));
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
                            text: 'คุณมั่นใจที่จะลบผู้ใช้งานดังกล่าวหรือไม่ ?',
                            icon: 'question',
                            showCancelButton: true
                        }).then(res => {
                            if (res.isConfirmed) {
                                $.ajax({
                                    url: '<?= base_url(); ?>/api/delete/faculty/'+id,
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
                                            }).then(() => facultyDT.ajax.reload(null, false));
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

                    let branchDT = $('#branchDT').DataTable({
                        ajax: {
                            url: '<?= base_url(); ?>/api/get/branch/dt/0',
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
                            targets: [0,1],
                            className: 'text-center'
                        }, {
                            targets: 4,
                            searchable: false,
                            orderable: false,
                            createdCell: (td, cellData, rowData, row, col) => {
                                $(td).append('<button class="btn btn-light btn-sm handler-branch-mod" data-id="'+rowData[5]+'" title="แก้ไข"><i class="fa-solid fa-pen-to-square"></i></button>');
                                $(td).append('<button class="btn btn-light orange-theme-2 btn-sm handler-branch-del" data-id="'+rowData[5]+'" title="ลบ"><i class="fa-solid fa-trash"></i></button>');
                            }
                        }]
                    });
                    const branchModal = new bootstrap.Modal(document.getElementById('branchModal'));
                    $('#branchModal').on('shown.bs.modal', e => branchDT.columns.adjust());
                    $(d).on('click', 'button.handler-branch', e => {
                        e.preventDefault();
                        const id = $(e.currentTarget).data('id');
                        $('form[name="createBranchForm"] input[name="faculty"]').val(id);
                        branchDT.ajax.url('<?= base_url(); ?>/api/get/branch/dt/'+id).load();
                        branchModal.show();
                    });

                    const createBranchModal = new bootstrap.Modal(document.getElementById('createBranchModal'));
                    $(d).on('submit', 'form[name="createBranchForm"]', e => {
                        e.preventDefault();
                        const f = $(e.currentTarget);
                        $.ajax({
                            url: '<?= base_url(); ?>/api/create/branch',
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
                                    }).then(() => {
                                        branchDT.ajax.reload(null, false);
                                        facultyDT.ajax.reload(null, false);
                                        branchModal.show();
                                    });
                                    f[0].reset();
                                    createBranchModal.hide();
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

                    const modifyBranchModal = new bootstrap.Modal(document.getElementById('modifyBranchModal'));
                    $(d).on('click', 'button.handler-branch-mod', e => {
                        e.preventDefault();
                        const id = $(e.currentTarget).data('id');
                        $.ajax({
                            url: '<?= base_url(); ?>/api/get/branch/'+id,
                            type: 'GET',
                            dataType: 'json',
                            success: r => {
                                if (r.success) {
                                    const data = r.data;
                                    const f = $('form[name="modifyBranchForm"]');
                                    $('input[name="branchId"]', f).val(data.branch_id);
                                    $('input[name="faculty"]', f).val(data.faculty_id);
                                    $('input[name="code"]', f).val(data.code);
                                    $('input[name="nameTha"]', f).val(data.name_tha);
                                    $('input[name="nameEng"]', f).val(data.name_eng);
                                    modifyBranchModal.show();
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

                    $(d).on('submit', 'form[name="modifyBranchForm"]', e => {
                        e.preventDefault();
                        const f = $(e.currentTarget);
                        $.ajax({
                            url: '<?= base_url(); ?>/api/modify/branch',
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
                                    }).then(() => branchDT.ajax.reload(null, false));
                                    modifyBranchModal.hide();
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

                    $(d).on('click', 'button.handler-branch-del', e => {
                        e.preventDefault();
                        const id = $(e.currentTarget).data('id');
                        Swal.fire({
                            title: 'ยืนยันการลบข้อมูล',
                            text: 'คุณมั่นใจที่จะลบผู้ใช้งานดังกล่าวหรือไม่ ?',
                            icon: 'question',
                            showCancelButton: true
                        }).then(res => {
                            if (res.isConfirmed) {
                                $.ajax({
                                    url: '<?= base_url(); ?>/api/delete/branch/'+id,
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
                                            }).then(() => {
                                                branchDT.ajax.reload(null, false);
                                                facultyDT.ajax.reload(null, false);
                                            });
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