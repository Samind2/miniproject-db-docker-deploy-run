<script>
    <?php if ($success): ?>
        Swal.fire({
            title: 'ลงทะเบียนสำเร็จแล้ว',
            html: '<?= $message; ?>',
            icon: 'success'
        }).then(() => location.href = '<?= $redirect; ?>');
    <?php else: ?>
        Swal.fire({
            title: 'เกิดข้อผิดพลาด',
            html: '<?= $message; ?>',
            icon: 'error'
        }).then(() => location.href = '<?= $redirect; ?>');
    <?php endif ?>
</script>