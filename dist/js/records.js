function getrecord(id, action) {

	$.ajax({
		type: 'post',
		url: 'internal_data',
		dataType: 'json',
		data: 'get_info_record=&id='+id
	}).done(function(data){
    switch (action) {
    	case 'info':
        $('#info-record').modal('show');
        $('#info-name').val(data.name);
        $('#info-region').val(data.region);
        $('#info-email').val(data.email);
        $('#info-subject').val(data.subject);
        $('#info-caso').val(data.casename);
        $('#info-mnsj').val(data.message);
    	break;

      case 'open_profile':
        window.open('<?= URL ?>'+'?req=profile','_self');
      break;
    }
  });
}