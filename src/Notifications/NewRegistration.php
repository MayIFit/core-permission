<?php

namespace MayIFit\Core\Permission\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use MayIFit\Core\Permission\Models\SystemSetting;

/**
 * Class NewRegistration
 *
 * @package MayIFit\Core\Permission
 */
class NewRegistration extends Notification implements ShouldQueue
{
    use Queueable;

    protected $senderEmail;
    protected $senderName;
    private $registeredEmail;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($email) {
        $this->registeredEmail = $email;
        $this->senderEmail = (SystemSetting::where('setting_name', 'shop.emailFrom')->first())->setting_value;
        $this->senderName = (SystemSetting::where('setting_name', 'shop.emailFromName')->first())->setting_value;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        return (new MailMessage)
            ->from($this->senderEmail, $this->senderName)
            ->greeting(trans('global.hello'))
            ->line(trans('global.new_user').": ".$this->registeredEmail)
            ->salutation(trans('global.regards').' '.config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
            //
        ];
    }
}