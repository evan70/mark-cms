<?php

namespace App\Services;

class Pagination
{
    private $items;
    private $totalItems;
    private $itemsPerPage;
    public $currentPage;

    public function __construct($items, $totalItems, $itemsPerPage, $currentPage)
    {
        $this->items = $items;
        $this->totalItems = $totalItems;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
    }

    public function items()
    {
        return $this->items;
    }

    public function totalPages()
    {
        return ceil($this->totalItems / $this->itemsPerPage);
    }

    public function hasPages()
    {
        return $this->totalPages() > 1;
    }

    public function currentPage()
    {
        return $this->currentPage;
    }

    public function previousPageUrl()
    {
        if ($this->currentPage > 1) {
            return '?page=' . ($this->currentPage - 1);
        }
        return null;
    }

    public function nextPageUrl()
    {
        if ($this->currentPage < $this->totalPages()) {
            return '?page=' . ($this->currentPage + 1);
        }
        return null;
    }
}
