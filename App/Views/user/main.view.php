<div class="mx-4">
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
    <main class="d-flex flex-row justify-content-between">
        <div class="flex-grow-1 border-end border-dark m-4 flex-column">
            <h2>Els meus fitxers</h2>
            <div class="row mb-4">
                <?php
                $hasFiles = false;
                if (isset($parameters['files']) && !is_null($parameters['files'])) {
                    foreach ($parameters['files'] as $file) {
                        if ($file['userID'] == $parameters['userLogged']['id']) {
                            $hasFiles = true;
                            switch ($file['extension']) {
                                case 'pdf':
                                    $imgSrc = "../../../Public/Assets/img/pdf.png";
                                    $altText = "PDF";
                                    break;
                                case 'txt':
                                    $imgSrc = "../../../Public/Assets/img/text.png";
                                    $altText = "Text";
                                    break;
                                case 'png':
                                case 'jpg':
                                case 'jpeg':
                                case 'svg':
                                case 'gif':
                                case 'raw':
                                    $imgSrc = "../../../Public/Assets/img/picture.png";
                                    $altText = "Image";
                                    break;
                                case 'php':
                                case 'js':
                                case 'java':
                                case 'py':
                                case 'c':
                                case 'html':
                                case 'php':
                                    $imgSrc = "../../../Public/Assets/img/code.png";
                                    $altText = "Codi";
                                    break;
                                default:
                                    $imgSrc = "../../../Public/Assets/img/file.png";
                                    $altText = "File";
                                    break;
                            }
                ?>
                            <div class="col-md-3">
                                <div class="media">
                                    <a href="<? echo $file['name'] ?>" type="button" class="btn" data-bs-toggle="modal" data-bs-target="#fileModal<?php echo $file['id'] ?>">
                                        <img src="<?php echo $imgSrc; ?>" class="mr-3" alt="<?php echo $altText; ?>">
                                        <div>
                                            <?php echo substr($file['name'], 0, 30);
                                            echo strlen($file['name']) > 30 ? "..." : null ?>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <!-- Modal -->
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
                                                    <object data="../../../Public/Assets/files/<? echo $parameters['userLogged']['username'] . '/' . $file['name'] ?>" width="100%" height="700hv" type="application/pdf"></object>
                                                <?
                                                    break;
                                                case 'txt':
                                                ?>
                                                    <object data="../../../Public/Assets/files/<? echo $parameters['userLogged']['username'] . '/' . $file['name'] ?>" type="text/plain" width="100%" height="700vh""></object>
                                            <?
                                                    break;
                                                case 'png':
                                                case 'jpg':
                                                case 'jpeg':
                                                case 'svg':
                                                case 'gif':
                                                case 'raw':
                                            ?>
                                                <img src=" ../../../Public/Assets/files/<? echo $parameters['userLogged']['username'] . '/' . $file['name'] ?>" alt="Image Uploaded From User" width="100%" />
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
                                        <div class="modal-footer">
                                            <a href="/file/share/?id=<? echo $file['id'] ?>" class="btn btn-success">Comparteix!</a>
                                            <a href="/file/download/?name=<? echo $file['name'] ?>" class="btn btn-info">Descarrega</a>
                                            <a class="btn btn-danger" href="/file/delete/?name=<? echo $file['name'] ?>&id=<? echo $file['id'] ?>&username=<? echo $file['nameUser'] ?>" class="btn btn-info">Elimina</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    }
                    if (!$hasFiles) {
                        ?>
                        <h5>No tens fitxers encara</h5>
                    <?php
                    }
                } else {
                    ?>
                    <h5>No tens fitxers encara</h5>
                <?php
                }
                ?>
            </div>
            <div class="invisible my-5">...</div>
            <h2 class="mt-5 mb-3">Fitxers compartits amb mi</h2>
            <div class="row">
                <?php
                $hasFiles = false;
                if (isset($parameters['files']) && !is_null($parameters['files'])) {
                    foreach ($parameters['files'] as $file) {
                        foreach ($file['shared'] as $shared) {
                            if ($shared == $parameters['userLogged']['id']) {
                                $hasFiles = true;
                                $username = $file['nameUser'];
                                switch ($file['extension']) {
                                    case 'pdf':
                                        $imgSrc = "../../../Public/Assets/img/pdf.png";
                                        $altText = "PDF";
                                        break;
                                    case 'txt':
                                        $imgSrc = "../../../Public/Assets/img/text.png";
                                        $altText = "Text";
                                        break;
                                    case 'png':
                                    case 'jpg':
                                    case 'jpeg':
                                    case 'svg':
                                    case 'gif':
                                    case 'raw':
                                        $imgSrc = "../../../Public/Assets/img/picture.png";
                                        $altText = "Image";
                                        break;
                                    case 'php':
                                    case 'js':
                                    case 'java':
                                    case 'py':
                                    case 'c':
                                    case 'html':
                                    case 'php':
                                        $imgSrc = "../../../Public/Assets/img/code.png";
                                        $altText = "Codi";
                                        break;
                                    default:
                                        $imgSrc = "../../../Public/Assets/img/file.png";
                                        $altText = "File";
                                        break;
                                }
                ?>
                                <div class="col-md-3">
                                    <div class="media">
                                        <a href="<? echo $file['name'] ?>" type="button" class="btn" data-bs-toggle="modal" data-bs-target="#fileModal<?php echo $file['id'] ?>">
                                            <img src="<?php echo $imgSrc; ?>" class="mr-3" alt="<?php echo $altText; ?>">
                                            <div class="media-body">
                                                <?php echo $file['name']; ?>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <!-- Modal -->
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
                                                        <object data="../../../Public/Assets/files/<? echo $username . '/' . $file['name'] ?>" width="100%" height="700hv" type="application/pdf"></object>
                                                    <?
                                                        break;
                                                    case 'txt':
                                                    ?>
                                                        <object data="../../../Public/Assets/files/<? echo $username . '/' . $file['name'] ?>" type="text/plain" width="100%" height="700vh""></object>
                                                <?
                                                        break;
                                                    case 'png':
                                                    case 'jpg':
                                                    case 'jpeg':
                                                    case 'svg':
                                                    case 'gif':
                                                    case 'raw':
                                                ?>
                                                    <img src=" ../../../Public/Assets/files/<? echo $username . '/' . $file['name'] ?>" alt="Image Uploaded From User" width="100%" />
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
                                            <div class="modal-footer">
                                                <a href="/file/download/?name=<? echo $file['name'] ?>&username=<? echo $username ?>" class="btn btn-info">Descarrega</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                    }
                    if (!$hasFiles) {
                        ?>
                        <h5>Ningú ha compartit fitxers amb tu</h5>
                    <?php
                    }
                } else {
                    ?>
                    <h5>Ningú ha compartit fitxers amb tu</h5>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="users m-4" style="width: 10%;">
            <h2>Xateja</h2>
            <?php
            foreach ($parameters['users'] as $user) {
                if ($user['username'] != $parameters['userLogged']['username'] && $user['username'] != 'admin') {
            ?>
                    <div class="card mt-2">
                        <button class="btn" data-bs-toggle="modal" data-bs-target="#sendMail<? echo $user['id'] ?>">
                            <div class="card-body text-start">
                                <h5 class="card-title"><?php echo $user['username'] ?></h5>
                            </div>
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="sendMail<? echo $user['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Enviar Correu a <? echo $user['username'] ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="/user/sendMail" enctype="multipart/form-data" method="post">
                                        <div class="mb-3 form-floating">
                                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Assumpte del correu">
                                            <label for="subject" class="form-label">Assumpte</label>
                                        </div>
                                        <div class="mb-3 form-floating">
                                            <textarea class="form-control" id="body" name="body" rows="5" placeholder="Cos del correu"></textarea>
                                            <label for="body" class="form-label">Cos del correu</label>
                                        </div>
                                        <input type="hidden" name="idSend" value="<? echo $user['id'] ?>">
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            <?
                }
            }
            ?>
        </div>
    </main>
</div>