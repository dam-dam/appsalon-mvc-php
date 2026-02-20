let paso= 1;
const pasoInicial= 1;
const pasoFianl= 3;

const cita = {
    id: "",
    nombre: "",
    fecha: "",
    hora:"",
    servicios:[]

}

document.addEventListener("DOMContentLoaded", function(){
    iniciarApp();
});

function iniciarApp(){
    mostrarSeccion();//muestra y oculta las secciones
    tabs(); //cambia la seccion cuando se precione los tabs
    botonesPaginador(); //Agrega o quita los botones del paginador
    paginaSiguiente();
    paginaAnterior();

    idCliente(); 
    consultarAPI(); //consulta la API en el backend de PHP
    nombreCliente(); //añade el nombre del cliente al objeto  de cita
    seleccionarFecha(); //añade fecha a la cita
    seleccionarHora(); //añade la hora

    mostrarResumen(); //muestra el resumen de la cita
}

function mostrarSeccion(){
    //ocultar la seccion anterios
    const seccionAnterior= document.querySelector(".mostrar")
    if(seccionAnterior){
        seccionAnterior.classList.remove("mostrar")
    }
    //seleccionar la seccion con el paso...
    const seccion = document.querySelector(`#paso-${paso}`);
    seccion.classList.add("mostrar");

    //qutamos el tab anterios
    const tabAnterior= document.querySelector(".actual");
    if(tabAnterior){
        tabAnterior.classList.remove("actual");
    }

    //resalta el tab actual
    const tabActual = document.querySelector(`[data-paso="${paso}"]`);
    tabActual.classList.add("actual");

    
}

function tabs(){
    const botones = document.querySelectorAll(".tabs button");
    botones.forEach(boton =>{
        boton.addEventListener("click", function(e){
            paso =(parseInt(e.target.dataset.paso));

            mostrarSeccion();
            botonesPaginador();
        })
    });

}

function botonesPaginador(){
    const paginaAnterior= document.querySelector("#anterior");
    const paginaSiguiente = document.querySelector("#siguiente");

    if(paso === 1){
        paginaAnterior.classList.add("ocultar");
        paginaSiguiente.classList.remove("ocultar");
    }else if(paso === 3){
        paginaAnterior.classList.remove("ocultar");
        paginaSiguiente.classList.add("ocultar");
    }else{
        paginaAnterior.classList.remove("ocultar");
        paginaSiguiente.classList.remove("ocultar");
        mostrarResumen();
    }

    mostrarSeccion();
}

function paginaAnterior(){
    const paginaAnterior = document.querySelector("#anterior")
    paginaAnterior.addEventListener("click", function(){
        if(paso <= pasoInicial){
            return
        }else{
            paso--;
            botonesPaginador();
        }
        
    });

}

function paginaSiguiente(){
    const paginaSiguiente = document.querySelector("#siguiente");
    paginaSiguiente.addEventListener("click", function(){
        if(paso >= pasoFianl){
            return
        }else{
            paso++;
            botonesPaginador();
        }
        
    });

}


