<?php

namespace App\View\Components;

use Illuminate\Support\Facades\App;
use Illuminate\View\Component;
use Symfony\Component\Intl\Countries;


class CountrySelect extends Component
{
    public $countries; //اي حاجة بابليك هنا ال فيوز هتقدر تشوفها
    public $selected;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected=null)
    {
        //
        $this->countries=Countries::getNames();
        $this->selected = $selected;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.country-select');
    }
}
