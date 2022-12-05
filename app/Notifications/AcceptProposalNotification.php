<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptProposalNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(protected $user, protected $project)
    {
        // dd($user);
        // dd($project);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }


    public function toDatabase($notifiable){ //nneeeewwww
        $body=sprintf(
            '%s accept your proposal on %s',
            $this->user->name,
            $this->project->title,
        );

        return[
            'title'=>'New notification',
            'body'=>$body,
            'icon'=>'icon-material-outline-group',
            'url'=>route('projects.show',[$this->project->id])
        ];
    }

    public function toBroadcast($notifiable){ ///neeeewwww

        $body=sprintf(
            '%s accept your proposal on %s',
            $this->user->name,
            $this->project->title,
        );

        return new BroadcastMessage([
            'title'=>'New notification',
            'body'=>$body,
            'icon'=>'icon-material-outline-group',
            'url'=>route('projects.show',[$this->project->id])
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
