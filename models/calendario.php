<?php
class Calendario extends Conectar
{
    // CATEGORIAS
    public function listar_catevents($idusu) { 
        try {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "CALL SP_Listar_catevents(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $idusu, PDO::PARAM_INT);
            $sql->execute();
            $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
            unset($conectar);
            return array('success' => true, 'data' => $resultado);
        } catch (Exception $e) {
            // Manejar el error, por ejemplo, registrarlo en un archivo de logs
            error_log($e->getMessage(), 3, '/var/log/php_errors.log');
            return array('success' => false, 'message' => $e->getMessage());
        }
    }

    // CALENDARIO
        public function listar_calendarios($idusu) {
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "CALL SP_Listar_Calendars(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $idusu, PDO::PARAM_INT);
            $sql->execute();
            $resultado = $sql->fetchAll(PDO::FETCH_ASSOC); 
            unset($conectar);
            return $resultado; 
        }
    
    
    
    // EVENTOS
        public function insert_events($tar_titulo, $tar_des, $tar_cat, $tar_est, $tar_pri, $todo_dia, $feini, $fefin, $tar_ubi, $tar_cal, $usuid, $agenda){
            $conectar = parent::conexion();
            parent::set_names();

            $sql = "CALL SP_Crear_events(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $tar_titulo, PDO::PARAM_STR);
            $sql->bindValue(2, $tar_des, PDO::PARAM_STR);
            $sql->bindValue(3, $tar_cat, PDO::PARAM_INT);
            $sql->bindValue(4, $tar_est, PDO::PARAM_STR);
            $sql->bindValue(5, $tar_pri, PDO::PARAM_STR);
            $sql->bindValue(6, $todo_dia, PDO::PARAM_STR);
            $sql->bindValue(7, $feini, PDO::PARAM_STR);
            $sql->bindValue(8, $fefin, PDO::PARAM_STR);
            $sql->bindValue(9, $tar_ubi, PDO::PARAM_STR);
            $sql->bindValue(10, $tar_cal, PDO::PARAM_INT);
            $sql->bindValue(11, $usuid, PDO::PARAM_INT);
            $sql->bindValue(12, $agenda, PDO::PARAM_INT);

            $sql->execute();
            $resultado = $sql->fetchAll();
            unset($conectar);

            // Devuelve el ID del evento recién creado
            return $resultado[0]['eve_id'];
        }

