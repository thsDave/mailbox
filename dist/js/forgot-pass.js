import {mail_check} from './config.js';

var form = document.getElementById('forgot-form');

$("#mail").keyup(() => {
	let email = document.getElementById('mail').value;
	if (mail_check(email.trim())) {
		$("#mail").removeClass('is-invalid');
		$("#mail").addClass('is-valid');
	}else {
		$("#mail").removeClass('is-valid');
		$("#mail").addClass('is-invalid');
	}
});

form.addEventListener('submit', (e) => {
	e.preventDefault();

	let arr_data = new FormData(form);

	var Toast = Swal.mixin({
		toast: false,
		position: 'center',
		showConfirmButton: true
	});

	let email = arr_data.get('forgot-email');

	if (email == '' || !mail_check(email))
	{
		Toast.fire({
			icon: 'error',
			title: '😯 Error! ☹️',
			text: 'Ingresa un correo electrónico válido',
			confirmButtonText: `De acuerdo 👍`
		});
	}
	else
	{
		fetch('external_data', {
			method: 'POST',
			body: arr_data
		})
		.then(res => res.json())
		.then(data => {
			if (data) {
				Toast.fire({
					icon: 'success',
					title: '😃 Success!! 🥳',
					text: 'Por favor revisa tu correo y sigue las instrucciones.',
					confirmButtonText: `De acuerdo 👍`
				})
				.then(() => {
					let url = window.location;
					window.open(url+'?action=login','_self');
				});
			}else {
				Toast.fire({
					icon: 'error',
					title: '😯 Error! ☹️',
					text: 'Ingresa un correo electrónico válido',
					confirmButtonText: `De acuerdo 👍`
				});
			}
			$('#mail').val('');
		});
	}

});