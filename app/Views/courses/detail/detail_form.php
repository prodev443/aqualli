<div class="row">
    <div class="col-md-12">
        <div class="mb-3">
            <a href="<?=base_url('courses/edit/'.$course['id'])?>" class="btn btn-success">
                <i class="bx bxs-pencil"></i> Editar
            </a>
        </div>
    </div>
</div>
<form id="course_form">
    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label id="code_label" for="code" class="form-label">Código</label>
                <input id="code" name="code" type="text" class="form-control" value="<?= $course['code'] ?>" readonly />
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="name" id="name" value="<?= $course['name'] ?>" readonly >
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" name="description" id="description" rows="3" readonly ><?= $course['description'] ?></textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-check mb-3">
                <input id="is_active" name="is_active" type="checkbox" class="form-check-input" value="1" <?= $course['is_active'] == 1 ? 'checked' : '' ?> disabled />
                <label id="is_active_label" class="form-label" for="is_active">Activo</label>
            </div>
        </div>
    </div>
</form>