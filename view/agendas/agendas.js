let calendar;
let counter = 1;
let counterpar = 1;
let selectedCategories = [];
let selectedCalendarios = [];
// Crear un objeto Date para obtener la hora actual
const now = new Date();
const currentDate = moment().format('DD/MM/YYYY');
// Obtener horas y minutos
const horas = String(now.getHours()).padStart(2, '0'); // Formatear a 2 dígitos
const minutos = String(now.getMinutes()).padStart(2, '0'); // Formatear a 2 dígitos
const campo1 = document.getElementById('campo1');
const campo2 = document.getElementById('campo2');

async function init(){
    try {
        await Promise.all([ListarCalendarios(), ListaCategorias()]);
        cargarEventos();
    } catch (error) {
        console.error('Error al inicializar:', error);
    }finally {
    }
}
// Inicializar el calendario principal
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');

    // Inicializar el calendario
    calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        initialView: 'timeGridWeek',
        firstDay: 0,
        titleFormat: { // Personalización del formato del título
            year: 'numeric', // Mostrar el año
            month: 'long',   // Mostrar el nombre completo del mes
            day: 'numeric'   // Mostrar los días
        },
        headerToolbar: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },       
        editable: false,
        selectable: false,
       
        
        slotMinTime: '05:00:00', // Hora mínima mostrada
        slotMaxTime: '20:00:00', // Hora máxima mostrada
            slotDuration: '00:30:00', // Intervalos de una hora entre las filas
            slotLabelFormat: {
                hour: 'numeric',
                minute: '2-digit',
                meridiem: 'short' // Muestra AM/PM (para español puedes usar 'h' en lugar de 'numeric')
            },
            allDaySlot: false, // Oculta la fila de 'todo el día'
           
            events: [
                        
                {
                    title: 'CITA 1',
                    start: '2024-10-21T10:30:00',
                    end: '2024-10-21T11:00:00'
                    
                },

                {
                    title: 'DISPONIBLE',
                    start: '2024-10-21T11:15:00',
                    end: '2024-10-21T11:45:00',
                    className: 'event-coral'
                },

                {
                    title: 'CITA 2',
                    start: '2024-10-21T12:00:00',
                    end: '2024-10-21T12:30:00'
                    
                },
                
            ],
        
        

        eventClick: function(info) {
            // Remover cualquier modal previo
            $('.fc-popover.click').remove();
            
            // Crear nuevo modal
            var eventEl = $(info.el);
            var modalHtml = `
                <div class="fc-popover click" style="z-index: 9999;"> <!-- z-index alto -->
                    <div class="fc-header">
                        ${moment(info.event.start).format('dddd • D')}
                        <button type="button" class="cl"><i class="font-icon-close-2"></i></button>
                    </div>
                    <div class="fc-body main-screen">
                        <p>${moment(info.event.start).format('dddd, D YYYY, hh:mma')}</p>
                        <p class="color-blue-grey">Detalles del evento</p>
                        <ul class="actions">
                            <li><a href="#">Más detalles</a></li>
                            <li><a href="#" class="fc-event-action-edit">Editar evento</a></li>
                            <li><a href="#" class="fc-event-action-remove">Eliminar evento</a></li>
                        </ul>
                    </div>
                </div>`;

            // Añadir el modal al DOM
            $('body').append(modalHtml);

            // Posicionar el modal
            var posPopover = function() {
                $('.fc-popover.click').css({
                    left: eventEl.offset().left + eventEl.outerWidth() / 2,
                    top: eventEl.offset().top + eventEl.outerHeight()
                });
            };
            posPopover();

            // Reposicionar al cambiar el tamaño o desplazamiento
            $(window).resize(posPopover);
            $('.fc-scroller, .calendar-page-content, body').scroll(posPopover);

            // Acción para cerrar modal
            $('.fc-popover.click .cl').click(function() {
                $('.fc-popover.click').remove();
            });

            // Acción para editar evento
            $('.fc-event-action-edit').click(function(e) {
                e.preventDefault();
                alert('Editar evento: ' + info.event.title);
                // Aquí puedes agregar lógica para edición de eventos
            });

            // Acción para eliminar evento
            $('.fc-event-action-remove').click(function(e) {
                e.preventDefault();
                if (confirm('¿Seguro que deseas eliminar este evento?')) {
                    info.event.remove();
                    $('.fc-popover.click').remove();
                }
            });
        }
    });

    // Renderizar el calendario
    calendar.render();

