<?php $classname = (isset($errors) && count($errors) > 0) ? "form--invalid" : ""; ?>
<form class="form form--add-lot container <?=$classname;?>" action="add.php" method="post" enctype="multipart/form-data">
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <?php $classname = isset($errors['name']) ? "form__item--invalid" : "";
        $error = $errors['name'] ?? "";
        $value = $lot['name'] ?? ""; ?>
        <div class="form__item <?=$classname;?>">
            <label for="lot-name">Наименование</label>
            <input id="lot-name" type="text" name="name" placeholder="Введите наименование лота" value="<?=$value;?>" required>
            <span class="form__error"><?=$error;?></span>
        </div>

        <?php $classname = isset($errors['category']) ? "form__item--invalid" : "";
        $error = $errors['category'] ?? "";
        $value = $lot['category'] ?? ""; ?>
        <div class="form__item" <?=$classname;?>>
            <label for="category">Категория</label>
            <select id="category" name="category" required>
                <?php foreach ($lots_categories as $category):
                    $selected = $category["id"] == $value ? "selected" : ""; ?>
                    <option value="<?=$category["id"];?>" <?=$selected;?> ><?=$category["name"];?></option>
                <?php endforeach; ?>
            </select>
            <span class="form__error"><?=$error;?></span>
        </div>
    </div>

    <?php $classname = isset($errors['description']) ? "form__item--invalid" : "";
    $error = $errors['description'] ?? "";
    $value = $lot['description'] ?? ""; ?>
    <div class="form__item form__item--wide <?=$classname;?>">
        <label for="description">Описание</label>
        <textarea id="description" name="description" placeholder="Напишите описание лота" required><?=$value;?></textarea>
        <span class="form__error"><?=$error;?></span>
    </div>

    <?php $classname = isset($errors['image']) ? "form__item--invalid" : "";
    $error = $errors['image'] ?? ""; ?>
    <div class="form__item form__item--file <?=$classname;?>"> <!-- form__item--uploaded -->
        <label>Изображение</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
            </div>
        </div>
        <div class="form__input-file ">
            <input class="visually-hidden" type="file" name="image" id="image" value="">
            <label for="image">
                <span>+ Добавить</span>
            </label>
        </div>
        <span class="form__error"><?=$error;?></span>
    </div>

    <div class="form__container-three">
        <?php $classname = isset($errors['start_price']) ? "form__item--invalid" : "";
        $error = $errors['start_price'] ?? "";
        $value = $lot['start_price'] ?? ""; ?>
        <div class="form__item form__item--small <?=$classname;?>">
            <label for="lot-rate">Начальная цена</label>
            <input id="lot-rate" type="number" name="start_price" placeholder="0" value="<?=$value;?>" required>
            <span class="form__error"><?=$error;?></span>
        </div>

        <?php $classname = isset($errors['price_step']) ? "form__item--invalid" : "";
        $error = $errors['price_step'] ?? "";
        $value = $lot['price_step'] ?? ""; ?>
        <div class="form__item form__item--small <?=$classname;?>">
            <label for="lot-step">Шаг ставки</label>
            <input id="lot-step" type="number" name="price_step" placeholder="0" value="<?=$value;?>">
            <span class="form__error"><?=$error;?></span>
        </div>

        <?php $classname = isset($errors['finish_date']) ? "form__item--invalid" : "";
        $error = $errors['finish_date'] ?? "";
        $value = $lot['finish_date'] ?? ""; ?>
        <div class="form__item <?=$classname;?>">
            <label for="lot-date">Дата окончания торгов</label>
            <input class="form__input-date" id="lot-date" type="date" name="finish_date" value="<?=$value;?>">
            <span class="form__error"><?=$error;?></span>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>