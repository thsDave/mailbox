
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
			break;

			case "5": //finalizada
				$('#status-box-color').addClass('bg-educodark text-white');
				$('#open_record').hide();
				$('#close_record').hide();
				$('#print_record').show();
				$('#add_entry').hide();
				$('#entries').show();
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

$(document).ready(function(){
	info_record();
});