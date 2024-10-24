let calendar;
let counter = 1;
let counterpar = 1;
let dataparticipantes;
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
const submitButton = $('#botonguardar'); 

async function init(){
    // Cargar información del usuario que creó el calendario
    $.post("../../controller/usuario.php?op=nombre_usu", function (data, status) {
        $("#creado").html('Creado por: &nbsp;' + data);
    });

    // Cargar participantes
    $.post("../../controller/usuario.php?op=part_event", function (data, status) {
        dataparticipantes = data;
        $("#tar_dat_1").html(data);
        $("#tar_dat_1").prop('disabled', false);
    });

    // // Llamar a las funciones que cargan calendarios y categorías
    // try {
    //     await Promise.all([ListarCalendarios(), ListaCategorias()]);
    //     cargarEventos();
    // } catch (error) {
    //     console.error('Error al inicializar:', error);
    // }finally {
    // }
}

// Inicializar el calendario
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    // Código para manejar los campos creados inicialmente
    const $existingElement = $("#tar_dat_1");
    const $selectUsuarioInicial = $("#tar_par_1");

    // Inicializar el calendario
    calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'today,prev,next',
            center: 'title',
            right: 'dayGridDay,dayGridWeek,dayGridMonth,listWeek'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día',
            list: 'Agenda'
        },        
        editable: true,
        selectable: true,
        dayMaxEvents: true,  
        eventDidMount: function(info) {
            var cateveColor = info.event.extendedProps.cateve_color;
    
            // Si el color del evento está definido, aplícalo
            if (cateveColor) {
                info.el.style.backgroundColor = cateveColor;
                info.el.style.borderColor = cateveColor;
            }
        },      
        eventClick: function(info) {
            // Remover cualquier modal previo
            $('.fc-popover.click').remove();

            // Obtener los tiempos de inicio y fin
            const start = info.event.start;
            const end = info.event.end;

            // Verificar si la hora de inicio y fin son diferentes
            let timeHtml;
            if (end && start.getTime() !== end.getTime()) {
                // Si la hora de inicio y fin son diferentes, mostrar ambas
                timeHtml = `${moment(start).format('hh:mma')} - ${moment(end).format('hh:mma')}`;
            } else {
                // Si son iguales, solo mostrar la hora de inicio
                timeHtml = `${moment(start).format('hh:mma')}`;
            }

            // Obtener el color de fondo del evento
            var cateveColor = info.event.extendedProps.cateve_color || '#FFF';  // Fallback al blanco si no tiene un color definido
            
            // Crear nuevo modal
            var eventEl = $(info.el);

            var modalHtml = `
                <div class="fc-popover click" style="z-index: 9999;">
                    <!-- z-index alto, color de fondo desde cateve_color -->
                    <div class="fc-header" style="background-color: ${cateveColor};">
                        ${moment(info.event.start).format('dddd • D')}
                        <button type="button" class="cl"><i class="font-icon-close-2"></i></button>
                    </div>
                    
                    <div class="fc-body main-screen">

                     
                        <p>${info.event.title}</p>
                        <p>${timeHtml}</p> <!-- Aquí se muestra la hora según la comparación -->
                        <p>${info.event.extendedProps.estado}</p>
                        <div style="display: flex; align-items: center;">
                            <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: ${info.event.extendedProps.cal_col}; margin-right: 5px;"></span>
                            <span>${info.event.extendedProps.calendario}</span>
                            <span style="margin-left: 15px;">
                                <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: ${info.event.extendedProps.cateve_color}; margin-right: 5px;"></span>
                                ${info.event.extendedProps.categoria}
                            </span>
                        </div>
                          <ul class="actions" style="margin: 15px 0 0 150px">
                            <li><a href="#" class="fc-event-action-mas ablack"><i class="fa fa-eye"></i></a></li>
                            <li><a href="#" class="fc-event-action-edit ablack"><i class="fa fa-edit"></i></a></li>
                            <li><a href="#" class="fc-event-action-remove ablack"><i class="fa fa-trash"></i></a></li>                            
                        </ul>
                     
                    </div>
                </div>
                `;

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

            // Acción para ver evento
            $('.fc-event-action-mas').click(function(e) {
                e.preventDefault();          
                let notificaciones = '';
                let participantes = '';

                limpiarDinamicos(); // Llamada a la función para limpiar solo los campos dinámicos adicionales

                // Cerrar la ventana emergente de detalles (modal)
                $('.fc-popover.click').remove();

                $("#mdltitulo").html("Ver Tarea");      
                
                // Id
                $("#tar_id").val(info.event.id);

                // Titulo                
                $("#tar_titulo").val(info.event.title);
                $("#tar_titulo").prop('disable', true); 

                // Summernote
                $('#tar_des').summernote('destroy');
                $('#tar_des').summernote({
                    popover: false,
                    lang: "es-ES", 
                    height: 100, // altura del editor
                    maxHeight: 100, // altura máxima del editor
                    toolbar: false,
                    disableResizeEditor: true, // desactivar la opción de redimensionar
                    disableDragAndDrop: true // deshabilitar arrastrar y soltar
                });
                $('#tar_des').summernote('code', info.event.extendedProps.descrip);
                $('#tar_des').summernote('disable');

                // Categoria
                $("#tar_cat").val(info.event.extendedProps.cateve_id);
                $("#tar_cat").prop('disabled', true);  

                // Estado
                var estadoSeleccionado = info.event.extendedProps.estado;
                $('#tar_est').append(new Option(estadoSeleccionado, estadoSeleccionado));
                $('#tar_est').val(estadoSeleccionado);
                $("#tar_est").prop('disabled', true);

                // Prioridad
                var prioridadSeleccionada = info.event.extendedProps.prioridad;
                // Limpiar la selección previa
                $('input[name="tar_pri"]').prop('checked', false);
                $('.btn').removeClass('active btn-danger btn-warning btn-success').addClass('btn-secondary'); // Cambiar a gris
                // Seleccionar el botón correspondiente y marcarlo como activo
                if (prioridadSeleccionada) {
                    const labelId = `#label-${prioridadSeleccionada.toLowerCase()}`;
                    $(`#${prioridadSeleccionada}`).prop('checked', true);
                    $(labelId).addClass('active').removeClass('btn-secondary'); // Revertir al color original
                    // Cambiar el color del botón según la prioridad
                    if (prioridadSeleccionada === 'Bajo') {
                        $(labelId).addClass('btn-warning'); // Amarillo
                    } else if (prioridadSeleccionada === 'Medio') {
                        $(labelId).addClass('btn-warning'); // Naranja
                    } else if (prioridadSeleccionada === 'Alto') {
                        $(labelId).addClass('btn-danger'); // Rojo
                    }
                }
                // Deshabilitar todos los botones
                $('input[name="tar_pri"]').prop('disabled', true);

                // Todo dia
                const Tododia = info.event.extendedProps.Tododia;
                if (Tododia === 'Si') {
                    $('#check-toggle-1').prop('checked', true); // Activar el checkbox
                } else {
                    $('#check-toggle-1').prop('checked', false); // Desactivar el checkbox
                }
                // Evitar que se cambie el estado del checkbox
                $('#check-toggle-1').on('click', function(e) {
                    e.preventDefault(); // Prevenir el cambio de estado
                });

                // CALENDARIO Y HORAS
                $('#tar_fcierre').val(info.event.extendedProps.fecha);
                $("#tar_fcierre").prop('disabled', true);
                $('#campo1').val(info.event.extendedProps.horaIni);
                $("#campo1").prop('disabled', true);
                $('.input-group-addon').css('pointer-events', 'none');
                $('#campo2').val(info.event.extendedProps.horaFin);
                $("#campo2").prop('disabled', true);

                // Ubicacion
                $("#tar_ubi").val(info.event.extendedProps.ubicacion);
                $("#tar_ubi").prop('disabled', true);

                // Calendario
                var calendarioseleccionado = info.event.extendedProps.calendario;
                $('#tar_cal').append(new Option(calendarioseleccionado, calendarioseleccionado));
                $('#tar_cal').val(calendarioseleccionado);
                $("#tar_cal").prop('disabled', true);

                // Notificaciones
                $("#tar_not").prop("disabled", true);
                $("#tar_min").prop("disabled", true);
                $("#tar_tie").prop("disabled", true);
                notificaciones = info.event.extendedProps.notificaciones; 
                notificaciones.forEach((notificacion, index) => {
                    let indice = index + 1; // Para manejar los índices dinámicamente (empieza en 1)
                    
                    if (indice === 1) {
                        // Para el primer conjunto de datos (usar los campos ya existentes)
                        $("#tar_not").val(notificacion.evenot_not);
                        $("#tar_min").val(notificacion.evenot_tim);
                        $("#tar_tie").val(notificacion.evenot_tip);
                    } else {
                        // Para los siguientes conjuntos de datos (crear nuevos campos dinámicamente)
                        const notificacionHTML = `
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <select class="form-control" id="tar_not_${indice}" name="tar_not_${indice}">
                                        <option data-icon="font-icon-cart" ${notificacion.evenot_not}>${notificacion.evenot_not}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="tar_min_${indice}" name="tar_min_${indice}" value="${notificacion.evenot_tim}" maxlength="3" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <select class="form-control" id="tar_tie_${indice}" name="tar_tie_${indice}">
                                        <option data-icon="font-icon-cart" ${notificacion.evenot_tip}>${notificacion.evenot_tip}</option>
                                    </select>
                                </div>
                            </div>`;                       
                
                        // Agregar al contenedor correspondiente
                        $('#div_agrnot').after(notificacionHTML);
                        $(`#tar_not_${indice}`).prop("disabled", true);
                        $(`#tar_min_${indice}`).prop("disabled", true);
                        $(`#tar_tie_${indice}`).prop("disabled", true);
                    }
                });
            
                //Participantes
                $("#tar_par_1").prop("disabled", true);
                $("#tar_dat_1").prop("disabled", true);
                $("#tar_edit_1").prop("disabled", true);
                participantes = info.event.extendedProps.participantes;
                // --- Manejar Participantes ---
                participantes.forEach((participante, index) => {
                    console.log(participante);
                    let indice2 = index + 1; // Para manejar los índices dinámicamente (empieza en 1)
    
                    if (indice2 === 1) {
                        // Para el primer conjunto de datos (usar los campos ya existentes)
                        $("#tar_par_1").val(participante.evepar_par);
                        $("#tar_dat_1").val(participante.evepar_mail);
                        $("#tar_edit_1").val(participante.evepar_per);
                    } else {
                        // Para los siguientes conjuntos de datos (crear nuevos campos dinámicamente)
                        const participanteHTML = `
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <select class="form-control" id="tar_par_${indice2}" name="tar_par_${indice2}">
                                        <option data-icon="font-icon-cart" ${participante.evepar_par}>${participante.evepar_par}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <select class="form-control" id="tar_dat_${indice2}" name="tar_dat_${indice2}" disabled>
                                        <option value="${participante.evepar_mail}">${participante.evepar_mail}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <select class="form-control" id="tar_edit_${indice2}" name="tar_edit_${indice2}">
                                        <option data-icon="font-icon-home" value="${participante.evepar_per}">${participante.evepar_per}</option>
                                    </select>
                                </div>
                            </div>`;                     
                
                        // Agregar al contenedor correspondiente
                        $('#div_agrpar').after(participanteHTML);
                        $(`#tar_par_${indice2}`).prop("disabled", true);
                        $(`#tar_dat_${indice2}`).prop("disabled", true);
                        $(`#tar_edit_${indice2}`).prop("disabled", true);
                    }
                })

                // Comentario
                $("#tar_comant").val(info.event.extendedProps.eve_com);
                $("#tar_comant").prop('disabled', true);
                // Summer comentario
                $('#tar_com').summernote('code', '');
                $("#Com_tarcom").hide();

                // Botones
                $("#AgrNot").hide();
                $("#AgrPar").hide();
                $("#botonguardar").hide();

                /* TODO:Mostrar Modal */
                $("#modaltarea").modal("show");
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
                // Usar swal para confirmar la eliminación
                swal({
                    title: '¿Seguro que deseas eliminar este evento?',
                    text: "¡Esta acción no se puede deshacer!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Si",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                },
                function (isConfirm) {
                    if (isConfirm) {
                        var eventId = info.event.id; // Obtener el ID del evento
                        $.post(
                            "../../controller/calendario.php?op=delete_event",
                            { id: eventId },
                            function (response) {
                                if (response.success) {
                                    swal('Eliminado!', response.message, 'success');
                                    // Eliminar el evento de FullCalendar
                                    info.event.remove();
                                    $('.fc-popover.click').remove();
                                } else {
                                    swal('Error!', response.message, 'error');
                                }                                
                                // Eliminar el evento de FullCalendar
                                info.event.remove();
                                $('.fc-popover.click').remove();
                            },
                            "json" // Asegúrate de especificar que la respuesta es JSON
                        ).fail(function(xhr, status, error) { // Manejo de errores
                            swal('Error!', 'Hubo un error al eliminar el evento: ' + error, 'error');
                        });                      
                    }
                }
                )
            });
        }
    });

    // Renderizar el calendario
    calendar.render();

     // Inicializar el datepicker lateral
     $('#side-datetimepicker').datetimepicker({
        locale: 'es',
        inline: true,  // Para que aparezca dentro del contenedor
        format: 'DD/MM/YYYY'  // Formato de la fecha
    }).on('dp.change', function(e) {
        const newDate = e.date.format('YYYY-MM-DD');

        // Cambiar la vista del calendario a la fecha seleccionada
        calendar.gotoDate(newDate);  // Navega a la fecha seleccionada

       // Actualizar la fecha seleccionada
        selectedDate = newDate;

        // Asegura que la vista cambie a dayGridDay al cambiar de fecha
        currentView = 'dayGridDay';
        calendar.changeView(currentView);
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

    // Añadir evento de cambio para validar el valor seleccionado en "tar_par_1"
    $selectUsuarioInicial.on('change', function() {
        const selectedValue = $(this).val();
        if (selectedValue === 'Usuario') {
            // Si el valor es 'Usuario', agregar los valores de dataparticipantes
            $existingElement.replaceWith(`
                <select class="form-control" id="tar_dat_1" name="tar_dat_1">
                    ${dataparticipantes}
                </select>
            `);
        } else {
            // Si no es 'Usuario', permitir escribir convirtiendo el select en un input
            $existingElement.replaceWith(`
                <input type="text" class="form-control" id="tar_dat_1" name="tar_dat_1">
            `);
        }
    });

    // Opcional: Si quieres que por defecto 'Usuario' cargue los dataparticipantes
    if ($selectUsuarioInicial.val() === 'Usuario') {
        $existingElement.html(dataparticipantes);
        $existingElement.prop('disabled', false);
    }
});

