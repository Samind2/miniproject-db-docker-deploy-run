<?php $pager->setSurroundCount(2); ?>
<nav>
    <ul class="pagination justify-content-center">
        <li class="page-item<?php if (!$pager->hasPrevious()) echo ' disabled';?>"><a class="page-link" href="<?= $pager->getFirst(); ?>" tabindex="-1">&laquo;</a></li>
        <li class="page-item<?php if (!$pager->hasPrevious()) echo ' disabled';?>"><a class="page-link" href="<?= $pager->getPrevious(); ?>">&lsaquo;</a></li>
        <?php
        foreach ($pager->links() as $link) {
            echo '<li class="page-item';
            if ($link['active']) echo ' active';
            echo '"><a class="page-link" href="'.$link['uri'].'">'.$link['title'].'</a></li>';
        }
        ?>
        <li class="page-item<?php if (!$pager->hasNext()) echo ' disabled';?>"><a class="page-link" href="<?= $pager->getNext(); ?>">&rsaquo;</a></li>
        <li class="page-item<?php if (!$pager->hasNext()) echo ' disabled';?>"><a class="page-link" href="<?= $pager->getLast(); ?>">&raquo;</a></li>
    </ul>
</nav>