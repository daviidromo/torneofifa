<?php
require_once 'includes/config.php';
require_once 'includes/funciones.php';

// Verificar que los grupos están sorteados y hay partidos jugados
if (!isset($_SESSION['grupos_sorteados'])) {
    header('Location: grupos.php');
    exit();
}

// Función para obtener los equipos clasificados de cada grupo
function obtenerClasificados($tabla_grupo) {
    $clasificados = [];
    $posicion = 0;
    foreach ($tabla_grupo as $equipo => $datos) {
        $clasificados[] = $equipo;
        $posicion++;
    }
    return $clasificados;
}

// Calcular tablas de posiciones
$tabla_a = calcularTablaPosiciones(
    $_SESSION['grupos_sorteados']['grupo_a']['equipos'],
    $_SESSION['grupos_sorteados']['grupo_a']['calendario']
);

$tabla_b = calcularTablaPosiciones(
    $_SESSION['grupos_sorteados']['grupo_b']['equipos'],
    $_SESSION['grupos_sorteados']['grupo_b']['calendario']
);

// Obtener clasificados en orden
$clasificados_a = obtenerClasificados($tabla_a); // [1ro, 2do, 3ro, 4to]
$clasificados_b = obtenerClasificados($tabla_b); // [1ro, 2do, 3ro, 4to]

// Inicializar eliminatorias de DOBLE ELIMINACIÓN si no existen
if (!isset($_SESSION['eliminatorias'])) {
    $_SESSION['eliminatorias'] = [
        // WINNER BRACKET
        'winner_bracket' => [
            'cuartos' => [
                // MATCH1: 1ro A vs 4to B
                ['local' => $clasificados_a[0], 'visitante' => $clasificados_b[3], 
                 'goles_local' => null, 'goles_visitante' => null, 'jugado' => false,
                 'tarjetas_rojas_local' => 0, 'tarjetas_rojas_visitante' => 0,
                 'tarjetas_amarillas_local' => 0, 'tarjetas_amarillas_visitante' => 0],
                // MATCH2: 2do B vs 3ro A
                ['local' => $clasificados_b[1], 'visitante' => $clasificados_a[2], 
                 'goles_local' => null, 'goles_visitante' => null, 'jugado' => false,
                 'tarjetas_rojas_local' => 0, 'tarjetas_rojas_visitante' => 0,
                 'tarjetas_amarillas_local' => 0, 'tarjetas_amarillas_visitante' => 0],
                // MATCH3: 1ro B vs 4to A
                ['local' => $clasificados_b[0], 'visitante' => $clasificados_a[3], 
                 'goles_local' => null, 'goles_visitante' => null, 'jugado' => false,
                 'tarjetas_rojas_local' => 0, 'tarjetas_rojas_visitante' => 0,
                 'tarjetas_amarillas_local' => 0, 'tarjetas_amarillas_visitante' => 0],
                // MATCH4: 2do A vs 3ro B
                ['local' => $clasificados_a[1], 'visitante' => $clasificados_b[2], 
                 'goles_local' => null, 'goles_visitante' => null, 'jugado' => false,
                 'tarjetas_rojas_local' => 0, 'tarjetas_rojas_visitante' => 0,
                 'tarjetas_amarillas_local' => 0, 'tarjetas_amarillas_visitante' => 0]
            ],
            'semifinales' => [
                // MATCH5: Ganador MATCH1 vs Ganador MATCH2
                ['local' => null, 'visitante' => null, 'goles_local' => null, 'goles_visitante' => null, 'jugado' => false,
                 'tarjetas_rojas_local' => 0, 'tarjetas_rojas_visitante' => 0,
                 'tarjetas_amarillas_local' => 0, 'tarjetas_amarillas_visitante' => 0],
                // MATCH6: Ganador MATCH3 vs Ganador MATCH4
                ['local' => null, 'visitante' => null, 'goles_local' => null, 'goles_visitante' => null, 'jugado' => false,
                 'tarjetas_rojas_local' => 0, 'tarjetas_rojas_visitante' => 0,
                 'tarjetas_amarillas_local' => 0, 'tarjetas_amarillas_visitante' => 0]
            ],
            'final' => [
                // MATCH7: Ganador MATCH5 vs Ganador MATCH6
                ['local' => null, 'visitante' => null, 'goles_local' => null, 'goles_visitante' => null, 'jugado' => false,
                 'tarjetas_rojas_local' => 0, 'tarjetas_rojas_visitante' => 0,
                 'tarjetas_amarillas_local' => 0, 'tarjetas_amarillas_visitante' => 0]
            ]
        ],
        
        // LOSER BRACKET
        'loser_bracket' => [
            'ronda1' => [
                // MATCH8: Perdedor MATCH1 vs Perdedor MATCH2
                ['local' => null, 'visitante' => null, 'goles_local' => null, 'goles_visitante' => null, 'jugado' => false,
                 'tarjetas_rojas_local' => 0, 'tarjetas_rojas_visitante' => 0,
                 'tarjetas_amarillas_local' => 0, 'tarjetas_amarillas_visitante' => 0],
                // MATCH9: Perdedor MATCH3 vs Perdedor MATCH4
                ['local' => null, 'visitante' => null, 'goles_local' => null, 'goles_visitante' => null, 'jugado' => false,
                 'tarjetas_rojas_local' => 0, 'tarjetas_rojas_visitante' => 0,
                 'tarjetas_amarillas_local' => 0, 'tarjetas_amarillas_visitante' => 0]
            ],
            'ronda2' => [
                // MATCH10: Ganador MATCH8 vs Perdedor MATCH6
                ['local' => null, 'visitante' => null, 'goles_local' => null, 'goles_visitante' => null, 'jugado' => false,
                 'tarjetas_rojas_local' => 0, 'tarjetas_rojas_visitante' => 0,
                 'tarjetas_amarillas_local' => 0, 'tarjetas_amarillas_visitante' => 0],
                // MATCH11: Ganador MATCH9 vs Perdedor MATCH5
                ['local' => null, 'visitante' => null, 'goles_local' => null, 'goles_visitante' => null, 'jugado' => false,
                 'tarjetas_rojas_local' => 0, 'tarjetas_rojas_visitante' => 0,
                 'tarjetas_amarillas_local' => 0, 'tarjetas_amarillas_visitante' => 0]
            ],
            'ronda3' => [
                // MATCH12: Ganador MATCH10 vs Ganador MATCH11
                ['local' => null, 'visitante' => null, 'goles_local' => null, 'goles_visitante' => null, 'jugado' => false,
                 'tarjetas_rojas_local' => 0, 'tarjetas_rojas_visitante' => 0,
                 'tarjetas_amarillas_local' => 0, 'tarjetas_amarillas_visitante' => 0]
            ],
            'final' => [
                // MATCH13: Ganador MATCH12 vs Perdedor MATCH7
                ['local' => null, 'visitante' => null, 'goles_local' => null, 'goles_visitante' => null, 'jugado' => false,
                 'tarjetas_rojas_local' => 0, 'tarjetas_rojas_visitante' => 0,
                 'tarjetas_amarillas_local' => 0, 'tarjetas_amarillas_visitante' => 0]
            ]
        ],
        
        // GRAN FINAL
        'gran_final' => [
            // MATCH14: Ganador Winner Bracket vs Ganador Loser Bracket
            ['local' => null, 'visitante' => null, 'goles_local' => null, 'goles_visitante' => null, 'jugado' => false,
             'tarjetas_rojas_local' => 0, 'tarjetas_rojas_visitante' => 0,
             'tarjetas_amarillas_local' => 0, 'tarjetas_amarillas_visitante' => 0]
        ],
        
        // TRUE FINAL (solo si el ganador del Loser Bracket gana la Gran Final)
        'true_final' => [
            // MATCH15: Solo si es necesario
            ['local' => null, 'visitante' => null, 'goles_local' => null, 'goles_visitante' => null, 'jugado' => false,
             'tarjetas_rojas_local' => 0, 'tarjetas_rojas_visitante' => 0,
             'tarjetas_amarillas_local' => 0, 'tarjetas_amarillas_visitante' => 0]
        ]
    ];
}

// Función para obtener ganador de un partido
function obtenerGanador($partido) {
    if (!$partido['jugado']) return null;
    if ($partido['goles_local'] > $partido['goles_visitante']) {
        return $partido['local'];
    } else {
        return $partido['visitante'];
    }
}

// Función para obtener perdedor de un partido
function obtenerPerdedor($partido) {
    if (!$partido['jugado']) return null;
    if ($partido['goles_local'] > $partido['goles_visitante']) {
        return $partido['visitante'];
    } else {
        return $partido['local'];
    }
}

// Función para obtener equipos eliminados (solo del Loser Bracket)
function obtenerEquiposEliminados() {
    $eliminados = [];
    
    if (!isset($_SESSION['eliminatorias'])) {
        return $eliminados;
    }
    
    $eliminatorias = $_SESSION['eliminatorias'];
    
    // Solo considerar equipos eliminados en el Loser Bracket
    $eliminados_loser_bracket = [];
    
    // Revisar partidos jugados en el Loser Bracket
    foreach ($eliminatorias['loser_bracket'] as $ronda_nombre => $ronda) {
        foreach ($ronda as $partido) {
            if ($partido['jugado']) {
                $perdedor = obtenerPerdedor($partido);
                if ($perdedor) {
                    $jugador = obtenerJugadorPorEquipo($perdedor);
                    $eliminados_loser_bracket[$perdedor] = [
                        'equipo' => $perdedor,
                        'jugador' => $jugador,
                        'ronda' => $ronda_nombre
                    ];
                }
            }
        }
    }
    
    // AÑADIR: Perdedor de la Gran Final
    if (isset($eliminatorias['gran_final'][0]) && $eliminatorias['gran_final'][0]['jugado']) {
        $perdedor_gf = obtenerPerdedor($eliminatorias['gran_final'][0]);
            $jugador = obtenerJugadorPorEquipo($perdedor_gf);
            $eliminados_loser_bracket[$perdedor_gf] = [
                'equipo' => $perdedor_gf,
                'jugador' => $jugador,
                'ronda' => 'gran_final'
            ];
        
    }
    
    // AÑADIR: Perdedor de la True Final (si existe)
    if (isset($eliminatorias['true_final'][0]) && $eliminatorias['true_final'][0]['jugado']) {
        $perdedor_tf = obtenerPerdedor($eliminatorias['true_final'][0]);
        if ($perdedor_tf && $perdedor_tf !== $campeon) {
            $jugador = obtenerJugadorPorEquipo($perdedor_tf);
            $eliminados_loser_bracket[$perdedor_tf] = [
                'equipo' => $perdedor_tf,
                'jugador' => $jugador,
                'ronda' => 'true_final'
            ];
        }
    }
    
    // Solo mostrar equipos que perdieron y no están en rondas posteriores
    foreach ($eliminados_loser_bracket as $equipo => $datos) {
        $sigue_en_competencia = false;
        
        // Verificar si el equipo está en algún partido posterior del Loser Bracket
        foreach ($eliminatorias['loser_bracket'] as $ronda) {
            foreach ($ronda as $partido) {
                if (($partido['local'] === $equipo || $partido['visitante'] === $equipo) && !$partido['jugado']) {
                    $sigue_en_competencia = true;
                    break 2;
                }
            }
        }
        
        // Verificar si está en la Gran Final (no jugada)
        if (isset($eliminatorias['gran_final'][0]) && 
            !$eliminatorias['gran_final'][0]['jugado'] && 
            ($eliminatorias['gran_final'][0]['local'] === $equipo || $eliminatorias['gran_final'][0]['visitante'] === $equipo)) {
            $sigue_en_competencia = true;
        }
        
        // Verificar si está en la True Final (no jugada)
        if (isset($eliminatorias['true_final'][0]) && 
            !$eliminatorias['true_final'][0]['jugado'] && 
            ($eliminatorias['true_final'][0]['local'] === $equipo || $eliminatorias['true_final'][0]['visitante'] === $equipo)) {
            $sigue_en_competencia = true;
        }
        
        if (!$sigue_en_competencia) {
            $eliminados[] = $datos;
        }
    }
    
    return $eliminados;
}

