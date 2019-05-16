<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <!--список из массива категорий-->
            <?php foreach ($categories as $key => $value) : ?>
                <li class="promo__item promo__item--<?= $value['character_code']; ?>">
                    <a class="promo__link" href="all-lots.php?cat=<?= $value['id']?>&page=1"><?= $value['name']; ?></a>
                </li>
            <?php endforeach; ?>

        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <!--список из массива с товарами-->
            <?php foreach ($lot_info as $key => $item) : ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= $item['image']; ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= $item['cat']; ?></span>
                        <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $item['id']; ?>"><?= htmlspecialchars($item['name']); ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount"><?= $item['count_bet'] > 0 ? $item['count_bet'] . ' ' . get_noun_plural_form($item['count_bet'], 'ставка', 'ставки', 'ставок') : 'Стартовая цена' ?></span>
                                <span class="lot__cost"><?= get_formatted_amount($item['price']) . '<b class="rub">р</b>'; ?></span>
                            </div>
                            <div class="lot__timer timer <?= (strtotime($item['date_completion']) - strtotime('now') <= $time_to_close && strtotime($item['date_completion']) - strtotime('now') > 0) ? 'timer--finishing' : '' ?>">
                                <?= get_time_completion($item['date_completion']); ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>

        </ul>
    </section>
</main>
