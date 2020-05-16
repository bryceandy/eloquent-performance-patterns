<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Notification extends Component
{
    public string $type;
    public string $message;

    /**
     * Create a new component instance.
     *
     * @param $type
     * @param $message
     */
    public function __construct($type, $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.notification');
    }
}
