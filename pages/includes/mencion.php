<?php include '../common/header.php'; ?>
<script src="/cuam/assets/js/mencion.js"></script>

<div class='container font-site'>
    <h3>Menciones</h3>
    <div class="bg-info info-container">
        <ul>
            <li>Para agregar una nueva mencion, haga "click" en el boton <strong>Agregar mencion</strong>.</li>
            <li>Para actualizar una mencion existente, haga "click" en el icono <i class="glyphicon glyphicon-pencil"></i> en el registro de la mencion que desea modificar.</li>
            <li>Para eliminar una mencion, haga "click" en el icono <i class="glyphicon glyphicon-minus-sign"></i> en el registro de la mencion que desea eliminar.</li>
        </ul>
    </div>
    <div class="table-btn-container">
        <button type="button" id="crear-mencion-btn" class="btn btn-primary pull-right add-btn">
            <i class="glyphicon glyphicon-plus"></i>
            Agregar mencion
        </button>
    </div>
    <table id="mencion-table" class="table table-striped table-hover table-bordered"></table>
</div>

<div class="modal fade" id="crear-mencion-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar Mencion</h4>
            </div>
            <div class="modal-body">
                <div id="mencion-message-container"></div>
                <form id="mencion-form" class="form-horizontal">
                    <input type="hidden" id="mencion-form-action" name="accion" value="">
                    <input type="hidden" id="input-mencion-id" name="input-mencion-id" value="">
                    <div class="form-group">
                        <label for="input-nombre" class="col-sm-2 control-label required">Nombre</label>
                        <div class="col-sm-10">
                            <input name="input-nombre" type="text" class="form-control" id="input-nombre" placeholder="Nombre">
                        </div>
                    </div>
                </form>
                <div class="bg-info info-container">
                    <ul>
                        <li>Los campos indicados con <span class="text-danger">*</span> son obligatorios.</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Cerrar</button>
                <button type="button" id="guardar-mencion-btn" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="elminar-mencion-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar mencion</h4>
            </div>
            <div class="modal-body">
                    <p>¿Desea eliminar la mencion?</p>
                    <div class="pull-center">
                        <button type="button" class="btn" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="eliminar-mencion-btn" mencion-id="">Eliminar</button>
                    </div>
            </div>
        </div>
    </div>
</div>