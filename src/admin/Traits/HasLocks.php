<?php

namespace Lara\Admin\Traits;

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

trait HasLocks
{

	private static function lockRecord($record) {
		$record->lockRecord();
	}

	private static function unlockRecord($record) {
		$record->unlockRecord();
	}

	private static function unlockAbandonedObjects()
	{
		$modelClass = static::$resource::getModel();
		static::checkTableLockColumns($modelClass::getTableName());
		$objects = $modelClass::where('locked_by', Auth::user()->id)->get();
		if (!empty($objects)) {
			foreach ($objects as $object) {
				$object->unlockRecord();
			}
		}
	}

	private static function checkRecordLock($record) {
		if($record->isLocked()) {
			Notification::make()
				->title(_q('lara-admin::default.message.record_locked'))
				->warning()
				->send();
			redirect()->route('filament.admin.resources.'.static::getResource()::getSlug().'.index');
		}
	}

	private static function checkTableLockColumns($tablename) {
		if(config('app.env') != 'production') {
			$tablenames = config('lara-common.database');
			if (!Schema::hasColumn($tablename, 'locked_at')) {
				Schema::table($tablename, function ($table) {
					$table->timestamp('locked_at')->nullable();
				});
			}
			if (!Schema::hasColumn($tablename, 'locked_by')) {
				Schema::table($tablename, function ($table)  use ($tablenames)  {
					$table->bigInteger('locked_by')->nullable()->unsigned();
					$table->foreign('locked_by')
						->references('id')
						->on($tablenames['auth']['users'])
						->onDelete('cascade');
				});
			}
		}
	}

}