
function info_record() {
	return $.ajax({
		type: 'post',
		url: 'internal_data',
		dataType: 'json',
		data: 'get_info_record'
	}).done(function(data){
		$('#profile-recorddate').html(data.recorddate);
		$('#profile-name').html(data.name);
		$('#profile-email').html(data.email);
		$('#profile-region').html(data.region);
		$('#profile-subject').html(data.subject);
		$('#profile-casename').html(data.casename);
		$('#profile-type').html(data.type);
		switch (data.idstatus) {
			case "3": //pendiente
				$('#status-box-color').addClass('bg-educodanger text-white');
				$('#open_record').show();
				$('#close_record').hide();
				$('#print_record').hide();
				$('#add_entry').hide();
				$('#entries').hide();
			break;

			case "4": //en proceso
				$('#status-box-color').addClass('bg-warning');
				$('#open_record').hide();
				$('#close_record').show();
				$('#print_record').hide();
				$('#add_entry').show();
				$('#entries').show();
				info_entries();
			break;

			case "5": //finalizada
				$('#status-box-color').addClass('bg-educodark text-white');
				$('#open_record').hide();
				$('#close_record').hide();
				$('#print_record').show();
				$('#add_entry').hide();
				$('#entries').show();
				info_entries();
			break;

			default:
				$('#status-box-color').addClass('bg-black text-white');
				$('#open_record').hide();
				$('#close_record').hide();
				$('#print_record').hide();
				$('#add_entry').hide();
				$('#entries').hide();
			break;
		}
		$('#profile-status').html(data.status);
		$('#profile-message').html(data.message);
		$('#profile-useropen').html(data.useropen);
		$('#profile-userclose').html(data.userclose);

		// Encabezado de seccion de entradas

		$('#profile-opendate').html('<strong>'+data.opendate+'</strong>');
		$('#profile-closedate').html('<strong>'+data.closedate+'</strong>');
	});
}

function info_entries() {
	return $.ajax({
		type: 'post',
		url: 'internal_data',
		dataType: 'json',
		data: 'get_entries'
	}).done(function(data){
		$('#entries').html(data);
	});
}

function getentry(id) {
	$.ajax({
		type: 'post',
		url: 'internal_data',
		dataType: 'json',
		data: 'get_entry=&id='+id
	}).done(function(data){
		if (data) {
			$('#edit-entry-modal').modal('show');
	        $('#entry-title').val(data.title);
	        $('#entry-desc').val(data.desc);
	        $('#entry-id').val(data.identry);
		}else {
			Swal.fire('No se logró obtener información de la entrada', '', 'error');
		}
  });
}

function delentry(id) {
	var Toast = Swal.mixin({
		toast: false,
		position: 'center',
		showConfirmButton: true
	});

	Toast.fire({
		icon: 'info',
		title: '¿Estás seguro de eliminar esta entrada?',
		html: '<p>Esta acción <strong>no podrá revertirse!</strong></p>',
		showDenyButton: true,
		showCancelButton: true,
		confirmButtonText: 'Eliminar entrada',
		denyButtonText: `No eliminar entrada`,
		cancelButtonText: 'Cancelar'
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				type: 'post',
				url: 'internal_data',
				data: 'del_entry&id='+id
			}).done(function(data){
				if (data)
					Swal.fire('La entrada ha sido eliminada!', '', 'success').then(()=>{
						info_record();
					});
				else
					Swal.fire('La entrada no pudo ser eliminada, intenta nuevamente.', '', 'error');
			});
		} else if (result.isDenied) {
			Swal.fire('La entrada no será eliminada.', '', 'info');
		}
	});
}

