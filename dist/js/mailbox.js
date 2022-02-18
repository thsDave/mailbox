$(document).ready(() => {
	$('#init-btns').show();
	$('#qcomplete').hide();
	$('#dcomplete').hide();
	$('#qanonimo').hide();
	$('#danonimo').hide();
});

document.getElementById('qvc').onclick = (e) => {
	$('#init-btns').hide();
   	$('#qcomplete').show();
	$('#dcomplete').hide();
	$('#qanonimo').hide();
	$('#danonimo').hide();
	e.preventDefault();
}

document.getElementById('dvc').onclick = (e) => {
	$('#init-btns').hide();
   	$('#qcomplete').hide();
	$('#dcomplete').show();
	$('#qanonimo').hide();
	$('#danonimo').hide();
	e.preventDefault();
}

document.getElementById('qva').onclick = (e) => {
	$('#init-btns').hide();
   	$('#qcomplete').hide();
	$('#dcomplete').hide();
	$('#qanonimo').show();
	$('#danonimo').hide();
	e.preventDefault();
}

document.getElementById('dva').onclick = (e) => {
	$('#init-btns').hide();
   	$('#qcomplete').hide();
	$('#dcomplete').hide();
	$('#qanonimo').hide();
	$('#danonimo').show();
	e.preventDefault();
}

$('.form-back').click((e) => {
	$('#init-btns').show();
	$('#qcomplete').hide();
	$('#dcomplete').hide();
	$('#qanonimo').hide();
	$('#danonimo').hide();
	e.preventDefault();
});

var Toast = Swal.mixin({
	toast: false,
	position: 'center',
	showConfirmButton: true
});

// ************************************
// Formulario Buzón de quejas completo
// ************************************

var d = new Date();
const date = d.getFullYear() + "-" + (d.getMonth() +1) + "-" + d.getDate();

var qcompleteform = document.getElementById('qcompleteform');

qcompleteform.addEventListener('submit', (e) => {
	e.preventDefault();

	let arr_data = new FormData(qcompleteform);

	arr_data.append('qcompleteform', 'true');
	arr_data.append('date', date);

	var Toast = Swal.mixin({
		toast: false,
		position: 'center',
		showConfirmButton: true
	});

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
				text: 'Tu caso ha sido registrado exitosamente! 👍',
				confirmButtonText: 'Continue..'
			}).then(()=>{
				qcompleteform.reset();
			});
		}else {
			Toast.fire({
				icon: 'error',
				title: '😦 Error! 😞',
				text: 'No se ha podido guardar el caso, verifica los datos e intenta nuevamente.',
				confirmButtonText: 'Continue..'
			});
		}
	});
});

// ************************************
// Formulario Buzón de quejas anonimo
// ************************************

var qanonimoform = document.getElementById('qanonimoform');

qanonimoform.addEventListener('submit', (e) => {
	e.preventDefault();

	let arr_data = new FormData(qanonimoform);

	arr_data.append('qanonimoform', 'true');
	arr_data.append('name', '');
	arr_data.append('email', '');
	arr_data.append('date', date);

	var Toast = Swal.mixin({
		toast: false,
		position: 'center',
		showConfirmButton: true
	});

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
				text: 'Tu caso ha sido registrado exitosamente! 👍',
				confirmButtonText: 'Continue..'
			}).then(()=>{
				qanonimoform.reset();
			});
		}else {
			Toast.fire({
				icon: 'error',
				title: '😦 Error! 😞',
				text: 'No se ha podido guardar el caso, verifica los datos e intenta nuevamente.',
				confirmButtonText: 'Continue..'
			});
		}
	});
});

// ************************************
// Formulario Buzón de denuncias completo
// ************************************

var dcompleteform = document.getElementById('dcompleteform');

dcompleteform.addEventListener('submit', (e) => {
	e.preventDefault();

	let arr_data = new FormData(dcompleteform);

	arr_data.append('dcompleteform', 'true');
	arr_data.append('date', date);

	var Toast = Swal.mixin({
		toast: false,
		position: 'center',
		showConfirmButton: true
	});

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
				text: 'Tu denuncia ha sido registrada exitosamente! 👍',
				confirmButtonText: 'Continue..'
			}).then(()=>{
				dcompleteform.reset();
			});
		}else {
			Toast.fire({
				icon: 'error',
				title: '😦 Error! 😞',
				text: 'No se ha podido guardar el caso, verifica los datos e intenta nuevamente.',
				confirmButtonText: 'Continue..'
			});
		}
	});
});

// ************************************
// Formulario Buzón de denuncias anonimo
// ************************************

var danonimoform = document.getElementById('danonimoform');

danonimoform.addEventListener('submit', (e) => {
	e.preventDefault();

	let arr_data = new FormData(danonimoform);

	arr_data.append('danonimoform', 'true');
	arr_data.append('name', '');
	arr_data.append('email', '');
	arr_data.append('date', date);

	var Toast = Swal.mixin({
		toast: false,
		position: 'center',
		showConfirmButton: true
	});

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
				text: 'Tu denuncia ha sido registrada exitosamente! 👍',
				confirmButtonText: 'Continue..'
			}).then(()=>{
				danonimoform.reset();
			});
		}else {
			Toast.fire({
				icon: 'error',
				title: '😦 Error! 😞',
				text: 'No se ha podido guardar el caso, verifica los datos e intenta nuevamente.',
				confirmButtonText: 'Continue..'
			});
		}
	});
});