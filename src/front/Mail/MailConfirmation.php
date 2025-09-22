<?php

namespace Lara\Front\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use Lara\Front\Http\Concerns\hasTheme;

// use Theme;
use Qirolab\Theme\Theme;

class MailConfirmation extends Mailable {

	use Queueable, SerializesModels;

	use hasTheme;

	/**
	 * @var object
	 */
	public $maildata;

	/**
	 * MailConfirmation constructor.
	 *
	 * @param object $maildata
	 * @return void
	 */
	public function __construct(object $maildata) {

		// BS5
		$theme = $this->getFrontTheme();
		$parent = $this->getParentTheme();
		Theme::set($theme, $parent);

		$this->maildata = $maildata;

	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {

		if(property_exists($this->maildata, 'attachment') & !empty($this->maildata->attachment)) {

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
}
