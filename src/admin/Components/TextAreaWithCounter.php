<?php

namespace Lara\Admin\Components;

use Filament\Forms\Components\Textarea;

use Lara\Admin\Components\Concerns\HasCharacterLimit;

class TextAreaWithCounter extends Textarea
{

	use HasCharacterLimit;

	protected string $view = 'lara-admin::components.textarea-with-counter';

}