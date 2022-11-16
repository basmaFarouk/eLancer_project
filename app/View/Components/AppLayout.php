<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    public $data;

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */

    public function __construct($data='')
    {
        //
        $this->data = $data;
        // dd($this->data);
    }
    public function render()
    {
        return view('layouts.app',['data'=>$this->data]);
    }
}
