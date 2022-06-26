<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function esUltimo(String $actual, String $proximo) : bool {
    if($actual !== $proximo) {
        return true;
    } else {
        return false;
    }

}

//Función que revisa que el usuario este autenticado
function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

//Función que revisa que el admin este autenticado
function isAdmin() {
    if(!isset($_SESSION['admin'])) {
        header('Location: /');
    }
}