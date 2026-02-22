<?php

namespace Lara\Front\Http\Widgets;

use Arrilot\Widgets\AbstractWidget;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Lara\Common\Models\Cta;
use Lara\Front\Http\Concerns\HasFrontend;
use Lara\Front\Http\Concerns\HasFrontMenu;

use LaravelLocalization;


class CtaWidget extends AbstractWidget
{
	use HasFrontend;
	use HasFrontMenu;

	protected $config = [
		'hook'     => null,
		'template' => 'default',
		'grid'     => null,
	];

	public $cacheTime = false;

	public function __construct(array $config = [])
	{
		parent::__construct($config);
	}

	public function cacheKey(array $params = [])
	{
		return 'lara.widgets.ctaWidget.' . $this->config['hook'];
	}

	/**
	 * @return Application|Factory|View
	 */
	public function run()
	{

		$language = LaravelLocalization::getCurrentLocale();

		$widgetcta = Cta::langIs($language)->where('hook', $this->config['hook'])->first();

		$eroutes = $this->getMenuEntityRoutes($language);

		// identifier
		$templateFileName = $this->config['template'];

		$widgetview = '_widgets.cta.' . $templateFileName;

		if (view()->exists($widgetview)) {

			return view($widgetview, [
				'config'    => $this->config,
				'grid'      => $this->config['grid'],
				'eroutes'   => $eroutes,
				'widgetcta' => $widgetcta,
			]);

		} else {
			$errorView = (config('app.env') == 'production') ? 'not_found_prod' : 'not_found';

			return view('_widgets._error.' . $errorView, [
				'widgetview' => $widgetview,
			]);
		}

	}

}
