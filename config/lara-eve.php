<?php

return [

	'use_tags_for_sorting' => [
		'service' => []
	],

	'override_front_entity_objects' => [
		'event' => [
			'primary_sortfield'    => 'startdate',
			'primary_sortorder'    => 'asc',
			'secondary_sortfield' => 'starttime',
			'secondary_sortorder' => 'asc',
			// 'paginate' => 10,
			// 'limit' => 25,
		]
	],

];
