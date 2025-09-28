<?php

return [

	'rich_editor' => [
		'toolbar_buttons' => [
			['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'highlight', 'textColor', 'link'],
			['h1', 'h2', 'h3', 'small', 'alignStart', 'alignCenter', 'alignEnd', 'alignJustify'],
			['blockquote', 'codeBlock', 'horizontalRule', 'bulletList', 'orderedList'],
			['table', 'grid', 'gridDelete', 'attachFiles', 'details', 'customBlocks'],
			['clearFormatting', 'undo', 'redo'],
		],

		'custom_blocks' => [
			Lara\App\Filament\Components\CustomBlocks\Hero2Block::class,
			Lara\Admin\Components\CustomBlocks\HeroBlock::class,

		]
	],


];