// Función para actualizar todo el bracket después de un partido
function actualizarBracketCompleto() {
    $wb = &$_SESSION['eliminatorias']['winner_bracket'];
    $lb = &$_SESSION['eliminatorias']['loser_bracket'];
    $gf = &$_SESSION['eliminatorias']['gran_final'];
    $tf = &$_SESSION['eliminatorias']['true_final'];
    
    // Actualizar semifinales del Winner Bracket
    if ($wb['cuartos'][0]['jugado'] && $wb['cuartos'][1]['jugado']) {
        $wb['semifinales'][0]['local'] = obtenerGanador($wb['cuartos'][0]);
        $wb['semifinales'][0]['visitante'] = obtenerGanador($wb['cuartos'][1]);
    }
    
    if ($wb['cuartos'][2]['jugado'] && $wb['cuartos'][3]['jugado']) {
        $wb['semifinales'][1]['local'] = obtenerGanador($wb['cuartos'][2]);
        $wb['semifinales'][1]['visitante'] = obtenerGanador($wb['cuartos'][3]);
    }
    
    // Actualizar final del Winner Bracket
    if ($wb['semifinales'][0]['jugado'] && $wb['semifinales'][1]['jugado']) {
        $wb['final'][0]['local'] = obtenerGanador($wb['semifinales'][0]);
        $wb['final'][0]['visitante'] = obtenerGanador($wb['semifinales'][1]);
    }
    
    // Actualizar Loser Bracket Ronda 1
    if ($wb['cuartos'][0]['jugado'] && $wb['cuartos'][1]['jugado']) {
        $lb['ronda1'][0]['local'] = obtenerPerdedor($wb['cuartos'][0]);
        $lb['ronda1'][0]['visitante'] = obtenerPerdedor($wb['cuartos'][1]);
    }
    
    if ($wb['cuartos'][2]['jugado'] && $wb['cuartos'][3]['jugado']) {
        $lb['ronda1'][1]['local'] = obtenerPerdedor($wb['cuartos'][2]);
        $lb['ronda1'][1]['visitante'] = obtenerPerdedor($wb['cuartos'][3]);
    }
    
    // Actualizar Loser Bracket Ronda 2
    if ($lb['ronda1'][0]['jugado'] && $wb['semifinales'][1]['jugado']) {
        $lb['ronda2'][0]['local'] = obtenerGanador($lb['ronda1'][0]);
        $lb['ronda2'][0]['visitante'] = obtenerPerdedor($wb['semifinales'][1]);
    }
    
    if ($lb['ronda1'][1]['jugado'] && $wb['semifinales'][0]['jugado']) {
        $lb['ronda2'][1]['local'] = obtenerGanador($lb['ronda1'][1]);
        $lb['ronda2'][1]['visitante'] = obtenerPerdedor($wb['semifinales'][0]);
    }
    
    // Actualizar Loser Bracket Ronda 3
    if ($lb['ronda2'][0]['jugado'] && $lb['ronda2'][1]['jugado']) {
        $lb['ronda3'][0]['local'] = obtenerGanador($lb['ronda2'][0]);
        $lb['ronda3'][0]['visitante'] = obtenerGanador($lb['ronda2'][1]);
    }
    
    // Actualizar Final del Loser Bracket
    if ($lb['ronda3'][0]['jugado'] && $wb['final'][0]['jugado']) {
        $lb['final'][0]['local'] = obtenerGanador($lb['ronda3'][0]);
        $lb['final'][0]['visitante'] = obtenerPerdedor($wb['final'][0]);
    }
    
    // Actualizar Gran Final
    if ($wb['final'][0]['jugado'] && $lb['final'][0]['jugado']) {
        $gf[0]['local'] = obtenerGanador($wb['final'][0]); // Ganador del Winner Bracket
        $gf[0]['visitante'] = obtenerGanador($lb['final'][0]); // Ganador del Loser Bracket
    }
    
    // Determinar campeón
    if ($gf[0]['jugado']) {
        $ganador_gf = obtenerGanador($gf[0]);
        
        // Si el ganador es del Winner Bracket, es campeón directamente
        if ($ganador_gf == $gf[0]['local']) {
            $_SESSION['campeon'] = $ganador_gf;
            $_SESSION['sonido_campeon'] = true;
        } 
        // Si el ganador es del Loser Bracket, se necesita True Final
        else if ($ganador_gf == $gf[0]['visitante']) {
            // Configurar True Final
            $tf[0]['local'] = $gf[0]['local']; // Ganador del Winner Bracket
            $tf[0]['visitante'] = $ganador_gf; // Ganador del Loser Bracket
            
            // Si ya se jugó la True Final, determinar campeón
            if ($tf[0]['jugado']) {
                $_SESSION['campeon'] = obtenerGanador($tf[0]);
                $_SESSION['sonido_campeon'] = true;
            }
        }
    }
}

// Reiniciar eliminatorias
if (isset($_POST['reiniciar_eliminatorias'])) {
    unset($_SESSION['eliminatorias']);
    unset($_SESSION['campeon']);
    unset($_SESSION['sonido_campeon']);
    header('Location: eliminatorias.php');
    exit();
}

// Procesar resultados de winner bracket cuartos
if (isset($_POST['guardar_wb_cuartos'])) {
    $partido_index = $_POST['partido_index'];
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        $_SESSION['eliminatorias']['winner_bracket']['cuartos'][$partido_index]['goles_local'] = $goles_local;
        $_SESSION['eliminatorias']['winner_bracket']['cuartos'][$partido_index]['goles_visitante'] = $goles_visitante;
        $_SESSION['eliminatorias']['winner_bracket']['cuartos'][$partido_index]['jugado'] = true;
        $_SESSION['eliminatorias']['winner_bracket']['cuartos'][$partido_index]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['eliminatorias']['winner_bracket']['cuartos'][$partido_index]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['eliminatorias']['winner_bracket']['cuartos'][$partido_index]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['eliminatorias']['winner_bracket']['cuartos'][$partido_index]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        actualizarBracketCompleto();
    }
    
    header('Location: eliminatorias.php');
    exit();
}

// Procesar EDICIÓN de resultados de winner bracket cuartos
if (isset($_POST['editar_wb_cuartos'])) {
    $partido_index = $_POST['partido_index'];
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        $_SESSION['eliminatorias']['winner_bracket']['cuartos'][$partido_index]['goles_local'] = $goles_local;
        $_SESSION['eliminatorias']['winner_bracket']['cuartos'][$partido_index]['goles_visitante'] = $goles_visitante;
        $_SESSION['eliminatorias']['winner_bracket']['cuartos'][$partido_index]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['eliminatorias']['winner_bracket']['cuartos'][$partido_index]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['eliminatorias']['winner_bracket']['cuartos'][$partido_index]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['eliminatorias']['winner_bracket']['cuartos'][$partido_index]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        actualizarBracketCompleto();
    }
    
    header('Location: eliminatorias.php');
    exit();
}

// Procesar resultados de winner bracket semifinales
if (isset($_POST['guardar_wb_semifinales'])) {
    $partido_index = $_POST['partido_index'];
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        $_SESSION['eliminatorias']['winner_bracket']['semifinales'][$partido_index]['goles_local'] = $goles_local;
        $_SESSION['eliminatorias']['winner_bracket']['semifinales'][$partido_index]['goles_visitante'] = $goles_visitante;
        $_SESSION['eliminatorias']['winner_bracket']['semifinales'][$partido_index]['jugado'] = true;
        $_SESSION['eliminatorias']['winner_bracket']['semifinales'][$partido_index]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['eliminatorias']['winner_bracket']['semifinales'][$partido_index]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['eliminatorias']['winner_bracket']['semifinales'][$partido_index]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['eliminatorias']['winner_bracket']['semifinales'][$partido_index]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        actualizarBracketCompleto();
    }
    
    header('Location: eliminatorias.php');
    exit();
}

// Procesar EDICIÓN de resultados de winner bracket semifinales
if (isset($_POST['editar_wb_semifinales'])) {
    $partido_index = $_POST['partido_index'];
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        $_SESSION['eliminatorias']['winner_bracket']['semifinales'][$partido_index]['goles_local'] = $goles_local;
        $_SESSION['eliminatorias']['winner_bracket']['semifinales'][$partido_index]['goles_visitante'] = $goles_visitante;
        $_SESSION['eliminatorias']['winner_bracket']['semifinales'][$partido_index]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['eliminatorias']['winner_bracket']['semifinales'][$partido_index]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['eliminatorias']['winner_bracket']['semifinales'][$partido_index]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['eliminatorias']['winner_bracket']['semifinales'][$partido_index]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        actualizarBracketCompleto();
    }
    
    header('Location: eliminatorias.php');
    exit();
}

// Procesar resultados de winner bracket final
if (isset($_POST['guardar_wb_final'])) {
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        $_SESSION['eliminatorias']['winner_bracket']['final'][0]['goles_local'] = $goles_local;
        $_SESSION['eliminatorias']['winner_bracket']['final'][0]['goles_visitante'] = $goles_visitante;
        $_SESSION['eliminatorias']['winner_bracket']['final'][0]['jugado'] = true;
        $_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        actualizarBracketCompleto();
    }
    
    header('Location: eliminatorias.php');
    exit();
}

// Procesar EDICIÓN de resultados de winner bracket final
if (isset($_POST['editar_wb_final'])) {
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        $_SESSION['eliminatorias']['winner_bracket']['final'][0]['goles_local'] = $goles_local;
        $_SESSION['eliminatorias']['winner_bracket']['final'][0]['goles_visitante'] = $goles_visitante;
        $_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        actualizarBracketCompleto();
    }
    
    header('Location: eliminatorias.php');
    exit();
}

// Procesar resultados de loser bracket ronda 1
if (isset($_POST['guardar_lb_ronda1'])) {
    $partido_index = $_POST['partido_index'];
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        $_SESSION['eliminatorias']['loser_bracket']['ronda1'][$partido_index]['goles_local'] = $goles_local;
        $_SESSION['eliminatorias']['loser_bracket']['ronda1'][$partido_index]['goles_visitante'] = $goles_visitante;
        $_SESSION['eliminatorias']['loser_bracket']['ronda1'][$partido_index]['jugado'] = true;
        $_SESSION['eliminatorias']['loser_bracket']['ronda1'][$partido_index]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['eliminatorias']['loser_bracket']['ronda1'][$partido_index]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['eliminatorias']['loser_bracket']['ronda1'][$partido_index]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['eliminatorias']['loser_bracket']['ronda1'][$partido_index]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        actualizarBracketCompleto();
    }
    
    header('Location: eliminatorias.php');
    exit();
}

// Procesar EDICIÓN de resultados de loser bracket ronda 1
if (isset($_POST['editar_lb_ronda1'])) {
    $partido_index = $_POST['partido_index'];
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        $_SESSION['eliminatorias']['loser_bracket']['ronda1'][$partido_index]['goles_local'] = $goles_local;
        $_SESSION['eliminatorias']['loser_bracket']['ronda1'][$partido_index]['goles_visitante'] = $goles_visitante;
        $_SESSION['eliminatorias']['loser_bracket']['ronda1'][$partido_index]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['eliminatorias']['loser_bracket']['ronda1'][$partido_index]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['eliminatorias']['loser_bracket']['ronda1'][$partido_index]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['eliminatorias']['loser_bracket']['ronda1'][$partido_index]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        actualizarBracketCompleto();
    }
    
    header('Location: eliminatorias.php');
    exit();
}

// Procesar resultados de loser bracket ronda 2
if (isset($_POST['guardar_lb_ronda2'])) {
    $partido_index = $_POST['partido_index'];
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        $_SESSION['eliminatorias']['loser_bracket']['ronda2'][$partido_index]['goles_local'] = $goles_local;
        $_SESSION['eliminatorias']['loser_bracket']['ronda2'][$partido_index]['goles_visitante'] = $goles_visitante;
        $_SESSION['eliminatorias']['loser_bracket']['ronda2'][$partido_index]['jugado'] = true;
        $_SESSION['eliminatorias']['loser_bracket']['ronda2'][$partido_index]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['eliminatorias']['loser_bracket']['ronda2'][$partido_index]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['eliminatorias']['loser_bracket']['ronda2'][$partido_index]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['eliminatorias']['loser_bracket']['ronda2'][$partido_index]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        actualizarBracketCompleto();
    }
    
    header('Location: eliminatorias.php');
    exit();
}

// Procesar EDICIÓN de resultados de loser bracket ronda 2
if (isset($_POST['editar_lb_ronda2'])) {
    $partido_index = $_POST['partido_index'];
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        $_SESSION['eliminatorias']['loser_bracket']['ronda2'][$partido_index]['goles_local'] = $goles_local;
        $_SESSION['eliminatorias']['loser_bracket']['ronda2'][$partido_index]['goles_visitante'] = $goles_visitante;
        $_SESSION['eliminatorias']['loser_bracket']['ronda2'][$partido_index]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['eliminatorias']['loser_bracket']['ronda2'][$partido_index]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['eliminatorias']['loser_bracket']['ronda2'][$partido_index]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['eliminatorias']['loser_bracket']['ronda2'][$partido_index]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        actualizarBracketCompleto();
    }
    
    header('Location: eliminatorias.php');
    exit();
}

// Procesar resultados de loser bracket ronda 3
if (isset($_POST['guardar_lb_ronda3'])) {
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['goles_local'] = $goles_local;
        $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['goles_visitante'] = $goles_visitante;
        $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['jugado'] = true;
        $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        actualizarBracketCompleto();
    }
    
    header('Location: eliminatorias.php');
    exit();
}

// Procesar EDICIÓN de resultados de loser bracket ronda 3
if (isset($_POST['editar_lb_ronda3'])) {
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['goles_local'] = $goles_local;
        $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['goles_visitante'] = $goles_visitante;
        $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        actualizarBracketCompleto();
    }
    
    header('Location: eliminatorias.php');
    exit();
}

// Procesar resultados de loser bracket final
if (isset($_POST['guardar_lb_final'])) {
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        $_SESSION['eliminatorias']['loser_bracket']['final'][0]['goles_local'] = $goles_local;
        $_SESSION['eliminatorias']['loser_bracket']['final'][0]['goles_visitante'] = $goles_visitante;
        $_SESSION['eliminatorias']['loser_bracket']['final'][0]['jugado'] = true;
        $_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        actualizarBracketCompleto();
    }
    
    header('Location: eliminatorias.php');
    exit();
}

// Procesar EDICIÓN de resultados de loser bracket final
if (isset($_POST['editar_lb_final'])) {
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        $_SESSION['eliminatorias']['loser_bracket']['final'][0]['goles_local'] = $goles_local;
        $_SESSION['eliminatorias']['loser_bracket']['final'][0]['goles_visitante'] = $goles_visitante;
        $_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        actualizarBracketCompleto();
    }
    
    header('Location: eliminatorias.php');
    exit();
}

// Procesar resultados de gran final
if (isset($_POST['guardar_gran_final'])) {
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        $_SESSION['eliminatorias']['gran_final'][0]['goles_local'] = $goles_local;
        $_SESSION['eliminatorias']['gran_final'][0]['goles_visitante'] = $goles_visitante;
        $_SESSION['eliminatorias']['gran_final'][0]['jugado'] = true;
        $_SESSION['eliminatorias']['gran_final'][0]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['eliminatorias']['gran_final'][0]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['eliminatorias']['gran_final'][0]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['eliminatorias']['gran_final'][0]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        actualizarBracketCompleto();
    }
    
    header('Location: eliminatorias.php');
    exit();
}

