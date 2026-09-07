<?php

namespace Lara\Admin\Resources\Base\Concerns;

use Closure;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\HtmlString;
use Usamamuneerchaudhary\FilaRank\Analysis\ContentContext;
use Usamamuneerchaudhary\FilaRank\Keyphrase\KeyphraseAnalyzer;
use Usamamuneerchaudhary\FilaRank\SeoAnalyzer;

use Lara\Admin\Resources\Base\Concerns\HasLanguageSection;

/**
 * Drop-in SEO section for any Filament form.
 *
 *   SeoFields::make()                       // assumes `content` + `slug` fields on the parent form
 *   SeoFields::make(contentField: 'body')   // custom rich-editor field name
 *
 * The section binds to the `seo` morphOne relationship provided by the
 * HasSeo trait, and re-analyses live as the user types.
 */
final class HasFilaRankFields
{
	public static function make(
		string $contentField = 'content',
		string $slugField = 'slug',
		string $clanguage = 'abc',
		bool $collapsed = true,
		?Closure $getContentUsing = null,
		?Closure $getSlugUsing = null,
	): Section {
		$content = $getContentUsing ?? fn(Get $get): ?string => $get("../{$contentField}");
		$slug = $getSlugUsing ?? fn(Get $get): ?string => $get("../{$slugField}");

		return Section::make(__('filarank::filarank.section_title'))
			->collapsible()
			->collapsed($collapsed)
			->relationship('seo')
			->schema([
				Tabs::make('seoTabs')
					->contained(false)
					->tabs([

						Tab::make(__('filarank::filarank.tab_preview_analysis'))
							->icon('heroicon-o-chart-bar-square')
							->schema([
								Placeholder::make('serp_preview')
									->label(__('filarank::filarank.serp_preview'))
									->content(fn(Get $get): HtmlString => new HtmlString(
										view('filarank::forms.snippet-preview', [
											'title'       => $get('title'),
											'description' => $get('description'),
											'slug'        => $slug($get),
											'host'        => SeoAnalyzer::siteHost() ?? 'example.com',
										])->render(),
									)),

								Placeholder::make('analysis')
									->label(__('filarank::filarank.analysis'))
									->content(fn(Get $get): HtmlString => new HtmlString(
										view('lara-admin::filarank.forms.analysis', [
											'keyphrases' => (new KeyphraseAnalyzer(SeoAnalyzer::analyzer()))->analyze(
												ContentContext::fromArray([
													'title'               => $get('title'),
													'description'         => $get('description'),
													'focus_keyword'       => $get('focus_keyword'),
													'additional_keywords' => $get('additional_keywords') ?? [],
													'slug'                => $slug($get),
													'content'             => $content($get),
													'is_cornerstone'      => (bool)$get('is_cornerstone'),
													'site_host'           => SeoAnalyzer::siteHost(),
													'language'            => SeoAnalyzer::languages()->get($get('locale')),
												]),
											),
										])->render(),
									)),
							]),

						Tab::make(__('filarank::filarank.tab_keywords_meta'))
							->icon('heroicon-o-tag')
							->schema([
								TextInput::make('focus_keyword')
									->label(__('filarank::filarank.focus_keyword'))
									->live(debounce: 600)
									->maxLength(255),

								TagsInput::make('additional_keywords')
									->label(__('filarank::filarank.additional_keywords'))
									->live()
									->separator(','),

								TextInput::make('title')
									->label(__('filarank::filarank.seo_title'))
									->live(debounce: 600)
									->maxLength(255)
									->hint(fn(Get $get): string => mb_strlen($get('title') ?? '') . ' / 60')
									->hintColor(fn(Get $get): string => match (true) {
										mb_strlen($get('title') ?? '') >= 30 && mb_strlen($get('title') ?? '') <= 60 => 'success',
										mb_strlen($get('title') ?? '') > 0 => 'warning',
										default => 'gray',
									}),

								Textarea::make('description')
									->label(__('filarank::filarank.meta_description'))
									->rows(3)
									->live(debounce: 600)
									->maxLength(500)
									->hint(fn(Get $get): string => mb_strlen($get('description') ?? '') . ' / 156')
									->hintColor(fn(Get $get): string => match (true) {
										mb_strlen($get('description') ?? '') >= 120 && mb_strlen($get('description') ?? '') <= 156 => 'success',
										mb_strlen($get('description') ?? '') > 0 => 'warning',
										default => 'gray',
									}),
							]),

						/*
						Tab::make(__('filarank::filarank.tab_advanced'))
							->icon('heroicon-o-cog-6-tooth')
							->schema([
								Toggle::make('is_cornerstone')
									->label(__('filarank::filarank.cornerstone'))
									->live()
									->inline(false),

								Toggle::make('noindex')
									->label(__('filarank::filarank.noindex'))
									->inline(false),
								TextInput::make('canonical_url')
									->label(__('filarank::filarank.canonical_url'))
									->url()
									->maxLength(255),

								Toggle::make('nofollow')
									->label(__('filarank::filarank.nofollow'))
									->inline(false),


							]),
						*/
					]),
			]);
	}
}
