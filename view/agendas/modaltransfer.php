<style>
    #calendarday {
        min-height: 500px;
        margin: 10px auto;
    }
</style>

<div id="modaltransfer" class="modal fade" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title">Buscar Agendas</h4>
            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-12">
                        <label class="form-label semibold" for="tar_par1">Usuario</label>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <select class="form-control" id="tar_par" name="tar_par">
                                <option data-icon="font-icon-home">YO</option>
                                <option data-icon="font-icon-cart">Pepito1</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div id='calendarday'></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>