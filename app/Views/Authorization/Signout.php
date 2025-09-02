<script>
    Swal.fire({
        title: 'ออกจากระบบสำเร็จแล้ว',
        text: 'ขอบคุณที่เข้ามาใช้งาน',
        icon: 'success',
        timerProgressBar: true,
        timer: 2000
    }).then(() => location.href = '<?= base_url(); ?>');
</script>