export const social_data = {
	apiKey: "AIzaSyAuFMJEjEWySucxpgQfKVGofRCA9rxQVe0",
    authDomain: "educo-login.firebaseapp.com",
    projectId: "educo-login",
    storageBucket: "educo-login.appspot.com",
    messagingSenderId: "514954588660",
    appId: "1:514954588660:web:4a1b52239f858429aa89a1",
    measurementId: "G-SMSFVVETTQ"
};

export const sweet = (res) => {
	var Toast = Swal.mixin({
		toast: false,
		position: 'center',
		showConfirmButton: true
	});
	if (res) {
		Toast.fire({
			icon: 'success',
			title: '😃 Usuario registrado!! 🥳',
			text: 'Ya puedes inicar tu sesión, gracias por registrarte.',
			confirmButtonText: `Genial! 👍`
		});
	}else {
		Toast.fire({
			icon: 'error',
			title: '😦 Usuario no registrado!! 😞',
			text: '¿Ya estas registrado con nosotros? intenta restablecer tu contraseña o verifica los datos y vuelve a intentarlo',
			confirmButtonText: `Ok! 👍`
		});
	}
}

export const log = (result) => {
	let arr_data = new FormData();
    let user = result.user;

    arr_data.append('firelogin', true);
    arr_data.append('email', user.providerData[0].email);

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
    		location.reload();
    	}else {
    		Toast.fire({
				icon: 'error',
				title: '😦 Usuario no registrado!! 😞',
				text: '¿Ya estas registrado con nosotros? intenta restablecer tu contraseña o verifica los datos y vuelve a intentarlo',
				confirmButtonText: `Ok! 👍`
			});
    	}
    });
}

export const register = (result) => {
	let arr_data = new FormData();
    let user = result.user;

    arr_data.append('fireregister', true);
    arr_data.append('name', user.providerData[0].displayName);
    arr_data.append('email', user.providerData[0].email);

    fetch('external_data', {
    	method: 'POST',
    	body: arr_data
    })
    .then(res => res.json())
    .then(data => {
    	sweet(data);
    });
}

export const str_check = (str) => {
	if (str.length > 0) {
		let abc = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyzáéíóúÁÉÍÓÚ ';
		abc = abc.split('');
		str = str.split('');
		let res = true;
		for (var val in str) {
		    if (!abc.includes(str[val])) {
		    	res = false;
		    	break;
		    }
		}
		return res;
	}else {
		return false;
	}
}

export const mail_check = (email) => {
	if (email.length > 0) {
		let abc = 'abcdefghijklmnopqrstuvwxyz1234567890_.-@';
		abc = abc.split('');
		let mail = email.split('');

		let res = true;

		for (var val in mail) {
		    if (!abc.includes(mail[val])) {
		    	res = false;
		    	break;
		    }
		}

		if (res) {
			let arroba = email.indexOf("@");
			if (arroba != -1)
			{
				let dominio = email.substring(email.length,(arroba+1));
				let punto = dominio.indexOf(".");
				return (punto != -1) ? true : false;
			}else {
				return false;
			}
		}else {
			return false;
		}
	}else {
		return false;
	}
}