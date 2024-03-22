//taer los datos de los formularios
const formulario = document.getElementById('formulario');
const inputs = document.querySelectorAll('#formulario input');

//son las limitaciones o condiciones que tiene cada espacio o cada input
const expresiones = {
	nuevo_id: /^\d{7,11}$/, 
	nuevo_nom: /^[a-zA-ZÀ-ÿ\s]{15,40}$/, 
	nueva_edad: /^\d{3}$/,
	nueva_eps: /^[a-zA-ZÀ-ÿ\s]{15,40}$/, 
    nuevo_sexo: /^\d{1}$/,
    nueva_desc: /^\d{10,500}$/,
	
}
//evita que se puedan enviar datos falsos o vacios, solo se ponen true cuando se cumplan las anteriores condiciones
const campos = {
	nuevo_id: false,
	nuevo_nom: false,
	nueva_edad: false,
	nueva_eps: false,
	nuevo_sexo: false,
    nueva_desc: false
	
}
 //la "e" significa evento
 //
const validarFormulario = (e) => {
	switch (e.target.name) {
		case "nuevo_id":
			validarCampo(expresiones.nuevo_id, e.target, 'nuevo_id');
		break;
		case "nuevo_nom":
			validarCampo(expresiones.nuevo_nom, e.target, 'nuevo_nom');
		break;
		case "nueva_edad":
			validarCampo(expresiones.nueva_edad, e.target, 'nueva_edad');
			
		break;
		
		case "nueva_eps":
			validarCampo(expresiones.nueva_eps, e.target, 'nueva_eps');
		break;
		case "nuevo_sexo":
			validarCampo(expresiones.nuevo_sexo, e.target, 'nuevo_sexo');
		break;
        case "nueva_desc":
            validarCampo(expresiones.nueva_desc, e.target, 'nueva_desc');
        break;
	}
}
//remover advertencias o estilos aplicados por las condiciones dadas(si estas condiciones se cumplen)

const validarCampo = (expresion, input, campo) => {
	if(expresion.test(input.value)){
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('fa-check-circle');
		document.querySelector(`#grupo__${campo} i`).classList.remove('fa-times-circle');
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo');
		campos[campo] = true;
	} else {
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('fa-times-circle');
		document.querySelector(`#grupo__${campo} i`).classList.remove('fa-check-circle');
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo');
		campos[campo] = false;
	}
}



inputs.forEach((input) => {
	input.addEventListener('keyup', validarFormulario);
	input.addEventListener('blur', validarFormulario);
});
//
formulario.addEventListener('submit', (e) => {
	e.preventDefault();
		var id = document.getElementById('nuevo_id').value;
		var nom = document.getElementById('nuevo_nom').value;
		var edad = document.getElementById('nueva_edad').value;
		var eps = document.getElementById('nueva_eps').value;
		var sexo = document.getElementById('nuevo_sexo').value;
		var desc = document.getElementById('nueva_desc').value;
	// aqui se validan si los valores cumplen todas las condiciones y se comparan
	//tambien se muestrasn en consola todos los datos recibidos y se envian a el archivo registro
	const terminos = document.getElementById('terminos');
	if(campos.usuario && campos.nombre && campos.password && campos.correo && campos.telefono  && terminos.checked ){
		//resetea el formulario
		formulario.reset();
		console.log(id);console.log(nom);console.log(edad);console.log(eps);console.log(sexo);console.log(desc);
		$.post ("registro.php?cod=datos",{id: id, nom: nom, edad: edad, eps: eps, sexo: sexo, desc: desc}, function(document){$("#mensaje").html(document);
		
		}),
		
		document.getElementById('formulario__mensaje-exito').classList.add('formulario__mensaje-exito-activo');
		setTimeout(() => {
			document.getElementById('formulario__mensaje-exito').classList.remove('formulario__mensaje-exito-activo');
		}, 5000);

		document.querySelectorAll('.formulario__grupo-correcto').forEach((icono) => {
			icono.classList.remove('formulario__grupo-correcto');
		});
	}
});
