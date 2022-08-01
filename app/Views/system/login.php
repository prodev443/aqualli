<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Inicio de sesión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="Samuel Alderete Rayón" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?=base_url('assets/images/favicon_feda.png')?>">

    <!-- Bootstrap Css -->
    <link href="<?=base_url('assets/css/bootstrap.min.css')?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?=base_url('assets/css/icons.min.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url('assets/libs/sweetalert2/sweetalert2.min.css')?>" rel="stylesheet" type="text/css" />

    <!-- App Css-->
    <link href="<?=base_url('assets/css/app.min.css')?>" id="app-style" rel="stylesheet" type="text/css" />

    <script src="<?=base_url('assets/libs/jquery/jquery.min.js')?>"></script>
</head>

<body>
    <?php if(isset($failure)):?>
        <script>
            $(document).ready(
                function(){
                    Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '<?=esc($failure,'js')?>',
                    })
                }
            );
        </script>
    <?php endif;?>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">¡Bienvenido!</h5>
                                        <p>Inicio - Gestión Aqualli </p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="<?=base_url('assets/images/profile-img.png')?>" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <a href="/" class="auth-logo-light">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="<?=base_url('assets/images/aqualli_fb.jpg')?>" alt="Logo FEDA" class="rounded-circle"
                                                height="34">
                                        </span>
                                    </div>
                                </a>

                                <a href="/" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="<?=base_url('assets/images/aqualli_fb.jpg')?>" alt="Logo FEDA" class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form class="form-horizontal" action="<?=base_url('login/signin')?>" method="POST">

                                    <?= csrf_field(); ?>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Correo electrónico</label>
                                        <input type="email" class="form-control" id="username" name="email"
                                            placeholder="usuario@micorreo.com">
                                    </div>
                                    <?php if (isset($validation) && $validation->hasError('email')) { ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?= $validation->getError('email'); ?>
                                        </div>
                                    <?php } ?>

                                    <div class="mb-3">
                                        <label class="form-label">Contraseña</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" placeholder="Ingresa contraseña"
                                                aria-label="Password" aria-describedby="password-addon" name="password">
                                            <button class="btn btn-light " type="button" id="password-addon"><i
                                                    class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                    </div>
                                    <?php if (isset($validation) && $validation->hasError('password')) { ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?= $validation->getError('password'); ?>
                                        </div>
                                    <?php } ?>

                                    <div class="mt-3 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">
                                            Ingresar
                                        </button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <a href="auth-recoverpw" class="text-muted"><i class="mdi mdi-lock me-1"></i>
                                            ¿Olvidaste tu contraseña?</a>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">

                        <div>
                            <p>© <script>document.write(new Date().getFullYear())</script> FEDA
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- end account-pages -->

    <!-- JAVASCRIPT -->
    <script src="<?=base_url('assets/libs/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
    <script src="<?=base_url('assets/libs/metismenu/metisMenu.min.js')?>"></script>
    <script src="<?=base_url('assets/libs/simplebar/simplebar.min.js')?>"></script>
    <script src="<?=base_url('assets/libs/node-waves/waves.min.js')?>"></script>
    <script src="<?=base_url('assets/libs/sweetalert2/sweetalert2.min.js')?>"></script>

    <?= $this->include('application/js-script') ?>
    
    <!-- App js -->
    <script src="<?=base_url('assets/js/app.js')?>"></script>
</body>

</html>