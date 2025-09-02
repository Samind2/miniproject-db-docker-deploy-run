<div class="bg-white border-top">
    <div class="container-fluid px-4 px-lg-5">
        <nav class="py-2" aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">หน้าแรก</a></li>
                <li class="breadcrumb-item active text-truncate" aria-current="page">หลักสูตรอบรม</li>
            </ol>
        </nav>
    </div>
</div>

<section>
    <div class="container-fluid px-4 px-lg-5 pt-4">
        <div class="row">
            <div class="col-lg-9">
                <form method="get" name="filterForm" class="row">
                    <div class="col-lg-5 col-12 mb-4">
                        <div class="input-group input-group-border-less shadow">
                            <input type="search" class="form-control" name="k" placeholder="ค้นหาหลักสูตร" value="<?= $fKeyword; ?>">
                            <button type="submit" class="btn btn-white-search i-translate-y--2"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12 mb-4">
                        <div class="input-group input-group-border-less shadow">
                            <select class="form-select" name="m">
                                <option value="0" selected>-- เลือกเดือน --</option>
                                <?php foreach($dateExtension::$month_long_tha as $i => $month): ?>
                                    <option value="<?= ($i + 1); ?>"<?php if($fMonth==($i+1)) echo ' selected'; ?>><?= $month; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 mb-4 d-flex align-items-center">
                        <small class="text-muted">หลักสูตร <?= number_format($courseCount, 0); ?> รายการ</small>
                    </div>
                    <input type="hidden" name="c" value="<?= join(',', $fCategory); ?>">
                </form>
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4 mb-4">
                    <?php foreach($courseList as $course): ?>
                        <div class="col">
                            <div class="card p-3 h-100">
                                <img class="card-img" src="<?= base_url().'/'.$course['image']; ?>" alt="<?= $course['title']; ?>" />
                                <div class="card-body px-0">
                                    <div class="text-left">
                                        <h5 class="fw-bolder course-name"><?= $course['title']; ?></h5>
                                        <div class="mb-2">
                                            <span class="badge bg-or-2"><?= $course['course_category_title']; ?></span>
                                            <?php if($course['is_onsite']=='FALSE') echo '<span class="badge bg-or-4">Online</span>'; ?>
                                        </div>
                                        <div class="course-note d-flex align-items-baseline"><i class="far fa-calendar-alt me-3"></i><?= $dateExtension::thai_range_format('d M y', $course['course_batch_start_classroom'], $course['course_batch_end_classroom']); ?></div>
                                        <?php if($course['is_onsite']=='TRUE'): ?>
                                            <div class="course-note d-flex align-items-baseline"><i class="fas fa-map-marker-alt me-3"></i><?= $course['location']; ?></div>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="card-footer bg-white px-0 pb-0">
                                    <strong class=""><?= number_format($course['regis_fee'], 0); ?> THB</strong>
                                </div>
                                <a href="<?= base_url();?>/course/<?= $course['course_id']; ?>" class="stretched-link"></a>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
                <?= $coursePaging; ?>
            </div>

            <div class="col-lg-3 d-none d-lg-block">
                <div class="bg-white rounded shadow p-4 sticky-top">
                    <h4 class="fw-bold">หมวดหมู่</h4>
                    <?php foreach($courseCategoryList as $i => $courseCategory): ?>
                        <div class="form-check form-check-lg form-check-inline">
                            <input class="form-check-input" type="checkbox" id="categoryItem<?= $i; ?>" name="category[]" value="<?= $courseCategory['course_category_id']; ?>"<?php if(in_array($courseCategory['course_category_id'], $fCategory)) echo ' checked'; ?>>
                            <label class="form-check-label" for="categoryItem<?= $i; ?>"><?= $courseCategory['title']; ?></label>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(d => {
            $('select[name="m"]').on('change', e => $('form[name="filterForm"]').submit());
            $('input[name="category[]"]').on('change', e => {
                selected = [];
                $('input[name="category[]"]:checked').each((i, el) => selected.push($(el).val()));
                location.href = '<?= base_url() ?>/course?c='+selected.join(',');
            });
        });
    </script>
</section>