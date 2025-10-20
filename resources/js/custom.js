document.addEventListener('alpine:init', () => {

	navGroups = document.querySelectorAll('.fi-sidebar-group.fi-collapsible');
	navGroups.forEach(navGroup => {
		navGroup.addEventListener('mouseup', (e) => {
			let listItem = e.target.closest('li');

			if (listItem.classList.contains('fi-sidebar-item')) {
				// submenu item is clicked
				let parentListItem = listItem.closest('.fi-sidebar-group');
				parentLabel = parentListItem.dataset.groupLabel;
				if (!parentLabel) {
					// root item is clicked
					setTimeout(() => {
						collapseAllGroups('root');
					}, "100");
				}
			}

			if (listItem.classList.contains('fi-sidebar-group')) {
				// main group is clicked
				collapsingLabel = listItem.dataset.groupLabel;
				setTimeout(() => {
					collapseAllGroups(collapsingLabel);
				}, "100");
			}
		})
	})

});

function collapseAllGroups(collapsingLabel) {

	if (collapsingLabel) {

		// get all labels
		let labels = [];
		listItems = document.querySelectorAll('.fi-sidebar-group.fi-collapsible');
		listItems.forEach(listItem => {
			navLabel = listItem.dataset.groupLabel;
			if (navLabel) {
				labels.push(navLabel);
			}
		});

		if (collapsingLabel == 'root' || labels.includes(collapsingLabel)) {
			sidebar = (Alpine.store('sidebar'));
			labels.forEach(label => {
				if (label != collapsingLabel) {
					sidebar.collapseGroup(label);
				}
			});
		}
	}
}



