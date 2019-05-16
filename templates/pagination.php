<?php if ($pages_count > 1): ?>
<ul class="pagination-list">
    <li class="pagination-item pagination-item-prev"><?php if ($cur_page > 1): ?><a href="all-lots.php?cat=<?= $category_id; ?>&page=<?= $cur_page - 1; ?>">Назад</a><?php endif; ?></li>
    <?php foreach ($pages as $page): ?>
        <li class="pagination-item <?php if ((string)$page === $cur_page): ?>pagination-item-active<?php endif; ?>"><a href="/all-lots.php?cat=<?= $category_id; ?>&page=<?= $page; ?>"><?= $page; ?></a></li>
    <?php endforeach; ?>
    <li class="pagination-item pagination-item-next"><?php if ($cur_page < $pages_count): ?><a href="all-lots.php?cat=<?= $category_id; ?>&page=<?= $cur_page + 1; ?>">Вперед</a><?php endif; ?></li>
</ul>
<?php endif; ?>
