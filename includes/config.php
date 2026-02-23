<?php
session_start();

// Datos iniciales
$jugadores = [
    "Romo", "Alejandro", "Mario", "Sergio", 
    "David", "Gabriel", "Adrian", "Alvaro", "Javi"
];

$equipos = [
    ["nombre" => "Real Madrid", "jugadores" => ["Portero", "Defensa1", "Defensa2", "Defensa3", "Defensa4", "Medio1", "Medio2", "Medio3", "Delantero1", "Delantero2", "Delantero3"]],
    ["nombre" => "FC Barcelona", "jugadores" => ["Portero", "Defensa1", "Defensa2", "Defensa3", "Defensa4", "Medio1", "Medio2", "Medio3", "Delantero1", "Delantero2", "Delantero3"]],
    ["nombre" => "Manchester City", "jugadores" => ["Portero", "Defensa1", "Defensa2", "Defensa3", "Defensa4", "Medio1", "Medio2", "Medio3", "Delantero1", "Delantero2", "Delantero3"]],
    ["nombre" => "Bayern Munich", "jugadores" => ["Portero", "Defensa1", "Defensa2", "Defensa3", "Defensa4", "Medio1", "Medio2", "Medio3", "Delantero1", "Delantero2", "Delantero3"]],
    ["nombre" => "Paris Saint-Germain", "jugadores" => ["Portero", "Defensa1", "Defensa2", "Defensa3", "Defensa4", "Medio1", "Medio2", "Medio3", "Delantero1", "Delantero2", "Delantero3"]],
    ["nombre" => "Liverpool", "jugadores" => ["Portero", "Defensa1", "Defensa2", "Defensa3", "Defensa4", "Medio1", "Medio2", "Medio3", "Delantero1", "Delantero2", "Delantero3"]],
    ["nombre" => "Juventus", "jugadores" => ["Portero", "Defensa1", "Defensa2", "Defensa3", "Defensa4", "Medio1", "Medio2", "Medio3", "Delantero1", "Delantero2", "Delantero3"]],
    ["nombre" => "Chelsea", "jugadores" => ["Portero", "Defensa1", "Defensa2", "Defensa3", "Defensa4", "Medio1", "Medio2", "Medio3", "Delantero1", "Delantero2", "Delantero3"]]
];

// Inicializar sesión si no existe
if (!isset($_SESSION['jugadores'])) {
    $_SESSION['jugadores'] = $jugadores;
}

if (!isset($_SESSION['asignaciones'])) {
    $_SESSION['asignaciones'] = [];
}

if (!isset($_SESSION['grupos'])) {
    $_SESSION['grupos'] = ['grupo_a' => [], 'grupo_b' => []];
}

if (!isset($_SESSION['sorteo_activo'])) {
    $_SESSION['sorteo_activo'] = false;
}

if (!isset($_SESSION['sorteo_paso'])) {
    $_SESSION['sorteo_paso'] = 0;
}

if (!isset($_SESSION['sorteo_indice'])) {
    $_SESSION['sorteo_indice'] = 0;
}

if (!isset($_SESSION['sorteo_jugadores'])) {
    $_SESSION['sorteo_jugadores'] = [];
}

if (!isset($_SESSION['sorteo_equipos'])) {
    $_SESSION['sorteo_equipos'] = [];
}

?>