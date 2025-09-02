<!DOCTYPE html>
<html lang="en">
    <head>
        <?= $Layout['Header']; ?>
    </head>
    <body class="d-flex flex-column min-vh-100">
        <?= $Layout['Navbar']; ?>
        <?= $Layout['Content']; ?>
        <?= $Layout['Footer']; ?>
        <script>$(d => window.waitingModal = new bootstrap.Modal(document.getElementById('waitingModal')));</script>
        <div class="modal" id="waitingModal" role="dialog" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="spinner-border text-primary m-auto" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </body>
</html>