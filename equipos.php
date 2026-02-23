<?php

require_once 'includes/config.php';

// Datos de plantillas de equipos (ACTUALIZADO CON LOS 12 EQUIPOS SOLICITADOS)
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
    'Bayern de Munich' => [
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
    'Atletico de Madrid' => [
        'Porteros' => ['Oblak', 'Musso', 'Esquivel'],
        'Defensas' => ['Hancko', 'Giménez', 'Le Normand', 'Llorente', 'Lenglet', 'Ruggeri', 'Molina', 'Galán', 'Pubill', 'Kostis'],
        'Medios' => ['Koke', 'Barrios', 'Baena', 'Simeone', 'Cardoso', 'Gonzalez', 'Almada', 'Gallagher'],
        'Delanteros' => ['Alvarez', 'Sørloth', 'Griezmann', 'Raspadori', 'Martín']
    ],
    'Chealsea' => [
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
    'Borussia Dormunt' => [
        'Porteros' => ['Kobel', 'Meyer', 'Ostrzinski', 'Drewes'],
        'Defensas' => ['Schlotterbeck', 'Anton', 'Anselmino', 'Bensebaini', 'Couto', 'Can', 'Mane', 'Süle', 'Kabar'],
        'Medios' => ['Nmecha', 'Sabitzer', 'Ryerson', 'Brandt', 'Svensson', 'Chukwuemeka', 'Bellingham', 'Groß', 'Özcan', 'Duranville', 'Campbell'],
        'Delanteros' => ['Guirassy', 'Adeyemi', 'Silva', 'Beier']
    ],
    'NewCastle' => [
        'Porteros' => ['Pope', 'Ramsdale', 'Ruddy', 'Gillespie', 'Thompson'],
        'Defensas' => ['Burn', 'Botman', 'Thiaw', 'Trippier', 'Schär', 'Livramento', 'Krafth', 'Lascelles', 'Hall', 'Murphy (LI)', 'Ashby'],
        'Medios' => ['Joelinton', 'Tonali', 'Guimarães', 'Willock', 'Miley'],
        'Delanteros' => ['Gordon', 'Woltemade', 'Murphy (ED)', 'Barnes', 'Elanga', 'Osula', 'Ramsey', 'Wissa']
    ]
];

// Inicializar expulsiones en sesión si no existen
if (!isset($_SESSION['expulsiones'])) {
    $_SESSION['expulsiones'] = [];
}

// Inicializar tarjetas amarillas en sesión si no existen
if (!isset($_SESSION['tarjetas_amarillas'])) {
    $_SESSION['tarjetas_amarillas'] = [];
}

// Inicializar goles en sesión si no existen
if (!isset($_SESSION['goles'])) {
    $_SESSION['goles'] = [];
}

// Inicializar asistencias en sesión si no existen
if (!isset($_SESSION['asistencias'])) {
    $_SESSION['asistencias'] = [];
}

// Inicializar ranking pichichi en sesión si no existe
if (!isset($_SESSION['pichichi'])) {
    $_SESSION['pichichi'] = [];
}

// Inicializar ranking asistencias en sesión si no existe
if (!isset($_SESSION['ranking_asistencias'])) {
    $_SESSION['ranking_asistencias'] = [];
}

// Obtener equipo específico si se pasa por parámetro
$equipo_seleccionado = null;
$jugador_del_equipo = null;

if (isset($_GET['equipo'])) {
    $equipo_seleccionado = $_GET['equipo'];
} elseif (isset($_GET['jugador'])) {
    $jugador_param = $_GET['jugador'];
    // Buscar el equipo del jugador
    if (isset($_SESSION['asignaciones'])) {
        foreach ($_SESSION['asignaciones'] as $asignacion) {
            if ($asignacion['jugador'] === $jugador_param) {
                $equipo_seleccionado = $asignacion['equipo'];
                $jugador_del_equipo = $asignacion['jugador'];
                break;
            }
        }
    }
}

// Obtener lista de equipos asignados
$equipos_asignados = [];
if (isset($_SESSION['asignaciones'])) {
    foreach ($_SESSION['asignaciones'] as $asignacion) {
        $equipos_asignados[$asignacion['equipo']] = $asignacion['jugador'];
    }
}

// Función para actualizar el ranking pichichi
function actualizarPichichi() {
    $_SESSION['pichichi'] = [];
    
    foreach ($_SESSION['goles'] as $equipo => $jugadores) {
        foreach ($jugadores as $jugador => $goles) {
            if ($goles > 0) {
                $_SESSION['pichichi'][] = [
                    'jugador' => $jugador,
                    'equipo' => $equipo,
                    'goles' => $goles
                ];
            }
        }
    }
    
    // Ordenar por número de goles (descendente)
    usort($_SESSION['pichichi'], function($a, $b) {
        return $b['goles'] - $a['goles'];
    });
}

// Función para actualizar el ranking de asistencias
function actualizarRankingAsistencias() {
    $_SESSION['ranking_asistencias'] = [];
    
    foreach ($_SESSION['asistencias'] as $equipo => $jugadores) {
        foreach ($jugadores as $jugador => $asistencias) {
            if ($asistencias > 0) {
                $_SESSION['ranking_asistencias'][] = [
                    'jugador' => $jugador,
                    'equipo' => $equipo,
                    'asistencias' => $asistencias
                ];
            }
        }
    }
    
    // Ordenar por número de asistencias (descendente)
    usort($_SESSION['ranking_asistencias'], function($a, $b) {
        return $b['asistencias'] - $a['asistencias'];
    });
}

// Procesar todas las acciones de formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipo = $_POST['equipo'] ?? '';
    $jugador = $_POST['jugador'] ?? '';
    
    if (isset($_POST['expulsar_jugador'])) {
        if (!isset($_SESSION['expulsiones'][$equipo])) {
            $_SESSION['expulsiones'][$equipo] = [];
        }
        
        if (!in_array($jugador, $_SESSION['expulsiones'][$equipo])) {
            $_SESSION['expulsiones'][$equipo][] = $jugador;
        }
        
        // Redirigir al mismo equipo
        header('Location: equipos.php?equipo=' . urlencode($equipo));
        exit();
    }
    
    if (isset($_POST['readmitir_jugador'])) {
        if (isset($_SESSION['expulsiones'][$equipo])) {
            $key = array_search($jugador, $_SESSION['expulsiones'][$equipo]);
            if ($key !== false) {
                unset($_SESSION['expulsiones'][$equipo][$key]);
                $_SESSION['expulsiones'][$equipo] = array_values($_SESSION['expulsiones'][$equipo]);
            }
        }
        
        header('Location: equipos.php?equipo=' . urlencode($equipo));
        exit();
    }
    
    if (isset($_POST['amonestar_jugador'])) {
        if (!isset($_SESSION['tarjetas_amarillas'][$equipo])) {
            $_SESSION['tarjetas_amarillas'][$equipo] = [];
        }
        
        if (!isset($_SESSION['tarjetas_amarillas'][$equipo][$jugador])) {
            $_SESSION['tarjetas_amarillas'][$equipo][$jugador] = 0;
        }
        
        $_SESSION['tarjetas_amarillas'][$equipo][$jugador]++;
        
        // Si llega a 2, expulsar automáticamente y RESETEAR tarjetas amarillas
        if ($_SESSION['tarjetas_amarillas'][$equipo][$jugador] >= 2) {
            if (!isset($_SESSION['expulsiones'][$equipo])) {
                $_SESSION['expulsiones'][$equipo] = [];
            }
            
            if (!in_array($jugador, $_SESSION['expulsiones'][$equipo])) {
                $_SESSION['expulsiones'][$equipo][] = $jugador;
            }
            
            // RESETEO: Poner las tarjetas amarillas a 0 después de la expulsión automática
            $_SESSION['tarjetas_amarillas'][$equipo][$jugador] = 0;
        }
        
        header('Location: equipos.php?equipo=' . urlencode($equipo));
        exit();
    }
    
    if (isset($_POST['reset_tarjetas_amarillas'])) {
        if (isset($_SESSION['tarjetas_amarillas'][$equipo])) {
            foreach ($_SESSION['tarjetas_amarillas'][$equipo] as $jugador => $count) {
                $_SESSION['tarjetas_amarillas'][$equipo][$jugador] = 0;
            }
        }
        
        header('Location: equipos.php?equipo=' . urlencode($equipo));
        exit();
    }
    
    // Procesar marcación de gol
    if (isset($_POST['marcar_gol'])) {
        if (!isset($_SESSION['goles'][$equipo])) {
            $_SESSION['goles'][$equipo] = [];
        }
        
        if (!isset($_SESSION['goles'][$equipo][$jugador])) {
            $_SESSION['goles'][$equipo][$jugador] = 0;
        }
        
        $_SESSION['goles'][$equipo][$jugador]++;
        
        // Actualizar ranking pichichi
        actualizarPichichi();
        
        header('Location: equipos.php?equipo=' . urlencode($equipo));
        exit();
    }
    
    // Procesar eliminación de gol
    if (isset($_POST['eliminar_gol'])) {
        if (isset($_SESSION['goles'][$equipo][$jugador]) && $_SESSION['goles'][$equipo][$jugador] > 0) {
            $_SESSION['goles'][$equipo][$jugador]--;
            
            // Actualizar ranking pichichi
            actualizarPichichi();
        }
        
        header('Location: equipos.php?equipo=' . urlencode($equipo));
        exit();
    }
    
    // Resetear todos los goles del equipo
    if (isset($_POST['reset_goles'])) {
        if (isset($_SESSION['goles'][$equipo])) {
            $_SESSION['goles'][$equipo] = [];
        }
        
        // Actualizar ranking pichichi
        actualizarPichichi();
        
        header('Location: equipos.php?equipo=' . urlencode($equipo));
        exit();
    }
    
    // Nuevo: Procesar marcación de asistencia
    if (isset($_POST['marcar_asistencia'])) {
        if (!isset($_SESSION['asistencias'][$equipo])) {
            $_SESSION['asistencias'][$equipo] = [];
        }
        
        if (!isset($_SESSION['asistencias'][$equipo][$jugador])) {
            $_SESSION['asistencias'][$equipo][$jugador] = 0;
        }
        
        $_SESSION['asistencias'][$equipo][$jugador]++;
        
        // Actualizar ranking de asistencias
        actualizarRankingAsistencias();
        
        header('Location: equipos.php?equipo=' . urlencode($equipo));
        exit();
    }
    
    // Nuevo: Procesar eliminación de asistencia
    if (isset($_POST['eliminar_asistencia'])) {
        if (isset($_SESSION['asistencias'][$equipo][$jugador]) && $_SESSION['asistencias'][$equipo][$jugador] > 0) {
            $_SESSION['asistencias'][$equipo][$jugador]--;
            
            // Actualizar ranking de asistencias
            actualizarRankingAsistencias();
        }
        
        header('Location: equipos.php?equipo=' . urlencode($equipo));
        exit();
    }
    
    // Nuevo: Resetear todas las asistencias del equipo
    if (isset($_POST['reset_asistencias'])) {
        if (isset($_SESSION['asistencias'][$equipo])) {
            $_SESSION['asistencias'][$equipo] = [];
        }
        
        // Actualizar ranking de asistencias
        actualizarRankingAsistencias();
        
        header('Location: equipos.php?equipo=' . urlencode($equipo));
        exit();
    }
}

