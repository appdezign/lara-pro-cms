{{ html()->form('POST', route('setup.stepprocess', ['step' => $step]))
	->attributes(['accept-charset' => 'UTF-8'])
	->open() }}

<div class="setup-header">
	<h3 class="fs-5 fw-light text-danger">Step 3 - Run Seeders</h3>
</div>
<div class="setup-content">
	<label for="seeder_type">Select Seeders</label>
	<input type="hidden" name="seeder_type" value="{{ $type }}">
	<select name="seeder_type" class="form-select" style="width: 200px;" disabled>
		<option value="essential" @if($type == 'essential') selected @endif>Essential</option>
		<option value="demo" @if($type == 'demo') selected @endif>Full Demo</option>
	</select>
</div>
<div class="setup-footer text-end">
	{{ html()->button('next', 'submit')->id('next-button')->class('btn btn-sm btn-danger next-button float-end')->style(['width' => '100px']) }}
</div>

{{ html()->form()->close() }}