// Procesar EDICIÓN de resultados de gran final
if (isset($_POST['editar_gran_final'])) {
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        $_SESSION['eliminatorias']['gran_final'][0]['goles_local'] = $goles_local;
        $_SESSION['eliminatorias']['gran_final'][0]['goles_visitante'] = $goles_visitante;
        $_SESSION['eliminatorias']['gran_final'][0]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['eliminatorias']['gran_final'][0]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['eliminatorias']['gran_final'][0]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['eliminatorias']['gran_final'][0]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        actualizarBracketCompleto();
    }
    
    header('Location: eliminatorias.php');
    exit();
}

// Procesar resultados de true final
if (isset($_POST['guardar_true_final'])) {
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        $_SESSION['eliminatorias']['true_final'][0]['goles_local'] = $goles_local;
        $_SESSION['eliminatorias']['true_final'][0]['goles_visitante'] = $goles_visitante;
        $_SESSION['eliminatorias']['true_final'][0]['jugado'] = true;
        $_SESSION['eliminatorias']['true_final'][0]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['eliminatorias']['true_final'][0]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['eliminatorias']['true_final'][0]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['eliminatorias']['true_final'][0]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        actualizarBracketCompleto();
    }
    
    header('Location: eliminatorias.php');
    exit();
}

// Procesar EDICIÓN de resultados de true final
if (isset($_POST['editar_true_final'])) {
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        $_SESSION['eliminatorias']['true_final'][0]['goles_local'] = $goles_local;
        $_SESSION['eliminatorias']['true_final'][0]['goles_visitante'] = $goles_visitante;
        $_SESSION['eliminatorias']['true_final'][0]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['eliminatorias']['true_final'][0]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['eliminatorias']['true_final'][0]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['eliminatorias']['true_final'][0]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        actualizarBracketCompleto();
    }
    
    header('Location: eliminatorias.php');
    exit();
}

// Actualizar bracket automáticamente al cargar la página
actualizarBracketCompleto();

// Obtener equipos eliminados
$equipos_eliminados = obtenerEquiposEliminados();

// Array de jugadores con sus fotos
$fotos_jugadores = [
    'Real Madrid' => 'img/equipos/real_madrid.png',
    'Barcelona' => 'img/equipos/barcelona.png',
    'Bayern de Munich' => 'img/equipos/bayern_munich.png',
    'Paris Saint-Germain' => 'img/equipos/psg.png',
    'Liverpool' => 'img/equipos/liverpool.png',
    'Manchester City' => 'img/equipos/manchester_city.png',
    'Arsenal' => 'img/equipos/arsenal.png',
    'Atletico de Madrid' => 'img/equipos/atletico_madrid.png',
    'Chealsea' => 'img/equipos/chelsea.png',
    'Inter de Milán' => 'img/equipos/inter_milan.png',
    'Borussia Dormunt' => 'img/equipos/borussia_dortmund.png',
    'NewCastle' => 'img/equipos/newcastle.png'
];

// Función para obtener la foto del EQUIPO (nueva función)
function obtenerFotoEquipo($nombre_equipo) {
    global $fotos_jugadores;
    return isset($fotos_jugadores[$nombre_equipo]) ? $fotos_jugadores[$nombre_equipo] : "img/equipos/default.png";
}

