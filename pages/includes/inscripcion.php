<?php include '../common/header.php'; ?>
<script src="/cuam/assets/js/inscripcion.js"></script>

<div class='container font-site'>
    <h3>Inscripciones</h3>
    <div class="bg-info info-container">
        <ul>
            <li>Para agregar una nueva inscripcion, haga "click" en el boton <strong>Agregar inscripcion</strong>.</li>
            <li>Para actualizar una inscripcion existente, haga "click" en el icono <i class="glyphicon glyphicon-pencil"></i> en el registro del estudiante que desea modificar.</li>
            <li>Para eliminar una inscripcion, haga "click" en el icono <i class="glyphicon glyphicon-minus-sign"></i> en el registro del estudiante que desea eliminar.</li>
        </ul>
    </div>
    <div class="table-btn-container">
        <button type="button" id="crear-inscripcion-btn" class="btn btn-primary pull-right add-btn">
            <i class="glyphicon glyphicon-plus"></i>
            Agregar inscripcion
        </button>
    </div>
    <table id="inscripcion-table" class="table table-striped table-hover table-bordered"></table>
</div>

<div class="modal fade" id="crear-inscripcion-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar Inscripcion</h4>
            </div>
            <div class="modal-body">
                <div id="inscripcion-message-container"></div>
                <form id="inscripcion-form" class="form-horizontal">
                    <input type="hidden" id="inscripcion-form-action" name="accion" value="">
                    <input type="hidden" id="input-inscripcion-id" name="input-inscripcion-id" value="">
                    <div class="form-group">
                        <label for="select-estudiante" class="col-sm-2 control-label required">Estudiante</label>
                        <div class="col-sm-10">
                            <select name="select-estudiante" type="text" class="form-control" id="select-estudiante">
                                <option value="">- Seleccione -</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select-mencion" class="col-sm-2 control-label required">Mencion</label>
                        <div class="col-sm-10">
                            <select name="select-mencion" type="text" class="form-control" id="select-mencion">
                                <option value="">- Seleccione -</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-fechadeinscripcion" class="col-sm-2 control-label required">Fecha de inscripcion</label>
                        <div class="col-sm-10">
                            <div class="input-group date" id="input-fechadeinscripcion">
                                <input type="text" name="input-fechadeinscripcion" class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
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
                <button type="button" id="guardar-inscripcion-btn" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="elminar-inscripcion-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar inscripcion</h4>
            </div>
            <div class="modal-body">
                    <p>¿Desea eliminar la inscripcion?</p>
                    <div class="pull-center">
                        <button type="button" class="btn" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="eliminar-inscripcion-btn" inscripcion-id="">Eliminar</button>
                    </div>
            </div>
        </div>
    </div>
</div>