// Inicializar el datepicker lateral
    moment.locale('es');
    moment.updateLocale('es', {
        week: {
            dow: 0  // Iniciar la semana el domingo
        }
    });
     
     $('#side-datetimepicker').datetimepicker({
        locale: 'es',
        inline: true,  // Para que aparezca dentro del contenedor
        format: 'DD/MM/YYYY'  // Formato de la fecha
        
    }).on('dp.change', function(e) {
        // Cambiar la vista del calendario a la fecha seleccionada
        calendar.gotoDate(e.date.format('YYYY-MM-DD'));  // Navega a la fecha seleccionada
       
    });

    // Ajuste de tamaño de ventana (para el contenido de la página del calendario)
    (function($, viewport) {
        $(document).ready(function() {
            if (viewport.is('>=lg')) {
                $('.calendar-page-content, .calendar-page-side').matchHeight();
            }
            $(window).resize(
                viewport.changed(function() {
                    if (viewport.is('<lg')) {
                        $('.calendar-page-content, .calendar-page-side').matchHeight({ remove: true });
                    }
                })
            );
        });
    })(jQuery, ResponsiveBootstrapToolkit);    
});


// Inicializar el calendarday
document.addEventListener('DOMContentLoaded', function() {
    var calendarDY = document.getElementById('calendarday');  // Usamos el nuevo id

    // Inicializar FullCalendar
    var calendar2 = new FullCalendar.Calendar(calendarDY, {
        locale: 'es',
        initialView: 'timeGridDay',
        firstDay: 0,
        titleFormat: { // Personalización del formato del título
            year: 'numeric', // Mostrar el año
            month: 'long',   // Mostrar el nombre completo del mes
            day: 'numeric'   // Mostrar los días
        },
        headerToolbar: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },       
        editable: false,
        selectable: false,
       
        
        slotMinTime: '05:00:00', // Hora mínima mostrada
        slotMaxTime: '20:00:00', // Hora máxima mostrada
            slotDuration: '00:30:00', // Intervalos de una hora entre las filas
            slotLabelFormat: {
                hour: 'numeric',
                minute: '2-digit',
                meridiem: 'short' // Muestra AM/PM (para español puedes usar 'h' en lugar de 'numeric')
            },
            allDaySlot: false, // Oculta la fila de 'todo el día'
           
            events: [
                        
                {
                    title: 'CITA 1',
                    start: '2024-10-21T10:30:00',
                    end: '2024-10-21T11:00:00'
                    
                },

                {
                    title: 'DISPONIBLE',
                    start: '2024-10-21T11:15:00',
                    end: '2024-10-21T11:45:00',
                    className: 'event-coral'
                },

                {
                    title: 'CITA 2',
                    start: '2024-10-21T12:00:00',
                    end: '2024-10-21T12:30:00'
                    
                },
                
            ]
    });

    // Renderizar el calendario
    calendar2.render();
     // Usar requestAnimationFrame para asegurar que el segundo calendario se renderice correctamente
     requestAnimationFrame(function() {
        calendar2.updateSize();
    });

   

});

// Boton nuevo
$(document).on("click", "#add-agenda", function () {
    $("#mdltitulo").html("Nueva Tarea"); 

    limpiar();

    // Limpiar el select
    $('#tar_est').empty();
    // Agregar opciones
    const options = [
        { value: 'Nueva', text: 'Nueva' },
        { value: 'En curso', text: 'En curso' }
    ];
    // Agregar todas las opciones a la vez
    options.forEach(option => {
        $('#tar_est').append(new Option(option.text, option.value));
    });

  /* TODO:Mostrar Modal */
    $("#modaltarea").modal("show");

    // Verificar si hay calendarios
    const hayCalendarios = $('#calendarios').children().length > 0;

    // Activar el botón de guardar una vez que el modal esté completamente mostrado
    $('#modaltarea').on('shown.bs.modal', function () {
        if (!hayCalendarios) {
            // Si no hay calendarios, bloquear el botón y mostrar la alerta
            $('#tarea_form').find('button[type="submit"]').prop('disabled', true); // Desactivar el botón de guardar
            swal({
                title: 'No hay calendarios',
                text: 'Por favor, crea primero un calendario.',
                icon: 'warning',
                confirmButtonText: 'Aceptar'
            });
        } else {
            // Si hay calendarios, activar el botón de guardar
            $('#tarea_form').find('button[type="submit"]').prop('disabled', false); // Activar el botón de guardar
        }
    });
});

 // Abrir el modal secundario sin cerrar el modal principal
 document.getElementById('transfer').addEventListener('click', function() {
    $('#modaltransfer').modal('show');
});


