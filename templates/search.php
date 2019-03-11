<div class="container">
    <section class="lots">
        <h2>Результаты поиска по запросу «<span><?=$search ?? "";?></span>»</h2>
            <?php if(!empty($lots)): ?>
            <ul class="lots__list">
                <?=include_template('_lots.php',['lots' => $lots]);?>
            </ul>
            <?php else: ?>
                <p>Ничего не найдено по вашему запросу</p>
            <?php endif; ?>
    </section>
    <?php if (isset($pages)) {
       echo include_template("_pagination.php", ["pages" => $pages]);
    } ?>
</div>
