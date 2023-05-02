<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PageContentHeader extends Component
{
    public $title, $breadcrumb = [];

    public function __construct($title = '', $breadcrumb = [])
    {
        $this->title = $title;
        $this->breadcrumb = $breadcrumb;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.page-content-header');
    }
}
