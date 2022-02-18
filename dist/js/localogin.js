var form = document.getElementById('form-login');

form.addEventListener('submit', (e) => {
	e.preventDefault();

	let arr_data = new FormData(form);

	arr_data.append('localogin', true);

	fetch('external_data',{
		method: 'POST',
		body: arr_data
	})
	.then(res => res.json())
	.then(data => {
		var Toast = Swal.mixin({
			toast: false,
			position: 'center',
			showConfirmButton: true
		});

		if(data) {
			location.reload();
		} else {
			Toast.fire({
				icon: 'error',
				title: '😦 Fail! 😞',
				text: 'Usuario y/o Contraseña incorrectos',
				confirmButtonText: `Ok! 👍`
			});

			$('#user').val('');
			$('#pwd').val('');
		}
	});
});