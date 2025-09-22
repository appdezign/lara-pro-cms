<?php

use Illuminate\Support\Facades\Route;

$routeName = Route::currentRouteName();
?>

<x-dynamic-component
	:component="$getFieldWrapperView()"
	:field="$field"
>
	<div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">

		<strong>[{{ $getRecord()->language }}] - {{ $getRecord()->title }}</strong>

		<ul style="list-style:none;">
			@foreach($getRecord()->languageChildren as $child)
				<li class="py-4">
					<a href="{{ route($routeName, ['record' => $child->id]) }}" class="language-version-link">
						[{{ $child->language }}] - {{ $child->title }}
					</a>
				</li>
			@endforeach
		</ul>

	</div>

</x-dynamic-component>
