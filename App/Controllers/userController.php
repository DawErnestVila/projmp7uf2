<?php
include_once(__DIR__ . "/../Helpers/userHelper.php");
include_once(__DIR__ . "/../Models/User.php");
include_once(__DIR__ . "/../Models/Log.php");
include_once(__DIR__ . "/../Core/Store.php");
include_once(__DIR__ . "/../Core/Mailer.php");

class userController extends Controller
{

    function create()
    {
        unset($_SESSION['rememberLogin']);
        $params = array(
            "title" => "Register",
            "flash" => isset($_GET['flash']) ? $_GET['flash'] : null,
            "rememberStore" => isset($_SESSION['rememberStore']) ? $_SESSION['rememberStore'] : null,
        );
        $this->render('user/create', $params, 'site');
        unset($_SESSION['rememberStore']);
    }

    function login()
    {
        unset($_SESSION['rememberStore']);
        $params = array(
            "title" => "Login",
            "flash" => isset($_GET['flash']) ? $_GET['flash'] : null,
            "rememberLogin" => isset($_SESSION['rememberLogin']) ? $_SESSION['rememberLogin'] : null,
        );
        $this->render('user/login', $params, 'site');
        unset($_SESSION['rememberLogin']);
    }

    function store()
    {
        if (isset($_POST['username']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['birthdate']) && isset($_POST['password'])) {
            unset($_SESSION['rememberStore']);
            $user = array(
                "id" => $_SESSION['idsUser']++,
                "username" => $_POST['username'],
                "firstname" => $_POST['first_name'],
                "lastname" => $_POST['last_name'],
                "email" => $_POST['email'],
                "birthdate" => $_POST['birthdate'],
                "password" => $_POST['password'],
                "profile" => null,
                "token" => generateToken(),
                "verified" => false
            );

            $_SESSION['rememberStore'] = $user;



            $correct = check_new_user($user, $_POST['confirm_password']);


            $file = $_FILES['profile_image']['name'];
            $nameFileArray = explode('.', $file);
            $user['profile'] = $user['username'] . "." . end($nameFileArray);



            $url_temp = $_FILES['profile_image']['tmp_name'];
            $url_dest = "img/profiles/";

            $fileCorrect = Store::file($url_temp, $url_dest, $user['profile']);



            if ($fileCorrect && $correct) {
                $userModel = new User();
                $userModel->store($user);

                $mailer = new Mailer();
                $mailer->mailServerSetup();
                $mailer->addRec(array($user['email']));
                $mailer->addVerifyContent($user);

                $mailer->send();

                $_SESSION['flash'] = "Usuari creat correctament, verifica el correu per poder accedir";
                $now = new DateTime('now', new DateTimeZone('Europe/Madrid'));
                $log = array(
                    "time" => $now->format('d/m/Y H:i:s'),
                    "message" => "S'ha creat l'usuari " . $user['username'],
                    "color" => "verd",
                );
                $logModel = new Log();
                $logModel->store($log);

                header('Location: /user/login/');
            } else {
                header('Location: /user/create/');
            }
        } else {
            $_SESSION['flash'] = "No tens permís per entrar >:(";
            header('Location: /main/home/');
        }
    }

    function verify()
    {
        if (isset($_GET['username']) && isset($_GET['token'])) {
            $userModel = new User();
            $user = $userModel->getByUsername($_GET['username']);
            if ($user['token'] == $_GET['token']) {
                $user['verified'] = true;
            }
            $userModel->update($user);

            $_SESSION['flash'] = 'Usuari confirmat';
            $params = array(
                "title" => "Login",
            );

            $now = new DateTime('now', new DateTimeZone('Europe/Madrid'));
            $log = array(
                "time" => $now->format('d/m/Y H:i:s'),
                "message" => $user['username'] . " ha verificat el correu",
                "color" => "violeta",
            );
            $logModel = new Log();
            $logModel->store($log);

            $this->render('user/login', $params, 'site');
        } else {
            $_SESSION['flash'] = "No tens permís per entrar >:(";
            header('Location: /main/home/');
        }
    }

