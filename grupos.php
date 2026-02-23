<?php
require_once 'includes/config.php';

// Definir plantillas de equipos con jugadores (CORREGIDOS LOS NOMBRES)
$plantillas_equipos = [
    'Real Madrid' => [
        'Porteros' => ['Thibaut Courtois', 'Andriy Lunin', 'Gonzalez', 'Mestre'],
        'Defensas' => ['Dani Carvajal', 'Antonio Rüdiger', 'David Alaba', 'Ferland Mendy', 'Éder Militão', 'Carreras', 'Huijsen', 'Alexander Arnold', 'Fran Garcia', 'Raul Asencio', 'Aguado', 'Fortea'],
        'Medios' => ['Jude Bellingham', 'Federico Valverde', 'Aurélien Tchouaméni', 'Eduardo Camavinga', 'Dani Ceballos', 'Pitarch'],
        'Delanteros' => ['Vinicius Jr', 'Rodrygo', 'Mbappe', 'Brahim Díaz', 'Arda Güler', 'Endrick', 'Gonzalo', 'Franco Mastantuono']
    ],
    'Barcelona' => [
        'Porteros' => ['Wojciech Szczęsny', 'Marc-André ter Stegen', 'Diego Kochen','García'],
        'Defensas' => ['Jules Koundé','Pau Cubarsí','Eric García','Alejandro Balde','Ronald Araujo','Andreas Christensen','Gerard Martín','Torrents'],
        'Medios' => ['Pedri', 'Frenkie de Jong', 'Fermín López', 'Dani Olmo', 'Marc Casadó', 'Gavi', 'Marc Bernal', 'Dro', 'Fernández'],
        'Delanteros' => ['Robert Lewandowski', 'Raphinha', 'Lamine Yamal', 'Ferran Torres', 'Marcus Rashford', 'Roony Bardghji', 'Fernández']
    ],
    'Bayern Munich' => [ // CORREGIDO: "Bayern de Múnich" -> "Bayern Múnich"
        'Porteros' => ['Manuel Neuer', 'Urbig', 'Sven Ulreich', 'Klanac', 'Bärtl' ],
        'Defensas' => ['Jonathan Tah', 'Dayot Upamecano', 'Josip Stanišić', 'Konrad Laimer', 'Kim Min Jae', 'Raphaël Guerreiro', 'Sacha Boey', 'Hiroki Ito', 'Alphonso Davies' ],
        'Medios' => ['Joshua Kimmich', 'Aleksandar Pavlović', 'Serge Gnabry', 'Leon Goretzka', 'Tom Bischof', 'Karl', 'Jamal Musiala', 'Santos Daiber' ],
        'Delanteros' => ['Harry Kane', 'Michael Olise', 'Luis Díaz', 'Nicolas Jackson', 'Mike' ]
    ],
    'Paris Saint-Germain' => [
        'Porteros' => ['Lucas Chevalier', 'Matvey Safonov', 'Marin' ],
        'Defensas' => ['Nuno Mendes', 'Willian Pacho', 'Marquinhos', 'Warren Zaïre-Emery', 'Lucas Hernández', 'Illia Zabarnyi', 'Lucas Beraldo', 'Kamara', 'Achraf Hakimi' ],
        'Medios' => ['Fabián Ruiz', 'Vitinha', 'João Neves', 'Senny Mayulu', 'Jangeal' ],
        'Delanteros' => ['Khvicha Kvaratskhelia', 'Ousmane Dembélé', 'Désiré Doué', 'Bradley Barcola', 'Ibrahim Mbaye', 'Ndjantou', 'Lee Kang-in', 'Gonçalo Ramos' ]
    ],
    'Liverpool' => [
        'Porteros' => ['Alisson', 'Mamardashvili', 'Woodman', 'Pécsi'],
        'Defensas' => ['van Dijk', 'Konaté', 'Kerkez', 'Bradley', 'Robertson', 'Gomez', 'Frimpong', 'Ramsay', 'Williams', 'Leoni'],
        'Medios' => ['Mac Allister', 'Gravenberch', 'Szoboszlai', 'Wirtz', 'Jones', 'Endo', 'Bajcetic', 'Nyoni'],
        'Delanteros' => ['Salah', 'Gakpo', 'Ekitiké', 'Isak', 'Chiesa', 'Ngumoha']
    ],
    'Manchester City' => [
        'Porteros' => ['Donnarumma', 'Trafford', 'Ortega', 'Bettinelli'],
        'Defensas' => ['Gvardiol', 'Dias', 'O\'Reilly', 'Nunes', 'Stones', 'Aït-Nouri', 'Khusanov', 'Lewis', 'Aké'],
        'Medios' => ['Rodri', 'Reijnders', 'Foden', 'Silva', 'González', 'Phillips', 'Kovačić'],
        'Delanteros' => ['Haaland', 'Doku', 'Bobb', 'Marmoush', 'Cherki', 'Savinho']
    ],
    'Arsenal' => [
        'Porteros' => ['Raya', 'Kepa'],
        'Defensas' => ['Gabriel', 'Saliba', 'Timber', 'Calafiori', 'White', 'Hincapié', 'Lewis-Skelly', 'Mosquera'],
        'Medios' => ['Rice', 'Zubimendi', 'Eze', 'Ødegaard', 'Merino', 'Nørgaard'],
        'Delanteros' => ['Gyökeres', 'Saka', 'Trossard', 'Havertz', 'Jesus', 'Martinelli', 'Madueke', 'Nwaneri']
    ],
    'Atlético de Madrid' => [
        'Porteros' => ['Oblak', 'Musso', 'Esquivel'],
        'Defensas' => ['Hancko', 'Giménez', 'Le Normand', 'Llorente', 'Lenglet', 'Ruggeri', 'Molina', 'Galán', 'Pubill', 'Kostis'],
        'Medios' => ['Koke', 'Barrios', 'Baena', 'Simeone', 'Cardoso', 'Gonzalez', 'Almada', 'Gallagher'],
        'Delanteros' => ['Alvarez', 'Sørloth', 'Griezmann', 'Raspadori', 'Martín']
    ],
    'Chelsea' => [ // CORREGIDO: "Chealsea" -> "Chelsea"
        'Porteros' => ['Sánchez', 'Jörgensen', 'Slonina'],
        'Defensas' => ['Cucurella', 'Adarabioyo', 'Chalobah', 'James', 'Fofana', 'Gusto', 'Hato', 'Acheampong', 'Badiashile', 'Colwill', 'Disasi'],
        'Medios' => ['Fernández', 'Caicedo', 'Palmer', 'Santos', 'Lavia', 'Buonanotte', 'Essugo'],
        'Delanteros' => ['João Pedro', 'Garnacho', 'Neto', 'Estêvão', 'Gittens', 'Delap', 'Guiu', 'George', 'Sterling']
    ],
    'Inter de Milán' => [
        'Porteros' => ['Sommer', 'Martínez', 'Di Gennaro'],
        'Defensas' => ['Bastoni', 'Acerbi', 'Akanji', 'Dimarco', 'Dumfries', 'Carlos Augusto', 'Bisseck', 'de Vrij', 'Palacios', 'Darmian'],
        'Medios' => ['Mkhitaryan', 'Çalhanoğlu', 'Barella', 'Zieliński', 'Luis Henrique', 'Sučić', 'Frattesi', 'Diouf'],
        'Delanteros' => ['Martínez', 'Thuram', 'Bonny', 'Esposito']
    ],
    'Borussia Dortmund' => [ // CORREGIDO: "Borussia Dormunt" -> "Borussia Dortmund"
        'Porteros' => ['Kobel', 'Meyer', 'Ostrzinski', 'Drewes'],
        'Defensas' => ['Schlotterbeck', 'Anton', 'Anselmino', 'Bensebaini', 'Couto', 'Can', 'Mane', 'Süle', 'Kabar'],
        'Medios' => ['Nmecha', 'Sabitzer', 'Ryerson', 'Brandt', 'Svensson', 'Chukwuemeka', 'Bellingham', 'Groß', 'Özcan', 'Duranville', 'Campbell'],
        'Delanteros' => ['Guirassy', 'Adeyemi', 'Silva', 'Beier']
    ],
    'Newcastle' => [ // CORREGIDO: "NewCastle" -> "Newcastle"
        'Porteros' => ['Pope', 'Ramsdale', 'Ruddy', 'Gillespie', 'Thompson'],
        'Defensas' => ['Burn', 'Botman', 'Thiaw', 'Trippier', 'Schär', 'Livramento', 'Krafth', 'Lascelles', 'Hall', 'Murphy (LI)', 'Ashby'],
        'Medios' => ['Joelinton', 'Tonali', 'Guimarães', 'Willock', 'Miley'],
        'Delanteros' => ['Gordon', 'Woltemade', 'Murphy (ED)', 'Barnes', 'Elanga', 'Osula', 'Ramsey', 'Wissa']
    ]
];

// Función para obtener todos los jugadores de un equipo con mejor manejo de errores
function obtenerJugadoresEquipo($equipo, $plantillas_equipos) {
    // Mapeo de nombres alternativos
    $mapeo_nombres = [
        'Bayern de Munich' => 'Bayern Munich',
        'Borussia Dormunt' => 'Borussia Dortmund',
        'NewCastle' => 'Newcastle',
        'Chealsea' => 'Chelsea',
        'Atletico de Madrid' => 'Atlético de Madrid'
    ];
    
    // Verificar si el nombre necesita ser mapeado
    if (isset($mapeo_nombres[$equipo])) {
        $equipo = $mapeo_nombres[$equipo];
    }
    
    if (isset($plantillas_equipos[$equipo])) {
        $jugadores = [];
        foreach ($plantillas_equipos[$equipo] as $posicion => $jugadores_posicion) {
            $jugadores = array_merge($jugadores, $jugadores_posicion);
        }
        return $jugadores;
    }
    
    // Si no se encuentra, buscar variaciones
    foreach ($plantillas_equipos as $nombre_equipo => $plantilla) {
        // Comparación insensible a mayúsculas y sin tildes
        $nombre1 = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $equipo));
        $nombre2 = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $nombre_equipo));
        
        if ($nombre1 === $nombre2) {
            $jugadores = [];
            foreach ($plantilla as $posicion => $jugadores_posicion) {
                $jugadores = array_merge($jugadores, $jugadores_posicion);
            }
            return $jugadores;
        }
    }
    
    return [];
}

// Verificar que hay equipos asignados
if (count($_SESSION['asignaciones']) < 8) {
    header('Location: sorteo.php');
    exit();
}

