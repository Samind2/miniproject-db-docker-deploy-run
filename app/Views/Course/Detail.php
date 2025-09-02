<div class="bg-white border-top">
  <div class="container-fluid px-4 px-lg-5">
    <nav class="py-2" aria-label="breadcrumb">
      <ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>">หน้าแรก</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url() ?>/course">หลักสูตรอบรม</a></li>
        <li class="breadcrumb-item active text-truncate" aria-current="page"><?= $course['title']; ?></li>
      </ol>
    </nav>
  </div>
</div>

<section class="course-cover">
  <div class="course-cover-bg">
    <div class="course-cover-bg-blur" style="background-image:url('<?= base_url().'/'.$course['image']; ?>')"></div>
  </div>
  <div class="course-cover-content">
    <div class="container pt-4">
      <div class="row">
        <div class="col-lg-12">
          <div class="d-flex flex-lg-row flex-column">
            <img class="course-cover-poster rounded shadow m-auto" src="<?= base_url().'/'.$course['image']; ?>" alt="<?= $course['title']; ?>" data-bs-toggle="modal" data-bs-target="#posterModal" />
            <div class="course-cover-info pt-5 pb-lg-0 pb-5 px-lg-5 px-2">
              <h1 class="text-light fw-bold"><?= $course['title']; ?></h1>
              <p class="course-cover-text fs-5 d-flex align-items-baseline">
                <?php if($course['is_onsite']=='TRUE'): ?>
                  <i class="fa-solid fa-location-dot"></i><?= $course['location']; ?>
                <?php else: ?>
                  <i class="fa-solid fa-desktop"></i>หลักสูตรอบรมออนไลน์
                <?php endif ?>
              </p>
              <p class="course-cover-text fs-5 d-flex align-items-baseline">
                <i class="far fa-clock"></i>หลักสูตรอบรม <strong class="mx-2"><?= number_format($course['class_hours'], 0); ?></strong> ชั่วโมง
              </p>
              <p class="course-cover-text fs-5 d-flex align-items-baseline">
                <i class="fa-solid fa-ticket"></i><strong class="me-2"><?= number_format($course['regis_fee'], 0); ?></strong>บาท / ท่าน
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="posterModal" tabindex="-1" aria-labelledby="posterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <button type="button" class="btn-close position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
        <img class="img-fluid rounded" src="<?= base_url().'/'.$course['image']; ?>" alt="<?= $course['title']; ?>" />
      </div>
    </div>
  </div>
</section>

