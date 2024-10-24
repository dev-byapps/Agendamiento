<div id="modalintegrantes" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo2"></h4>
            </div>
            <form method="post" id="integrantes_form">
                <div class="modal-body">

                    <input type="hidden" id="cc_id_modal" name="cc_id_modal" value="">


                    <div class="row">

                        <div class="col-lg-7">
                            <div class="box-typical box-typical-padding" id="table">

                                <table id="integrantes_data" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                                    <thead>
                                        <tr>
                                            <th style="width: 95%;">Integrantes</th>
                                            <th class="text-center" style="width: 5%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="box-typical box-typical-padding">
                                <fieldset class="form-group">

                                    <!-- Campo de entrada para buscar -->
                                    <input type="text" id="search" placeholder="Buscar..." onkeyup="filterResults()" class="form-control mb-2">

                                    <label class="form-label semibold" for="fil_usuarios">Usuarios</label>
                                    <select class="select2" id="fil_usuarios" name="fil_usuarios" data-placeholder="Seleccionar">
                                        <option label="Seleccionar"></option>
                                    </select>
                                    <br></br>
                                    <button type="button" id="btnagregar" class="btn btn-inline btn-primary">Agregar</button>
                                </fieldset>
                            </div>
                        </div>



                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>

                </div>
            </form>
        </div>
    </div>
</div>