// Función mejorada para generar calendario equilibrado
function generarCalendarioEquilibrado($equipos_grupo) {
    $num_equipos = count($equipos_grupo);
    $calendario = [];
    
    // Si el número de equipos es impar, añadimos un descanso
    if ($num_equipos % 2 != 0) {
        array_push($equipos_grupo, 'Descansa');
        $num_equipos++;
    }
    
    $num_jornadas = $num_equipos - 1;
    
    for ($jornada = 0; $jornada < $num_jornadas; $jornada++) {
        $partidos_jornada = [];
        
        for ($i = 0; $i < $num_equipos / 2; $i++) {
            $local = $equipos_grupo[$i];
            $visitante = $equipos_grupo[$num_equipos - 1 - $i];
            
            // Solo añadir partido si no es descanso
            if ($local != 'Descansa' && $visitante != 'Descansa') {
                // Alternar localías para equilibrar
                if ($jornada % 2 == 0 && $i % 2 == 0) {
                    $partidos_jornada[] = [
                        'local' => $local,
                        'visitante' => $visitante,
                        'jugado' => false,
                        'goles_local' => null,
                        'goles_visitante' => null,
                        'tarjetas_rojas_local' => 0,
                        'tarjetas_rojas_visitante' => 0,
                        'tarjetas_amarillas_local' => 0,
                        'tarjetas_amarillas_visitante' => 0,
                        // Nuevos campos para jugadores y valoraciones
                        'local_jugador1' => null,
                        'local_valoracion1' => null,
                        'local_jugador2' => null,
                        'local_valoracion2' => null,
                        'visitante_jugador1' => null,
                        'visitante_valoracion1' => null,
                        'visitante_jugador2' => null,
                        'visitante_valoracion2' => null
                    ];
                } else {
                    $partidos_jornada[] = [
                        'local' => $visitante,
                        'visitante' => $local,
                        'jugado' => false,
                        'goles_local' => null,
                        'goles_visitante' => null,
                        'tarjetas_rojas_local' => 0,
                        'tarjetas_rojas_visitante' => 0,
                        'tarjetas_amarillas_local' => 0,
                        'tarjetas_amarillas_visitante' => 0,
                        // Nuevos campos para jugadores y valoraciones
                        'local_jugador1' => null,
                        'local_valoracion1' => null,
                        'local_jugador2' => null,
                        'local_valoracion2' => null,
                        'visitante_jugador1' => null,
                        'visitante_valoracion1' => null,
                        'visitante_jugador2' => null,
                        'visitante_valoracion2' => null
                    ];
                }
            }
        }
        
        $calendario[] = $partidos_jornada;
        
        // Rotar equipos (excepto el primero)
        $ultimo = array_pop($equipos_grupo);
        array_splice($equipos_grupo, 1, 0, $ultimo);
    }
    
    return $calendario;
}

// Sistema de ranking predefinido para los equipos
$rankings_equipos = [
    'Liverpool' => 94,
    'Barcelona' => 95,
    'Real Madrid' => 98,
    'Bayern Munich' => 99, // CORREGIDO
    'Paris Saint-Germain' => 97,
    'Manchester City' => 93,
    'Arsenal' => 96,
    'Atlético de Madrid' => 91,
    'Chelsea' => 89,
    'Inter de Milán' => 88,
    'Borussia Dortmund' => 90, // CORREGIDO
    'Newcastle' => 92
];



// Función para calcular enfrentamiento directo entre dos equipos
function calcularEnfrentamientoDirecto($equipo1, $equipo2, $calendario) {
    $puntos_equipo1 = 0;
    $puntos_equipo2 = 0;
    $dg_equipo1 = 0;
    $dg_equipo2 = 0;
    $gf_equipo1 = 0;
    $gf_equipo2 = 0;
    
    foreach ($calendario as $jornada) {
        foreach ($jornada as $partido) {
            if ($partido['jugado']) {
                // Verificar si es un partido entre estos dos equipos
                if (($partido['local'] == $equipo1 && $partido['visitante'] == $equipo2) ||
                    ($partido['local'] == $equipo2 && $partido['visitante'] == $equipo1)) {
                    
                    $goles_local = $partido['goles_local'];
                    $goles_visitante = $partido['goles_visitante'];
                    
                    // Determinar qué equipo es local y cuál visitante en este contexto
                    if ($partido['local'] == $equipo1) {
                        $gf_equipo1 += $goles_local;
                        $gf_equipo2 += $goles_visitante;
                        $dg_equipo1 += ($goles_local - $goles_visitante);
                        $dg_equipo2 += ($goles_visitante - $goles_local);
                        
                        if ($goles_local > $goles_visitante) {
                            $puntos_equipo1 += 3;
                        } elseif ($goles_local < $goles_visitante) {
                            $puntos_equipo2 += 3;
                        } else {
                            $puntos_equipo1 += 1;
                            $puntos_equipo2 += 1;
                        }
                    } else {
                        $gf_equipo1 += $goles_visitante;
                        $gf_equipo2 += $goles_local;
                        $dg_equipo1 += ($goles_visitante - $goles_local);
                        $dg_equipo2 += ($goles_local - $goles_visitante);
                        
                        if ($goles_visitante > $goles_local) {
                            $puntos_equipo1 += 3;
                        } elseif ($goles_visitante < $goles_local) {
                            $puntos_equipo2 += 3;
                        } else {
                            $puntos_equipo1 += 1;
                            $puntos_equipo2 += 1;
                        }
                    }
                }
            }
        }
    }
    
    return [
        $equipo1 => ['puntos' => $puntos_equipo1, 'dg' => $dg_equipo1, 'gf' => $gf_equipo1],
        $equipo2 => ['puntos' => $puntos_equipo2, 'dg' => $dg_equipo2, 'gf' => $gf_equipo2]
    ];
}

// Función para calcular tabla de posiciones con nuevos criterios de desempate
function calcularTablaPosiciones($equipos_grupo, $calendario) {
    global $rankings_equipos;
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
            'tr' => 0,  // Tarjetas rojas
            'ta' => 0,  // Tarjetas amarillas
            'ranking' => isset($rankings_equipos[$equipo]) ? $rankings_equipos[$equipo] : 50 // Ranking del equipo
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
                
                // Actualizar tarjetas amarillas
                $tabla[$local]['ta'] += $partido['tarjetas_amarillas_local'];
                $tabla[$visitante]['ta'] += $partido['tarjetas_amarillas_visitante'];
                
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
    
    // Ordenar tabla aplicando todos los criterios de desempate
    uasort($tabla, function($a, $b) use ($calendario, $tabla) {
        // 1. Puntos
        if ($a['pts'] != $b['pts']) {
            return $b['pts'] - $a['pts'];
        }
        // 2. Diferencia de goles general
        if ($a['dg'] != $b['dg']) {
            return $b['dg'] - $a['dg'];
        }
        
        // 3. Enfrentamiento directo
        $equipos_empatados = [];
        foreach ($tabla as $equipo => $datos) {
            if ($datos['pts'] == $a['pts']) {
                $equipos_empatados[] = $equipo;
            }
        }
        
        // Si solo hay dos equipos empatados, aplicar enfrentamiento directo
        if (count($equipos_empatados) == 2) {
            $enfrentamiento = calcularEnfrentamientoDirecto($equipos_empatados[0], $equipos_empatados[1], $calendario);
            
            $equipoA = $equipos_empatados[0];
            $equipoB = $equipos_empatados[1];
            
            // Comparar puntos en enfrentamiento directo
            if ($enfrentamiento[$equipoA]['puntos'] != $enfrentamiento[$equipoB]['puntos']) {
                return $enfrentamiento[$equipoB]['puntos'] - $enfrentamiento[$equipoA]['puntos'];
            }
            
            // Comparar diferencia de goles en enfrentamiento directo
            if ($enfrentamiento[$equipoA]['dg'] != $enfrentamiento[$equipoB]['dg']) {
                return $enfrentamiento[$equipoB]['dg'] - $enfrentamiento[$equipoA]['dg'];
            }
            
            // Comparar goles a favor en enfrentamiento directo
            if ($enfrentamiento[$equipoA]['gf'] != $enfrentamiento[$equipoB]['gf']) {
                return $enfrentamiento[$equipoB]['gf'] - $enfrentamiento[$equipoA]['gf'];
            }
        }
        
        
        
        // 4. Goles a favor general
        if ($a['gf'] != $b['gf']) {
            return $b['gf'] - $a['gf'];
        }
        
        // 5. Fair Play (menos tarjetas rojas, luego menos tarjetas amarillas)
        if ($a['tr'] != $b['tr']) {
            return $a['tr'] - $b['tr']; // Menos tarjetas rojas es mejor
        }
        if ($a['ta'] != $b['ta']) {
            return $a['ta'] - $b['ta']; // Menos tarjetas amarillas es mejor
        }
        
        // 6. Ranking (peor equipo pasa primero)
        return $a['ranking'] - $b['ranking'];
    });
    
    return $tabla;
}

// Función para verificar si todos los partidos están jugados
function todosPartidosJugados($grupos_sorteados) {
    foreach ($grupos_sorteados as $grupo) {
        foreach ($grupo['calendario'] as $jornada) {
            foreach ($jornada as $partido) {
                if (!$partido['jugado']) {
                    return false;
                }
            }
        }
    }
    return true;
}

// Realizar sorteo de grupos
if (isset($_POST['sorteo_grupos']) && !isset($_SESSION['grupos_sorteados'])) {
    $equipos = array_column($_SESSION['asignaciones'], 'equipo');
    shuffle($equipos); // Mezclar aleatoriamente
    
    // Dividir en dos grupos
    $grupo_a = array_slice($equipos, 0, 4);
    $grupo_b = array_slice($equipos, 4, 4);
    
    // Generar calendarios equilibrados
    $calendario_a = generarCalendarioEquilibrado($grupo_a);
    $calendario_b = generarCalendarioEquilibrado($grupo_b);
    
    $_SESSION['grupos_sorteados'] = [
        'grupo_a' => [
            'equipos' => $grupo_a,
            'calendario' => $calendario_a
        ],
        'grupo_b' => [
            'equipos' => $grupo_b,
            'calendario' => $calendario_b
        ]
    ];
    
    // Crear lista mezclada de equipos para la animación con secuencia ALEATORIA de grupos
    $equipos_mezclados = [];
    
    // Primero creamos arrays separados para cada grupo
    $equipos_grupo_a = [];
    $equipos_grupo_b = [];
    
    foreach ($grupo_a as $equipo) {
        $equipos_grupo_a[] = ['equipo' => $equipo, 'grupo' => 'A'];
    }
    
    foreach ($grupo_b as $equipo) {
        $equipos_grupo_b[] = ['equipo' => $equipo, 'grupo' => 'B'];
    }
    
    // Mezclamos los equipos dentro de cada grupo
    shuffle($equipos_grupo_a);
    shuffle($equipos_grupo_b);
    
    // Ahora creamos una secuencia aleatoria de grupos (4 A y 4 B)
    $secuencia_grupos = array_merge(
        array_fill(0, 4, 'A'),
        array_fill(0, 4, 'B')
    );
    shuffle($secuencia_grupos); // Mezclar la secuencia: ej. A,B,B,A,B,A,A,B
    
    // Construir la lista final con la secuencia aleatoria
    $indice_a = 0;
    $indice_b = 0;
    
    foreach ($secuencia_grupos as $grupo) {
        if ($grupo === 'A' && $indice_a < count($equipos_grupo_a)) {
            $equipos_mezclados[] = $equipos_grupo_a[$indice_a];
            $indice_a++;
        } elseif ($grupo === 'B' && $indice_b < count($equipos_grupo_b)) {
            $equipos_mezclados[] = $equipos_grupo_b[$indice_b];
            $indice_b++;
        }
    }
    
    $_SESSION['animacion_sorteo'] = [
        'equipos_mezclados' => $equipos_mezclados,
        'completado' => false
    ];
}

