<?php
require_once 'includes/config.php';

// AÑADIR ESTO: Copiar el array de plantillas de equipos desde equipos.php
$plantillas_equipos = [
    'Real Madrid' => [
        'Porteros' => ['Thibaut Courtois', 'Andriy Lunin', 'Kepa Arrizabalaga'],
        ],
    'Barcelona' => [
        'Porteros' => ['Marc-André ter Stegen', 'Iñaki Peña'],
        ],
    'Bayern de Munich' => [
        'Porteros' => ['Manuel Neuer', 'Sven Ulreich'],
        ],
    'Paris Saint-Germain' => [
        'Porteros' => ['Gianluigi Donnarumma', 'Keylor Navas'],
        ],
    'Liverpool' => [
        'Porteros' => ['Alisson Becker', 'Caoimhín Kelleher'],
        ],
    'Manchester City' => [
        'Porteros' => ['Ederson', 'Stefan Ortega'],
        ],
    'Arsenal' => [
        'Porteros' => ['David Raya', 'Aaron Ramsdale'],
        ],
    'Atletico de Madrid' => [
        'Porteros' => ['Jan Oblak', 'Ivo Grbić'],
        ],
    'Chealsea' => [
        'Porteros' => ['Robert Sánchez', 'Đorđe Petrović'],
        ],
    'Inter de Milán' => [
        'Porteros' => ['Yann Sommer', 'Emil Audero'],
        ],
    'Borussia Dormunt' => [
        'Porteros' => ['Gregor Kobel', 'Alexander Meyer'],
        ],
    'NewCastle' => [
        'Porteros' => ['Nick Pope', 'Martin Dúbravka'],
        ]
];

// Función para obtener el primer portero de un equipo
function obtenerPorteroPrincipal($equipo) {
    global $plantillas_equipos;
    
    if (isset($plantillas_equipos[$equipo]['Porteros'][0])) {
        return $plantillas_equipos[$equipo]['Porteros'][0];
    }
    
    return "Portero no definido";
}

function obtenerEquipoPorJugador($nombreJugador) {
    if (isset($_SESSION['asignaciones'])) {
        foreach ($_SESSION['asignaciones'] as $asignacion) {
            if ($asignacion['jugador'] === $nombreJugador) {
                return $asignacion['equipo'];
            }
        }
    }
    return null;
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
    return null;
}

function buscarPartidosEnEstructura($estructura) {
    $partidosEncontrados = [];
    
    if (is_array($estructura)) {
        foreach ($estructura as $valor) {
            if (is_array($valor)) {
                // Un partido debe tener local y visitante definidos
                if (isset($valor['local']) && isset($valor['visitante'])) {
                    // Verificamos si realmente se ha jugado (marcado como jugado o tiene goles)
                    $tieneGoles = (isset($valor['goles_local']) && $valor['goles_local'] !== '') || 
                                  (isset($valor['goles_visitante']) && $valor['goles_visitante'] !== '');
                    $jugado = isset($valor['jugado']) && $valor['jugado'];
                    
                    if ($jugado || $tieneGoles) {
                        $partidosEncontrados[] = $valor;
                    }
                } else {
                    // Si no es un partido, seguimos buscando en profundidad
                    $partidosEncontrados = array_merge($partidosEncontrados, buscarPartidosEnEstructura($valor));
                }
            }
        }
    }
    return $partidosEncontrados;
}
// 2. SEGUNDO: Corregimos la función principal para que use la de arriba.
// Función para obtener todos los partidos jugados (CORREGIDA)
function obtenerPartidosJugados() {
    $partidos = [];

    // Partidos de grupos
    if (isset($_SESSION['grupos_sorteados'])) {
        foreach (['grupo_a', 'grupo_b'] as $grupo) {
            if (isset($_SESSION['grupos_sorteados'][$grupo]['calendario'])) {
                foreach ($_SESSION['grupos_sorteados'][$grupo]['calendario'] as $jornada) {
                    foreach ($jornada as $partido) {
                        if (isset($partido['jugado']) && $partido['jugado']) {
                            $partidos[] = $partido;
                        }
                    }
                }
            }
        }
    }

    // Partidos de eliminatorias
    if (isset($_SESSION['eliminatorias'])) {
        $eliminatorias = $_SESSION['eliminatorias'];
        // Ahora simplemente llamamos a la función externa sin redefinirla
        $partidosEliminatorias = buscarPartidosEnEstructura($eliminatorias);
        $partidos = array_merge($partidos, $partidosEliminatorias);
    }

    return $partidos;
}

// Función para calcular estadísticas de jugadores
function calcularEstadisticasJugadores() {
    $partidos = obtenerPartidosJugados();
    $estadisticas = [];

    // Inicializar estadísticas para cada jugador
    if (isset($_SESSION['jugadores'])) {
        foreach ($_SESSION['jugadores'] as $jugador) {
            $estadisticas[$jugador] = [
                'goles_a_favor' => 0,
                'goles_en_contra' => 0,
                'tarjetas_rojas' => 0,
                'tarjetas_amarillas' => 0,
                'puntos_guarro' => 0,
                'partidos_jugados' => 0,
                'partidos_ganados' => 0,
                'partidos_empatados' => 0,
                'partidos_perdidos' => 0,
                'mejor_resultado' => ['goles_favor' => 0, 'goles_contra' => 0, 'diferencia' => -100],
                'peor_resultado' => ['goles_favor' => 0, 'goles_contra' => 0, 'diferencia' => 100]
            ];
        }
    }

    // Procesar partidos
    foreach ($partidos as $partido) {
        $equipo_local = $partido['local'];
        $equipo_visitante = $partido['visitante'];
        $goles_local = $partido['goles_local'];
        $goles_visitante = $partido['goles_visitante'];
        $tarjetas_rojas_local = $partido['tarjetas_rojas_local'] ?? 0;
        $tarjetas_rojas_visitante = $partido['tarjetas_rojas_visitante'] ?? 0;
        $tarjetas_amarillas_local = $partido['tarjetas_amarillas_local'] ?? 0;
        $tarjetas_amarillas_visitante = $partido['tarjetas_amarillas_visitante'] ?? 0;

        // Buscar jugadores dueños de los equipos
        $jugador_local = null;
        $jugador_visitante = null;
        if (isset($_SESSION['asignaciones'])) {
            foreach ($_SESSION['asignaciones'] as $asignacion) {
                if ($asignacion['equipo'] === $equipo_local) {
                    $jugador_local = $asignacion['jugador'];
                }
                if ($asignacion['equipo'] === $equipo_visitante) {
                    $jugador_visitante = $asignacion['jugador'];
                }
            }
        }

        // Actualizar estadísticas del jugador local
        if ($jugador_local && isset($estadisticas[$jugador_local])) {
            $estadisticas[$jugador_local]['goles_a_favor'] += $goles_local;
            $estadisticas[$jugador_local]['goles_en_contra'] += $goles_visitante;
            $estadisticas[$jugador_local]['tarjetas_rojas'] += $tarjetas_rojas_local;
            $estadisticas[$jugador_local]['tarjetas_amarillas'] += $tarjetas_amarillas_local;
            $estadisticas[$jugador_local]['puntos_guarro'] += ($tarjetas_rojas_local * 2) + $tarjetas_amarillas_local;
            $estadisticas[$jugador_local]['partidos_jugados']++;

            $diferencia = $goles_local - $goles_visitante;
            if ($diferencia > $estadisticas[$jugador_local]['mejor_resultado']['diferencia']) {
                $estadisticas[$jugador_local]['mejor_resultado'] = [
                    'goles_favor' => $goles_local,
                    'goles_contra' => $goles_visitante,
                    'diferencia' => $diferencia,
                    'rival' => $equipo_visitante
                ];
            }
            if ($diferencia < $estadisticas[$jugador_local]['peor_resultado']['diferencia']) {
                $estadisticas[$jugador_local]['peor_resultado'] = [
                    'goles_favor' => $goles_local,
                    'goles_contra' => $goles_visitante,
                    'diferencia' => $diferencia,
                    'rival' => $equipo_visitante
                ];
            }

            if ($goles_local > $goles_visitante) {
                $estadisticas[$jugador_local]['partidos_ganados']++;
            } elseif ($goles_local < $goles_visitante) {
                $estadisticas[$jugador_local]['partidos_perdidos']++;
            } else {
                $estadisticas[$jugador_local]['partidos_empatados']++;
            }
        }

        // Actualizar estadísticas del jugador visitante
        if ($jugador_visitante && isset($estadisticas[$jugador_visitante])) {
            $estadisticas[$jugador_visitante]['goles_a_favor'] += $goles_visitante;
            $estadisticas[$jugador_visitante]['goles_en_contra'] += $goles_local;
            $estadisticas[$jugador_visitante]['tarjetas_rojas'] += $tarjetas_rojas_visitante;
            $estadisticas[$jugador_visitante]['tarjetas_amarillas'] += $tarjetas_amarillas_visitante;
            $estadisticas[$jugador_visitante]['puntos_guarro'] += ($tarjetas_rojas_visitante * 2) + $tarjetas_amarillas_visitante;
            $estadisticas[$jugador_visitante]['partidos_jugados']++;

            $diferencia = $goles_visitante - $goles_local;
            if ($diferencia > $estadisticas[$jugador_visitante]['mejor_resultado']['diferencia']) {
                $estadisticas[$jugador_visitante]['mejor_resultado'] = [
                    'goles_favor' => $goles_visitante,
                    'goles_contra' => $goles_local,
                    'diferencia' => $diferencia,
                    'rival' => $equipo_local
                ];
            }
            if ($diferencia < $estadisticas[$jugador_visitante]['peor_resultado']['diferencia']) {
                $estadisticas[$jugador_visitante]['peor_resultado'] = [
                    'goles_favor' => $goles_visitante,
                    'goles_contra' => $goles_local,
                    'diferencia' => $diferencia,
                    'rival' => $equipo_local
                ];
            }

            if ($goles_visitante > $goles_local) {
                $estadisticas[$jugador_visitante]['partidos_ganados']++;
            } elseif ($goles_visitante < $goles_local) {
                $estadisticas[$jugador_visitante]['partidos_perdidos']++;
            } else {
                $estadisticas[$jugador_visitante]['partidos_empatados']++;
            }
        }
    }

    return $estadisticas;
}

