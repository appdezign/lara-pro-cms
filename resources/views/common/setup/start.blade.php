@extends('lara-common::layout-setup')

@section('content')

		@if($dbsuccess)

			{{ html()->form('POST', route('setup.start'))
				->attributes(['accept-charset' => 'UTF-8'])
				->open() }}

			<h3 class="fs-5 fw-light text-danger">Start</h3>

			<div class="row mb-5">
				<div class="col">
					{{ html()->button('next', 'submit')->id('next-button')->class('btn btn-sm btn-danger next-button float-end')->style(['width' => '100px']) }}
				</div>
			</div>

			<p>{!! $dbmessage !!}</p>

			{{ html()->form()->close() }}

		@else

			<p>{!! $dbmessage !!}</p>

		@endif

@endsection

@section('scripts-after')

	<script type="text/javascript">

		$(document).ready(function () {
			// spinner for save button
			$(".next-button").click(function () {
				$("button.next-button").html('<i class="fa fa-spin fa-circle-o-notch"></i>');
			});
		});

	</script>

@endsection