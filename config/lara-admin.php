<?php

use Lara\Admin\Components\CustomBlocks\HeroBlock;
use Lara\App\Filament\Components\CustomBlocks\Hero2Block;

return [

    /*
     * Classes implementing Lara\Admin\Contracts\PanelExtension, which add navigation items
     * and routes to the admin panel (e.g. a site's legacy, non-Livewire admin pages).
     */
    'panel_extensions' => [],

    'filarank' => [
        'section_collapsed' => true,
        'show_in_table' => false,
    ],

    'rich_editor' => [
        'full' => [
            'toolbar_buttons' => [
                ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'highlight', 'textColor', 'link'],
                ['h1', 'h2', 'h3', 'small', 'alignStart', 'alignCenter', 'alignEnd', 'alignJustify'],
                ['blockquote', 'codeBlock', 'horizontalRule', 'bulletList', 'orderedList'],
                ['table', 'grid', 'gridDelete', 'attachFiles', 'attachCuratorMedia', 'details', 'customBlocks'],
                ['clearFormatting', 'undo', 'redo'],
                ['sourceCode', 'fullscreen'],
            ],
        ],
        'minimal' => [
            'toolbar_buttons' => [
                ['bold', 'italic', 'underline', 'strike', 'link'],
                ['clearFormatting', 'undo', 'redo'],
                ['sourceCode', 'fullscreen'],
            ],
        ],

        'custom_blocks' => [
            Hero2Block::class,
            HeroBlock::class,

        ],
    ],

];
