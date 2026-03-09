<?php

use Lara\Common\Models\Entity;

$isIndexMethod = false;
$currentRoute = Route::currentRouteName();
$array = explode('.', $currentRoute);
if (sizeof($array) == 5) {
	if ($array[0] == 'filament'
		&& $array[1] == 'admin'
		&& $array[2] == 'resources'
		&& $array[4] == 'index'
	) {
		$resourceSlug = $array[3];
		$entity = Entity::where('resource_slug', $resourceSlug)->first();
		if($entity) {
			$modelClass = $entity->model_class;
			$objectIds = $modelClass::pluck('id')->toArray();
			$isIndexMethod = true;
		}
	}
}
?>

<?php if ($isIndexMethod) : ?>
<script>
	// this is the index method, so we remove the persistent tabs of the edit method
	let objIds = <?= json_encode($objectIds); ?>;
	objIds.forEach(objId => {
		let item = '<?= $entity->resource_slug; ?>' + '-' + objId + '-tab';
		console.log(item);
		let retrievedObject = localStorage.getItem(item);
		if (retrievedObject) {
			localStorage.removeItem(item);
		}
	});
</script>
<?php endif; ?>


@if(session('laracacheclear'))

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
	        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
	        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<script>

		document.addEventListener("DOMContentLoaded", function () {
			$.ajax({
				url: "/laracache/clear",
				success: function (data) {
					console.log(data.payload);
				}
			}).then(function () {
				return $.ajax({
					url: "/laracache/cache",
					success: function (data) {
						console.log(data.payload);
					}
				})
			});
		});
	</script>
@endif

