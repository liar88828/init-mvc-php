document.addEventListener('DOMContentLoaded', function() {
	fetchUsers();

	const userForm = document.getElementById('users-form');
	userForm.addEventListener('submit', function(event) {
		event.preventDefault(); // Prevent form submission
		addUser();
	});
});

function fetchUsers() {
	fetch('getUsers') // Use the new route
			.then(response => response.json())
			.then(data => {
				const userList = document.getElementById('users-list');
				userList.innerHTML = '';
				data.forEach(user => {
					const li = document.createElement('li');
					li.textContent = user.name;
					userList.appendChild(li);
				});
			})
			.catch(error => console.error('Error fetching users:', error));
}

function addUser() {
	const nameInput = document.getElementById('name');
	const userName = nameInput.value;

	fetch('addUser', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json'
		},
		body: JSON.stringify({ name: userName })
	})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					fetchUsers(); // Refresh users list
					nameInput.value = ''; // Clear input
				} else {
					console.error('Error adding users:', data.message);
				}
			})
			.catch(error => console.error('Error:', error));
}