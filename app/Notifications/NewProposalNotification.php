<?php

namespace App\Notifications;

use App\Channels\Log;
use App\Channels\Nepras;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Broadcasting\BroadcastEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class NewProposalNotification extends Notification
{
    use Queueable;

    protected $proposal;
    protected $freelancer;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Proposal $proposal,User $freelancer)
    {
        $this->proposal=$proposal;
        $this->freelancer=$freelancer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //Dynamic Via
        // $via=[];
        // if($notifiable->notify_mail){
        //     $via[]='mail';
        // } if($notifiable->notify_sms){
        //     $via[]='nexmo';
        // }
        // return $via;

        //return ['database','mail','broadcast','vonage'];
        return ['mail','broadcast','database'];
        // return [Log::class,Nepras::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $user=Auth::user()->email;
        $body=sprintf(
            '%s applied for a job %s',
            $this->freelancer->name,
            $this->proposal->project->title,
        );
        return (new MailMessage)
                    ->subject('New Proposal')
                    ->from($user,'E-lancer Notification')
                    ->greeting('Hello '.$notifiable->name)
                    ->line($body)
                    ->action('View Proposal ', route('client.candidate.details',
                    ['user_id'=>$this->proposal->freelancer_id,'project_id'=>$this->proposal->project_id]))
                    ->line('Thank you for using our application!');
                    // ->view('mail.proposal')
    }

    public function toDatabase($notifiable){ //nneeeewwww
        $body=sprintf(
            '%s applied for a job %s',
            $this->freelancer->name,
            $this->proposal->project->title,
        );

        return[
            'title'=>'New Proposal',
            'body'=>$body,
            'icon'=>'icon-material-outline-group',
            'url'=>route('client.candidate.details',[$this->proposal->freelancer_id,$this->proposal->project_id])
        ];
    }

    public function toBroadcast($notifiable){ ///neeeewwww

        $body=sprintf(
            '%s applied for a job %s',
            $this->freelancer->name,
            $this->proposal->project->title,
        );

        return new BroadcastMessage([
            'title'=>'New Proposal',
            'body'=>$body,
            'icon'=>'icon-material-outline-group',
            'url'=>route('client.candidate.details',[$this->proposal->freelancer_id,$this->proposal->project_id])
            //route('projects.show',$this->proposal->project_id)
        ]);
    }

    public function toVonage($notifiable)
{
    $body=sprintf(
        '%s applied for a job %s',
        $this->freelancer->name,
        $this->proposal->project->title,
    );
    return (new VonageMessage($notifiable))
                ->content($body)
                ->from('15554443333');;


}

   public function toLog($notifiable){

    $body=sprintf(
        '%s applied for a job %s',
        $this->freelancer->name,
        $this->proposal->project->title,
    );

    return $body;
   }

   public function toNepras($notifiable){

    $body=sprintf(
        '%s applied for a job %s',
        $this->freelancer->name,
        $this->proposal->project->title,
    );

    return $body;
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
