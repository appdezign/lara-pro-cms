<?php

namespace Lara\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

use Lara\Admin\Resources\Users\UserResource;

class UserForm
{
	private static function rs(): UserResource
	{
		$class = UserResource::class;
		return new $class;
	}

	public static function configure(Schema $schema): Schema
	{
		return $schema
			->components([
				Section::make('Content')
					->collapsible()
					->columnSpanFull()
					->schema([
						TextInput::make('name')
							->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.name'))
							->required(),
						TextInput::make('email')
							->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.email'))
							->email()
							->required(),
						TextInput::make('password')
							->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.password'))
							->password()
							->maxLength(255)
							->autocomplete('new-password')
							->dehydrateStateUsing(static function ($state, $record) {
								return !empty($state)
									? Hash::make($state)
									: $record->password;
							}),
						Select::make('locale')
							->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.locale'))
							->options([
								'nl' => 'nl',
								'en' => 'en',
							])
							->selectablePlaceholder(false),
						Select::make('roles')
							->label(_q(static::rs()->getModule() . '::' . static::rs()->getSlug() . '.column.roles'))
							->relationship('roles', 'name')
							->multiple()
							->preload(),
					]),
			]);
	}
}
