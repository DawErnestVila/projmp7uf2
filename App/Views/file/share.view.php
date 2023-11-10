<main class="mx-4 container">
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
    <h1 class="my-4">Comparteix el Fitxer!</h1>
    <section class="d-flex flex-row">
        <?php
        foreach ($parameters['users'] as $user) {
            if ($user['username'] != $parameters['userLogged']['username'] && $user['username'] != "admin") {
        ?>
                <div class="container">
                    <section class="mx-auto my-5" style="max-width: 23rem;">

                        <div class="card testimonial-card mt-2 mb-3">
                            <div class="card-up aqua-gradient"></div>
                            <div class="avatar mx-auto white">
                                <img src="<? echo '/Public/Assets/img/profiles/' . $user['profile'] ?>" class="mt-3" alt="Foto de perfil" height="170px">
                            </div>
                            <div class="card-body text-center">
                                <h4 class="card-title font-weight-bold"><? echo $user['username'] ?></h4>
                                <hr>
                                <p><a class="btn btn-outline-primary" href="/file/shareWith/?idUser=<? echo $user['id'] ?>&idFile=<? echo $parameters['idFile'] ?>">Comparteix</a></p>
                            </div>
                        </div>

                    </section>
                </div>
        <?
            }
        }

        ?>

    </section>
</main>