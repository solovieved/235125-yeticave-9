<ul class="nav__list container">
    <?php foreach ($categories as $key => $value) : ?>
        <li class="nav__item <?php if ($_GET['cat'] === $value['id']) : ?>nav__item--current<?php endif; ?>">
            <a href="all-lots.php?cat=<?= $value['id'] ?>"><?= $value['name']; ?></a>
        </li>
    <?php endforeach; ?>
</ul>
