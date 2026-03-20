<?php

namespace Lara\Front\Http\Concerns;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\File;
use Lara\Front\Http\Lara\FrontActiveRoute;
use Qirolab\Theme\Theme;

use stdClass;

trait HasFrontView
{

	/**
	 * @param object $entity
	 * @param FrontActiveRoute $activeroute
	 * @return mixed
	 */
	private function getEntityView(object $entity, FrontActiveRoute $activeroute)
	{
		$method = $activeroute->getMethod();

		return $entity->getViews()->where('method', $method)->first();
	}

	/**
	 * Get the view file
	 *
	 * The view file is based on:
	 * - the entity key
	 * - the entity method
	 *
	 * @param object $entity
	 * @param FrontActiveRoute $activeroute
	 * @return string|null
	 */
	private function getFrontViewFile(object $entity, FrontActiveRoute $activeroute)
	{

		$view = $this->getEntityView($entity, $activeroute);

		if($view) {
			$viewfile = $view->filename;
			$viewpath = 'content.' . $entity->getResourceSlug() . '.' . $viewfile;
			$this->checkThemeViewFile($entity, $viewpath);
			return $viewpath;
		} else {
			return null;
		}

	}

	/**
	 * @param object $entity
	 * @param string $viewpath
	 * @return void
	 */
	private function checkThemeViewFile(object $entity, string $viewpath): bool
	{

		$result = false;

		if (config('app.env') != 'production') {
			$ds = DIRECTORY_SEPARATOR;
			$themeBasePath = config('theme.base_path');
			if (!view()->exists($viewpath)) {
				$defaultViewPath = config('theme.parent');
				$clientViewPath = config('theme.active');
				$srcDir = $themeBasePath . $ds . $defaultViewPath . $ds . 'views' . $ds . 'content' . $ds . '_templates' . $ds . $entity->getCgroup();
				$destDir = $themeBasePath . $ds . $clientViewPath . $ds . 'views' . $ds . 'content' . $ds . $entity->getResourceSlug() . $ds;
				$result = File::copyDirectory($srcDir, $destDir);
			}
		}

		return $result;

	}

	/**
	 * Get the default full layout of the theme
	 * from the special layout xml file
	 *
	 * The layout that is returned only contains
	 * the default options for the partials
	 *
	 * @return stdClass
	 */
	private function getDefaultThemeLayout()
	{

		$layoutPath = Theme::path('views') . '/_layout/_layout.xml';
		$partials = simplexml_load_file($layoutPath);

		$layout = new stdClass;

		foreach ($partials as $partial) {

			$partial_key = $partial->key;

			foreach ($partial->items->item as $item) {
				if ($item->isDefault == 'true') {
					if ($item->partialFile == 'hidden') {
						$layout->$partial_key = false;
					} else {
						$layout->$partial_key = (string)$item->partialFile;
					}
				}
			}
		}

		return $layout;

	}

	/**
	 * Get the grid for this layout
	 *
	 * @param object $layout
	 * @return stdClass
	 */
	private function getGrid(object $layout)
	{
		$platform = config('lara-front.lara_front_platform');

		if($platform == 'tailwind') {
			return $this->getTailwindGrid($layout);
		} elseif($platform == 'bootstrap') {
			return $this->getBootstrapGrid($layout);
		} else {
			return null;
		}
	}

	private function getTailwindGrid(object $layout) {

		$grid = new stdClass;

		// default values
		$grid->module = 'lara-section';
		$grid->container = 'container';

		$grid->hasSidebar = 'has-no-sidebar';
		$grid->hasSidebarLeft = false;
		$grid->leftCols = 'hidden';
		$grid->hasSidebarRight = false;
		$grid->rightCols = 'hidden';

		$grid->contentCols = 'col-span-12';

		$grid->gridColumns = 'col-span-12';

		if (str_starts_with($layout->content, 'boxed')) {

			// boxed
			$grid->container = 'container';

			list($boxed, $sidebar, $type, $cols) = explode('_', $layout->content);

			$colcount = (int)$cols;

			if ($sidebar == 'default') { // no sidebar

				if ($type == 'col') {
					if($colcount == 12) {
						$grid->gridColumns = 'col-span-12';
					} elseif($colcount == 10) {
						$grid->gridColumns = 'responsive-col-span-10';
					} elseif($colcount == 8) {
						$grid->gridColumns = 'responsive-col-span-8';
					} elseif($colcount == 6) {
						$grid->gridColumns = 'responsive-col-span-6';
					}
				}

			} elseif ($sidebar == 'sidebar') {

				$grid->hasSidebar = 'has-sidebar';

				if ($type == 'left') {

					$grid->hasSidebarLeft = true;
					$grid->leftCols = 'lg:col-span-' . $cols;

					$contentcols = 12 - $colcount;
					$grid->contentCols = 'col-span-12 lg:col-span-' . $contentcols;

					$grid->gridColumns = 'col-span-12';

				} elseif ($type == 'right') {

					$grid->hasSidebarRight = true;
					$grid->rightCols = 'col-span-12 lg:col-span-' . $cols;

					$contentcols = 12 - $colcount;
					$grid->contentCols = 'col-span-12 lg:col-span-' . (string)$contentcols;

					$grid->gridColumns = 'col-span-12';

				} elseif ($type == 'leftright') {
					// two sidebars

					$grid->hasSidebarLeft = true;
					$grid->leftCols = 'col-span-12 lg:col-span-' . $cols;

					$grid->hasSidebarRight = true;
					$grid->rightCols = 'col-span-12 lg:col-span-' . $cols;

					$contentcols = 12 - (2 * $colcount);
					$grid->contentCols = 'col-span-12 lg:col-span-' . (string)$contentcols;

					$grid->gridColumns = 'col-span-12';

				} else {
					//
				}

			} else {
				// default
				$grid->gridColumns = 'col-span-12';
			}

		} elseif (str_starts_with($layout->content, 'full')) {

			// full width
			$grid->container = 'container-fluid';
			$grid->gridColumns = 'col-span-12';

		} else {

			// default
			$grid->container = 'container';
			$grid->gridColumns = 'col-span-12';
		}

		return $grid;
	}

