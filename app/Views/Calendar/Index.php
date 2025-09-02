<div class="bg-white border-top">
    <div class="container-fluid px-4 px-lg-5">
        <nav class="py-2" aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">หน้าแรก</a></li>
                <li class="breadcrumb-item active text-truncate" aria-current="page">ปฏิทินอบรม</li>
            </ol>
        </nav>
    </div>
</div>

<section>
    <div class="container-fluid px-4 px-lg-5 pt-4">
        <div class="bg-white rounded shadow p-4 mb-4">
            <div id='calendar'></div>
        </div>
        <script>
            $(d => {
                new FullCalendar.Calendar(document.getElementById('calendar'), {
                    timeZone: 'UTC',
                    locale: 'th',
                    themeSystem: 'bootstrap5',
                    headerToolbar: {
                        left: 'title',
                        center: null,
                        right: 'prev,next today',
                    },
                    editable: false,
                    navLinks: false,
                    displayEventTime: false,
                    events: '<?= base_url(); ?>/api/get/course/calendar',
                    eventMouseEnter: d => d.el.setAttribute('title', d.event.title),
                    eventClick: d => window.open('<?= base_url(); ?>/course/'+d.event.id),
                    loading: r => document.getElementById('waitingModal').style.display = r ? 'block' : 'none'
                }).render();
            });
        </script>
    </div>    
</section>