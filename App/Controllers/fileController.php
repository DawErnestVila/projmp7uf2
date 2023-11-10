<?php
include_once(__DIR__ . "/../Models/File.php");
include_once(__DIR__ . "/../Models/User.php");
include_once(__DIR__ . "/../Models/Log.php");
include_once(__DIR__ . "/../Core/Store.php");
class fileController extends Controller
{
    function store()
    {
        if (isset($_SESSION['userLogged']) && isset($_FILES)) {
            $file = array(
                "id" => $_SESSION['idsFile']++,
                "userID" => $_SESSION['userLogged']['id'],
                "nameUser" => $_SESSION['userLogged']['username'],
                "name" => $_FILES['fitxer']['name'],
                "extension" => null,
                "shared" => array(),
            );

            $nameFileArray = explode('.', $file['name']);
            $file['extension'] = end($nameFileArray);

            $fileModel = new File();
            $fileModel->store($file);

            $url_temp = $_FILES['fitxer']['tmp_name'];
            $url_dest = "files/" . $_SESSION['userLogged']['username'] . "/";

            $_SESSION['flash'] = Store::newFile($url_temp, $url_dest, $file['name']);
            $now = new DateTime('now', new DateTimeZone('Europe/Madrid'));
            $log = array(
                "time" => $now->format('d/m/Y H:i:s'),
                "message" => "L'usuari " . $_SESSION['userLogged']['username'] . " ha afegit el fitxer ' " . $file['name'] . " '",
                "color" => "verd-fosc",
            );
            $logModel = new Log();
            $logModel->store($log);
            header('Location: /user/main/');
        } else {
            $_SESSION['flash'] = "No tens permís per entrar >:(";
            header('Location: /main/home/');
        }
    }

    function delete()
    {
        if (isset($_SESSION['userLogged']) && isset($_GET['username']) && isset($_GET['name']) && isset($_GET['id'])) {
            $username = basename($_GET['username']);
            $file = basename($_GET['name']);
            $fileModel = new File();
            $fileModel->delete($_GET['id']);
            $file_pointer = __DIR__ . "/../../Public/Assets/files/" . $username . "/" . $file;

            if (!unlink($file_pointer)) {
                $_SESSION['flash'] = "Hi ha hagut un error al eliminar " . $file;
            } else {
                $_SESSION['flash'] = "S'ha eliminat correctament el fitxer " . $file;
                $now = new DateTime('now', new DateTimeZone('Europe/Madrid'));
                $log = array(
                    "time" => $now->format('d/m/Y H:i:s'),
                    "message" => "L'usuari " . $_SESSION['userLogged']['username'] . " ha eliminat el fitxer ' " . $file . " '",
                    "color" => "vermell",
                );
                $logModel = new Log();
                $logModel->store($log);
            }

            if ($_SESSION['userLogged']['username'] == "admin") {
                header('Location: /user/admin/');
            } else {
                header('Location: /user/main/');
            }
        } else {
            $_SESSION['flash'] = "No tens permís per entrar >:(";
            header('Location: /main/home/');
        }
    }

    function download()
    {
        if (isset($_SESSION['userLogged']) && isset($_GET['name'])) {
            if (isset($_GET['username'])) {
                $file_path = __DIR__ . "/../../Public/Assets/files/" . $_GET['username'] . "/" . $_GET['name'];
            } else {
                $file_path = __DIR__ . "/../../Public/Assets/files/" . $_SESSION['userLogged']['username'] . "/" . $_GET['name'];
            }

            if (file_exists($file_path)) {
                // Set headers to force download
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
                header('Content-Length: ' . filesize($file_path));

                // Read the file and output it to the browser
                readfile($file_path);

                $now = new DateTime('now', new DateTimeZone('Europe/Madrid'));
                $log = array(
                    "time" => $now->format('d/m/Y H:i:s'),
                    "message" => "L'usuari " . $_SESSION['userLogged']['username'] . " ha descarregat el fitxer ' " . $_GET['name'] . " '",
                    "color" => "blau-clar",
                );
                $logModel = new Log();
                $logModel->store($log);
            } else {
                echo 'File not found.';
            }
        } else {
            $_SESSION['flash'] = "No tens permís per entrar >:(";
            header('Location: /main/home/');
        }
    }

    function share()
    {
        if (isset($_SESSION['userLogged'])) {
            $userModel = new User();
            $allusers = $userModel->getAll();
            $params = array(
                "title" => "Share File",
                "users" => $allusers,
                "userLogged" => $_SESSION['userLogged'],
                "idFile" => $_GET['id']
            );
            $this->render('file/share', $params, 'site');
        } else {
            $_SESSION['flash'] = "No tens permís per entrar >:(";
            header('Location: /main/home/');
        }
    }

    function shareWith()
    {
        if (isset($_SESSION['userLogged']) && isset($_GET['idUser']) && isset($_GET['idFile'])) {
            $idShared = $_GET['idUser'];
            $idFile = $_GET['idFile'];

            $fileModel = new File();
            $allusers = $fileModel->getAll();

            foreach ($allusers as $file) {
                if ($file['id'] == $idFile) {
                    $afegit = false;
                    foreach ($file['shared'] as $compartit) {
                        if ($compartit == $idShared) {
                            $afegit = true;
                            $_SESSION['flash'] = 'Ja ho has compartit amb aquest usuari';
                            break;
                        }
                    }

                    if (!$afegit) {
                        $file['shared'][] = $idShared;
                        $fileModel->update($file);
                        $_SESSION['flash'] = 'Compartit correctament';

                        $userModel = new User();
                        $sharedWith = $userModel->getById($idShared);
                        $now = new DateTime('now', new DateTimeZone('Europe/Madrid'));
                        $log = array(
                            "time" => $now->format('d/m/Y H:i:s'),
                            "message" => "L'usuari " . $_SESSION['userLogged']['username'] . " ha compartit el fitxer ' " . $file['name'] . " ' amb " . $sharedWith['username'],
                            "color" => "groc",
                        );
                        $logModel = new Log();
                        $logModel->store($log);
                    }
                    break;
                }
            }
            header('Location: /file/share/?id=' . $idFile);
        } else {
            $_SESSION['flash'] = "No tens permís per entrar >:(";
            header('Location: /main/home/');
        }
    }
}
