<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Activation;

class ActivationCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected $activation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Activation $activation)
    {
        $this->activation = $activation;
    }

    /**
     * メール認証にて、メール本文に付与する確認用URL情報を設定
     *
     * @return $this
     */
    public function build()
    {
        $appUrl = config('app.url');
        
        return $this->markdown('emails.activations.created')
            ->with([
                'url' => $appUrl . "/register/verify?code={$this->activation->code}",
                'user_name' => $this->activation->user_name,
            ]);
    }
}
