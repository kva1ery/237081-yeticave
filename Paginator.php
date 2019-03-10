<?php

/**
 * Класс для создания пагинаторов на странцах
 */
class Paginator {
    private $items_count;
    private $count_on_page;
    private $current_page;
    private $pages_count;
    private $offset;
    private $url;

    /**
     * Конструктор
     * @param int $items_count Общее количество элементов в коллекции
     * @param int $count_on_page Количество элементов на странице
     * @param int $current_page Текущая страница
     * @param string $url Начало url, к которому добавиться номер страницы
     */
    public function __construct($items_count, $count_on_page, $current_page=1, $url="/?page=") {
        $this->items_count = $items_count;
        $this->count_on_page = $count_on_page;
        $this->current_page = $current_page;
        $this->url = $url;

        $this->pages_count = ceil($this->items_count / $this->count_on_page);
        $this->offset = ($this->current_page - 1) * $this->count_on_page;
    }

    /**
     * Определяет является ли текущая странца первой
     * @return bool Текущая странца - первая
     */
    public function FirstIsCurrent() {
        return $this->current_page === 1;
    }

    /**
     * Возвращает url первой страницы
     * @return string url первой страницы
     */
    public function FirstUrl() {
        return $this->url . 1;
    }

    /**
     * Определяет является ли текущая странца последней
     * @return bool Текущая странца - последняя
     */
    public function LastIsCurrnet() {
        return $this->current_page === $this->pages_count;
    }

    /**
     * Возвращает url последней страницы
     * @return string url последней страницы
     */
    public function LastUrl() {
        return $this->url . $this->pages_count;
    }

    /**
     * Возвращает смещение относительно начала коллекции, для получения элементов текущей страницы
     * @return int Смещение относительно начала коллекции
     */
    public function GetOffset() {
        return $this->offset;
    }

    /**
     * Возвращает коллекцию записей описывающих страницы
     * number - номер страницы
     * is_active - true если страница является текущей
     * url - url страницы
     * @return array Коллекция записей описывающих страницы
     */
    public function GetPages() {
        $pages = [];
        for($p=1; $p<=$this->pages_count; $p++) {
            $page = [
                "number" => $p,
                "is_active" => $p === $this->current_page,
                "url" => $this->url . $p
            ];
            $pages[] = $page;
        }
        return $pages;
    }
}