<div class="course-share d-flex flex-column">
  <?php if(session()->get('LOGGED_IN')): ?>
    <button class="btn btn-primary btn-circle-lg i-rotate--25"<?= $openEnroll ? 'data-bs-toggle="modal" data-bs-target="#enrollModal"' : ' disabled'; ?> title="ลงทะเบียน"><i class="fa-solid fa-ticket"></i></button>
  <?php else: ?>
    <a href="<?= base_url(); ?>/signin?callback=<?= base64_encode($course['course_id']); ?>" class="btn btn-primary btn-circle-lg i-rotate--25" title="ลงทะเบียน"><i class="fa-solid fa-ticket"></i></a>
  <?php endif ?>
  <div class="btn-group dropstart" role="group">
    <button class="btn btn-light btn-circle-lg i-translate-y--2 mt-2 dropdown-toggle dropdown-toggle-split arrow-none" data-bs-toggle="dropdown" aria-expanded="false" title="แชร์"><i class="fa-solid fa-share"></i></button>
    <ul class="dropdown-menu border-0 shadow">
      <li>
        <a class="dropdown-item" href="#" data-url="<?= base_url().'/course/'.$course['course_id']; ?>" onclick="linkToClipboard(event)"><i class="fa-solid fa-link me-3"></i>คัดลอกลิงก์</a>
      </li>
      <li data-href="<?= base_url().'/course/'.$course['course_id']; ?>">
        <a class="dropdown-item" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= base_url().'/course/'.$course['course_id']; ?>&src=sdkpreparse"><i class="fa-brands fa-facebook me-3 app-fb"></i>Facebook</a>
      </li>
      <li>
        <a class="dropdown-item" target="_blank" href="https://wa.me/?text=<?= base_url().'/course/'.$course['course_id']; ?>"><i class="fa-brands fa-whatsapp me-3 app-whatsapp"></i>WhatsApp</a>
      </li>
      <li>
        <a class="dropdown-item" target="_blank" href="https://twitter.com/intent/tweet?text=<?= base_url().'/course/'.$course['course_id']; ?>"><i class="fa-brands fa-twitter me-3 app-twitter"></i>Twitter</a>
      </li>
      <li>
        <a class="dropdown-item" target="_blank" href="https://social-plugins.line.me/lineit/share?url=<?= base_url().'/course/'.$course['course_id']; ?>"><i class="fa-brands fa-line me-3 app-line"></i>Line</a>
      </li>
    </ul>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v16.0" nonce="oWSipGtZ"></script>
    <script>
      function linkToClipboard(e) {
        e.preventDefault();
        navigator.clipboard.writeText(e.currentTarget.getAttribute('data-url'));
        Swal.fire({
          title: 'คัดลอกเรียบร้อยแล้ว',
          text: 'คัดลอกลิงก์สู่คลิปบอร์ดบนเครื่องของคุณ',
          icon: 'success',
          timerProgressBar: true,
          timer: 1500
        });
      }
    </script>
  </div>
  <a href="#" class="btn btn-light btn-circle-lg i-translate-y--2 mt-2" title="ขึ้นด้านบน" target="_top"><i class="fa-solid fa-arrow-up"></i></a>
</div>