// Función para calcular ranking de Bota de Oro
function calcularBotaDeOro() {
    $botaDeOro = [];
    
    if (isset($_SESSION['goles']) && is_array($_SESSION['goles'])) {
        foreach ($_SESSION['goles'] as $equipo => $jugadores) {
            foreach ($jugadores as $jugador => $goles) {
                if ($goles > 0) {
                    $botaDeOro[] = [
                        'jugador' => $jugador,
                        'equipo' => $equipo,
                        'goles' => $goles
                    ];
                }
            }
        }
    }
    
    usort($botaDeOro, function($a, $b) {
        return $b['goles'] - $a['goles'];
    });
    
    return $botaDeOro;
}

// Función para calcular ranking de Mayor Asistente
function calcularMayorAsistente() {
    $mayorAsistente = [];
    
    if (isset($_SESSION['asistencias']) && is_array($_SESSION['asistencias'])) {
        foreach ($_SESSION['asistencias'] as $equipo => $jugadores) {
            foreach ($jugadores as $jugador => $asistencias) {
                if ($asistencias > 0) {
                    $mayorAsistente[] = [
                        'jugador' => $jugador,
                        'equipo' => $equipo,
                        'asistencias' => $asistencias
                    ];
                }
            }
        }
    }
    
    usort($mayorAsistente, function($a, $b) {
        return $b['asistencias'] - $a['asistencias'];
    });
    
    return $mayorAsistente;
}

// Función para calcular records
function calcularRecords($estadisticas) {
    $records = [
        'mayor_goleada' => ['jugador' => null, 'goles_favor' => 0, 'goles_contra' => 0, 'diferencia' => 0],
        'maximo_goleador' => ['jugador' => null, 'goles' => 0],
        'maximo_encajador' => ['jugador' => null, 'goles' => 0],
        'mayor_asistente' => ['jugador' => null, 'asistencias' => 0],
        'mas_guarro' => ['jugador' => null, 'puntos_guarro' => 0, 'tarjetas_rojas' => 0, 'tarjetas_amarillas' => 0],
        'mas_victorias' => ['jugador' => null, 'victorias' => 0],
        'mas_derrotas' => ['jugador' => null, 'derrotas' => 0]
    ];

    foreach ($estadisticas as $jugador => $stats) {
        if ($stats['mejor_resultado']['diferencia'] > $records['mayor_goleada']['diferencia']) {
            $equipoJugador = obtenerEquipoPorJugador($jugador);
            $records['mayor_goleada'] = [
                'jugador' => $jugador,
                'equipo' => $equipoJugador,
                'goles_favor' => $stats['mejor_resultado']['goles_favor'],
                'goles_contra' => $stats['mejor_resultado']['goles_contra'],
                'diferencia' => $stats['mejor_resultado']['diferencia'],
                'rival' => $stats['mejor_resultado']['rival']
            ];
        }

        if ($stats['goles_a_favor'] > $records['maximo_goleador']['goles']) {
            $records['maximo_goleador'] = [
                'jugador' => $jugador,
                'goles' => $stats['goles_a_favor']
            ];
        }

        if ($stats['goles_en_contra'] > $records['maximo_encajador']['goles']) {
            $records['maximo_encajador'] = [
                'jugador' => $jugador,
                'goles' => $stats['goles_en_contra']
            ];
        }

        if ($stats['puntos_guarro'] > $records['mas_guarro']['puntos_guarro']) {
            $records['mas_guarro'] = [
                'jugador' => $jugador,
                'puntos_guarro' => $stats['puntos_guarro'],
                'tarjetas_rojas' => $stats['tarjetas_rojas'],
                'tarjetas_amarillas' => $stats['tarjetas_amarillas']
            ];
        }

        if ($stats['partidos_ganados'] > $records['mas_victorias']['victorias']) {
            $records['mas_victorias'] = [
                'jugador' => $jugador,
                'victorias' => $stats['partidos_ganados']
            ];
        }

        if ($stats['partidos_perdidos'] > $records['mas_derrotas']['derrotas']) {
            $records['mas_derrotas'] = [
                'jugador' => $jugador,
                'derrotas' => $stats['partidos_perdidos']
            ];
        }
    }

    // Calcular Mayor Asistente
    $rankingAsistencias = calcularMayorAsistente();
    if (!empty($rankingAsistencias)) {
        $records['mayor_asistente'] = [
            'jugador' => $rankingAsistencias[0]['jugador'],
            'asistencias' => $rankingAsistencias[0]['asistencias'],
            'equipo' => $rankingAsistencias[0]['equipo']
        ];
    }

    return $records;
}

// Inicializar Gol Puskas
if (!isset($_SESSION['puskas'])) {
    $_SESSION['puskas'] = [
        'jugador' => '',
        'descripcion' => ''
    ];
}

// Inicializar Balón de Oro
if (!isset($_SESSION['balon_oro'])) {
    $_SESSION['balon_oro'] = [
        'votos' => [],
        'ganador' => null
    ];
}

// Inicializar asistencias si no existe
if (!isset($_SESSION['asistencias'])) {
    $_SESSION['asistencias'] = [];
}

// Función para calcular el ganador del Balón de Oro
function calcularGanadorBalonOro() {
    if (empty($_SESSION['balon_oro']['votos'])) {
        $_SESSION['balon_oro']['ganador'] = null;
        return;
    }
    
    $conteo = [];
    foreach ($_SESSION['balon_oro']['votos'] as $voto) {
        $jugador = $voto['jugador'];
        if (!isset($conteo[$jugador])) {
            $conteo[$jugador] = 0;
        }
        $conteo[$jugador]++;
    }
    
    // Ordenar por número de votos (descendente)
    arsort($conteo);
    
    // Verificar si hay empate
    $puntuaciones = array_values($conteo);
    $jugadores = array_keys($conteo);
    
    if (count($conteo) > 1 && $puntuaciones[0] === $puntuaciones[1]) {
        // Hay empate
        $_SESSION['balon_oro']['ganador'] = null;
        $_SESSION['balon_oro']['empate'] = true;
        $_SESSION['balon_oro']['candidatos_empate'] = [];
        
        // Encontrar todos los jugadores con la puntuación máxima
        $max_votos = $puntuaciones[0];
        foreach ($conteo as $jugador => $votos) {
            if ($votos === $max_votos) {
                $_SESSION['balon_oro']['candidatos_empate'][] = $jugador;
            }
        }
    } else {
        // Hay un ganador claro
        $_SESSION['balon_oro']['ganador'] = $jugadores[0];
        $_SESSION['balon_oro']['empate'] = false;
        $_SESSION['balon_oro']['candidatos_empate'] = [];
    }
    
    $_SESSION['balon_oro']['conteo'] = $conteo;
}

// Función para calcular el Guante de Oro MEJORADA con criterios de desempate
function calcularGuanteDeOro($estadisticasJugadores) {
    $porterosStats = [];
    
    if (isset($_SESSION['asignaciones'])) {
        foreach ($_SESSION['asignaciones'] as $asignacion) {
            $equipo = $asignacion['equipo'];
            $jugador = $asignacion['jugador'];
            
            if (isset($estadisticasJugadores[$jugador])) {
                $stats = $estadisticasJugadores[$jugador];
                
                if ($stats['partidos_jugados'] > 0) {
                    $cleanSheets = 0;
                    $partidos = obtenerPartidosJugados();
                    
                    foreach ($partidos as $partido) {
                        if ($partido['local'] === $equipo || $partido['visitante'] === $equipo) {
                            if ($partido['local'] === $equipo) {
                                $golesRecibidos = $partido['goles_visitante'];
                            } else {
                                $golesRecibidos = $partido['goles_local'];
                            }
                            
                            if ($golesRecibidos == 0) {
                                $cleanSheets++;
                            }
                        }
                    }
                    
                    $porterosStats[] = [
                        'equipo' => $equipo,
                        'jugador' => $jugador,
                        'portero_real' => obtenerPorteroPrincipal($equipo),
                        'clean_sheets' => $cleanSheets,
                        'partidos_jugados' => $stats['partidos_jugados'],
                        'goles_recibidos' => $stats['goles_en_contra'],
                        'promedio_goles' => $stats['partidos_jugados'] > 0 ? 
                            number_format($stats['goles_en_contra'] / $stats['partidos_jugados'], 2) : 0,
                        'porcentaje_clean_sheets' => $stats['partidos_jugados'] > 0 ? 
                            number_format(($cleanSheets / $stats['partidos_jugados']) * 100, 1) : 0
                    ];
                }
            }
        }
    }
    
    // ORDENAR POR MÚLTIPLES CRITERIOS (más robusto)
    usort($porterosStats, function($a, $b) {
        // 1. PRIMER CRITERIO: Más Clean Sheets
        if ($b['clean_sheets'] != $a['clean_sheets']) {
            return $b['clean_sheets'] - $a['clean_sheets'];
        }
        
        // 2. SEGUNDO CRITERIO: Menos Goles Recibidos (si empate en clean sheets)
        if ($a['goles_recibidos'] != $b['goles_recibidos']) {
            return $a['goles_recibidos'] - $b['goles_recibidos'];
        }
        
        // 3. TERCER CRITERIO: Mejor Promedio (menos goles por partido)
        if ($a['promedio_goles'] != $b['promedio_goles']) {
            return $a['promedio_goles'] - $b['promedio_goles'];
        }
        
        // 4. CUARTO CRITERIO: Más Partidos Jugados (consistencia)
        return $b['partidos_jugados'] - $a['partidos_jugados'];
    });
    
    return $porterosStats;
}

