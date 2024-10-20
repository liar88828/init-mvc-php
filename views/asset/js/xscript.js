document.addEventListener('DOMContentLoaded', function() {
	fetchUsers();
});

function fetchUsers() {
	fetch('index.php?action=getUsers')
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