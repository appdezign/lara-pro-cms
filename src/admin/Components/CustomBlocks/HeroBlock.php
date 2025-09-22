<?php

namespace Lara\Admin\Components\CustomBlocks;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor\RichContentCustomBlock;

class HeroBlock extends RichContentCustomBlock
{
    public static function getId(): string
    {
        return 'hero';
    }

    public static function getLabel(): string
    {
        return 'Hero';
    }

    public static function configureEditorAction(Action $action): Action
    {
        return $action
            ->modalDescription('Configure the hero block')
	        ->schema([
		        TextInput::make('heading')
			        ->required(),
		        TextInput::make('subheading'),
	        ]);
    }

    public static function toPreviewHtml(array $config): string
    {
        return view('lara-admin::components.custom-blocks.hero.preview', [
	        'heading' => $config['heading'],
	        'subheading' => $config['subheading'] ?? 'Default subheading',
        ])->render();
    }

    public static function toHtml(array $config, array $data): string
    {
        return view('lara-admin::components.custom-blocks.hero.index', [
	        'heading' => $config['heading'],
	        'subheading' => $config['subheading'] ?? 'Default subheading',
        ])->render();
    }
}
