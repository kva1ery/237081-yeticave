<?php $classname = (!empty($errors)) ? "form--invalid" : ""; ?>
<form class="form container <?=$classname;?>" action="signup.php" method="post" enctype="multipart/form-data">
    <h2>Регистрация нового аккаунта</h2>
    <?php $classname = isset($errors["email"]) ? "form__item--invalid" : "";
    $error = $errors["email"] ?? "";
    $value = $user["email"] ?? ""; ?>
    <div class="form__item <?=$classname;?>">
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$value;?>" required>
        <span class="form__error"><?=$error;?></span>
    </div>

    <?php $classname = isset($errors["password"]) ? "form__item--invalid" : "";
    $error = $errors["password"] ?? "";
    $value = $user["password"] ?? ""; ?>
    <div class="form__item <?=$classname;?>">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?=$value;?>" required>
        <span class="form__error"><?=$error;?></span>
    </div>

    <?php $classname = isset($errors["name"]) ? "form__item--invalid" : "";
    $error = $errors["name"] ?? "";
    $value = $user["name"] ?? ""; ?>
    <div class="form__item <?=$classname;?>">
        <label for="name">Имя*</label>
        <input id="name" type="text" name="name" placeholder="Введите имя" value="<?=$value;?>" required>
        <span class="form__error"><?=$error;?></span>
    </div>

    <?php $classname = isset($errors["contacts"]) ? "form__item--invalid" : "";
    $error = $errors["contacts"] ?? "";
    $value = $user["contacts"] ?? ""; ?>
    <div class="form__item <?=$classname;?>">
        <label for="contacts">Контактные данные*</label>
        <textarea id="contacts" name="contacts" placeholder="Напишите как с вами связаться" required><?=$value;?></textarea>
        <span class="form__error"><?=$error;?></span>
    </div>

    <?php $classname = isset($errors["avatar"]) ? "form__item--invalid" : "";
    $error = $errors["avatar"] ?? ""; ?>
    <div class="form__item form__item--file form__item--last <?=$classname;?>">
        <label>Аватар</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" name="avatar" id="photo2" value="">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
        </div>
        <span class="form__error"><?=$error;?></span>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
</form>