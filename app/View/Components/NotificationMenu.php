<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class NotificationMenu extends Component
{
    public $notifications;
    public $new;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($count=10)
    {
        //
        $user=Auth::user();
        if($user){

            $this->notifications=$user->notifications()->take($count)->get();
            $this->new=$user->unreadNotifications()->count();
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.notification-menu');
    }
}
