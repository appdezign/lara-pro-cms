<?php

namespace Lara\Common\Http\Controllers\Auth\Filament;

use Filament\Auth\Pages\Login as BaseAuth;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Panel\Concerns\HasRenderHooks;
use Filament\Schemas\Schema;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;

/**
 * @property Form $form
 */
class Login extends BaseAuth
{

    use HasRenderHooks;

    public function mount(): void
    {
        $this->renderHook(
            PanelsRenderHook::BODY_START,
            fn (): View => view('lara-common::auth.login-background'),
        );
        $this->registerRenderHooks();
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.login' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }

	public function form(Schema $schema): Schema
	{
		return $schema
			->components([
				$this->getLoginFormComponent(),
				$this->getPasswordFormComponent(),
				$this->getRememberFormComponent(),
			]);
	}

    protected function getLoginFormComponent()
    {
        return TextInput::make('login')
            ->label('Login')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    protected function getCredentialsFromFormData(array $data): array
    {
        $login_type = filter_var($data['login'], FILTER_VALIDATE_EMAIL ) ? 'email' : 'name';

        return [
            $login_type => $data['login'],
            'password'  => $data['password'],
        ];
    }

}
