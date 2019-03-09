<div class="container">
    <section class="lots">
        <h2>Результаты поиска по запросу «<span><?=$search ?? "";?></span>»</h2>
        <ul class="lots__list">
            <?=include_template('_lots.php',['lots' => $lots]); ?>
        </ul>
    </section>
    <?php if (isset($pages)) {
       echo include_template("_pagination.php", ["pages" => $pages]);
    } ?>
</div>