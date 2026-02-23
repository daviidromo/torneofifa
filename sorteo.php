<?php
require_once 'includes/config.php';

// Verificar que hay jugadores registrados
if (count($_SESSION['jugadores']) < 9) {
    header('Location: jugadores.php');
    exit();
}

// Inicializar asignaciones si no existen
if (!isset($_SESSION['asignaciones'])) {
    $_SESSION['asignaciones'] = [];
}

// Lista de equipos disponibles con sus escudos e himnos (ACTUALIZADA CON LOS 12 EQUIPOS SOLICITADOS)
$equipos_info = [
    'Real Madrid' => [
        'escudo' => 'img/equipos/real_madrid.png',
        'himno' => 'himnos/real_madrid.mp3'
    ],
    'Serie A' => [
        'escudo' => 'img/equipos/barcelona.png',
        'himno' => 'himnos/barcelona.mp3'
    ],
    'Bayer de Munich' => [
        'escudo' => 'img/equipos/bayern_munich.png',
        'himno' => 'himnos/bayern_munich.mp3'
    ],
    'La liga' => [
        'escudo' => 'img/equipos/psg.png',
        'himno' => 'himnos/psg.mp3'
    ],
    'Liverpool' => [
        'escudo' => 'img/equipos/liverpool.png',
        'himno' => 'himnos/liverpool.mp3'
    ],
    'Juventus' => [
        'escudo' => 'img/equipos/manchester_city.png',
        'himno' => 'himnos/manchester_city.mp3'
    ],
    'Premier' => [
        'escudo' => 'img/equipos/arsenal.png',
        'himno' => 'himnos/arsenal.mp3'
    ],
    'Bundesliga' => [
        'escudo' => 'img/equipos/atletico_madrid.png',
        'himno' => 'himnos/atletico.mp3'
    ],
    'Chealsea' => [
        'escudo' => 'img/equipos/chelsea.png',
        'himno' => 'himnos/chealsea.mp3'
    ],
    'Ligue 1' => [
        'escudo' => 'img/equipos/inter_milan.png',
        'himno' => 'himnos/inter_milan.mp3'
    ],
    
];
/*
    'Borussia Dormunt' => [
        'escudo' => 'img/equipos/borussia_dortmund.png',
        'himno' => 'himnos/borussia_dortmund.mp3'
    ],
    'NewCastle' => [
        'escudo' => 'img/equipos/newcastle.png',
        'himno' => 'himnos/newcastle.mp3'
    ]*/

$equipos = array_keys($equipos_info);

// REINICIAR SORTEO - NUEVA LÓGICA AÑADIDA
if (isset($_POST['reiniciar_sorteo'])) {
    $_SESSION['asignaciones'] = [];
    unset($_SESSION['sorteo_actual']);
    header('Location: sorteo.php');
    exit();
}

// Equipos disponibles (excluir los ya asignados)
$equipos_disponibles = array_diff($equipos, array_column($_SESSION['asignaciones'], 'equipo'));

// Si se inicia el sorteo
if (isset($_POST['iniciar_sorteo']) && count($equipos_disponibles) > 0 && count($_SESSION['asignaciones']) < 9) {
    $jugadores_sin_equipo = array_diff($_SESSION['jugadores'], array_column($_SESSION['asignaciones'], 'jugador'));
    // MEZCLAR LOS JUGADORES PARA ORDEN ALEATORIO
    shuffle($jugadores_sin_equipo);
    
    $jugador_actual = array_shift($jugadores_sin_equipo);
    
    $_SESSION['sorteo_actual'] = [
        'jugador' => $jugador_actual,
        'equipo' => null,
        'estado' => 'mostrando_jugador'
    ];
}