// Procesar resultados de partidos
if (isset($_POST['guardar_resultado'])) {
    $grupo = $_POST['grupo'];
    $jornada_index = $_POST['jornada'];
    $partido_index = $_POST['partido'];
    
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    // Nuevos campos para jugadores y valoraciones
    $local_jugador1 = $_POST['local_jugador1'] ?? '';
    $local_valoracion1 = $_POST['local_valoracion1'] ?? '';
    $local_jugador2 = $_POST['local_jugador2'] ?? '';
    $local_valoracion2 = $_POST['local_valoracion2'] ?? '';
    $visitante_jugador1 = $_POST['visitante_jugador1'] ?? '';
    $visitante_valoracion1 = $_POST['visitante_valoracion1'] ?? '';
    $visitante_jugador2 = $_POST['visitante_jugador2'] ?? '';
    $visitante_valoracion2 = $_POST['visitante_valoracion2'] ?? '';
    
    // Validar datos
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['jugado'] = true;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['goles_local'] = $goles_local;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['goles_visitante'] = $goles_visitante;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        // Guardar datos de jugadores y valoraciones
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['local_jugador1'] = $local_jugador1;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['local_valoracion1'] = $local_valoracion1;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['local_jugador2'] = $local_jugador2;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['local_valoracion2'] = $local_valoracion2;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['visitante_jugador1'] = $visitante_jugador1;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['visitante_valoracion1'] = $visitante_valoracion1;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['visitante_jugador2'] = $visitante_jugador2;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['visitante_valoracion2'] = $visitante_valoracion2;
    }
    
    header('Location: grupos.php');
    exit();
}

// EDITAR RESULTADO
if (isset($_POST['editar_resultado'])) {
    $grupo = $_POST['grupo'];
    $jornada_index = $_POST['jornada'];
    $partido_index = $_POST['partido'];
    
    $goles_local = intval($_POST['goles_local']);
    $goles_visitante = intval($_POST['goles_visitante']);
    $tarjetas_rojas_local = intval($_POST['tarjetas_rojas_local']);
    $tarjetas_rojas_visitante = intval($_POST['tarjetas_rojas_visitante']);
    $tarjetas_amarillas_local = intval($_POST['tarjetas_amarillas_local']);
    $tarjetas_amarillas_visitante = intval($_POST['tarjetas_amarillas_visitante']);
    
    // Nuevos campos para jugadores y valoraciones
    $local_jugador1 = $_POST['local_jugador1'] ?? '';
    $local_valoracion1 = $_POST['local_valoracion1'] ?? '';
    $local_jugador2 = $_POST['local_jugador2'] ?? '';
    $local_valoracion2 = $_POST['local_valoracion2'] ?? '';
    $visitante_jugador1 = $_POST['visitante_jugador1'] ?? '';
    $visitante_valoracion1 = $_POST['visitante_valoracion1'] ?? '';
    $visitante_jugador2 = $_POST['visitante_jugador2'] ?? '';
    $visitante_valoracion2 = $_POST['visitante_valoracion2'] ?? '';
    
    // Validar datos
    if ($goles_local >= 0 && $goles_visitante >= 0 && 
        $tarjetas_rojas_local >= 0 && $tarjetas_rojas_visitante >= 0 &&
        $tarjetas_amarillas_local >= 0 && $tarjetas_amarillas_visitante >= 0) {
        
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['goles_local'] = $goles_local;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['goles_visitante'] = $goles_visitante;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['tarjetas_rojas_local'] = $tarjetas_rojas_local;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['tarjetas_rojas_visitante'] = $tarjetas_rojas_visitante;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['tarjetas_amarillas_local'] = $tarjetas_amarillas_local;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['tarjetas_amarillas_visitante'] = $tarjetas_amarillas_visitante;
        
        // Actualizar datos de jugadores y valoraciones
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['local_jugador1'] = $local_jugador1;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['local_valoracion1'] = $local_valoracion1;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['local_jugador2'] = $local_jugador2;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['local_valoracion2'] = $local_valoracion2;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['visitante_jugador1'] = $visitante_jugador1;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['visitante_valoracion1'] = $visitante_valoracion1;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['visitante_jugador2'] = $visitante_jugador2;
        $_SESSION['grupos_sorteados'][$grupo]['calendario'][$jornada_index][$partido_index]['visitante_valoracion2'] = $visitante_valoracion2;
    }
    
    header('Location: grupos.php');
    exit();
}

// Reiniciar grupos
if (isset($_POST['reiniciar_grupos'])) {
    unset($_SESSION['grupos_sorteados']);
    unset($_SESSION['animacion_sorteo']);
    header('Location: grupos.php');
    exit();
}

// Marcar animación como completada
if (isset($_GET['completar_animacion'])) {
    if (isset($_SESSION['animacion_sorteo'])) {
        $_SESSION['animacion_sorteo']['completado'] = true;
    }
    header('Location: grupos.php');
    exit();
}

// Calcular tablas de posiciones si los grupos están sorteados
$tabla_a = [];
$tabla_b = [];
$todos_partidos_jugados = false;

if (isset($_SESSION['grupos_sorteados'])) {
    $tabla_a = calcularTablaPosiciones(
        $_SESSION['grupos_sorteados']['grupo_a']['equipos'],
        $_SESSION['grupos_sorteados']['grupo_a']['calendario']
    );
    
    $tabla_b = calcularTablaPosiciones(
        $_SESSION['grupos_sorteados']['grupo_b']['equipos'],
        $_SESSION['grupos_sorteados']['grupo_b']['calendario']
    );
    
    // Verificar si todos los partidos están jugados
    $todos_partidos_jugados = todosPartidosJugados($_SESSION['grupos_sorteados']);
}

