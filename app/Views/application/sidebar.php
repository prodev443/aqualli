<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title text-light" key="t-menu">Módulos</li>

                <?php if(isset($modulesAllowed) && in_array('teachers', $modulesAllowed)): ?>
                <!-- Sección de Profesores -->

                <li>
                    <a href="<?=base_url('teachers')?>" class="waves-effect text-light">
                        <i class="fas fa-user-tie text-light"></i><span>Profesores</span>
                    </a>
                </li>

                <?php endif;?>

                <?php if(isset($modulesAllowed) && in_array('students', $modulesAllowed)): ?>
                <!-- Sección de Alumnos -->

                <li>
                    <a href="<?=base_url('students')?>" class="waves-effect text-light">
                        <i class="dripicons-user text-light"></i><span>Alumnos</span>
                    </a>
                </li>

                <?php endif;?>

                <?php if(isset($modulesAllowed) && in_array('students', $modulesAllowed)): ?>
                <!-- Sección de Grupos -->

                <li>
                    <a href="<?=base_url('groups')?>" class="waves-effect text-light">
                        <i class="dripicons-user-group text-light"></i><span>Grupos</span>
                    </a>
                </li>

                <?php endif;?>

                <?php if (isset($modulesAllowed) && in_array('courses', $modulesAllowed)) : ?>
                <!-- Sección de Cursos -->
                <li>
                    <a href="<?=base_url('courses')?>" class="waves-effect text-light">
                        <i class="bx bx-swim text-light"></i><span>Cursos</span>
                    </a> 
                </li>
                <?php endif ?>

                <?php if(isset($modulesAllowed) && in_array('users', $modulesAllowed)): ?>
                <!-- Sección de Usuarios -->

                <li>
                    <a href="<?=base_url('users')?>" class="waves-effect text-light">
                        <i class="fas fa-user text-light"></i><span>Usuarios</span>
                    </a>
                </li>

                <?php endif;?>

                <?php if($is_admin): ?>
                <!-- Sección de Administrador -->
                <li class="menu-title text-light" key="t-menu">Administrador</li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect text-light">
                        <i class="bx bx-cog text-light"></i>
                        <span key="t-dashboards">Configuración</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?=base_url('system/roles')?>" key="t-default" class="text-light">
                            <i class="fas fa-users text-light"></i> Roles
                        </a></li>
                    </ul>
                </li>

                <?php endif;?>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->