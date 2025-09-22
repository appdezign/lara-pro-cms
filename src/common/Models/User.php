<?php

namespace Lara\Common\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;
use Yebor974\Filament\RenewPassword\Traits\RenewPassword;
use Yebor974\Filament\RenewPassword\Contracts\RenewPasswordContract;

class User extends Authenticatable  implements RenewPasswordContract
{
	use Notifiable;
	use SoftDeletes;
	use HasRoles;
	use RenewPassword;
	use TwoFactorAuthenticatable;

	protected $table = 'lara_auth_users';

    /**
     * @var string[]
     */
	protected $guarded = [
		'id',
		'created_at',
		'updated_at',
		'deleted_at',
	];

	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
		'deleted_at' => 'datetime',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var list<string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array
	{
		return [
			'email_verified_at' => 'datetime',
			'password'          => 'hashed',
		];
	}
}
