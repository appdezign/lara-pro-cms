<?php

namespace Lara\Front\Http\Widgets;

use Arrilot\Widgets\AbstractWidget;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Lara\Common\Models\Menu;
use Lara\Common\Models\MenuItem;

use LaravelLocalization;

class MenuLevelOneWidget extends AbstractWidget
{

	protected $config = [
		'mnu'  => 'main',
		'grid' => null,
	];

	public $cacheTime = false; // do not cache

	public function __construct(array $config = [])
	{
		parent::__construct($config);
	}

	public function cacheKey(array $params = [])
	{
		return 'lara.widgets.menuLevelOneWidget.' . $this->config['mnu'];
	}

	/**
	 * @return Application|Factory|View
	 */
	public function run()
	{

		$language = LaravelLocalization::getCurrentLocale();

		$menu = Menu::where('slug', $this->config['mnu'])->first();

		if ($menu) {

			$menulevelone = MenuItem::scoped(['menu_id' => $menu->id, 'language' => $language])
				->defaultOrder()
				->where('publish', 1)
				->whereNull('parent_id')
				->get()
				->toTree();

		} else {

			$menulevelone = null;

		}

		$widgetview = '_widgets.menu-level-one.' . $this->config['mnu'];

		if(view()->exists($widgetview)) {

			return view($widgetview, [
				'config'       => $this->config,
				'grid'         => $this->config['grid'],
				'menulevelone' => $menulevelone,
			]);

		} else {
			$errorView = (config('app.env') == 'production') ? 'not_found_prod' : 'not_found';
			return view('_widgets._error.' . $errorView, [
				'widgetview' => $widgetview,
			]);
		}

	}

}
