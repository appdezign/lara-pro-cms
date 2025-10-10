<?php

namespace Lara\Admin\Providers;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;

use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Vite;

use Lara\Admin\Components\GeoLocationField;
use Lara\Admin\Components\LanguageVersions;
use Lara\Admin\Components\YouTubeField;
use Lara\Admin\Enums\NavGroup;
use Lara\Admin\Fonts\LaraFontProvider;
use Lara\Admin\Http\Middleware\FilamentAuthenticate;
use Lara\Admin\Traits\HasLanguage;
use Lara\Admin\Traits\HasParams;
use Lara\Admin\Widgets\Analytics;
use Lara\Common\Http\Controllers\Auth\Filament\Login;

// use Awcodes\Curator\CuratorPlugin;
use Awcodes\Versions\VersionsPlugin;
use Awcodes\Versions\VersionsWidget;
use BezhanSalleh\GoogleAnalytics\GoogleAnalyticsPlugin;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Kenepa\ResourceLock\ResourceLockPlugin;
use Yebor974\Filament\RenewPassword\RenewPasswordPlugin;

class AdminPanelProvider extends PanelProvider
{
	use HasLanguage;
	use HasParams;

	protected static ?string $clanguage = null;

	public function panel(Panel $panel): Panel
	{
		return $panel
			->default()
			->id('admin')
			->path('admin')
			->login(Login::class)
			->sidebarWidth('16.5rem')
			->breadcrumbs(false)
			->globalSearch(false)
			->darkMode(false)
			->font(
				family: 'Inter',
				provider: LaraFontProvider::class,
			)
			->brandName('Lara 10')
			->navigationGroups(static::getNavigationGroups())
			->discoverResources(in: base_path('laracms/core/src/admin/Resources'), for: 'Lara\\Admin\\Resources')
			->discoverPages(in: base_path('laracms/core/src/admin/Pages'), for: 'Lara\\Admin\\Pages')
			->discoverResources(in: base_path('laracms/app/Filament/Resources'), for: 'Lara\\App\\Filament\\Resources')
			->discoverPages(in: base_path('laracms/app/Filament/Pages'), for: 'Lara\\App\\Filament\\Pages')
			->pages([
				Dashboard::class,
			])
			->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
			->widgets([
				Analytics\LaraSessionsDurationWidget::class,
				Analytics\LaraSessionsByDeviceWidget::class,
				Analytics\LaraPageViewsWidget::class,
				Analytics\LaraVisitorsWidget::class,
				Analytics\LaraSessionsWidget::class,
				Analytics\LaraSessionsByCountryWidget::class,
				Analytics\LaraMostVisitedPagesWidget::class,
				Analytics\LaraTopReferrersListWidget::class,
				VersionsWidget::class,
			])
			->middleware([
				EncryptCookies::class,
				AddQueuedCookiesToResponse::class,
				StartSession::class,
				AuthenticateSession::class,
				ShareErrorsFromSession::class,
				VerifyCsrfToken::class,
				SubstituteBindings::class,
				DisableBladeIconComponents::class,
				DispatchServingFilamentEvent::class,
			])
			->plugins([
				GoogleAnalyticsPlugin::make(),
				VersionsPlugin::make()
					->hasNavigationView(false)
					->widgetColumnSpan('full')
					->widgetSort(99999),
				/*
				CuratorPlugin::make()
					->label('Media')
					->pluralLabel('Media')
					->navigationIcon('heroicon-o-photo')
					->navigationGroup('Content')
					->navigationSort(3),
				*/
				RenewPasswordPlugin::make()
					->passwordExpiresIn(days: 90),
				ResourceLockPlugin::make(),
				BreezyCore::make()
					->enableTwoFactorAuthentication()
					->myProfile(),
			])
			->authMiddleware([
				FilamentAuthenticate::class,
			])
			->viteTheme('laracms/core/resources/css/theme.css', 'assets/admin/build');

	}