$(document).on("click", "#config", function () {
    $("#mdltitconf").html("Configuración de Agendamiento");  

  /* TODO:Mostrar Modal */
    $("#modalconfig").modal("show");   
});


// Botones primarios
document.getElementById('check-toggle-1').addEventListener('change', function() {  
    if (this.checked) {
        campo1.value = "00:00";
        campo2.value = "23:59";
        campo1.disabled = true;  // Bloquear el campo
        campo2.disabled = true;  // Bloquear el campo
        $('#horaini_hidden').val($('#campo1').val()); // Transferir valor al campo oculto
        $('#horafin_hidden').val($('#campo2').val()); // Transferir valor al campo oculto
    } else {
        campo1.disabled = false;  // Desbloquear el campo
        campo2.disabled = false;  // Desbloquear el campo
        campo1.value = `${horas}:${minutos}`; // Establecer la hora actual
        campo2.value = `${horas}:${minutos}`; // Establecer la hora actual
        $('#horaini_hidden').val(''); // Limpiar el valor del campo oculto
        $('#horafin_hidden').val(''); // Limpiar el valor del campo oculto
    }
});

// Evento para agregar Notificaciones nuevos campos
document.getElementById('AgrNot').addEventListener('click', function() {
    // Crear un nuevo div contenedor para los campos
    let newFields = document.createElement('div');
    newFields.classList.add('row', 'added-fields');
    newFields.setAttribute('id', 'new-fields-' + counter);

    // Crear el campo de Notificación
    let notificationField = `
        <div class="col-lg-5">
            <div class="form-group">
                <select class="form-control" id="tar_not_${counter}" name="tar_not_${counter}">
                    <option data-icon="font-icon-home">Notificación</option>
                    <option data-icon="font-icon-cart">Correo Electrónico</option>
                    <option data-icon="font-icon-cart">Whatsapp</option>
                </select>
            </div>
        </div>`;

    // Crear el campo de Minutos
    let minutesField = `
        <div class="col-lg-2">
            <div class="form-group">
                <input type="text" class="form-control" id="tar_min_${counter}" name="tar_min_${counter}" maxlength="3" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            </div>
        </div>`;

    // Crear el campo de Tiempo
    let timeField = `
        <div class="col-lg-3">
            <div class="form-group">
                <select class="form-control" id="tar_tie_${counter}" name="tar_tie_${counter}">
                    <option data-icon="font-icon-home">Minutos</option>
                    <option data-icon="font-icon-cart">Horas</option>
                    <option data-icon="font-icon-cart">Días</option>
                    <option data-icon="font-icon-cart">Semanas</option>
                </select>
            </div>
        </div>`;

    // Crear el botón de eliminar
    let deleteButton = `
        <div class="col-lg-2">
            <div class="form-group">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeFields(${counter})">X</button>
            </div>
        </div>`;

    // Añadir los campos y el botón al contenedor
    newFields.innerHTML = notificationField + minutesField + timeField + deleteButton;

    // Obtener el contenedor donde se van a insertar los nuevos campos
    let modalBody = document.querySelector('.modal-body');
    let referenceDiv = document.getElementById('div_agrnot');

    // Añadir el nuevo div después de div_agrpar
    if (referenceDiv) {
        referenceDiv.insertAdjacentElement('afterend', newFields);
    }

    // Incrementar el contador para los próximos IDs
    counter++;
});

