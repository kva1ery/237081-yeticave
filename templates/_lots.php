<?php foreach ($lots as $lot): ?>
    <li class="lots__item lot">
        <div class="lot__image">
            <img src="<?=$lot["image_url"]?>" width="350" height="260" alt="">
        </div>
        <div class="lot__info">
            <span class="lot__category"><?=$lot["category"]?></span>
            <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?=esc($lot["name"])?></a></h3>
            <div class="lot__state">
                <div class="lot__rate">
                    <span class="lot__amount">Стартовая цена</span>
                    <span class="lot__cost"><?=currency_format($lot["price"])?><b class="rub">р</b></span>
                </div>
                <div class="lot__timer timer">
                    <?=$lot["time_left"]?>
                </div>
            </div>
        </div>
    </li>
<?php endforeach; ?>
