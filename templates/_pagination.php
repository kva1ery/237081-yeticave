<ul class="pagination-list">
    <li class="pagination-item pagination-item-prev">
        <a <?=!($pages->FirstIsCurrent()) ? ('href="' . $pages->FirstUrl() . '"') : '';?>>Назад</a>
    </li>
    <?php foreach ($pages->GetPages() as $page): ?>
    <li class="pagination-item <?=$page["is_active"] ? "pagination-item-active" : "";?>">
        <a <?=!$page["is_active"] ? ('href="' . $page["url"] . '"') : '';?>><?=$page["number"];?></a>
    </li>
    <?php endforeach; ?>
    <li class="pagination-item pagination-item-next">
        <a <?=!($pages->LastIsCurrnet()) ? ('href="' . $pages->LastUrl() . '"') : '';?>>Вперед</a>
    </li>
</ul>