// Determinar si mostrar animación o contenido completo
$mostrar_animacion = isset($_SESSION['animacion_sorteo']) && 
                    !$_SESSION['animacion_sorteo']['completado'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupos - Torneo FIFA 26</title>
    
    <style>
/* ===== VARIABLES Y ESTILOS BASE ===== */
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
    --text-color: #ffffff;
    --text-secondary: #b0b0b0;
    --border-radius: 12px;
    --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    --transition: all 0.3s ease;
    --gradient-primary: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
    --gradient-accent: linear-gradient(135deg, #e94560, #ff6b6b, #ff8e8e);
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

/* ===== BOTONES GENERALES ===== */
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

.button-danger {
    background: rgba(231, 76, 60, 0.2);
    border-color: rgba(231, 76, 60, 0.5);
}

.button-danger:hover {
    background: rgba(231, 76, 60, 0.3);
}

.navegacion-inferior {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 40px;
    flex-wrap: wrap;
}

/* ===== HEADER DE GRUPOS ===== */
.grupos-container {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: var(--box-shadow);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.header-grupos {
    text-align: center;
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
}

.header-grupos::after {
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

.header-grupos h2 {
    font-size: 2.5rem;
    margin-bottom: 10px;
    background: linear-gradient(to right, var(--text-color), var(--highlight-color));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    text-shadow: 0 0 10px rgba(233, 69, 96, 0.3);
}

.header-grupos p {
    font-size: 1.2rem;
    color: var(--text-secondary);
}

/* ===== ESTADO PREVIO AL SORTEO ===== */
.estado-sorteo {
    text-align: center;
    padding: 40px 20px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.estado-sorteo h3 {
    font-size: 2rem;
    margin-bottom: 15px;
    color: var(--highlight-color);
}

.estado-sorteo p {
    font-size: 1.1rem;
    color: var(--text-secondary);
    margin-bottom: 30px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.estadisticas-grupos {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
    max-width: 700px;
    margin: 0 auto 30px;
}

.estadistica-item {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 20px;
    text-align: center;
    transition: var(--transition);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.estadistica-item:hover {
    transform: translateY(-5px);
    background: rgba(255, 255,255, 0.1);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
}

.estadistica-valor {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 5px;
    color: var(--highlight-color);
}

.estadistica-label {
    font-size: 0.9rem;
    color: var(--text-secondary);
}

/* ===== ANIMACIÓN DE SORTEO ===== */
.animacion-sorteo {
    text-align: center;
    padding: 20px;
    margin-bottom: 30px;
    background: rgba(233, 69, 96, 0.1);
    border-radius: var(--border-radius);
    border: 1px solid rgba(233, 69, 96, 0.3);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(233, 69, 96, 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(233, 69, 96, 0); }
    100% { box-shadow: 0 0 0 0 rgba(233, 69, 96, 0); }
}

/* ===== ANIMACIÓN DE SORTEO DINÁMICA ===== */
.animacion-sorteo-dinamica {
    text-align: center;
    padding: 40px 30px;
    margin-bottom: 30px;
    background: rgba(15, 52, 96, 0.4);
    border-radius: var(--border-radius);
    border: 3px solid rgba(233, 69, 96, 0.6);
    position: relative;
    overflow: hidden;
    min-height: 400px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.animacion-sorteo-dinamica::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    animation: shine 2s infinite;
}

@keyframes shine {
    0% { left: -100%; }
    100% { left: 100%; }
}

.equipo-sorteado {
    font-size: 3rem;
    font-weight: bold;
    margin: 30px 0;
    padding: 25px 40px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 15px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    animation: teamReveal 1s ease-out;
    text-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(10px);
    min-width: 400px;
    position: relative;
    overflow: hidden;
}

@keyframes teamReveal {
    0% { 
        opacity: 0; 
        transform: scale(0.5) translateY(50px); 
        filter: blur(10px);
    }
    50% { 
        opacity: 0.7; 
        transform: scale(1.1) translateY(-10px);
    }
    100% { 
        opacity: 1; 
        transform: scale(1) translateY(0);
        filter: blur(0);
    }
}

.grupo-asignado {
    font-size: 2rem;
    color: var(--highlight-color);
    margin: 20px 0;
    font-weight: bold;
    animation: groupReveal 0.8s ease-out 0.3s both;
    text-shadow: 0 0 15px rgba(233, 69, 96, 0.7);
    padding: 15px 30px;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 10px;
    border: 1px solid rgba(233, 69, 96, 0.4);
}

@keyframes groupReveal {
    0% { 
        opacity: 0; 
        transform: scale(0.8) translateX(-50px);
    }
    100% { 
        opacity: 1; 
        transform: scale(1) translateX(0);
    }
}

.contador-sorteo {
    font-size: 1.5rem;
    color: var(--text-secondary);
    margin-top: 25px;
    padding: 10px 20px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    animation: fadeIn 0.5s ease;
}

.equipo-flotante {
    position: absolute;
    font-size: 1.2rem;
    opacity: 0;
    animation: floatAround 15s linear infinite;
    pointer-events: none;
    z-index: 1;
}

@keyframes floatAround {
    0% { 
        transform: translate(0, 0) rotate(0deg); 
        opacity: 0;
    }
    10% { opacity: 0.7; }
    90% { opacity: 0.7; }
    100% { 
        transform: translate(calc(100vw - 200px), calc(100vh - 200px)) rotate(360deg); 
        opacity: 0;
    }
}

/* Colores específicos para grupos */
.grupo-a-color {
    color: #4A90E2;
    border-color: #4A90E2;
    text-shadow: 0 0 15px rgba(74, 144, 226, 0.7);
}

.grupo-b-color {
    color: #E24A4A;
    border-color: #E24A4A;
    text-shadow: 0 0 15px rgba(226, 74, 74, 0.7);
}

/* ===== GRID DE GRUPOS ===== */
.grid-grupos {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-bottom: 40px;
}

.grupo {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 25px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.grupo::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, transparent, rgba(255, 255, 255, 0.03), transparent);
    z-index: -1;
}

.grupo:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
}

.grupo-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.grupo-nombre {
    font-size: 1.8rem;
    color: var(--text-color);
}

.grupo-badge {
    background: var(--gradient-accent);
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
}

/* ===== TABLAS DE POSICIONES ===== */
.tabla-posiciones {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 25px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.tabla-posiciones th {
    background: rgba(255, 255, 255, 0.1);
    padding: 12px 8px;
    text-align: center;
    font-weight: bold;
    font-size: 0.85rem;
    color: var(--highlight-color);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.tabla-posiciones td {
    padding: 10px 8px;
    text-align: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    transition: var(--transition);
}

.tabla-posiciones tr:hover td {
    background: rgba(255, 255, 255, 0.05);
}

.posicion-destacada {
    background: rgba(76, 175, 80, 0.1) !important;
    border-left: 3px solid var(--success-color);
}

.equipo-tabla {
    text-align: left !important;
    font-weight: bold;
    padding-left: 15px !important;
}

/* ===== CALENDARIO DE PARTIDOS ===== */
.calendario-grupo {
    margin-top: 25px;
}

.calendario-titulo {
    font-size: 1.3rem;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    color: var(--highlight-color);
}

.jornada {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 20px;
    margin-bottom: 20px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: var(--transition);
}

.jornada:hover {
    background: rgba(255, 255, 255, 0.08);
}

.jornada-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.jornada-numero {
    font-weight: bold;
    color: var(--highlight-color);
}

.jornada-fecha {
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.partidos-jornada {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.partido {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 15px;
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 15px;
    align-items: center;
    transition: var(--transition);
    border: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
}

.partido:hover {
    background: rgba(255, 255, 255, 0.08);
    transform: translateX(5px);
}

.partido.jugado {
    border-left: 4px solid var(--success-color);
}

.equipo-local, .equipo-visitante {
    font-weight: 500;
    text-align: center;
    padding: 8px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 6px;
}

.equipo-local {
    text-align: right;
}

.equipo-visitante {
    text-align: left;
}

.resultado {
    font-size: 1.3rem;
    font-weight: bold;
    text-align: center;
    padding: 8px 15px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 6px;
    min-width: 80px;
}

.vs {
    font-size: 1.1rem;
    font-weight: bold;
    text-align: center;
    color: var(--highlight-color);
    padding: 8px 15px;
}

.tarjetas-info {
    grid-column: 1 / -1;
    text-align: center;
    font-size: 0.85rem;
    color: var(--danger-color);
    padding: 5px;
    background: rgba(231, 76, 60, 0.1);
    border-radius: 4px;
    margin-top: 5px;
}

.amarillas-info {
    grid-column: 1 / -1;
    text-align: center;
    font-size: 0.85rem;
    color: var(--warning-color);
    padding: 5px;
    background: rgba(243, 156, 18, 0.1);
    border-radius: 4px;
    margin-top: 5px;
}

.valoraciones-info {
    grid-column: 1 / -1;
    text-align: center;
    font-size: 0.85rem;
    color: #4CAF50;
    padding: 8px;
    background: rgba(76, 175, 80, 0.1);
    border-radius: 6px;
    margin-top: 8px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.valoracion-equipo {
    padding: 5px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 4px;
}

.valoracion-jugador {
    font-size: 0.8rem;
    color: var(--text-color);
    margin-top: 3px;
}

/* ===== FORMULARIOS DE RESULTADOS ===== */
.form-resultado {
    grid-column: 1 / -1;
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 15px;
    align-items: center;
    margin-top: 10px;
    padding: 15px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.form-goles {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    grid-column: 1 / -1;
}

.input-resultado {
    width: 60px;
    padding: 8px;
    text-align: center;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 6px;
    color: var(--text-color);
    font-size: 1rem;
    transition: var(--transition);
}

.input-resultado:focus {
    outline: none;
    border-color: var(--highlight-color);
    box-shadow: 0 0 5px rgba(233, 69, 96, 0.5);
}

.form-tarjetas {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 10px;
    grid-column: 1 / -1;
}

.tarjeta-grupo {
    display: flex;
    align-items: center;
    gap: 5px;
}

/* ===== FORMULARIO DE JUGADORES ===== */
.form-jugadores {
    grid-column: 1 / -1;
    margin-top: 15px;
    padding: 15px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.jugadores-equipo {
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.jugadores-equipo h4 {
    margin-bottom: 10px;
    color: var(--text-color);
    font-size: 1rem;
}

.jugadores-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.jugador-input {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.jugador-input label {
    font-size: 0.85rem;
    color: var(--text-secondary);
}

.jugador-input select {
    padding: 8px;
    background: rgba(0, 0, 0, 0.3); /* FONDO MÁS OSCURO PARA MEJOR CONTRASTE */
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 4px;
    color: var(--text-color); /* TEXTO BLANCO */
    font-size: 0.9rem;
    cursor: pointer;
}

.jugador-input select:focus {
    outline: none;
    border-color: var(--highlight-color);
    box-shadow: 0 0 5px rgba(233, 69, 96, 0.5);
}

.jugador-input select option {
    background-color: #1a1a2e; /* FONDO OSCURO PARA OPCIONES */
    color: var(--text-color); /* TEXTO BLANCO */
}

/* Estilo para el placeholder en select */
.jugador-input select option[value=""] {
    color: var(--text-secondary);
}

/* ===== BOTONES DE ACCIÓN ===== */
.btn-guardar, .btn-editar {
    padding: 8px 15px;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    transition: var(--transition);
    font-size: 0.85rem;
}

.btn-guardar {
    background: var(--success-color);
    color: white;
    grid-column: 1 / -1;
    justify-self: center;
    margin-top: 10px;
}

.btn-guardar:hover {
    background: #45a049;
    transform: scale(1.05);
}

.btn-editar {
    background: rgba(255, 193, 7, 0.8);
    color: #000;
    grid-column: 1 / -1;
    justify-self: center;
    margin-top: 10px;
}

.btn-editar:hover {
    background: rgba(255, 193, 7, 1);
    transform: scale(1.05);
}

/* ===== ACCIONES DE GRUPOS ===== */
.acciones-grupos {
    text-align: center;
    margin-top: 30px;
}

/* ===== ESTADÍSTICAS FINALES ===== */
.estadisticas-grupos-final {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 40px;
    padding: 25px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

/* ===== ANIMACIONES ===== */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.grupo, .estadistica-item, .jornada {
    animation: fadeInUp 0.6s ease forwards;
}

.grupo-a { animation-delay: 0.1s; }
.grupo-b { animation-delay: 0.2s; }
.estadistica-item:nth-child(1) { animation-delay: 0.3s; }
.estadistica-item:nth-child(2) { animation-delay: 0.4s; }
.estadistica-item:nth-child(3) { animation-delay: 0.5s; }
.estadistica-item:nth-child(4) { animation-delay: 0.6s; }

/* ===== RESPONSIVE ===== */
@media (max-width: 1024px) {
    .grid-grupos {
        grid-template-columns: 1fr;
    }
    
    .tabla-posiciones {
        font-size: 0.8rem;
    }
    
    .tabla-posiciones th, .tabla-posiciones td {
        padding: 8px 5px;
    }
}

@media (max-width: 768px) {
    .grupos-container {
        padding: 20px;
    }
    
    .header-grupos h2 {
        font-size: 2rem;
    }
    
    .estadisticas-grupos {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .partido {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .equipo-local, .equipo-visitante {
        text-align: center;
    }
    
    .form-resultado {
        grid-template-columns: 1fr;
    }
    
    .form-goles {
        order: 1;
    }
    
    .form-tarjetas {
        order: 2;
    }
    
    .form-jugadores {
        order: 3;
    }
    
    .btn-guardar, .btn-editar {
        order: 4;
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
    
    .equipo-sorteado {
        font-size: 2rem;
        min-width: 300px;
        padding: 20px;
    }
    
    .grupo-asignado {
        font-size: 1.5rem;
    }
    
    .jugadores-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .header-grupos h2 {
        font-size: 1.8rem;
    }
    
    .estado-sorteo h3 {
        font-size: 1.5rem;
    }
    
    .grupo-nombre {
        font-size: 1.5rem;
    }
    
    .estadisticas-grupos {
        grid-template-columns: 1fr;
    }
    
    .estadisticas-grupos-final {
        grid-template-columns: 1fr;
    }
    
    .jornada {
        padding: 15px;
    }
    
    .equipo-sorteado {
        font-size: 1.5rem;
        min-width: 250px;
        padding: 15px;
    }
    
    .grupo-asignado {
        font-size: 1.2rem;
    }
    
    .contador-sorteo {
        font-size: 1.1rem;
    }
}

.partido.jugado .resultado {
    background: rgba(76, 175, 80, 0.2);
    color: var(--success-color);
}

/* Estilos para equipos en animación */
.equipo-lista {
    list-style: none;
    padding: 0;
}

.equipo-lista li {
    padding: 12px;
    margin: 8px 0;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: var(--transition);
    opacity: 0;
    transform: translateX(-30px);
    animation: slideIn 0.6s ease forwards;
    position: relative;
    overflow: hidden;
}

.equipo-lista li::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    transition: left 0.5s ease;
}

.equipo-lista li:hover::before {
    left: 100%;
}

@keyframes slideIn {
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.equipo-lista li:nth-child(1) { animation-delay: 0.1s; }
.equipo-lista li:nth-child(2) { animation-delay: 0.2s; }
.equipo-lista li:nth-child(3) { animation-delay: 0.3s; }
.equipo-lista li:nth-child(4) { animation-delay: 0.4s; }

/* Efectos especiales */
.confetti {
    position: fixed;
    width: 10px;
    height: 10px;
    background: var(--highlight-color);
    opacity: 0;
    pointer-events: none;
    z-index: 1000;
}

@keyframes confettiFall {
    0% {
        transform: translateY(-100px) rotate(0deg);
        opacity: 1;
    }
    100% {
        transform: translateY(100vh) rotate(360deg);
        opacity: 0;
    }
}
</style>
</head>
<body>
    <div class="container">
        <div class="grupos-container">
            <div class="header-grupos">
                <h2>🏆 Fase de Grupos</h2>
                <p>8 equipos, 2 grupos, 1 campeón</p>
            </div>
            
            <?php if (!isset($_SESSION['grupos_sorteados'])): ?>
                <!-- Estado previo al sorteo -->
                <div class="estado-sorteo">
                    <h3>🎯 Grupos por Sorteo</h3>
                    <p>Los 8 equipos se dividirán en 2 grupos de 4 equipos cada uno</p>
                    <div class="estadisticas-grupos">
                        <div class="estadistica-item">
                            <div class="estadistica-valor">8</div>
                            <div class="estadistica-label">Equipos</div>
                        </div>
                        <div class="estadistica-item">
                            <div class="estadistica-valor">2</div>
                            <div class="estadistica-label">Grupos</div>
                        </div>
                        <div class="estadistica-item">
                            <div class="estadistica-valor">4</div>
                            <div class="estadistica-label">Equipos por Grupo</div>
                        </div>
                        <div class="estadistica-item">
                            <div class="estadistica-valor">12</div>
                            <div class="estadistica-label">Partidos en Fase de Grupos</div>
                        </div>
                    </div>
                    
                    <form method="POST" style="margin-top: 30px;">
                        <button type="submit" name="sorteo_grupos" class="button button-success" style="font-size: 1.3rem; padding: 15px 40px;">
                            🎲 Realizar Sorteo de Grupos
                        </button>
                    </form>
                </div>
                
            <?php else: ?>
                <!-- Grupos ya sorteados -->
                <?php 
                $grupo_a = $_SESSION['grupos_sorteados']['grupo_a'];
                $grupo_b = $_SESSION['grupos_sorteados']['grupo_b'];
                ?>
                
                <?php if ($mostrar_animacion): ?>
                    <!-- Animación de sorteo en progreso -->
                    <div class="animacion-sorteo-dinamica" id="animacion-sorteo">
                        <h3 style="color: white; margin-bottom: 20px; font-size: 2rem;">🎪 SORTEO EN DIRECTO 🎪</h3>
                        <p style="color: rgba(255,255,255,0.9); margin: 0 0 30px 0; font-size: 1.2rem;">Asignando equipos a los grupos...</p>
                        
                        <div id="equipo-actual" class="equipo-sorteado"></div>
                        <div id="grupo-asignado" class="grupo-asignado"></div>
                        <div id="contador-sorteo" class="contador-sorteo"></div>
                    </div>
                    
                    <div style="display: none;">
                <?php else: ?>
                    <!-- Sorteo completado -->
                    <div class="animacion-sorteo">
                        <h3 style="color: white; margin-bottom: 15px; font-size: 2.5rem;">✨ ¡GRUPOS COMPLETADOS! ✨</h3>
                        <p style="color: rgba(255,255,255,0.9); margin: 0; font-size: 1.3rem;">La fase de grupos está lista para comenzar</p>
                    </div>
                <?php endif; ?>
                
                <!-- CONTENIDO COMPLETO DE GRUPOS (siempre visible excepto durante animación) -->
                <?php if (!$mostrar_animacion): ?>
                <div class="grid-grupos">
                    <!-- Grupo A -->
                    <div class="grupo grupo-a">
                        <div class="grupo-header">
                            <h3 class="grupo-nombre">🏆 Grupo A</h3>
                            <div class="grupo-badge">4 Equipos</div>
                        </div>
                        
                        <!-- Lista de equipos Grupo A -->
                        <h4 style="color: #4A90E2; margin: 25px 0 15px 0; text-align: center;">👥 Equipos del Grupo</h4>
                        <ul class="equipo-lista">
                            <?php foreach ($grupo_a['equipos'] as $equipo): ?>
                                <li><?php echo $equipo; ?></li>
                            <?php endforeach; ?>
                        </ul>
                        
                        <!-- Tabla de posiciones Grupo A -->
                        <h4 style="color: var(--primary); margin: 25px 0 15px 0; text-align: center;">📊 Tabla de Posiciones</h4>
                        <table class="tabla-posiciones">
                            <thead>
                                <tr>
                                    <th>Pos</th>
                                    <th>Equipo</th>
                                    <th>PJ</th>
                                    <th>PG</th>
                                    <th>PE</th>
                                    <th>PP</th>
                                    <th>GF</th>
                                    <th>GC</th>
                                    <th>DG</th>
                                    <th>TR</th>
                                    <th>TA</th>
                                    <th>Pts</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $posicion = 1;
                                foreach ($tabla_a as $equipo => $datos): 
                                    $clase = $posicion <= 2 ? 'posicion-destacada' : '';
                                ?>
                                    <tr class="<?php echo $clase; ?>">
                                        <td><?php echo $posicion; ?></td>
                                        <td class="equipo-tabla"><?php echo $equipo; ?></td>
                                        <td><?php echo $datos['pj']; ?></td>
                                        <td><?php echo $datos['pg']; ?></td>
                                        <td><?php echo $datos['pe']; ?></td>
                                        <td><?php echo $datos['pp']; ?></td>
                                        <td><?php echo $datos['gf']; ?></td>
                                        <td><?php echo $datos['gc']; ?></td>
                                        <td><?php echo $datos['dg']; ?></td>
                                        <td><?php echo $datos['tr']; ?></td>
                                        <td><?php echo $datos['ta']; ?></td>
                                        <td><strong><?php echo $datos['pts']; ?></strong></td>
                                    </tr>
                                <?php 
                                $posicion++;
                                endforeach; 
                                ?>
                            </tbody>
                        </table>
                        
                        <div class="calendario-grupo">
                            <div class="calendario-titulo">📅 Calendario - Grupo A</div>
                            <?php foreach ($grupo_a['calendario'] as $jornada_index => $partidos): ?>
                                <div class="jornada">
                                    <div class="jornada-header">
                                        <span class="jornada-numero">Jornada <?php echo $jornada_index + 1; ?></span>
                                        <span class="jornada-fecha">Fecha <?php echo $jornada_index + 1; ?></span>
                                    </div>
                                    <div class="partidos-jornada">
                                        <?php foreach ($partidos as $partido_index => $partido): ?>
                                            <div class="partido <?php echo $partido['jugado'] ? 'jugado' : ''; ?>">
                                                <div class="equipo-local"><?php echo $partido['local']; ?></div>
                                                
                                                <?php if ($partido['jugado']): ?>
                                                    <div class="resultado">
                                                        <?php echo $partido['goles_local']; ?> - <?php echo $partido['goles_visitante']; ?>
                                                    </div>
                                                    <div class="equipo-visitante"><?php echo $partido['visitante']; ?></div>
                                                    
                                                    <!-- Mostrar valoraciones si existen -->
                                                    <?php if ($partido['local_jugador1'] || $partido['local_jugador2'] || $partido['visitante_jugador1'] || $partido['visitante_jugador2']): ?>
                                                        <div class="valoraciones-info">
                                                            <div class="valoracion-equipo">
                                                                <strong><?php echo $partido['local']; ?>:</strong>
                                                                <?php if ($partido['local_jugador1']): ?>
                                                                    <div class="valoracion-jugador"><?php echo $partido['local_jugador1']; ?>: <?php echo $partido['local_valoracion1']; ?></div>
                                                                <?php endif; ?>
                                                                <?php if ($partido['local_jugador2']): ?>
                                                                    <div class="valoracion-jugador"><?php echo $partido['local_jugador2']; ?>: <?php echo $partido['local_valoracion2']; ?></div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="valoracion-equipo">
                                                                <strong><?php echo $partido['visitante']; ?>:</strong>
                                                                <?php if ($partido['visitante_jugador1']): ?>
                                                                    <div class="valoracion-jugador"><?php echo $partido['visitante_jugador1']; ?>: <?php echo $partido['visitante_valoracion1']; ?></div>
                                                                <?php endif; ?>
                                                                <?php if ($partido['visitante_jugador2']): ?>
                                                                    <div class="valoracion-jugador"><?php echo $partido['visitante_jugador2']; ?>: <?php echo $partido['visitante_valoracion2']; ?></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($partido['tarjetas_rojas_local'] > 0 || $partido['tarjetas_rojas_visitante'] > 0): ?>
                                                        <div class="tarjetas-info">
                                                            🟥 Local: <?php echo $partido['tarjetas_rojas_local']; ?> | Visitante: <?php echo $partido['tarjetas_rojas_visitante']; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if ($partido['tarjetas_amarillas_local'] > 0 || $partido['tarjetas_amarillas_visitante'] > 0): ?>
                                                        <div class="amarillas-info">
                                                            🟨 Local: <?php echo $partido['tarjetas_amarillas_local']; ?> | Visitante: <?php echo $partido['tarjetas_amarillas_visitante']; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <!-- BOTÓN EDITAR RESULTADO -->
                                                    <button type="button" class="btn-editar" onclick="mostrarFormularioEdicion('grupo_a', <?php echo $jornada_index; ?>, <?php echo $partido_index; ?>)">
                                                        ✏️ Editar Resultado
                                                    </button>
                                                    
                                                    <!-- FORMULARIO DE EDICIÓN (OCULTO INICIALMENTE) -->
                                                    <form method="POST" class="form-resultado" id="form-editar-grupo_a-<?php echo $jornada_index; ?>-<?php echo $partido_index; ?>" style="display: none;">
                                                        <div class="form-goles">
                                                            <input type="number" name="goles_local" class="input-resultado" min="0" max="20" 
                                                                   value="<?php echo $partido['goles_local']; ?>" required>
                                                            <span style="font-weight: bold; font-size: 1.1rem;">-</span>
                                                            <input type="number" name="goles_visitante" class="input-resultado" min="0" max="20" 
                                                                   value="<?php echo $partido['goles_visitante']; ?>" required>
                                                        </div>
                                                        
                                                        <div class="form-tarjetas">
                                                            <div class="tarjeta-grupo">
                                                                <span style="color: #e74c3c;">🟥 L:</span>
                                                                <input type="number" name="tarjetas_rojas_local" class="input-resultado" min="0" max="5" 
                                                                       value="<?php echo $partido['tarjetas_rojas_local']; ?>">
                                                            </div>
                                                            <div class="tarjeta-grupo">
                                                                <span style="color: #e74c3c;">🟥 V:</span>
                                                                <input type="number" name="tarjetas_rojas_visitante" class="input-resultado" min="0" max="5" 
                                                                       value="<?php echo $partido['tarjetas_rojas_visitante']; ?>">
                                                            </div>
                                                            <div class="tarjeta-grupo">
                                                                <span style="color: #f39c12;">🟨 L:</span>
                                                                <input type="number" name="tarjetas_amarillas_local" class="input-resultado" min="0" max="10" 
                                                                       value="<?php echo $partido['tarjetas_amarillas_local']; ?>">
                                                            </div>
                                                            <div class="tarjeta-grupo">
                                                                <span style="color: #f39c12;">🟨 V:</span>
                                                                <input type="number" name="tarjetas_amarillas_visitante" class="input-resultado" min="0" max="10" 
                                                                       value="<?php echo $partido['tarjetas_amarillas_visitante']; ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Formulario para jugadores y valoraciones -->
                                                        <div class="form-jugadores">
                                                            <div class="jugadores-equipo">
                                                                <h4><?php echo $partido['local']; ?> - Jugadores Destacados</h4>
                                                                <div class="jugadores-grid">
                                                                    <div class="jugador-input">
                                                                        <label>Jugador 1:</label>
                                                                        <select name="local_jugador1">
                                                                            <option value="">Seleccionar jugador</option>
                                                                            <?php 
                                                                            $jugadores_local = obtenerJugadoresEquipo($partido['local'], $plantillas_equipos);
                                                                            foreach ($jugadores_local as $jugador): ?>
                                                                                <option value="<?php echo $jugador; ?>" <?php echo ($partido['local_jugador1'] == $jugador) ? 'selected' : ''; ?>>
                                                                                    <?php echo $jugador; ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <input type="number" name="local_valoracion1" class="input-resultado" min="1" max="10" step="0.01" placeholder="Valoración" 
                                                                               value="<?php echo $partido['local_valoracion1']; ?>">
                                                                    </div>
                                                                    <div class="jugador-input">
                                                                        <label>Jugador 2:</label>
                                                                        <select name="local_jugador2">
                                                                            <option value="">Seleccionar jugador</option>
                                                                            <?php foreach ($jugadores_local as $jugador): ?>
                                                                                <option value="<?php echo $jugador; ?>" <?php echo ($partido['local_jugador2'] == $jugador) ? 'selected' : ''; ?>>
                                                                                    <?php echo $jugador; ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <input type="number" name="local_valoracion2" class="input-resultado" min="1" max="10" step="0.01" placeholder="Valoración" 
                                                                               value="<?php echo $partido['local_valoracion2']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="jugadores-equipo">
                                                                <h4><?php echo $partido['visitante']; ?> - Jugadores Destacados</h4>
                                                                <div class="jugadores-grid">
                                                                    <div class="jugador-input">
                                                                        <label>Jugador 1:</label>
                                                                        <select name="visitante_jugador1">
                                                                            <option value="">Seleccionar jugador</option>
                                                                            <?php 
                                                                            $jugadores_visitante = obtenerJugadoresEquipo($partido['visitante'], $plantillas_equipos);
                                                                            foreach ($jugadores_visitante as $jugador): ?>
                                                                                <option value="<?php echo $jugador; ?>" <?php echo ($partido['visitante_jugador1'] == $jugador) ? 'selected' : ''; ?>>
                                                                                    <?php echo $jugador; ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <input type="number" name="visitante_valoracion1" class="input-resultado" min="1" max="10" step="0.01" placeholder="Valoración" 
                                                                               value="<?php echo $partido['visitante_valoracion1']; ?>">
                                                                    </div>
                                                                    <div class="jugador-input">
                                                                        <label>Jugador 2:</label>
                                                                        <select name="visitante_jugador2">
                                                                            <option value="">Seleccionar jugador</option>
                                                                            <?php foreach ($jugadores_visitante as $jugador): ?>
                                                                                <option value="<?php echo $jugador; ?>" <?php echo ($partido['visitante_jugador2'] == $jugador) ? 'selected' : ''; ?>>
                                                                                    <?php echo $jugador; ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <input type="number" name="visitante_valoracion2" class="input-resultado" min="1" max="10" step="0.01" placeholder="Valoración" 
                                                                               value="<?php echo $partido['visitante_valoracion2']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <input type="hidden" name="grupo" value="grupo_a">
                                                        <input type="hidden" name="jornada" value="<?php echo $jornada_index; ?>">
                                                        <input type="hidden" name="partido" value="<?php echo $partido_index; ?>">
                                                        <button type="submit" name="editar_resultado" class="btn-guardar">
                                                            ✅ Actualizar Resultado
                                                        </button>
                                                        <button type="button" class="btn-editar" onclick="ocultarFormularioEdicion('grupo_a', <?php echo $jornada_index; ?>, <?php echo $partido_index; ?>)">
                                                            ❌ Cancelar
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <div class="vs">VS</div>
                                                    <div class="equipo-visitante"><?php echo $partido['visitante']; ?></div>
                                                    
                                                    <!-- FORMULARIO ORIGINAL PARA PARTIDOS NO JUGADOS -->
                                                    <form method="POST" class="form-resultado">
                                                        <div class="form-goles">
                                                            <input type="number" name="goles_local" class="input-resultado" min="0" max="20" placeholder="0" required>
                                                            <span style="font-weight: bold; font-size: 1.1rem;">-</span>
                                                            <input type="number" name="goles_visitante" class="input-resultado" min="0" max="20" placeholder="0" required>
                                                        </div>
                                                        
                                                        <div class="form-tarjetas">
                                                            <div class="tarjeta-grupo">
                                                                <span style="color: #e74c3c;">🟥 L:</span>
                                                                <input type="number" name="tarjetas_rojas_local" class="input-resultado" min="0" max="5" value="0">
                                                            </div>
                                                            <div class="tarjeta-grupo">
                                                                <span style="color: #e74c3c;">🟥 V:</span>
                                                                <input type="number" name="tarjetas_rojas_visitante" class="input-resultado" min="0" max="5" value="0">
                                                            </div>
                                                            <div class="tarjeta-grupo">
                                                                <span style="color: #f39c12;">🟨 L:</span>
                                                                <input type="number" name="tarjetas_amarillas_local" class="input-resultado" min="0" max="10" value="0">
                                                            </div>
                                                            <div class="tarjeta-grupo">
                                                                <span style="color: #f39c12;">🟨 V:</span>
                                                                <input type="number" name="tarjetas_amarillas_visitante" class="input-resultado" min="0" max="10" value="0">
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Formulario para jugadores y valoraciones -->
                                                        <div class="form-jugadores">
                                                            <div class="jugadores-equipo">
                                                                <h4><?php echo $partido['local']; ?> - Jugadores Destacados</h4>
                                                                <div class="jugadores-grid">
                                                                    <div class="jugador-input">
                                                                        <label>Jugador 1:</label>
                                                                        <select name="local_jugador1">
                                                                            <option value="">Seleccionar jugador</option>
                                                                            <?php 
                                                                            $jugadores_local = obtenerJugadoresEquipo($partido['local'], $plantillas_equipos);
                                                                            foreach ($jugadores_local as $jugador): ?>
                                                                                <option value="<?php echo $jugador; ?>"><?php echo $jugador; ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <input type="number" name="local_valoracion1" class="input-resultado" min="1" max="10" step="0.01" placeholder="Valoración">
                                                                    </div>
                                                                    <div class="jugador-input">
                                                                        <label>Jugador 2:</label>
                                                                        <select name="local_jugador2">
                                                                            <option value="">Seleccionar jugador</option>
                                                                            <?php foreach ($jugadores_local as $jugador): ?>
                                                                                <option value="<?php echo $jugador; ?>"><?php echo $jugador; ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <input type="number" name="local_valoracion2" class="input-resultado" min="1" max="10" step="0.01" placeholder="Valoración">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="jugadores-equipo">
                                                                <h4><?php echo $partido['visitante']; ?> - Jugadores Destacados</h4>
                                                                <div class="jugadores-grid">
                                                                    <div class="jugador-input">
                                                                        <label>Jugador 1:</label>
                                                                        <select name="visitante_jugador1">
                                                                            <option value="">Seleccionar jugador</option>
                                                                            <?php 
                                                                            $jugadores_visitante = obtenerJugadoresEquipo($partido['visitante'], $plantillas_equipos);
                                                                            foreach ($jugadores_visitante as $jugador): ?>
                                                                                <option value="<?php echo $jugador; ?>"><?php echo $jugador; ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <input type="number" name="visitante_valoracion1" class="input-resultado" min="1" max="10" step="0.01" placeholder="Valoración">
                                                                    </div>
                                                                    <div class="jugador-input">
                                                                        <label>Jugador 2:</label>
                                                                        <select name="visitante_jugador2">
                                                                            <option value="">Seleccionar jugador</option>
                                                                            <?php foreach ($jugadores_visitante as $jugador): ?>
                                                                                <option value="<?php echo $jugador; ?>"><?php echo $jugador; ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <input type="number" name="visitante_valoracion2" class="input-resultado" min="1" max="10" step="0.01" placeholder="Valoración">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <input type="hidden" name="grupo" value="grupo_a">
                                                        <input type="hidden" name="jornada" value="<?php echo $jornada_index; ?>">
                                                        <input type="hidden" name="partido" value="<?php echo $partido_index; ?>">
                                                        <button type="submit" name="guardar_resultado" class="btn-guardar">
                                                            ✅ Guardar Resultado
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Grupo B -->
                    <div class="grupo grupo-b">
                        <div class="grupo-header">
                            <h3 class="grupo-nombre">🏆 Grupo B</h3>
                            <div class="grupo-badge">4 Equipos</div>
                        </div>
                        
                        <!-- Lista de equipos Grupo B -->
                        <h4 style="color: #E24A4A; margin: 25px 0 15px 0; text-align: center;">👥 Equipos del Grupo</h4>
                        <ul class="equipo-lista">
                            <?php foreach ($grupo_b['equipos'] as $equipo): ?>
                                <li><?php echo $equipo; ?></li>
                            <?php endforeach; ?>
                        </ul>
                        
                        <!-- Tabla de posiciones Grupo B -->
                        <h4 style="color: var(--primary); margin: 25px 0 15px 0; text-align: center;">📊 Tabla de Posiciones</h4>
                        <table class="tabla-posiciones">
                            <thead>
                                <tr>
                                    <th>Pos</th>
                                    <th>Equipo</th>
                                    <th>PJ</th>
                                    <th>PG</th>
                                    <th>PE</th>
                                    <th>PP</th>
                                    <th>GF</th>
                                    <th>GC</th>
                                    <th>DG</th>
                                    <th>TR</th>
                                    <th>TA</th>
                                    <th>Pts</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $posicion = 1;
                                foreach ($tabla_b as $equipo => $datos): 
                                    $clase = $posicion <= 2 ? 'posicion-destacada' : '';
                                ?>
                                    <tr class="<?php echo $clase; ?>">
                                        <td><?php echo $posicion; ?></td>
                                        <td class="equipo-tabla"><?php echo $equipo; ?></td>
                                        <td><?php echo $datos['pj']; ?></td>
                                        <td><?php echo $datos['pg']; ?></td>
                                        <td><?php echo $datos['pe']; ?></td>
                                        <td><?php echo $datos['pp']; ?></td>
                                        <td><?php echo $datos['gf']; ?></td>
                                        <td><?php echo $datos['gc']; ?></td>
                                        <td><?php echo $datos['dg']; ?></td>
                                        <td><?php echo $datos['tr']; ?></td>
                                        <td><?php echo $datos['ta']; ?></td>
                                        <td><strong><?php echo $datos['pts']; ?></strong></td>
                                    </tr>
                                <?php 
                                $posicion++;
                                endforeach; 
                                ?>
                            </tbody>
                        </table>
                        
                        <div class="calendario-grupo">
                            <div class="calendario-titulo">📅 Calendario - Grupo B</div>
                            <?php foreach ($grupo_b['calendario'] as $jornada_index => $partidos): ?>
                                <div class="jornada">
                                    <div class="jornada-header">
                                        <span class="jornada-numero">Jornada <?php echo $jornada_index + 1; ?></span>
                                        <span class="jornada-fecha">Fecha <?php echo $jornada_index + 1; ?></span>
                                    </div>
                                    <div class="partidos-jornada">
                                        <?php foreach ($partidos as $partido_index => $partido): ?>
                                            <div class="partido <?php echo $partido['jugado'] ? 'jugado' : ''; ?>">
                                                <div class="equipo-local"><?php echo $partido['local']; ?></div>
                                                
                                                <?php if ($partido['jugado']): ?>
                                                    <div class="resultado">
                                                        <?php echo $partido['goles_local']; ?> - <?php echo $partido['goles_visitante']; ?>
                                                    </div>
                                                    <div class="equipo-visitante"><?php echo $partido['visitante']; ?></div>
                                                    
                                                    <!-- Mostrar valoraciones si existen -->
                                                    <?php if ($partido['local_jugador1'] || $partido['local_jugador2'] || $partido['visitante_jugador1'] || $partido['visitante_jugador2']): ?>
                                                        <div class="valoraciones-info">
                                                            <div class="valoracion-equipo">
                                                                <strong><?php echo $partido['local']; ?>:</strong>
                                                                <?php if ($partido['local_jugador1']): ?>
                                                                    <div class="valoracion-jugador"><?php echo $partido['local_jugador1']; ?>: <?php echo $partido['local_valoracion1']; ?></div>
                                                                <?php endif; ?>
                                                                <?php if ($partido['local_jugador2']): ?>
                                                                    <div class="valoracion-jugador"><?php echo $partido['local_jugador2']; ?>: <?php echo $partido['local_valoracion2']; ?></div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="valoracion-equipo">
                                                                <strong><?php echo $partido['visitante']; ?>:</strong>
                                                                <?php if ($partido['visitante_jugador1']): ?>
                                                                    <div class="valoracion-jugador"><?php echo $partido['visitante_jugador1']; ?>: <?php echo $partido['visitante_valoracion1']; ?></div>
                                                                <?php endif; ?>
                                                                <?php if ($partido['visitante_jugador2']): ?>
                                                                    <div class="valoracion-jugador"><?php echo $partido['visitante_jugador2']; ?>: <?php echo $partido['visitante_valoracion2']; ?></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($partido['tarjetas_rojas_local'] > 0 || $partido['tarjetas_rojas_visitante'] > 0): ?>
                                                        <div class="tarjetas-info">
                                                            🟥 Local: <?php echo $partido['tarjetas_rojas_local']; ?> | Visitante: <?php echo $partido['tarjetas_rojas_visitante']; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if ($partido['tarjetas_amarillas_local'] > 0 || $partido['tarjetas_amarillas_visitante'] > 0): ?>
                                                        <div class="amarillas-info">
                                                            🟨 Local: <?php echo $partido['tarjetas_amarillas_local']; ?> | Visitante: <?php echo $partido['tarjetas_amarillas_visitante']; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    
                                                    <!-- BOTÓN EDITAR RESULTADO -->
                                                    <button type="button" class="btn-editar" onclick="mostrarFormularioEdicion('grupo_b', <?php echo $jornada_index; ?>, <?php echo $partido_index; ?>)">
                                                        ✏️ Editar Resultado
                                                    </button>
                                                    
                                                    <!-- FORMULARIO DE EDICIÓN (OCULTO INICIALMENTE) -->
                                                    <form method="POST" class="form-resultado" id="form-editar-grupo_b-<?php echo $jornada_index; ?>-<?php echo $partido_index; ?>" style="display: none;">
                                                        <div class="form-goles">
                                                            <input type="number" name="goles_local" class="input-resultado" min="0" max="20" 
                                                                   value="<?php echo $partido['goles_local']; ?>" required>
                                                            <span style="font-weight: bold; font-size: 1.1rem;">-</span>
                                                            <input type="number" name="goles_visitante" class="input-resultado" min="0" max="20" 
                                                                   value="<?php echo $partido['goles_visitante']; ?>" required>
                                                        </div>
                                                        
                                                        <div class="form-tarjetas">
                                                            <div class="tarjeta-grupo">
                                                                <span style="color: #e74c3c;">🟥 L:</span>
                                                                <input type="number" name="tarjetas_rojas_local" class="input-resultado" min="0" max="5" 
                                                                       value="<?php echo $partido['tarjetas_rojas_local']; ?>">
                                                            </div>
                                                            <div class="tarjeta-grupo">
                                                                <span style="color: #e74c3c;">🟥 V:</span>
                                                                <input type="number" name="tarjetas_rojas_visitante" class="input-resultado" min="0" max="5" 
                                                                       value="<?php echo $partido['tarjetas_rojas_visitante']; ?>">
                                                            </div>
                                                            <div class="tarjeta-grupo">
                                                                <span style="color: #f39c12;">🟨 L:</span>
                                                                <input type="number" name="tarjetas_amarillas_local" class="input-resultado" min="0" max="10" 
                                                                       value="<?php echo $partido['tarjetas_amarillas_local']; ?>">
                                                            </div>
                                                            <div class="tarjeta-grupo">
                                                                <span style="color: #f39c12;">🟨 V:</span>
                                                                <input type="number" name="tarjetas_amarillas_visitante" class="input-resultado" min="0" max="10" 
                                                                       value="<?php echo $partido['tarjetas_amarillas_visitante']; ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Formulario para jugadores y valoraciones -->
                                                        <div class="form-jugadores">
                                                            <div class="jugadores-equipo">
                                                                <h4><?php echo $partido['local']; ?> - Jugadores Destacados</h4>
                                                                <div class="jugadores-grid">
                                                                    <div class="jugador-input">
                                                                        <label>Jugador 1:</label>
                                                                        <select name="local_jugador1">
                                                                            <option value="">Seleccionar jugador</option>
                                                                            <?php 
                                                                            $jugadores_local = obtenerJugadoresEquipo($partido['local'], $plantillas_equipos);
                                                                            foreach ($jugadores_local as $jugador): ?>
                                                                                <option value="<?php echo $jugador; ?>" <?php echo ($partido['local_jugador1'] == $jugador) ? 'selected' : ''; ?>>
                                                                                    <?php echo $jugador; ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <input type="number" name="local_valoracion1" class="input-resultado" min="1" max="10" step="0.01" placeholder="Valoración" 
                                                                               value="<?php echo $partido['local_valoracion1']; ?>">
                                                                    </div>
                                                                    <div class="jugador-input">
                                                                        <label>Jugador 2:</label>
                                                                        <select name="local_jugador2">
                                                                            <option value="">Seleccionar jugador</option>
                                                                            <?php foreach ($jugadores_local as $jugador): ?>
                                                                                <option value="<?php echo $jugador; ?>" <?php echo ($partido['local_jugador2'] == $jugador) ? 'selected' : ''; ?>>
                                                                                    <?php echo $jugador; ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <input type="number" name="local_valoracion2" class="input-resultado" min="1" max="10" step="0.01" placeholder="Valoración" 
                                                                               value="<?php echo $partido['local_valoracion2']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="jugadores-equipo">
                                                                <h4><?php echo $partido['visitante']; ?> - Jugadores Destacados</h4>
                                                                <div class="jugadores-grid">
                                                                    <div class="jugador-input">
                                                                        <label>Jugador 1:</label>
                                                                        <select name="visitante_jugador1">
                                                                            <option value="">Seleccionar jugador</option>
                                                                            <?php 
                                                                            $jugadores_visitante = obtenerJugadoresEquipo($partido['visitante'], $plantillas_equipos);
                                                                            foreach ($jugadores_visitante as $jugador): ?>
                                                                                <option value="<?php echo $jugador; ?>" <?php echo ($partido['visitante_jugador1'] == $jugador) ? 'selected' : ''; ?>>
                                                                                    <?php echo $jugador; ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <input type="number" name="visitante_valoracion1" class="input-resultado" min="1" max="10" step="0.01" placeholder="Valoración" 
                                                                               value="<?php echo $partido['visitante_valoracion1']; ?>">
                                                                    </div>
                                                                    <div class="jugador-input">
                                                                        <label>Jugador 2:</label>
                                                                        <select name="visitante_jugador2">
                                                                            <option value="">Seleccionar jugador</option>
                                                                            <?php foreach ($jugadores_visitante as $jugador): ?>
                                                                                <option value="<?php echo $jugador; ?>" <?php echo ($partido['visitante_jugador2'] == $jugador) ? 'selected' : ''; ?>>
                                                                                    <?php echo $jugador; ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <input type="number" name="visitante_valoracion2" class="input-resultado" min="1" max="10" step="0.01" placeholder="Valoración" 
                                                                               value="<?php echo $partido['visitante_valoracion2']; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <input type="hidden" name="grupo" value="grupo_b">
                                                        <input type="hidden" name="jornada" value="<?php echo $jornada_index; ?>">
                                                        <input type="hidden" name="partido" value="<?php echo $partido_index; ?>">
                                                        <button type="submit" name="editar_resultado" class="btn-guardar">
                                                            ✅ Actualizar Resultado
                                                        </button>
                                                        <button type="button" class="btn-editar" onclick="ocultarFormularioEdicion('grupo_b', <?php echo $jornada_index; ?>, <?php echo $partido_index; ?>)">
                                                            ❌ Cancelar
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <div class="vs">VS</div>
                                                    <div class="equipo-visitante"><?php echo $partido['visitante']; ?></div>
                                                    
                                                    <!-- FORMULARIO ORIGINAL PARA PARTIDOS NO JUGADOS -->
                                                    <form method="POST" class="form-resultado">
                                                        <div class="form-goles">
                                                            <input type="number" name="goles_local" class="input-resultado" min="0" max="20" placeholder="0" required>
                                                            <span style="font-weight: bold; font-size: 1.1rem;">-</span>
                                                            <input type="number" name="goles_visitante" class="input-resultado" min="0" max="20" placeholder="0" required>
                                                        </div>
                                                        
                                                        <div class="form-tarjetas">
                                                            <div class="tarjeta-grupo">
                                                                <span style="color: #e74c3c;">🟥 L:</span>
                                                                <input type="number" name="tarjetas_rojas_local" class="input-resultado" min="0" max="5" value="0">
                                                            </div>
                                                            <div class="tarjeta-grupo">
                                                                <span style="color: #e74c3c;">🟥 V:</span>
                                                                <input type="number" name="tarjetas_rojas_visitante" class="input-resultado" min="0" max="5" value="0">
                                                            </div>
                                                            <div class="tarjeta-grupo">
                                                                <span style="color: #f39c12;">🟨 L:</span>
                                                                <input type="number" name="tarjetas_amarillas_local" class="input-resultado" min="0" max="10" value="0">
                                                            </div>
                                                            <div class="tarjeta-grupo">
                                                                <span style="color: #f39c12;">🟨 V:</span>
                                                                <input type="number" name="tarjetas_amarillas_visitante" class="input-resultado" min="0" max="10" value="0">
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Formulario para jugadores y valoraciones -->
                                                        <div class="form-jugadores">
                                                            <div class="jugadores-equipo">
                                                                <h4><?php echo $partido['local']; ?> - Jugadores Destacados</h4>
                                                                <div class="jugadores-grid">
                                                                    <div class="jugador-input">
                                                                        <label>Jugador 1:</label>
                                                                        <select name="local_jugador1">
                                                                            <option value="">Seleccionar jugador</option>
                                                                            <?php 
                                                                            $jugadores_local = obtenerJugadoresEquipo($partido['local'], $plantillas_equipos);
                                                                            foreach ($jugadores_local as $jugador): ?>
                                                                                <option value="<?php echo $jugador; ?>"><?php echo $jugador; ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <input type="number" name="local_valoracion1" class="input-resultado" min="1" max="10" step="0.01" placeholder="Valoración">
                                                                    </div>
                                                                    <div class="jugador-input">
                                                                        <label>Jugador 2:</label>
                                                                        <select name="local_jugador2">
                                                                            <option value="">Seleccionar jugador</option>
                                                                            <?php foreach ($jugadores_local as $jugador): ?>
                                                                                <option value="<?php echo $jugador; ?>"><?php echo $jugador; ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <input type="number" name="local_valoracion2" class="input-resultado" min="1" max="10" step="0.01" placeholder="Valoración">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="jugadores-equipo">
                                                                <h4><?php echo $partido['visitante']; ?> - Jugadores Destacados</h4>
                                                                <div class="jugadores-grid">
                                                                    <div class="jugador-input">
                                                                        <label>Jugador 1:</label>
                                                                        <select name="visitante_jugador1">
                                                                            <option value="">Seleccionar jugador</option>
                                                                            <?php 
                                                                            $jugadores_visitante = obtenerJugadoresEquipo($partido['visitante'], $plantillas_equipos);
                                                                            foreach ($jugadores_visitante as $jugador): ?>
                                                                                <option value="<?php echo $jugador; ?>"><?php echo $jugador; ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <input type="number" name="visitante_valoracion1" class="input-resultado" min="1" max="10" step="0.01" placeholder="Valoración">
                                                                    </div>
                                                                    <div class="jugador-input">
                                                                        <label>Jugador 2:</label>
                                                                        <select name="visitante_jugador2">
                                                                            <option value="">Seleccionar jugador</option>
                                                                            <?php foreach ($jugadores_visitante as $jugador): ?>
                                                                                <option value="<?php echo $jugador; ?>"><?php echo $jugador; ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <input type="number" name="visitante_valoracion2" class="input-resultado" min="1" max="10" step="0.01" placeholder="Valoración">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <input type="hidden" name="grupo" value="grupo_b">
                                                        <input type="hidden" name="jornada" value="<?php echo $jornada_index; ?>">
                                                        <input type="hidden" name="partido" value="<?php echo $partido_index; ?>">
                                                        <button type="submit" name="guardar_resultado" class="btn-guardar">
                                                            ✅ Guardar Resultado
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <div class="estadisticas-grupos">
                    <div class="estadistica-item">
                        <div class="estadistica-valor">12</div>
                        <div class="estadistica-label">Partidos Totales</div>
                    </div>
                    <div class="estadistica-item">
                        <div class="estadistica-valor">6</div>
                        <div class="estadistica-label">Partidos por Grupo</div>
                    </div>
                    <div class="estadistica-item">
                        <div class="estadistica-valor">3</div>
                        <div class="estadistica-label">Jornadas por Grupo</div>
                    </div>
                    <div class="estadistica-item">
                        <div class="estadistica-valor">4</div>
                        <div class="estadistica-label">Clasifican por Grupo</div>
                    </div>
                </div>
                
                <div class="acciones-grupos">
                    <form method="POST">
                        <button type="submit" name="reiniciar_grupos" class="button button-danger" 
                                onclick="return confirm('¿Estás seguro de que quieres reiniciar los grupos? Se perderán todos los resultados.')">
                            🔄 Realizar Nuevo Sorteo
                        </button>
                    </form>
                </div>
                <?php endif; ?>
                
                <?php if ($mostrar_animacion): ?>
                    </div> <!-- cierre del div oculto durante animación -->
                <?php endif; ?>
            <?php endif; ?>
        </div>
        
        <div class="navegacion-inferior">
            <a href="index.php" class="button">🏠 Volver al Inicio</a>
            <?php if (isset($_SESSION['grupos_sorteados']) && !$mostrar_animacion && $todos_partidos_jugados): ?>
                <a href="eliminatorias.php" class="button button-success">⚽ Comenzar Fase de Eliminatoria</a>
            <?php endif; ?>
        </div>
    </div>

    <script>
    // Funciones para mostrar/ocultar formularios de edición
    function mostrarFormularioEdicion(grupo, jornada, partido) {
        const formId = `form-editar-${grupo}-${jornada}-${partido}`;
        const form = document.getElementById(formId);
        if (form) {
            form.style.display = 'grid';
        }
    }
    
    function ocultarFormularioEdicion(grupo, jornada, partido) {
        const formId = `form-editar-${grupo}-${jornada}-${partido}`;
        const form = document.getElementById(formId);
        if (form) {
            form.style.display = 'none';
        }
    }
    
    // Animación de sorteo de equipos
    <?php if ($mostrar_animacion): ?>
        const equiposMezclados = <?php echo json_encode($_SESSION['animacion_sorteo']['equipos_mezclados']); ?>;
        const totalEquipos = equiposMezclados.length;
        let equipoIndex = 0;
        const intervalo = 1; // 10 segundos entre equipos
        
        // Función para crear efecto de confeti
        function crearConfeti() {
            const colors = ['#e94560', '#4A90E2', '#E24A4A', '#4CAF50', '#FFD700', '#C0C0C0'];
            const animacionContainer = document.getElementById('animacion-sorteo');
            
            for (let i = 0; i < 30; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.animation = `confettiFall ${Math.random() * 3 + 2}s linear forwards`;
                confetti.style.animationDelay = Math.random() * 1 + 's';
                confetti.style.width = (Math.random() * 10 + 5) + 'px';
                confetti.style.height = (Math.random() * 10 + 5) + 'px';
                animacionContainer.appendChild(confetti);
                
                // Remover después de la animación
                setTimeout(() => {
                    confetti.remove();
                }, 5000);
            }
        }

        function mostrarEquipo() {
            if (equipoIndex < totalEquipos) {
                const item = equiposMezclados[equipoIndex];
                const equipo = item.equipo;
                const grupo = item.grupo;
                
                // Aplicar estilos según el grupo
                const grupoColor = grupo === 'A' ? 'grupo-a-color' : 'grupo-b-color';
                
                // Mostrar equipo con animación
                const equipoActual = document.getElementById('equipo-actual');
                const grupoAsignado = document.getElementById('grupo-asignado');
                const contadorSorteo = document.getElementById('contador-sorteo');
                
                // Reset animaciones
                equipoActual.style.animation = 'none';
                grupoAsignado.style.animation = 'none';
                
                setTimeout(() => {
                    equipoActual.textContent = equipo;
                    equipoActual.className = `equipo-sorteado ${grupoColor}`;
                    equipoActual.style.animation = 'teamReveal 1s ease-out';
                    
                    setTimeout(() => {
                        grupoAsignado.textContent = `🎯 ASIGNADO AL GRUPO ${grupo}`;
                        grupoAsignado.className = `grupo-asignado ${grupoColor}`;
                        grupoAsignado.style.animation = 'groupReveal 0.8s ease-out';
                        // Efecto de confeti para equipos especiales
                        if (equipoIndex === 0 || equipoIndex === totalEquipos) {
                            crearConfeti();
                        }
                    }, 500);
                    
                    contadorSorteo.textContent = `Equipo ${equipoIndex} de ${totalEquipos}`;                    
                }, 50);
                
                equipoIndex++;
                
                // Programar siguiente equipo
                if (equipoIndex < totalEquipos) {
                    setTimeout(mostrarEquipo, intervalo);
                } else {
                    // Último equipo - preparar final
                    setTimeout(() => {
                        // Recargar para mostrar contenido completo
                        window.location.href = 'grupos.php?completar_animacion=1';
                    }, intervalo);
                }
            }
        }
        
        // Iniciar animación después de un breve delay
        setTimeout(mostrarEquipo, 1000);
    <?php endif; ?>
    </script>
</body>
</html>