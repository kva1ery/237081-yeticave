<div class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <?php foreach ($lots_categories as $category): ?>
                <li class="promo__item <?=$category["class"]?>">
                    <a class="promo__link" href="category.php?id=<?=$category["id"];?>"><?=$category["name"];?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <?=include_template('_lots.php',['lots' => $lots]); ?>
        </ul>
    </section>
</div>