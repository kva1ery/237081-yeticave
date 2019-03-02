<section class="lot-item container">
    <h2><?=esc($lot["name"])?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="uploads/<?=$lot["image"]?>" width="730" height="548" alt="Сноуборд">
            </div>
            <p class="lot-item__category">Категория: <span><?=$lot["category_name"]?></span></p>
            <p class="lot-item__description"><?=esc($lot["description"]);?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <?php $time_finish = is_less_than_hour($lot["finish_date"]) ? "timer--finishing" : "";?>
                <div class="lot-item__timer timer <?=$time_finish;?>">
                    <?=time_to_finish($lot["finish_date"])?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?=currency_format($lot["current_price"]);?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?=currency_format($lot["min_bet"]);?> р</span>
                    </div>
                </div>
                <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post">
                    <p class="lot-item__form-item form__item form__item--invalid">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="cost" placeholder="<?=currency_format($lot["min_bet"]);?>">
                        <span class="form__error">Введите наименование лота</span>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <div class="history">
                <h3>История ставок (<span><?=count($bets);?></span>)</h3>
                <table class="history__list">
                    <?php foreach ($bets as $bet): ?>
                    <tr class="history__item">
                        <td class="history__name"><?=esc($bet["user_name"]);?></td>
                        <td class="history__price"><?=currency_format($bet["price"]);?> р</td>
                        <td class="history__time"><?=$bet["create_date"];?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>