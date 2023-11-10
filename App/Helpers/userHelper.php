<?php
include_once(__DIR__ . "/../Models/File.php");

function generateToken()
{
    $caracters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $token = substr(str_shuffle($caracters), 0, 12);
    return $token;
}

function getAge($birthdate)
{
    $today = new DateTime();
    $diff = $today->diff(new DateTime($birthdate));
    return $diff->y;
}

function deleteFiles($username)
{
    $folderPath = __DIR__ . "/../../Public/Assets/files" . "/" . $username;
    if (is_dir($folderPath)) {
        $files = scandir($folderPath);
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                // $filePath = $folderPath . "/" . $file;
                $fileModel = new File();
                $fitxer = $fileModel->getByName($file);
                // $fileModel->delete($fitxer['id']);
                // unlink($filePath);
                $file = basename($file);
                $fileModel = new File();
                $fileModel->delete($fitxer['id']);
                $file_pointer = __DIR__ . "/../../Public/Assets/files/" . $username . "/" . $file;

                if (!unlink($file_pointer)) {
                    $_SESSION['flash'] = "Hi ha hagut un error al eliminar " . $username;
                } else {
                    $_SESSION['flash'] = "S'ha eliminat correctament a l'usuari " . $username;
                }
            }
        }
    }
}

function check_new_user($user, $password2)
{
    $username = $user['username'];
    $firstName = $user['firstname'];
    $lastName = $user['lastname'];
    $email = $user['email'];
    $dateBirth = $user['birthdate'];
    $edat = getAge($dateBirth);
    $password1 = $user['password'];
    $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    $correct = true;
    if ($edat < 13) {
        $_SESSION['flash'] = "Has de tenir com a mínim 13 anys per poder utilitzar la web";
        $correct = false;
    }
    if (empty($username)) {
        $_SESSION['flash'] = "El nom d'usuari no pot estar buit";
        $correct = false;
    }
    if (empty($firstName)) {
        $_SESSION['flash'] = "El teu nom no pot estar buit";
        $correct = false;
    }
    if (empty($lastName)) {
        $_SESSION['flash'] = "El Cognom no pot estar buit";
        $correct = false;
    }
    if (empty($email)) {
        $_SESSION['flash'] = "L'email no pot estar buit";
        $correct = false;
    }
    if (empty($password1)) {
        $_SESSION['flash'] = "La contrasenya no pot estar buida";
        $correct = false;
    }
    if ($password1 == $password2) {
        if (strlen($password1) < 8) {
            $_SESSION['flash'] = "La contrasenya ha de tenir almenys 8 caràcters";
            $correct = false;
        }
    } else {
        $_SESSION['flash'] = "Les constrasenyes no coincideixen";
        $correct = false;
    }
    if (strlen($username) < 4 || strlen($username) > 20) {
        $_SESSION['flash'] = "El nom d'usuari ha de tenir entre 4 i 20 caràcters";
        $correct = false;
    }
    if (!preg_match($pattern, $email)) {
        $_SESSION['flash'] = "L'email no és vàlid, ex: exemple@exemple.cat";
        $correct = false;
    }
    if ($correct) {
        $correct = check_user_exists($username, $email);
    }
    return $correct;
}

function check_user_exists($username, $email)
{
    foreach ($_SESSION['users'] as $user) {
        if ($user['username'] === $username) {
            $_SESSION['flash'] = "El nom d'usuari " . $username . " ja existeix";
            return false;
        } elseif ($user['email'] === $email) {
            $_SESSION['flash'] = "L'email " . $email . " ja ha sigut registrat";
            return false;
        }
    };
    return true;
}