// Función para obtener todos los partidos jugados (ACTUALIZADA)
// ... (asegúrate de pegar esto sustituyendo solo la función calcularTopValoraciones) ...

function calcularTopValoraciones() {
    $partidos = obtenerPartidosJugados();
    $valoraciones = [];
    
    foreach ($partidos as $partido) {
       $mapeo = [
            ['jugador' => 'local_jugador1', 'valor' => 'local_valoracion1', 'equipo' => 'local'],
            ['jugador' => 'local_jugador2', 'valor' => 'local_valoracion2', 'equipo' => 'local'],
            ['jugador' => 'visitante_jugador1', 'valor' => 'visitante_valoracion1', 'equipo' => 'visitante'],
            ['jugador' => 'visitante_jugador2', 'valor' => 'visitante_valoracion2', 'equipo' => 'visitante']
        ];

        foreach ($mapeo as $m) {
            if (!empty($partido[$m['jugador']]) && isset($partido[$m['valor']]) && $partido[$m['valor']] !== '') {
                $nombreOriginal = trim($partido[$m['jugador']]);
                $nombreKey = mb_strtoupper($nombreOriginal); 
                $valor = floatval($partido[$m['valor']]);

                if (!isset($valoraciones[$nombreKey])) {
                    $valoraciones[$nombreKey] = [
                        'nombre_display' => $nombreOriginal,
                        'total' => 0,
                        'veces' => 0,
                        'equipo' => $partido[$m['equipo']] ?? 'Desconocido'
                    ];
                }
                
                // Sumamos la valoración al total acumulado
                $valoraciones[$nombreKey]['total'] += $valor;
                $valoraciones[$nombreKey]['veces']++;
            }
        }
    }
    
    // Ordenamos por el TOTAL acumulado más alto (de mayor a menor)
    uasort($valoraciones, function($a, $b) {
        if ($a['total'] == $b['total']) {
            // En caso de empate en puntos, el que tenga más partidos jugados va primero
            return $b['veces'] - $a['veces'];
        }
        return ($a['total'] < $b['total']) ? 1 : -1;
    });
    
    return array_slice($valoraciones, 0, 10, true);
}

// Procesar formulario de Balón de Oro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_balon_oro'])) {
    $votante = trim($_POST['votante_balon_oro'] ?? '');
    $jugador_votado = trim($_POST['jugador_balon_oro'] ?? '');
    
    if (!empty($votante) && !empty($jugador_votado)) {
        // Verificar si el votante ya ha votado
        $ya_voto = false;
        foreach ($_SESSION['balon_oro']['votos'] as $voto_existente) {
            if ($voto_existente['votante'] === $votante) {
                $ya_voto = true;
                break;
            }
        }
        
        if (!$ya_voto) {
            $_SESSION['balon_oro']['votos'][] = [
                'votante' => $votante,
                'jugador' => $jugador_votado
            ];
            
            // Recalcular ganador después de cada voto
            calcularGanadorBalonOro();
        }
    }
    
    header('Location: estadisticas.php');
    exit();
}

// Calcular ganadores al cargar la página
calcularGanadorBalonOro();

// Obtener lista de participantes que aún no han votado (Balón de Oro)
$participantes_sin_votar_balon = [];
if (isset($_SESSION['jugadores'])) {
    $votantes_balon = array_column($_SESSION['balon_oro']['votos'], 'votante');
    $participantes_sin_votar_balon = array_diff($_SESSION['jugadores'], $votantes_balon);
}

// Determinar si mostrar formulario Balón de Oro
$todosHanVotadoBalon = (count($participantes_sin_votar_balon) == 0);
$hayEmpateBalon = isset($_SESSION['balon_oro']['empate']) && $_SESSION['balon_oro']['empate'];
$hayGanadorBalon = isset($_SESSION['balon_oro']['ganador']) && $_SESSION['balon_oro']['ganador'] !== null;

// Solo mostrar el ganador si todos han votado y hay un ganador claro
$mostrarGanadorBalonOro = $todosHanVotadoBalon && $hayGanadorBalon && !$hayEmpateBalon;

// Mostrar formulario si:
// - Se solicita edición manualmente
// - No todos han votado
// - Hay empate
// - No hay ganador
$mostrarFormularioBalonOro = isset($_GET['editar_balon_oro']) || 
                            !$todosHanVotadoBalon || 
                            $hayEmpateBalon || 
                            !$hayGanadorBalon;

// Procesar formulario de Gol Puskas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_puskas'])) {
    $_SESSION['puskas'] = [
        'jugador' => $_POST['jugador_puskas'] ?? '',
        'descripcion' => $_POST['descripcion_puskas'] ?? ''
    ];
    
    header('Location: estadisticas.php');
    exit();
}

// Determinar si mostrar formulario Puskas
$mostrarFormularioPuskas = isset($_GET['editar_puskas']) || empty($_SESSION['puskas']['jugador']);

// Calcular estadísticas
$estadisticasJugadores = calcularEstadisticasJugadores();
$records = calcularRecords($estadisticasJugadores);
$botaDeOro = calcularBotaDeOro();
$mayorAsistente = calcularMayorAsistente();
$guanteDeOro = calcularGuanteDeOro($estadisticasJugadores);
$ganadorGuanteOro = !empty($guanteDeOro) ? $guanteDeOro[0] : null;
$topValoraciones = calcularTopValoraciones(); // NUEVO: Calcular top 10 valoraciones