<div class="container" data-bs-spy="scroll" data-bs-target="#list-example">
  <div class="row">
    <div class="col-lg-8">
      <article>

        <section class="mb-5 course-body">
          <h5 class="fw-bolder mb-4 mt-5" id="section1"><i class="far fa-calendar-alt"></i> วันรับสมัคร</h5>
          <div class="mb-4">
            <div class="bg-white rounded shadow">
              <table class="table">
                <thead>
                  <tr>
                    <th class="text-center" width="50">#</th>
                    <th class="text-center">ช่วงวันรับสมัคร</th>
                    <th class="text-center">ช่วงเวลาเรียน</th>
                    <th class="text-center" width="150">เปิดรับสมัคร (ท่าน)</th>
                    <th class="text-center" width="80">รายชื่อ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $now = date('Y-m-d', strtotime(date('Y-m-d')));
                  if(count($courseBatchList) > 0):
                    foreach($courseBatchList as $i => $courseBatch):
                      $enrollStart = date('Y-m-d', strtotime($courseBatch['start_enrollment']));
                      $enrollEnd = date('Y-m-d', strtotime($courseBatch['end_enrollment']));
                      $openEnroll = (($now >= $enrollStart && $now < $enrollEnd) && $courseBatch['enrolled_count'] < $courseBatch['max_enroll']);
                      $showList = ($now > $enrollEnd && $courseBatch['enrolled_count'] >= round(($courseBatch['max_enroll'] / 100) * $courseBatch['min_enroll']));
                      ?>
                      <tr class="<?= $openEnroll ? 'fw-bold' : 'text-black-50'; ?>">
                        <td class="text-center"><?= ($i + 1) ?></td>
                        <td class="text-center">
                          <?= $dateExtension::thai_range_format('d M Y', $courseBatch['start_enrollment'], $courseBatch['end_enrollment']); ?><br>
                          <span class="fs-sm">(ก่อนวันที่เริ่มเรียน <?= $dateExtension::date_between($courseBatch['end_enrollment'], $courseBatch['start_classroom']); ?> วัน)</span>
                        </td>
                        <td class="text-center">
                          <?= $dateExtension::thai_range_format('d M Y', $courseBatch['start_classroom'], $courseBatch['end_classroom']); ?><br>
                          <span class="fs-sm">(<?= number_format($dateExtension::date_between($courseBatch['start_classroom'], $courseBatch['end_classroom'], true), 0); ?> วัน)</span>
                        </td>
                        <td class="text-center"><?= number_format($courseBatch['enrolled_count'], 0).' / '.number_format($courseBatch['max_enroll'], 0); ?></td>
                        <td class="text-center">
                          <?php if($showList): ?>
                            <button class="btn btn-light btn-sm handler-show-joined" data-id="<?= $courseBatch['course_batch_id']; ?>" title="รายชื่อผู้เข้าอบรม"><i class="fa-solid fa-user-group"></i></button>
                          <?php endif ?>
                        </td>
                      </tr>
                    <?php endforeach;
                    else: ?>
                      <tr>
                        <td class="text-center" colspan="4">-- ไม่พบรอบสมัครหลักสูตร --</td>
                      </tr>
                    <?php endif ?>
                </tbody>
              </table>
            </div>
          </div>

          <h5 class="fw-bolder mb-4 mt-5" id="section2"><i class="far fa-clock"></i> ระยะเวลาของหลักสูตร</h5>
          <p class="fs-6 mb-4 course-content">หลักสูตรอบรม <?= number_format($course['class_hours'], 0); ?> ชั่วโมง</p>

          <?php if($course['is_onsite']=='TRUE'): ?>
            <h5 class="fw-bolder mb-4 mt-5" id="section3"><i class="fas fa-map-marker-alt"></i> สถานที่</h5>
            <p class="fs-6 mb-4 course-content"><?= $course['location']; ?></p>
          <?php else: ?>
            <h5 class="fw-bolder mb-4 mt-5" id="section4"><i class="fa-solid fa-desktop"></i> ห้องเรียนออนไลน์</h5>
            <p class="fs-6 mb-4 course-content">
              <?php if($course['online_url']!='' && $showLink): ?>
                <strong>ลิงก์เข้าเรียน:</strong> <a href="<?= $course['online_url']; ?>" target="_blank"><?= $course['online_url']; ?></a>
              <?php endif;
              if($course['online_requirement']!='') echo '<br><br>'.$course['online_requirement']; ?>
            </p>
          <?php endif ?>

          <h5 class="fw-bolder mb-4 mt-5" id="section5"><i class="fas fa-bullseye"></i> วัตถุประสงค์</h5>
          <p class="fs-6 mb-4 course-content"><?= $course['objective']; ?></p>

          <h5 class="fw-bolder mb-4 mt-5" id="section6"><i class="far fa-user"></i> กลุ่มเป้าหมาย</h5>
          <p class="fs-6 mb-4 course-content"><?= $course['target']; ?></p>

          <h5 class="fw-bolder mb-4 mt-5" id="section7"><i class="fas fa-chalkboard"></i> ขอบข่ายเนื้อหา</h5>
          <p class="fs-6 mb-4 course-content"><?= $course['content']; ?></p>

          <h5 class="fw-bolder mb-4 mt-5" id="section8"><i class="fas fa-file-alt"></i> การวัดผลประเมินผล</h5>
          <p class="fs-6 mb-4 course-content"><?= $course['evaluation']; ?></p>

          <h5 class="fw-bolder mb-4 mt-5" id="section9"><i class="fas fa-award"></i> ผลที่คาดว่าจะได้รับ</h5>
          <p class="fs-6 mb-4 course-content"><?= $course['expected_results']; ?></p>

          <h5 class="fw-bolder mb-4 mt-5" id="section10"><i class="fas fa-clipboard-list"></i> กำหนดการ</h5>
          <ul class=" course-content fs-6 contact-course">
            <li><a href="<?= base_url().'/'.$course['schedule']; ?>" target="_blank" class="orange-theme-2">ดาวน์โหลด PDF</a> </li>
          </ul>

          <h5 class="fw-bolder mb-4 mt-5" id="section11"><i class="fa-solid fa-user-tie"></i> วิทยากร</h5>
          <p class="fs-6 mb-4 course-content">
            <?php foreach($courseLecturerList as $courseLecturer): ?>
              <div class="d-flex align-items-center mb-2">
                <img src="<?= base_url().'/'.$courseLecturer['image']; ?>" class="border rounded-circle" width="50" height="50" />
                <span class="ms-3">
                  <?php echo $courseLecturer['fullname'];
                  if($courseLecturer['url']!==''): ?>
                    <a href="<?= $courseLecturer['url']; ?>" class="ms-2" target="_blank" title="ข้อมูลวิทยากร"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                  <?php endif ?>
                </span>
              </div>
            <?php endforeach ?>
          </p>

          <h5 class="fw-bolder mb-4 mt-5" id="section12"><i class="far fa-comments"></i> สอบถามเพิ่มเติม</h5>
          <p class="fs-6 mb-4 course-content"><?= $course['contact']; ?></p>
        </div>
      </section>
    </article>

    <!-- Side widgets-->
    <div class="col-lg-4 d-none d-lg-block border-start">
      <div id="list-example " class="list-group sticky-top mt-3">
        <div class="card-header bg-or-4"><a class=" list-group-item-action text-light" href="#"></a></div>
        <a class="list-group-item list-group-item-action" href="#section1"><i class="far fa-calendar-alt"></i> วันรับสมัคร</a>
        <a class="list-group-item list-group-item-action" href="#section2"><i class="far fa-clock"></i> ระยะเวลาของหลักสูตร</a>
        <?php if($course['is_onsite']=='TRUE'): ?>
          <a class="list-group-item list-group-item-action" href="#section3"><i class="fas fa-map-marker-alt"></i> สถานที่</a>
        <?php else: ?>
          <a class="list-group-item list-group-item-action" href="#section4"><i class="fa-solid fa-desktop"></i> ห้องเรียนออนไลน์</a>
        <?php endif ?>
        <a class="list-group-item list-group-item-action" href="#section5"><i class="fas fa-bullseye"></i> วัตถุประสงค์</a>
        <a class="list-group-item list-group-item-action" href="#section6"><i class="far fa-user"></i> กลุ่มเป้าหมาย</a>
        <a class="list-group-item list-group-item-action" href="#section7"><i class="fas fa-chalkboard"></i> ขอบข่ายเนื้อหา</a>
        <a class="list-group-item list-group-item-action" href="#section8"><i class="fas fa-file-alt"></i> การวัดผลประเมินผล</a>
        <a class="list-group-item list-group-item-action" href="#section9"><i class="fas fa-award"></i> ผลที่คาดว่าจะได้รับ</a>
        <a class="list-group-item list-group-item-action" href="#section10"><i class="fas fa-clipboard-list"></i> กำหนดการ</a>
        <a class="list-group-item list-group-item-action" href="#section11"><i class="fa-solid fa-user-tie"></i> วิทยากร</a>

        <div class="my-3 card-rela">
          <?php if(session()->get('LOGGED_IN')): ?>
            <button class="btn bg-or-conts"<?= $openEnroll ? 'data-bs-toggle="modal" data-bs-target="#enrollModal"' : ' disabled'; ?>>ลงทะเบียน</button>
          <?php else: ?>
            <a href="<?= base_url(); ?>/signin?callback=<?= base64_encode($course['course_id']); ?>" class="btn bg-or-conts">ลงทะเบียน</a>
          <?php endif ?>
          <a href="#section12" class="btn bg-or-5 text-light">สอบถามเพิ่มเติม</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="joinedModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="joinedModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="joinedModalLabel">รายชื่อผู้เข้าอบรม</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-hover table-light w-100" id="joinedDT">
          <thead>
            <th width="80">#</th>
            <th>ชื่อผู้เข้าร่วม</th>
            <th width="120">สถานะ</th>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <script>
    $(d => {
      let joinedDT = $('#joinedDT').DataTable({
        ajax: {
          url: '<?= base_url(); ?>/api/get/enroll/joined/dt/0',
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
        columnDefs: [{
          targets: 0,
          className: 'text-center'
        }]
      });
      const joinedModal = new bootstrap.Modal(document.getElementById('joinedModal'));
      $('#joinedModal').on('shown.bs.modal', e => joinedDT.columns.adjust());
      $(d).on('click', 'button.handler-show-joined', e => {
        e.preventDefault();
        const id = $(e.currentTarget).data('id');
        joinedDT.ajax.url('<?= base_url(); ?>/api/get/enroll/joined/dt/'+id).load();
        joinedModal.show();
      });
    });
  </script>
</div>

<?php if(session()->get('LOGGED_IN') && $openEnroll): ?>
  <div class="modal fade" id="enrollModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="enrollModalLabel" aria-hidden="true">
    <form method="post" name="enrollForm" action="<?= base_url(); ?>/course/enroll" class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl needs-validation" novalidate>
      <input type="hidden" name="cid" value="<?= $course['course_id']; ?>">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel">ลงทะเบียนเข้าอบรม</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="p-4">
            <div class="d-flex flex-lg-row flex-column">
              <img class="rounded shadow m-auto" src="<?= base_url().'/'.$course['image']; ?>" alt="<?= $course['title']; ?>" width="250" />
              <div class="mt-lg-0 mt-4 px-lg-5 px-2">
                <h1 class="fw-bold"><?= $course['title']; ?></h1>
                <p class="course-cover-text fs-5 d-flex align-items-baseline">
                  <?php if($course['is_onsite']=='TRUE'): ?>
                    <i class="fa-solid fa-location-dot"></i><?= $course['location']; ?>
                  <?php else: ?>
                    <i class="fa-solid fa-desktop"></i>หลักสูตรอบรมออนไลน์
                  <?php endif ?>
                </p>
                <p class="course-cover-text fs-5 d-flex align-items-baseline">
                  <i class="far fa-clock"></i>หลักสูตรอบรม <strong class="mx-2"><?= number_format($course['class_hours'], 0); ?></strong> ชั่วโมง
                </p>
                <p class="course-cover-text fs-5 d-flex align-items-baseline">
                  <i class="fa-solid fa-ticket"></i><strong class="me-2"><?= number_format($course['regis_fee'], 0); ?></strong>บาท / ท่าน
                </p>
              </div>
            </div>
          </div>
          <h5 class="fw-bolder mt-5 mb-3">เลือกรอบอบรม</h5>
          <div class="rounded border p-4">
            <table class="table table-hover m-0">
              <thead>
                <tr>
                  <th class="text-center" width="80">เลือก</th>
                  <th class="text-center" width="50">#</th>
                  <th class="text-center">ช่วงเวลาเรียน</th>
                  <th class="text-center" width="180">เปิดรับสมัคร (ท่าน)</th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($courseBatchList) > 0):
                  $r = 0;
                  foreach($courseBatchList as $i => $courseBatch):
                    $enrollStart = date('Y-m-d', strtotime($courseBatch['start_enrollment']));
                    $enrollEnd = date('Y-m-d', strtotime($courseBatch['end_enrollment']));
                    $openEnroll = (($now >= $enrollStart && $now < $enrollEnd) && $courseBatch['enrolled_count'] < $courseBatch['max_enroll']);
                    ?>
                    <tr class="<?= $openEnroll ? 'fw-bold' : 'text-black-50'; ?>">
                      <td class="text-center">
                        <?php if($courseBatch['enrolled_count'] >= $courseBatch['max_enroll']): ?>
                          <span class="badge bg-or-2">เต็ม</span>
                        <?php else:
                          if($openEnroll) $r++; ?>
                          <div class="form-check d-flex justify-content-center">
                            <input class="form-check-input" type="radio" name="batch" id="batch" value="<?= $courseBatch['course_batch_id']; ?>"<?php if($r==1 && $openEnroll) echo ' checked'; ?><?php if(!$openEnroll) echo ' disabled'; ?>>
                            <label class="form-check-label" for="batch"></label>
                          </div>
                        <?php endif ?>
                      </td>
                      <td class="text-center"><?= ($i + 1) ?></td>
                      <td class="text-center">
                        <?= $dateExtension::thai_range_format('d M Y', $courseBatch['start_classroom'], $courseBatch['end_classroom']); ?>
                        <span class="fs-sm">(<?= number_format($dateExtension::date_between($courseBatch['start_classroom'], $courseBatch['end_classroom'], true), 0); ?> วัน)</span>
                      </td>
                      <td class="text-center"><?= number_format($courseBatch['enrolled_count'], 0).' / '.number_format($courseBatch['max_enroll'], 0); ?></td>
                    </tr>
                  <?php endforeach;
                  else: ?>
                    <tr>
                      <td class="text-center" colspan="4">-- ไม่พบรอบสมัครหลักสูตร --</td>
                    </tr>
                  <?php endif ?>
              </tbody>
            </table>
          </div>
          <h5 class="fw-bolder mt-5 mb-3">ข้อมูลผู้สมัครอบรม</h5>
          <div class="rounded border p-4">
            <div class="mb-3">
              <label for="fullnameTha" class="form-label">ชื่อ-นามสกุล ภาษาไทย</label>
              <input type="text" class="form-control" name="fullnameTha" id="fullnameTha" autocomplete="off" value="<?= $UserLogged['name_title_tha'].$UserLogged['fullname_tha']; ?>" required readonly>
            </div>
            <div class="mb-3">
              <label for="fullnameEng" class="form-label">ชื่อ-นามสกุล ภาษาอังกฤษ</label>
              <input type="text" class="form-control" name="fullnameEng" id="fullnameEng" autocomplete="off" value="<?= $UserLogged['name_title_eng'].$UserLogged['fullname_eng']; ?>" required readonly>
            </div>
            <div class="row">
              <div class="col-lg-3 mb-3">
                <label for="birthDate" class="form-label">วันเกิด <span class="text-danger">*</span></label>
                <select class="form-select text-center" name="birthDate" id="birthDate" required disabled>
                  <?php
                  $cBirth = date_create($UserLogged['birth']);
                  for($d=1; $d<=31; $d++): ?>
                    <option value="<?= $d; ?>"<?php if(date_format($cBirth, 'd')==$d) echo ' selected'; ?>><?= $d; ?></option>
                  <?php endfor ?>
                </select>
                <div class="invalid-feedback">กรุณาเลือกวันเกิด</div>
              </div>
              <div class="col-lg-6 mb-3">
                <label for="birthMonth" class="form-label">เดือน <span class="text-danger">*</span></label>
                <select class="form-select text-center" name="birthMonth" id="birthMonth" required disabled>
                  <?php foreach($dateExtension::$month_long_tha as $i => $month): ?>
                    <option value="<?= ($i+1); ?>"<?php if(date_format($cBirth, 'm')==($i+1)) echo ' selected'; ?>><?= $month; ?></option>
                  <?php endforeach ?>
                </select>
                <div class="invalid-feedback">กรุณาเลือกเดือนเกิด</div>
              </div>
              <div class="col-lg-3 mb-3">
                <label for="birthYear" class="form-label">ปี (พ.ศ.) <span class="text-danger">*</span></label>
                <select class="form-select text-center" name="birthYear" id="birthYear" required disabled>
                  <?php for($y=date('Y')-15; $y>=1950; $y--): ?>
                    <option value="<?= $y; ?>"<?php if(date_format($cBirth, 'Y')==$y) echo ' selected'; ?>><?= ($y+543); ?></option>
                  <?php endfor ?>
                </select>
                <div class="invalid-feedback">กรุณาเลือกปีเกิด (พ.ศ.)</div>
              </div>
            </div>
            <div class="mb-3">
              <label for="idCard" class="form-label">หมายเลขบัตรประชาชน</label>
              <input type="text" class="form-control text-center" name="idCard" id="idCard" minlength="13" maxlength="13" autocomplete="off" value="<?= $UserLogged['id_card']; ?>" required readonly>
            </div>
          </div>
          <h5 class="fw-bolder mt-5 mb-3">ข้อมูลติดต่อ</h5>
          <div class="rounded border p-4">
            <div class="mb-3">
              <label for="mobile" class="form-label">เบอร์มือถือ</label>
              <input type="text" class="form-control" name="mobile" id="mobile" minlength="10" maxlength="10" autocomplete="off" value="<?= $UserLogged['mobile']; ?>" required readonly>
              <div class="invalid-feedback">กรุณากรอกเบอร์มือถือ</div>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">อีเมล</label>
              <input type="email" class="form-control" name="email" id="email" maxlength="100" autocomplete="off" value="<?= $UserLogged['email']; ?>" required readonly>
              <div class="invalid-feedback">กรุณากรอกอีเมล</div>
            </div>
          </div>
          <h5 class="fw-bolder mt-5 mb-3">ข้อมูลที่อยู่</h5>
          <div class="rounded border p-4">
            <div class="mb-3">
              <label for="address" class="form-label">รายละเอียดที่อยู่ <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="address" id="address" maxlength="200" autocomplete="off" value="<?= $UserLogged['address']; ?>" placeholder="ชื่ออาคาร หมู่บ้าน หมู่ ซอย ถนน" required readonly>
              <div class="invalid-feedback">กรุณากรอกรายละเอียดที่อยู่</div>
            </div>
            <div class="mb-3">
              <label for="province" class="form-label">จังหวัด <span class="text-danger">*</span></label>
              <select class="form-select" name="province" id="province" required disabled>
                <?php foreach($provinceList as $province): ?>
                  <option value="<?= $province['name']; ?>"<?php if($UserLogged['province']==$province['name']) echo ' selected'; ?>><?= $province['name']; ?></option>
                <?php endforeach ?>
              </select>
              <div class="invalid-feedback">กรุณาเลือกจังหวัด</div>
            </div>
            <div class="mb-3">
              <label for="district" class="form-label">เขต/อำเภอ <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="district" id="district" maxlength="100" autocomplete="off" value="<?= $UserLogged['district']; ?>" required readonly>
              <div class="invalid-feedback">กรุณากรอกเขต/อำเภอ</div>
            </div>
            <div class="mb-3">
              <label for="subDistrict" class="form-label">แขวง/ตำบล <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="subDistrict" id="subDistrict" maxlength="100" autocomplete="off" value="<?= $UserLogged['sub_district']; ?>" required readonly>
              <div class="invalid-feedback">กรุณากรอกแขวง/ตำบล</div>
            </div>
            <div class="mb-3">
              <label for="postalCode" class="form-label">รหัสไปรษณีย์ <span class="text-danger">*</span></label>
              <input type="text" class="form-control text-center" name="postalCode" id="postalCode" minlength="5" maxlength="5" autocomplete="off" value="<?= $UserLogged['postal_code']; ?>" required readonly>
              <div class="invalid-feedback">กรุณากรอกรหัสไปรษณีย์</div>
            </div>
          </div>
          <h5 class="fw-bolder mt-5 mb-3">ที่อยู่ในการออกใบแจ้งหนี้/ใบเสร็จ</h5>
          <div class="rounded border p-4">
            <div class="row row-cols-2 g-4">
              <div class="d-grid col">
                <input type="radio" class="btn-check" name="invoiceLocat" id="invoiceLocatDefault" autocomplete="off" value="DEFAULT" checked>
                <label class="btn btn-outline-checkebox btn-lg py-3" for="invoiceLocatDefault">ใช้ที่อยู่ของฉัน</label>
              </div>
              <div class="d-grid col">
                <input type="radio" class="btn-check" name="invoiceLocat" id="invoiceLocatAnother" autocomplete="off" value="ANOTHER">
                <label class="btn btn-outline-checkebox btn-lg py-3" for="invoiceLocatAnother"></i>ใช้ที่อยู่อื่น (โปรดระบุ)</label>
              </div>
            </div>
            <div class="mt-3" id="invoiceLocatContainer" style="display:none">
              <div class="mb-3">
                <label for="invoiceName" class="form-label">ชื่อผู้รับ/องค์กร/หน่วยงาน <span class="text-danger">*</span></label>
                <input type="text" class="form-control invoice-locat" name="invoiceName" id="invoiceName" maxlength="250" autocomplete="off">
                <div class="invalid-feedback">กรุณากรอกชื่อผู้รับ/องค์กร/หน่วยงาน (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)</div>
              </div>
              <div class="mb-3">
                <label for="invoiceTaxId" class="form-label">เลขประจำตัวผู้เสียภาษี <span class="text-danger">*</span></label>
                <input type="text" class="form-control text-center invoice-locat" name="invoiceTaxId" id="invoiceTaxId" minlength="13" maxlength="13" autocomplete="off">
                <div class="invalid-feedback">กรุณากรอกเลขประจำตัวผู้เสียภาษี (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)</div>
              </div>
              <div class="mb-3">
                <label for="invoiceAddress" class="form-label">รายละเอียดที่อยู่ <span class="text-danger">*</span></label>
                <input type="text" class="form-control invoice-locat" name="invoiceAddress" id="invoiceAddress" maxlength="200" autocomplete="off" placeholder="ชื่ออาคาร หมู่บ้าน หมู่ ซอย ถนน">
                <div class="invalid-feedback">กรุณากรอกรายละเอียดที่อยู่ (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)</div>
              </div>
              <div class="mb-3">
                <label for="invoiceProvince" class="form-label">จังหวัด <span class="text-danger">*</span></label>
                <select class="form-select invoice-locat" name="invoiceProvince" id="invoiceProvince">
                  <?php foreach($provinceList as $province): ?>
                    <option value="<?= $province['name']; ?>"><?= $province['name']; ?></option>
                  <?php endforeach ?>
                </select>
                <div class="invalid-feedback">กรุณาเลือกจังหวัด (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)</div>
              </div>
              <div class="mb-3">
                <label for="invoiceDistrict" class="form-label">เขต/อำเภอ <span class="text-danger">*</span></label>
                <input type="text" class="form-control invoice-locat" name="invoiceDistrict" id="invoiceDistrict" maxlength="100" autocomplete="off">
                <div class="invalid-feedback">กรุณากรอกเขต/อำเภอ (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)</div>
              </div>
              <div class="mb-3">
                <label for="invoiceSubDistrict" class="form-label">แขวง/ตำบล <span class="text-danger">*</span></label>
                <input type="text" class="form-control invoice-locat" name="invoiceSubDistrict" id="invoiceSubDistrict" maxlength="100" autocomplete="off">
                <div class="invalid-feedback">กรุณากรอกแขวง/ตำบล (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)</div>
              </div>
              <div class="mb-3">
                <label for="invoicePostalCode" class="form-label">รหัสไปรษณีย์ <span class="text-danger">*</span></label>
                <input type="text" class="form-control text-center invoice-locat" name="invoicePostalCode" id="invoicePostalCode" minlength="5" maxlength="5" autocomplete="off">
                <div class="invalid-feedback">กรุณากรอกรหัสไปรษณีย์ (สำหรับการออกใบแจ้งหนี้/ใบเสร็จ)</div>
              </div>
            </div>
            <script>
              $(d => {
                $('input[name="invoiceLocat"]').on('change', e => {
                  let el = $('#invoiceLocatContainer');
                  let c = $('.invoice-locat');
                  if ($(e.currentTarget).val()=='ANOTHER') {
                    el.slideDown();
                    c.prop('required', true);
                  } else {
                    el.slideUp();
                    c.prop('required', false);
                  }
                });
              });
            </script>
          </div>
          <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg">ยืนยันการลงทะเบียน</button>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
        </div>
      </div>
    </form>
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
        $('form[name="enrollForm"] button[type="submit"]').on('click', e => {
          e.preventDefault();
          const f = $(e.currentTarget).parents('form');
          Swal.fire({
            title: 'ยืนยันการลงทะเบียน',
            html: 'เมื่อลงทะเบียนแล้ว คุณจะไม่สามารถลงทะเบียนซ้ำอีกครั้งได้<br>คุณยืนยันที่จะลงทะเบียนหรือไม่?',
            icon: 'question',
            showCancelButton: true
          }).then(res => {
            if (res.isConfirmed) f.submit();
          });
        });
      });
    </script>
  </div>
<?php endif ?>