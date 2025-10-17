<?php

namespace Lara\Admin\Enums;

use Filament\Support\Contracts\HasLabel;

enum NavGroup: string implements HasLabel
{
	case Root = 'root';
	case Menu = 'menu';
	case Modules = 'modules';
	case Blocks = 'blocks';
	case Forms = 'forms';
	case Tools = 'tools';
	case Seo = 'seo';
	case Users = 'users';
	case Builder = 'builder';

	public function getLabel(): ?string
	{
		return match ($this) {
			self::Root => 'Root',
			self::Menu => 'Menu',
			self::Modules => 'Modules',
			self::Blocks => 'Blocks',
			self::Forms => 'Forms',
			self::Tools => 'Tools',
			self::Seo => 'Seo',
			self::Users => 'Users',
			self::Builder => 'Builder',
		};
	}

	public function getLabelNl(): ?string
	{
		return match ($this) {
			self::Root => 'Root',
			self::Menu => 'Menu',
			self::Modules => 'Modules',
			self::Blocks => 'Blokken',
			self::Forms => 'Formulieren',
			self::Tools => 'Tools',
			self::Seo => 'Seo',
			self::Users => 'Gebruikers',
			self::Builder => 'Builder',
		};
	}

	public function getLabelEn(): ?string
	{
		return match ($this) {
			self::Root => 'Root',
			self::Menu => 'Menu',
			self::Modules => 'Modules',
			self::Blocks => 'Blocks',
			self::Forms => 'Forms',
			self::Tools => 'Tools',
			self::Seo => 'Seo',
			self::Users => 'Users',
			self::Builder => 'Builder',
		};
	}

	public function getIcon(): ?string
	{
		return match ($this) {
			self::Root => null,
			self::Menu => 'bi-menu-button',
			self::Modules => 'bi-box',
			self::Blocks => 'bi-layers',
			self::Forms => 'bi-file-earmark-text',
			self::Tools => 'bi-gear',
			self::Seo => 'bi-bar-chart-line',
			self::Users => 'bi-people',
			self::Builder => 'bi-gear',
		};
	}

	public static function toArray(): array
	{
		$array = [];
		foreach (self::cases() as $case) {
			$array[$case->value] = $case->value;
		}
		return $array;
	}

}
