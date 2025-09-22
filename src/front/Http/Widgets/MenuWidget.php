<?php

namespace Lara\Front\Http\Widgets;

use Arrilot\Widgets\AbstractWidget;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Lara\Common\Models\Menu;
use Lara\Common\Models\MenuItem;

use Lara\Front\Http\Concerns\hasFrontend;
use Lara\Front\Http\Concerns\HasFrontMenu;
use Lara\Front\Http\Concerns\HasFrontRoutes;

use LaravelLocalization;

class MenuWidget extends AbstractWidget
{

	use hasFrontend;
	use HasFrontMenu;
	use HasFrontRoutes;

	protected $config = [
		'mnu'      => 'main',
		'showroot' => false,
		'grid'     => null,
		'template' => 'menu',
	];

	public $cacheTime = false; // DO NOT CACHE THE MENU !!!

	public function cacheKey(array $params = [])
	{
		return 'lara.widgets.menuWidget.' . $this->config['mnu'];
	}

	/**
	 * @return Application|Factory|View
	 */
	public function run()
	{

		$language = LaravelLocalization::getCurrentLocale();

		$activemenu = $this->getActiveMenuArray(true);

		$menu = Menu::where('slug', $this->config['mnu'])->first();

		if ($menu) {


			if ($this->config['showroot']) {

				// kalnoy/nestedset
				$tree = MenuItem::scoped(['menu_id' => $menu->id, 'language' => $language])
					->defaultOrder()
					->where('publish', 1)
					->where('is_home', 0)
					->get()
					->toTree();

			} else {

				$tree = MenuItem::scoped(['menu_id' => $menu->id, 'language' => $language])
					->defaultOrder()
					->where('publish', 1)
					->get()
					->toTree();
			}

		} else {

			$tree = null;

		}

		$widgetview = '_widgets.' . $this->config['template'] . '.' . $this->config['mnu'];

		if(view()->exists($widgetview)) {

			return view($widgetview, [
				'config'     => $this->config,
				'grid'       => $this->config['grid'],
				'tree'       => $tree,
				'activemenu' => $activemenu,
			]);

		} else {
			$errorView = (config('app.env') == 'production') ? 'not_found_prod' : 'not_found';
			return view('_widgets._error.' . $errorView, [
				'widgetview' => $widgetview,
			]);
		}

	}

}
