<?php
namespace Lara\Admin\Livewire;

use Filament\Forms\Components\TextInput;
use Jeffgreco13\FilamentBreezy\Livewire\PersonalInfo;

class LaraProfile extends PersonalInfo
{
	public array $only = ['name', 'email', 'firstname', 'middlename', 'lastname'];

	// You can override the default components by returning an array of components.
	protected function getProfileFormComponents(): array
	{
		return [
			$this->getNameComponent(),
			$this->getEmailComponent(),
			$this->getFirstNameComponent(),
			$this->getMiddleNameComponent(),
			$this->getLastNameComponent(),
		];
	}


	protected function getFirstNameComponent(): TextInput
	{
		return TextInput::make('firstname')
			->label(_q('lara-admin::users.column.firstname'));
	}

	protected function getMiddleNameComponent(): TextInput
	{
		return TextInput::make('middlename')
			->label(_q('lara-admin::users.column.middlename'));
	}

	protected function getLastNameComponent(): TextInput
	{
		return TextInput::make('lastname')
			->label(_q('lara-admin::users.column.lastname'));
	}

}