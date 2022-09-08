<?php 
$this->setVar('title', 'Detalle');
$this->setVar('pagetitle', 'Grupo');
$this->setVar('css_styles', array(
    'assets/libs/fullcalendar/main.min.css',
    'assets/libs/bootstrap/icons/bootstrap-icons.css',
    'assets/libs/select2/css/select2.min.css',
    'assets/libs/select2/bootstrap-5-theme/select2-bootstrap-5-theme.min.css',
    'assets/libs/select2/bootstrap-5-theme/select2-bootstrap-5-theme.rtl.min.css',

));
$this->setVar('scripts', array(
    'assets/libs/fullcalendar/main.min.js',
    'assets/libs/fullcalendar/locales/es.js',
    'assets/libs/select2/js/select2.min.js',
    'assets/js/groups/detail.js',
));
?>
<?= $this->extend('layouts/main');?>
<?= $this->section('content');?>

<!-- Formulario Horario del grupo -->
<div id="teacher-data" data-id="<?= $group['teacher_id'] ?>"></div>
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="card-title mb-4">Datos del Grupo</h4>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex flex-row-reverse bd-highlight">
                        <div class="p-2 bd-highlight">
                            <a href="<?=base_url('groups')?>"><i class="bx bx-arrow-back"></i> Regresar</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="mb-3">
                    <a href="<?=base_url('groups/edit/'.$group['id'])?>" class="btn btn-success btn-label">
                        <i class="bx bxs-pencil label-icon"></i> Editar
                    </a>
                </div>
                <form id="group_form">
                    <div id="group-info" data-id="<?= $group['id'] ?>"></div>
                    <input type="hidden" name="id" value="<?= $group['id'] ?>">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">Grupo</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="<?= $group['name'] ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="teacher_id" class="form-label">Profesor</label>
                                <select class="form-control" name="teacher_id" id="teacher_id" disabled>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="observations" class="form-label">Observaciones</label>
                                <textarea class="form-control" name="observations" id="observations" rows="3"
                                    readonly><?= $group['observations'] ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Termina formulario del grupo -->

<!-- Inicia ventana modal -->
<div class="modal fade" id="event-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-3 px-4 border-bottom-0">
                <h5 class="modal-title" id="modal-title">Clase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body p-4">
                <form class="needs-validation" name="event-form" id="form-event" novalidate>
                    <input id="event-id" type="hidden" value="">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="course_id" class="form-label">Curso</label>
                                <select class="select2-search form-select" data-live-search="true" name="course_id"
                                    id="course_id" required>
                                    <option disabled selected value> -- Seleccione un curso -- </option>
                                </select>
                                <div class="invalid-feedback">Seleccione un curso de la lista</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Hora</label>
                                <select class="form-control form-select" name="startTime" id="event-startTime" required>
                                    <option disabled selected value> -- Seleccione una hora -- </option>
                                    <option value="07:00:00">07:00:00</option>
                                    <option value="08:00:00">08:00:00</option>
                                    <option value="09:00:00">09:00:00</option>
                                    <option value="10:00:00">10:00:00</option>
                                    <option value="11:00:00">11:00:00</option>
                                    <option value="12:00:00">12:00:00</option>
                                    <option value="13:00:00">13:00:00</option>
                                    <option value="14:00:00">14:00:00</option>
                                    <option value="15:00:00">15:00:00</option>
                                    <option value="16:00:00">16:00:00</option>
                                    <option value="17:00:00">17:00:00</option>
                                    <option value="18:00:00">18:00:00</option>
                                    <option value="19:00:00">19:00:00</option>
                                    <option value="20:00:00">20:00:00</option>
                                    <option value="21:00:00">21:00:00</option>
                                </select>
                                <div class="invalid-feedback">Seleccione una hora válida</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Día</label>
                                <select class="form-control form-select" name="daysOfWeek" id="event-daysOfWeek"
                                    required>
                                    <option disabled selected value> -- Selecciona el día -- </option>
                                    <option value="0">Domingo</option>
                                    <option value="1">Lunes</option>
                                    <option value="2">Martes</option>
                                    <option value="3">Miércoles</option>
                                    <option value="4">Jueves</option>
                                    <option value="5">Viernes</option>
                                    <option value="6">Sábado</option>
                                </select>
                                <div class="invalid-feedback">Selecione un día válido</div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-success btn-label" id="btn-save-event">
                            <i class="bx bx-save label-icon"></i>Guardar
                        </button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger btn-label" id="btn-delete-event">
                            <i class="bx bx-trash label-icon"></i>Eliminar
                        </button>
                    </div>
                </form>
            </div>
        </div> <!-- end modal-content-->
    </div>
</div>
<!-- Termina modal-->

<!-- Sección del calendario de clases -->
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="mb-3">
                    <button class="btn btn-primary btn-label" id="btn-new-event">
                        <i class="mdi mdi-plus-circle-outline label-icon"></i>Clase
                    </button>
                </div>
            </div>
            <div class="row">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
<!-- Termina sección del calendario de clases -->
<?= $this->endSection(); ?>