// Función para obtener el jugador asignado a un equipo
function obtenerJugadorPorEquipo($equipo) {
    if (isset($_SESSION['asignaciones'])) {
        foreach ($_SESSION['asignaciones'] as $asignacion) {
            if ($asignacion['equipo'] === $equipo) {
                return $asignacion['jugador'];
            }
        }
    }
    return "Jugador no encontrado";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminatorias - Torneo FIFA 26</title>
    
    <style>
        /* ===== VARIABLES Y ESTILOS BASE ===== */
        :root {
            --primary-color: #1a1a2e;
            --secondary-color: #16213e;
            --accent-color: #0f3460;
            --highlight-color: #e94560;
            --gold-color: #ffd700;
            --silver-color: #c0c0c0;
            --bronze-color: #cd7f32;
            --text-color: #ffffff;
            --success-color: #4CAF50;
            --danger-color: #f44336;
            --warning-color: #f39c12;
            --border-radius: 10px;
            --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--text-color);
            min-height: 100vh;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1800px;
            margin: 0 auto;
        }

        /* ===== ESTILOS MEJORADOS PARA VIDEOS CIRCULARES ===== */
        .eliminados-section {
            margin: 30px 0;
            padding: 20px;
            background: rgba(231, 76, 60, 0.1);
            border-radius: var(--border-radius);
            border: 1px solid rgba(231, 76, 60, 0.3);
        }

        .eliminados-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }

        .eliminado-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            border-left: 4px solid #e74c3c;
            transition: var(--transition);
            min-height: 180px;
            text-align: center;
        }

        .eliminado-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(231, 76, 60, 0.3);
            background: rgba(255, 255, 255, 0.08);
        }

        .eliminado-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
            width: 100%;
        }

        .eliminado-foto {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e74c3c;
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }

        .eliminado-details {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .eliminado-equipo {
            font-weight: bold;
            color: var(--text-color);
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .eliminado-jugador {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 5px;
        }

        .eliminado-ronda {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
            font-style: italic;
        }

        /* Contenedor circular para el video */
        .video-circular-container {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
            border: 4px solid #e74c3c;
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
            background: #000;
            transition: var(--transition);
        }

        .video-circular-container:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(231, 76, 60, 0.6);
        }

        .video-circular {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        /* Indicador de reproducción */
        .video-indicador {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(231, 76, 60, 0.8);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            opacity: 0;
            transition: var(--transition);
            pointer-events: none;
        }

        .video-circular-container:hover .video-indicador {
            opacity: 1;
        }

        /* Estados del video */
        .video-cargando {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
        }

        /* ===== RESPONSIVE PARA VIDEOS CIRCULARES ===== */
        @media (max-width: 768px) {
            .eliminados-container {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 15px;
            }
            
            .eliminado-card {
                padding: 15px;
                min-height: 160px;
            }

            .video-circular-container {
                width: 100px;
                height: 100px;
            }

            .eliminado-foto {
                width: 70px;
                height: 70px;
            }

            .eliminado-equipo {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 480px) {
            .eliminados-container {
                grid-template-columns: 1fr;
            }
            
            .eliminado-card {
                flex-direction: column;
                text-align: center;
            }

            .video-circular-container {
                width: 90px;
                height: 90px;
            }

            .eliminado-foto {
                width: 60px;
                height: 60px;
            }
        }

        @media (min-width: 1200px) {
            .eliminados-container {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
            
            .video-circular-container {
                width: 140px;
                height: 140px;
            }
        }

        /* ===== ENCABEZADO Y TÍTULOS ===== */
        .header-eliminatorias {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .header-eliminatorias::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--highlight-color), transparent);
        }

        .header-eliminatorias h2 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            background: linear-gradient(to right, var(--text-color), var(--highlight-color));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 0 10px rgba(233, 69, 96, 0.3);
        }

        .header-eliminatorias p {
            font-size: 1.2rem;
            opacity: 0.8;
        }

        /* ===== BRACKET HORIZONTAL COMPLETO ===== */
        .bracket-completo {
            display: block;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 40px;
            overflow-x: auto;
            padding: 20px 0;
        }

        .ronda-completa {
            flex: 1;
            min-width: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .ronda-titulo {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 20px;
            padding: 10px 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--border-radius);
            text-align: center;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .ronda-titulo::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--highlight-color), transparent);
        }

        .winner-bracket .ronda-titulo {
            background: rgba(76, 175, 80, 0.2);
            border-left: 4px solid var(--success-color);
        }

        .loser-bracket .ronda-titulo {
            background: rgba(244, 67, 54, 0.2);
            border-left: 4px solid var(--danger-color);
        }

        .final-bracket .ronda-titulo {
            background: rgba(255, 215, 0, 0.2);
            border-left: 4px solid var(--gold-color);
        }

        .partidos-ronda {
            width: 100%;
        }

        .partido-horizontal {
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            padding: 20px;
            box-shadow: var(--box-shadow);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .partido-horizontal::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, transparent, rgba(255, 255, 255, 0.03), transparent);
            z-index: -1;
        }

        .partido-horizontal:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
        }

        .partido-horizontal.jugado {
            border-left: 4px solid var(--success-color);
        }

        .equipos-partido-horizontal {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .equipo-horizontal {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            transition: var(--transition);
        }

        .equipo-horizontal:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .equipo-ganador {
            background: rgba(76, 175, 80, 0.2);
            border-left: 4px solid var(--success-color);
        }

        .nombre-equipo-horizontal {
            flex: 1;
            font-weight: 500;
        }

        .resultado-horizontal {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin: 10px 0;
        }

        .goles-horizontal {
            font-size: 1.5rem;
            font-weight: bold;
            min-width: 30px;
            text-align: center;
        }

        .separador-horizontal {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .vs-horizontal {
            text-align: center;
            font-weight: bold;
            margin: 10px 0;
            color: var(--highlight-color);
        }

        /* ===== INFORMACIÓN DE TARJETAS ===== */
        .tarjetas-info-horizontal {
            text-align: center;
            font-size: 0.85rem;
            color: var(--danger-color);
            padding: 8px;
            background: rgba(231, 76, 60, 0.1);
            border-radius: 6px;
            margin-top: 5px;
        }

        .amarillas-info-horizontal {
            text-align: center;
            font-size: 0.85rem;
            color: var(--warning-color);
            padding: 8px;
            background: rgba(243, 156, 18, 0.1);
            border-radius: 6px;
            margin-top: 5px;
        }

        /* ===== FORMULARIOS ===== */
        .form-horizontal {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 15px;
        }

        .form-goles-horizontal {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .input-horizontal {
            width: 60px;
            padding: 8px;
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            color: var(--text-color);
            font-size: 1rem;
            transition: var(--transition);
        }

        .input-horizontal:focus {
            outline: none;
            border-color: var(--highlight-color);
            box-shadow: 0 0 5px rgba(233, 69, 96, 0.5);
        }

        /* Formulario de tarjetas */
        .form-tarjetas-horizontal {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .tarjeta-grupo-horizontal {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .tarjeta-grupo-horizontal span {
            font-size: 0.9rem;
            font-weight: bold;
        }

        /* ===== BOTONES ===== */
        .btn-guardar-horizontal, .btn-editar-horizontal, .btn-cancelar-horizontal {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
        }

        .btn-guardar-horizontal {
            background: var(--success-color);
            color: white;
        }

        .btn-guardar-horizontal:hover {
            background: #45a049;
            transform: translateY(-2px);
        }

        .btn-editar-horizontal {
            background: rgba(255, 193, 7, 0.8);
            color: #000;
        }

        .btn-editar-horizontal:hover {
            background: rgba(255, 193, 7, 1);
            transform: translateY(-2px);
        }

        .btn-cancelar-horizontal {
            background: var(--danger-color);
            color: white;
        }

        .btn-cancelar-horizontal:hover {
            background: #d32f2f;
            transform: translateY(-2px);
        }

        /* ===== BOTONES DE ACCIÓN ===== */
        .acciones-eliminatorias {
            text-align: center;
            margin: 30px 0;
        }

        .button {
            display: inline-block;
            padding: 12px 25px;
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-color);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
            margin: 0 10px;
            backdrop-filter: blur(10px);
        }

        .button:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .button-danger {
            background: rgba(244, 67, 54, 0.2);
            border-color: rgba(244, 67, 54, 0.5);
        }

        .button-danger:hover {
            background: rgba(244, 67, 54, 0.3);
        }

        .button-success {
            background: rgba(76, 175, 80, 0.2);
            border-color: rgba(76, 175, 80, 0.5);
        }

        .button-success:hover {
            background: rgba(76, 175, 80, 0.3);
        }

        .navegacion-inferior {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .bracket-completo {
                flex-direction: column;
            }
            
            .ronda-completa {
                margin-bottom: 30px;
            }
        }

        @media (max-width: 768px) {
            .header-eliminatorias h2 {
                font-size: 2rem;
            }
            
            .navegacion-inferior {
                flex-direction: column;
                align-items: center;
            }
            
            .button {
                margin-bottom: 10px;
                width: 100%;
                max-width: 300px;
            }
            
            .form-tarjetas-horizontal {
                flex-direction: column;
                align-items: center;
            }
        }

        /* Información de clasificados */
        .clasificados-info {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .clasificado-grupo {
            flex: 1;
            min-width: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--box-shadow);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
        }

        .clasificado-grupo:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
        }

        .grupo-header {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .grupo-titulo {
            font-size: 1.5rem;
            text-align: center;
        }

        .equipo-clasificado {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin-bottom: 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .equipo-clasificado::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--highlight-color);
            transform: scaleY(0);
            transition: var(--transition);
        }

        .equipo-clasificado:hover::before {
            transform: scaleY(1);
        }

        .equipo-clasificado:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .posicion-equipo {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            margin-right: 15px;
            font-weight: bold;
        }

        .nombre-equipo {
            flex: 1;
            font-weight: 500;
        }

        /* Badges de posición */
        .badge-primero, .badge-segundo, .badge-tercero, .badge-cuarto {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .badge-primero {
            background: linear-gradient(135deg, var(--gold-color), #ffa500);
            color: #000;
        }

        .badge-segundo {
            background: linear-gradient(135deg, var(--silver-color), #a0a0a0);
            color: #000;
        }

        .badge-tercero {
            background: linear-gradient(135deg, var(--bronze-color), #8c5c2c);
            color: #fff;
        }

        .badge-cuarto {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        /* ===== ANUNCIO DE CAMPEÓN MEJORADO ===== */
        .campeon-anuncio {
            background: linear-gradient(135deg, #ffd700, #ffed4e);
            color: #000;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            margin: 20px 0;
            border: 3px solid #ffc107;
            box-shadow: 0 10px 30px rgba(255, 215, 0, 0.4);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
    </style>
    
    <script>
        // Funciones para mostrar/ocultar formularios de edición
        function mostrarFormularioEdicion(tipo, index) {
            const formId = `form-editar-${tipo}-${index}`;
            const form = document.getElementById(formId);
            if (form) {
                form.style.display = 'flex';
            }
        }

        function ocultarFormularioEdicion(tipo, index) {
            const formId = `form-editar-${tipo}-${index}`;
            const form = document.getElementById(formId);
            if (form) {
                form.style.display = 'none';
            }
        }

        // Función para redirigir a ganador.php después de 3 segundos (opcional)
        function redirigirAGanador() {
            setTimeout(function() {
                window.location.href = 'ganador.php';
            }, 3000);
        }

        // Si hay campeón, ofrecer redirección automática pero no forzarla
        <?php if (isset($_SESSION['campeon']) && isset($_SESSION['sonido_campeon'])): ?>
        window.onload = function() {
            // Mostrar opción de redirección automática
            const redirigir = confirm('🎉 ¡Tenemos un campeón! ¿Quieres ir a la página de celebración?');
            if (redirigir) {
                window.location.href = 'ganador.php';
            }
            // Marcar que ya se mostró el sonido para no volver a preguntar
            <?php unset($_SESSION['sonido_campeon']); ?>
        };
        <?php endif; ?>
    </script>
</head>
<body>
    <div class="container">
        <div class="eliminatorias-container">
            <div class="header-eliminatorias">
                <h2>🏆 Fase de Eliminatorias - Doble Eliminación</h2>
                <p>Sistema de doble eliminación para 8 equipos - 15 partidos posibles</p>
            </div>
            
            <!-- Anuncio de Campeón -->
            <?php if (isset($_SESSION['campeon'])): ?>
            <div class="campeon-anuncio">
                <h2 style="font-size: 2.2rem; margin-bottom: 15px;">🎉 ¡TENEMOS CAMPEÓN! 🎉</h2>
                <p style="font-size: 1.4rem; font-weight: bold; margin-bottom: 20px;">
                    <?php echo $_SESSION['campeon']; ?> es el campeón del torneo!
                </p>
                <div style="display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;">
                    <a href="ganador.php" class="button" style="background: #28a745; color: white; padding: 12px 25px; font-size: 1.1rem;">
                        🎊 Ir a Página de Celebración
                    </a>
                    <a href="estadisticas.php" class="button" style="background: #17a2b8; color: white; padding: 12px 25px; font-size: 1.1rem;">
                        📊 Ver Estadísticas Completas
                    </a>
                    
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Sección de Equipos Eliminados - MODIFICADA PARA MOSTRAR FOTO DEL EQUIPO -->
            <?php if (count($equipos_eliminados) > 0): ?>
            <div class="eliminados-section">
                <div class="ronda-titulo" style="background: rgba(231, 76, 60, 0.2); border-left: 4px solid #e74c3c;">
                    🚫 Equipos Eliminados (<?php echo count($equipos_eliminados); ?>)
                </div>
                <div class="eliminados-container">
                    <?php foreach ($equipos_eliminados as $eliminado): ?>
                        <div class="eliminado-card">
                            <div class="eliminado-info">
                                <!-- CAMBIO AQUÍ: usar obtenerFotoEquipo en lugar de obtenerFotoJugador -->
                                <img src="<?php echo obtenerFotoEquipo($eliminado['equipo']); ?>" 
                                     alt="<?php echo $eliminado['equipo']; ?>" 
                                     class="eliminado-foto">
                                <div class="eliminado-details">
                                    <div class="eliminado-equipo"><?php echo $eliminado['equipo']; ?></div>
                                    <div class="eliminado-jugador"><?php echo $eliminado['jugador']; ?></div>
                                    <div class="eliminado-ronda">
                                        Eliminado en: <?php echo ucfirst(str_replace('_', ' ', $eliminado['ronda'])); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="video-circular-container">
                                <video class="video-circular" autoplay loop muted playsinline 
                                       onloadstart="this.style.opacity='1'" 
                                       onwaiting="this.previousElementSibling.style.display='block'" 
                                       oncanplay="this.previousElementSibling.style.display='none'">
                                    <source src="videosF/<?php echo strtolower($eliminado['jugador']); ?>.mp4" type="video/mp4">
                                    Tu navegador no soporta el elemento video.
                                </video>
                                <div class="video-cargando" style="display: none;">Cargando...</div>
                                <div class="video-indicador">▶️</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Información de clasificados -->
            <div class="clasificados-info">
                <div class="clasificado-grupo clasificado-grupo-a">
                    <div class="grupo-header">
                        <h3 class="grupo-titulo">Grupo A - Clasificación</h3>
                    </div>
                    <div class="equipos-clasificados">
                        <?php foreach ($clasificados_a as $index => $equipo): ?>
                            <div class="equipo-clasificado">
                                <div class="posicion-equipo"><?php echo $index + 1; ?></div>
                                <div class="nombre-equipo"><?php echo $equipo; ?></div>
                                <div class="<?php 
                                    echo $index == 0 ? 'badge-primero' : 
                                         ($index == 1 ? 'badge-segundo' : 
                                         ($index == 2 ? 'badge-tercero' : 'badge-cuarto')); 
                                ?>">
                                    <?php echo $index + 1; ?>º
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="clasificado-grupo clasificado-grupo-b">
                    <div class="grupo-header">
                        <h3 class="grupo-titulo">Grupo B - Clasificación</h3>
                    </div>
                    <div class="equipos-clasificados">
                        <?php foreach ($clasificados_b as $index => $equipo): ?>
                            <div class="equipo-clasificado">
                                <div class="posicion-equipo"><?php echo $index + 1; ?></div>
                                <div class="nombre-equipo"><?php echo $equipo; ?></div>
                                <div class="<?php 
                                    echo $index == 0 ? 'badge-primero' : 
                                         ($index == 1 ? 'badge-segundo' : 
                                         ($index == 2 ? 'badge-tercero' : 'badge-cuarto')); 
                                ?>">
                                    <?php echo $index + 1; ?>º
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- BRACKET HORIZONTAL COMPLETO -->
            <div class="bracket-completo">
                <!-- WINNER BRACKET - Cuartos -->
                <div class="ronda-completa winner-bracket">
                    <div class="ronda-titulo">Winner Bracket - Cuartos</div>
                    <div class="partidos-ronda">
                        <?php foreach ($_SESSION['eliminatorias']['winner_bracket']['cuartos'] as $index => $partido): ?>
                            <div class="partido-horizontal <?php echo $partido['jugado'] ? 'jugado' : ''; ?>">
                                <div class="equipos-partido-horizontal">
                                    <div class="equipo-horizontal <?php echo ($partido['jugado'] && $partido['goles_local'] > $partido['goles_visitante']) ? 'equipo-ganador' : ''; ?>">
                                        <div class="nombre-equipo-horizontal"><?php echo $partido['local']; ?></div>
                                    </div>
                                    
                                    <?php if ($partido['jugado']): ?>
                                        <div class="resultado-horizontal">
                                            <span class="goles-horizontal"><?php echo $partido['goles_local']; ?></span>
                                            <span class="separador-horizontal">-</span>
                                            <span class="goles-horizontal"><?php echo $partido['goles_visitante']; ?></span>
                                        </div>
                                        
                                        <div class="equipo-horizontal <?php echo ($partido['jugado'] && $partido['goles_visitante'] > $partido['goles_local']) ? 'equipo-ganador' : ''; ?>">
                                            <div class="nombre-equipo-horizontal"><?php echo $partido['visitante']; ?></div>
                                        </div>
                                        
                                        <!-- Mostrar información de tarjetas -->
                                        <?php if ($partido['tarjetas_rojas_local'] > 0 || $partido['tarjetas_rojas_visitante'] > 0): ?>
                                            <div class="tarjetas-info-horizontal">
                                                🟥 <?php echo $partido['local']; ?>: <?php echo $partido['tarjetas_rojas_local']; ?> | 
                                                <?php echo $partido['visitante']; ?>: <?php echo $partido['tarjetas_rojas_visitante']; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($partido['tarjetas_amarillas_local'] > 0 || $partido['tarjetas_amarillas_visitante'] > 0): ?>
                                            <div class="amarillas-info-horizontal">
                                                🟨 <?php echo $partido['local']; ?>: <?php echo $partido['tarjetas_amarillas_local']; ?> | 
                                                <?php echo $partido['visitante']; ?>: <?php echo $partido['tarjetas_amarillas_visitante']; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- BOTÓN EDITAR RESULTADO -->
                                        <button type="button" class="btn-editar-horizontal" onclick="mostrarFormularioEdicion('wb_cuartos', <?php echo $index; ?>)">
                                            ✏️ Editar Resultado
                                        </button>
                                        
                                        <!-- FORMULARIO DE EDICIÓN (OCULTO INICIALMENTE) -->
                                        <form method="POST" class="form-horizontal" id="form-editar-wb_cuartos-<?php echo $index; ?>" style="display: none;">
                                            <div class="form-goles-horizontal">
                                                <input type="number" name="goles_local" class="input-horizontal" min="0" max="20" 
                                                       value="<?php echo $partido['goles_local']; ?>" required>
                                                <span class="separador-horizontal">-</span>
                                                <input type="number" name="goles_visitante" class="input-horizontal" min="0" max="20" 
                                                       value="<?php echo $partido['goles_visitante']; ?>" required>
                                            </div>
                                            
                                            <div class="form-tarjetas-horizontal">
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $partido['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_local" class="input-horizontal" min="0" max="5" 
                                                           value="<?php echo $partido['tarjetas_rojas_local']; ?>">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $partido['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_visitante" class="input-horizontal" min="0" max="5" 
                                                           value="<?php echo $partido['tarjetas_rojas_visitante']; ?>">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $partido['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_local" class="input-horizontal" min="0" max="10" 
                                                           value="<?php echo $partido['tarjetas_amarillas_local']; ?>">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $partido['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_visitante" class="input-horizontal" min="0" max="10" 
                                                           value="<?php echo $partido['tarjetas_amarillas_visitante']; ?>">
                                                </div>
                                            </div>
                                            
                                            <input type="hidden" name="partido_index" value="<?php echo $index; ?>">
                                            <button type="submit" name="editar_wb_cuartos" class="btn-guardar-horizontal">
                                                ✅ Actualizar Resultado
                                            </button>
                                            <button type="button" class="btn-cancelar-horizontal" onclick="ocultarFormularioEdicion('wb_cuartos', <?php echo $index; ?>)">
                                                ❌ Cancelar
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <div class="vs-horizontal">VS</div>
                                        <div class="equipo-horizontal">
                                            <div class="nombre-equipo-horizontal"><?php echo $partido['visitante']; ?></div>
                                        </div>
                                        
                                        <!-- Formulario para partidos no jugados -->
                                        <form method="POST" class="form-horizontal">
                                            <div class="form-goles-horizontal">
                                                <input type="number" name="goles_local" class="input-horizontal" min="0" max="20" placeholder="0" required>
                                                <span class="separador-horizontal">-</span>
                                                <input type="number" name="goles_visitante" class="input-horizontal" min="0" max="20" placeholder="0" required>
                                            </div>
                                            
                                            <div class="form-tarjetas-horizontal">
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $partido['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_local" class="input-horizontal" min="0" max="5" value="0">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $partido['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_visitante" class="input-horizontal" min="0" max="5" value="0">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $partido['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_local" class="input-horizontal" min="0" max="10" value="0">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $partido['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_visitante" class="input-horizontal" min="0" max="10" value="0">
                                                </div>
                                            </div>
                                            
                                            <input type="hidden" name="partido_index" value="<?php echo $index; ?>">
                                            <button type="submit" name="guardar_wb_cuartos" class="btn-guardar-horizontal">
                                                ✅ Guardar
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- LOSER BRACKET - Ronda 1 -->
                <div class="ronda-completa loser-bracket">
                    <div class="ronda-titulo">Loser Bracket - Ronda 1</div>
                    <div class="partidos-ronda">
                        <?php foreach ($_SESSION['eliminatorias']['loser_bracket']['ronda1'] as $index => $partido): ?>
                            <div class="partido-horizontal <?php echo $partido['jugado'] ? 'jugado' : ''; ?>">
                                <div class="equipos-partido-horizontal">
                                    <div class="equipo-horizontal <?php echo ($partido['jugado'] && $partido['goles_local'] > $partido['goles_visitante']) ? 'equipo-ganador' : ''; ?>">
                                        <div class="nombre-equipo-horizontal"><?php echo $partido['local'] ?? 'Por definir'; ?></div>
                                    </div>
                                    
                                    <?php if ($partido['jugado']): ?>
                                        <div class="resultado-horizontal">
                                            <span class="goles-horizontal"><?php echo $partido['goles_local']; ?></span>
                                            <span class="separador-horizontal">-</span>
                                            <span class="goles-horizontal"><?php echo $partido['goles_visitante']; ?></span>
                                        </div>
                                        
                                        <div class="equipo-horizontal <?php echo ($partido['jugado'] && $partido['goles_visitante'] > $partido['goles_local']) ? 'equipo-ganador' : ''; ?>">
                                            <div class="nombre-equipo-horizontal"><?php echo $partido['visitante']; ?></div>
                                        </div>
                                        
                                        <!-- Mostrar información de tarjetas -->
                                        <?php if ($partido['tarjetas_rojas_local'] > 0 || $partido['tarjetas_rojas_visitante'] > 0): ?>
                                            <div class="tarjetas-info-horizontal">
                                                🟥 <?php echo $partido['local']; ?>: <?php echo $partido['tarjetas_rojas_local']; ?> | 
                                                <?php echo $partido['visitante']; ?>: <?php echo $partido['tarjetas_rojas_visitante']; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($partido['tarjetas_amarillas_local'] > 0 || $partido['tarjetas_amarillas_visitante'] > 0): ?>
                                            <div class="amarillas-info-horizontal">
                                                🟨 <?php echo $partido['local']; ?>: <?php echo $partido['tarjetas_amarillas_local']; ?> | 
                                                <?php echo $partido['visitante']; ?>: <?php echo $partido['tarjetas_amarillas_visitante']; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- BOTÓN EDITAR RESULTADO -->
                                        <button type="button" class="btn-editar-horizontal" onclick="mostrarFormularioEdicion('lb_ronda1', <?php echo $index; ?>)">
                                            ✏️ Editar Resultado
                                        </button>
                                        
                                        <!-- FORMULARIO DE EDICIÓN (OCULTO INICIALMENTE) -->
                                        <form method="POST" class="form-horizontal" id="form-editar-lb_ronda1-<?php echo $index; ?>" style="display: none;">
                                            <div class="form-goles-horizontal">
                                                <input type="number" name="goles_local" class="input-horizontal" min="0" max="20" 
                                                       value="<?php echo $partido['goles_local']; ?>" required>
                                                <span class="separador-horizontal">-</span>
                                                <input type="number" name="goles_visitante" class="input-horizontal" min="0" max="20" 
                                                       value="<?php echo $partido['goles_visitante']; ?>" required>
                                            </div>
                                            
                                            <div class="form-tarjetas-horizontal">
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $partido['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_local" class="input-horizontal" min="0" max="5" 
                                                           value="<?php echo $partido['tarjetas_rojas_local']; ?>">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $partido['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_visitante" class="input-horizontal" min="0" max="5" 
                                                           value="<?php echo $partido['tarjetas_rojas_visitante']; ?>">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $partido['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_local" class="input-horizontal" min="0" max="10" 
                                                           value="<?php echo $partido['tarjetas_amarillas_local']; ?>">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $partido['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_visitante" class="input-horizontal" min="0" max="10" 
                                                           value="<?php echo $partido['tarjetas_amarillas_visitante']; ?>">
                                                </div>
                                            </div>
                                            
                                            <input type="hidden" name="partido_index" value="<?php echo $index; ?>">
                                            <button type="submit" name="editar_lb_ronda1" class="btn-guardar-horizontal">
                                                ✅ Actualizar Resultado
                                            </button>
                                            <button type="button" class="btn-cancelar-horizontal" onclick="ocultarFormularioEdicion('lb_ronda1', <?php echo $index; ?>)">
                                                ❌ Cancelar
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <div class="vs-horizontal">VS</div>
                                        <div class="equipo-horizontal">
                                            <div class="nombre-equipo-horizontal"><?php echo $partido['visitante'] ?? 'Por definir'; ?></div>
                                        </div>
                                        
                                        <?php if ($partido['local'] && $partido['visitante']): ?>
                                            <form method="POST" class="form-horizontal">
                                                <div class="form-goles-horizontal">
                                                    <input type="number" name="goles_local" class="input-horizontal" min="0" max="20" placeholder="0" required>
                                                    <span class="separador-horizontal">-</span>
                                                    <input type="number" name="goles_visitante" class="input-horizontal" min="0" max="20" placeholder="0" required>
                                                </div>
                                                
                                                <div class="form-tarjetas-horizontal">
                                                    <div class="tarjeta-grupo-horizontal">
                                                        <span style="color: #e74c3c;">🟥 <?php echo $partido['local']; ?>:</span>
                                                        <input type="number" name="tarjetas_rojas_local" class="input-horizontal" min="0" max="5" value="0">
                                                    </div>
                                                    <div class="tarjeta-grupo-horizontal">
                                                        <span style="color: #e74c3c;">🟥 <?php echo $partido['visitante']; ?>:</span>
                                                        <input type="number" name="tarjetas_rojas_visitante" class="input-horizontal" min="0" max="5" value="0">
                                                    </div>
                                                    <div class="tarjeta-grupo-horizontal">
                                                        <span style="color: #f39c12;">🟨 <?php echo $partido['local']; ?>:</span>
                                                        <input type="number" name="tarjetas_amarillas_local" class="input-horizontal" min="0" max="10" value="0">
                                                    </div>
                                                    <div class="tarjeta-grupo-horizontal">
                                                        <span style="color: #f39c12;">🟨 <?php echo $partido['visitante']; ?>:</span>
                                                        <input type="number" name="tarjetas_amarillas_visitante" class="input-horizontal" min="0" max="10" value="0">
                                                    </div>
                                                </div>
                                                
                                                <input type="hidden" name="partido_index" value="<?php echo $index; ?>">
                                                <button type="submit" name="guardar_lb_ronda1" class="btn-guardar-horizontal">
                                                    ✅ Guardar
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- WINNER BRACKET - Semifinales -->
                <div class="ronda-completa winner-bracket">
                    <div class="ronda-titulo">Winner Bracket - Semifinales</div>
                    <div class="partidos-ronda">
                        <?php foreach ($_SESSION['eliminatorias']['winner_bracket']['semifinales'] as $index => $partido): ?>
                            <div class="partido-horizontal <?php echo $partido['jugado'] ? 'jugado' : ''; ?>">
                                <div class="equipos-partido-horizontal">
                                    <div class="equipo-horizontal <?php echo ($partido['jugado'] && $partido['goles_local'] > $partido['goles_visitante']) ? 'equipo-ganador' : ''; ?>">
                                        <div class="nombre-equipo-horizontal"><?php echo $partido['local'] ?? 'Por definir'; ?></div>
                                    </div>
                                    
                                    <?php if ($partido['jugado']): ?>
                                        <div class="resultado-horizontal">
                                            <span class="goles-horizontal"><?php echo $partido['goles_local']; ?></span>
                                            <span class="separador-horizontal">-</span>
                                            <span class="goles-horizontal"><?php echo $partido['goles_visitante']; ?></span>
                                        </div>
                                        
                                        <div class="equipo-horizontal <?php echo ($partido['jugado'] && $partido['goles_visitante'] > $partido['goles_local']) ? 'equipo-ganador' : ''; ?>">
                                            <div class="nombre-equipo-horizontal"><?php echo $partido['visitante']; ?></div>
                                        </div>
                                        
                                        <!-- Mostrar información de tarjetas -->
                                        <?php if ($partido['tarjetas_rojas_local'] > 0 || $partido['tarjetas_rojas_visitante'] > 0): ?>
                                            <div class="tarjetas-info-horizontal">
                                                🟥 <?php echo $partido['local']; ?>: <?php echo $partido['tarjetas_rojas_local']; ?> | 
                                                <?php echo $partido['visitante']; ?>: <?php echo $partido['tarjetas_rojas_visitante']; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($partido['tarjetas_amarillas_local'] > 0 || $partido['tarjetas_amarillas_visitante'] > 0): ?>
                                            <div class="amarillas-info-horizontal">
                                                🟨 <?php echo $partido['local']; ?>: <?php echo $partido['tarjetas_amarillas_local']; ?> | 
                                                <?php echo $partido['visitante']; ?>: <?php echo $partido['tarjetas_amarillas_visitante']; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- BOTÓN EDITAR RESULTADO -->
                                        <button type="button" class="btn-editar-horizontal" onclick="mostrarFormularioEdicion('wb_semifinales', <?php echo $index; ?>)">
                                            ✏️ Editar Resultado
                                        </button>
                                        
                                        <!-- FORMULARIO DE EDICIÓN (OCULTO INICIALMENTE) -->
                                        <form method="POST" class="form-horizontal" id="form-editar-wb_semifinales-<?php echo $index; ?>" style="display: none;">
                                            <div class="form-goles-horizontal">
                                                <input type="number" name="goles_local" class="input-horizontal" min="0" max="20" 
                                                       value="<?php echo $partido['goles_local']; ?>" required>
                                                <span class="separador-horizontal">-</span>
                                                <input type="number" name="goles_visitante" class="input-horizontal" min="0" max="20" 
                                                       value="<?php echo $partido['goles_visitante']; ?>" required>
                                            </div>
                                            
                                            <div class="form-tarjetas-horizontal">
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $partido['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_local" class="input-horizontal" min="0" max="5" 
                                                           value="<?php echo $partido['tarjetas_rojas_local']; ?>">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $partido['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_visitante" class="input-horizontal" min="0" max="5" 
                                                           value="<?php echo $partido['tarjetas_rojas_visitante']; ?>">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $partido['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_local" class="input-horizontal" min="0" max="10" 
                                                           value="<?php echo $partido['tarjetas_amarillas_local']; ?>">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $partido['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_visitante" class="input-horizontal" min="0" max="10" 
                                                           value="<?php echo $partido['tarjetas_amarillas_visitante']; ?>">
                                                </div>
                                            </div>
                                            
                                            <input type="hidden" name="partido_index" value="<?php echo $index; ?>">
                                            <button type="submit" name="editar_wb_semifinales" class="btn-guardar-horizontal">
                                                ✅ Actualizar Resultado
                                            </button>
                                            <button type="button" class="btn-cancelar-horizontal" onclick="ocultarFormularioEdicion('wb_semifinales', <?php echo $index; ?>)">
                                                ❌ Cancelar
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <div class="vs-horizontal">VS</div>
                                        <div class="equipo-horizontal">
                                            <div class="nombre-equipo-horizontal"><?php echo $partido['visitante'] ?? 'Por definir'; ?></div>
                                        </div>
                                        
                                        <?php if ($partido['local'] && $partido['visitante']): ?>
                                            <form method="POST" class="form-horizontal">
                                                <div class="form-goles-horizontal">
                                                    <input type="number" name="goles_local" class="input-horizontal" min="0" max="20" placeholder="0" required>
                                                    <span class="separador-horizontal">-</span>
                                                    <input type="number" name="goles_visitante" class="input-horizontal" min="0" max="20" placeholder="0" required>
                                                </div>
                                                
                                                <div class="form-tarjetas-horizontal">
                                                    <div class="tarjeta-grupo-horizontal">
                                                        <span style="color: #e74c3c;">🟥 <?php echo $partido['local']; ?>:</span>
                                                        <input type="number" name="tarjetas_rojas_local" class="input-horizontal" min="0" max="5" value="0">
                                                    </div>
                                                    <div class="tarjeta-grupo-horizontal">
                                                        <span style="color: #e74c3c;">🟥 <?php echo $partido['visitante']; ?>:</span>
                                                        <input type="number" name="tarjetas_rojas_visitante" class="input-horizontal" min="0" max="5" value="0">
                                                    </div>
                                                    <div class="tarjeta-grupo-horizontal">
                                                        <span style="color: #f39c12;">🟨 <?php echo $partido['local']; ?>:</span>
                                                        <input type="number" name="tarjetas_amarillas_local" class="input-horizontal" min="0" max="10" value="0">
                                                    </div>
                                                    <div class="tarjeta-grupo-horizontal">
                                                        <span style="color: #f39c12;">🟨 <?php echo $partido['visitante']; ?>:</span>
                                                        <input type="number" name="tarjetas_amarillas_visitante" class="input-horizontal" min="0" max="10" value="0">
                                                    </div>
                                                </div>
                                                
                                                <input type="hidden" name="partido_index" value="<?php echo $index; ?>">
                                                <button type="submit" name="guardar_wb_semifinales" class="btn-guardar-horizontal">
                                                    ✅ Guardar
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- LOSER BRACKET - Ronda 2 -->
                <div class="ronda-completa loser-bracket">
                    <div class="ronda-titulo">Loser Bracket - Ronda 2</div>
                    <div class="partidos-ronda">
                        <?php foreach ($_SESSION['eliminatorias']['loser_bracket']['ronda2'] as $index => $partido): ?>
                            <div class="partido-horizontal <?php echo $partido['jugado'] ? 'jugado' : ''; ?>">
                                <div class="equipos-partido-horizontal">
                                    <div class="equipo-horizontal <?php echo ($partido['jugado'] && $partido['goles_local'] > $partido['goles_visitante']) ? 'equipo-ganador' : ''; ?>">
                                        <div class="nombre-equipo-horizontal"><?php echo $partido['local'] ?? 'Por definir'; ?></div>
                                    </div>
                                    
                                    <?php if ($partido['jugado']): ?>
                                        <div class="resultado-horizontal">
                                            <span class="goles-horizontal"><?php echo $partido['goles_local']; ?></span>
                                            <span class="separador-horizontal">-</span>
                                            <span class="goles-horizontal"><?php echo $partido['goles_visitante']; ?></span>
                                        </div>
                                        
                                        <div class="equipo-horizontal <?php echo ($partido['jugado'] && $partido['goles_visitante'] > $partido['goles_local']) ? 'equipo-ganador' : ''; ?>">
                                            <div class="nombre-equipo-horizontal"><?php echo $partido['visitante']; ?></div>
                                        </div>
                                        
                                        <!-- Mostrar información de tarjetas -->
                                        <?php if ($partido['tarjetas_rojas_local'] > 0 || $partido['tarjetas_rojas_visitante'] > 0): ?>
                                            <div class="tarjetas-info-horizontal">
                                                🟥 <?php echo $partido['local']; ?>: <?php echo $partido['tarjetas_rojas_local']; ?> | 
                                                <?php echo $partido['visitante']; ?>: <?php echo $partido['tarjetas_rojas_visitante']; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($partido['tarjetas_amarillas_local'] > 0 || $partido['tarjetas_amarillas_visitante'] > 0): ?>
                                            <div class="amarillas-info-horizontal">
                                                🟨 <?php echo $partido['local']; ?>: <?php echo $partido['tarjetas_amarillas_local']; ?> | 
                                                <?php echo $partido['visitante']; ?>: <?php echo $partido['tarjetas_amarillas_visitante']; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- BOTÓN EDITAR RESULTADO -->
                                        <button type="button" class="btn-editar-horizontal" onclick="mostrarFormularioEdicion('lb_ronda2', <?php echo $index; ?>)">
                                            ✏️ Editar Resultado
                                        </button>
                                        
                                        <!-- FORMULARIO DE EDICIÓN (OCULTO INICIALMENTE) -->
                                        <form method="POST" class="form-horizontal" id="form-editar-lb_ronda2-<?php echo $index; ?>" style="display: none;">
                                            <div class="form-goles-horizontal">
                                                <input type="number" name="goles_local" class="input-horizontal" min="0" max="20" 
                                                       value="<?php echo $partido['goles_local']; ?>" required>
                                                <span class="separador-horizontal">-</span>
                                                <input type="number" name="goles_visitante" class="input-horizontal" min="0" max="20" 
                                                       value="<?php echo $partido['goles_visitante']; ?>" required>
                                            </div>
                                            
                                            <div class="form-tarjetas-horizontal">
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $partido['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_local" class="input-horizontal" min="0" max="5" 
                                                           value="<?php echo $partido['tarjetas_rojas_local']; ?>">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $partido['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_visitante" class="input-horizontal" min="0" max="5" 
                                                           value="<?php echo $partido['tarjetas_rojas_visitante']; ?>">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $partido['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_local" class="input-horizontal" min="0" max="10" 
                                                           value="<?php echo $partido['tarjetas_amarillas_local']; ?>">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $partido['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_visitante" class="input-horizontal" min="0" max="10" 
                                                           value="<?php echo $partido['tarjetas_amarillas_visitante']; ?>">
                                                </div>
                                            </div>
                                            
                                            <input type="hidden" name="partido_index" value="<?php echo $index; ?>">
                                            <button type="submit" name="editar_lb_ronda2" class="btn-guardar-horizontal">
                                                ✅ Actualizar Resultado
                                            </button>
                                            <button type="button" class="btn-cancelar-horizontal" onclick="ocultarFormularioEdicion('lb_ronda2', <?php echo $index; ?>)">
                                                ❌ Cancelar
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <div class="vs-horizontal">VS</div>
                                        <div class="equipo-horizontal">
                                            <div class="nombre-equipo-horizontal"><?php echo $partido['visitante'] ?? 'Por definir'; ?></div>
                                        </div>
                                        
                                        <?php if ($partido['local'] && $partido['visitante']): ?>
                                            <form method="POST" class="form-horizontal">
                                                <div class="form-goles-horizontal">
                                                    <input type="number" name="goles_local" class="input-horizontal" min="0" max="20" placeholder="0" required>
                                                    <span class="separador-horizontal">-</span>
                                                    <input type="number" name="goles_visitante" class="input-horizontal" min="0" max="20" placeholder="0" required>
                                                </div>
                                                
                                                <div class="form-tarjetas-horizontal">
                                                    <div class="tarjeta-grupo-horizontal">
                                                        <span style="color: #e74c3c;">🟥 <?php echo $partido['local']; ?>:</span>
                                                        <input type="number" name="tarjetas_rojas_local" class="input-horizontal" min="0" max="5" value="0">
                                                    </div>
                                                    <div class="tarjeta-grupo-horizontal">
                                                        <span style="color: #e74c3c;">🟥 <?php echo $partido['visitante']; ?>:</span>
                                                        <input type="number" name="tarjetas_rojas_visitante" class="input-horizontal" min="0" max="5" value="0">
                                                    </div>
                                                    <div class="tarjeta-grupo-horizontal">
                                                        <span style="color: #f39c12;">🟨 <?php echo $partido['local']; ?>:</span>
                                                        <input type="number" name="tarjetas_amarillas_local" class="input-horizontal" min="0" max="10" value="0">
                                                    </div>
                                                    <div class="tarjeta-grupo-horizontal">
                                                        <span style="color: #f39c12;">🟨 <?php echo $partido['visitante']; ?>:</span>
                                                        <input type="number" name="tarjetas_amarillas_visitante" class="input-horizontal" min="0" max="10" value="0">
                                                    </div>
                                                </div>
                                                
                                                <input type="hidden" name="partido_index" value="<?php echo $index; ?>">
                                                <button type="submit" name="guardar_lb_ronda2" class="btn-guardar-horizontal">
                                                    ✅ Guardar
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- LOSER BRACKET - Ronda 3 -->
                <div class="ronda-completa loser-bracket">
                    <div class="ronda-titulo">Loser Bracket - Ronda 3</div>
                    <div class="partidos-ronda">
                        <div class="partido-horizontal <?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['jugado'] ? 'jugado' : ''; ?>">
                            <div class="equipos-partido-horizontal">
                                <div class="equipo-horizontal <?php echo ($_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['jugado'] && $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['goles_local'] > $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['goles_visitante']) ? 'equipo-ganador' : ''; ?>">
                                    <div class="nombre-equipo-horizontal"><?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['local'] ?? 'Por definir'; ?></div>
                                </div>
                                
                                <?php if ($_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['jugado']): ?>
                                    <div class="resultado-horizontal">
                                        <span class="goles-horizontal"><?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['goles_local']; ?></span>
                                        <span class="separador-horizontal">-</span>
                                        <span class="goles-horizontal"><?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['goles_visitante']; ?></span>
                                    </div>
                                    
                                    <div class="equipo-horizontal <?php echo ($_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['jugado'] && $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['goles_visitante'] > $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['goles_local']) ? 'equipo-ganador' : ''; ?>">
                                        <div class="nombre-equipo-horizontal"><?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['visitante']; ?></div>
                                    </div>
                                    
                                    <!-- Mostrar información de tarjetas -->
                                    <?php if ($_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_rojas_local'] > 0 || $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_rojas_visitante'] > 0): ?>
                                        <div class="tarjetas-info-horizontal">
                                            🟥 <?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['local']; ?>: <?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_rojas_local']; ?> | 
                                            <?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['visitante']; ?>: <?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_rojas_visitante']; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_amarillas_local'] > 0 || $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_amarillas_visitante'] > 0): ?>
                                        <div class="amarillas-info-horizontal">
                                            🟨 <?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['local']; ?>: <?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_amarillas_local']; ?> | 
                                            <?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['visitante']; ?>: <?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_amarillas_visitante']; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- BOTÓN EDITAR RESULTADO -->
                                    <button type="button" class="btn-editar-horizontal" onclick="mostrarFormularioEdicion('lb_ronda3', 0)">
                                        ✏️ Editar Resultado
                                    </button>
                                    
                                    <!-- FORMULARIO DE EDICIÓN (OCULTO INICIALMENTE) -->
                                    <form method="POST" class="form-horizontal" id="form-editar-lb_ronda3-0" style="display: none;">
                                        <div class="form-goles-horizontal">
                                            <input type="number" name="goles_local" class="input-horizontal" min="0" max="20" 
                                                   value="<?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['goles_local']; ?>" required>
                                            <span class="separador-horizontal">-</span>
                                            <input type="number" name="goles_visitante" class="input-horizontal" min="0" max="20" 
                                                   value="<?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['goles_visitante']; ?>" required>
                                        </div>
                                        
                                        <div class="form-tarjetas-horizontal">
                                            <div class="tarjeta-grupo-horizontal">
                                                <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['local']; ?>:</span>
                                                <input type="number" name="tarjetas_rojas_local" class="input-horizontal" min="0" max="5" 
                                                       value="<?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_rojas_local']; ?>">
                                            </div>
                                            <div class="tarjeta-grupo-horizontal">
                                                <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['visitante']; ?>:</span>
                                                <input type="number" name="tarjetas_rojas_visitante" class="input-horizontal" min="0" max="5" 
                                                       value="<?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_rojas_visitante']; ?>">
                                            </div>
                                            <div class="tarjeta-grupo-horizontal">
                                                <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['local']; ?>:</span>
                                                <input type="number" name="tarjetas_amarillas_local" class="input-horizontal" min="0" max="10" 
                                                       value="<?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_amarillas_local']; ?>">
                                            </div>
                                            <div class="tarjeta-grupo-horizontal">
                                                <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['visitante']; ?>:</span>
                                                <input type="number" name="tarjetas_amarillas_visitante" class="input-horizontal" min="0" max="10" 
                                                       value="<?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['tarjetas_amarillas_visitante']; ?>">
                                            </div>
                                        </div>
                                        
                                        <button type="submit" name="editar_lb_ronda3" class="btn-guardar-horizontal">
                                            ✅ Actualizar Resultado
                                        </button>
                                        <button type="button" class="btn-cancelar-horizontal" onclick="ocultarFormularioEdicion('lb_ronda3', 0)">
                                            ❌ Cancelar
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <div class="vs-horizontal">VS</div>
                                    <div class="equipo-horizontal">
                                        <div class="nombre-equipo-horizontal"><?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['visitante'] ?? 'Por definir'; ?></div>
                                    </div>
                                    
                                    <?php if ($_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['local'] && $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['visitante']): ?>
                                        <form method="POST" class="form-horizontal">
                                            <div class="form-goles-horizontal">
                                                <input type="number" name="goles_local" class="input-horizontal" min="0" max="20" placeholder="0" required>
                                                <span class="separador-horizontal">-</span>
                                                <input type="number" name="goles_visitante" class="input-horizontal" min="0" max="20" placeholder="0" required>
                                            </div>
                                            
                                            <div class="form-tarjetas-horizontal">
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_local" class="input-horizontal" min="0" max="5" value="0">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_visitante" class="input-horizontal" min="0" max="5" value="0">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_local" class="input-horizontal" min="0" max="10" value="0">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['loser_bracket']['ronda3'][0]['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_visitante" class="input-horizontal" min="0" max="10" value="0">
                                                </div>
                                            </div>
                                            
                                            <button type="submit" name="guardar_lb_ronda3" class="btn-guardar-horizontal">
                                                ✅ Guardar
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                                                  
                <!-- WINNER BRACKET - Final -->
                <div class="ronda-completa winner-bracket">
                    <div class="ronda-titulo">Winner Bracket - Final</div>
                    <div class="partidos-ronda">
                        <div class="partido-horizontal <?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['jugado'] ? 'jugado' : ''; ?>">
                            <div class="equipos-partido-horizontal">
                                <div class="equipo-horizontal <?php echo ($_SESSION['eliminatorias']['winner_bracket']['final'][0]['jugado'] && $_SESSION['eliminatorias']['winner_bracket']['final'][0]['goles_local'] > $_SESSION['eliminatorias']['winner_bracket']['final'][0]['goles_visitante']) ? 'equipo-ganador' : ''; ?>">
                                    <div class="nombre-equipo-horizontal"><?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['local'] ?? 'Por definir'; ?></div>
                                </div>
                                
                                <?php if ($_SESSION['eliminatorias']['winner_bracket']['final'][0]['jugado']): ?>
                                    <div class="resultado-horizontal">
                                        <span class="goles-horizontal"><?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['goles_local']; ?></span>
                                        <span class="separador-horizontal">-</span>
                                        <span class="goles-horizontal"><?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['goles_visitante']; ?></span>
                                    </div>
                                    
                                    <div class="equipo-horizontal <?php echo ($_SESSION['eliminatorias']['winner_bracket']['final'][0]['jugado'] && $_SESSION['eliminatorias']['winner_bracket']['final'][0]['goles_visitante'] > $_SESSION['eliminatorias']['winner_bracket']['final'][0]['goles_local']) ? 'equipo-ganador' : ''; ?>">
                                        <div class="nombre-equipo-horizontal"><?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['visitante']; ?></div>
                                    </div>
                                    
                                    <!-- Mostrar información de tarjetas -->
                                    <?php if ($_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_rojas_local'] > 0 || $_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_rojas_visitante'] > 0): ?>
                                        <div class="tarjetas-info-horizontal">
                                            🟥 <?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['local']; ?>: <?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_rojas_local']; ?> | 
                                            <?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['visitante']; ?>: <?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_rojas_visitante']; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_amarillas_local'] > 0 || $_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_amarillas_visitante'] > 0): ?>
                                        <div class="amarillas-info-horizontal">
                                            🟨 <?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['local']; ?>: <?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_amarillas_local']; ?> | 
                                            <?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['visitante']; ?>: <?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_amarillas_visitante']; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- BOTÓN EDITAR RESULTADO -->
                                    <button type="button" class="btn-editar-horizontal" onclick="mostrarFormularioEdicion('wb_final', 0)">
                                        ✏️ Editar Resultado
                                    </button>
                                    
                                    <!-- FORMULARIO DE EDICIÓN (OCULTO INICIALMENTE) -->
                                    <form method="POST" class="form-horizontal" id="form-editar-wb_final-0" style="display: none;">
                                        <div class="form-goles-horizontal">
                                            <input type="number" name="goles_local" class="input-horizontal" min="0" max="20" 
                                                   value="<?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['goles_local']; ?>" required>
                                            <span class="separador-horizontal">-</span>
                                            <input type="number" name="goles_visitante" class="input-horizontal" min="0" max="20" 
                                                   value="<?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['goles_visitante']; ?>" required>
                                        </div>
                                        
                                        <div class="form-tarjetas-horizontal">
                                            <div class="tarjeta-grupo-horizontal">
                                                <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['local']; ?>:</span>
                                                <input type="number" name="tarjetas_rojas_local" class="input-horizontal" min="0" max="5" 
                                                       value="<?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_rojas_local']; ?>">
                                            </div>
                                            <div class="tarjeta-grupo-horizontal">
                                                <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['visitante']; ?>:</span>
                                                <input type="number" name="tarjetas_rojas_visitante" class="input-horizontal" min="0" max="5" 
                                                       value="<?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_rojas_visitante']; ?>">
                                            </div>
                                            <div class="tarjeta-grupo-horizontal">
                                                <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['local']; ?>:</span>
                                                <input type="number" name="tarjetas_amarillas_local" class="input-horizontal" min="0" max="10" 
                                                       value="<?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_amarillas_local']; ?>">
                                            </div>
                                            <div class="tarjeta-grupo-horizontal">
                                                <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['visitante']; ?>:</span>
                                                <input type="number" name="tarjetas_amarillas_visitante" class="input-horizontal" min="0" max="10" 
                                                       value="<?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['tarjetas_amarillas_visitante']; ?>">
                                            </div>
                                        </div>
                                        
                                        <button type="submit" name="editar_wb_final" class="btn-guardar-horizontal">
                                            ✅ Actualizar Resultado
                                        </button>
                                        <button type="button" class="btn-cancelar-horizontal" onclick="ocultarFormularioEdicion('wb_final', 0)">
                                            ❌ Cancelar
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <div class="vs-horizontal">VS</div>
                                    <div class="equipo-horizontal">
                                        <div class="nombre-equipo-horizontal"><?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['visitante'] ?? 'Por definir'; ?></div>
                                    </div>
                                    
                                    <?php if ($_SESSION['eliminatorias']['winner_bracket']['final'][0]['local'] && $_SESSION['eliminatorias']['winner_bracket']['final'][0]['visitante']): ?>
                                        <form method="POST" class="form-horizontal">
                                            <div class="form-goles-horizontal">
                                                <input type="number" name="goles_local" class="input-horizontal" min="0" max="20" placeholder="0" required>
                                                <span class="separador-horizontal">-</span>
                                                <input type="number" name="goles_visitante" class="input-horizontal" min="0" max="20" placeholder="0" required>
                                            </div>
                                            
                                            <div class="form-tarjetas-horizontal">
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_local" class="input-horizontal" min="0" max="5" value="0">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_visitante" class="input-horizontal" min="0" max="5" value="0">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_local" class="input-horizontal" min="0" max="10" value="0">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['winner_bracket']['final'][0]['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_visitante" class="input-horizontal" min="0" max="10" value="0">
                                                </div>
                                            </div>
                                            
                                            <button type="submit" name="guardar_wb_final" class="btn-guardar-horizontal">
                                                ✅ Guardar
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- LOSER BRACKET - Final -->
                <div class="ronda-completa loser-bracket">
                    <div class="ronda-titulo">Loser Bracket - Final</div>
                    <div class="partidos-ronda">
                        <div class="partido-horizontal <?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['jugado'] ? 'jugado' : ''; ?>">
                            <div class="equipos-partido-horizontal">
                                <div class="equipo-horizontal <?php echo ($_SESSION['eliminatorias']['loser_bracket']['final'][0]['jugado'] && $_SESSION['eliminatorias']['loser_bracket']['final'][0]['goles_local'] > $_SESSION['eliminatorias']['loser_bracket']['final'][0]['goles_visitante']) ? 'equipo-ganador' : ''; ?>">
                                    <div class="nombre-equipo-horizontal"><?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['local'] ?? 'Por definir'; ?></div>
                                </div>
                                
                                <?php if ($_SESSION['eliminatorias']['loser_bracket']['final'][0]['jugado']): ?>
                                    <div class="resultado-horizontal">
                                        <span class="goles-horizontal"><?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['goles_local']; ?></span>
                                        <span class="separador-horizontal">-</span>
                                        <span class="goles-horizontal"><?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['goles_visitante']; ?></span>
                                    </div>
                                    
                                    <div class="equipo-horizontal <?php echo ($_SESSION['eliminatorias']['loser_bracket']['final'][0]['jugado'] && $_SESSION['eliminatorias']['loser_bracket']['final'][0]['goles_visitante'] > $_SESSION['eliminatorias']['loser_bracket']['final'][0]['goles_local']) ? 'equipo-ganador' : ''; ?>">
                                        <div class="nombre-equipo-horizontal"><?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['visitante']; ?></div>
                                    </div>
                                    
                                    <!-- Mostrar información de tarjetas -->
                                    <?php if ($_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_rojas_local'] > 0 || $_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_rojas_visitante'] > 0): ?>
                                        <div class="tarjetas-info-horizontal">
                                            🟥 <?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['local']; ?>: <?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_rojas_local']; ?> | 
                                            <?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['visitante']; ?>: <?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_rojas_visitante']; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_amarillas_local'] > 0 || $_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_amarillas_visitante'] > 0): ?>
                                        <div class="amarillas-info-horizontal">
                                            🟨 <?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['local']; ?>: <?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_amarillas_local']; ?> | 
                                            <?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['visitante']; ?>: <?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_amarillas_visitante']; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- BOTÓN EDITAR RESULTADO -->
                                    <button type="button" class="btn-editar-horizontal" onclick="mostrarFormularioEdicion('lb_final', 0)">
                                        ✏️ Editar Resultado
                                    </button>
                                    
                                    <!-- FORMULARIO DE EDICIÓN (OCULTO INICIALMENTE) -->
                                    <form method="POST" class="form-horizontal" id="form-editar-lb_final-0" style="display: none;">
                                        <div class="form-goles-horizontal">
                                            <input type="number" name="goles_local" class="input-horizontal" min="0" max="20" 
                                                   value="<?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['goles_local']; ?>" required>
                                            <span class="separador-horizontal">-</span>
                                            <input type="number" name="goles_visitante" class="input-horizontal" min="0" max="20" 
                                                   value="<?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['goles_visitante']; ?>" required>
                                        </div>
                                        
                                        <div class="form-tarjetas-horizontal">
                                            <div class="tarjeta-grupo-horizontal">
                                                <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['local']; ?>:</span>
                                                <input type="number" name="tarjetas_rojas_local" class="input-horizontal" min="0" max="5" 
                                                       value="<?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_rojas_local']; ?>">
                                            </div>
                                            <div class="tarjeta-grupo-horizontal">
                                                <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['visitante']; ?>:</span>
                                                <input type="number" name="tarjetas_rojas_visitante" class="input-horizontal" min="0" max="5" 
                                                       value="<?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_rojas_visitante']; ?>">
                                            </div>
                                            <div class="tarjeta-grupo-horizontal">
                                                <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['local']; ?>:</span>
                                                <input type="number" name="tarjetas_amarillas_local" class="input-horizontal" min="0" max="10" 
                                                       value="<?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_amarillas_local']; ?>">
                                            </div>
                                            <div class="tarjeta-grupo-horizontal">
                                                <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['visitante']; ?>:</span>
                                                <input type="number" name="tarjetas_amarillas_visitante" class="input-horizontal" min="0" max="10" 
                                                       value="<?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['tarjetas_amarillas_visitante']; ?>">
                                            </div>
                                        </div>
                                        
                                        <button type="submit" name="editar_lb_final" class="btn-guardar-horizontal">
                                            ✅ Actualizar Resultado
                                        </button>
                                        <button type="button" class="btn-cancelar-horizontal" onclick="ocultarFormularioEdicion('lb_final', 0)">
                                            ❌ Cancelar
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <div class="vs-horizontal">VS</div>
                                    <div class="equipo-horizontal">
                                        <div class="nombre-equipo-horizontal"><?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['visitante'] ?? 'Por definir'; ?></div>
                                    </div>
                                    
                                    <?php if ($_SESSION['eliminatorias']['loser_bracket']['final'][0]['local'] && $_SESSION['eliminatorias']['loser_bracket']['final'][0]['visitante']): ?>
                                        <form method="POST" class="form-horizontal">
                                            <div class="form-goles-horizontal">
                                                <input type="number" name="goles_local" class="input-horizontal" min="0" max="20" placeholder="0" required>
                                                <span class="separador-horizontal">-</span>
                                                <input type="number" name="goles_visitante" class="input-horizontal" min="0" max="20" placeholder="0" required>
                                            </div>
                                            
                                            <div class="form-tarjetas-horizontal">
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_local" class="input-horizontal" min="0" max="5" value="0">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_visitante" class="input-horizontal" min="0" max="5" value="0">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_local" class="input-horizontal" min="0" max="10" value="0">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['loser_bracket']['final'][0]['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_visitante" class="input-horizontal" min="0" max="10" value="0">
                                                </div>
                                            </div>
                                            
                                            <button type="submit" name="guardar_lb_final" class="btn-guardar-horizontal">
                                                ✅ Guardar
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- GRAN FINAL -->
                <div class="ronda-completa final-bracket">
                    <div class="ronda-titulo">🏆 Gran Final</div>
                    <div class="partidos-ronda">
                        <div class="partido-horizontal <?php echo $_SESSION['eliminatorias']['gran_final'][0]['jugado'] ? 'jugado' : ''; ?>">
                            <div class="equipos-partido-horizontal">
                                <div class="equipo-horizontal <?php echo ($_SESSION['eliminatorias']['gran_final'][0]['jugado'] && $_SESSION['eliminatorias']['gran_final'][0]['goles_local'] > $_SESSION['eliminatorias']['gran_final'][0]['goles_visitante']) ? 'equipo-ganador' : ''; ?>">
                                    <div class="nombre-equipo-horizontal"><?php echo $_SESSION['eliminatorias']['gran_final'][0]['local'] ?? 'Ganador WB'; ?></div>
                                </div>
                                
                                <?php if ($_SESSION['eliminatorias']['gran_final'][0]['jugado']): ?>
                                    <div class="resultado-horizontal">
                                        <span class="goles-horizontal"><?php echo $_SESSION['eliminatorias']['gran_final'][0]['goles_local']; ?></span>
                                        <span class="separador-horizontal">-</span>
                                        <span class="goles-horizontal"><?php echo $_SESSION['eliminatorias']['gran_final'][0]['goles_visitante']; ?></span>
                                    </div>
                                    
                                    <div class="equipo-horizontal <?php echo ($_SESSION['eliminatorias']['gran_final'][0]['jugado'] && $_SESSION['eliminatorias']['gran_final'][0]['goles_visitante'] > $_SESSION['eliminatorias']['gran_final'][0]['goles_local']) ? 'equipo-ganador' : ''; ?>">
                                        <div class="nombre-equipo-horizontal"><?php echo $_SESSION['eliminatorias']['gran_final'][0]['visitante']; ?></div>
                                    </div>
                                    
                                    <!-- Mostrar información de tarjetas -->
                                    <?php if ($_SESSION['eliminatorias']['gran_final'][0]['tarjetas_rojas_local'] > 0 || $_SESSION['eliminatorias']['gran_final'][0]['tarjetas_rojas_visitante'] > 0): ?>
                                        <div class="tarjetas-info-horizontal">
                                            🟥 <?php echo $_SESSION['eliminatorias']['gran_final'][0]['local']; ?>: <?php echo $_SESSION['eliminatorias']['gran_final'][0]['tarjetas_rojas_local']; ?> | 
                                            <?php echo $_SESSION['eliminatorias']['gran_final'][0]['visitante']; ?>: <?php echo $_SESSION['eliminatorias']['gran_final'][0]['tarjetas_rojas_visitante']; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($_SESSION['eliminatorias']['gran_final'][0]['tarjetas_amarillas_local'] > 0 || $_SESSION['eliminatorias']['gran_final'][0]['tarjetas_amarillas_visitante'] > 0): ?>
                                        <div class="amarillas-info-horizontal">
                                            🟨 <?php echo $_SESSION['eliminatorias']['gran_final'][0]['local']; ?>: <?php echo $_SESSION['eliminatorias']['gran_final'][0]['tarjetas_amarillas_local']; ?> | 
                                            <?php echo $_SESSION['eliminatorias']['gran_final'][0]['visitante']; ?>: <?php echo $_SESSION['eliminatorias']['gran_final'][0]['tarjetas_amarillas_visitante']; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($_SESSION['eliminatorias']['gran_final'][0]['visitante'] == obtenerGanador($_SESSION['eliminatorias']['gran_final'][0])): ?>
                                        <div class="amarillas-info-horizontal" style="background: rgba(233, 69, 96, 0.2); color: var(--highlight-color);">
                                            ⚠️ El ganador del Loser Bracket ganó. Se requiere True Final.
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- BOTÓN EDITAR RESULTADO -->
                                    <button type="button" class="btn-editar-horizontal" onclick="mostrarFormularioEdicion('gran_final', 0)">
                                        ✏️ Editar Resultado
                                    </button>
                                    
                                    <!-- FORMULARIO DE EDICIÓN (OCULTO INICIALMENTE) -->
                                    <form method="POST" class="form-horizontal" id="form-editar-gran_final-0" style="display: none;">
                                        <div class="form-goles-horizontal">
                                            <input type="number" name="goles_local" class="input-horizontal" min="0" max="20" 
                                                   value="<?php echo $_SESSION['eliminatorias']['gran_final'][0]['goles_local']; ?>" required>
                                            <span class="separador-horizontal">-</span>
                                            <input type="number" name="goles_visitante" class="input-horizontal" min="0" max="20" 
                                                   value="<?php echo $_SESSION['eliminatorias']['gran_final'][0]['goles_visitante']; ?>" required>
                                        </div>
                                        
                                        <div class="form-tarjetas-horizontal">
                                            <div class="tarjeta-grupo-horizontal">
                                                <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['gran_final'][0]['local']; ?>:</span>
                                                <input type="number" name="tarjetas_rojas_local" class="input-horizontal" min="0" max="5" 
                                                       value="<?php echo $_SESSION['eliminatorias']['gran_final'][0]['tarjetas_rojas_local']; ?>">
                                            </div>
                                            <div class="tarjeta-grupo-horizontal">
                                                <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['gran_final'][0]['visitante']; ?>:</span>
                                                <input type="number" name="tarjetas_rojas_visitante" class="input-horizontal" min="0" max="5" 
                                                       value="<?php echo $_SESSION['eliminatorias']['gran_final'][0]['tarjetas_rojas_visitante']; ?>">
                                            </div>
                                            <div class="tarjeta-grupo-horizontal">
                                                <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['gran_final'][0]['local']; ?>:</span>
                                                <input type="number" name="tarjetas_amarillas_local" class="input-horizontal" min="0" max="10" 
                                                       value="<?php echo $_SESSION['eliminatorias']['gran_final'][0]['tarjetas_amarillas_local']; ?>">
                                            </div>
                                            <div class="tarjeta-grupo-horizontal">
                                                <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['gran_final'][0]['visitante']; ?>:</span>
                                                <input type="number" name="tarjetas_amarillas_visitante" class="input-horizontal" min="0" max="10" 
                                                       value="<?php echo $_SESSION['eliminatorias']['gran_final'][0]['tarjetas_amarillas_visitante']; ?>">
                                            </div>
                                        </div>
                                        
                                        <button type="submit" name="editar_gran_final" class="btn-guardar-horizontal">
                                            ✅ Actualizar Resultado
                                        </button>
                                        <button type="button" class="btn-cancelar-horizontal" onclick="ocultarFormularioEdicion('gran_final', 0)">
                                            ❌ Cancelar
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <div class="vs-horizontal">VS</div>
                                    <div class="equipo-horizontal">
                                        <div class="nombre-equipo-horizontal"><?php echo $_SESSION['eliminatorias']['gran_final'][0]['visitante'] ?? 'Ganador LB'; ?></div>
                                    </div>
                                    
                                    <?php if ($_SESSION['eliminatorias']['gran_final'][0]['local'] && $_SESSION['eliminatorias']['gran_final'][0]['visitante']): ?>
                                        <form method="POST" class="form-horizontal">
                                            <div class="form-goles-horizontal">
                                                <input type="number" name="goles_local" class="input-horizontal" min="0" max="20" placeholder="0" required>
                                                <span class="separador-horizontal">-</span>
                                                <input type="number" name="goles_visitante" class="input-horizontal" min="0" max="20" placeholder="0" required>
                                            </div>
                                            
                                            <div class="form-tarjetas-horizontal">
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['gran_final'][0]['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_local" class="input-horizontal" min="0" max="5" value="0">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['gran_final'][0]['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_visitante" class="input-horizontal" min="0" max="5" value="0">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['gran_final'][0]['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_local" class="input-horizontal" min="0" max="10" value="0">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['gran_final'][0]['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_visitante" class="input-horizontal" min="0" max="10" value="0">
                                                </div>
                                            </div>
                                            
                                            <button type="submit" name="guardar_gran_final" class="btn-guardar-horizontal">
                                                🏆 Jugar Gran Final
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- TRUE FINAL (solo si es necesario) -->
                <?php if ($_SESSION['eliminatorias']['gran_final'][0]['jugado'] && $_SESSION['eliminatorias']['gran_final'][0]['visitante'] == obtenerGanador($_SESSION['eliminatorias']['gran_final'][0])): ?>
                    <div class="ronda-completa final-bracket">
                        <div class="ronda-titulo">⚡ True Final</div>
                        <div class="partidos-ronda">
                            <div class="partido-horizontal <?php echo $_SESSION['eliminatorias']['true_final'][0]['jugado'] ? 'jugado' : ''; ?>">
                                <div class="equipos-partido-horizontal">
                                    <div class="equipo-horizontal <?php echo ($_SESSION['eliminatorias']['true_final'][0]['jugado'] && $_SESSION['eliminatorias']['true_final'][0]['goles_local'] > $_SESSION['eliminatorias']['true_final'][0]['goles_visitante']) ? 'equipo-ganador' : ''; ?>">
                                        <div class="nombre-equipo-horizontal"><?php echo $_SESSION['eliminatorias']['true_final'][0]['local'] ?? 'Ganador WB'; ?></div>
                                    </div>
                                    
                                    <?php if ($_SESSION['eliminatorias']['true_final'][0]['jugado']): ?>
                                        <div class="resultado-horizontal">
                                            <span class="goles-horizontal"><?php echo $_SESSION['eliminatorias']['true_final'][0]['goles_local']; ?></span>
                                            <span class="separador-horizontal">-</span>
                                            <span class="goles-horizontal"><?php echo $_SESSION['eliminatorias']['true_final'][0]['goles_visitante']; ?></span>
                                        </div>
                                        
                                        <div class="equipo-horizontal <?php echo ($_SESSION['eliminatorias']['true_final'][0]['jugado'] && $_SESSION['eliminatorias']['true_final'][0]['goles_visitante'] > $_SESSION['eliminatorias']['true_final'][0]['goles_local']) ? 'equipo-ganador' : ''; ?>">
                                            <div class="nombre-equipo-horizontal"><?php echo $_SESSION['eliminatorias']['true_final'][0]['visitante']; ?></div>
                                        </div>
                                        
                                        <!-- Mostrar información de tarjetas -->
                                        <?php if ($_SESSION['eliminatorias']['true_final'][0]['tarjetas_rojas_local'] > 0 || $_SESSION['eliminatorias']['true_final'][0]['tarjetas_rojas_visitante'] > 0): ?>
                                            <div class="tarjetas-info-horizontal">
                                                🟥 <?php echo $_SESSION['eliminatorias']['true_final'][0]['local']; ?>: <?php echo $_SESSION['eliminatorias']['true_final'][0]['tarjetas_rojas_local']; ?> | 
                                                <?php echo $_SESSION['eliminatorias']['true_final'][0]['visitante']; ?>: <?php echo $_SESSION['eliminatorias']['true_final'][0]['tarjetas_rojas_visitante']; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($_SESSION['eliminatorias']['true_final'][0]['tarjetas_amarillas_local'] > 0 || $_SESSION['eliminatorias']['true_final'][0]['tarjetas_amarillas_visitante'] > 0): ?>
                                            <div class="amarillas-info-horizontal">
                                                🟨 <?php echo $_SESSION['eliminatorias']['true_final'][0]['local']; ?>: <?php echo $_SESSION['eliminatorias']['true_final'][0]['tarjetas_amarillas_local']; ?> | 
                                                <?php echo $_SESSION['eliminatorias']['true_final'][0]['visitante']; ?>: <?php echo $_SESSION['eliminatorias']['true_final'][0]['tarjetas_amarillas_visitante']; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- BOTÓN EDITAR RESULTADO -->
                                        <button type="button" class="btn-editar-horizontal" onclick="mostrarFormularioEdicion('true_final', 0)">
                                            ✏️ Editar Resultado
                                        </button>
                                        
                                        <!-- FORMULARIO DE EDICIÓN (OCULTO INICIALMENTE) -->
                                        <form method="POST" class="form-horizontal" id="form-editar-true_final-0" style="display: none;">
                                            <div class="form-goles-horizontal">
                                                <input type="number" name="goles_local" class="input-horizontal" min="0" max="20" 
                                                       value="<?php echo $_SESSION['eliminatorias']['true_final'][0]['goles_local']; ?>" required>
                                                <span class="separador-horizontal">-</span>
                                                <input type="number" name="goles_visitante" class="input-horizontal" min="0" max="20" 
                                                       value="<?php echo $_SESSION['eliminatorias']['true_final'][0]['goles_visitante']; ?>" required>
                                            </div>
                                            
                                            <div class="form-tarjetas-horizontal">
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['true_final'][0]['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_local" class="input-horizontal" min="0" max="5" 
                                                           value="<?php echo $_SESSION['eliminatorias']['true_final'][0]['tarjetas_rojas_local']; ?>">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['true_final'][0]['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_rojas_visitante" class="input-horizontal" min="0" max="5" 
                                                           value="<?php echo $_SESSION['eliminatorias']['true_final'][0]['tarjetas_rojas_visitante']; ?>">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['true_final'][0]['local']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_local" class="input-horizontal" min="0" max="10" 
                                                           value="<?php echo $_SESSION['eliminatorias']['true_final'][0]['tarjetas_amarillas_local']; ?>">
                                                </div>
                                                <div class="tarjeta-grupo-horizontal">
                                                    <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['true_final'][0]['visitante']; ?>:</span>
                                                    <input type="number" name="tarjetas_amarillas_visitante" class="input-horizontal" min="0" max="10" 
                                                           value="<?php echo $_SESSION['eliminatorias']['true_final'][0]['tarjetas_amarillas_visitante']; ?>">
                                                </div>
                                            </div>
                                            
                                            <button type="submit" name="editar_true_final" class="btn-guardar-horizontal">
                                                ✅ Actualizar Resultado
                                            </button>
                                            <button type="button" class="btn-cancelar-horizontal" onclick="ocultarFormularioEdicion('true_final', 0)">
                                                ❌ Cancelar
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <div class="vs-horizontal">VS</div>
                                        <div class="equipo-horizontal">
                                            <div class="nombre-equipo-horizontal"><?php echo $_SESSION['eliminatorias']['true_final'][0]['visitante'] ?? 'Ganador LB'; ?></div>
                                        </div>
                                        
                                        <?php if ($_SESSION['eliminatorias']['true_final'][0]['local'] && $_SESSION['eliminatorias']['true_final'][0]['visitante']): ?>
                                            <form method="POST" class="form-horizontal">
                                                <div class="form-goles-horizontal">
                                                    <input type="number" name="goles_local" class="input-horizontal" min="0" max="20" placeholder="0" required>
                                                    <span class="separador-horizontal">-</span>
                                                    <input type="number" name="goles_visitante" class="input-horizontal" min="0" max="20" placeholder="0" required>
                                                </div>
                                                
                                                <div class="form-tarjetas-horizontal">
                                                    <div class="tarjeta-grupo-horizontal">
                                                        <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['true_final'][0]['local']; ?>:</span>
                                                        <input type="number" name="tarjetas_rojas_local" class="input-horizontal" min="0" max="5" value="0">
                                                    </div>
                                                    <div class="tarjeta-grupo-horizontal">
                                                        <span style="color: #e74c3c;">🟥 <?php echo $_SESSION['eliminatorias']['true_final'][0]['visitante']; ?>:</span>
                                                        <input type="number" name="tarjetas_rojas_visitante" class="input-horizontal" min="0" max="5" value="0">
                                                    </div>
                                                    <div class="tarjeta-grupo-horizontal">
                                                        <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['true_final'][0]['local']; ?>:</span>
                                                        <input type="number" name="tarjetas_amarillas_local" class="input-horizontal" min="0" max="10" value="0">
                                                    </div>
                                                    <div class="tarjeta-grupo-horizontal">
                                                        <span style="color: #f39c12;">🟨 <?php echo $_SESSION['eliminatorias']['true_final'][0]['visitante']; ?>:</span>
                                                        <input type="number" name="tarjetas_amarillas_visitante" class="input-horizontal" min="0" max="10" value="0">
                                                    </div>
                                                </div>
                                                
                                                <button type="submit" name="guardar_true_final" class="btn-guardar-horizontal">
                                                    ⚡ Jugar True Final
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
        <!-- Botones de acción -->
            <div class="acciones-eliminatorias">
                <form method="POST">
                    <button type="submit" name="reiniciar_eliminatorias" class="button button-danger" 
                            onclick="return confirm('¿Estás seguro de que quieres reiniciar las eliminatorias? Se perderán todos los resultados.')">
                        🔄 Reiniciar Eliminatorias
                    </button>
                </form>
            </div>
            <!-- En la sección de navegación inferior -->

            <div class="navegacion-inferior">
    
    <a href="index.php" class="button">🏠 Volver al Inicio</a>
    <a href="grupos.php" class="button">📊 Volver a Grupos</a>
    
</div>
        </div>
    </div>

    <script>
        // Manejar la reproducción automática de videos circulares
        document.addEventListener('DOMContentLoaded', function() {
            const videos = document.querySelectorAll('.video-circular');
            
            videos.forEach(video => {
                // Intentar reproducir automáticamente
                const playPromise = video.play();
                
                if (playPromise !== undefined) {
                    playPromise.catch(error => {
                        console.log('Reproducción automática falló:', error);
                        // Mostrar mensaje de interacción si es necesario
                        video.parentElement.addEventListener('click', function() {
                            video.play();
                        });
                    });
                }
                
                // Manejar errores de carga
                video.addEventListener('error', function() {
                    console.log('Error cargando video:', video.src);
                    video.style.display = 'none';
                    const errorMsg = document.createElement('div');
                    errorMsg.textContent = '❌ Video no disponible';
                    errorMsg.style.cssText = 'position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); color:white; font-size:0.8rem;';
                    video.parentElement.appendChild(errorMsg);
                });
                
                // Reiniciar video cuando termine (para el loop)
                video.addEventListener('ended', function() {
                    video.currentTime = 0;
                    video.play();
                });
            });
            
            // Efecto hover mejorado para los contenedores de video
            const videoContainers = document.querySelectorAll('.video-circular-container');
            videoContainers.forEach(container => {
                container.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });
                
                container.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>
</html>