$(document).ready(function(){

	info_record();

	var d = new Date();

	const date = d.getFullYear() + "-" + (d.getMonth() +1) + "-" + d.getDate();

	// Abrir record

	$('#open_record').click(()=>{
		var Toast = Swal.mixin({
			toast: false,
			position: 'center',
			showConfirmButton: true
		});

		Toast.fire({
			icon: 'info',
			title: '¿Estás seguro de abrir el caso?',
			html: '<p style="text-align: justify;">Al abrir el caso, el comité de seguimiento <strong>será responsable</strong> de llevar el proceso hasta su resolución dejando constancia en las entradas registradas, y de ser necesario adjuntar documentos que respalden los acuerdos de solución.</p>',
			showDenyButton: true,
			showCancelButton: true,
			confirmButtonText: 'Abrir caso',
			denyButtonText: `No abrir caso`,
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: 'post',
					url: 'internal_data',
					data: 'open_record&date='+date
				}).done(function(data){
					if (data)
						Swal.fire('El caso se ha abierto exitosamente!', '', 'success').then(()=>{
							info_record();
						});
					else
						Swal.fire('El caso no pudo ser abierto, intenta nuevamente.', '', 'error');
				});
			} else if (result.isDenied) {
				Swal.fire('El caso no será abierto', '', 'info');
			}
		});
	});

	// Cerrar record

	$('#close_record').click(()=>{
		var Toast = Swal.mixin({
			toast: false,
			position: 'center',
			showConfirmButton: true
		});

		Toast.fire({
			icon: 'info',
			title: '¿Estás seguro de cerrar el caso?',
			html: '<p>Al cerrar el caso, ya no podrás agregar y/o modificar ninguna entrada registrada.</p>',
			showDenyButton: true,
			showCancelButton: true,
			confirmButtonText: 'Cerrar caso',
			denyButtonText: `No cerrar caso`,
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: 'post',
					url: 'internal_data',
					dataType: 'json',
					data: 'close_record&date='+date
				}).done(function(data){
					Swal.fire(data.mnsj, '', data.icon).then(()=>{
						info_record();
					});
				});
			}else if (result.isDenied) {
				Swal.fire('El caso se mantendrá abierto', '', 'info');
			}
		});
	});

	// Agregar entrada

	var newEntryForm = document.getElementById('new_entry');

	newEntryForm.addEventListener('submit', (e) => {
		e.preventDefault();

		let arr_data = new FormData(newEntryForm);

		arr_data.append('new_entry', 'true');
		arr_data.append('date', date);

		var Toast = Swal.mixin({
			toast: false,
			position: 'center',
			showConfirmButton: true
		});

		fetch('internal_data', {
			method: 'POST',
			body: arr_data
		})
		.then(res => res.json())
		.then(data => {
			if (data) {
				Toast.fire({
					icon: 'success',
					title: '😃 Success!! 🥳',
					text: 'Tu entrada ha sido registrada exitosamente! 👍',
					confirmButtonText: 'Continue..'
				}).then(()=>{
					newEntryForm.reset();
					info_record();
				});
			}else {
				Toast.fire({
					icon: 'error',
					title: '😦 Error! 😞',
					text: 'No se ha podido guardar la entrada, verifica los datos e intenta nuevamente.',
					confirmButtonText: 'Continue..'
				});
			}
		});
	});

	// Editar entrada

	var editEntryForm = document.getElementById('edit-entry');

	editEntryForm.addEventListener('submit', (e) => {
		e.preventDefault();

		let arr_data = new FormData(editEntryForm);

		arr_data.append('edit_entry', 'true');
		arr_data.append('date', date);

		var Toast = Swal.mixin({
			toast: false,
			position: 'center',
			showConfirmButton: true
		});

		fetch('internal_data', {
			method: 'POST',
			body: arr_data
		})
		.then(res => res.json())
		.then(data => {
			if (data) {
				Toast.fire({
					icon: 'success',
					title: '😃 Success!! 🥳',
					text: 'Tu entrada ha sido actualizada exitosamente! 👍',
					confirmButtonText: 'Continue..'
				}).then(()=>{
					editEntryForm.reset();
					$('#edit-entry-modal').modal('hide');
					info_record();
				});
			}else {
				Toast.fire({
					icon: 'error',
					title: '😦 Error! 😞',
					text: 'No se ha podido actualizar la entrada, verifica los datos e intenta nuevamente.',
					confirmButtonText: 'Continue..'
				});
			}
		});
	});

	// Eliminar entrada
});