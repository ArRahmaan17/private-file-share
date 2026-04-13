<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Head extends Component
{
    public string $title;
    public string $description;

    /**
     * Create a new component instance.
     */
    public function __construct(string $title = 'FileStream - Simple, Secure File Sharing', string $description = 'High-performance, secure file sharing with glassmorphism aesthetic.')
    {
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.head');
    }
}