// Evento para agregar nuevos campos Participantes
document.getElementById('AgrPar').addEventListener('click', function() {
    // Crear un nuevo div contenedor para los campos
    let newFields = document.createElement('div');
    newFields.classList.add('row', 'added-fields');
    newFields.setAttribute('id', 'new-fields-' + counterpar);

    // Crear el campo de Usuario
    let usuarioField = `
        <div class="col-lg-5">
            <div class="form-group">
                <select class="form-control" id="tar_par_${counterpar}" name="tar_par_${counterpar}">
                    <option data-icon="font-icon-home">Usuario</option>
                    <option data-icon="font-icon-cart">Externo</option>
                </select>
            </div>
        </div>
        `;

    // Crear el campo de id
    let idField = `
        <div class="col-lg-5">
            <div class="form-group">
                <select class="form-control" id="tar_dat_${counterpar}" name="tar_dat_${counterpar}" disabled>
                </select>
            </div>
        </div>
        `;    

    // Crear el botón de eliminar
    let deleteButton = `
        <div class="col-lg-2">
            <div class="form-group">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeFields(${counterpar})">X</button>
            </div>
        </div>`;

    // Añadir los campos y el botón al contenedor
    newFields.innerHTML = usuarioField + idField + deleteButton;

    // Obtener el contenedor donde se van a insertar los nuevos campos
    let modalBody = document.querySelector('.modal-body');
    let referenceDiv = document.getElementById('div_agrpar');

    // Añadir el nuevo div después de div_agrpar
    if (referenceDiv) {
        referenceDiv.insertAdjacentElement('afterend', newFields);
    }

    // Incrementar el contador para los próximos IDs
    counterpar++;
});

// Boton guardar
$("#tarea_form").on("submit", function (e) {
    e.preventDefault();
    guardaryeditar();
});




function limpiar(){
    $("#tar_id").val("");
    $("#tar_titulo").val("");   
    $('#tar_des').summernote('code', '');
    $("#tar_cat").prop("selectedIndex", 0);
    $("#check-toggle-1").prop("checked", false);
    campo1.disabled = false;  // Desbloquear el campo
    campo2.disabled = false;  // Desbloquear el campo
    campo1.value = `${horas}:${minutos}`; // Establecer la hora actual
    campo2.value = `${horas}:${minutos}`; // Establecer la hora actual
    $('#horaini_hidden').val(''); // Limpiar el valor del campo oculto
    $('#horafin_hidden').val(''); // Limpiar el valor del campo oculto
    $('#tar_fcierre').val(currentDate);
    $("#tar_ubi").val("");
    $("#tar_cal").prop("selectedIndex", 0);
    $("#tar_not").prop("selectedIndex", 0);
    $("#tar_min").val("");
    $("#tar_tie").prop("selectedIndex", 0);
    $("#tar_par").prop("selectedIndex", 0);
    $('#tar_dat').empty();
    $("#descrip").hide();
    $("#tar_comant").val("");
    $('#tar_com').summernote('code', '');

    $.post("../../controller/usuario.php?op=nombre_usu", function (data, status) {
        $("#creado").html('Creado por: &nbsp;' + data);
    });
}

function guardaryeditar(){
    // Obtener el valor del checkbox: 'Sí' si está marcado, 'No' si no
    let todoDia = $('#check-toggle-1').is(':checked') ? 'Si' : 'No';

    const formData = new FormData($("#tarea_form")[0]);
    formData.append('todo_dia', todoDia);

    for (const [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }

    $.ajax({
        url: "../../controller/calendario.php?op=guardaryeditarEvento",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);


        //   if (datos == "1") {
        //     $("#entidad_form")[0].reset();
        //     /* TODO:Ocultar Modal */
        //     $("#modalmantenimiento").modal("hide");
        //     $("#entidad_data").DataTable().ajax.reload();
    
        //     /* TODO:Mensaje de Confirmacion */
        //     swal({
        //       title: "BYAPPS::CRM",
        //       text: "Registrado Correctamente.",
        //       type: "success",
        //       confirmButtonClass: "btn-success",
        //     });
        //   } else if (datos == "2") {
        //     $("#entidad_form")[0].reset();
        //     /* TODO:Ocultar Modal */
        //     $("#modalmantenimiento").modal("hide");
        //     $("#entidad_data").DataTable().ajax.reload();
    
        //     /* TODO:Mensaje de Confirmacion */
        //     swal({
        //       title: "BYAPPS::CRM",
        //       text: "Actualizado Correctamente.",
        //       type: "success",
        //       confirmButtonClass: "btn-success",
        //     });
        //   } else if (datos == "0") {
        //   }
        },
      });
}


// Función para eliminar los campos creados dinámicamente
function removeFields(id) {
    let fieldGroup = document.getElementById('new-fields-' + id);
    if (fieldGroup) {
        fieldGroup.remove();
    }
}

init();