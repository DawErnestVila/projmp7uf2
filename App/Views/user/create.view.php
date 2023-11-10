<div class="container mt-3">

    <?php
    if (isset($_SESSION['flash'])) {
    ?>
        <div class="alert alert-info p-3 mx-auto my-3 text-center col-md-6 fw-bolder" role="alert">
            <?php echo $_SESSION['flash']; ?>
        </div>
    <?php
        unset($_SESSION['flash']);
    }

    ?>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2>Sign Up</h2>
                    <form action="/user/store" method="post" enctype="multipart/form-data" method="post">
                        <div class="form-floating mt-2">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Usuari.." value="<?= isset($parameters['rememberStore']['username']) ? $parameters['rememberStore']['username'] : null ?>">
                            <label for="username">Usuari</label>
                        </div>
                        <div class="form-floating mt-2">
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Nom.." value="<?= isset($parameters['rememberStore']['firstname']) ? $parameters['rememberStore']['firstname'] : null ?>">
                            <label for="first_name">Nom</label>
                        </div>
                        <div class="form-floating mt-2">
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Cognom.." value="<?= isset($parameters['rememberStore']['lastname']) ? $parameters['rememberStore']['lastname'] : null ?>">
                            <label for="last_name">Cognom</label>
                        </div>
                        <div class="form-floating mt-2">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email.." value="<?= isset($parameters['rememberStore']['email']) ? $parameters['rememberStore']['email'] : null ?>">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mt-2">
                            <input type="date" class="form-control" id="birthdate" name="birthdate" max="<?php echo date('Y-m-d'); ?>" value="<?= isset($parameters['rememberStore']['birthdate']) ? $parameters['rememberStore']['birthdate'] : null; ?>">
                            <label for="birthdate">Data de Naixement</label>
                        </div>
                        <div class="form-group mt-2">
                            <label for="profile_image">Imatge de Perfil</label>
                            <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
                        </div>
                        <div class="form-floating mt-2">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Contrasenya..">
                            <label for="password">Contrasenya</label>
                        </div>
                        <div class="form-floating mt-2">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirmar..">
                            <label for="confirm_password">Confirmar Contrasenya</label>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Sign Up</button>
                        <div class="text-end">
                            <small class=""><a href="/user/login">Ja tens compte? Logueja't</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>