	private function getBootstrapGrid(object $layout) {

		$grid = new stdClass;

		// default values
		$grid->module = 'module-sm';
		$grid->container = 'container';

		$grid->hasSidebar = 'has-no-sidebar';
		$grid->hasSidebarLeft = false;
		$grid->leftCols = 'hidden';
		$grid->hasSidebarRight = false;
		$grid->rightCols = 'hidden';

		$grid->contentCols = 'col-sm-12';

		$grid->gridColumns = 'col-12';

		if (str_starts_with($layout->content, 'boxed')) {

			// boxed
			$grid->container = 'container';

			list($boxed, $sidebar, $type, $cols) = explode('_', $layout->content);

			$colcount = (int)$cols;

			if ($sidebar == 'default') {

				if ($type == 'col') {

					$gridcols = 'col-lg-' . $cols;

					if ($colcount < 12) {
						$offset = (12 - $colcount) / 2;
						$offsetcols = ' offset-lg-' . $offset;
					} else {
						$offsetcols = '';
					}

					if ($colcount == 8 && $offset == 2) {
						$grid->gridColumns = 'col-xl-' . $colcount . ' offset-xl-' . $offset . ' col-lg-10 offset-lg-1';
					} else {
						$grid->gridColumns = $gridcols . $offsetcols;
					}

				}

			} elseif ($sidebar == 'sidebar') {

				$grid->hasSidebar = 'has-sidebar';

				if ($type == 'left') {

					$grid->hasSidebarLeft = true;
					$grid->leftCols = 'col-lg-' . $cols;

					$contentcols = 12 - $colcount;
					$grid->contentCols = 'col-lg-' . $contentcols;

					$grid->gridColumns = 'col-12';

				} elseif ($type == 'right') {

					$grid->hasSidebarRight = true;
					$grid->rightCols = 'col-lg-' . $cols;

					$contentcols = 12 - $colcount;
					$grid->contentCols = 'col-lg-' . (string)$contentcols;

					$grid->gridColumns = 'col-12';

				} elseif ($type == 'leftright') {
					// two sidebars

					$grid->hasSidebarLeft = true;
					$grid->leftCols = 'col-lg-' . $cols;

					$grid->hasSidebarRight = true;
					$grid->rightCols = 'col-lg-' . $cols;

					$contentcols = 12 - (2 * $colcount);
					$grid->contentCols = 'col-lg-' . (string)$contentcols;

					$grid->gridColumns = 'col-12';

				} else {
					//
				}

			} else {
				// default
				$grid->gridColumns = 'col-12';
			}

		} elseif (substr($layout->content, 0, 4) == 'full') {

			// full width
			$grid->container = 'container-fluid';
			$grid->gridColumns = 'col-12';

		} else {

			// default
			$grid->container = 'container';
			$grid->gridColumns = 'col-12';
		}

		return $grid;
	}




	private function getGridVars($entity)
	{

		$varsFile = null;

		foreach (Theme::getViewPaths() as $themePath) {
			$gridVarsFile = $themePath . '/_grid/vars.php';
			if (file_exists($gridVarsFile)) {
				$varsFile = $gridVarsFile;
			}
		}

		return $varsFile;

	}

	/**
	 * @param $entity
	 * @return string|null
	 */
	private function getGridOverride($entity, FrontActiveRoute $activeroute)
	{

		$override = null;

		foreach (Theme::getViewPaths() as $themePath) {
			$entityPath = $themePath . '/content/' . $entity->getResourceSlug();
			$gridFile = $entityPath . '/' . $activeroute->getMethod() . '/_grid/vars.php';
			if (file_exists($gridFile)) {
				$override = $gridFile;
				break;
			}
		}

		return $override;

	}

	/**
	 * Get the custom layout for the current object
	 * The custom layout can override the default layout settings
	 *
	 * @param object $object
	 * @param object|null $params
	 * @return stdClass
	 */
	private function getObjectThemeLayout(object $object, ?object $params = null)
	{

		$layoutPath = Theme::path('views') . '/_layout/_layout.xml';
		$partials = simplexml_load_file($layoutPath);

		$layout = new stdClass;

		foreach ($partials as $partial) {

			$partial_key = (string)$partial->key;

			$found = false;

			// get custom layout value from database
			if ($object->layout) {
				$item = $object->layout;
				if(!empty($item->$partial_key)) {
					if ($item->$partial_key == 'hidden') {
						$layout->$partial_key = false;
					} else {
						$layout->$partial_key = $item->$partial_key;
					}
					$found = true;
				}
			}

			if (!$found) {
				// get default value from layout XML
				foreach ($partial->items->item as $item) {
					if ($item->isDefault == 'true') {
						if ((string)$item->partialFile == 'hidden') {
							$layout->$partial_key = false;
						} else {
							$layout->$partial_key = (string)$item->partialFile;

						}
					}
				}
			}

		}

		if (!empty($params) && $params->getShowTags() == 'filterbytaxonomy') {
			// force left sidebar for tag menu
			$layout->content = 'boxed_sidebar_left_3';
		}

		return $layout;

	}

}
