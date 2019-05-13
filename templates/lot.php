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
                    <div class="lot-item__state">
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
                        <?php if ($show_form || strtotime($item['date_completion']) < strtotime('now')) : ?>
                        <form class="lot-item__form" action="/lot.php?id=<?= $item['id'] ?>" method="post" autocomplete="off">
                            <p class="lot-item__form-item form__item <?= count($errors) ? "form__item--invalid" : ""; ?>">
                                <label for="cost">Ваша ставка</label>
                                <input id="cost" type="text" name="cost" placeholder="<?= $item['min']; ?> ">
                                <span class="form__error"><?= $errors['cost'] ?? ""; ?></span>
                            </p>
                            <button type="submit" class="button">Сделать ставку</button>
                        </form>
                        <?php endif; ?>
                    </div>
                    <div class="history">
                        <h3>История ставок (<span><?= count($bet);?></span>)</h3>
                        <table class="history__list">
                        <?php foreach ($bet as $key => $item) : ?>
                            <tr class="history__item">
                                <td class="history__name"><?= $item['name']; ?></td>
                                <td class="history__price"><?= $item['price']; ?></td>
                                <td class="history__time"><?= show_time(strtotime($item['date_bet'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</main>
