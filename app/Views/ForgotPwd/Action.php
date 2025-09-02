<script>
    <?php if($res['success']): ?>
        Swal.fire({
            title: 'กู้คืนบัญชีของคุณ',
            text: '<?= $res['message']; ?>',
            icon: 'success'
        }).then(() => location.href = '<?= base_url(); ?>/signin');
    <?php else: ?>
        Swal.fire({
            title: 'เกิดข้อผิดพลาด',
            html: '<?= $res['message']; ?>',
            icon: 'error'
        }).then(() => location.href = '<?= base_url(); ?>/forgotpwd');
    <?php endif ?>
</script>