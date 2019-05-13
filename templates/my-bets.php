<main>
    <nav class="nav">
        <?= include_template('menu-top.php', ['categories' => $categories]); ?>
    </nav>
    <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">
        <?php foreach ($user_bet as $key => $item) : ?>
            <tr class="rates__item">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="<?= $item['image']; ?>" width="54" height="40" alt="Сноуборд">
                    </div>
                    <h3 class="rates__title"><a href="lot.php?id=<?= $item['lot']; ?>"><?= $item['name']; ?></a></h3>
                </td>
                <td class="rates__category">
                    <?= $item['category']; ?>
                </td>
                <td class="rates__timer">
                    <div class="timer <?php if (strtotime($item['date_completion']) - strtotime('now') <= $time_to_close) : ?>timer--finishing<?php endif; ?>"><?= get_time_completion($item['date_completion']); ?></div>
                </td>
                <td class="rates__price">
                    <?= get_formatted_amount($item['price']) . ' р'; ?>
                </td>
                <td class="rates__time">
                    <?= show_time(strtotime($item['date_bet'])); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </section>
</main>
