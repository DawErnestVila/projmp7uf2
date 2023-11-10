<main class="container">
    <h1 class="my-4">ADMIN</h1>
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
    <div class="m-4">
        <h2>Usuaris</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Contrasenya</th>
                    <th scope="col">Email</th>
                    <th scope="col">Accions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($parameters['users'] as $user) {
                    if ($user['username'] != "admin") {
                ?>
                        <tr>
                            <th scope="row"><? echo $user['id'] ?></th>
                            <td><? echo $user['username'] ?></td>
                            <td><? echo $user['password'] ?></td>
                            <td><? echo $user['email'] ?></td>
                            <td>
                                <a href="/user/delete/?userId=<? echo $user['id'] ?>" class="btn btn-danger">Eliminar</a>
                            </td>
                        </tr>
                <?
                    }
                }


                ?>
            </tbody>
        </table>
    </div>


    <div class="m-4">
        <h2>Arxius</h2>
        <?php
        if (isset($parameters['files'])) {
        ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nom del Propietari</th>
                        <th scope="col">Nom del Fitxer</th>
                        <th scope="col">Accions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($parameters['files'] as $file) {
                    ?>
                        <tr>
                            <th scope="row"><? echo $file['id'] ?></th>
                            <td><? echo $file['nameUser'] ?></td>
                            <td><a href="<? echo $file['name'] ?>" data-bs-toggle="modal" data-bs-target="#fileModal<?php echo $file['id'] ?>"><? echo $file['name'] ?></a></td>
                            <td>
                                <a href="/file/delete/?name=<? echo $file['name'] ?>&id=<? echo $file['id'] ?>&username=<? echo $file['nameUser'] ?>" class="btn btn-danger">Eliminar</a>
                            </td>
                        </tr>
                        <div class="modal fade" id="fileModal<?php echo $file['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog <? echo $file['extension'] == 'pdf' || $file['extension'] == 'txt' ? 'modal-xl' : null ?>">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $file['name'] ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php
                                        switch ($file['extension']) {
                                            case 'pdf':
                                        ?>
                                                <object data="../../../Public/Assets/files/<? echo $file['nameUser'] . '/' . $file['name'] ?>" width="100%" height="700hv" type="application/pdf"></object>
                                            <?
                                                break;
                                            case 'txt':
                                            ?>
                                                <object data="../../../Public/Assets/files/<? echo $file['nameUser'] . '/' . $file['name'] ?>" type="text/plain" width="100%" height="700vh""></object>
                                                <?
                                                break;
                                            case 'png':
                                            case 'jpg':
                                            case 'jpeg':
                                            case 'svg':
                                            case 'gif':
                                            case 'raw':
                                                ?>
                                                    <img src=" ../../../Public/Assets/files/<? echo $file['nameUser'] . '/' . $file['name'] ?>" alt="Image Uploaded From User" width="100%" />
                                            <?
                                                break;
                                            default:
                                            ?>
                                                <p class="text-danger fw-bold">
                                                    Vista prèvia no disponible
                                                </p>
                                        <?
                                                break;
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?
                    }


                    ?>
                </tbody>
            </table>
        <?
        } else {
            echo '<h3 class="my-4 bg-info p-3">No hi han fitxers a monitoritzar</h3>';
        }

        ?>
    </div>
</main>