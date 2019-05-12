<main>
    <nav class="nav">
        <?= include_template('menu-top.php', ['categories' => $categories]); ?>
    </nav>
    <section class="lot-item container">
    <?php foreach ($lot_info as $key => $item) : ?>
        <h2><?= htmlspecialchars($item['name']); ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?= $item['image']; ?>" width="730" height="548" alt="Сноуборд">
                </div>
                <p class="lot-item__category">Категория: <span><?= $item['cat']; ?></span></p>
                <p class="lot-item__description"><?= htmlspecialchars($item['description']); ?></p>
            </div>
            <div class="lot-item__right">
                <div class="lot-item__state <?php if (!$_SESSION) : ?>visually-hidden<?php endif; ?>">
                    <div class="lot-item__timer timer <?php if (strtotime($item['date_completion']) - strtotime('now') <= $time_to_close) : ?>timer--finishing<?php endif; ?>">
                        <?= get_time_completion($item['date_completion']); ?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?= $item['price']; ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?= $item['min']; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </section>
</main>