// Boton nuevo
$(document).on("click", "#add-event", function () {
    $("#mdltitulo").html("Nueva Tarea"); 

    limpiar();

    // Limpiar el select
    $('#tar_est').empty();
    // Agregar opciones
    const options = [
        { value: 'Asignada', text: 'Asignada' },
    ];
    // Agregar todas las opciones a la vez
    options.forEach(option => {
        $('#tar_est').append(new Option(option.text, option.value));
    });
    // Prioridad inicio
    $('#Alto').prop('checked', true); // Seleccionar ALTO
    $('#label-alto').addClass('active');
    // Desactivar botones BAJO y MEDIO
    $('#label-bajo, #label-medio').removeClass('active'); // Desactivar BAJO y MEDIO
    $('#Bajo, #Medio').prop('disabled', true); // Desactivar botones

    // -------- Summernote -------- //
    $('#tar_des').summernote({
        popover: false,
        height: 150, // altura del editor
        lang: "es-ES",
        toolbar: [
            ["style", ["bold", "italic", "underline", "clear"]],
            ["fontsize", ["fontsize"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["height", ["height"]],
        ],
        focus: true // enfocar al iniciar
    });
        

  /* TODO:Mostrar Modal */
    $("#modaltarea").modal("show");

    // Activar el botón de guardar una vez que el modal esté completamente mostrado
    $('#modaltarea').on('shown.bs.modal', function () {
            $('#tarea_form').find('button[type="submit"]').prop('disabled', false); // Activar el botón de guardar
    });
});

$(document).on("click", "#add-calendar", function () {
    $("#mdltitcal").html("Nuevo Calendario");  

  /* TODO:Mostrar Modal */
    $("#modalcalendar").modal("show");   
});

// // Botones primarios
// document.getElementById('check-toggle-1').addEventListener('change', function() {  
//     if (this.checked) {
//         campo1.value = "00:00";
//         campo2.value = "23:59";
//         campo1.disabled = true;  // Bloquear el campo
//         campo2.disabled = true;  // Bloquear el campo
//         $('#horaini_hidden').val($('#campo1').val()); // Transferir valor al campo oculto
//         $('#horafin_hidden').val($('#campo2').val()); // Transferir valor al campo oculto
//     } else {
//         campo1.disabled = false;  // Desbloquear el campo
//         campo2.disabled = false;  // Desbloquear el campo
//         campo1.value = `${horas}:${minutos}`; // Establecer la hora actual
//         campo2.value = `${horas}:${minutos}`; // Establecer la hora actual
//         $('#horaini_hidden').val(''); // Limpiar el valor del campo oculto
//         $('#horafin_hidden').val(''); // Limpiar el valor del campo oculto
//     }
// });

// Evento para agregar Notificaciones nuevos campos
document.getElementById('AgrNot').addEventListener('click', function() {
    // Incrementar el contador para los próximos IDs
    counter++;

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
                <button type="button" class="btn btn-danger btn-sm" onclick="removeFieldsnot(${counter})">X</button>
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
    
});

// Evento para agregar nuevos campos Participantes
document.getElementById('AgrPar').addEventListener('click', function() {
    // Incrementar el contador para los próximos IDs
    counterpar++;

    // Crear un nuevo div contenedor para los campos
    let newFields = document.createElement('div');
    newFields.classList.add('row', 'added-fields');
    newFields.setAttribute('id', 'new-fields-' + counterpar);

    // Crear el campo de Usuario
    let usuarioField = `
        <div class="col-lg-3">
            <div class="form-group">
                <select class="form-control" id="tar_par_${counterpar}" name="tar_par_${counterpar}">
                    <option data-icon="font-icon-home" value="Usuario">Usuario</option>
                    <option data-icon="font-icon-cart" value="Externo">Externo</option>
                </select>
            </div>
        </div>
        `;

    // Crear el campo de id
    let idField = `
        <div class="col-lg-5">
            <div class="form-group">
                <select class="form-control" id="tar_dat_${counterpar}" name="tar_dat_${counterpar}">
                </select>
            </div>
        </div>
        `;

    // Crear el campo de editable
    let editField = `
        <div class="col-lg-2">
            <div class="form-group">
                <select class="form-control" id="tar_edit_${counterpar}" name="tar_edit_${counterpar}">
                    <option data-icon="font-icon-home" value="Si">Sí</option>
                    <option data-icon="font-icon-cart" value="No">No</option>
                </select>
            </div>
        </div>
        `;

    // Crear el botón de eliminar
    let deleteButton = `
        <div class="col-lg-2">
            <div class="form-group">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeFieldspar(${counterpar})">X</button>
            </div>
        </div>
        `;

    // Añadir los campos y el botón al contenedor
    newFields.innerHTML = usuarioField + idField + editField + deleteButton;

    // Obtener el contenedor donde se van a insertar los nuevos campos
    let referenceDiv = document.getElementById('div_agrpar');

    // Añadir el nuevo div después de div_agrpar
    if (referenceDiv) {
        referenceDiv.insertAdjacentElement('afterend', newFields);
    }    

    // Ahora que el campo ha sido añadido al DOM, podemos agregar los datos a la lista con el ID dinámico
    const $newElement = $("#tar_dat_" + counterpar);
    const $selectUsuario = $("#tar_par_" + counterpar);
    
    // Agregar dataparticipantes al nuevo campo de id por defecto
    if ($newElement.length) {
        $newElement.html(dataparticipantes);
        $newElement.prop('disabled', false);
    }

    // Añadir evento de cambio para validar el valor seleccionado en "tar_par_*"
    $selectUsuario.on('change', function() {
        const selectedValue = $(this).val();
        
        if (selectedValue === 'Usuario') {
            // Cambiar el contenido del select manteniendo el ID
            $newElement.html(dataparticipantes);
            $newElement.prop('disabled', false); // Habilitar el select si es necesario
        } else {
            // Cambiar a un input manteniendo el ID
            const inputElement = `
                <input type="text" class="form-control" id="${$newElement.attr('id')}" name="tar_dat_${counterpar}">
            `;
            $newElement.parent().html(inputElement); // Reemplaza el elemento manteniendo el ID
        }
    });
});

// Boton guardar
$("#tarea_form").on("submit", function (e) {
    e.preventDefault();
    guardaryeditar();
});

// Escuchar cambios en la categoría y actualizar los estados dinámicamente
$(document).on("change", "#tar_cat", function () {
    // Limpiar el select de estados
    $('#tar_est').empty();

    // Obtener el valor de la categoría
    let categoria = $('#tar_cat').val();

    // Verificar el título del modal
    let tituloModal = $("#mdltitulo").html();

    // Actualizar el select de estados según la categoría seleccionada y el título del modal
    if (tituloModal === "Nueva Tarea") {
        if (categoria === '1') {
            $('#tar_est').append(new Option('Asignada', 'Asignada'));
            // PRIORIDAD
            $('#Alto').prop('checked', true); // Seleccionar ALTO
            $('#label-alto').addClass('active');
            // Desactivar botones BAJO y MEDIO
            $('#label-bajo, #label-medio').removeClass('active'); // Desactivar BAJO y MEDIO
            $('#Bajo, #Medio').prop('disabled', true); // Desactivar botones
        } else {
            $('#tar_est').append(new Option('Creado', 'Creado'));
            $('#tar_est').append(new Option('En curso', 'En curso'));
            // PRIORIDAD - Para otras categorías, establecer prioridad en BAJO y permitir cambios
            $('#Bajo').prop('checked', true); // Seleccionar BAJO
            $('#label-bajo').addClass('active');
            $('#label-alto, #label-medio').removeClass('active');
            // Activar todos los botones
            $('#Bajo, #Medio').prop('disabled', false); // Activar botones
        }

        // Evento de clic para permitir cambios en BAJO y MEDIO
        $('#label-bajo, #label-medio').on('click', function () {
            $(this).siblings().removeClass('active'); // Desmarcar otros
            $(this).addClass('active'); // Marcar el seleccionado
        });

    } else if (tituloModal === "Editar Tarea") {
        if (categoria === '1') {
            $('#tar_est').append(new Option('Cumplida', 'Cumplida'));
            $('#tar_est').append(new Option('No cumplida', 'No cumplida'));
            $('#tar_est').append(new Option('Cancelada', 'Cancelada'));
            $('#tar_est').append(new Option('Transferida', 'Transferida'));
            $('#tar_est').append(new Option('Reasignada', 'Reasignada'));
        } else {
            $('#tar_est').append(new Option('Completado', 'Completado'));
            $('#tar_est').append(new Option('Vencido', 'Vencido'));
            $('#tar_est').append(new Option('Eliminado', 'Eliminado'));

        }
    }
});

function cargarEventos() {
    // Obtener el rango de fechas actual del calendario
    let view = calendar.view;
    let start = view.activeStart.toISOString().split('T')[0];
    let end = view.activeEnd.toISOString().split('T')[0];

    let ajaxParams = {
        start: start,
        end: end,
        categories: JSON.stringify(selectedCategories),
        calendarios: JSON.stringify(selectedCalendarios)
    };

    // console.log(ajaxParams);

    $.ajax({
        url: '../../controller/calendario.php?op=listar_events',
        type: 'POST',
        data: ajaxParams,
        success: function(response) {
            // console.log(response);

            const result = JSON.parse(response);

            // Manejar errores en la respuesta
            if (result.status === 'error') {
                alert('Error: ' + result.message);
                return; // Salir de la función en caso de error
            }

            const events = result.data;

            events.forEach(function(event) {
                event.color = event.cal_col;
            });

            // Limpiar eventos anteriores y añadir nuevos eventos al calendario
            calendar.removeAllEvents();
            calendar.addEventSource(events);
        },
        error: function() {
            swal('Hubo un error al cargar los eventos.');
        }
    });
}

// function ListarCalendarios() {
//     return new Promise((resolve, reject) => {
//         $.ajax({
//             url: '../../controller/calendario.php?op=listar_calendarios', 
//             type: 'GET',
//             dataType: 'json',
//             success: function(calendarios) {
//                 if(calendarios != null){
//                     let lista = '';
//                     selectedCalendarios = [];
        
//                     calendarios.forEach(function(calendarios) {
//                         selectedCalendarios.push(Number(calendarios.cal_id)); // Agregar el ID de los calendarios al array
//                         lista += `
//                                     <div class="checkbox">
//                                         <input type="checkbox" id="cal${calendarios.cal_id}" checked="">
//                                         <label for="cal${calendarios.cal_id}">${calendarios.cal_nom}</label>
//                                     </div>
//                                 `;

//                         $('#tar_cal').append(new Option(calendarios.cal_nom, calendarios.cal_id));
//                     });
//                     $('#calendarios').html(lista);
//                     resolve();
//                 } else {
//                     reject('Error: No se encontraron calendarios.');
//                 }
//             },
//             error: function(e) {
//                 swal({
//                     title: 'Error al listar los calendarios',
//                     text: e,
//                     icon: 'error',  // 'success', 'warning', 'info', or 'error'
//                     buttons: {
//                         confirm: {
//                             text: 'Aceptar',
//                             value: true,
//                             visible: true,
//                             className: '',
//                             closeModal: true
//                         }
//                     }
//                 });
//                 reject(e);
//             }
//         });
//     });
// }

// function ListaCategorias() {
//     return new Promise((resolve, reject) => {
//         $.ajax({
//             // url: '../../controller/calendario.php?op=listar_catevents', 
//             // type: 'GET',
//             // dataType: 'json',
//             // success: function(eventos) {
//                 // let lista = '';
//                 // selectedCategories = [];

//                 // Verificar si no hay eventos
//                 // if (eventos.length === 0) {
//                 //     swal({
//                 //         title: 'No existen categorías',
//                 //         text: 'Debe primero crear categorías o solicitarlas a su supervisor.',
//                 //         icon: 'warning',  // Puedes usar 'success', 'warning', 'info', o 'error'
//                 //         buttons: {
//                 //             confirm: {
//                 //                 text: 'Aceptar',
//                 //                 value: true,
//                 //                 visible: true,
//                 //                 className: '',
//                 //                 closeModal: true
//                 //             }
//                 //         }
//                 //     });
//                 //     reject('No hay categorías disponibles'); // Rechazar la promesa si no hay categorías
//                 //     return; // Salir de la función si no hay categorías
//                 // }

//                 // eventos.forEach(function(evento) {
//                 //     selectedCategories.push(Number(evento.cateve_id)); // Agregar el ID de la categoría al array
//                 //     lista += `
//                 //                 <div class="checkbox-bird ${evento.cateve_color}">
//                 //                     <input type="checkbox" id="cat${evento.cateve_id}" checked="">
//                 //                     <label for="cat${evento.cateve_id}">${evento.cateve_title}</label>
//                 //                 </div>
//                 //             `;

//                 //     $('#tar_cat').append(new Option(evento.cateve_title, evento.cateve_id));
//                 // });

//                 // $('#categorias').html(lista);
//                 // resolve();
//             // },
//             error: function(e) {
//                 swal({
//                     title: 'Error al listar las categorías',
//                     text: e.responseText || 'Ocurrió un error inesperado.',
//                     icon: 'error',  // 'success', 'warning', 'info', or 'error'
//                     buttons: {
//                         confirm: {
//                             text: 'Aceptar',
//                             value: true,
//                             visible: true,
//                             className: '',
//                             closeModal: true
//                         }
//                     }
//                 });
//                 reject(e);
//             }
//         });
//     });
// }

function limpiar(){
    $("#tar_id").val("");
    $("#tar_titulo").val("");   
    $('#tar_des').summernote('destroy');
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


    // Eliminar los campos dinámicamente creados
    $(".added-fields").remove(); // Esto elimina todos los campos añadidos
}

// Función para eliminar los campos creados dinámicamente
function removeFieldsnot(id) {
    let fieldGroup = document.getElementById('new-fields-' + id);
    if (fieldGroup) {
        fieldGroup.remove();
    }
}

// Función para eliminar los campos creados dinámicamente
function removeFieldspar(id) {
    let fieldGroup = document.getElementById('new-fields-' + id);
    if (fieldGroup) {
        fieldGroup.remove();
    }
}

function guardaryeditar() {
    // Bloquear el botón y mostrar el ícono de carga
    submitButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Cargando...');

    // Obtener el valor del checkbox: 'Sí' si está marcado, 'No' si no
    let todoDia = $('#check-toggle-1').is(':checked') ? 'Si' : 'No';

    const formData = new FormData($("#tarea_form")[0]);
    formData.append('todo_dia', todoDia);
    formData.append('counter', counter);
    formData.append('counterpar', counterpar);

    formData.append('agenda', null);

    let isValid = true;  // Bandera para indicar si todo es válido

    // Validar todos los campos `tar_par_` y `tar_dat_` desde el inicio hasta los que se crean dinámicamente
    for (let i = 1; i <= counterpar; i++) {
        let tarDat = $("#tar_dat_" + i).val(); // Obtener el valor del campo        
        let usuarioTipo = $("#tar_par_" + i).val(); // Obtener el valor del campo de tipo

        if (usuarioTipo) {
            if (!tarDat) {
                swal("No pueden existir campos vacios valida la información o elimina el campo.");
                // Desbloquear el botón al recibir la respuesta
                submitButton.prop('disabled', false).html('Guardar'); 
                return; // Salir de la función si el campo está vacío
                
            }

            if (usuarioTipo === "Usuario") {
                if (!/^\d+$/.test(tarDat)) {
                    swal("El campo debe contener solo valores numéricos para el tipo 'Usuario'.");
                    // Desbloquear el botón al recibir la respuesta
                    submitButton.prop('disabled', false).html('Guardar'); 
                    return;
                }
            } else {
                if (!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(tarDat)) {
                    swal("El campo debe contener un correo electrónico válido.");
                    // Desbloquear el botón al recibir la respuesta
                    submitButton.prop('disabled', false).html('Guardar'); 
                    return;
                }
            }
        }
    }

    // Si no es válido, detener el envío del formulario
    if (!isValid) {
        // Desbloquear el botón al recibir la respuesta
        submitButton.prop('disabled', false).html('Guardar'); 
        return;
    }    

    $.ajax({
        url: "../../controller/calendario.php?op=guardaryeditarEvento",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);

            // Desbloquear el botón al recibir la respuesta
            submitButton.prop('disabled', false).html('Guardar'); 

            if (datos == "1") {
                $("#tarea_form")[0].reset();            
                $("#modaltarea").modal("hide"); // Ocultar Modal

                // Eliminar los campos dinámicamente creados
                $(".added-fields").remove(); // Esto elimina todos los campos añadidos

                cargarEventos(); // Llama a cargarEventos para actualizar el calendario

                swal({
                    title: "BYAPPS::CRM",
                    text: "Registrado Correctamente.",
                    type: "success",
                    confirmButtonClass: "btn-success",
                });
            } else if (datos == "2") {
                // Manejo de otro caso
            } else {
                // Manejo de error
            }
        },
        error: function (xhr, status, error) {
            // Desbloquear el botón si ocurre un error
            submitButton.prop('disabled', false).html('Guardar'); // Reemplaza 'Guardar' con el texto original
            swal("Error", "Ocurrió un error al guardar los datos.", "error");
        }
    });
}

function limpiarDinamicos() {
    // Limpiar notificaciones adicionales
    $('#div_agrnot').siblings('[id^="tar_not_"]').remove(); // Elimina todos los select adicionales de notificaciones
    $('#div_agrnot').siblings('[id^="tar_min_"]').remove(); // Elimina todos los inputs adicionales de minutos
    $('#div_agrnot').siblings('[id^="tar_tie_"]').remove(); // Elimina todos los select adicionales de tipos

    // Limpiar participantes adicionales
    $('#div_agrpar').siblings('[id^="tar_par_"]').remove(); // Elimina todos los selects adicionales de participantes
    $('#div_agrpar').siblings('[id^="tar_dat_"]').remove(); // Elimina todos los selects adicionales de datos
    $('#div_agrpar').siblings('[id^="tar_edit_"]').remove(); // Elimina todos los selects adicionales de edición
}





init();