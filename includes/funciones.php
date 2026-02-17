<?php
function iniciarSorteo() {
    $jugadores = $_SESSION['jugadores'];
    $equipos = $GLOBALS['equipos'];
    
    shuffle($jugadores);
    shuffle($equipos);
    
    $_SESSION['sorteo_jugadores'] = $jugadores;
    $_SESSION['sorteo_equipos'] = $equipos;
    $_SESSION['sorteo_activo'] = true;
    $_SESSION['sorteo_paso'] = 1;
    $_SESSION['sorteo_indice'] = 0;
    
    return true;
}

function avanzarSorteo() {
    if (!$_SESSION['sorteo_activo']) {
        return false;
    }
    
    if ($_SESSION['sorteo_paso'] == 1) {
        $_SESSION['sorteo_paso'] = 2;
        
        $jugador = $_SESSION['sorteo_jugadores'][$_SESSION['sorteo_indice']];
        $equipo = $_SESSION['sorteo_equipos'][$_SESSION['sorteo_indice']];
        $_SESSION['asignaciones'][$jugador] = $equipo;
        
    } elseif ($_SESSION['sorteo_paso'] == 2) {
        $_SESSION['sorteo_indice']++;
        $_SESSION['sorteo_paso'] = 1;
        
        if ($_SESSION['sorteo_indice'] >= count($_SESSION['sorteo_jugadores'])) {
            $_SESSION['sorteo_activo'] = false;
            $_SESSION['sorteo_paso'] = 0;
        }
    }
    
    return true;
}

function obtenerEstadoSorteo() {
    return [
        'activo' => $_SESSION['sorteo_activo'],
        'paso' => $_SESSION['sorteo_paso'],
        'indice' => $_SESSION['sorteo_indice'],
        'jugador_actual' => $_SESSION['sorteo_activo'] ? $_SESSION['sorteo_jugadores'][$_SESSION['sorteo_indice']] : null,
        'equipo_actual' => $_SESSION['sorteo_activo'] ? $_SESSION['sorteo_equipos'][$_SESSION['sorteo_indice']] : null,
        'total' => count($_SESSION['jugadores'])
    ];
}

function realizarSorteoGrupos() {
    if (empty($_SESSION['asignaciones'])) {
        return false;
    }
    
    $equipos_asignados = array_column($_SESSION['asignaciones'], 'nombre');
    shuffle($equipos_asignados);
    
    $_SESSION['grupos'] = [
        'grupo_a' => array_slice($equipos_asignados, 0, 4),
        'grupo_b' => array_slice($equipos_asignados, 4, 4)
    ];
    
    return true;
}
// includes/functions.php

// Función para calcular tabla de posiciones
function calcularTablaPosiciones($equipos_grupo, $calendario) {
    $tabla = [];
    
    // Inicializar equipos en la tabla
    foreach ($equipos_grupo as $equipo) {
        $tabla[$equipo] = [
            'pj' => 0,  // Partidos jugados
            'pg' => 0,  // Partidos ganados
            'pe' => 0,  // Partidos empatados
            'pp' => 0,  // Partidos perdidos
            'gf' => 0,  // Goles a favor
            'gc' => 0,  // Goles en contra
            'dg' => 0,  // Diferencia de goles
            'pts' => 0, // Puntos
            'tr' => 0   // Tarjetas rojas
        ];
    }
    
    // Procesar partidos jugados
    foreach ($calendario as $jornada) {
        foreach ($jornada as $partido) {
            if ($partido['jugado']) {
                $local = $partido['local'];
                $visitante = $partido['visitante'];
                $goles_local = $partido['goles_local'];
                $goles_visitante = $partido['goles_visitante'];
                
                // Actualizar partidos jugados
                $tabla[$local]['pj']++;
                $tabla[$visitante]['pj']++;
                
                // Actualizar goles
                $tabla[$local]['gf'] += $goles_local;
                $tabla[$local]['gc'] += $goles_visitante;
                $tabla[$visitante]['gf'] += $goles_visitante;
                $tabla[$visitante]['gc'] += $goles_local;
                
                // Actualizar diferencia de goles
                $tabla[$local]['dg'] = $tabla[$local]['gf'] - $tabla[$local]['gc'];
                $tabla[$visitante]['dg'] = $tabla[$visitante]['gf'] - $tabla[$visitante]['gc'];
                
                // Actualizar tarjetas rojas
                $tabla[$local]['tr'] += $partido['tarjetas_rojas_local'];
                $tabla[$visitante]['tr'] += $partido['tarjetas_rojas_visitante'];
                
                // Determinar resultado y puntos
                if ($goles_local > $goles_visitante) {
                    $tabla[$local]['pg']++;
                    $tabla[$local]['pts'] += 3;
                    $tabla[$visitante]['pp']++;
                } elseif ($goles_local < $goles_visitante) {
                    $tabla[$visitante]['pg']++;
                    $tabla[$visitante]['pts'] += 3;
                    $tabla[$local]['pp']++;
                } else {
                    $tabla[$local]['pe']++;
                    $tabla[$local]['pts'] += 1;
                    $tabla[$visitante]['pe']++;
                    $tabla[$visitante]['pts'] += 1;
                }
            }
        }
    }
    
    // Ordenar tabla por puntos, diferencia de goles y goles a favor
    uasort($tabla, function($a, $b) {
        if ($a['pts'] != $b['pts']) {
            return $b['pts'] - $a['pts'];
        }
        if ($a['dg'] != $b['dg']) {
            return $b['dg'] - $a['dg'];
        }
        return $b['gf'] - $a['gf'];
    });
    
    return $tabla;
}


?>