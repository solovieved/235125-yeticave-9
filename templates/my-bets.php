<main>
    <nav class="nav">
        <?= include_template('menu-top.php', ['categories' => $categories]); ?>
    </nav>
    <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">
            <?php foreach ($user_bet as $key => $item) : ?>
                <tr class="rates__item <?= ((int)$item['winner'] === $user_id) ? 'rates__item--win' : ''; ?><?= ((strtotime($item['date_completion']) < strtotime('now')) && ($item['winner'] !== $user_id)) ? 'rates__item--end' : ''; ?>">
                    <td class="rates__info">
                        <div class="rates__img">
                            <img src="<?= $item['image']; ?>" width="54" height="40" alt="Сноуборд">
                        </div>
                        <div>
                            <h3 class="rates__title"><a href="lot.php?id=<?= $item['lot']; ?>"><?= $item['name']; ?></a></h3>
                            <?php if ((int)$item['winner'] === $user_id) : ?>
                                <p><?= $item['contacts']; ?></p>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="rates__category">
                        <?= $item['category']; ?>
                    </td>
                    <td class="rates__timer">
                        <?php if (strtotime($item['date_completion']) > time()) : ?>
                            <div class="timer <?= (strtotime($item['date_completion']) - strtotime('now') <= $time_to_close && strtotime($item['date_completion']) - strtotime('now') > 0) ? 'timer--finishing' : '' ?>">
                                <?= get_time_completion($item['date_completion']); ?>
                            </div>
                        <?php elseif ((int)$item['winner'] === $user_id) : ?>
                            <div class="timer timer--win">Ставка выиграла</div>
                        <?php else : ?>
                            <div class="timer timer--end">Торги окончены</div>
                        <?php endif; ?>
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
