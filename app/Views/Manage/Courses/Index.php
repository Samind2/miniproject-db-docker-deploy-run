<div class="bg-white border-top">
    <div class="container-fluid px-4 px-lg-5">
        <nav class="py-2" aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">ส่วนผู้ดูแล</a></li>
                <li class="breadcrumb-item active text-truncate" aria-current="page">หลักสูตรอบรม</li>
            </ol>
        </nav>
    </div>
</div>

<section class="container-fluid mt-4">
    <div class="modal fade" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <form method="post" name="createForm" class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl needs-validation" novalidate>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">เพิ่มใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="fw-bolder mb-3">ข้อมูลทั่วไป</h5>
                    <div class="rounded border p-4">
                        <div class="mb-3">
                            <label for="createForm_title" class="form-label">ชื่อหลักสูตร <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" id="createForm_title" maxlength="250" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกชื่อหลักสูตร</div>
                        </div>
                        <div class="mb-3">
                            <label for="createForm_courseCategory" class="form-label">หมวดหลักสูตร <span class="text-danger">*</span></label>
                            <select class="form-select" name="courseCategory" id="createForm_courseCategory" required>
                                <?php foreach($courseCategoryList as $i => $courseCategory): ?>
                                    <option value="<?= $courseCategory['course_category_id']; ?>"><?= $courseCategory['title']; ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">กรุณาเลือกหมวดหลักสูตร</div>
                        </div>
                        <div class="mb-3">
                            <label for="createForm_branch" class="form-label">หลักสูตรภายใต้ คณะ/สาขาวิชา <span class="text-danger">*</span></label>
                            <select class="form-select" name="branch" id="createForm_branch" required>
                                <?php foreach($branchOptions as $branchOption): ?>
                                    <optgroup label="<?= $branchOption['label']; ?>">
                                        <?php foreach($branchOption['options'] as $option): ?>
                                            <option value="<?= $option['branch_id']; ?>"><?= $option['code'].' '.$option['name_tha']; ?></option>
                                        <?php endforeach ?>
                                    </optgroup>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">กรุณาเลือกคณะ/สาขาวิชา</div>
                        </div>
                        <div class="mb-3">
                            <label for="createForm_classHours" class="form-label">จำนวนชั่วโมงเรียน (ชั่วโมง) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control text-center" name="classHours" id="createForm_classHours" autocomplete="off" min="1" max="100" step="1" value="1" required>
                            <div class="invalid-feedback">กรุณากรอกจำนวนชั่วโมงเรียน (ชั่วโมง)</div>
                        </div>
                        <div class="mb-3">
                            <label for="createForm_regisFee" class="form-label">ค่าสมัคร/ท่าน (THB.) (0 = ไม่มีค่าใช้จ่าย) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control text-center" name="regisFee" id="createForm_regisFee" autocomplete="off" min="0" max="10000" step="1" value="0" required>
                            <div class="invalid-feedback">กรุณากรอกค่าสมัคร/ท่าน (THB.)</div>
                        </div>
                    </div>
                    <h5 class="fw-bolder mt-5 mb-3">สถานที่</h5>
                    <div class="rounded border p-4">
                        <div class="row row-cols-2 g-4">
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="locatType" id="createForm_locatOnSite" autocomplete="off" value="ONSITE" checked>
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="createForm_locatOnSite">On-Site</label>
                            </div>
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="locatType" id="createForm_locatOnline" autocomplete="off" value="ONLINE">
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="createForm_locatOnline"></i>Online</label>
                            </div>
                        </div>
                        <div class="mt-3" id="createForm_locatOnSiteContainer">
                            <div class="mb-3">
                                <label for="createForm_location" class="form-label">สถานที่จัดอบรม <span class="text-danger">*</span></label>
                                <input type="text" class="form-control createform-locat-onsite" name="location" id="createForm_location" autocomplete="off" placeholder="ชื่อสถานที่ / อาคาร / ห้อง / ชั้น / โซน" required>
                                <div class="invalid-feedback">กรุณากรอกสถานที่จัดอบรม</div>
                            </div>
                        </div>
                        <div class="mt-3" id="createForm_locatOnlineContainer" style="display:none">
                            <div class="mb-3">
                                <label for="createForm_onlineUrl" class="form-label">URL Address</label>
                                <input type="text" class="form-control createform-locat-online" name="onlineUrl" id="createForm_onlineUrl" autocomplete="off" placeholder="https:\\">
                            </div>
                            <div class="mb-3">
                                <label for="createForm_onlineRequirement" class="form-label">เพิ่มเติม (ถ้ามี)</label>
                                <input type="text" class="form-control createform-locat-online" name="onlineRequirement" id="createForm_onlineRequirement" autocomplete="off">
                            </div>
                        </div>
                        <script>
                            $(d => {
                                $('form[name="createForm"] input[name="locatType"]').on('change', e => {
                                    let elOnSite = $('#createForm_locatOnSiteContainer');
                                    let cOnSite = $('.createform-locat-onsite');
                                    let elOnline = $('#createForm_locatOnlineContainer');
                                    let cOnline = $('.createform-locat-online');
                                    if ($(e.currentTarget).val()=='ONSITE') {
                                        elOnSite.slideDown();
                                        cOnSite.prop('required', true);
                                        elOnline.slideUp();
                                        cOnline.prop('required', false);
                                    } else {
                                        elOnSite.slideUp();
                                        cOnSite.prop('required', false);
                                        elOnline.slideDown();
                                        cOnline.prop('required', true);
                                    }
                                });
                            });
                        </script>
                    </div>
                    <h5 class="fw-bolder mt-5 mb-3">วิทยากร</h5>
                    <div class="rounded border p-4">
                        <div class="mb-3">
                            <label for="createForm_lecturers" class="form-label">วิทยากร (เลือกได้มากกว่า 1 ท่าน) <span class="text-danger">*</span></label>
                            <select class="form-select" name="lecturers[]" id="createForm_lecturers" size="0" data-placeholder="เลือกวิทยากร" multiple required>
                                <?php foreach($lecturerOptions as $lecturerOption): ?>
                                    <optgroup label="<?= $lecturerOption['label']; ?>">
                                        <?php foreach($lecturerOption['options'] as $option): ?>
                                            <option value="<?= $option['lecturer_id']; ?>"><?= $option['fullname']; ?></option>
                                        <?php endforeach ?>
                                    </optgroup>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">กรุณาเลือกวิทยากร</div>
                        </div>
                    </div>
                    <h5 class="fw-bolder mt-5 mb-3">รายละเอียด</h5>
                    <div class="rounded border p-4">
                        <div class="mb-3">
                            <label for="createForm_objective" class="form-label">วัตถุประสงค์ <span class="text-danger">*</span></label>
                            <textarea class="form-control summernote" name="objective" id="createForm_objective" autocomplete="off" required></textarea>
                            <div class="invalid-feedback">กรุณากรอกวัตถุประสงค์</div>
                        </div>
                        <div class="mb-3">
                            <label for="createForm_target" class="form-label">กลุ่มเป้าหมาย <span class="text-danger">*</span></label>
                            <textarea class="form-control summernote" name="target" id="createForm_target" autocomplete="off" required></textarea>
                            <div class="invalid-feedback">กรุณากรอกกลุ่มเป้าหมาย</div>
                        </div>
                        <div class="mb-3">
                            <label for="createForm_content" class="form-label">ขอบข่ายเนื้อหา <span class="text-danger">*</span></label>
                            <textarea class="form-control summernote" name="content" id="createForm_content" autocomplete="off" required></textarea>
                            <div class="invalid-feedback">กรุณากรอกขอบข่ายเนื้อหา</div>
                        </div>
                        <div class="mb-3">
                            <label for="createForm_evaluation" class="form-label">การวัดผลประเมินผล <span class="text-danger">*</span></label>
                            <textarea class="form-control summernote" name="evaluation" id="createForm_evaluation" autocomplete="off" required></textarea>
                            <div class="invalid-feedback">กรุณากรอกการวัดผลประเมินผล</div>
                        </div>
                        <div class="mb-3">
                            <label for="createForm_expectedResults" class="form-label">ผลที่คาดว่าจะได้รับ <span class="text-danger">*</span></label>
                            <textarea class="form-control summernote" name="expectedResults" id="createForm_expectedResults" autocomplete="off" required></textarea>
                            <div class="invalid-feedback">กรุณากรอกผลที่คาดว่าจะได้รับ</div>
                        </div>
                        <div class="mb-3">
                            <label for="createForm_contact" class="form-label">สอบถามเพิ่มเติม <span class="text-danger">*</span></label>
                            <textarea class="form-control summernote" name="contact" id="createForm_contact" autocomplete="off" required></textarea>
                            <div class="invalid-feedback">กรุณากรอกสอบถามเพิ่มเติม</div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="createForm_schedule" class="form-label">กำหนดการ <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="createForm_schedule" name="schedule" aria-label="Upload" accept="<?= join(',', $fileSchedule['accept']); ?>" required>
                                <small class="text-muted">รองรับไฟล์ประเภท <?= join(', ', $fileSchedule['extension']); ?> : ขนาดไม่เกิน <?= number_to_size($fileSchedule['maxSize']); ?></small>
                                <div class="invalid-feedback">กรุณาอัปโหลดกำหนดการ</div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="createForm_image" class="form-label">รูปภาพ <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="createForm_image" name="image" aria-label="Upload" accept="<?= join(',', $fileImage['accept']); ?>" required>
                                <small class="text-muted">รองรับไฟล์ประเภท <?= join(', ', $fileImage['extension']); ?> : ขนาดไม่เกิน <?= number_to_size($fileImage['maxSize']); ?></small>
                                <div class="invalid-feedback">กรุณาอัปโหลดรูปภาพ</div>
                            </div>
                        </div>
                    </div>
                    <h5 class="fw-bolder mt-5 mb-3">การเข้าถึงเนื้อหา</h5>
                    <div class="rounded border p-4">
                        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-3 g-4">
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="display" id="createForm_displayPrivate" autocomplete="off" value="PRIVATE" checked>
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="createForm_displayPrivate">
                                    <i class="fa-solid fa-lock me-2"></i>ส่วนตัว<br>
                                    <span class="fs-sm">ซ่อนจากรายการ ไม่สามารถอ่านเนื้อหาได้</span>
                                </label>
                            </div>
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="display" id="createForm_displaySpecific" autocomplete="off" value="SPECIFIC">
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="createForm_displaySpecific">
                                    <i class="fa-solid fa-users me-2"></i>จำกัด<br>
                                    <span class="fs-sm">ซ่อนจากรายการ สามารถอ่านเนื้อหาได้</span>
                                </label>
                            </div>
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="display" id="createForm_displayPublic" autocomplete="off" value="PUBLIC">
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="createForm_displayPublic">
                                    <i class="fa-solid fa-earth-asia me-2"></i>สาธารณะ<br>
                                    <span class="fs-sm">แสดงรายการ สามารถอ่านเนื้อหาได้</span>
                                </label>
                            </div>
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
        <form method="post" name="modifyForm" class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl needs-validation" novalidate>
            <input type="hidden" name="courseId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifyModalLabel">แก้ไขข้อมูล</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <h5 class="fw-bolder mb-3">ข้อมูลทั่วไป</h5>
                    <div class="rounded border p-4">
                        <div class="mb-3">
                            <label for="modifyForm_title" class="form-label">ชื่อหลักสูตร <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" id="modifyForm_title" maxlength="250" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกชื่อหลักสูตร</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_courseCategory" class="form-label">หมวดหลักสูตร <span class="text-danger">*</span></label>
                            <select class="form-select" name="courseCategory" id="modifyForm_courseCategory" required>
                                <?php foreach($courseCategoryList as $i => $courseCategory): ?>
                                    <option value="<?= $courseCategory['course_category_id']; ?>"><?= $courseCategory['title']; ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">กรุณาเลือกหมวดหลักสูตร</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_branch" class="form-label">หลักสูตรภายใต้ คณะ/สาขาวิชา <span class="text-danger">*</span></label>
                            <select class="form-select" name="branch" id="modifyForm_branch" required>
                                <?php foreach($branchOptions as $branchOption): ?>
                                    <optgroup label="<?= $branchOption['label']; ?>">
                                        <?php foreach($branchOption['options'] as $option): ?>
                                            <option value="<?= $option['branch_id']; ?>"><?= $option['code'].' '.$option['name_tha']; ?></option>
                                        <?php endforeach ?>
                                    </optgroup>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">กรุณาเลือกคณะ/สาขาวิชา</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_classHours" class="form-label">จำนวนชั่วโมงเรียน (ชั่วโมง) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control text-center" name="classHours" id="modifyForm_classHours" autocomplete="off" min="1" max="100" step="1" value="1" required>
                            <div class="invalid-feedback">กรุณากรอกจำนวนชั่วโมงเรียน (ชั่วโมง)</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_regisFee" class="form-label">ค่าสมัคร/ท่าน (THB.) (0 = ไม่มีค่าใช้จ่าย) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control text-center" name="regisFee" id="modifyForm_regisFee" autocomplete="off" min="0" max="10000" step="1" value="0" required>
                            <div class="invalid-feedback">กรุณากรอกค่าสมัคร/ท่าน (THB.)</div>
                        </div>
                    </div>
                    <h5 class="fw-bolder mt-5 mb-3">สถานที่</h5>
                    <div class="rounded border p-4">
                        <div class="row row-cols-2 g-4">
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="locatType" id="modifyForm_locatOnSite" autocomplete="off" value="ONSITE" checked>
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="modifyForm_locatOnSite">On-Site</label>
                            </div>
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="locatType" id="modifyForm_locatOnline" autocomplete="off" value="ONLINE">
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="modifyForm_locatOnline"></i>Online</label>
                            </div>
                        </div>
                        <div class="mt-3" id="modifyForm_locatOnSiteContainer">
                            <div class="mb-3">
                                <label for="modifyForm_location" class="form-label">สถานที่จัดอบรม <span class="text-danger">*</span></label>
                                <input type="text" class="form-control modifyform-locat-onsite" name="location" id="modifyForm_location" autocomplete="off" placeholder="ชื่อสถานที่ / อาคาร / ห้อง / ชั้น / โซน" required>
                                <div class="invalid-feedback">กรุณากรอกสถานที่จัดอบรม</div>
                            </div>
                        </div>
                        <div class="mt-3" id="modifyForm_locatOnlineContainer" style="display:none">
                            <div class="mb-3">
                                <label for="modifyForm_onlineUrl" class="form-label">URL Address</label>
                                <input type="text" class="form-control modifyform-locat-online" name="onlineUrl" id="modifyForm_onlineUrl" autocomplete="off" placeholder="https:\\">
                            </div>
                            <div class="mb-3">
                                <label for="modifyForm_onlineRequirement" class="form-label">เพิ่มเติม (ถ้ามี)</label>
                                <input type="text" class="form-control modifyform-locat-online" name="onlineRequirement" id="modifyForm_onlineRequirement" autocomplete="off">
                            </div>
                        </div>
                        <script>
                            $(d => {
                                $('form[name="modifyForm"] input[name="locatType"]').on('change', e => {
                                    let elOnSite = $('#modifyForm_locatOnSiteContainer');
                                    let cOnSite = $('.modifyform-locat-onsite');
                                    let elOnline = $('#modifyForm_locatOnlineContainer');
                                    let cOnline = $('.modifyform-locat-online');
                                    if ($(e.currentTarget).val()=='ONSITE') {
                                        elOnSite.slideDown();
                                        cOnSite.prop('required', true);
                                        elOnline.slideUp();
                                        cOnline.prop('required', false);
                                    } else {
                                        elOnSite.slideUp();
                                        cOnSite.prop('required', false);
                                        elOnline.slideDown();
                                        cOnline.prop('required', true);
                                    }
                                });
                            });
                        </script>
                    </div>
                    <h5 class="fw-bolder mt-5 mb-3">วิทยากร</h5>
                    <div class="rounded border p-4">
                        <div class="mb-3">
                            <label for="modifyForm_lecturers" class="form-label">วิทยากร (เลือกได้มากกว่า 1 ท่าน) <span class="text-danger">*</span></label>
                            <select class="form-select" name="lecturers[]" id="modifyForm_lecturers" size="0" data-placeholder="เลือกวิทยากร" multiple required>
                                <?php foreach($lecturerOptions as $lecturerOption): ?>
                                    <optgroup label="<?= $lecturerOption['label']; ?>">
                                        <?php foreach($lecturerOption['options'] as $option): ?>
                                            <option value="<?= $option['lecturer_id']; ?>"><?= $option['fullname']; ?></option>
                                        <?php endforeach ?>
                                    </optgroup>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">กรุณาเลือกวิทยากร</div>
                        </div>
                    </div>
                    <h5 class="fw-bolder mt-5 mb-3">รายละเอียด</h5>
                    <div class="rounded border p-4">
                        <div class="mb-3">
                            <label for="modifyForm_objective" class="form-label">วัตถุประสงค์ <span class="text-danger">*</span></label>
                            <textarea class="form-control summernote" name="objective" id="modifyForm_objective" autocomplete="off" required></textarea>
                            <div class="invalid-feedback">กรุณากรอกวัตถุประสงค์</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_target" class="form-label">กลุ่มเป้าหมาย <span class="text-danger">*</span></label>
                            <textarea class="form-control summernote" name="target" id="modifyForm_target" autocomplete="off" required></textarea>
                            <div class="invalid-feedback">กรุณากรอกกลุ่มเป้าหมาย</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_content" class="form-label">ขอบข่ายเนื้อหา <span class="text-danger">*</span></label>
                            <textarea class="form-control summernote" name="content" id="modifyForm_content" autocomplete="off" required></textarea>
                            <div class="invalid-feedback">กรุณากรอกขอบข่ายเนื้อหา</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_evaluation" class="form-label">การวัดผลประเมินผล <span class="text-danger">*</span></label>
                            <textarea class="form-control summernote" name="evaluation" id="modifyForm_evaluation" autocomplete="off" required></textarea>
                            <div class="invalid-feedback">กรุณากรอกการวัดผลประเมินผล</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_expectedResults" class="form-label">ผลที่คาดว่าจะได้รับ <span class="text-danger">*</span></label>
                            <textarea class="form-control summernote" name="expectedResults" id="modifyForm_expectedResults" autocomplete="off" required></textarea>
                            <div class="invalid-feedback">กรุณากรอกผลที่คาดว่าจะได้รับ</div>
                        </div>
                        <div class="mb-3">
                            <label for="modifyForm_contact" class="form-label">สอบถามเพิ่มเติม <span class="text-danger">*</span></label>
                            <textarea class="form-control summernote" name="contact" id="modifyForm_contact" autocomplete="off" required></textarea>
                            <div class="invalid-feedback">กรุณากรอกสอบถามเพิ่มเติม</div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="modifyForm_schedule" class="form-label">เปลี่ยนกำหนดการ</label>
                                <input type="file" class="form-control" id="modifyForm_schedule" name="schedule" aria-label="Upload" accept="<?= join(',', $fileSchedule['accept']); ?>">
                                <small class="text-muted">รองรับไฟล์ประเภท <?= join(', ', $fileSchedule['extension']); ?> : ขนาดไม่เกิน <?= number_to_size($fileSchedule['maxSize']); ?></small>
                                <div class="mt-3" preview="schedule"></div>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="modifyForm_image" class="form-label">เปลี่ยนรูปภาพ</label>
                                <input type="file" class="form-control" id="modifyForm_image" name="image" aria-label="Upload" accept="<?= join(',', $fileImage['accept']); ?>">
                                <small class="text-muted">รองรับไฟล์ประเภท <?= join(', ', $fileImage['extension']); ?> : ขนาดไม่เกิน <?= number_to_size($fileImage['maxSize']); ?></small>
                                <div class="mt-3" preview="image"></div>
                            </div>
                        </div>
                    </div>
                    <h5 class="fw-bolder mt-5 mb-3">การเข้าถึงเนื้อหา</h5>
                    <div class="rounded border p-4">
                        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-3 g-4">
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="display" id="modifyForm_displayPrivate" autocomplete="off" value="PRIVATE" checked>
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="modifyForm_displayPrivate">
                                    <i class="fa-solid fa-lock me-2"></i>ส่วนตัว<br>
                                    <span class="fs-sm">ซ่อนจากรายการ ไม่สามารถอ่านเนื้อหาได้</span>
                                </label>
                            </div>
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="display" id="modifyForm_displaySpecific" autocomplete="off" value="SPECIFIC">
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="modifyForm_displaySpecific">
                                    <i class="fa-solid fa-users me-2"></i>จำกัด<br>
                                    <span class="fs-sm">ซ่อนจากรายการ สามารถอ่านเนื้อหาได้</span>
                                </label>
                            </div>
                            <div class="d-grid col">
                                <input type="radio" class="btn-check" name="display" id="modifyForm_displayPublic" autocomplete="off" value="PUBLIC">
                                <label class="btn btn-outline-checkebox btn-lg py-3" for="modifyForm_displayPublic">
                                    <i class="fa-solid fa-earth-asia me-2"></i>สาธารณะ<br>
                                    <span class="fs-sm">แสดงรายการ สามารถอ่านเนื้อหาได้</span>
                                </label>
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

    <div class="modal fade" id="batchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="batchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="batchModalLabel">รอบหลักสูตร</h5>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-primary me-2" data-bs-target="#createBatchModal" data-bs-toggle="modal" data-bs-dismiss="modal">เพิ่มใหม่</button>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-light w-100" id="batchDT">
                        <thead>
                            <th>#</th>
                            <th>เปิดใช้งาน</th>
                            <th>เริ่มสมัคร</th>
                            <th>สิ้นสุดสมัคร</th>
                            <th>เริ่มอบรม</th>
                            <th>สิ้นสุดอบรม</th>
                            <th>สิ้นสุดชำระเงิน</th>
                            <th>จำกัดผู้เข้าร่วม</th>
                            <th>ผู้สมัคร</th>
                            <th width="100"></th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createBatchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createBatchModalLabel" aria-hidden="true">
        <form method="post" name="createBatchForm" class="modal-dialog modal-dialog-centered modal-dialog-scrollable needs-validation" novalidate>
            <input type="hidden" name="course">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createBatchModalLabel">เพิ่มใหม่</h5>
                    <button type="button" class="btn-close" data-bs-target="#batchModal" data-bs-toggle="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="createBatchForm_startClassroom" class="form-label">วันที่เริ่ม/สิ้นสุดการเรียน <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="date" class="form-control text-center" name="startClassroom" id="createBatchForm_startClassroom" autocomplete="off" required>
                            <span class="input-group-text">ถึง</span>
                            <input type="date" class="form-control text-center rounded-end" name="endClassroom" id="createBatchForm_endClassroom" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกวันที่เริ่ม/สิ้นสุดการเรียน</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="createBatchForm_startEnrollment" class="form-label">วันที่เริ่ม/สิ้นสุดลงทะเบียน <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="date" class="form-control text-center" name="startEnrollment" id="createBatchForm_startEnrollment" autocomplete="off" required>
                            <span class="input-group-text">ถึง</span>
                            <input type="date" class="form-control text-center rounded-end" name="endEnrollment" id="createBatchForm_endEnrollment" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกวันที่เริ่ม/สิ้นสุดลงทะเบียน</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="createBatchForm_endPayment" class="form-label">วันที่สิ้นสุดการชำระเงิน <span class="text-danger">*</span></label>
                        <input type="date" class="form-control text-center" name="endPayment" id="createBatchForm_endPayment" autocomplete="off" required>
                        <div class="invalid-feedback">กรุณากรอกวันที่สิ้นสุดการชำระเงิน</div>
                    </div>
                    <div class="mb-3">
                        <label for="createBatchForm_maxEnroll" class="form-label">จำนวนผู้เรียน (0 = ไม่จำกัด) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control text-center" name="maxEnroll" id="createBatchForm_maxEnroll" autocomplete="off" min="0" max="1000" step="1" value="0" required>
                        <div class="invalid-feedback">กรุณากรอกจำนวนผู้เรียน</div>
                    </div>
                    <div class="mb-3">
                        <label for="createBatchForm_minEnroll" class="form-label">จำนวนผู้สมัครขั้นต่ำ (%) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control text-center" name="minEnroll" id="createBatchForm_minEnroll" autocomplete="off" min="0" max="100" step="1" value="80" required>
                        <div class="invalid-feedback">กรุณากรอกจำนวนผู้สมัครขั้นต่ำ (%)</div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="isActive" id="createBatchForm_isActive" value="TRUE" checked>
                            <label class="form-check-label" for="createBatchForm_isActive">เปิดใช้งานรอบหลักสูตร</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-target="#batchModal" data-bs-toggle="modal" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">เพิ่มใหม่</button>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="modifyBatchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modifyBatchModalLabel" aria-hidden="true">
        <form method="post" name="modifyBatchForm" class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <input type="hidden" name="batchId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifyBatchModalLabel">แก้ไขข้อมูล</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="modifyBatchForm_startClassroom" class="form-label">วันที่เริ่ม/สิ้นสุดการเรียน <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="date" class="form-control text-center" name="startClassroom" id="modifyBatchForm_startClassroom" autocomplete="off" required>
                            <span class="input-group-text">ถึง</span>
                            <input type="date" class="form-control text-center rounded-end" name="endClassroom" id="modifyBatchForm_endClassroom" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกวันที่เริ่ม/สิ้นสุดการเรียน</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="modifyBatchForm_startEnrollment" class="form-label">วันที่เริ่ม/สิ้นสุดลงทะเบียน <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="date" class="form-control text-center" name="startEnrollment" id="modifyBatchForm_startEnrollment" autocomplete="off" required>
                            <span class="input-group-text">ถึง</span>
                            <input type="date" class="form-control text-center rounded-end" name="endEnrollment" id="modifyBatchForm_endEnrollment" autocomplete="off" required>
                            <div class="invalid-feedback">กรุณากรอกวันที่เริ่ม/สิ้นสุดลงทะเบียน</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="createBatchForm_endPayment" class="form-label">วันที่สิ้นสุดการชำระเงิน <span class="text-danger">*</span></label>
                        <input type="date" class="form-control text-center" name="endPayment" id="createBatchForm_endPayment" autocomplete="off" required>
                        <div class="invalid-feedback">กรุณากรอกวันที่สิ้นสุดการชำระเงิน</div>
                    </div>
                    <div class="mb-3">
                        <label for="modifyBatchForm_maxEnroll" class="form-label">จำนวนผู้เรียน (0 = ไม่จำกัด) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control text-center" name="maxEnroll" id="modifyBatchForm_maxEnroll" autocomplete="off" min="0" max="1000" step="1" value="0" required>
                        <div class="invalid-feedback">กรุณากรอกจำนวนผู้เรียน</div>
                    </div>
                    <div class="mb-3">
                        <label for="modifyBatchForm_minEnroll" class="form-label">จำนวนผู้สมัครขั้นต่ำ (%) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control text-center" name="minEnroll" id="modifyBatchForm_minEnroll" autocomplete="off" min="0" max="100" step="1" value="80" required>
                        <div class="invalid-feedback">กรุณากรอกจำนวนผู้สมัครขั้นต่ำ (%)</div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="isActive" id="modifyBatchForm_isActive" value="TRUE" checked>
                            <label class="form-check-label" for="modifyBatchForm_isActive">เปิดใช้งานรอบหลักสูตร</label>
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
                <h3 class="fw-bolder text-center">หลักสูตรอบรม</h3>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">เพิ่มใหม่</button>
            </div>
            <table class="table table-hover table-light w-100" id="coursesDT" style="min-width:1500px">
                <thead>
                    <th width="40">#</th>
                    <th>ชื่อหลักสูตร</th>
                    <th width="80">การเข้าถึง</th>
                    <th width="60">ชม.เรียน</th>
                    <th>หมวด</th>
                    <th>คณะ/สาขาวิชา</th>
                    <th width="60">ค่าสมัคร</th>
                    <th width="60">เข้าชม</th>
                    <th>ผู้สร้าง</th>
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
                    $('select[name="lecturers[]"]').select2({
                        theme: 'bootstrap-5',
                        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                        placeholder: $(this).data('placeholder'),
                        closeOnSelect: false,
                    });

                    $('textarea.summernote').summernote();
                    let coursesDT = $('#coursesDT').DataTable({
                        ajax: {
                            url: '<?= base_url(); ?>/api/get/course/dt',
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
                            targets: [0,3,6,7],
                            className: 'text-center'
                        }, {
                            targets: 1,
                            createdCell: (td, cellData, rowData, row, col) => {
                                $(td).html('<a href="<?= base_url(); ?>/course/'+rowData[10]+'" target="_blank">'+cellData+'</a>');
                                if (rowData[10]=='FALSE') $(td).append('<span class="badge bg-or-4 ms-2">Online</span>');
                            }
                        }, {
                            targets: 2,
                            className: 'text-center',
                            createdCell: (td, cellData, rowData, row, col) => {
                                let style = text = '';
                                switch (cellData) {
                                    case 'PRIVATE':
                                        style = 'bg-or-4';
                                        text = 'ส่วนตัว';
                                        break;
                                    case 'SPECIFIC':
                                        style = 'bg-or-3';
                                        text = 'จำกัด';
                                        break;
                                    case 'PUBLIC':
                                        style = 'bg-or-conts';
                                        text = 'สาธารณะ';
                                        break;
                                }
                                $(td).html('<span class="badge '+style+'">'+text+'</span>');
                            }
                        }, {
                            targets: 9,
                            searchable: false,
                            orderable: false,
                            createdCell: (td, cellData, rowData, row, col) => {
                                $(td).append('<button class="btn btn-light btn-sm handler-batch" data-id="'+rowData[10]+'" title="รอบหลักสูตร"><i class="fa-regular fa-clock"></i></button>');
                                $(td).append('<button class="btn btn-light btn-sm handler-mod" data-id="'+rowData[10]+'" title="แก้ไข"><i class="fa-solid fa-pen-to-square"></i></button>');
                                $(td).append('<button class="btn btn-light orange-theme-2 btn-sm handler-del" data-id="'+rowData[10]+'" title="ลบ"><i class="fa-solid fa-trash"></i></button>');
                            }
                        }]
                    });

                    $('input[name="schedule"]').on('change', e => {
                        const c = $(e.currentTarget);
                        let oversize = false;
                        $.each(c[0].files, function(i, d) {
                            if (d.size > parseInt('<?= $fileSchedule['maxSize']; ?>')) {
                                oversize = true;
                                return false;
                            }
                        });
                        if (oversize) {
                            Swal.fire({
                                title: 'แจ้งเตือน',
                                html: 'ไฟล์มีขนาดเกินกว่า <?= number_to_size($fileSchedule['maxSize']); ?>',
                                icon: 'warning'
                            }).then(() => c.val(null));
                        }
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
                            url: '<?= base_url(); ?>/api/create/course',
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
                                    }).then(() => coursesDT.ajax.reload(null, false));
                                    $('select[name="lecturers[]"]', f).val(null).trigger('change');
                                    $('textarea.summernote', f).each((i, e) => $(e).summernote('reset'));
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
                            url: '<?= base_url(); ?>/api/get/course/'+id,
                            type: 'GET',
                            dataType: 'json',
                            success: r => {
                                if (r.success) {
                                    const previewSchedule = $('[preview="schedule"]');
                                    const previewImage = $('[preview="image"]');
                                    const data = r.data;
                                    const f = $('form[name="modifyForm"]');
                                    previewSchedule.html('');
                                    previewImage.html('');
                                    $('textarea.summernote', f).each((i, e) => $(e).summernote('destroy'));
                                    $('input[name="courseId"]', f).val(data.course_id);
                                    $('select[name="courseCategory"]', f).val(data.course_category_id);
                                    $('select[name="branch"]', f).val(data.branch_id);
                                    $('input[name="title"]', f).val(data.title);
                                    $('input[name="regisFee"]', f).val(data.regis_fee);
                                    if (data.is_onsite=='TRUE') {
                                        $('input[name="locatType"][value="ONSITE"]', f).prop('checked', true);
                                        $('#modifyForm_locatOnSiteContainer').show();
                                        $('#modifyForm_locatOnlineContainer').hide();
                                    } else {
                                        $('input[name="locatType"][value="ONLINE"]', f).prop('checked', true);
                                        $('#modifyForm_locatOnSiteContainer').hide();
                                        $('#modifyForm_locatOnlineContainer').show();
                                    }
                                    $('input[name="onlineUrl"]', f).val(data.online_url);
                                    $('input[name="onlineRequirement"]', f).val(data.online_requirement);
                                    $('input[name="location"]', f).val(data.location);
                                    $('input[name="classHours"]', f).val(data.class_hours);
                                    $('select[name="lecturers[]"]', f).val(data.lecturers.map(i => i['lecturer_id'])).trigger('change');
                                    $('textarea[name="objective"]', f).val(data.objective);
                                    $('textarea[name="target"]', f).val(data.target);
                                    $('textarea[name="content"]', f).val(data.content);
                                    $('textarea[name="evaluation"]', f).val(data.evaluation);
                                    $('textarea[name="expectedResults"]', f).val(data.expected_results);
                                    $('textarea[name="contact"]', f).val(data.contact);
                                    $('textarea.summernote', f).summernote();
                                    $('input[name="display"][value="'+data.display+'"]', f).prop('checked', true);
                                    if (data.schedule != '')
                                        previewSchedule.append($('<a></a>').attr({href: '<?= base_url(); ?>/'+data.schedule, target: '_blank'}).text('ดาวน์โหลดกำหนดการ'));
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
                            url: '<?= base_url(); ?>/api/modify/course',
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
                                    }).then(() => coursesDT.ajax.reload(null, false));
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
                            text: 'คุณมั่นใจที่จะลบหลักสูตรอบรมดังกล่าวหรือไม่ ?',
                            icon: 'question',
                            showCancelButton: true
                        }).then(res => {
                            if (res.isConfirmed) {
                                $.ajax({
                                    url: '<?= base_url(); ?>/api/delete/course/'+id,
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
                                            }).then(() => coursesDT.ajax.reload(null, false));
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

                    let batchDT = $('#batchDT').DataTable({
                        ajax: {
                            url: '<?= base_url(); ?>/api/get/course/batch/dt/0',
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
                            targets: [0,2,3,4,5,6,7,8],
                            className: 'text-center'
                        }, {
                            targets: 1,
                            className: 'text-center',
                            createdCell: (td, cellData, rowData, row, col) => {
                                $(td).html('<span class="badge bg-'+(cellData=='TRUE' ? 'or-conts' : 'or-4')+' ms-2">'+(cellData=='TRUE' ? 'เปิดใช้งาน' : 'ปิดใช้งาน')+'</span>');
                            }
                        }, {
                            targets: 9,
                            searchable: false,
                            orderable: false,
                            createdCell: (td, cellData, rowData, row, col) => {
                                $(td).append('<a href="<?= base_url(); ?>/manage/courses/enroll/'+rowData[10]+'" target="_blank" class="btn btn-light btn-sm" title="ผู้สมัคร"><i class="fa-solid fa-user-group"></i></a>');
                                $(td).append('<button class="btn btn-light btn-sm handler-batch-mod" data-id="'+rowData[10]+'" title="แก้ไข"><i class="fa-solid fa-pen-to-square"></i></button>');
                                $(td).append('<button class="btn btn-light orange-theme-2 btn-sm handler-batch-del" data-id="'+rowData[10]+'" title="ลบ"><i class="fa-solid fa-trash"></i></button>');
                            }
                        }]
                    });
                    const batchModal = new bootstrap.Modal(document.getElementById('batchModal'));
                    $('#batchModal').on('shown.bs.modal', e => batchDT.columns.adjust());
                    $(d).on('click', 'button.handler-batch', e => {
                        e.preventDefault();
                        const id = $(e.currentTarget).data('id');
                        $('form[name="createBatchForm"] input[name="course"]').val(id);
                        batchDT.ajax.url('<?= base_url(); ?>/api/get/course/batch/dt/'+id).load();
                        batchModal.show();
                    });

                    const createBatchModal = new bootstrap.Modal(document.getElementById('createBatchModal'));
                    $(d).on('submit', 'form[name="createBatchForm"]', e => {
                        e.preventDefault();
                        const f = $(e.currentTarget);
                        $.ajax({
                            url: '<?= base_url(); ?>/api/create/course/batch',
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
                                        batchDT.ajax.reload(null, false);
                                        batchModal.show();
                                    });
                                    f[0].reset();
                                    createBatchModal.hide();
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

                    const modifyBatchModal = new bootstrap.Modal(document.getElementById('modifyBatchModal'));
                    $(d).on('click', 'button.handler-batch-mod', e => {
                        e.preventDefault();
                        const id = $(e.currentTarget).data('id');
                        $.ajax({
                            url: '<?= base_url(); ?>/api/get/course/batch/'+id,
                            type: 'GET',
                            dataType: 'json',
                            success: r => {
                                if (r.success) {
                                    const data = r.data;
                                    const f = $('form[name="modifyBatchForm"]');
                                    $('input[name="batchId"]', f).val(data.course_batch_id);
                                    $('input[name="startClassroom"]', f).val(data.start_classroom);
                                    $('input[name="endClassroom"]', f).val(data.end_classroom);
                                    $('input[name="startEnrollment"]', f).val(data.start_enrollment);
                                    $('input[name="endEnrollment"]', f).val(data.end_enrollment);
                                    $('input[name="endPayment"]', f).val(data.end_payment);
                                    $('input[name="maxEnroll"]', f).val(data.max_enroll);
                                    $('input[name="minEnroll"]', f).val(data.min_enroll);
                                    $('input[name="isActive"]', f).prop('checked', data.is_active == 'TRUE');
                                    modifyBatchModal.show();
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

                    $(d).on('submit', 'form[name="modifyBatchForm"]', e => {
                        e.preventDefault();
                        const f = $(e.currentTarget);
                        $.ajax({
                            url: '<?= base_url(); ?>/api/modify/course/batch',
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
                                    }).then(() => batchDT.ajax.reload(null, false));
                                    modifyBatchModal.hide();
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

                    $(d).on('click', 'button.handler-batch-del', e => {
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
                                    url: '<?= base_url(); ?>/api/delete/course/batch/'+id,
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
                                            }).then(() => batchDT.ajax.reload(null, false));
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

                    $('input[name="startClassroom"]').on('keypress change', e => {
                        const c = $(e.currentTarget);
                        const stClassr = c.val();
                        const f = c.parents('form');
                        if (stClassr!='') {
                            let dStClassr = new Date(stClassr);
                            dStClassr.setDate(dStClassr.getDate()-14);
                            $('input[name="endEnrollment"]', f).val(dStClassr.getFullYear()+'-'+String(dStClassr.getMonth()+1).padStart(2, '0')+'-'+String(dStClassr.getDate()).padStart(2, '0'));
                        }
                    });
                });
            </script>
        </div>
    </div>
</section>