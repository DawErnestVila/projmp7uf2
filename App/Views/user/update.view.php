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
                    <h2>Editant a <? echo $parameters['userLogged']['username'] ?></h2>
                    <form action="/user/checkUpdate" method="POST" enctype="multipart/form-data">
                        <div class="form-group my-3">
                            <label for="new_password">Nova Contrasenya</label>
                            <input type="password" class="form-control" name="new_password" id="new_password">
                        </div>
                        <div class="form-group my-3">
                            <label for="confirm_new_password">Confirmar Nova Contrasenya</label>
                            <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password">
                        </div>
                        <button class="btn btn-success" type="submit">Guardar Canvis</button>
                        <a href="/user/main" class="btn btn-danger mx-3">Cancel·lar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>