async function consultarAPI(){
    try {
        const url = `${location.origin}/api/servicios`
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios){
    servicios.forEach(servicio=>{
        const {id , nombre, precio} = servicio;

        const nombreServicio = document.createElement("P");
        nombreServicio.classList.add("nombre-servicio");
        nombreServicio.textContent= nombre;

        const precioServicio = document.createElement("P");
        precioServicio.classList.add("precio-servicio");
        precioServicio.textContent= `$${precio}`;

        const servicioDiv = document.createElement("DIV");
        servicioDiv.classList.add("servicio");
        servicioDiv.dataset.idServicio= id;
        servicioDiv.onclick = function(){
            seleccionarServicio(servicio);
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector("#servicios").appendChild(servicioDiv)

        //console.log(servicioDiv) //mostrar todos los servicios
    })

}

function seleccionarServicio(servicio){
    const {id} = servicio
    const{servicios} = cita;

    //identificar al elemento al que se le da click
    const divServicio =document.querySelector(`[data-id-servicio="${id}"]`);    

    //comprobar si un servicio ya fue agregagp o quitarlo
    if(servicios.some(agregado=> agregado.id === servicio.id)){
        //si ya existe, aeliminarlo
        cita.servicios = servicios.filter(agregado=> agregado.id != servicio.id);
        divServicio.classList.remove("seleccionado")

    }else{
        //sino agregarlo
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add("seleccionado")

    }
   //console.log(cita);

}

function idCliente(){
     cita.id = document.querySelector("#id").value;   
}

function nombreCliente(){
    const nombre = document.querySelector("#nombre").value;
    cita.nombre = nombre
    //console.log(nombre)
}
function seleccionarFecha(){
    const inputFecha = document.querySelector("#fecha");
        inputFecha.addEventListener("input", function(e){
            const dia = new Date(e.target.value).getUTCDay() //sabremos que sia de la semana es. Domingo = 0 y asi sucesivamente

            if([6,0].includes(dia)){
                e.target.value = "";
                mostrarMensaje("Sabados y Domingos no abrimos", "error", ".formulario");
                
            }else{
                cita.fecha = e.target.value;
            }
        });

}

function seleccionarHora(){
    const inputHora = document.querySelector("#hora");
    inputHora.addEventListener("input", function(e){

        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];//split separa un string

        if(hora < 10 || hora >18){
            e.target.value= "";
            mostrarMensaje("hora no valida", "error", ".formulario")
        }else{
            cita.hora = e.target.value;
        }

    });
    
}

function mostrarMensaje(mensaje, tipo, elemento, desaparece = true){
    //verificar sii ya exiiiste una alerta
    const alertaPrevia = document.querySelector(".alerta");
    if(alertaPrevia){
        alertaPrevia.remove();
    }

    //agregar alerta
    const alerta = document.createElement("DIV");
    alerta.textContent = mensaje;
    alerta.classList.add("alerta");
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento)
    referencia.appendChild(alerta);

    if(desaparece){
        //eliminar alerta
    setTimeout(()=>{
        alerta.remove();
    }, 3000);

    }else{

    }
    
}
function mostrarResumen(){
    const resumen = document.querySelector(".contenido-resumen");

    //limpiar contenido de resumen
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild)
    }
    
    if(Object.values(cita).includes("") || cita.servicios.length === 0){
        mostrarMensaje("hace falta datos de servivio , fecha u hora", "error", ".contenido-resumen", false);
    }

     //formatear el div de resumen
    const{nombre, fecha, hora, servicios} = cita;

    
    //heading para servicios en resumen
    const headingServicios= document.createElement("H3");
    headingServicios.textContent = "Resumen servicios"
    resumen.appendChild(headingServicios);

    //iterando y mostrando servicios
    servicios.forEach(servicio=>{
        const{id, nombre, precio} = servicio;

        const contenedorServicio = document.createElement("DIV");
        contenedorServicio.classList.add("contenedor-servicio");

        const textoServicio = document.createElement("P");
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement("P");
        precioServicio.innerHTML = `<span>Precio: </span> $${precio}`

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);

    })

     //heading para servicios en resumen
    const headingCliente= document.createElement("H3");
    headingCliente.textContent = "Resuen Cliente"
    resumen.appendChild(headingCliente);


    const nombreCliente= document.createElement("P");
    nombreCliente.innerHTML = `<span>Nombre: </span> ${nombre}`;

    //formatear la fecha en español
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate();
    const year = fechaObj.getFullYear();

    const fechaUTC= new Date(Date.UTC(year, mes, dia));

    const opciones= {weekday: "long", year: "numeric", month: "long", day: "numeric"}
    const fechaFormateada = fechaUTC.toLocaleDateString("es-MX", opciones);


    const fechaCliente= document.createElement("P");
    fechaCliente.innerHTML = `<span>Fecha: </span> ${fechaFormateada}`;

    const horaCliente= document.createElement("P");
    horaCliente.innerHTML = `<span>Hora: </span> ${hora}`;

    const botonReservar = document.createElement("BUTTON");
    botonReservar.classList.add("boton");
    botonReservar.textContent= "Reservar Cita";
    botonReservar.onclick = reservarCita;
   

   

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCliente);
    resumen.appendChild(horaCliente);
    
    resumen.appendChild(botonReservar);
}

async function reservarCita(){

    const{id,nombre, fecha, hora, servicios} = cita;

    //iterar sobre los id de los servicios para agegar el id a la bd
    const idServicios = servicios.map(servicio=> servicio.id)
    //console.log(idServicios)
    

    const datos = new FormData();
    //datos.append("nombre", nombre);
    datos.append("usuarioId", id);
    datos.append("fecha", fecha);
    datos.append("hora", hora);
    datos.append("servicios", idServicios);



   // console.log([...datos])

   try {
    
    //peticion hacia la API
    const url = `${location.origin}/api/citas`

    const respuesta = await fetch(url, {
        method:"POST",
        body: datos
    });
    
    const resultado = await respuesta.json();
    if(resultado.resultado){
        Swal.fire({
        icon: "success",
        title: "Cita creada",
        text: "Tu cita fue creada correctamente",
        confirmButtonColor: "#03b3ff",
        confirmButtonText:"OK"
         //footer: '<a href="#">Why do I have this issue?</a>'
        }).then(()=>{
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        });
    }
    
   } catch (error) {
        Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Hubo un error al guardar a cita",
        //footer: '<a href="#">Why do I have this issue?</a>'
    });
    
   }
}