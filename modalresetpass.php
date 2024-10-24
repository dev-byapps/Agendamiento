<div id="modalresetpass" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4>
            </div>

            <form method="post" id="resetpass_form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-danger alert-icon alert-close alert-dismissible fade in" role="alert">
                                <i class="font-icon font-icon-warning"></i>
                                Ingrese su nombre de usuario registrado. Enviaremos un mensaje a su correo electrónico con instrucciones para restablecer su contraseña. Por favor, revise su bandeja de entrada.
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label" for="user">Usuario</label>
                                <input type="text" class="form-control" id="user" name="user" required>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="action" id="#" value="add" class="btn btn-primary">Restablecer</button>
                    <button type="button" id="cerrarresetpass" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>