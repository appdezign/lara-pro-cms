@extends('lara-common::layout-setup')

@section('content')

	<h3 class="fs-5 fw-light text-danger">Step {{ $step }}</h3>

	@includeIf('lara-common::setup._partials.step'.$step)

@endsection

@section('scripts-after')

	<script type="text/javascript">

		$(document).ready(function () {
			// spinner for save button
			$(".next-button").click(function () {
				$("button.next-button").html('<i class="fas fa-circle-notch fa-spin p-0"></i>');
			});
		});

	</script>

@endsection