// Si se ha hecho clic en un jugador, mostramos sus detalles
$jugadorSeleccionado = null;
if (isset($_GET['jugador']) && array_key_exists($_GET['jugador'], $estadisticasJugadores)) {
    $jugadorSeleccionado = $_GET['jugador'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas - Torneo FIFA 26</title>
    <style>
        
        /* Todos los estilos CSS permanecen iguales */
        :root {
            --primary-color: #1a1a2e;
            --secondary-color: #16213e;
            --accent-color: #0f3460;
            --highlight-color: #e94560;
            --success-color: #4CAF50;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --gold-color: #ffd700;
            --silver-color: #c0c0c0;
            --bronze-color: #cd7f32;
            --puskas-color: #8B4513;
            --guante-color: #1e90ff;
            --valoracion-color: #FF69B4;
            --text-color: #ffffff;
            --text-secondary: #b0b0b0;
            --border-radius: 12px;
            --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            --transition: all 0.3s ease;
            --gradient-primary: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
            --gradient-accent: linear-gradient(135deg, #e94560, #ff6b6b, #ff8e8e);
            --gradient-gold: linear-gradient(135deg, #ffd700, #ffa500, #ff8c00);
            --gradient-guante: linear-gradient(135deg, #1e90ff, #4169e1, #0000ff);
            --gradient-valoracion: linear-gradient(135deg, #FF69B4, #FF1493, #C71585);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--gradient-primary);
            color: var(--text-color);
            min-height: 100vh;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
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
            backdrop-filter: blur(10px);
            text-align: center;
        }

        .button:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
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

        .estadisticas-container {
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--box-shadow);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header-estadisticas {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .header-estadisticas::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 3px;
            background: var(--gradient-accent);
            border-radius: 3px;
        }

        .header-estadisticas h2 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            background: linear-gradient(to right, var(--text-color), var(--highlight-color));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 0 10px rgba(233, 69, 96, 0.3);
        }

        .header-estadisticas p {
            font-size: 1.2rem;
            color: var(--text-secondary);
        }

        .records-section {
            margin-bottom: 50px;
        }

        .records-section h3 {
            font-size: 1.8rem;
            margin-bottom: 25px;
            text-align: center;
            color: var(--highlight-color);
        }

        .records-grid {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .records-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .records-row.centered {
            grid-template-columns: repeat(2, 1fr);
            max-width: 66.666%;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .records-row {
                grid-template-columns: 1fr;
            }
            
            .records-row.centered {
                grid-template-columns: 1fr;
                max-width: 100%;
            }
        }

        .record-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            padding: 25px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .record-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, transparent, rgba(255, 255, 255, 0.03), transparent);
            z-index: -1;
        }

        .record-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .record-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .record-titulo {
            font-size: 1.1rem;
            color: var(--text-secondary);
            margin-bottom: 10px;
        }

        .record-jugador {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 8px;
            color: var(--text-color);
        }

        .record-dato {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--gold-color);
            margin-bottom: 5px;
        }

        .record-info {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .bota-oro-section {
            margin-bottom: 50px;
        }

        .bota-oro-section h3 {
            font-size: 1.8rem;
            margin-bottom: 25px;
            text-align: center;
            color: var(--gold-color);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .trofeo-bota-oro {
            font-size: 2rem;
            animation: shine 2s infinite;
        }

        @keyframes shine {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); filter: drop-shadow(0 0 10px gold); }
            100% { transform: scale(1); }
        }

        .ranking-bota-oro {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .bota-oro-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .bota-oro-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, transparent, rgba(255, 255, 255, 0.03), transparent);
            z-index: -1;
        }

        .bota-oro-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .posicion-bota {
            font-size: 3rem;
            margin-bottom: 15px;
            text-align: center;
            filter: drop-shadow(0 0 5px rgba(255, 255, 255, 0.3));
        }

        .bota-oro-card:nth-child(1) .posicion-bota {
            animation: bounceBronze 2s infinite;
        }

        .bota-oro-card:nth-child(2) .posicion-bota {
            animation: bounceSilver 2s infinite;
        }

        .bota-oro-card:nth-child(3) .posicion-bota {
            animation: bounceGold 2s infinite;
        }

        @keyframes bounceBronze {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.1); }
        }

        @keyframes bounceSilver {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.1); }
        }

        @keyframes bounceGold {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-15px) scale(1.2); filter: drop-shadow(0 0 10px gold); }
        }

        .jugador-bota-oro {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .nombre-jugador-bota {
            font-size: 1.4rem;
            font-weight: bold;
            color: var(--text-color);
        }

        .equipo-jugador-bota {
            font-size: 0.9rem;
            color: var(--text-secondary);
            background: rgba(255, 255, 255, 0.1);
            padding: 4px 8px;
            border-radius: 12px;
        }

        .goles-bota-oro {
            text-align: center;
        }

        .cantidad-goles {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .label-goles {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .sin-goles {
            text-align: center;
            padding: 40px;
            color: var(--text-secondary);
            font-style: italic;
            grid-column: 1 / -1;
        }

        .puskas-section {
            margin-bottom: 50px;
        }

        .puskas-section h3 {
            font-size: 1.8rem;
            margin-bottom: 25px;
            text-align: center;
            color: var(--puskas-color);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .trofeo-puskas {
            font-size: 2rem;
            animation: glow 2s infinite;
        }

        @keyframes glow {
            0% { transform: scale(1); filter: drop-shadow(0 0 5px var(--puskas-color)); }
            50% { transform: scale(1.1); filter: drop-shadow(0 0 15px var(--puskas-color)); }
            100% { transform: scale(1); filter: drop-shadow(0 0 5px var(--puskas-color)); }
        }

        .puskas-container {
            background: rgba(139, 69, 19, 0.1);
            border-radius: var(--border-radius);
            padding: 30px;
            border: 1px solid rgba(139, 69, 19, 0.3);
            transition: var(--transition);
        }

        .puskas-container:hover {
            border-color: rgba(139, 69, 19, 0.5);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        .form-puskas {
            display: grid;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-weight: bold;
            color: var(--text-color);
        }

        .form-control {
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--border-radius);
            color: var(--text-color);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--puskas-color);
            background: rgba(255, 255, 255, 0.15);
        }

        .form-control::placeholder {
            color: var(--text-secondary);
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .btn-puskas {
            background: rgba(139, 69, 19, 0.3);
            color: white;
            border: 1px solid rgba(139, 69, 19, 0.5);
            padding: 12px 25px;
            border-radius: var(--border-radius);
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1rem;
        }

        .btn-puskas:hover {
            background: rgba(139, 69, 19, 0.5);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .puskas-ganador {
            text-align: center;
            padding: 30px;
        }

        .puskas-jugador {
            font-size: 2rem;
            font-weight: bold;
            color: var(--puskas-color);
            margin-bottom: 15px;
        }

        .puskas-descripcion {
            font-size: 1.2rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 25px;
            font-style: italic;
        }

        .btn-editar-puskas {
            background: rgba(139, 69, 19, 0.2);
            color: white;
            border: 1px solid rgba(139, 69, 19, 0.5);
            padding: 10px 20px;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: bold;
            transition: var(--transition);
            display: inline-block;
        }

        .btn-editar-puskas:hover {
            background: rgba(139, 69, 19, 0.4);
            transform: translateY(-3px);
        }

        .jugadores-section {
            margin-bottom: 40px;
        }

        .jugadores-section h3 {
            font-size: 1.8rem;
            margin-bottom: 25px;
            text-align: center;
            color: var(--highlight-color);
        }

        .grid-jugadores {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
        }

        .jugador-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
            text-decoration: none;
            color: var(--text-color);
            position: relative;
            overflow: hidden;
        }

        .jugador-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, transparent, rgba(255, 255, 255, 0.03), transparent);
            z-index: -1;
        }

        .jugador-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .nombre-jugador {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: var(--text-color);
            text-align: center;
        }

        .estadisticas-jugador {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 15px;
        }

        .estadistica-item {
            text-align: center;
            padding: 12px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            transition: var(--transition);
        }

        .estadistica-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: scale(1.05);
        }

        .estadistica-valor {
            font-size: 1.3rem;
            font-weight: bold;
            color: var(--highlight-color);
        }

        .estadistica-label {
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-top: 5px;
        }

        .click-detalles {
            text-align: center;
            margin-top: 15px;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .detalles-jugador {
            margin-top: 40px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .detalles-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .detalles-header h3 {
            font-size: 1.8rem;
            color: var(--highlight-color);
            margin: 0;
        }

        .btn-cerrar {
            background: rgba(231, 76, 60, 0.3);
            color: white;
            border: 1px solid rgba(231, 76, 60, 0.5);
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .btn-cerrar:hover {
            background: rgba(231, 76, 60, 0.5);
            transform: scale(1.05);
        }

        .mejor-peor-partido {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        .partido-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            padding: 25px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .partido-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, transparent, rgba(255, 255, 255, 0.03), transparent);
            z-index: -1;
        }

        .partido-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .partido-card.mejor {
            border-left: 4px solid var(--success-color);
        }

        .partido-card.peor {
            border-left: 4px solid var(--danger-color);
        }

        .partido-titulo {
            font-size: 1.3rem;
            margin-bottom: 15px;
            color: var(--text-color);
        }

        .partido-resultado {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .partido-card.mejor .partido-resultado {
            color: var(--success-color);
        }

        .partido-card.peor .partido-resultado {
            color: var(--danger-color);
        }

        .partido-rival {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .partido-diferencia {
            font-size: 1.1rem;
            font-weight: bold;
        }

        .partido-card.mejor .partido-diferencia {
            color: var(--success-color);
        }

        .partido-card.peor .partido-diferencia {
            color: var(--danger-color);
        }

        .estadisticas-adicionales {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .estadistica-adicional {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
        }

        .estadistica-adicional:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-5px);
        }

        .estadistica-adicional .valor {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .estadistica-adicional .label {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .balon-oro-section {
            margin-bottom: 50px;
        }

        .balon-oro-section h3 {
            font-size: 1.8rem;
            margin-bottom: 25px;
            text-align: center;
            color: var(--gold-color);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .trofeo-balon-oro {
            font-size: 2rem;
            animation: rotate 3s infinite linear;
        }

        @keyframes rotate {
            0% { transform: rotateY(0deg); }
            100% { transform: rotateY(360deg); }
        }

        .balon-oro-container {
            background: rgba(255, 215, 0, 0.1);
            border-radius: var(--border-radius);
            padding: 30px;
            border: 1px solid rgba(255, 215, 0, 0.3);
            transition: var(--transition);
        }

        .balon-oro-container:hover {
            border-color: rgba(255, 215, 0, 0.5);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        .form-balon-oro {
            display: grid;
            gap: 20px;
        }

        .btn-balon-oro {
            background: rgba(255, 215, 0, 0.3);
            color: white;
            border: 1px solid rgba(255, 215, 0, 0.5);
            padding: 12px 25px;
            border-radius: var(--border-radius);
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1rem;
        }

        .btn-balon-oro:hover {
            background: rgba(255, 215, 0, 0.5);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .balon-oro-ganador {
            text-align: center;
            padding: 30px;
        }

        .balon-oro-jugador {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--gold-color);
            margin-bottom: 20px;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
        }

        .balon-oro-estadisticas {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 25px;
        }

        .estadistica-balon {
            text-align: center;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
        }

        .estadistica-balon .valor {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--gold-color);
        }

        .estadistica-balon .label {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-top: 5px;
        }

        .guante-oro-section {
            margin-bottom: 50px;
        }

        .guante-oro-section h3 {
            font-size: 1.8rem;
            margin-bottom: 25px;
            text-align: center;
            color: var(--guante-color);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .trofeo-guante-oro {
            font-size: 2rem;
            animation: pulse-guante 2s infinite;
        }

        @keyframes pulse-guante {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); filter: drop-shadow(0 0 10px var(--guante-color)); }
            100% { transform: scale(1); }
        }

        .guante-oro-container {
            background: rgba(30, 144, 255, 0.1);
            border-radius: var(--border-radius);
            padding: 30px;
            border: 1px solid rgba(30, 144, 255, 0.3);
            transition: var(--transition);
        }

        .guante-oro-container:hover {
            border-color: rgba(30, 144, 255, 0.5);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        .guante-oro-ganador {
            text-align: center;
            padding: 30px;
        }

        .guante-oro-portero {
            font-size: 2.2rem;
            font-weight: bold;
            color: var(--guante-color);
            margin-bottom: 15px;
            text-shadow: 0 0 10px rgba(30, 144, 255, 0.5);
            background: linear-gradient(135deg, var(--guante-color), #87cefa);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            padding: 10px;
        }

        .guante-oro-estadisticas {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 25px;
        }

        .estadistica-guante {
            text-align: center;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
        }

        .estadistica-guante .valor {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--guante-color);
        }

        .estadistica-guante .label {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-top: 5px;
        }

        .empate-mensaje {
            text-align: center;
            padding: 20px;
            background: rgba(255, 165, 0, 0.1);
            border-radius: var(--border-radius);
            border: 1px solid rgba(255, 165, 0, 0.3);
            margin-bottom: 20px;
        }

        .empate-mensaje h4 {
            color: var(--warning-color);
            margin-bottom: 10px;
        }

        .candidatos-empate {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            margin-top: 15px;
        }

        .candidato-empate {
            background: rgba(255, 165, 0, 0.2);
            padding: 8px 15px;
            border-radius: 20px;
            border: 1px solid rgba(255, 165, 0, 0.4);
        }

        .jugadores-pendientes {
            margin-top: 20px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
        }

        .jugadores-pendientes h4 {
            color: var(--text-secondary);
            margin-bottom: 10px;
            text-align: center;
        }

        .lista-pendientes {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
        }

        .jugador-pendiente {
            background: rgba(255, 255, 255, 0.1);
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.9rem;
        }

        .form-group small {
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin-top: 5px;
            display: block;
        }

        .balon-oro-ganador .balon-oro-jugador {
            font-size: 2.2rem;
            font-weight: bold;
            color: var(--gold-color);
            margin-bottom: 15px;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
            background: linear-gradient(135deg, var(--gold-color), #ffed4e);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            padding: 10px;
        }

        /* ===== SECCIÓN ACTUALIZADA: TOP 10 VALORACIONES (Más grandes y legibles) ===== */
        .top-valoraciones-section {
            margin-bottom: 60px;
        }

        .top-valoraciones-section h3 {
            font-size: 2.2rem; /* Título más grande */
            margin-bottom: 35px;
            text-align: center;
            color: var(--valoracion-color);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .top-valoraciones-container {
            background: rgba(255, 105, 180, 0.1);
            border-radius: var(--border-radius);
            padding: 40px; /* Más padding en el contenedor */
            border: 1px solid rgba(255, 105, 180, 0.3);
        }

        .top-valoraciones-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); /* Cajas más anchas */
            gap: 30px; /* Más espacio entre cajas */
        }

        .top-valoracion-card {
            background: rgba(255, 255, 255, 0.08);
            border-radius: var(--border-radius);
            padding: 35px 25px; /* Cajas mucho más altas y espaciosas */
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 20px;
            min-height: 150px; /* Altura mínima garantizada */
        }

        .posicion-valoracion {
            font-size: 2.8rem; /* Icono de medalla más grande */
            font-weight: bold;
            min-width: 70px;
            text-align: center;
        }

        .jugador-valoracion {
            flex-grow: 1;
            min-width: 0; /* Permite que el nombre use break-word correctamente */
        }

        .nombre-jugador-valoracion {
            font-size: 1.6rem; /* Nombre más grande y visible */
            font-weight: bold;
            margin-bottom: 8px;
            color: var(--text-color);
            line-height: 1.2;
            word-wrap: break-word; /* Ajuste para nombres largos */
            overflow-wrap: break-word;
        }

        .equipo-jugador-valoracion {
            font-size: 1rem;
            color: var(--text-secondary);
            background: rgba(255, 255, 255, 0.1);
            padding: 6px 12px;
            border-radius: 12px;
            display: inline-block;
        }

        .estadisticas-valoracion {
            text-align: right;
            min-width: 100px;
        }

        .valoracion-numero {
            font-size: 2.5rem; /* Puntuación más destacada */
            font-weight: bold;
            color: var(--valoracion-color);
            line-height: 1;
        }

        .valoracion-label {
            font-size: 0.85rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Ajuste responsive para móviles */
        @media (max-width: 768px) {
            .top-valoraciones-grid {
                grid-template-columns: 1fr;
            }
            
            .top-valoracion-card {
                padding: 25px;
                flex-direction: row; /* Mantenemos horizontal si cabe */
                text-align: left;
            }

            .nombre-jugador-valoracion {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 768px) {
            .records-grid {
                grid-template-columns: 1fr;
            }
            
            .ranking-bota-oro {
                grid-template-columns: 1fr;
            }
            
            .grid-jugadores {
                grid-template-columns: 1fr;
            }
            
            .mejor-peor-partido {
                grid-template-columns: 1fr;
            }
            
            .estadisticas-adicionales {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .navegacion-inferior {
                flex-direction: column;
                align-items: center;
            }
            
            .button {
                width: 100%;
                max-width: 300px;
                margin-bottom: 10px;
            }
            
            .detalles-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .header-estadisticas h2 {
                font-size: 2rem;
            }
            
            .estadisticas-jugador {
                grid-template-columns: 1fr;
            }
            
            .estadisticas-adicionales {
                grid-template-columns: 1fr;
            }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .record-card:nth-child(1) .record-icon {
            animation: pulse 2s infinite;
        }

        .jugador-card, .record-card, .partido-card, .bota-oro-card {
            animation: fadeIn 0.6s ease forwards;
        }
        /* Solo añadimos un pequeño estilo adicional para destacar criterios */
        .criterio-info {
            font-size: 0.9rem;
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 15px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="estadisticas-container">
            <div class="header-estadisticas">
                <h2>Estadísticas del Torneo</h2>
                <p>📊 Records y desempeño individual de cada jugador</p>
            </div>

            <!-- Sección de Bota de Oro - ORDEN 3º, 2º, 1º -->
            <div class="bota-oro-section">
                <h3>
                    <span class="trofeo-bota-oro">👞</span>
                    Bota de Oro - Máximos Goleadores
                </h3>
                
                <?php if (!empty($botaDeOro)): ?>
                    <div class="ranking-bota-oro">
                        <?php 
                        $topTres = array_slice($botaDeOro, 0, 3);
                        
                        if (count($topTres) >= 3): ?>
                         <!-- Primer lugar -->
                            <div class="bota-oro-card">
                                <div class="posicion-bota">🥇</div>
                                <div class="jugador-bota-oro">
                                    <div class="nombre-jugador-bota"><?php echo htmlspecialchars($topTres[0]['jugador']); ?></div>
                                    <div class="equipo-jugador-bota"><?php echo htmlspecialchars($topTres[0]['equipo']); ?></div>
                                </div>
                                <div class="goles-bota-oro">
                                    <div class="cantidad-goles" style="color: var(--gold-color);"><?php echo $topTres[0]['goles']; ?> goles</div>
                                    <div class="label-goles">1º Puesto - Bota de Oro</div>
                                </div>
                            </div>
                           

                            <!-- Segundo lugar -->
                            <div class="bota-oro-card">
                                <div class="posicion-bota">🥈</div>
                                <div class="jugador-bota-oro">
                                    <div class="nombre-jugador-bota"><?php echo htmlspecialchars($topTres[1]['jugador']); ?></div>
                                    <div class="equipo-jugador-bota"><?php echo htmlspecialchars($topTres[1]['equipo']); ?></div>
                                </div>
                                <div class="goles-bota-oro">
                                    <div class="cantidad-goles" style="color: var(--silver-color);"><?php echo $topTres[1]['goles']; ?> goles</div>
                                    <div class="label-goles">2º Puesto</div>
                                </div>
                            </div>

                            <!-- Tercer lugar -->
                            <div class="bota-oro-card">
                                <div class="posicion-bota">🥉</div>
                                <div class="jugador-bota-oro">
                                    <div class="nombre-jugador-bota"><?php echo htmlspecialchars($topTres[2]['jugador']); ?></div>
                                    <div class="equipo-jugador-bota"><?php echo htmlspecialchars($topTres[2]['equipo']); ?></div>
                                </div>
                                <div class="goles-bota-oro">
                                    <div class="cantidad-goles" style="color: var(--bronze-color);"><?php echo $topTres[2]['goles']; ?> goles</div>
                                    <div class="label-goles">3º Puesto</div>
                                </div>
                            </div>

                        <?php elseif (count($topTres) == 2): ?>
                            <!-- Solo hay 2 jugadores -->
                            <div class="bota-oro-card">
                                <div class="posicion-bota">🥈</div>
                                <div class="jugador-bota-oro">
                                    <div class="nombre-jugador-bota"><?php echo htmlspecialchars($topTres[1]['jugador']); ?></div>
                                    <div class="equipo-jugador-bota"><?php echo htmlspecialchars($topTres[1]['equipo']); ?></div>
                                </div>
                                <div class="goles-bota-oro">
                                    <div class="cantidad-goles" style="color: var(--silver-color);"><?php echo $topTres[1]['goles']; ?> goles</div>
                                    <div class="label-goles">2º Puesto</div>
                                </div>
                            </div>

                            <div class="bota-oro-card">
                                <div class="posicion-bota">🥇</div>
                                <div class="jugador-bota-oro">
                                    <div class="nombre-jugador-bota"><?php echo htmlspecialchars($topTres[0]['jugador']); ?></div>
                                    <div class="equipo-jugador-bota"><?php echo htmlspecialchars($topTres[0]['equipo']); ?></div>
                                </div>
                                <div class="goles-bota-oro">
                                    <div class="cantidad-goles" style="color: var(--gold-color);"><?php echo $topTres[0]['goles']; ?> goles</div>
                                    <div class="label-goles">1º Puesto - Bota de Oro</div>
                                </div>
                            </div>

                        <?php elseif (count($topTres) == 1): ?>
                            <!-- Solo hay 1 jugador -->
                            <div class="bota-oro-card" style="grid-column: 1 / -1; max-width: 400px; margin: 0 auto;">
                                <div class="posicion-bota">🥇</div>
                                <div class="jugador-bota-oro">
                                    <div class="nombre-jugador-bota"><?php echo htmlspecialchars($topTres[0]['jugador']); ?></div>
                                    <div class="equipo-jugador-bota"><?php echo htmlspecialchars($topTres[0]['equipo']); ?></div>
                                </div>
                                <div class="goles-bota-oro">
                                    <div class="cantidad-goles" style="color: var(--gold-color);"><?php echo $topTres[0]['goles']; ?> goles</div>
                                    <div class="label-goles">1º Puesto - Bota de Oro</div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="sin-goles">
                        No hay goles individuales registrados todavía.
                    </div>
                <?php endif; ?>
            </div>

            <!-- Sección Gol Puskas -->
            <div class="puskas-section">
                <h3>
                    <span class="trofeo-puskas">⚽</span>
                    Gol Puskas - Mejor Gol del Torneo
                </h3>
                
                <div class="puskas-container">
                    <?php if ($mostrarFormularioPuskas): ?>
                        <form method="POST" class="form-puskas">
                            <div class="form-group">
                                <label for="jugador_puskas">Jugador del Gol Puskas</label>
                                <input type="text" id="jugador_puskas" name="jugador_puskas" class="form-control" 
                                       value="<?php echo htmlspecialchars($_SESSION['puskas']['jugador'] ?? ''); ?>" 
                                       placeholder="Nombre del jugador..." required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion_puskas">Descripción del Gol</label>
                                <textarea id="descripcion_puskas" name="descripcion_puskas" class="form-control" 
                                          placeholder="Describe el gol más bonito del torneo..."><?php echo htmlspecialchars($_SESSION['puskas']['descripcion'] ?? ''); ?></textarea>
                            </div>
                            <button type="submit" name="guardar_puskas" class="btn-puskas">
                                🏆 Guardar Gol Puskas
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="puskas-ganador">
                            <div class="puskas-jugador">
                                <?php echo htmlspecialchars($_SESSION['puskas']['jugador']); ?>
                            </div>
                            <?php if (!empty($_SESSION['puskas']['descripcion'])): ?>
                                <div class="puskas-descripcion">
                                    "<?php echo htmlspecialchars($_SESSION['puskas']['descripcion']); ?>"
                                </div>
                            <?php endif; ?>
                            <a href="estadisticas.php?editar_puskas=1" class="btn-editar-puskas">
                                ✏️ Editar Gol Puskas
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sección Guante de Oro MEJORADA -->
            <div class="guante-oro-section">
                <h3>
                    <span class="trofeo-guante-oro">🧤</span>
                    Guante de Oro - Mejor Portero
                </h3>
                
                <div class="criterio-info">
                    🏆 Criterios de evaluación: 1. Clean Sheets → 2. Menos Goles → 3. Mejor Promedio
                </div>
                
                <div class="guante-oro-container">
                    <?php 
                    $guanteDeOro = calcularGuanteDeOro($estadisticasJugadores);
                    $ganadorGuanteOro = !empty($guanteDeOro) ? $guanteDeOro[0] : null;
                    ?>
                    
                    <?php if ($ganadorGuanteOro): ?>
                        <div class="guante-oro-ganador">
                            <div class="guante-oro-portero">
                                <?php echo htmlspecialchars($ganadorGuanteOro['portero_real']); ?>
                            </div>
                            <div style="color: var(--text-secondary); margin-bottom: 15px;">
                                Portero del <?php echo htmlspecialchars($ganadorGuanteOro['equipo']); ?>
                            </div>
                            <div style="color: var(--text-secondary); margin-bottom: 25px;">
                                Equipo de <?php echo htmlspecialchars($ganadorGuanteOro['jugador']); ?>
                            </div>
                            
                            <div class="guante-oro-estadisticas">
                                <div class="estadistica-guante">
                                    <div class="valor"><?php echo $ganadorGuanteOro['clean_sheets']; ?></div>
                                    <div class="label">Clean Sheets</div>
                                </div>
                                <div class="estadistica-guante">
                                    <div class="valor"><?php echo $ganadorGuanteOro['goles_recibidos']; ?></div>
                                    <div class="label">Goles Recibidos</div>
                                </div>
                                <div class="estadistica-guante">
                                    <div class="valor"><?php echo $ganadorGuanteOro['promedio_goles']; ?></div>
                                    <div class="label">Promedio por Partido</div>
                                </div>
                            </div>
                            
                            <!-- Mostrar criterio de desempate si es necesario -->
                            <?php if ($ganadorGuanteOro['clean_sheets'] == 0 && count($guanteDeOro) > 1): ?>
                                <div style="margin-top: 15px; padding: 10px; background: rgba(30, 144, 255, 0.1); border-radius: 8px; text-align: center;">
                                    <small style="color: var(--text-secondary);">
                                        ⚖️ Desempate por menos goles recibidos
                                    </small>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Ranking completo de porteros MEJORADO -->
                        <div style="margin-top: 30px; padding: 20px; background: rgba(255,255,255,0.05); border-radius: 8px;">
                            <h4 style="color: var(--text-secondary); margin-bottom: 15px; text-align: center;">
                                Ranking de Porteros
                                <div style="font-size: 0.8rem; margin-top: 5px; color: var(--text-secondary);">
                                    Orden: Clean Sheets → Goles Recibidos → Promedio
                                </div>
                            </h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px;">
                                <?php foreach ($guanteDeOro as $index => $portero): ?>
                                    <div style="text-align: center; padding: 15px; background: rgba(30, 144, 255, 0.1); border-radius: 8px; border: 1px solid rgba(30, 144, 255, 0.3);">
                                        <div style="font-size: 1.5rem; margin-bottom: 10px;">
                                            <?php 
                                            if ($index === 0) echo '🥇';
                                            elseif ($index === 1) echo '🥈';
                                            elseif ($index === 2) echo '🥉';
                                            else echo ($index + 1) . 'º';
                                            ?>
                                        </div>
                                        <div style="font-weight: bold; color: var(--guante-color); margin-bottom: 5px;">
                                            <?php echo htmlspecialchars($portero['portero_real']); ?>
                                        </div>
                                        <div style="font-size: 0.9rem; color: var(--text-secondary); margin-bottom: 5px;">
                                            <?php echo htmlspecialchars($portero['equipo']); ?>
                                        </div>
                                        
                                        <!-- Estadísticas principales -->
                                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; margin: 10px 0;">
                                            <div>
                                                <div style="font-size: 1.2rem; font-weight: bold; color: white;">
                                                    <?php echo $portero['clean_sheets']; ?>
                                                </div>
                                                <div style="font-size: 0.7rem; color: var(--text-secondary);">Clean</div>
                                            </div>
                                            <div>
                                                <div style="font-size: 1.2rem; font-weight: bold; color: white;">
                                                    <?php echo $portero['goles_recibidos']; ?>
                                                </div>
                                                <div style="font-size: 0.7rem; color: var(--text-secondary);">Goles</div>
                                            </div>
                                            <div>
                                                <div style="font-size: 1.2rem; font-weight: bold; color: white;">
                                                    <?php echo $portero['promedio_goles']; ?>
                                                </div>
                                                <div style="font-size: 0.7rem; color: var(--text-secondary);">Prom.</div>
                                            </div>
                                        </div>
                                        
                                        <!-- Información adicional -->
                                        <div style="font-size: 0.8rem; color: var(--text-secondary);">
                                            <?php echo $portero['partidos_jugados']; ?> partidos
                                            <?php if ($portero['porcentaje_clean_sheets'] > 0): ?>
                                                • <?php echo $portero['porcentaje_clean_sheets']; ?>% efectividad
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div style="text-align: center; padding: 40px; color: var(--text-secondary);">
                            No hay suficientes datos para determinar el Guante de Oro.
                            <div style="margin-top: 15px; font-size: 0.9rem;">
                                Se necesitan partidos jugados para calcular esta estadística.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- NUEVA SECCIÓN: Top 10 Valoraciones -->
            <div class="top-valoraciones-section">
                <h3>
                    <span class="trofeo-valoraciones">⭐</span>
                    Top 10 - Mejores Valoraciones
                </h3>
                
                <div class="top-valoraciones-container">
                    <?php if (!empty($topValoraciones)): ?>
                        <div class="top-valoraciones-grid">
                            <?php 
                            $posicion = 1;
                            foreach ($topValoraciones as $jugador => $datos): 
                                $colorPosicion = '';
                                if ($posicion === 1) $colorPosicion = 'gold';
                                elseif ($posicion === 2) $colorPosicion = 'silver';
                                elseif ($posicion === 3) $colorPosicion = 'bronze';
                            ?>
                                <div class="top-valoracion-card">
                                    <div class="posicion-valoracion" style="color: var(--<?php echo $colorPosicion; ?>-color);">
                                        <?php 
                                        if ($posicion === 1) echo '🥇';
                                        elseif ($posicion === 2) echo '🥈';
                                        elseif ($posicion === 3) echo '🥉';
                                        else echo $posicion . 'º';
                                        ?>
                                    </div>
                                    <div class="jugador-valoracion">
                                        <div class="nombre-jugador-valoracion"><?php echo htmlspecialchars($jugador); ?></div>
                                        <div class="equipo-jugador-valoracion">
                                            <?php echo htmlspecialchars($datos['equipo'] ?? 'Sin equipo'); ?>
                                        </div>
                                    </div>
                                    <div class="estadisticas-valoracion">
                                        <div class="valoracion-promedio">
                                            <div class="valoracion-numero"><?php echo number_format($datos['total'], 1); ?></div>
                                            <div class="valoracion-label">Puntos Totales</div>
                                        </div>
                                        <div class="detalles-valoracion">
                                            <div class="valoracion-veces"><?php echo $datos['veces']; ?> partido(s) jugados</div>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                            $posicion++;
                            endforeach; 
                            ?>
                        </div>
                    <?php else: ?>
                        <div class="sin-valoraciones">
                            No hay valoraciones registradas todavía.
                            <div style="margin-top: 15px; font-size: 0.9rem;">
                                Las valoraciones se registran al introducir resultados en los partidos.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sección Balón de Oro -->
            <div class="balon-oro-section">
                <h3>
                    <span class="trofeo-balon-oro">⚽</span>
                    Balón de Oro - Mejor Jugador de Fútbol Real
                </h3>
                
                <div class="balon-oro-container">
                    <?php if ($mostrarFormularioBalonOro): ?>
                        <?php if ($hayEmpateBalon): ?>
                            <div class="empate-mensaje">
                                <h4>⚖️ ¡Empate en la votación!</h4>
                                <p>Los siguientes jugadores están empatados con <?php echo max($_SESSION['balon_oro']['conteo'] ?? [0]); ?> votos cada uno:</p>
                                <div class="candidatos-empate">
                                    <?php foreach ($_SESSION['balon_oro']['candidatos_empate'] as $candidato): ?>
                                        <div class="candidato-empate"><?php echo htmlspecialchars($candidato); ?></div>
                                    <?php endforeach; ?>
                                </div>
                                <p style="margin-top: 15px; color: var(--warning-color);">
                                    <strong>Faltan <?php echo count($participantes_sin_votar_balon); ?> participantes por votar para desempatar.</strong>
                                </p>
                            </div>
                        <?php elseif (!$todosHanVotadoBalon): ?>
                            <div class="info-votacion" style="text-align: center; margin-bottom: 20px; padding: 15px; background: rgba(255,255,255,0.05); border-radius: 8px;">
                                <h4 style="color: var(--highlight-color);">Votación en curso</h4>
                                <p>Faltan <?php echo count($participantes_sin_votar_balon); ?> de <?php echo count($_SESSION['jugadores']); ?> participantes por votar.</p>
                            </div>
                        <?php endif; ?>

                        <form method="POST" class="form-balon-oro">
                            <div class="form-group">
                                <label for="votante_balon_oro">Tu Nombre (Participante que vota)</label>
                                <input type="text" id="votante_balon_oro" name="votante_balon_oro" class="form-control" 
                                       placeholder="Escribe tu nombre..." required
                                       value="<?php echo isset($_GET['votante']) ? htmlspecialchars($_GET['votante']) : ''; ?>">
                                <small style="color: var(--text-secondary);">
                                    Escribe exactamente tu nombre como aparece en el torneo
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="jugador_balon_oro">Jugador de Fútbol Real - Balón de Oro</label>
                                <input type="text" id="jugador_balon_oro" name="jugador_balon_oro" class="form-control" 
                                       placeholder="Ej: Lionel Messi, Cristiano Ronaldo..." required>
                                <small style="color: var(--text-secondary);">
                                    Elige al jugador de fútbol real que merece el Balón de Oro
                                </small>
                            </div>
                            <button type="submit" name="guardar_balon_oro" class="btn-balon-oro">
                                🏅 Votar Balón de Oro
                            </button>
                        </form>

                        <!-- Mostrar votos actuales SOLO cuando todos hayan votado -->
                        <?php if (!empty($_SESSION['balon_oro']['conteo']) && $todosHanVotadoBalon): ?>
                            <div class="votos-actuales" style="margin-top: 25px; padding: 15px; background: rgba(255,255,255,0.05); border-radius: 8px;">
                                <h4 style="color: var(--text-secondary); margin-bottom: 10px; text-align: center;">Votos Actuales (<?php echo count($_SESSION['balon_oro']['votos']); ?> de <?php echo count($_SESSION['jugadores']); ?>)</h4>
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px;">
                                    <?php 
                                    $conteo = $_SESSION['balon_oro']['conteo'];
                                    arsort($conteo); // Ordenar por votos descendente
                                    ?>
                                    <?php foreach ($conteo as $jugador => $votos): ?>
                                        <div style="text-align: center; padding: 8px; background: rgba(255,215,0,0.1); border-radius: 6px;">
                                            <div style="font-weight: bold; color: var(--gold-color);"><?php echo $votos; ?> voto(s)</div>
                                            <div style="font-size: 0.9rem; color: var(--text-color);"><?php echo htmlspecialchars($jugador); ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($participantes_sin_votar_balon)): ?>
                            <div class="jugadores-pendientes">
                                <h4>Participantes pendientes de votar (<?php echo count($participantes_sin_votar_balon); ?>):</h4>
                                <div class="lista-pendientes">
                                    <?php foreach ($participantes_sin_votar_balon as $participante): ?>
                                        <div class="jugador-pendiente"><?php echo htmlspecialchars($participante); ?></div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                    <?php elseif ($mostrarGanadorBalonOro): ?>
                        <!-- Mostrar ganador solo cuando todos hayan votado y haya un ganador claro -->
                        <div class="balon-oro-ganador">
                            <div class="balon-oro-jugador">
                                🏆 <?php echo htmlspecialchars($_SESSION['balon_oro']['ganador']); ?>
                            </div>
                            <div style="color: var(--text-secondary); margin-bottom: 25px;">
                                Ganador del Balón de Oro - Mejor Jugador de Fútbol Real
                            </div>
                            
                            <div class="balon-oro-estadisticas">
                                <div class="estadistica-balon">
                                    <div class="valor"><?php echo count($_SESSION['balon_oro']['votos']); ?></div>
                                    <div class="label">Total de Votos</div>
                                </div>
                                <div class="estadistica-balon">
                                    <div class="valor"><?php echo $_SESSION['balon_oro']['conteo'][$_SESSION['balon_oro']['ganador']] ?? 0; ?></div>
                                    <div class="label">Votos Recibidos</div>
                                </div>
                            </div>

                            <!-- Mostrar todos los votos -->
                            <div style="margin-top: 25px; padding: 20px; background: rgba(255,255,255,0.05); border-radius: 8px;">
                                <h4 style="color: var(--text-secondary); margin-bottom: 15px; text-align: center;">Detalle de Votos</h4>
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
                                    <?php 
                                    $conteo = $_SESSION['balon_oro']['conteo'];
                                    arsort($conteo); // Ordenar por votos descendente
                                    ?>
                                    <?php foreach ($conteo as $jugador => $votos): ?>
                                        <div style="text-align: center; padding: 10px; background: rgba(255,215,0,0.1); border-radius: 6px;">
                                            <div style="font-size: 1.2rem; font-weight: bold; color: var(--gold-color);"><?php echo $votos; ?></div>
                                            <div style="font-size: 0.9rem; color: var(--text-color);"><?php echo htmlspecialchars($jugador); ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Caso en que todos han votado pero hay empate -->
                        <div class="empate-mensaje">
                            <h4>⚖️ ¡Empate después de todas las votaciones!</h4>
                            <p>Todos los participantes han votado, pero hay un empate entre:</p>
                            <div class="candidatos-empate">
                                <?php foreach ($_SESSION['balon_oro']['candidatos_empate'] as $candidato): ?>
                                    <div class="candidato-empate"><?php echo htmlspecialchars($candidato); ?></div>
                                <?php endforeach; ?>
                            </div>
                            <p style="margin-top: 15px; color: var(--warning-color);">
                                <strong>No hay más participantes para desempatar. Consideren un desempate manual.</strong>
                            </p>
                            <a href="estadisticas.php?editar_balon_oro=1" class="btn-editar-puskas" style="margin-top: 15px; display: inline-block;">
                                ✏️ Reiniciar Votación
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sección de Records -->
            <div class="records-section">
                <h3>🏆 Records del Torneo</h3>
                <div class="records-grid">
                    <!-- Fila superior - 3 records -->
                    <div class="records-row">
                        <!-- Más Guarro -->
                        <div class="record-card">
                            <div class="record-icon">🟥🟨</div>
                            <div class="record-titulo">Más Guarro (Puntos)</div>
                            <div class="record-jugador"><?php echo $records['mas_guarro']['jugador'] ?? 'N/A'; ?></div>
                            <div class="record-dato"><?php echo $records['mas_guarro']['puntos_guarro'] ?? '0'; ?> pts</div>
                            <div class="record-info">
                                <?php 
                                if (isset($records['mas_guarro']['tarjetas_rojas'])) {
                                    echo $records['mas_guarro']['tarjetas_rojas'] . ' rojas (2pts) + ' . $records['mas_guarro']['tarjetas_amarillas'] . ' amarillas (1pt)';
                                }
                                ?>
                            </div>
                        </div>
                       <!-- Mayor Goleada -->
                        <div class="record-card">
                            <div class="record-icon">💥</div>
                            <div class="record-titulo">Mayor Goleada</div>
                            <div class="record-jugador">
                                <?php if (isset($records['mayor_goleada']['jugador'])) {
                                    // Obtener el equipo del jugador que hizo la mayor goleada
                                    $equipoGoleador = obtenerEquipoPorJugador($records['mayor_goleada']['jugador']);
                                    
                                }
                                echo $records['mayor_goleada']['jugador'] . ' (' . $equipoGoleador . ')' ?? 'N/A'; ?>
                            </div>
                            <div class="record-dato">
                                <?php 
                                if (isset($records['mayor_goleada']['goles_favor'])) {
                                    echo $records['mayor_goleada']['goles_favor'] . ' - ' . $records['mayor_goleada']['goles_contra'];
                                } else {
                                    echo 'N/A';
                                }
                                ?>
                            </div>
                            <div class="record-info">
                                
                                <?php 
                                 if (isset($records['mayor_goleada']['rival'])) {
                                    $jugadorRival = obtenerJugadorPorEquipo($records['mayor_goleada']['rival']);
                                    if ($jugadorRival) {
                                        echo 'vs ' . $jugadorRival . ' (' . $records['mayor_goleada']['rival'] . ')';
                                    } else {
                                        echo 'vs ' . $records['mayor_goleada']['rival'];
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Mayor Asistente -->
                        <div class="record-card">
                            <div class="record-icon">🎯</div>
                            <div class="record-titulo">Mayor Asistente</div>
                            <div class="record-jugador"><?php echo $records['mayor_asistente']['jugador'] ?? 'N/A'; ?></div>
                            <div class="record-dato"><?php echo $records['mayor_asistente']['asistencias'] ?? '0'; ?> asistencias</div>
                            <div class="record-info">
                                <?php 
                                if (isset($records['mayor_asistente']['equipo'])) {
                                    echo $records['mayor_asistente']['equipo'];
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- Fila inferior - 2 records centrados -->
                    <div class="records-row centered">
                        <!-- Máximo Goleador -->
                        <div class="record-card">
                            <div class="record-icon">⚽</div>
                            <div class="record-titulo">Máximo Goleador</div>
                            <div class="record-jugador"><?php echo $records['maximo_goleador']['jugador'] ?? 'N/A'; ?></div>
                            <div class="record-dato"><?php echo $records['maximo_goleador']['goles'] ?? '0'; ?> goles</div>
                        </div>

                        <!-- Máximo Encajador -->
                        <div class="record-card">
                            <div class="record-icon">🥅</div>
                            <div class="record-titulo">Máximo Encajador</div>
                            <div class="record-jugador"><?php echo $records['maximo_encajador']['jugador'] ?? 'N/A'; ?></div>
                            <div class="record-dato"><?php echo $records['maximo_encajador']['goles'] ?? '0'; ?> goles</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección de Jugadores -->
            <div class="jugadores-section">
                <h3>👥 Estadísticas por Jugador</h3>
                <div class="grid-jugadores">
                    <?php foreach ($estadisticasJugadores as $jugador => $stats): ?>
                        <a href="estadisticas.php?jugador=<?php echo urlencode($jugador); ?>" class="jugador-card">
                            <div class="nombre-jugador"><?php echo htmlspecialchars($jugador); ?></div>
                            <div class="estadisticas-jugador">
                                <div class="estadistica-item">
                                    <div class="estadistica-valor"><?php echo $stats['partidos_jugados']; ?></div>
                                    <div class="estadistica-label">Partidos</div>
                                </div>
                                <div class="estadistica-item">
                                    <div class="estadistica-valor"><?php echo $stats['goles_a_favor']; ?></div>
                                    <div class="estadistica-label">Goles a Favor</div>
                                </div>
                                <div class="estadistica-item">
                                    <div class="estadistica-valor"><?php echo $stats['goles_en_contra']; ?></div>
                                    <div class="estadistica-label">Goles en Contra</div>
                                </div>
                                <div class="estadistica-item">
                                    <div class="estadistica-valor"><?php echo $stats['tarjetas_rojas']; ?></div>
                                    <div class="estadistica-label">Tarjetas Rojas</div>
                                </div>
                                <div class="estadistica-item">
                                    <div class="estadistica-valor"><?php echo $stats['tarjetas_amarillas']; ?></div>
                                    <div class="estadistica-label">Tarjetas Amarillas</div>
                                </div>
                                <div class="estadistica-item">
                                    <div class="estadistica-valor"><?php echo $stats['puntos_guarro']; ?></div>
                                    <div class="estadistica-label">Puntos Guarro</div>
                                </div>
                            </div>
                            <div class="click-detalles">
                                Click para ver detalles completos
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Detalles del Jugador Seleccionado -->
            <?php if ($jugadorSeleccionado): ?>
                <div class="detalles-jugador">
                    <div class="detalles-header">
                        <h3>Estadísticas Detalladas de <?php echo htmlspecialchars($jugadorSeleccionado); ?></h3>
                        <a href="estadisticas.php" class="btn-cerrar">Cerrar Detalles</a>
                    </div>

                    <div class="mejor-peor-partido">
                        <!-- Mejor Partido -->
                        <div class="partido-card mejor">
                            <div class="partido-titulo">🥇 Mejor Partido</div>
                            <div class="partido-resultado">
                                <?php 
                                $mejor = $estadisticasJugadores[$jugadorSeleccionado]['mejor_resultado'];
                                echo $mejor['goles_favor'] . ' - ' . $mejor['goles_contra'];
                                ?>
                            </div>
                            <div class="partido-rival">
                                vs <?php echo $mejor['rival']; ?>
                            </div>
                            <div class="partido-diferencia">
                                Diferencia: +<?php echo $mejor['diferencia']; ?>
                            </div>
                        </div>

                        <!-- Peor Partido -->
                        <div class="partido-card peor">
                            <div class="partido-titulo">📉 Peor Partido</div>
                            <div class="partido-resultado">
                                <?php 
                                $peor = $estadisticasJugadores[$jugadorSeleccionado]['peor_resultado'];
                                echo $peor['goles_favor'] . ' - ' . $peor['goles_contra'];
                                ?>
                            </div>
                            <div class="partido-rival">
                                vs <?php echo $peor['rival']; ?>
                            </div>
                            <div class="partido-diferencia">
                                Diferencia: <?php echo $peor['diferencia']; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Otras estadísticas del jugador -->
                    <div class="estadisticas-adicionales">
                        <div class="estadistica-adicional">
                            <div class="valor" style="color: var(--success-color);">
                                <?php echo $estadisticasJugadores[$jugadorSeleccionado]['partidos_ganados']; ?>
                            </div>
                            <div class="label">Victorias</div>
                        </div>
                        <div class="estadistica-adicional">
                            <div class="valor" style="color: var(--warning-color);">
                                <?php echo $estadisticasJugadores[$jugadorSeleccionado]['partidos_empatados']; ?>
                            </div>
                            <div class="label">Empates</div>
                        </div>
                        <div class="estadistica-adicional">
                            <div class="valor" style="color: var(--danger-color);">
                                <?php echo $estadisticasJugadores[$jugadorSeleccionado]['partidos_perdidos']; ?>
                            </div>
                            <div class="label">Derrotas</div>
                        </div>
                        <div class="estadistica-adicional">
                            <div class="valor" style="color: var(--gold-color);">
                                <?php 
                                $golesFavor = $estadisticasJugadores[$jugadorSeleccionado]['goles_a_favor'];
                                $golesContra = $estadisticasJugadores[$jugadorSeleccionado]['goles_en_contra'];
                                echo $golesFavor - $golesContra;
                                ?>
                            </div>
                            <div class="label">Diferencia de Goles</div>
                        </div>
                        
                        <div class="estadistica-adicional">
                            <div class="valor" style="color: #e74c3c;">
                                <?php echo $estadisticasJugadores[$jugadorSeleccionado]['puntos_guarro']; ?>
                            </div>
                            <div class="label">Puntos Guarro</div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="navegacion-inferior">
            <a href="index.php" class="button">🏠 Volver al Inicio</a>
            <?php if (isset($_SESSION['campeon'])): ?>
                <a href="eliminatorias.php" class="button button-success">🏆 Ver Eliminatorias</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
