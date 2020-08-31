<?php

namespace MayIFit\Core\Permission\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use MayIFit\Core\Permission\Models\SystemSetting;

/**
 * Class Passwordreset
 *
 * @package MayIFit\Core\Permission
 */
class PasswordReset extends Notification implements ShouldQueue
{
    use Queueable;

    protected $senderEmail;
    protected $senderName;
    protected $link;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($link)
    {
        $this->link = $link;
        $this->senderEmail = (SystemSetting::where('setting_name', 'shop.emailFrom')->first())->setting_value;
        $this->senderName = (SystemSetting::where('setting_name', 'shop.emailFromName')->first())->setting_value;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(rtrim(config('app.url')) . $this->link);
        return (new MailMessage)
            ->from($this->senderEmail, $this->senderName)
            ->greeting(trans('global.hello'))
            ->line(trans('global.changed_your_password'))
            ->action(trans('action.reset_your_password_here'), $url)
            ->line(trans('global.ignore_if_it_was_not_you'));
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
