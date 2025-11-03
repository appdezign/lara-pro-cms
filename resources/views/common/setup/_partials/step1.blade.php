{{ html()->form('POST', route('setup.stepprocess', ['step' => $step]))
	->attributes(['accept-charset' => 'UTF-8'])
	->open() }}

<div class="setup-header">
	<h3 class="fs-5 fw-light text-danger">Step 1 - Create Account</h3>
</div>
<div class="setup-content">

	@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<div class="row py-2">
		<div class="col-3">
			user
		</div>
		<div class="col-9">
			superadmin
		</div>
	</div>

	<div class="row py-2">
		<div class="col-3">
			password
		</div>
		<div class="col-9">
			{{ html()->text('password')->class('form-control')->placeholder('password') }}
		</div>
	</div>
</div>
<div class="setup-footer text-end">
	{{ html()->button('next', 'submit')->id('next-button')->class('btn btn-sm btn-danger next-button float-end')->style(['width' => '100px']) }}
</div>

{{ html()->form()->close() }}