// Si estamos en medio de un sorteo
if (isset($_SESSION['sorteo_actual'])) {
    // Después de 5 segundos, asignar equipo
    if ($_SESSION['sorteo_actual']['estado'] == 'mostrando_jugador' && isset($_POST['mostrar_equipo'])) {
        
        // Convertir a array indexado numéricamente
        $equipos_disponibles_array = array_values($equipos_disponibles);
        
        // Verificación exhaustiva
        if (empty($equipos_disponibles_array)) {
            // Log del error para debugging
            error_log("ERROR: No hay equipos disponibles. Asignaciones actuales: " . 
                     json_encode($_SESSION['asignaciones']));
            
            // Asignar un equipo por defecto o manejar el error
            $equipo_asignado = "Equipo Por Definir";
        } else {
            // Selección segura del equipo
            $random_key = array_rand($equipos_disponibles_array);
            $equipo_asignado = $equipos_disponibles_array[$random_key];
            
            // Verificación final
            if (empty($equipo_asignado)) {
                $equipo_asignado = "Equipo Por Definir";
            }
        }
        
        $_SESSION['sorteo_actual']['equipo'] = $equipo_asignado;
        $_SESSION['sorteo_actual']['estado'] = 'mostrando_equipo';
        
        // Guardar la asignación
        $_SESSION['asignaciones'][] = [
            'jugador' => $_SESSION['sorteo_actual']['jugador'],
            'equipo' => $equipo_asignado
        ];
    }

    
    // Continuar al siguiente jugador
    if (isset($_POST['continuar'])) {
        unset($_SESSION['sorteo_actual']);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorteo - Torneo FIFA 26</title>
    
    <style>
/* ===== VARIABLES Y ESTILOS BASE ===== */
:root {
    --primary-color: #1a1a2e;
    --secondary-color: #16213e;
    --accent-color: #0f3460;
    --highlight-color: #e94560;
    --success-color: #4CAF50;
    --danger-color: #e74c3c;
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
    --gradient-gold: linear-gradient(135deg, #ffd700, #ffa500, #ff8c00);
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
    overflow-x: hidden;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* ===== BOTONES GENERALES ===== */
.button {
    display: inline-block;
    padding: 15px 30px;
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
    font-size: 1.1rem;
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

/* ===== ESTADO INICIAL DEL SORTEO ===== */
.sorteo-inicio {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 60px 40px;
    text-align: center;
    box-shadow: var(--box-shadow);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    overflow: hidden;
}

.sorteo-inicio::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: 
        radial-gradient(circle at 20% 80%, rgba(233, 69, 96, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(15, 52, 96, 0.1) 0%, transparent 50%);
    z-index: -1;
}

.sorteo-info h2 {
    font-size: 3rem;
    margin-bottom: 15px;
    background: linear-gradient(to right, var(--text-color), var(--highlight-color));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    text-shadow: 0 0 10px rgba(233, 69, 96, 0.3);
}

.sorteo-info p {
    font-size: 1.3rem;
    color: var(--text-secondary);
    margin-bottom: 30px;
}

.estado-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin: 30px auto;
}

.estado-item {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 20px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: var(--transition);
}

.estado-item:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.1);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
}

.estado-item span {
    display: block;
    color: var(--text-secondary);
    margin-bottom: 8px;
    font-size: 0.9rem;
}

.estado-item strong {
    display: block;
    font-size: 1.5rem;
    color: var(--highlight-color);
}

.sorteo-acciones {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 40px;
}

/* ===== ETAPA DE JUGADOR ===== */
.sorteo-epico {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 40px;
    box-shadow: var(--box-shadow);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.sorteo-epico::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: 
        radial-gradient(circle at 30% 30%, rgba(255, 215, 0, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 70% 70%, rgba(233, 69, 96, 0.1) 0%, transparent 50%);
    z-index: -1;
}

.etapa-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.etapa-header h3 {
    font-size: 1.8rem;
    color: var(--highlight-color);
}

.contador {
    background: var(--gradient-accent);
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: bold;
    font-size: 1.1rem;
}

.jugador-destacado {
    margin-bottom: 40px;
}

.nombre-jugador-grande {
    font-size: 3.5rem;
    font-weight: bold;
    margin-bottom: 20px;
    background: linear-gradient(to right, var(--text-color), var(--highlight-color));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    text-shadow: 0 0 10px rgba(233, 69, 96, 0.3);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.mensaje-espera {
    font-size: 1.3rem;
    color: var(--text-secondary);
}

.contador-tiempo {
    margin-top: 30px;
}

.timer {
    font-size: 2rem;
    font-weight: bold;
    color: var(--highlight-color);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.segundos {
    font-size: 3rem;
    color: var(--gold-color);
    text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
}

/* ===== PANTALLA COMPLETA DEL EQUIPO ===== */
.pantalla-completa-equipo {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--gradient-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.contenido-equipo-destacado {
    text-align: center;
    padding: 40px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    max-width: 800px;
    width: 90%;
    animation: zoomIn 0.8s ease;
}

@keyframes zoomIn {
    from { transform: scale(0.8); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.equipo-gigante {
    margin-bottom: 30px;
}

.escudo-equipo {
    width: 200px;
    height: 200px;
    margin: 0 auto 20px;
    display: block;
    object-fit: contain;
    animation: escudoReveal 1s ease;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    padding: 15px;
    box-shadow: 0 0 30px rgba(255, 215, 0, 0.5);
}

@keyframes escudoReveal {
    0% { 
        transform: scale(0) rotate(-180deg);
        opacity: 0;
    }
    50% { 
        transform: scale(1.2) rotate(10deg);
        opacity: 1;
    }
    100% { 
        transform: scale(1) rotate(0deg);
        opacity: 1;
    }
}

.nombre-equipo-gigante {
    font-size: 4rem;
    font-weight: bold;
    margin-bottom: 20px;
    background: var(--gradient-gold);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    text-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
    animation: teamReveal 1.5s ease;
}

@keyframes teamReveal {
    0% { 
        transform: scale(0.5) rotate(-10deg);
        opacity: 0;
    }
    50% { 
        transform: scale(1.1) rotate(5deg);
        opacity: 1;
    }
    100% { 
        transform: scale(1) rotate(0deg);
        opacity: 1;
    }
}

.info-jugador-equipo {
    margin-bottom: 40px;
    font-size: 1.5rem;
}

.texto-jugador {
    color: var(--text-secondary);
}

.nombre-jugador-equipo {
    font-weight: bold;
    color: var(--highlight-color);
}

.boton-continuar-equipo {
    margin-top: 30px;
}

.button-gigante {
    background: var(--gradient-accent);
    color: white;
    border: none;
    padding: 20px 40px;
    border-radius: var(--border-radius);
    font-size: 1.5rem;
    font-weight: bold;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 10px 20px rgba(233, 69, 96, 0.3);
}

.button-gigante:hover {
    transform: scale(1.05);
    box-shadow: 0 15px 30px rgba(233, 69, 96, 0.5);
}

/* ===== SORTEO COMPLETADO ===== */
.sorteo-completado {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 40px;
    box-shadow: var(--box-shadow);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.completado-header {
    text-align: center;
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.completado-header h2 {
    font-size: 2.5rem;
    margin-bottom: 10px;
    background: linear-gradient(to right, var(--success-color), var(--gold-color));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    text-shadow: 0 0 10px rgba(76, 175, 80, 0.3);
}

.completado-header p {
    font-size: 1.3rem;
    color: var(--text-secondary);
}

.resultados-sorteo {
    margin-bottom: 40px;
}

.resultados-sorteo h3 {
    font-size: 1.8rem;
    margin-bottom: 25px;
    text-align: center;
    color: var(--highlight-color);
}

.lista-asignaciones {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 15px;
}

.asignacion-item {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: var(--transition);
}

.asignacion-item:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.1);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
}

.jugador-info {
    font-weight: bold;
    color: var(--text-color);
}

.separador {
    width: 2px;
    height: 30px;
    background: var(--highlight-color);
    margin: 0 15px;
}

.equipo-info {
    font-weight: bold;
    color: var(--gold-color);
}

.escudo-lista {
    width: 40px;
    height: 40px;
    object-fit: contain;
    margin-right: 10px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    padding: 5px;
}

.acciones-finales {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

/* ===== EFECTOS ESPECIALES ===== */
.confetti {
    position: fixed;
    width: 10px;
    height: 10px;
    background: var(--gold-color);
    opacity: 0;
    z-index: 9999;
    animation: confettiFall 5s ease-in-out forwards;
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

/* ===== CONTROL DE MÚSICA ===== */
.control-musica {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1001;
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(0, 0, 0, 0.7);
    padding: 10px 15px;
    border-radius: 50px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.boton-musica {
    background: none;
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    transition: var(--transition);
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
}

.boton-musica:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.1);
}

.volumen-container {
    display: flex;
    align-items: center;
    gap: 8px;
}

.volumen-slider {
    width: 80px;
    -webkit-appearance: none;
    height: 5px;
    border-radius: 5px;
    background: rgba(255, 255, 255, 0.2);
    outline: none;
}

.volumen-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    background: var(--highlight-color);
    cursor: pointer;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .sorteo-inicio, .sorteo-epico, .sorteo-completado {
        padding: 30px 20px;
    }
    
    .sorteo-info h2 {
        font-size: 2.2rem;
    }
    
    .nombre-jugador-grande {
        font-size: 2.5rem;
    }
    
    .nombre-equipo-gigante {
        font-size: 2.5rem;
    }
    
    .escudo-equipo {
        width: 150px;
        height: 150px;
    }
    
    .estado-grid {
        grid-template-columns: 1fr;
    }
    
    .sorteo-acciones, .acciones-finales {
        flex-direction: column;
        align-items: center;
    }
    
    .button {
        width: 100%;
        max-width: 300px;
        margin-bottom: 10px;
    }
    
    .lista-asignaciones {
        grid-template-columns: 1fr;
    }
    
    .asignacion-item {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
    
    .separador {
        width: 50px;
        height: 2px;
        margin: 5px 0;
    }
    
    .control-musica {
        top: 10px;
        right: 10px;
        padding: 8px 12px;
    }
    
    .volumen-slider {
        width: 60px;
    }
}

@media (max-width: 480px) {
    .sorteo-info h2 {
        font-size: 1.8rem;
    }
    
    .nombre-jugador-grande {
        font-size: 2rem;
    }
    
    .nombre-equipo-gigante {
        font-size: 2rem;
    }
    
    .escudo-equipo {
        width: 120px;
        height: 120px;
    }
    
    .etapa-header {
        flex-direction: column;
        gap: 15px;
    }
    
    .control-musica {
        flex-direction: column;
        gap: 8px;
        padding: 10px;
    }
}

/* Efectos de brillo adicionales */
.sorteo-epico::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: rotate 10s linear infinite;
    z-index: -1;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>

<script>
// Variables globales para control de audio
let musicaFondo = null;
let himnoActual = null;
let volumenFondo = 0.5;

// Función para inicializar la música de fondo
function inicializarMusicaFondo() {
    // Crear elemento de audio para la música épica
    musicaFondo = new Audio('himnos/epica_sorteo.mp3'); // Asegúrate de tener este archivo
    musicaFondo.loop = true;
    musicaFondo.volume = volumenFondo;
    
    // Intentar reproducir automáticamente (puede requerir interacción del usuario)
    musicaFondo.play().catch(e => {
        console.log('La reproducción automática fue bloqueada. El usuario debe interactuar primero.');
    });
}

// Función para pausar la música de fondo
function pausarMusicaFondo() {
    if (musicaFondo) {
        musicaFondo.pause();
    }
}

// Función para reanudar la música de fondo
function reanudarMusicaFondo() {
    if (musicaFondo) {
        musicaFondo.play().catch(e => console.log('Error al reanudar música:', e));
    }
}

// Función para cambiar el volumen de la música de fondo
function cambiarVolumenFondo(nuevoVolumen) {
    volumenFondo = nuevoVolumen;
    if (musicaFondo) {
        musicaFondo.volume = nuevoVolumen;
    }
    
    // Guardar preferencia de volumen
    localStorage.setItem('volumenSorteo', nuevoVolumen);
}

// Función para crear efecto de confeti
function crearConfeti() {
    const colores = ['#e94560', '#ffd700', '#4CAF50', '#0f3460', '#ffffff'];
    for (let i = 0; i < 100; i++) {
        const confeti = document.createElement('div');
        confeti.className = 'confetti';
        confeti.style.left = Math.random() * 100 + 'vw';
        confeti.style.background = colores[Math.floor(Math.random() * colores.length)];
        confeti.style.animationDelay = Math.random() * 5 + 's';
        confeti.style.width = Math.random() * 10 + 5 + 'px';
        confeti.style.height = Math.random() * 10 + 5 + 'px';
        document.body.appendChild(confeti);
        
        // Remover confeti después de la animación
        setTimeout(() => {
            confeti.remove();
        }, 5000);
    }
}

// Función para reproducir himno del equipo (pausando la música de fondo)
function reproducirHimno(equipo) {
    // Pausar música de fondo
    pausarMusicaFondo();
    
    // Detener himno anterior si existe
    if (himnoActual) {
        himnoActual.pause();
        himnoActual = null;
    }
    
    const himnos = {
        'Real Madrid': 'himnos/real_madrid.mp3',
        'Barcelona': 'himnos/barcelona.mp3',
        'Bayern de Munich': 'himnos/bayern_munich.mp3',
        'Paris Saint-Germain': 'himnos/psg.mp3',
        'Liverpool': 'himnos/liverpool.mp3',
        'Manchester City': 'himnos/manchester_city.mp3',
        'Arsenal': 'himnos/arsenal.mp3',
        'Atletico de Madrid': 'himnos/atletico.mp3',
        'Chealsea': 'himnos/chealsea.mp3',
        'Inter de Milán': 'himnos/inter_milan.mp3',
        'Borussia Dormunt': 'himnos/borussia-dortmund.mp3',
        'NewCastle': 'himnos/newcastle.mp3'
    };
    
    if (himnos[equipo]) {
        himnoActual = new Audio(himnos[equipo]);
        himnoActual.volume = 0.7;
        himnoActual.play().catch(e => console.log('Error reproduciendo himno:', e));
        
        // Cuando termine el himno, reanudar la música de fondo
        himnoActual.onended = function() {
            reanudarMusicaFondo();
            himnoActual = null;
        };
    } else {
        // Si no hay himno para el equipo, reanudar música de fondo
        reanudarMusicaFondo();
    }
}

// Función para alternar música (play/pause)
function alternarMusica() {
    if (musicaFondo) {
        if (musicaFondo.paused) {
            reanudarMusicaFondo();
            document.getElementById('botonPlayPause').textContent = '⏸️';
        } else {
            pausarMusicaFondo();
            document.getElementById('botonPlayPause').textContent = '▶️';
        }
    }
}

// Cargar configuración al iniciar
document.addEventListener('DOMContentLoaded', function() {
    // Cargar volumen guardado
    const volumenGuardado = localStorage.getItem('volumenSorteo');
    if (volumenGuardado) {
        volumenFondo = parseFloat(volumenGuardado);
        document.getElementById('volumenSlider').value = volumenFondo * 100;
    }
    
    // Inicializar música de fondo (excepto en pantalla de equipo)
    if (!document.querySelector('.pantalla-completa-equipo')) {
        inicializarMusicaFondo();
    }
    
    // Configurar evento para el slider de volumen
    document.getElementById('volumenSlider').addEventListener('input', function() {
        const nuevoVolumen = this.value / 100;
        cambiarVolumenFondo(nuevoVolumen);
    });
    
    // Si estamos en la pantalla de equipo, lanzar confeti y reproducir himno
    if (document.querySelector('.pantalla-completa-equipo')) {
        crearConfeti();
        const equipoElement = document.querySelector('.nombre-equipo-gigante');
        if (equipoElement) {
            const equipo = equipoElement.textContent.trim();
            reproducirHimno(equipo);
        }
    }
    
    // Configurar botón de play/pause
    document.getElementById('botonPlayPause').addEventListener('click', alternarMusica);
});
</script>
</head>
<body>
    <!-- Control de música -->
    <div class="control-musica">
        <button id="botonPlayPause" class="boton-musica">⏸️</button>
        <div class="volumen-container">
            <span>🔊</span>
            <input type="range" id="volumenSlider" class="volumen-slider" min="0" max="100" value="50">
        </div>
    </div>

    <div class="container">
        <div class="page-content">
            <?php if (!isset($_SESSION['sorteo_actual']) && count($_SESSION['asignaciones']) < 9): ?>
                <!-- Estado inicial -->
                <div class="sorteo-inicio" style="text-align: center; padding: 60px 40px;">
                    <div class="sorteo-info">
                        <h2>¡Sorteo de Equipos!</h2>
                        <p>Asigna aleatoriamente los equipos a los 9 jugadores</p>
                        <div class="estado-grid" style="max-width: 400px; margin: 30px auto;">
                            <div class="estado-item">
                                <span>Jugadores listos:</span>
                                <strong><?php echo count($_SESSION['jugadores']); ?> de 9</strong>
                            </div>
                            <div class="estado-item">
                                <span>Equipos asignados:</span>
                                <strong><?php echo count($_SESSION['asignaciones']); ?> de 9</strong>
                            </div>
                            
                        </div>
                    </div>
                    <div class="sorteo-acciones">
                        <form method="POST">
                            <button type="submit" name="iniciar_sorteo" class="button button-success" 
                                    <?php echo count($_SESSION['jugadores']) < 9 ? 'disabled' : ''; ?>>
                                🎲 Iniciar Sorteo Épico
                            </button>
                        </form>
                        <a href="index.php" class="button">🏠 Volver al Inicio</a>
                    </div>
                </div>
                
            <?php elseif (isset($_SESSION['sorteo_actual']) && $_SESSION['sorteo_actual']['estado'] == 'mostrando_jugador'): ?>
                <!-- Mostrando jugador -->
                <div class="sorteo-epico">
                    <div class="etapa-jugador">
                        <div class="etapa-header">
                            <h3>Jugador Actual</h3>
                            <div class="contador"><?php echo count($_SESSION['asignaciones']) + 1; ?>/9</div>
                        </div>
                        
                        <div class="jugador-destacado">
                            <div class="nombre-jugador-grande">
                                <?php echo $_SESSION['sorteo_actual']['jugador']; ?>
                            </div>
                            <div class="mensaje-espera">
                                Preparando el equipo asignado...
                            </div>
                        </div>
                        
                        <div class="contador-tiempo">
                            <div class="timer">
                                <span class="segundos">10</span> segundos
                            </div>
                        </div>
                    </div>
                </div>
                
                <script>
                // Contador automático para mostrar el equipo después de 5 segundos (ajustable según tus necesidades)
                setTimeout(function() {
                    document.getElementById('formMostrarEquipo').submit();
                }, 5);
                
                // Animación del contador
                let segundos = 10;
                setInterval(function() {
                    segundos--;
                    if (segundos >= 0) {
                        document.querySelector('.segundos').textContent = segundos;
                    }
                }, 1000);
                </script>
                
                <form id="formMostrarEquipo" method="POST" style="display: none;">
                    <input type="hidden" name="mostrar_equipo" value="1">
                </form>
                
            <?php elseif (isset($_SESSION['sorteo_actual']) && $_SESSION['sorteo_actual']['estado'] == 'mostrando_equipo'): ?>
                <!-- Mostrando equipo en pantalla completa -->
                <?php 
                $equipo_actual = $_SESSION['sorteo_actual']['equipo'];
                $escudo = isset($equipos_info[$equipo_actual]['escudo']) ? $equipos_info[$equipo_actual]['escudo'] : 'img/equipos/default.png';
                ?>
                <div class="pantalla-completa-equipo" id="pantallaEquipo" style="display: flex;">
                    <div class="contenido-equipo-destacado">
                        <div class="equipo-gigante">
                            <img class="escudo-equipo" src="<?php echo $escudo; ?>" alt="Escudo de <?php echo $equipo_actual; ?>">
                            <div class="nombre-equipo-gigante">
                                <?php echo $equipo_actual; ?>
                            </div>
                        </div>
                        
                        <div class="info-jugador-equipo">
                            <span class="texto-jugador"></span>
                            <span class="nombre-jugador-equipo"><?php echo $_SESSION['sorteo_actual']['jugador']; ?></span>
                        </div>
                        
                        <div class="boton-continuar-equipo">
                            <form method="POST">
                                <button type="submit" name="continuar" class="button-gigante">
                                    ⚽ Continuar Sorteo
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <script>
                // Mostrar pantalla completa del equipo
                document.getElementById('pantallaEquipo').style.display = 'flex';
                
                // Reproducir himno del equipo (automáticamente pausa la música de fondo)
                const equipo = "<?php echo $equipo_actual; ?>";
                reproducirHimno(equipo);
                </script>
                
            <?php else: ?>
                <!-- Sorteo completado -->
                <div class="sorteo-completado">
                    <div class="completado-header">
                        <h2 style="color: #27ae60;">¡Sorteo Completado! 🏆</h2>
                        <p>Todos los equipos han sido asignados</p>
                    </div>
                    
                    <div class="resultados-sorteo">
                        <h3>Asignaciones Finales</h3>
                        <div class="lista-asignaciones">
                            <?php foreach ($_SESSION['asignaciones'] as $asignacion): 
                                $escudo = isset($equipos_info[$asignacion['equipo']]['escudo']) ? $equipos_info[$asignacion['equipo']]['escudo'] : 'img/equipos/default.png';
                            ?>
                                <div class="asignacion-item">
                                    <span class="jugador-info"><?php echo $asignacion['jugador']; ?></span>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <img src="<?php echo $escudo; ?>" alt="Escudo" class="escudo-lista">
                                        <span class="equipo-info"><?php echo $asignacion['equipo']; ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="acciones-finales">
                        <a href="index.php" class="button">🏠 Volver al Inicio</a>
                        <a href="grupos.php" class="button button-success">📊 Ver Grupos</a>
                        <form method="POST">
                            <button type="submit" name="reiniciar_sorteo" class="button button-danger" 
                                    onclick="return confirm('¿Estás seguro de que quieres reiniciar el sorteo? Se perderán todas las asignaciones.')">
                                🔄 Reiniciar Sorteo
                            </button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>