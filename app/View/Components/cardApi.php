<?php

namespace App\View\Components;

use Illuminate\View\Component;

class cardApi extends Component
{
    public $title;
    public $url;
    public $description;
    public $parameters;
    public $response;

    public function __construct($title, $url, $description, $parameters = [], $response = [])
    {
        $this->title = $title;
        $this->url = $url;
        $this->description = $description;
        $this->parameters = $parameters;
        $this->response = $response;
    }

    public function render()
    {
        return view('components.card-api');
    }
}