        public function delete_event_completo($id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "CALL SP_Eliminar_events_completo(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            try {
                $stmt->execute();
                
                // Comprobar si la eliminación fue exitosa
                if ($stmt->rowCount() > 0) {
                    return [
                        'status' => 'success',
                        'message' => 'Evento eliminado con éxito.'
                    ];
                } else {
                    return [
                        'status' => 'error',
                        'message' => 'No se encontró el evento con el ID proporcionado.'
                    ];
                }
            } catch (PDOException $e) {
                return [
                    'status' => 'error',
                    'message' => 'Error al eliminar el evento: ' . $e->getMessage()
                ];
            } finally {
                // Cerrar la conexión
                unset($conectar);
            }
        }
        // Pendiente revisar el procedimeinto
        public function listar_events($usuid, $categories, $calendarios, $start, $end) {
            $conectar = parent::conexion();
            parent::set_names();
        
            // Convertir las categorías a una cadena separada por comas si están presentes
            $categoriesString = !empty($categories) ? implode(',', $categories) : null;
            // Convertir los calendarios a una cadena separada por comas si están presentes
            $calendariosString = !empty($calendarios) ? implode(',', $calendarios) : null;
        
            try {
                $sql = "CALL SP_Listar_events2(?,?,?,?,?)";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $usuid, PDO::PARAM_INT);
                $sql->bindValue(2, $categoriesString, PDO::PARAM_STR);
                $sql->bindValue(3, $calendariosString, PDO::PARAM_STR);
                $sql->bindValue(4, $start, PDO::PARAM_STR);
                $sql->bindValue(5, $end, PDO::PARAM_STR);
                $sql->execute();
        
                // no tener en cuenta el primer resultado 
                $sql->fetchAll(PDO::FETCH_ASSOC);        
                // Capturar el segundo conjunto de resultados 
                $sql->nextRowset(); // Avanzar al siguiente conjunto de resultados
                $datos = $sql->fetchAll(PDO::FETCH_ASSOC);
        
                // Devolver todos los resultados como un arreglo
                return json_encode(array(
                    'status' => 'success',
                    'datos' => $datos
                ));
        
            } catch (Exception $e) {
                // Manejar excepciones
                return json_encode(array('status' => 'error', 'message' => $e->getMessage()));
            } finally {
                unset($conectar);
            }
        }
        
        



    // NOTIFICACIONES
        public function insert_notify($ideve, $tar_not, $tar_min, $tar_tie){
            $conectar = parent::conexion();
            parent::set_names();
        
            $sql = "CALL SP_Crear_Notify(?, ?, ?, ?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $ideve, PDO::PARAM_INT);
            $sql->bindValue(2, $tar_not, PDO::PARAM_STR);
            $sql->bindValue(3, $tar_min, PDO::PARAM_INT);
            $sql->bindValue(4, $tar_tie, PDO::PARAM_STR);
            $sql->execute();
            $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
            unset($conectar);
            return $resultado; 
        }

    // PARTICIPANTES
        public function insert_eventshare($ideve, $tar_par, $mail, $tar_edit){
            $conectar = parent::conexion();
            parent::set_names();
        
            $sql = "CALL SP_Crear_events_Share(?, ?, ?, ?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $ideve, PDO::PARAM_INT);
            $sql->bindValue(2, $tar_par, PDO::PARAM_STR);
            $sql->bindValue(3, $mail, PDO::PARAM_STR);
            $sql->bindValue(4, $tar_edit, PDO::PARAM_STR);
            $sql->execute();
            $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
            unset($conectar);
            return $resultado; 
        }

        





    


        

        public function delete_event_notify($id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "CALL SP_Eliminar_events_notify(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->execute();
            $resultado = $sql->fetchAll();
            unset($conectar);
        }

        public function delete_event_share($id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "CALL SP_Eliminar_events_share(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->execute();
            $resultado = $sql->fetchAll();
            unset($conectar);
        }



        public function create_calendar($name, $description, $propietario, $color, $privacy, $state){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "CALL SP_Create_Calendar(?, ?, ?, ?, ?, ?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $name, PDO::PARAM_STR);
            $sql->bindValue(2, $description, PDO::PARAM_STR);
            $sql->bindValue(3, $propietario, PDO::PARAM_INT);
            $sql->bindValue(4, $color, PDO::PARAM_STR);
            $sql->bindValue(5, $privacy, PDO::PARAM_INT);
            $sql->bindValue(6, $state, PDO::PARAM_STR);
            $sql->execute();
            unset($conectar);
        }

        public function delete_calendar($id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "CALL SP_Delete_Calendar(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->execute();
            unset($conectar);
        }
        public function view_a_calendar($id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "CALL SP_View_A_Calendar(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->execute();
            unset($conectar);
        }

        public function update_calendar($id, $name, $description, $propietario, $color, $privacy, $state){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "CALL SP_Update_Calendar(?, ?, ?, ?, ?, ?, ?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->bindValue(2, $name, PDO::PARAM_STR);
            $sql->bindValue(3, $description, PDO::PARAM_STR);
            $sql->bindValue(4, $propietario, PDO::PARAM_INT);
            $sql->bindValue(5, $color, PDO::PARAM_STR);
            $sql->bindValue(6, $privacy, PDO::PARAM_INT);
            $sql->bindValue(7, $state, PDO::PARAM_STR);
            $sql->execute();
            unset($conectar);
        }

        public function update_color_calendar($id, $color){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "CALL SP_Update_Calendar_Color(?, ?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $id, PDO::PARAM_INT);
            $sql->bindValue(2, $color, PDO::PARAM_STR);
            $sql->execute();
            unset($conectar);
        }
        
    // COMPARTIDO CALENDARIO
        public function create_calendarcompartido($idcalendar, $description, $propietario, $color, $privacy, $state){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "CALL SP_Create_Calendar(?, ?, ?, ?, ?, ?)";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $name, PDO::PARAM_STR);
            $sql->bindValue(2, $description, PDO::PARAM_STR);
            $sql->bindValue(3, $propietario, PDO::PARAM_INT);
            $sql->bindValue(4, $color, PDO::PARAM_STR);
            $sql->bindValue(5, $privacy, PDO::PARAM_INT);
            $sql->bindValue(6, $state, PDO::PARAM_STR);
            $sql->execute();
            unset($conectar);
        }

        // mostrar con quien esta compartido
        // ver permisos 
        // Editar permisos
        // Eliminar compartido

        //ver configuracion de notificaciones
        // Editar configuracion de notificaciones
         
        //ver configuracion de perfiles calendario
        // Editar perfiles calendario


    
    public function agregarevents($title, $start, $end, $category_id)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Crear_events(?, ?, ?, ?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $title, PDO::PARAM_STR);
        $sql->bindValue(2, $start, PDO::PARAM_STR);
        $sql->bindValue(3, $end, PDO::PARAM_STR);
        $sql->bindValue(3, $category_id, PDO::PARAM_INT);

        $sql->execute();
        unset($conectar);
    }
    public function editarevents($id, $title, $start, $end)
    {
        $conectar = parent::conexion();
        parent::set_names();
        $sql = "CALL SP_Editar_events(?, ?, ?, ?)";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id, PDO::PARAM_INT);
        $sql->bindValue(2, $title, PDO::PARAM_STR);
        $sql->bindValue(3, $start, PDO::PARAM_STR);
        $sql->bindValue(4, $end, PDO::PARAM_STR);
        $sql->execute();
        unset($conectar);
    }
    
    

        //Mostrar con quien esta compartido el evento
        // ver permisos
        // Editar permisos
        // Eliminar compartido el evento
        // Crear compartido el evento

    






        // ver una categoria evento
        // Editar categoria evento
        // Eliminar categoria evento
        // Crear categoria evento

    // AGENDAS
        // Crear agendas
        // ver agenda
        // Editar agenda
        // Elimina agenda

    // CITAS
        //Crear cita
        // ver citas
        // ver una cita
        // Edita cita
        // Elimina cita
        
    // NOTIFICACIONES
        //Crear notificaciones
        // ver notificaciones
        // ver una notificacion
        // Edita notificaciones
        // Elimina notificaciones
    
    
    
    
    
    
}