// Actualizar rankings al cargar la página
actualizarPichichi();
actualizarRankingAsistencias();

// Mapeo de imágenes de equipos (ACTUALIZADO CON LOS 12 EQUIPOS)
$imagenes_equipos = [
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

// Función para verificar si una imagen existe
function imagenExiste($ruta) {
    return file_exists($ruta) && is_file($ruta);
}

// Función para obtener el número de tarjetas amarillas de un jugador
function obtenerTarjetasAmarillas($equipo, $jugador) {
    if (isset($_SESSION['tarjetas_amarillas'][$equipo][$jugador])) {
        return $_SESSION['tarjetas_amarillas'][$equipo][$jugador];
    }
    return 0;
}

// Función para obtener el número de goles de un jugador
function obtenerGoles($equipo, $jugador) {
    if (isset($_SESSION['goles'][$equipo][$jugador])) {
        return $_SESSION['goles'][$equipo][$jugador];
    }
    return 0;
}

// Función para obtener el número de asistencias de un jugador
function obtenerAsistencias($equipo, $jugador) {
    if (isset($_SESSION['asistencias'][$equipo][$jugador])) {
        return $_SESSION['asistencias'][$equipo][$jugador];
    }
    return 0;
}

// Función para obtener emoji del equipo (ACTUALIZADO)
function obtenerEmojiEquipo($equipo) {
    $emojis = [
        'Real Madrid' => '⚪',
        'Barcelona' => '🔵🔴',
        'Bayern' => '🔴',
        'Psg' => '🔵🔴',
        'Liverpool' => '🔴',
        'Manchester City' => '🔵',
        'Arsenal' => '🔴',
        'Atletico de Madrid' => '🔴⚪',
        'Chealsea' => '🔵',
        'Inter de milan' => '🔵⚫',
        'Dormunt' => '🟡',
        'NewCastle' => '⚫⚪'
    ];
    
    return $emojis[$equipo] ?? '⚽';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipos - Torneo FIFA 26</title>
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
    --info-color: #3498db;
    --text-color: #ffffff;
    --text-secondary: #b0b0b0;
    --border-radius: 12px;
    --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    --transition: all 0.3s ease;
    --gradient-primary: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    --gradient-accent: linear-gradient(135deg, var(--accent-color), var(--highlight-color));
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

/* ===== ESTILOS GENERALES ===== */
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

.button-warning {
    background: rgba(243, 156, 18, 0.2);
    border-color: rgba(243, 156, 18, 0.5);
}

.button-warning:hover {
    background: rgba(243, 156, 18, 0.3);
}

.navegacion-inferior {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 40px;
    flex-wrap: wrap;
}

/* ===== VISTA DE LISTA DE EQUIPOS ===== */
.equipos-container {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: var(--box-shadow);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.header-equipos {
    text-align: center;
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.header-equipos h2 {
    font-size: 2.5rem;
    margin-bottom: 10px;
    background: linear-gradient(to right, var(--text-color), var(--highlight-color));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    text-shadow: 0 0 10px rgba(233, 69, 96, 0.3);
}

.contador-jugadores {
    font-size: 1.2rem;
    color: var(--text-secondary);
    background: rgba(255, 255, 255, 0.1);
    padding: 8px 16px;
    border-radius: 20px;
    display: inline-block;
}

.grid-equipos {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
}

.equipo-card {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 25px;
    text-decoration: none;
    color: var(--text-color);
    transition: var(--transition);
    border: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.equipo-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, transparent, rgba(255, 255, 255, 0.03), transparent);
    z-index: -1;
}

.equipo-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
    border-color: rgba(255, 255, 255, 0.3);
}

.escudo-equipo {
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.escudo-equipo img {
    max-width: 100%;
    max-height: 80px;
    filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.3));
    transition: var(--transition);
}

.equipo-card:hover .escudo-equipo img {
    transform: scale(1.1);
}

.nombre-equipo {
    font-size: 1.4rem;
    font-weight: bold;
    margin-bottom: 10px;
    color: var(--text-color);
}

.jugador-asignado {
    font-size: 0.95rem;
    color: var(--text-secondary);
    margin-bottom: 15px;
}

.btn-ver-plantilla {
    background: var(--gradient-accent);
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: bold;
    transition: var(--transition);
    margin-top: auto;
}

.equipo-card:hover .btn-ver-plantilla {
    transform: scale(1.05);
    box-shadow: 0 5px 15px rgba(233, 69, 96, 0.4);
}

/* ===== VISTA DETALLE DEL EQUIPO ===== */
.plantilla-container {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: var(--box-shadow);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.header-plantilla {
    text-align: center;
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
}

.header-plantilla::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 3px;
    background: var(--gradient-accent);
    border-radius: 3px;
}

.escudo-equipo {
    margin-bottom: 20px;
}

.escudo-equipo img {
    max-width: 120px;
    filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.3));
}

