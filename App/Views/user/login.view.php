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
                    <h2>Login</h2>
                    <form method="POST" enctype="multipart/form-data" action="/user/checklogin">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Usuari" value="<?= isset($parameters['rememberLogin']['username']) ? $parameters['rememberLogin']['username'] : null ?>">
                            <label for="username">Usuari</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Contrasenya">
                            <label for="password">Contrasenya</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                        <div class="text-end">
                            <small class=""><a href="/user/create">No tens compte? Registra't</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>