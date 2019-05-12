<main>
    <nav class="nav">
        <?= include_template('menu-top.php', ['categories' => $categories]); ?>
    </nav>
    <form class="form container <?= count($errors) ? "form--invalid" : ""; ?>" action="login.php" method="post" enctype="multipart/form-data">
        <!-- form--invalid -->
        <h2>Вход</h2>
        <div class="form__item <?= isset($errors['email']) ? "form__item--invalid" : ""; ?>">
            <!-- form__item--invalid -->
            <label for="email">E-mail <sup>*</sup></label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $login_data['email'] ?? ""; ?>">
            <span class="form__error"><?= $errors['email'] ?? ""; ?></span>
        </div>
        <div class="form__item form__item--last <?= isset($errors['password']) ? "form__item--invalid" : ""; ?>">
            <label for="password">Пароль <sup>*</sup></label>
            <input id="password" type="password" name="password" placeholder="Введите пароль">
            <span class="form__error"><?= $errors['password'] ?? ""; ?></span>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Войти</button>
    </form>
</main>