.nombre-equipo-plantilla {
    font-size: 2.5rem;
    margin-bottom: 10px;
    background: linear-gradient(to right, var(--text-color), var(--highlight-color));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    text-shadow: 0 0 10px rgba(233, 69, 96, 0.3);
}

.jugador-propietario {
    font-size: 1.2rem;
    color: var(--text-secondary);
    background: rgba(255, 255, 255, 0.1);
    padding: 8px 16px;
    border-radius: 20px;
    display: inline-block;
}

.grid-plantilla {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

.categoria-plantilla {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 20px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: var(--transition);
}

.categoria-plantilla:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
}

.categoria-titulo {
    font-size: 1.4rem;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    color: var(--highlight-color);
}

.lista-jugadores {
    list-style: none;
}

.lista-jugadores li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    margin-bottom: 8px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    transition: var(--transition);
}

.lista-jugadores li:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateX(5px);
}

.jugador-expulsado {
    background: rgba(231, 76, 60, 0.2) !important;
    border-left: 4px solid var(--danger-color);
}

.jugador-expulsado:hover {
    background: rgba(231, 76, 60, 0.3) !important;
}

.jugador-con-amarilla {
    border-left: 4px solid var(--warning-color);
}

.icono-expulsado {
    margin-right: 8px;
}

.contador-amarillas {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    background-color: var(--warning-color);
    color: #000;
    border-radius: 50%;
    font-size: 0.8rem;
    font-weight: bold;
    margin-left: 8px;
}

/* ===== BOTONES DE ACCIONES ===== */
.btn-expulsar, .btn-readmitir, .btn-amonestar, .btn-gol, .btn-eliminar-gol, .btn-asistencia, .btn-eliminar-asistencia {
    padding: 6px 12px;
    border: none;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: bold;
    cursor: pointer;
    transition: var(--transition);
    margin-left: 5px;
}

.btn-expulsar {
    background: rgba(231, 76, 60, 0.3);
    color: white;
    border: 1px solid rgba(231, 76, 60, 0.5);
}

.btn-expulsar:hover {
    background: rgba(231, 76, 60, 0.5);
    transform: scale(1.05);
}

.btn-readmitir {
    background: rgba(76, 175, 80, 0.3);
    color: white;
    border: 1px solid rgba(76, 175, 80, 0.5);
}

.btn-readmitir:hover {
    background: rgba(76, 175, 80, 0.5);
    transform: scale(1.05);
}

.btn-amonestar {
    background: rgba(243, 156, 18, 0.3);
    color: white;
    border: 1px solid rgba(243, 156, 18, 0.5);
}

.btn-amonestar:hover {
    background: rgba(243, 156, 18, 0.5);
    transform: scale(1.05);
}

.btn-gol {
    background: rgba(46, 204, 113, 0.3);
    color: white;
    border: 1px solid rgba(46, 204, 113, 0.5);
}

.btn-gol:hover {
    background: rgba(46, 204, 113, 0.5);
    transform: scale(1.05);
}

.btn-eliminar-gol {
    background: rgba(231, 76, 60, 0.3);
    color: white;
    border: 1px solid rgba(231, 76, 60, 0.5);
}

.btn-eliminar-gol:hover {
    background: rgba(231, 76, 60, 0.5);
    transform: scale(1.05);
}

