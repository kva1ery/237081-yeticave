<?php

class Paginator {
    private $items_count;
    private $count_on_page;
    private $current_page;
    private $pages_count;
    private $offset;
    private $url;

    public function __construct($items_count, $count_on_page, $current_page=1, $url="/?page=") {
        $this->items_count = $items_count;
        $this->count_on_page = $count_on_page;
        $this->current_page = $current_page;
        $this->url = $url;

        $this->pages_count = ceil($this->items_count / $this->count_on_page);
        $this->offset = ($this->current_page - 1) * $this->count_on_page;
    }

    public function FirstIsCurrent() {
        return $this->current_page == 1;
    }

    public function FirstUrl() {
        return $this->url . 1;
    }

    public function LastIsCurrnet() {
        return $this->current_page == $this->pages_count;
    }

    public function LastUrl() {
        return $this->url . $this->pages_count;
    }

    public function GetOffset() {
        return $this->offset;
    }

    public function GetPages() {
        $pages = [];
        for($p=1; $p<=$this->pages_count; $p++) {
            $page = [
                "number" => $p,
                "is_active" => $p == $this->current_page,
                "url" => $this->url . $p
            ];
            $pages[] = $page;
        }
        return $pages;
    }
}