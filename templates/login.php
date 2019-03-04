<?php $classname = (!empty($errors)) ? "form--invalid" : ""; ?>
<form class="form container <?=$classname;?>" action="login.php" method="post">
    <h2>Вход</h2>
    <?php $classname = isset($errors["email"]) ? "form__item--invalid" : "";
    $error = $errors["email"] ?? "";
    $value = $login["email"] ?? ""; ?>
    <div class="form__item <?=$classname;?>">
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$value;?>">
        <span class="form__error"><?=$error;?></span>
    </div>

    <?php $classname = isset($errors["password"]) ? "form__item--invalid" : "";
    $error = $errors["password"] ?? "";
    $value = $login["password"] ?? ""; ?>
    <div class="form__item form__item--last <?=$classname;?>">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?=$value;?>">
        <span class="form__error"><?=$error;?></span>
    </div>
    <span class="form__error form__error--bottom"><?=$errors["form"] ?? "";?></span>
    <button type="submit" class="button">Войти</button>
</form>