.btn-asistencia {
    background: rgba(52, 152, 219, 0.3);
    color: white;
    border: 1px solid rgba(52, 152, 219, 0.5);
}

.btn-asistencia:hover {
    background: rgba(52, 152, 219, 0.5);
    transform: scale(1.05);
}

.btn-eliminar-asistencia {
    background: rgba(231, 76, 60, 0.3);
    color: white;
    border: 1px solid rgba(231, 76, 60, 0.5);
}

.btn-eliminar-asistencia:hover {
    background: rgba(231, 76, 60, 0.5);
    transform: scale(1.05);
}

.btn-reset-amarillas, .btn-reset-goles, .btn-reset-asistencias {
    background: rgba(243, 156, 18, 0.2);
    color: white;
    border: 1px solid rgba(243, 156, 18, 0.5);
    padding: 10px 20px;
    border-radius: var(--border-radius);
    cursor: pointer;
    font-weight: bold;
    transition: var(--transition);
    margin-top: 10px;
}

.btn-reset-amarillas:hover, .btn-reset-goles:hover, .btn-reset-asistencias:hover {
    background: rgba(243, 156, 18, 0.4);
    transform: translateY(-3px);
}

.btn-reset-goles {
    background: rgba(46, 204, 113, 0.2);
    border-color: rgba(46, 204, 113, 0.5);
}

.btn-reset-goles:hover {
    background: rgba(46, 204, 113, 0.4);
}

.btn-reset-asistencias {
    background: rgba(52, 152, 219, 0.2);
    border-color: rgba(52, 152, 219, 0.5);
}

.btn-reset-asistencias:hover {
    background: rgba(52, 152, 219, 0.4);
}

/* ===== CONTADORES ===== */
.contador-goles {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 24px;
    height: 24px;
    background-color: var(--success-color);
    color: white;
    border-radius: 50%;
    font-size: 0.8rem;
    font-weight: bold;
    margin-left: 8px;
    padding: 0 6px;
}

.contador-asistencias {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 24px;
    height: 24px;
    background-color: var(--info-color);
    color: white;
    border-radius: 50%;
    font-size: 0.8rem;
    font-weight: bold;
    margin-left: 8px;
    padding: 0 6px;
}

/* ===== SECCIÓN DE EXPULSIONES ===== */
.seccion-expulsiones {
    background: rgba(231, 76, 60, 0.1);
    border-radius: var(--border-radius);
    padding: 25px;
    margin-bottom: 40px;
    border: 1px solid rgba(231, 76, 60, 0.3);
}

.titulo-expulsiones {
    font-size: 1.5rem;
    margin-bottom: 20px;
    color: var(--danger-color);
    display: flex;
    align-items: center;
    gap: 10px;
}

.lista-expulsiones {
    list-style: none;
}

.lista-expulsiones li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    margin-bottom: 8px;
    background: rgba(231, 76, 60, 0.2);
    border-radius: 8px;
    border-left: 4px solid var(--danger-color);
}

.sin-expulsiones {
    text-align: center;
    padding: 20px;
    color: var(--text-secondary);
    font-style: italic;
}

/* ===== SECCIÓN DE TARJETAS AMARILLAS ===== */
.seccion-amarillas {
    background: rgba(243, 156, 18, 0.1);
    border-radius: var(--border-radius);
    padding: 25px;
    margin-bottom: 40px;
    border: 1px solid rgba(243, 156, 18, 0.3);
}

.titulo-amarillas {
    font-size: 1.5rem;
    margin-bottom: 20px;
    color: var(--warning-color);
    display: flex;
    align-items: center;
    gap: 10px;
}

.lista-amarillas {
    list-style: none;
}

.lista-amarillas li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    margin-bottom: 8px;
    background: rgba(243, 156, 18, 0.2);
    border-radius: 8px;
    border-left: 4px solid var(--warning-color);
}

.sin-amarillas {
    text-align: center;
    padding: 20px;
    color: var(--text-secondary);
    font-style: italic;
}

/* ===== SECCIÓN DE GOLES ===== */
.seccion-goles {
    background: rgba(46, 204, 113, 0.1);
    border-radius: var(--border-radius);
    padding: 25px;
    margin-bottom: 40px;
    border: 1px solid rgba(46, 204, 113, 0.3);
}

.titulo-goles {
    font-size: 1.5rem;
    margin-bottom: 20px;
    color: var(--success-color);
    display: flex;
    align-items: center;
    gap: 10px;
}

.lista-goles {
    list-style: none;
}

.lista-goles li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    margin-bottom: 8px;
    background: rgba(46, 204, 113, 0.2);
    border-radius: 8px;
    border-left: 4px solid var(--success-color);
}

.sin-goles {
    text-align: center;
    padding: 20px;
    color: var(--text-secondary);
    font-style: italic;
}

/* ===== SECCIÓN DE ASISTENCIAS ===== */
.seccion-asistencias {
    background: rgba(52, 152, 219, 0.1);
    border-radius: var(--border-radius);
    padding: 25px;
    margin-bottom: 40px;
    border: 1px solid rgba(52, 152, 219, 0.3);
}

.titulo-asistencias {
    font-size: 1.5rem;
    margin-bottom: 20px;
    color: var(--info-color);
    display: flex;
    align-items: center;
    gap: 10px;
}

.lista-asistencias {
    list-style: none;
}

.lista-asistencias li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    margin-bottom: 8px;
    background: rgba(52, 152, 219, 0.2);
    border-radius: 8px;
    border-left: 4px solid var(--info-color);
}

.sin-asistencias {
    text-align: center;
    padding: 20px;
    color: var(--text-secondary);
    font-style: italic;
}

/* ===== SECCIÓN PICHICHI ===== */
.seccion-pichichi {
    background: rgba(241, 196, 15, 0.1);
    border-radius: var(--border-radius);
    padding: 25px;
    margin-bottom: 40px;
    border: 1px solid rgba(241, 196, 15, 0.3);
}

.titulo-pichichi {
    font-size: 1.5rem;
    margin-bottom: 20px;
    color: var(--warning-color);
    display: flex;
    align-items: center;
    gap: 10px;
}

.trofeo-pichichi {
    font-size: 1.8rem;
    margin-right: 5px;
}

.lista-pichichi {
    list-style: none;
    counter-reset: pichichi-counter;
}

.lista-pichichi li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    margin-bottom: 10px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    border-left: 4px solid var(--warning-color);
    counter-increment: pichichi-counter;
    transition: var(--transition);
}

.lista-pichichi li:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateX(5px);
}

