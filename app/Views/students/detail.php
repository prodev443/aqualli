<?php
$this->setVar('title', 'Detalle');
$this->setVar('pagetitle', 'Alumnos');
$this->setVar('css_styles', array(
    'assets/libs/tabulator/css/tabulator_bootstrap3.min.css',
    'assets/libs/tabulator/css/tabulator_custom.css',
    'assets/libs/fullcalendar/main.min.css',
    'assets/libs/bootstrap/icons/bootstrap-icons.css',
));
$this->setVar('scripts', array(
    'assets/libs/tabulator/js/tabulator.min.js',
    'assets/custom/js/table_library.js', // Funciones para tabulator
    'assets/libs/fullcalendar/main.min.js',
    'assets/libs/fullcalendar/locales/es.js',
    'assets/js/students/detail.js',
));
?>
<?=$this->extend('layouts/main');?>
<?=$this->section('content');?>
<!-- Formulario Alumno -->
<div id="student-data" data-id="<?=$student['id']?>"></div>
<div id="group-data" data-id="<?=$student['group_id']?>"></div>
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="card-title mb-4">Datos del Alumno</h4>
                </div>
                <div class="col-sm-6">
                    <div class="d-flex flex-row-reverse bd-highlight">
                        <div class="p-2 bd-highlight">
                            <a href="<?=base_url('students')?>"><i class="bx bx-arrow-back"></i> Regresar</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="nav-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                        type="button" role="tab" aria-controls="details" aria-selected="true">Detalles</button>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="details" role="tabpanel" aria-labelledby="details-tab">
                    <br>
                    <form id="student-form">
                        <input type="hidden" id="id" name="id" value="<?=$student['id']?>">
                        <div class="row">
                            <div class="d-flex gap-2 flex-wrap">
                                <div class="mb-3">
                                    <a href="<?=base_url('students/edit/' . $student['id'])?>"
                                        class="btn btn-success btn-label">
                                        <i class="bx bxs-pencil label-icon"></i>&nbsp;Editar
                                    </a>&nbsp;
                                    <?php if (!empty($student['photo_path'])): ?>
                                    <button id="deletePhotoBtn" type="button" class="btn btn-danger btn-label">
                                        <i class="bx bxs-trash label-icon"></i>Eliminar Fotografía
                                    </button>
                                    <?php endif;?>
                                </div>
                                <div class="dropdown">
                                    <a href="#" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Formatos&nbsp;<i class="mdi mdi-chevron-down"></i>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" target="_blank"><i
                                                class="mdi mdi-eye label-icon"></i>&nbsp;En
                                            construcción</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($student['photo_path'])): ?>
                        <div class="row" id="photo">
                            <div>
                                <img src="<?=base_url('students/resources/getphoto/' . $student['id'])?>"
                                    class="img-thumbnail" onerror="this.style.display='none'" width="75px">
                            </div>
                        </div>
                        <?php endif;?>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="<?=$student['first_name']?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Apellido Paterno</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="<?=$student['last_name']?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="second_last_name" class="form-label">Apellido Materno</label>
                                    <input type="text" class="form-control" id="second_last_name"
                                        name="second_last_name" value="<?=$student['second_last_name']?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="group" class="form-label">Grupo</label>
                                    <input type="text" class="form-control" id="group" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="birthdate" class="form-label">Fecha de nacimiento</label>
                                    <input type="date" class="form-control" id="birthdate" name="birthdate"
                                        value="<?=$student['birthdate']?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="<?=$student['email']?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" id="phone_number" name="phone_number"
                                        value="<?=$student['phone_number']?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="mobile_number" class="form-label">Móvil</label>
                                    <input type="tel" class="form-control" id="mobile_number" name="mobile_number"
                                        value="<?=$student['mobile_number']?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="address_line" class="form-label">Dirección</label>
                                    <textarea class="form-control" id="address_line" name="address_line"
                                        readonly><?=$student['address_line']?></textarea>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="address_postal_code" class="form-label">C.P.</label>
                                    <input type="text" class="form-control" id="address_postal_code"
                                        name="address_postal_code" value="<?=$student['address_postal_code']?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="address_city" class="form-label">Ciudad</label>
                                    <input type="text" class="form-control" id="address_city" name="address_city"
                                        value="<?=$student['address_city']?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <input type="checkbox" class="form-check-input" name="is_active"
                                        <?=($student['is_active'] == 1) ? 'checked' : ''?> disabled>
                                    <label for="is_active" class="form-label">Activo</label>
                                </div>
                            </div>
                        </div>

                        <!-- Agregar esta funcionalidad -->
                        <!-- <div>
                            <button type="button" class="btn btn-primary btn-label" id="gen-user-btn">
                                <i class="fas fa-user"></i>&nbsp;Generar usuario
                            </button>
                        </div> -->

                    </form>
                </div>
            </div>
        </div>
        <!-- end card body -->
    </div>
</div>
<!-- Termina formulario -->

<!-- Tabla de cursos y calificaciones -->
<div class="row">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">
                Cursos del alumno
            </h4>
            <div class="row">
                <div id="courses-table"></div>
            </div>
        </div>
    </div>
</div>
<!-- Termina tabla de cursos y calificaciones -->

<!-- Inicia calendario de clases -->
<div class="row">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Clases</h4>
            <div id="student-calendar"></div>
        </div>
    </div>
</div>
<!-- Termina calendario de clases -->

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
                    <input id="event-id" type="hidden">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="course_id" class="form-label">Curso</label>
                                <select class="select2-search form-select" name="course_id" id="course_id" disabled>
                                    <option disabled selected value> -- Seleccione un curso -- </option>
                                </select>
                                <div class="invalid-feedback">Seleccione un curso de la lista</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Hora</label>
                                <select class="form-control form-select" name="startTime" id="event-startTime" disabled>
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
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Día</label>
                                <select class="form-control form-select" name="daysOfWeek" id="event-daysOfWeek"
                                    disabled>
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
                </form>
            </div>
        </div> <!-- end modal-content-->
    </div>
</div>
<!-- Termina modal-->
<?=$this->endSection();?>