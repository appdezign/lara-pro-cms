<?php
use Illuminate\Support\Str;
use Lara\Common\Models\Setting;

$companyName = Setting::where('key', 'company_name')->value('value');

?>
@if($getRecord()->opengraph)
	<div class="og-preview">

		@if($getRecord()->hasOpenGraphImage())
			<img src="{{ glideUrl($getRecord()->ogimage->path, 1200, 630) }}" />
		@elseif($getRecord()->hasFeatured())
			<img src="{{ glideUrl($getRecord()->featured()->path, 1200, 630) }}" />
		@else
			<img src="https://dummyimage.com/1200x630/e8ecf0/d4d8dc?text=OG Preview"
		@endif

		<div class="og-preview-content">

			<div class="og-preview-sitename">
				{{ $companyName }}
			</div>

			<h3 class="og-preview-title font-semibold">
				@if($getRecord()->opengraph && !empty($getRecord()->opengraph->og_title))
					{{ $getRecord()->opengraph->og_title }}
				@else
					{{ $getRecord()->title }}
				@endif
			</h3>

			<div class="og-preview-text">
				@if($getRecord()->opengraph && !empty($getRecord()->opengraph->og_description))
					{{ $getRecord()->opengraph->og_description }}
				@elseif(!empty($getRecord()->lead))
					{{ Str::limit(strip_tags($getRecord()->lead), 300) }}
				@elseif(!empty($getRecord()->body))
					{{ Str::limit(strip_tags($getRecord()->body), 300) }}
				@else
					(no description available)
				@endif
			</div>

		</div>
	</div>
@endif