	public function boot(): void
	{

		TextInput::configureUsing(function (TextInput $textInput) {
			$textInput->inlineLabel()
				->dehydrateStateUsing(function (?string $state): ?string {
					return is_string($state) ? trim($state) : $state;
				});
		});

		Textarea::configureUsing(function (Textarea $textArea) {
			$textArea->inlineLabel();
		});

		RichEditor::configureUsing(function (RichEditor $editor) {
			$editor->inlineLabel()
				->toolbarButtons(static::getRichEditorToolbarOptions());
		});

		Toggle::configureUsing(function (Toggle $toggle) {
			$toggle->inlineLabel();
		});

		ToggleButtons::configureUsing(function (ToggleButtons $toggleButtons) {
			$toggleButtons->inlineLabel();
		});

		Checkbox::configureUsing(function (Checkbox $checkbox) {
			$checkbox->inlineLabel();
		});

		CheckboxList::configureUsing(function (CheckboxList $checkboxList) {
			$checkboxList->inlineLabel();
		});

		Radio::configureUsing(function (Radio $radio) {
			$radio->inlineLabel();
		});

		Tagsinput::configureUsing(function (Tagsinput $tagsinput) {
			$tagsinput->inlineLabel();
		});

		Select::configureUsing(function (Select $select) {
			$select->inlineLabel()
				->native(false)
				->searchable(true);
		});

		ColorPicker::configureUsing(function (ColorPicker $colorPicker) {
			$colorPicker->inlineLabel();
		});

		DateTimePicker::configureUsing(function (DateTimePicker $dateTimePicker) {
			$dateTimePicker->inlineLabel()
				->seconds(false)
				->extraAttributes(['class' => 'max-w-80']);
		});

		YouTubeField::configureUsing(function (YouTubeField $youtubeField) {
			$youtubeField->inlineLabel();
		});

		GeoLocationField::configureUsing(function (GeoLocationField $geolocationField) {
			$geolocationField->inlineLabel();
		});

		LanguageVersions::configureUsing(function (LanguageVersions $LanguageVersions) {
			$LanguageVersions->inlineLabel();
		});

		Placeholder::configureUsing(function (Placeholder $placeholder) {
			$placeholder->inlineLabel();
		});

		/*
		FileUpload::configureUsing(function (FileUpload $fileUpload) {
			$fileUpload->disk(config('lara.uploads.disk'))
				->imageResizeMode('contain')
				->imageResizeTargetWidth(config('lara.uploads.images.max_width'))
				->imageResizeTargetHeight(config('lara.uploads.images.max_height'))
				->itemPanelAspectRatio('0.75')
				->visibility('public')

			;
		});
		*/

		FilamentColor::register([
			'primary'   => [
				50  => 'rgb(242, 250, 251)',
				100 => 'rgb(230, 244, 248)',
				200 => 'rgb(191, 228, 237)',
				300 => 'rgb(153, 211, 227)',
				400 => 'rgb(77, 179, 205)',
				// 500 => 'rgb(0, 146, 184)',
				500 => 'rgb(0, 131, 166)',
				600 => 'rgb(0, 131, 166)',
				700 => 'rgb(0, 110, 138)',
				800 => 'rgb(0, 88, 110)',
				900 => 'rgb(0, 72, 90)',
				950 => 'rgb(0, 44, 55)',
			],
			'secondary' => [
				50  => 'rgb(246, 247, 248)',
				100 => 'rgb(237, 238, 240)',
				200 => 'rgb(209, 213, 218)',
				300 => 'rgb(181, 187, 195)',
				400 => 'rgb(126, 136, 150)',
				500 => 'rgb(71, 85, 105)',
				600 => 'rgb(64, 77, 95)',
				700 => 'rgb(53, 64, 79)',
				800 => 'rgb(43, 51, 63)',
				900 => 'rgb(35, 42, 51)',
				950 => 'rgb(21, 26, 32)',
			],
			'info'      => [
				50  => 'rgb(244, 248, 253)',
				100 => 'rgb(232, 240, 251)',
				200 => 'rgb(198, 218, 245)',
				300 => 'rgb(163, 195, 239)',
				400 => 'rgb(94, 150, 227)',
				500 => 'rgb(25, 105, 215)',
				600 => 'rgb(23, 95, 194)',
				700 => 'rgb(19, 79, 161)',
				800 => 'rgb(15, 63, 129)',
				900 => 'rgb(12, 51, 105)',
				950 => 'rgb(8, 32, 65)',
			],
			'success'   => [
				50  => 'rgb(242, 250, 249)',
				100 => 'rgb(230, 245, 243)',
				200 => 'rgb(191, 229, 226)',
				300 => 'rgb(153, 213, 208)',
				400 => 'rgb(77, 182, 172)',
				500 => 'rgb(0, 150, 137)',
				600 => 'rgb(0, 135, 123)',
				700 => 'rgb(0, 113, 103)',
				800 => 'rgb(0, 90, 82)',
				900 => 'rgb(0, 74, 67)',
				950 => 'rgb(0, 45, 41)',
			],
			'warning'   => [
				50  => 'rgb(254, 247, 243)',
				100 => 'rgb(253, 238, 231)',
				200 => 'rgb(250, 213, 194)',
				300 => 'rgb(247, 188, 158)',
				400 => 'rgb(240, 138, 85)',
				500 => 'rgb(234, 88, 12)',
				600 => 'rgb(211, 79, 11)',
				700 => 'rgb(176, 66, 9)',
				800 => 'rgb(140, 53, 7)',
				900 => 'rgb(115, 43, 6)',
				950 => 'rgb(70, 26, 4)',
			],
			'danger'    => [
				50  => 'rgb(253, 244, 247)',
				100 => 'rgb(251, 232, 239)',
				200 => 'rgb(245, 198, 215)',
				300 => 'rgb(239, 164, 191)',
				400 => 'rgb(228, 95, 144)',
				500 => 'rgb(216, 27, 96)',
				600 => 'rgb(194, 24, 86)',
				700 => 'rgb(162, 20, 72)',
				800 => 'rgb(130, 16, 58)',
				900 => 'rgb(106, 13, 47)',
				950 => 'rgb(65, 8, 29)',
			],
		]);

		// Replace default icons
		FilamentIcon::register([
			'actions::edit-action'   => 'heroicon-o-pencil-square',
			'actions::view-action'   => 'heroicon-o-eye',
			'actions::delete-action' => 'heroicon-o-trash',
		]);

		// RenderHooks
		FilamentView::registerRenderHook(
			PanelsRenderHook::USER_MENU_BEFORE,
			fn(): View => view('lara-admin::partials.language-switch'),
		);

		FilamentView::registerRenderHook(
			PanelsRenderHook::USER_MENU_BEFORE,
			fn(): View => view('lara-admin::partials.cache'),
		);

		FilamentView::registerRenderHook(
			PanelsRenderHook::USER_MENU_AFTER,
			fn(): View => view('lara-admin::partials.frontend'),
		);

		FilamentView::registerRenderHook(
			PanelsRenderHook::USER_MENU_AFTER,
			fn(): View => view('lara-admin::partials.builder-menu'),
		);

		FilamentView::registerRenderHook(
			PanelsRenderHook::BODY_END,
			fn(): View => view('lara-admin::partials.google-maps'),
		);

		FilamentAsset::register([
			Css::make('lara', Vite::asset('laracms/core/resources/css/lara.scss', 'assets/admin/build'))
		]);

		// JS
		FilamentAsset::register([
			Js::make('custom-script', base_path('laracms/core/resources/js/custom.js')),
		]);

		// Translations
		/*
		$this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', 'lara-admin');
		$this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', 'lara-app');
		$this->loadTranslationsFrom(__DIR__ . '/../Resources/Lang', 'lara-front');
		*/

	}

	private static function getNavigationGroups(): array
	{

		static::setContentLanguage();

		$rows = array();

		foreach (NavGroup::cases() as $navGroup) {

			$rows[] = NavigationGroup::make()
				->label($navGroup->getLabelNl())
				->icon($navGroup->getIcon())
				->collapsed();

			$rows[] = NavigationGroup::make()
				->label($navGroup->getLabelEn())
				->icon($navGroup->getIcon())
				->collapsed();

		}

		return $rows;
	}

	private static function getRichEditorToolbarOptions(): array
	{
		if (!empty(config('lara-admin.rich_editor.toolbar_buttons'))) {
			return config('lara-admin.rich_editor.toolbar_buttons');
		} else {
			// default
			return [
				['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
				['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
				['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
				['table', 'attachFiles'],
				['undo', 'redo'],
			];
		}

	}
}
