"use strict";

let map;
async function initMap(latitude, longitude) {

	const { Map } = await google.maps.importLibrary("maps");
	const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

	const myLatLng = { lat: latitude, lng: longitude };
	map = new Map(document.getElementById("map-canvas"), {
		center: myLatLng,
		zoom: 14,
		mapId: '4504f8b37365c3d0',
	});

	const marker = new AdvancedMarkerElement({
		map,
		position: myLatLng,
	});
}

export function toggleMap(latitude, longitude) {

	const canvas = document.querySelector('.js-maps-container');
	const toggleButton = document.querySelector('#map-preview');

	if(canvas) {
		if(canvas.classList.contains('hidden')) {
			canvas.classList.remove('hidden');
			toggleButton.innerHTML = 'Hide Map';
			initMap(latitude, longitude);
		} else {
			canvas.classList.add('hidden');
			toggleButton.innerHTML = 'Preview Map';
		}
	}
}