.lista-pichichi li::before {
    content: counter(pichichi-counter);
    font-weight: bold;
    font-size: 1.2rem;
    color: var(--warning-color);
    margin-right: 15px;
    min-width: 30px;
    text-align: center;
}

.lista-pichichi li:first-child {
    background: rgba(241, 196, 15, 0.2);
    border-left: 4px solid gold;
}

.lista-pichichi li:first-child::before {
    content: "🥇";
    font-size: 1.5rem;
}

.lista-pichichi li:nth-child(2)::before {
    content: "🥈";
    font-size: 1.5rem;
}

.lista-pichichi li:nth-child(3)::before {
    content: "🥉";
    font-size: 1.5rem;
}

.jugador-pichichi {
    display: flex;
    align-items: center;
    gap: 10px;
}

.equipo-pichichi {
    font-size: 0.9rem;
    color: var(--text-secondary);
    background: rgba(255, 255, 255, 0.1);
    padding: 4px 8px;
    border-radius: 12px;
}

.goles-pichichi {
    font-size: 1.3rem;
    font-weight: bold;
    color: var(--warning-color);
    background: rgba(241, 196, 15, 0.2);
    padding: 5px 10px;
    border-radius: 20px;
}

.sin-pichichi {
    text-align: center;
    padding: 20px;
    color: var(--text-secondary);
    font-style: italic;
}

/* ===== SECCIÓN RANKING ASISTENCIAS ===== */
.seccion-ranking-asistencias {
    background: rgba(52, 152, 219, 0.1);
    border-radius: var(--border-radius);
    padding: 25px;
    margin-bottom: 40px;
    border: 1px solid rgba(52, 152, 219, 0.3);
}

.titulo-ranking-asistencias {
    font-size: 1.5rem;
    margin-bottom: 20px;
    color: var(--info-color);
    display: flex;
    align-items: center;
    gap: 10px;
}

.trofeo-asistencias {
    font-size: 1.8rem;
    margin-right: 5px;
}

.lista-asistencias-ranking {
    list-style: none;
    counter-reset: asistencias-counter;
}

.lista-asistencias-ranking li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    margin-bottom: 10px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    border-left: 4px solid var(--info-color);
    counter-increment: asistencias-counter;
    transition: var(--transition);
}

.lista-asistencias-ranking li:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateX(5px);
}

.lista-asistencias-ranking li::before {
    content: counter(asistencias-counter);
    font-weight: bold;
    font-size: 1.2rem;
    color: var(--info-color);
    margin-right: 15px;
    min-width: 30px;
    text-align: center;
}

.lista-asistencias-ranking li:first-child {
    background: rgba(52, 152, 219, 0.2);
    border-left: 4px solid var(--info-color);
}

.lista-asistencias-ranking li:first-child::before {
    content: "🥇";
    font-size: 1.5rem;
}

.lista-asistencias-ranking li:nth-child(2)::before {
    content: "🥈";
    font-size: 1.5rem;
}

.lista-asistencias-ranking li:nth-child(3)::before {
    content: "🥉";
    font-size: 1.5rem;
}

.jugador-asistencias {
    display: flex;
    align-items: center;
    gap: 10px;
}

.equipo-asistencias {
    font-size: 0.9rem;
    color: var(--text-secondary);
    background: rgba(255, 255, 255, 0.1);
    padding: 4px 8px;
    border-radius: 12px;
}

.asistencias-count {
    font-size: 1.3rem;
    font-weight: bold;
    color: var(--info-color);
    background: rgba(52, 152, 219, 0.2);
    padding: 5px 10px;
    border-radius: 20px;
}

.sin-asistencias-ranking {
    text-align: center;
    padding: 20px;
    color: var(--text-secondary);
    font-style: italic;
}

/* ===== ESTADÍSTICAS DEL EQUIPO ===== */
.estadisticas-equipo {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 20px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 25px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.estadistica-item {
    text-align: center;
    padding: 15px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    transition: var(--transition);
}

.estadistica-item:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.1);
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

/* ===== ESTADO SIN EQUIPOS ASIGNADOS ===== */
.sin-equipos {
    text-align: center;
    padding: 60px 20px;
}

.sin-equipos p {
    color: var(--text-secondary);
    font-size: 1.2rem;
    margin-bottom: 20px;
}

