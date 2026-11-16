<?php

namespace Lara\Front\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Lara\Front\Http\Concerns\HasTheme;
// use Theme;
use Lara\Front\LaraTheme\Theme;

class MailConfirmation extends Mailable
{
    use HasTheme;
    use Queueable, SerializesModels;

    /**
     * @var object
     */
    public $maildata;

    /**
     * MailConfirmation constructor.
     *
     * @return void
     */
    public function __construct(object $maildata)
    {

        $this->maildata = $maildata;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $theme = $this->getFrontTheme();
        $parent = $this->getParentTheme();
        Theme::set($theme, $parent);

        $this->maildata->view = $this->resolveMailView($this->maildata->view);

        if (property_exists($this->maildata, 'attachment') & ! empty($this->maildata->attachment)) {

            $attach = $this->maildata->attachment;

            return $this->from($this->maildata->from->email, $this->maildata->from->name)
                ->subject($this->maildata->subject)
                ->view($this->maildata->view)->attach($attach->filepath, [
                    'as' => $attach->filename,
                    'mime' => $attach->mimetype,
                ]);

        } else {
            return $this->from($this->maildata->from->email, $this->maildata->from->name)
                ->subject($this->maildata->subject)
                ->view($this->maildata->view);
        }

    }

    /**
     * The form's own mail view (email.{resource slug}.confirm|webmaster), or the
     * shared form template (email._templates.form.confirm|webmaster) when the
     * theme has none.
     */
    private function resolveMailView(string $view): string
    {
        if (view()->exists($view)) {
            return $view;
        }

        return 'email._templates.form.'.Str::afterLast($view, '.');
    }
}
