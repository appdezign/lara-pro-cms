{{ html()->form('POST', route('setup.stepprocess', ['step' => $step]))
	->attributes(['accept-charset' => 'UTF-8'])
	->open() }}

<div class="setup-header">
	<h3 class="fs-5 fw-light text-danger">Step 1 - Migrate Database</h3>
</div>
<div class="setup-content">
	<label for="seeder_type">Select Content</label>
	<select name="seeder_type" class="form-select" style="width: 200px;" >
		<option value="essential" selected>Essential</option>
		<option value="demo">Full Demo</option>
	</select>
</div>
<div class="setup-footer text-end">
	{{ html()->button('next', 'submit')->id('next-button')->class('btn btn-sm btn-danger next-button float-end')->style(['width' => '100px']) }}
</div>

{{ html()->form()->close() }}