/* ===== ANIMACIONES ===== */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.equipo-card, .categoria-plantilla, .estadistica-item {
    animation: fadeIn 0.5s ease forwards;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .grid-equipos {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }
    
    .grid-plantilla {
        grid-template-columns: 1fr;
    }
    
    .estadisticas-equipo {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .lista-jugadores li {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
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
    
    .nombre-equipo-plantilla {
        font-size: 2rem;
    }
    
    .btn-expulsar, .btn-readmitir, .btn-amonestar, .btn-gol, .btn-eliminar-gol, .btn-asistencia, .btn-eliminar-asistencia {
        margin-left: 0;
        margin-top: 5px;
        width: 100%;
    }
}

@media (max-width: 480px) {
    .header-equipos h2, .nombre-equipo-plantilla {
        font-size: 1.8rem;
    }
    
    .grid-equipos {
        grid-template-columns: 1fr;
    }
    
    .estadisticas-equipo {
        grid-template-columns: 1fr;
    }
}

/* Efectos especiales */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.equipo-card:hover .escudo-equipo {
    animation: pulse 1s infinite;
}

/* Efecto de brillo en elementos importantes */
.estadistica-item:nth-child(6):hover .estadistica-valor {
    color: var(--danger-color);
    text-shadow: 0 0 10px rgba(231, 76, 60, 0.5);
}
</style>
</head>
<body>
    <div class="container">        
        <?php if ($equipo_seleccionado && array_key_exists($equipo_seleccionado, $plantillas_equipos)): ?>
            <!-- Mostrar plantilla del equipo específico -->
            <div class="plantilla-container">
                <div class="header-plantilla">
                    <div class="escudo-equipo">
                        <?php 
                        // Mostrar imagen del equipo si existe, sino mostrar emoji por defecto
                        if (isset($imagenes_equipos[$equipo_seleccionado]) && imagenExiste($imagenes_equipos[$equipo_seleccionado])): 
                        ?>
                            <img src="<?php echo $imagenes_equipos[$equipo_seleccionado]; ?>" alt="<?php echo $equipo_seleccionado; ?>">
                        <?php else: ?>
                            <span style="font-size: 4rem;"><?php echo obtenerEmojiEquipo($equipo_seleccionado); ?></span>
                        <?php endif; ?>
                    </div>
                    <h1 class="nombre-equipo-plantilla"><?php echo $equipo_seleccionado; ?></h1>
                    <?php if ($jugador_del_equipo): ?>
                        <div class="jugador-propietario">
                            <strong><?php echo $jugador_del_equipo; ?></strong>
                        </div>
                    <?php elseif (isset($equipos_asignados[$equipo_seleccionado])): ?>
                        <div class="jugador-propietario">
                            <strong><?php echo $equipos_asignados[$equipo_seleccionado]; ?></strong>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="grid-plantilla">
                    <?php foreach ($plantillas_equipos[$equipo_seleccionado] as $categoria => $jugadores): ?>
                        <div class="categoria-plantilla">
                            <h3 class="categoria-titulo"><?php echo $categoria; ?></h3>
                            <ul class="lista-jugadores">
                                <?php foreach ($jugadores as $jugador): 
                                    $estaExpulsado = isset($_SESSION['expulsiones'][$equipo_seleccionado]) && 
                                                   in_array($jugador, $_SESSION['expulsiones'][$equipo_seleccionado]);
                                    $tarjetasAmarillas = obtenerTarjetasAmarillas($equipo_seleccionado, $jugador);
                                    $tieneAmarillas = $tarjetasAmarillas > 0;
                                    $golesJugador = obtenerGoles($equipo_seleccionado, $jugador);
                                    $tieneGoles = $golesJugador > 0;
                                    $asistenciasJugador = obtenerAsistencias($equipo_seleccionado, $jugador);
                                    $tieneAsistencias = $asistenciasJugador > 0;
                                ?>
                                    <li class="<?php echo $estaExpulsado ? 'jugador-expulsado' : ($tieneAmarillas ? 'jugador-con-amarilla' : ''); ?>">
                                        <span>
                                            <?php if ($estaExpulsado): ?>
                                                <span class="icono-expulsado">🟥</span>
                                            <?php endif; ?>
                                            <?php echo $jugador; ?>
                                            <?php if ($tieneAmarillas && !$estaExpulsado): ?>
                                                <span class="contador-amarillas" title="<?php echo $tarjetasAmarillas; ?> tarjeta(s) amarilla(s)">
                                                    <?php echo $tarjetasAmarillas; ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php if ($tieneGoles && !$estaExpulsado): ?>
                                                <span class="contador-goles" title="<?php echo $golesJugador; ?> gol(es)">
                                                    <?php echo $golesJugador; ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php if ($tieneAsistencias && !$estaExpulsado): ?>
                                                <span class="contador-asistencias" title="<?php echo $asistenciasJugador; ?> asistencia(s)">
                                                    <?php echo $asistenciasJugador; ?>
                                                </span>
                                            <?php endif; ?>
                                        </span>
                                        
                                        <div class="botones-jugador">
                                            <?php if ($estaExpulsado): ?>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="equipo" value="<?php echo htmlspecialchars($equipo_seleccionado); ?>">
                                                    <input type="hidden" name="jugador" value="<?php echo htmlspecialchars($jugador); ?>">
                                                    <button type="submit" name="readmitir_jugador" class="btn-readmitir" 
                                                            onclick="return confirm('¿Readmitir a <?php echo $jugador; ?>?')">
                                                        ✅ Readmitir
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="equipo" value="<?php echo htmlspecialchars($equipo_seleccionado); ?>">
                                                    <input type="hidden" name="jugador" value="<?php echo htmlspecialchars($jugador); ?>">
                                                    <button type="submit" name="marcar_gol" class="btn-gol" 
                                                            onclick="return confirm('¿Marcar gol a <?php echo $jugador; ?>?')">
                                                        ⚽ Gol
                                                    </button>
                                                </form>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="equipo" value="<?php echo htmlspecialchars($equipo_seleccionado); ?>">
                                                    <input type="hidden" name="jugador" value="<?php echo htmlspecialchars($jugador); ?>">
                                                    <button type="submit" name="marcar_asistencia" class="btn-asistencia" 
                                                            onclick="return confirm('¿Marcar asistencia a <?php echo $jugador; ?>?')">
                                                        🎯 Asistencia
                                                    </button>
                                                </form>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="equipo" value="<?php echo htmlspecialchars($equipo_seleccionado); ?>">
                                                    <input type="hidden" name="jugador" value="<?php echo htmlspecialchars($jugador); ?>">
                                                    <button type="submit" name="amonestar_jugador" class="btn-amonestar" 
                                                            onclick="return confirm('¿Amonestar a <?php echo $jugador; ?>? (Amarilla)')">
                                                        🟨 Amonestar
                                                    </button>
                                                </form>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="equipo" value="<?php echo htmlspecialchars($equipo_seleccionado); ?>">
                                                    <input type="hidden" name="jugador" value="<?php echo htmlspecialchars($jugador); ?>">
                                                    <button type="submit" name="expulsar_jugador" class="btn-expulsar" 
                                                            onclick="return confirm('¿Expulsar a <?php echo $jugador; ?>? (Roja directa)')">
                                                        🟥 Expulsar
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Sección de jugadores expulsados -->
                <div class="seccion-expulsiones">
                    <h3 class="titulo-expulsiones">
                        <span>🟥</span>
                        Jugadores Expulsados
                    </h3>
                    
                    <?php if (isset($_SESSION['expulsiones'][$equipo_seleccionado]) && !empty($_SESSION['expulsiones'][$equipo_seleccionado])): ?>
                        <ul class="lista-expulsiones">
                            <?php foreach ($_SESSION['expulsiones'][$equipo_seleccionado] as $jugador_expulsado): ?>
                                <li>
                                    <span><?php echo $jugador_expulsado; ?></span>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="equipo" value="<?php echo htmlspecialchars($equipo_seleccionado); ?>">
                                        <input type="hidden" name="jugador" value="<?php echo htmlspecialchars($jugador_expulsado); ?>">
                                        <button type="submit" name="readmitir_jugador" class="btn-readmitir">
                                            ✅ Readmitir
                                        </button>
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="sin-expulsiones">
                            No hay jugadores expulsados en este equipo.
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Sección de tarjetas amarillas -->
                <div class="seccion-amarillas">
                    <h3 class="titulo-amarillas">
                        <span>🟨</span>
                        Tarjetas Amarillas
                        <form method="POST" style="display: inline; margin-left: 20px;">
                            <input type="hidden" name="equipo" value="<?php echo htmlspecialchars($equipo_seleccionado); ?>">
                            <button type="submit" name="reset_tarjetas_amarillas" class="btn-reset-amarillas" 
                                    onclick="return confirm('¿Resetear todas las tarjetas amarillas de <?php echo $equipo_seleccionado; ?>?')">
                                🔄 Resetear Amarillas
                            </button>
                        </form>
                    </h3>
                    
                    <?php 
                    $jugadoresConAmarillas = [];
                    if (isset($_SESSION['tarjetas_amarillas'][$equipo_seleccionado])) {
                        foreach ($_SESSION['tarjetas_amarillas'][$equipo_seleccionado] as $jugador => $count) {
                            if ($count > 0) {
                                $jugadoresConAmarillas[$jugador] = $count;
                            }
                        }
                    }
                    ?>
                    
                    <?php if (!empty($jugadoresConAmarillas)): ?>
                        <ul class="lista-amarillas">
                            <?php foreach ($jugadoresConAmarillas as $jugador => $count): ?>
                                <li>
                                    <span>
                                        <?php echo $jugador; ?>
                                        <span class="contador-amarillas"><?php echo $count; ?></span>
                                    </span>
                                    <span>
                                        <?php if ($count >= 2): ?>
                                            <span style="color: var(--danger-color); font-weight: bold;">(SUSPENDIDO - Se resetearán a 0)</span>
                                        <?php else: ?>
                                            <span style="color: var(--warning-color);">(<?php echo 2 - $count; ?> para suspensión)</span>
                                        <?php endif; ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="sin-amarillas">
                            No hay jugadores con tarjetas amarillas en este equipo.
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Sección de Goles -->
                <div class="seccion-goles">
                    <h3 class="titulo-goles">
                        <span>⚽</span>
                        Goles Marcados
                        <form method="POST" style="display: inline; margin-left: 20px;">
                            <input type="hidden" name="equipo" value="<?php echo htmlspecialchars($equipo_seleccionado); ?>">
                            <button type="submit" name="reset_goles" class="btn-reset-goles" 
                                    onclick="return confirm('¿Resetear todos los goles de <?php echo $equipo_seleccionado; ?>?')">
                                🔄 Resetear Goles
                            </button>
                        </form>
                    </h3>
                    
                    <?php 
                    $jugadoresConGoles = [];
                    if (isset($_SESSION['goles'][$equipo_seleccionado])) {
                        foreach ($_SESSION['goles'][$equipo_seleccionado] as $jugador => $count) {
                            if ($count > 0) {
                                $jugadoresConGoles[$jugador] = $count;
                            }
                        }
                    }
                    ?>
                    
                    <?php if (!empty($jugadoresConGoles)): ?>
                        <ul class="lista-goles">
                            <?php foreach ($jugadoresConGoles as $jugador => $count): ?>
                                <li>
                                    <span>
                                        <?php echo $jugador; ?>
                                        <span class="contador-goles"><?php echo $count; ?></span>
                                    </span>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="equipo" value="<?php echo htmlspecialchars($equipo_seleccionado); ?>">
                                        <input type="hidden" name="jugador" value="<?php echo htmlspecialchars($jugador); ?>">
                                        <button type="submit" name="eliminar_gol" class="btn-eliminar-gol" 
                                                onclick="return confirm('¿Eliminar gol a <?php echo $jugador; ?>?')">
                                            ➖ Eliminar Gol
                                        </button>
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="sin-goles">
                            No hay goles registrados para este equipo.
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Sección de Asistencias -->
                <div class="seccion-asistencias">
                    <h3 class="titulo-asistencias">
                        <span>🎯</span>
                        Asistencias
                        <form method="POST" style="display: inline; margin-left: 20px;">
                            <input type="hidden" name="equipo" value="<?php echo htmlspecialchars($equipo_seleccionado); ?>">
                            <button type="submit" name="reset_asistencias" class="btn-reset-asistencias" 
                                    onclick="return confirm('¿Resetear todas las asistencias de <?php echo $equipo_seleccionado; ?>?')">
                                🔄 Resetear Asistencias
                            </button>
                        </form>
                    </h3>
                    
                    <?php 
                    $jugadoresConAsistencias = [];
                    if (isset($_SESSION['asistencias'][$equipo_seleccionado])) {
                        foreach ($_SESSION['asistencias'][$equipo_seleccionado] as $jugador => $count) {
                            if ($count > 0) {
                                $jugadoresConAsistencias[$jugador] = $count;
                            }
                        }
                    }
                    ?>
                    
                    <?php if (!empty($jugadoresConAsistencias)): ?>
                        <ul class="lista-asistencias">
                            <?php foreach ($jugadoresConAsistencias as $jugador => $count): ?>
                                <li>
                                    <span>
                                        <?php echo $jugador; ?>
                                        <span class="contador-asistencias"><?php echo $count; ?></span>
                                    </span>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="equipo" value="<?php echo htmlspecialchars($equipo_seleccionado); ?>">
                                        <input type="hidden" name="jugador" value="<?php echo htmlspecialchars($jugador); ?>">
                                        <button type="submit" name="eliminar_asistencia" class="btn-eliminar-asistencia" 
                                                onclick="return confirm('¿Eliminar asistencia a <?php echo $jugador; ?>?')">
                                            ➖ Eliminar Asistencia
                                        </button>
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="sin-asistencias">
                            No hay asistencias registradas para este equipo.
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="estadisticas-equipo">
                    <div class="estadistica-item">
                        <div class="estadistica-valor"><?php echo count($plantillas_equipos[$equipo_seleccionado]['Porteros']); ?></div>
                        <div class="estadistica-label">Porteros</div>
                    </div>
                    <div class="estadistica-item">
                        <div class="estadistica-valor"><?php echo count($plantillas_equipos[$equipo_seleccionado]['Defensas']); ?></div>
                        <div class="estadistica-label">Defensas</div>
                    </div>
                    <div class="estadistica-item">
                        <div class="estadistica-valor"><?php echo count($plantillas_equipos[$equipo_seleccionado]['Medios']); ?></div>
                        <div class="estadistica-label">Mediocampistas</div>
                    </div>
                    <div class="estadistica-item">
                        <div class="estadistica-valor"><?php echo count($plantillas_equipos[$equipo_seleccionado]['Delanteros']); ?></div>
                        <div class="estadistica-label">Delanteros</div>
                    </div>
                    <div class="estadistica-item">
                        <div class="estadistica-valor">
                            <?php 
                            $total_jugadores = count($plantillas_equipos[$equipo_seleccionado]['Porteros']) + 
                                              count($plantillas_equipos[$equipo_seleccionado]['Defensas']) + 
                                              count($plantillas_equipos[$equipo_seleccionado]['Medios']) + 
                                              count($plantillas_equipos[$equipo_seleccionado]['Delanteros']);
                            echo $total_jugadores;
                            ?>
                        </div>
                        <div class="estadistica-label">Total Jugadores</div>
                    </div>
                    <div class="estadistica-item">
                        <div class="estadistica-valor" style="color: <?php echo (isset($_SESSION['expulsiones'][$equipo_seleccionado]) && count($_SESSION['expulsiones'][$equipo_seleccionado]) > 0) ? '#e74c3c' : 'var(--primary)'; ?>">
                            <?php echo isset($_SESSION['expulsiones'][$equipo_seleccionado]) ? count($_SESSION['expulsiones'][$equipo_seleccionado]) : 0; ?>
                        </div>
                        <div class="estadistica-label">Jugadores Expulsados</div>
                    </div>
                    <div class="estadistica-item">
                        <div class="estadistica-valor" style="color: var(--warning-color);">
                            <?php 
                            $total_amarillas = 0;
                            if (isset($_SESSION['tarjetas_amarillas'][$equipo_seleccionado])) {
                                foreach ($_SESSION['tarjetas_amarillas'][$equipo_seleccionado] as $count) {
                                    $total_amarillas += $count;
                                }
                            }
                            echo $total_amarillas;
                            ?>
                        </div>
                        <div class="estadistica-label">Tarjetas Amarillas</div>
                    </div>
                    <div class="estadistica-item">
                        <div class="estadistica-valor" style="color: var(--success-color);">
                            <?php 
                            $total_goles = 0;
                            if (isset($_SESSION['goles'][$equipo_seleccionado])) {
                                foreach ($_SESSION['goles'][$equipo_seleccionado] as $count) {
                                    $total_goles += $count;
                                }
                            }
                            echo $total_goles;
                            ?>
                        </div>
                        <div class="estadistica-label">Goles Totales</div>
                    </div>
                    <div class="estadistica-item">
                        <div class="estadistica-valor" style="color: var(--info-color);">
                            <?php 
                            $total_asistencias = 0;
                            if (isset($_SESSION['asistencias'][$equipo_seleccionado])) {
                                foreach ($_SESSION['asistencias'][$equipo_seleccionado] as $count) {
                                    $total_asistencias += $count;
                                }
                            }
                            echo $total_asistencias;
                            ?>
                        </div>
                        <div class="estadistica-label">Asistencias Totales</div>
                    </div>
                </div>
            </div>
            
            <div class="navegacion-inferior">
                <a href="equipos.php" class="button">← Volver a Equipos</a>
                <a href="index.php" class="button">🏠 Volver al Inicio</a>
            </div>
            
        <?php else: ?>
            <!-- Mostrar lista de equipos -->
            <div class="equipos-container">
                <div class="header-equipos">
                    <h2> Equipos del Torneo</h2>
                    <div class="contador-jugadores">
                        <?php echo count($equipos_asignados); ?> de 8 equipos asignados ⚽
                    </div>
                </div>
                
                <?php if (empty($equipos_asignados)): ?>
                    <div style="text-align: center; padding: 40px;">
                        <p style="color: #6c757d; font-size: 1.2rem; margin-bottom: 20px;">
                            No hay equipos asignados todavía.
                        </p>
                        <a href="sorteo.php" class="button button-success">🎲 Realizar Sorteo de Equipos</a>
                    </div>
                <?php else: ?>
                    <div class="grid-equipos">
                        <?php foreach ($equipos_asignados as $equipo => $jugador): ?>
                            <a href="equipos.php?equipo=<?php echo urlencode($equipo); ?>" class="equipo-card">
                                <div class="escudo-equipo" style="width: 80px; height: 80px; margin: 0 auto 15px; font-size: 2.5rem;">
                                    <?php 
                                    // Mostrar imagen del equipo si existe, sino mostrar emoji por defecto
                                    if (isset($imagenes_equipos[$equipo]) && imagenExiste($imagenes_equipos[$equipo])): 
                                    ?>
                                        <img src="<?php echo $imagenes_equipos[$equipo]; ?>" alt="<?php echo $equipo; ?>">
                                    <?php else: ?>
                                        <span style="font-size: 3rem;"><?php echo obtenerEmojiEquipo($equipo); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="nombre-equipo"><?php echo $equipo; ?></div>
                                <div class="jugador-asignado"><?php echo $jugador; ?></div>
                                <div class="btn-ver-plantilla">Ver plantilla completa</div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Sección Pichichi en la vista general -->
            <div class="seccion-pichichi">
                <h3 class="titulo-pichichi">
                    <span class="trofeo-pichichi">🏆</span>
                    Ranking Pichichi - Máximos Goleadores
                </h3>
                
                <?php if (!empty($_SESSION['pichichi'])): ?>
                    <ul class="lista-pichichi">
                        <?php foreach ($_SESSION['pichichi'] as $index => $goleador): ?>
                            <li>
                                <div class="jugador-pichichi">
                                    <span><?php echo $goleador['jugador']; ?></span>
                                    <span class="equipo-pichichi"><?php echo $goleador['equipo']; ?></span>
                                </div>
                                <div class="goles-pichichi"><?php echo $goleador['goles']; ?> goles</div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="sin-pichichi">
                        No hay goles registrados en el torneo todavía.
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Sección Ranking de Asistencias en la vista general -->
            <div class="seccion-ranking-asistencias">
                <h3 class="titulo-ranking-asistencias">
                    <span class="trofeo-asistencias">🎯</span>
                    Ranking de Asistencias
                </h3>
                
                <?php if (!empty($_SESSION['ranking_asistencias'])): ?>
                    <ul class="lista-asistencias-ranking">
                        <?php foreach ($_SESSION['ranking_asistencias'] as $index => $asistente): ?>
                            <li>
                                <div class="jugador-asistencias">
                                    <span><?php echo $asistente['jugador']; ?></span>
                                    <span class="equipo-asistencias"><?php echo $asistente['equipo']; ?></span>
                                </div>
                                <div class="asistencias-count"><?php echo $asistente['asistencias']; ?> asistencias</div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <div class="sin-asistencias-ranking">
                        No hay asistencias registradas en el torneo todavía.
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="navegacion-inferior">
                <a href="index.php" class="button">🏠 Volver al Inicio</a>
                <?php if (count($_SESSION['jugadores']) >= 8 && empty($equipos_asignados)): ?>
                    <a href="sorteo.php" class="button button-success">🎲 Realizar Sorteo</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>