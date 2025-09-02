<header class="bg-or-5 py-1 bg-header-img">
    <div class="container-fluid px-4 px-lg-5 my-5">
        <div class="text-center orange-theme-4">
            <h1 class="display-4 fw-bolder">หลักสูตรระยะสั้น</h1>
            <p class="lead fw-normal text-50 mb-0">คณะวิทยาศาสตร์และเทคโนโลยี มหาวิทยาลัยราชภัฏนครปฐม</p>
        </div>
    </div>
</header>
<section class="py-2">
    <div class="container-fluid px-4 px-lg-5 mt-5">
        <div class="row row-cols-1 row-cols-md-3 row-cols-xl-4 justify-content-center g-4 mb-4">
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
</section>