    function checklogin()
    {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $_SESSION['rememberLogin'] = array(
                "username" => $username,
            );
            $userModel = new User();
            $allusers = $userModel->getAll();

            foreach ($allusers as $user) {
                if ($user['username'] == $username && $user['password'] == $password && $user['verified']) {
                    $_SESSION['flash'] = "Benvigut, " . $user['username'];
                    $_SESSION['userLogged'] = $user;
                    unset($_SESSION['flash']);
                    if ($username == "admin") {
                        $now = new DateTime('now', new DateTimeZone('Europe/Madrid'));
                        $log = array(
                            "time" => $now->format('d/m/Y H:i:s'),
                            "message" => "Ha iniciat sessió l'usuari " . $user['username'],
                            "color" => "lila-clar",
                        );
                        $logModel = new Log();
                        $logModel->store($log);
                        header('Location: /user/admin');
                    } else {
                        $now = new DateTime('now', new DateTimeZone('Europe/Madrid'));
                        $log = array(
                            "time" => $now->format('d/m/Y H:i:s'),
                            "message" => "Ha iniciat sessió l'usuari " . $user['username'],
                            "color" => "lila-clar",
                        );
                        $logModel = new Log();
                        $logModel->store($log);
                        header('Location: /user/main/');
                    }
                    break;
                } else {
                    if ($user['username'] == $username && $user['password'] == $password) {
                        $_SESSION['flash'] = 'Et falta verificar el teu compte per correu';
                        break;
                    } else {
                        $_SESSION['flash'] = 'Credencials no correctes';
                    }
                    header('Location: /user/login/');
                }
            }
        } else {
            $_SESSION['flash'] = "No tens permís per entrar >:(";
            header('Location: /main/home/');
        }
    }

    function main()
    {
        if (isset($_SESSION['userLogged'])) {
            unset($_SESSION['rememberLogin']);
            $userModel = new User();
            $usuaris = $userModel->getAll();
            $params = array(
                "title" => "Main",
                "userLogged" => $_SESSION['userLogged'],
                "files" => isset($_SESSION['files']) ? $_SESSION['files'] : null,
                "users" => $usuaris,
                "flash" => isset($_GET['flash']) ? $_GET['flash'] : null
            );
            $this->render('user/main', $params, 'site');
        } else {
            $_SESSION['flash'] = "No tens permís per entrar >:(";
            header('Location: /main/home');
        }
    }

    function logOut()
    {
        if (isset($_SESSION['userLogged'])) {
            $now = new DateTime('now', new DateTimeZone('Europe/Madrid'));
            $log = array(
                "time" => $now->format('d/m/Y H:i:s'),
                "message" => "Ha sortit l'usuari " . $_SESSION['userLogged']['username'],
                "color" => "gris-clar",
            );
            $logModel = new Log();
            $logModel->store($log);
            unset($_SESSION['userLogged']);
            header('Location: /main/home');
        }
    }

    function sendMail()
    {
        if (isset($_SESSION['userLogged']) && isset($_POST['idSend']) && isset($_POST['subject']) && isset($_POST['body'])) {
            $userModel = new User();
            $userTo = $userModel->getById($_POST['idSend']);
            $usuaris = $userModel->getAll();
            $emailTo = $userTo['email'];
            $mailer = new Mailer();
            $mailer->mailServerSetup();
            $mailer->addRecCustom(array($emailTo), $_SESSION['userLogged']['username']);
            $mailer->addVerifyContentCustom($_POST['subject'], $_POST['body']);

            $mailer->send();
            $now = new DateTime('now', new DateTimeZone('Europe/Madrid'));
            $log = array(
                "time" => $now->format('d/m/Y H:i:s'),
                "message" => "L'usuari " . $_SESSION['userLogged']['username'] . " ha enviat un email a " . $userTo['username'],
                "color" => "taronja",
            );
            $logModel = new Log();
            $logModel->store($log);
            $_SESSION['flash'] = "Email enviat correctament";

            header('Location: /user/main/');
        } else {
            $_SESSION['flash'] = "No tens permís per entrar >:(";
            header('Location: /main/home/');
        }
    }

    function admin()
    {
        if (isset($_SESSION['userLogged']) && $_SESSION['userLogged']['username'] == "admin") {
            unset($_SESSION['rememberLogin']);
            $userModel = new User();
            $usuaris = $userModel->getAll();
            $params = array(
                "title" => "Dashboard",
                "userLogged" => $_SESSION['userLogged'],
                "files" => isset($_SESSION['files']) ? $_SESSION['files'] : null,
                "users" => $usuaris,
                "flash" => isset($_GET['flash']) ? $_GET['flash'] : null
            );
            $this->render('user/admin', $params, 'site');
        } else {
            $_SESSION['flash'] = "No tens permís per entrar >:(";
            header('Location: /main/home/');
        }
    }

    function delete()
    {
        if (isset($_SESSION['userLogged']) && $_SESSION['userLogged']['username'] == "admin") {
            $IDuser = $_GET['userId'];
            $userModel = new User();
            $username = $userModel->getById($IDuser);
            $userModel->delete($IDuser);

            if ($username['username'] != "ernest" && $username['username'] != "joan") {
                $file_pointer = __DIR__ . "/../../Public/Assets/img/profiles/" . $username['profile'];
                if (!unlink($file_pointer)) {
                    $_SESSION['flash'] = "Hi ha hagut un error al eliminar la foto de perfil";
                }
            }

            deleteFiles($username['username']);
            $now = new DateTime('now', new DateTimeZone('Europe/Madrid'));
            $log = array(
                "time" => $now->format('d/m/Y H:i:s'),
                "message" => "Has eliminat a l'usuari " . $username['username'] . " i tots els seus fitxers",
                "color" => "vermell-clar",
            );
            $logModel = new Log();
            $logModel->store($log);
            header('Location: /user/admin/');
        } else {
            $_SESSION['flash'] = "No tens permís per entrar >:(";
            header('Location: /main/home/');
        }
    }

    function update()
    {
        if (isset($_SESSION['userLogged']) && $_SESSION['userLogged']['username'] != "admin") {
            $params = array(
                "title" => "Update",
                "userLogged" => $_SESSION['userLogged'],
                "flash" => isset($_GET['flash']) ? $_GET['flash'] : null
            );
            $this->render('user/update', $params, 'site');
        } else {
            $_SESSION['flash'] = "No tens permís per entrar >:(";
            header('Location: /main/home/');
        }
    }

    function checkUpdate()
    {
        if (isset($_SESSION['userLogged']) && $_SESSION['userLogged']['username'] != "admin" && isset($_POST['new_password'])) {
            $userModel = new User();
            $user = $userModel->getById($_SESSION['userLogged']['id']);
            if (isset($_POST['new_password'])) {
                if ($_POST['new_password'] == $_POST['confirm_new_password'] && strlen($_POST['new_password']) >= 8) {
                    $user['password'] = $_POST['new_password'];
                    $userModel->update($user);
                    $_SESSION['flash'] = 'Contrasenya editada correctament';
                    $now = new DateTime('now', new DateTimeZone('Europe/Madrid'));
                    $log = array(
                        "time" => $now->format('d/m/Y H:i:s'),
                        "message" => "L'usuari " . $user['username'] . " ha acutalitzat la seva contrasenya",
                        "color" => "blau-fosc",
                    );
                    $logModel = new Log();
                    $logModel->store($log);
                    header('Location: /user/main');
                } else {
                    $_SESSION['flash'] = 'No coincideixen les dues contrasenyes noves';
                    header('Location: /user/update');
                }
            }
            header('Location: /user/update');
        } else {
            $_SESSION['flash'] = "No tens permís per entrar >:(";
            header('Location: /main/home/');
        }
    }

    function logs()
    {
        if (isset($_SESSION['userLogged']) && $_SESSION['userLogged']['username'] == "admin") {
            $logsModel = new Log();
            $logs = $logsModel->getAll();
            $params = array(
                "title" => "Logs",
                "userLogged" => $_SESSION['userLogged'],
                "logs" => $logs,
            );
            $this->render('user/logs', $params, 'site');
        } else {
            $_SESSION['flash'] = "No tens permís per entrar >:(";
            header('Location: /main/home/');
        }
    }
}
