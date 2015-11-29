<?php include '../common/header.php'; ?>
<script src="/cuam/assets/js/estudiante.js"></script>

<div class='container font-site'>
    <h3>Estudiantes</h3>
    <div class="bg-info info-container">
        <ul>
            <li>Para agregar un nuevo estudiante, haga "click" en el boton <strong>Agregar estudiante</strong>.</li>
            <li>Para actualizar un estudiante existente, haga "click" en el icono <i class="glyphicon glyphicon-pencil"></i> en el registro del estudiante que desea modificar.</li>
            <li>Para eliminar un estudiante, haga "click" en el icono <i class="glyphicon glyphicon-minus-sign"></i> en el registro del estudiante que desea eliminar.</li>
        </ul>
    </div>
    <div class="table-btn-container">
        <button type="button" id="crear-estudiante-btn" class="btn btn-primary pull-right add-btn">
            <i class="glyphicon glyphicon-plus"></i>
            Agregar estudiante
        </button>
    </div>
    <table id="estudiante-table" class="table table-striped table-hover table-bordered"></table>
</div>

<div class="modal fade" id="crear-estudiante-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar estudiante</h4>
            </div>
            <div class="modal-body">
                <div id="estudiante-message-container"></div>
                <form id="estudiante-form" class="form-horizontal">
                    <input type="hidden" id="estudiante-form-action" name="accion" value="">
                    <input type="hidden" id="input-estudiante-id" name="input-estudiante-id" value="">
                    <div class="form-group">
                        <label for="input-nombre" class="col-sm-2 control-label required">Nombre</label>
                        <div class="col-sm-10">
                            <input name="input-nombre" type="text" class="form-control" id="input-nombre" placeholder="Nombre">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-apellido" class="col-sm-2 control-label required">Apellido</label>
                        <div class="col-sm-10">
                            <input name="input-apellido" type="text" class="form-control" id="input-apellido" placeholder="Apellido">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select-sexo" class="col-sm-2 control-label required">Sexo</label>
                        <div class="col-sm-10">
                            <select name="select-sexo" type="text" class="form-control" id="select-sexo">
                                <option value="">- Seleccione -</option>
                                <option value="F">Femenino</option>
                                <option value="M">Masculino</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-fechadenacimiento" class="col-sm-2 control-label required">Fecha de nacimiento</label>
                        <div class="col-sm-10">
                            <div class="input-group date" id="input-fechadenacimiento">
                                <input type="text" name="input-fechadenacimiento" class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-cedula" class="col-sm-2 control-label required">Cedula</label>
                        <div class="col-sm-10">
                            <input name="input-cedula" type="text" class="form-control" id="input-cedula" placeholder="Indique el numero de cedula (solo numeros sin espacios)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input name="input-email" type="text" class="form-control" id="input-email" placeholder="cuenta@email.com">
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
                <button type="button" id="guardar-estudiante-btn" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="elminar-estudiante-modal" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Eliminar estudiante</h4>
            </div>
            <div class="modal-body">
                    <p>¿Desea eliminar al estudiante?</p>
                    <div class="pull-center">
                        <button type="button" class="btn" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="eliminar-estudiante-btn" estudiante-id="">Eliminar</button>
                    </div>
            </div>
        </div>
    </div>
</div>

