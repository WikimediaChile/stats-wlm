<?php

namespace helper;

class paginator
{
    private $total;
    private $elements;
    private $pages;
    private $page;

    public function __construct(int $total, int $elements)
    {
        $this->total = $total;
        $this->elements = $elements;
        $this->pages = ceil($total/$elements);
    }

    public function setPage(int $page)
    {
        $this->page = $page;
    }

    public function hasPreviousPage() : bool
    {
        return $this->page > 1;
    }

    public function hasNextPage() : bool
    {
        return $this->page < $this->pages;
    }

    public function hasPages(): bool
    {
        return $this->pages > 0;
    }

    public function getPage() : int
    {
        return $this->page;
    }

    public function getPages(): int
    {
        return $this->pages;
    }

    public function render(string $ui = 'paginator.htm')
    {
        \F3::mset([
            'page' => $this->page,
            'pages' => $this->pages,
            'next' => $this->hasNextPage(),
            'previous' => $this->hasPreviousPage()
        ], 'paginator_');
        echo \Template::instance()->render($ui);
    }
}
