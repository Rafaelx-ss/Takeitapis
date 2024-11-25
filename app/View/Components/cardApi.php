<?php

namespace App\View\Components;

use Illuminate\View\Component;

class cardApi extends Component
{
    public $title;
    public $url;
    public $description;
    public $params;


    public function __construct($title, $url, $description, $params = [])
    {
        $this->title = $title;
        $this->url = $url;
        $this->description = $description;
        $this->params = $params;
    }

    public function render()
    {
        return view('components.card-api');
    }
}
