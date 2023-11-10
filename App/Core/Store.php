<?php

class Store
{

    public static function file($src, $dst, $filename)
    {
        $url_dst_folder = $_SERVER['DOCUMENT_ROOT'] . "/Public/Assets/" . $dst;
        $url_dst_file = $url_dst_folder . $filename;

        if (!file_exists($url_dst_folder)) {
            mkdir($url_dst_folder, 0777, true);
        }

        if (move_uploaded_file($src, $url_dst_file)) {
            return true;
        } else {
            $_SESSION['flash'] = "Error a l'hora de penjar el fitxer";
            return false;
        }
    }

    public static function newFile($src, $dst, $filename)
    {
        $url_dst_folder =  $url_dst_folder = $_SERVER['DOCUMENT_ROOT'] . "/Public/Assets/" . $dst;
        $url_dst_file = $url_dst_folder . $filename;

        if (!file_exists($url_dst_folder)) {
            mkdir($url_dst_folder, 0777, true);
        }

        if (move_uploaded_file($src, $url_dst_file)) {
            return 'Fitxer afegit correctament';
        } else {
            return 'Error al carregar el fitxer';
        }
    }
}
