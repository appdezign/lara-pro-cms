<?php

namespace Lara\Common\Http\Controllers\Setup\Concerns;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait HasSetup
{
	private function laraNeedsSetup() {
		$tablename = config('lara-common.database.ent.entities', 'lara_resource_entities');
		return !Schema::hasTable($tablename) || DB::table($tablename)->count() == 0;
	}
}