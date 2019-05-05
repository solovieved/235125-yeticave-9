<main>
    <nav class="nav">
        <?= include_template('menu-top.php', ['categories' => $categories]); ?>
    </nav>

    <?php
    $error = isset($errors) ? "form--invalid" : "";
    ?>

    <form class="form form--add-lot container <?= $error; ?>" action="add.php" method="post">
        <h2>Добавление лота</h2>
        <div class="form__container-two">

            <?php
            $class = isset($errors['lot-name']) ? "form__item--invalid" : "";
            $value = isset($lot_data['lot-name']) ? $lot_data['lot-name'] : "";
            $error = isset($errors['lot-name']) ? $errors['lot-name'] : "";
            ?>

            <div class="form__item <?= $class; ?>">
                <label for="lot-name">Наименование <sup>*</sup></label>
                <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?= $value; ?>">
                <span class="form__error"><?= $error; ?></span>
            </div>

            <?php
            $class = isset($errors['category']) ? "form__item--invalid" : "";
            $error = isset($errors['category']) ? $errors['category'] : "";
            ?>

            <div class="form__item <?= $class; ?>">
                <label for="category">Категория <sup>*</sup></label>
                <select id="category" name="category">
                    <option value="">Выберите категорию</option>

                    <?php foreach ($categories as $value) : ?>
                        <option value="<?= $value['id']; ?>"><?= $value['name']; ?></option>
                    <?php endforeach; ?>

                </select>
                <span class="form__error"><?= $error; ?></span>
            </div>
        </div>

        <?php
        $class = isset($errors['message']) ? "form__item--invalid" : "";
        $value = isset($lot_data['message']) ? $lot_data['message'] : "";
        $error = isset($errors['message']) ? $errors['message'] : "";
        ?>

        <div class="form__item form__item--wide <?= $class; ?>">
            <label for="message">Описание <sup>*</sup></label>
            <textarea id="message" name="message" placeholder="Напишите описание лота"><?= $value; ?></textarea>
            <span class="form__error"><?= $error; ?></span>
        </div>

        <?php
        $class = isset($errors['lot-img']) ? "form__item--invalid" : "";
        $error = isset($errors['lot-img']) ? $errors['lot-img'] : "";
        ?>

        <div class="form__item form__item--file <?= $class; ?>">
            <label>Изображение <sup>*</sup></label>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="lot-img" name="lot-img" value="">
                <label for="lot-img">
                    Добавить
                </label>
            </div>
            <span class="form__error"><?= $error; ?></span>
        </div>
        <div class="form__container-three">

            <?php
            $class = isset($errors['lot-rate']) ? "form__item--invalid" : "";
            $value = isset($lot_data['lot-rate']) ? $lot_data['lot-rate'] : "";
            $error = isset($errors['lot-rate']) ? $errors['lot-rate'] : "";
            ?>

            <div class="form__item form__item--small <?= $class; ?>">
                <label for="lot-rate">Начальная цена <sup>*</sup></label>
                <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value="<?= $value ?>">
                <span class="form__error"><?= $error; ?></span>
            </div>

            <?php
            $class = isset($errors['lot-step']) ? "form__item--invalid" : "";
            $value = isset($lot_data['lot-step']) ? $lot_data['lot-step'] : "";
            $error = isset($errors['lot-step']) ? $errors['lot-step'] : "";
            ?>

            <div class="form__item form__item--small <?= $class; ?>">
                <label for="lot-step">Шаг ставки <sup>*</sup></label>
                <input id="lot-step" type="text" name="lot-step" placeholder="0" value="<?= $value ?>">
                <span class="form__error"><?= $error; ?></span>
            </div>

            <?php
            $class = isset($errors['lot-date']) ? "form__item--invalid" : "";
            $value = isset($lot_data['lot-date']) ? $lot_data['lot-date'] : "";
            $error = isset($errors['lot-date']) ? $errors['lot-date'] : "";
            ?>

            <div class="form__item <?= $class; ?>">
                <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
                <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?= $value ?>">
                <span class="form__error"><?= $error; ?></span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>
