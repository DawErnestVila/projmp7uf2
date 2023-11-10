<!doctype html>
<html lang="ca">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>Dr0ive - <?php echo $parameters["title"] ?></title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <link rel="icon" href="../../../Public/Assets/img/triangle-half.svg">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body style="background-color: #e0e0e0;">
    <nav class="d-flex justify-content-between p-3 bg-dark text-white">
        <div class="left d-flex align-items-center">
            <i class="bi bi-triangle-half"> - Dr0ive</i>
            <div class="d-flex align-items-center">
                <?php
                if (isset($parameters['userLogged']) && !empty($parameters['userLogged'])) {
                    if ($parameters['userLogged']['username'] != "admin") {
                        echo '<a class="text-decoration-none mx-3 btn btn-info" href="/user/main">Home</a>';
                    } else {
                        echo '<a class="text-decoration-none mx-3 btn btn-info" href="/user/admin">Home</a>';
                    }
                } else {
                    echo '<a class="text-decoration-none mx-3 btn btn-info" href="/main/home">Home</a>';
                }
                ?>
            </div>
        </div>
        <div class="right d-flex">
            <?php
            if (isset($parameters['userLogged']) && !empty($parameters['userLogged'])) {
                if ($parameters['userLogged']['username'] != "admin") {
            ?>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-success mx-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        + Fitxer
                    </button>

                    <!-- Modal -->
                    <div class="modal fade text-black" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <form action="/file/store" enctype="multipart/form-data" method="post">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Afageix un fitxer</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="file" name="fitxer" id="fitxer">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancela</button>
                                        <button type="submit" class="btn btn-primary">Guarda Fitxer</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <?
                }
                ?>
                <div class="d-flex align-items-center mx-1"><a class="text-white font-weight-bold text-decoration-none mx-2 dropdown-toggle" href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"><img src="<?php echo '/Public/Assets/img/profiles/' . $parameters['userLogged']['profile'] ?> " alt="Foto de Perfil" height="40px"></a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <?php
                        if ($parameters['userLogged']['username'] != "admin") {
                        ?>
                            <li><a class="dropdown-item" href="/user/update">Editar Usuari</a></li>
                        <?php
                        } else {
                        ?>
                            <li><a class="dropdown-item" href="/user/logs">Logs</a></li>
                        <? } ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/user/logOut">LogOut</a></li>
                    </ul>
                </div>
            <?php
            } else {
            ?>
                <div class="d-flex align-items-center">
                    <a class="text-decoration-none mx-2 btn btn-light" href="/user/login">Login</a>
                </div>
            <?php
            }
            ?>
        </div>
    </nav>
    <?php echo $content ?>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>