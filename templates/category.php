<div class="container">
    <section class="lots">
        <h2>Все лоты в  категории <span>«<?=$category ?? "";?>»</span></h2>
        <ul class="lots__list">
            <?=include_template("_lots.php", ["lots" => $lots]); ?>
        </ul>
    </section>
    <?=include_template("_pagination.php", ["pages" => $pages]); ?>
</div>