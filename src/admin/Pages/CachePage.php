<?php

namespace Lara\Admin\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Panel;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use Lara\Admin\Traits\HasNavGroup;

class CachePage extends Page
{

	use HasNavGroup;

	protected static string|BackedEnum|null $navigationIcon = null;

	protected static ?int $navigationSort = 10;

	protected string $view = 'lara-admin::pages.cache-page';

	public function mount(): void
	{
		abort_unless(Auth::user()->can('view_any_cache'), 403);
	}

	public static function getSlug(?Panel $panel = null): string
	{
		return 'cache';
	}

	public static function getNavigationLabel(): string
	{
		return _q('lara-admin::' . static::getSlug() . '.navigation.label', true);
	}

	public static function getNavigationGroup(): ?string
	{
		return static::getNavGroup('tools');
	}

	public function getTitle(): string | Htmlable
	{
		return 'Cache';
	}



}
