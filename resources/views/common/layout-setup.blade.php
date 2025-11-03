<!DOCTYPE html>
<html>
<head>

	@yield('head-before')

	@include('lara-common::_main.html_header')

	@yield('head-after')

	<style>
		html, body {
			height: 100%;
		}
		.setup-container .card {
			width: 500px;
			max-width: 90%;
			background-color: #fff;
		}
		.setup-container .card .card-body {
			padding:2rem;
		}
		.setup-header {
			margin-bottom: 1rem;
			padding-bottom: 0.5rem;
			border-bottom: 1px solid #dce6f0;
		}
		.setup-content {
			min-height: 150px;
			padding: 1rem;

		}
		.setup-footer {
			margin: 1rem 0;
			padding-top: 1rem;
			border-top: 1px solid #dce6f0;
		}
	</style>

</head>

<body class="" style="background-image: url('/assets/filament/img/auth-bg.jpg')">

<div class="setup-container d-flex justify-content-center align-items-center h-100">

	<div class="card" style="">

		<div class="card-header py-3">
			<h1 class="fs-4 fw-light text-secondary">
				Lara Setup
			</h1>
		</div>

		<div class="card-body">

			@yield('content')

		</div>

	</div>

</div>

@yield('scripts-before')

@include('lara-common::_main.html_footer')

@yield('scripts-after')

</body>
</html>
