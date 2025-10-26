<?php

namespace Lara\Common\Http\Controllers\Setup;

use App\Http\Controllers\Controller;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

use Lara\Common\Http\Controllers\Setup\Concerns\HasSetup;

class SetupController extends Controller
{

	use HasSetup;


	/**
	 * @return Application|Factory|View
	 */
	public function show()
	{

		try {

			DB::connection()->getPdo();

			$dbsuccess = true;

			$dbname = DB::connection()->getDatabaseName();

			$dbmessage = 'Connected to database successfully :';
			$dbmessage .= '<ul>';
			$dbmessage .= '<li>' . $dbname . '</li>';
			$dbmessage .= '</ul>';

		} catch (\Exception $e) {

			$dbsuccess = false;
			$dbmessage = "ERROR: can not connect to the database. Please check your configuration.";

		}

		return view('lara-common::setup.start', [
			'dbmessage' => $dbmessage,
			'dbsuccess' => $dbsuccess,
		]);

	}

	/**
	 * @param int $step
	 * @return Application|Factory|View
	 */
	public function stepshow(int $step)
	{

		$dbname = DB::connection()->getDatabaseName();

		if ($step == 1) {

			return view('lara-common::setup.step', [
				'dbname' => $dbname,
				'step'   => $step,
			]);

		} elseif ($step == 2) {

			$type = session('seeder_type');

			return view('lara-common::setup.step', [
				'dbname' => $dbname,
				'step'   => $step,
				'type'   => $type,
			]);

		} elseif ($step == 3) {

			return view('lara-common::setup.step', [
				'dbname' => $dbname,
				'step'   => $step,
			]);

		} else {

			return view('lara-common::setup.step', [
				'dbname' => $dbname,
				'step'   => 1,
			]);

		}

	}

	/**
	 * @return RedirectResponse
	 */
	public function start()
	{

		flash('Setup has started')->success();

		return redirect()->route('setup.stepshow', ['step' => 1]);

	}

	/**
	 * @param Request $request
	 * @param int $step
	 * @return \Illuminate\Foundation\Application|RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function stepprocess(Request $request, int $step)
	{

		if ($step == 1) {

			$type = $request->input('seeder_type');
			session(['seeder_type' => $type]);

			$this->migrateFresh($type, $step);

		} elseif ($step == 2) {

			$type = $request->input('seeder_type');
			$this->runSeeders($type, $step);

			// cleanup
			$this->finishSetup($type);

			return redirect('/admin');

		}

		$nextstep = $step + 1;

		return redirect()->route('setup.stepshow', ['step' => $nextstep]);

	}

}

