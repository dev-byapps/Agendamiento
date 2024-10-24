async function init() {
    // llamar a la funcion que carga las categorias y los calendarios
    try {
        await Promise.all([ListaCategorias(), ListarCalendarios()]);
        cargarEventos();
    } catch (error) {
        console.error('Error al inicializar:', error);
    }
}

function ListaCategorias() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '../../controller/calendario.php?op=listar_catevents', 
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.error){
                    // Manejar el error si la respuesta contiene un error
                    swal({
                        title: 'Error al listar las categorías',
                        text: response.message || 'Ocurrió un error inesperado.',
                        icon: 'error',
                        buttons: {
                            confirm: {
                                text: 'Aceptar',
                                value: true,
                                visible: true,
                                className: '',
                                closeModal: true
                            }
                        }
                    });
                    reject(response.message || 'Error desconocido');
                    return;
                }

                let eventos = response.data;
                let lista = '';
                selectedCategories = [];

                // Verificar si no hay eventos
                if (eventos.length === 0) {
                    swal({
                        title: 'No existen categorías',
                        text: 'Debe primero crear categorías o solicitarlas a su supervisor.',
                        icon: 'warning',  // Puedes usar 'success', 'warning', 'info', o 'error'
                        buttons: {
                            confirm: {
                                text: 'Aceptar',
                                value: true,
                                visible: true,
                                className: '',
                                closeModal: true
                            }
                        }
                    });
                    reject('No hay categorías disponibles'); // Rechazar la promesa si no hay categorías
                    return; // Salir de la función si no hay categorías
                }

                eventos.forEach(function(evento) {
                    console.log(evento.cateve_color);
                    selectedCategories.push(Number(evento.cateve_id)); // Agregar el ID de la categoría al array
                    lista += `
                                <div class="checkbox-bird">
                                    <input type="checkbox" id="cat${evento.cateve_id}" checked="" style="accent-color: ${evento.cateve_color};">
                                    <label for="cat${evento.cateve_id}">${evento.cateve_title}</label>
                                </div>
                            `;

                    $('#tar_cat').append(new Option(evento.cateve_title, evento.cateve_id));
                });

                $('#categorias').html(lista);                
                resolve();
            },
            error: function(e) {
                swal({
                    title: 'Error al listar las categorías',
                    text: e.responseText || 'Ocurrió un error inesperado.',
                    icon: 'error',  // 'success', 'warning', 'info', or 'error'
                    buttons: {
                        confirm: {
                            text: 'Aceptar',
                            value: true,
                            visible: true,
                            className: '',
                            closeModal: true
                        }
                    }
                });
                reject(e);
            }
        });
    });
}

function ListarCalendarios() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '../../controller/calendario.php?op=listar_calendarios', 
            type: 'GET',
            dataType: 'json',
            success: function(calendarios) {
                if(calendarios != null){
                    let lista = '';
                    selectedCalendarios = [];
        
                    calendarios.forEach(function(calendarios) {
                        selectedCalendarios.push(Number(calendarios.cal_id)); // Agregar el ID de los calendarios al array
                        lista += `
                                    <div class="checkbox">
                                        <input type="checkbox" id="cal${calendarios.cal_id}" checked="">
                                        <label for="cal${calendarios.cal_id}">${calendarios.cal_nom}</label>
                                    </div>
                                `;

                        $('#tar_cal').append(new Option(calendarios.cal_nom, calendarios.cal_id));
                    });
                    $('#calendarios').html(lista);
                    resolve();
                } else {
                    reject('Error: No se encontraron calendarios.');
                }
            },
            error: function(e) {
                swal({
                    title: 'Error al listar los calendarios',
                    text: e,
                    icon: 'error', 
                    buttons: {
                        confirm: {
                            text: 'Aceptar',
                            value: true,
                            visible: true,
                            className: '',
                            closeModal: true
                        }
                    }
                });
                reject(e);
            }
        });
    });
}




init();