<?php

class mainController extends Controller
{
    function home()
    {
        if (!isset($_SESSION['users'])) {
            $_SESSION['users'][] = array(
                "id" => 0,
                "username" => "admin",
                "firstname" => "admin",
                "lastname" => "admin",
                "email" => "ernestvilacasas@gmail.com",
                "birthdate" => null,
                "password" => "admin",
                "profile" => "admin.png",
                "token" => "abc123",
                "verified" => true
            );
            $_SESSION['users'][] = array(
                "id" => 1,
                "username" => "ernest",
                "firstname" => "Ernest",
                "lastname" => "Vila",
                "email" => "ernest.vila@cirvianum.cat",
                "birthdate" => null,
                "password" => "ernest",
                "profile" => "ernest.jpg",
                "token" => "abc321",
                "verified" => true
            );
            $_SESSION['users'][] = array(
                "id" => 2,
                "username" => "joan",
                "firstname" => "Joan",
                "lastname" => "Mañalich",
                "email" => "ernest.vila@cirvianum.cat",
                "birthdate" => null,
                "password" => "joan",
                "profile" => "joan.png",
                "token" => "cba123",
                "verified" => true
            );
        }

        $params = array(
            "title" => "Home",
        );
        $this->render('home', $params, 'site');
    }

    function reset()
    {
        unset($_SESSION['idsUser']);
        unset($_SESSION['idsFile']);
        unset($_SESSION['users']);
        if (isset($_SESSION['userLogged'])) {
            unset($_SESSION['userLogged']);
        }
        if (isset($_SESSION['files'])) {
            unset($_SESSION['files']);
        }
        if (isset($_SESSION['logs'])) {
            unset($_SESSION['logs']);
        }


        function deleteFolder($folderPath)
        {
            if (is_dir($folderPath)) {
                $files = scandir($folderPath);
                foreach ($files as $file) {
                    if ($file != "." && $file != "..") {
                        $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;
                        if (is_dir($filePath)) {
                            // Recursively delete subfolders
                            deleteFolder($filePath);
                        } else {
                            // Delete files inside the folder
                            unlink($filePath);
                        }
                    }
                }
                // Remove the empty folder
                rmdir($folderPath);
            }
        }

        // Usage
        $folderToDelete = __DIR__ . "/../../Public/Assets/files";
        deleteFolder($folderToDelete);
        header('Location: /main/home');
    }

    function err404()
    {
        $ruta = "";
        if (isset($_SESSION['userLogged'])) {
            $_SESSION['userLogged']['username'] == "admin" ? $ruta = "/user/admin" : $ruta = "/user/main";
        } else {
            $ruta = "/main/home";
        }
        $params = array(
            "title" => "404",
            "userLogged" => isset($_SESSION['userLogged']) ? $_SESSION['userLogged'] : null,
            "ruta" => $ruta,
        );
        $this->render('404', $params, 'site');
    }
}
