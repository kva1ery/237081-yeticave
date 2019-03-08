<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <?php foreach ($bets as $bet): ?>
        <?php $win = $bet["win"]?>
        <tr class="rates__item <?=$win ? "rates__item--win" : "";?>">
            <td class="rates__info">
                <div class="rates__img">
                    <img src="/img/<?=$bet["lot_image"]?>" width="54" height="40" alt="<?=esc($bet["lot_name"]);?>">
                </div>
                <h3 class="rates__title"><a href="lot.php?id=<?=$bet["lot_id"];?>"><?=esc($bet["lot_name"]);?></a></h3>
            </td>
            <td class="rates__category">
                <?=$bet["category_name"];?>
            </td>
            <td class="rates__timer">
                <?php $time_finish = is_less_than_hour($bet["lot_finish_date"]) ? "timer--finishing" : "";?>

                <div class="timer <?=$time_finish;?> <?=$win ? "timer--win" : "";?>">
                    <?=$win ? "Ставка выиграла" : time_to_finish($bet["lot_finish_date"])?>
                </div>
            </td>
            <td class="rates__price">
                <?=currency_format($bet["price"]);?> р
            </td>
            <td class="rates__time">
                <?=time_from_start($bet["create_date"]);?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>