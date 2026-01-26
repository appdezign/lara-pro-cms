<?php

namespace Lara\Common\Models\Concerns;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait HasLaraLocks
{
	public function lockRecord()
	{
		$this->attributes['locked_at'] = Carbon::now();
		$this->attributes['locked_by'] = Auth::user()->id;
		$this->save();
	}

	public function unlockRecord()
	{
		$this->attributes['locked_at'] = null;
		$this->attributes['locked_by'] = null;
		$this->save();
	}

	public function isLocked(): bool
	{
		$locked = $this->attributes['locked_by'];
		return !empty($locked) && $locked != Auth::user()->id;
	}
}