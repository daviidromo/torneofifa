<?php
require_once 'includes/config.php';
session_start();

// Datos de las marcas/sponsors
$marcas_sponsors = [
    'KITKAT' => [
        'logo' => 'img/sponsors/kitkat.png',
        'color' => '#D62327',
        'color_secundario' => '#FFFFFF',
        'eslogan_victoria' => 'Te veo muy cansado de correr detrás de mi balón... ¡tómate un respiro, tómate un KitKat, y deja de hacer el melón!',
        'eslogan_derrota' => 'Nos hemos dormido un poco en los laureles... ¡es que nos hemos tomado un respiro con KitKat, no te me rebeles!',
        'icono' => '🍫',
        'descripcion' => 'El chocolate que te da un break'
    ],
    'ORAL-B' => [
        'logo' => 'img/sponsors/oralb.png',
        'color' => '#00A79D',
        'color_secundario' => '#FFFFFF',
        'eslogan_victoria' => 'Te has quedado con la boca abierta viendo mi jugada... ¡usa Oral-B, que tienes la dentadura desencajada!',
        'eslogan_derrota' => 'Nos han partido la cara y ha sido una tortura... ¡pero con Oral-B mantendremos fresca la frescura!',
        'icono' => '🦷',
        'descripcion' => 'Sonrisas más sanas, resultados más brillantes'
    ],
    'TELEPIZZA' => [
        'logo' => 'img/sponsors/telepizza.png',
        'color' => '#E31837',
        'color_secundario' => '#FFD700',
        'eslogan_victoria' => 'El secreto está en la masa... ¡y el secreto de hoy es la PALIZA de Telepizza que te llevas a casa!',
        'eslogan_derrota' => 'El pedido nos ha llegado frío hoy... ¡pero os juro que Telepizza traerá la revancha caliente!',
        'icono' => '🍕',
        'descripcion' => 'La pizza que llega a tu cancha'
    ],
    'REXONA' => [
        'logo' => 'img/sponsors/rexona.png',
        'color' => '#0072CE',
        'color_secundario' => '#FFFFFF',
        'eslogan_victoria' => 'A ti te huele el sobaquillo... ¡pero a mí Rexona NO me abandona ni en el banquillo!',
        'eslogan_derrota' => 'Hemos sudado tinta china... ¡pero tranquilos que Rexona nos protegerá de la ruina!',
        'icono' => '💧',
        'descripcion' => 'Protección que no te abandona'
    ],
    'RED BULL' => [
        'logo' => 'img/sponsors/redbull.png',
        'color' => '#0033A0',
        'color_secundario' => '#ED1C24',
        'eslogan_victoria' => 'Tú vas a pedales y yo tengo alas... ¡tómate un Red Bull a ver si me igualas!',
        'eslogan_derrota' => 'Hoy nos hemos estrellado contra el suelo... ¡pero Red Bull nos dará energía para alzar el vuelo!',
        'icono' => '🐂',
        'descripcion' => 'Te da alas'
    ],
    'MASTERCARD' => [
        'logo' => 'img/sponsors/mastercard.png',
        'color' => '#EB001B',
        'color_secundario' => '#F79E1B',
        'eslogan_victoria' => 'Ver tu cara de paquete no tiene precio... ¡para todo lo demás, existe Mastercard!',
        'eslogan_derrota' => 'Hoy no hemos dado crédito en el campo... ¡pero con Mastercard financiaremos el próximo adelanto!',
        'icono' => '💳',
        'descripcion' => 'Priceless moments on the pitch'
    ],
    'DURACELL' => [
        'logo' => 'img/sponsors/duracell.png',
        'color' => '#FFD700',
        'color_secundario' => '#000000',
        'eslogan_victoria' => 'Tú te has cansado al primer minuto... ¡y yo duro y duro como el conejo de Duracell en bruto!',
        'eslogan_derrota' => 'Se nos han gastado las pilas de correr... ¡pero pondremos Duracell para volver a nacer!',
        'icono' => '🔋',
        'descripcion' => 'La energía que no se agota'
    ],
    'FAIRY' => [
        'logo' => 'img/sponsors/fairy.png',
        'color' => '#00AEEF',
        'color_secundario' => '#FFFFFF',
        'eslogan_victoria' => 'Yo soy el milagro antigrasa... ¡y con una gota de Fairy te he limpiado de mi casa!',
        'eslogan_derrota' => 'Había mucha suciedad en nuestro juego... ¡pero con Fairy frotaremos fuerte para empezar de nuevo!',
        'icono' => '🧼',
        'descripcion' => 'Limpia hasta la suciedad más difícil'
    ]
];

// Datos iniciales de jugadores
$jugadores = [
    "Romo", "Reyes", "Figueroa", "Huevo", 
    "Josete", "Carlos", "Jogi", "Ivanoskyx"
];

// Función para asignar sponsors aleatoriamente
function asignarSponsorsAJugadores($jugadores, $marcas_sponsors) {
    $sponsors = array_keys($marcas_sponsors);
    shuffle($sponsors); // Mezclar los sponsors
    
    $asignaciones = [];
    for ($i = 0; $i < count($jugadores); $i++) {
        $asignaciones[$jugadores[$i]] = [
            'sponsor' => $sponsors[$i],
            'datos' => $marcas_sponsors[$sponsors[$i]]
        ];
    }
    
    return $asignaciones;
}

// Verificar si ya existen asignaciones en sesión, si no, crear nuevas
if (!isset($_SESSION['asignaciones_sponsors']) || isset($_GET['reasignar'])) {
    $_SESSION['asignaciones_sponsors'] = asignarSponsorsAJugadores($jugadores, $marcas_sponsors);
}

$asignaciones = $_SESSION['asignaciones_sponsors'];

// Función para verificar si una imagen existe
function imagenExiste($ruta) {
    return file_exists($ruta) && is_file($ruta);
}

// Obtener marca específica si se pasa por parámetro
$marca_seleccionada = isset($_GET['marca']) ? $_GET['marca'] : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sponsors - Torneo FIFA 26</title>
    <style>
/* ===== VARIABLES Y ESTILOS BASE ===== */
:root {
    --primary-color: #1a1a2e;
    --secondary-color: #16213e;
    --accent-color: #0f3460;
    --highlight-color: #e94560;
    --gold-color: #ffd700;
    --text-color: #ffffff;
    --text-secondary: #b0b0b0;
    --border-radius: 20px;
    --box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
    --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    --gradient-primary: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
    --font-size-gigante: clamp(2.5rem, 5vw, 4.5rem);
    --font-size-muy-grande: clamp(2rem, 4vw, 3.5rem);
    --font-size-grande: clamp(1.8rem, 3.5vw, 2.8rem);
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
    max-width: 1800px;
    margin: 0 auto;
}

/* ===== BOTONES GENERALES ===== */
.button {
    display: inline-flex;
    align-items: center;
    gap: 15px;
    padding: 18px 35px;
    background: linear-gradient(135deg, var(--highlight-color), #ff6b6b);
    color: white;
    border: none;
    border-radius: var(--border-radius);
    text-decoration: none;
    font-weight: bold;
    font-size: 1.4rem;
    cursor: pointer;
    transition: var(--transition);
    backdrop-filter: blur(10px);
    text-align: center;
    box-shadow: 0 12px 30px rgba(233, 69, 96, 0.4);
}

.button:hover {
    transform: translateY(-8px) scale(1.08);
    box-shadow: 0 20px 40px rgba(233, 69, 96, 0.6);
    background: linear-gradient(135deg, #ff6b6b, var(--highlight-color));
}

.button-secondary {
    background: rgba(255, 255, 255, 0.15);
    border: 2px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
}

.button-secondary:hover {
    background: rgba(255, 255, 255, 0.25);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
}

.button-success {
    background: linear-gradient(135deg, #4CAF50, #2E7D32);
    box-shadow: 0 12px 30px rgba(76, 175, 80, 0.4);
}

.button-success:hover {
    background: linear-gradient(135deg, #2E7D32, #4CAF50);
    box-shadow: 0 20px 40px rgba(76, 175, 80, 0.6);
}

.navegacion-inferior {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-top: 60px;
    flex-wrap: wrap;
}

/* ===== ASIGNACIÓN DE SPONSORS A JUGADORES ===== */
.asignacion-sponsors-container {
    background: rgba(255, 255, 255, 0.06);
    border-radius: var(--border-radius);
    padding: 50px;
    box-shadow: var(--box-shadow);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(255, 255, 255, 0.15);
    margin-bottom: 50px;
    animation: fadeInUp 0.8s ease forwards;
}

.header-asignacion {
    text-align: center;
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 3px solid rgba(255, 255, 255, 0.15);
    position: relative;
}

.header-asignacion::after {
    content: '';
    position: absolute;
    bottom: -3px;
    left: 50%;
    transform: translateX(-50%);
    width: 200px;
    height: 5px;
    background: linear-gradient(to right, var(--highlight-color), var(--gold-color));
    border-radius: 5px;
}

.header-asignacion h2 {
    font-size: 2.5rem;
    margin-bottom: 20px;
    background: linear-gradient(to right, var(--text-color), var(--gold-color));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    text-shadow: 0 0 30px rgba(255, 215, 0, 0.4);
    letter-spacing: 2px;
    font-weight: 800;
}

.contador-asignacion {
    font-size: 1.5rem;
    color: var(--text-color);
    background: rgba(255, 255, 255, 0.15);
    padding: 12px 25px;
    border-radius: 35px;
    display: inline-block;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.2);
    font-weight: bold;
}

.grid-asignacion {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.jugador-sponsor-card {
    background: rgba(255, 255, 255, 0.07);
    border-radius: var(--border-radius);
    padding: 30px;
    transition: var(--transition);
    border: 2px solid rgba(255, 255, 255, 0.15);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(15px);
}

.jugador-sponsor-card:hover {
    transform: translateY(-15px) scale(1.03);
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.7);
}

.jugador-info {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 25px;
    width: 100%;
    justify-content: center;
}

.jugador-icono {
    font-size: 3rem;
    background: rgba(255, 255, 255, 0.15);
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid rgba(255, 255, 255, 0.3);
}

.jugador-nombre {
    font-size: 2rem;
    font-weight: 800;
    color: var(--text-color);
    text-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
}

.separador {
    font-size: 2rem;
    color: var(--gold-color);
    margin: 0 20px;
}

.sponsor-asignado {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
    margin-top: 20px;
}

.logo-sponsor-asignado {
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid rgba(255, 255, 255, 0.3);
    transition: var(--transition);
}

.jugador-sponsor-card:hover .logo-sponsor-asignado {
    transform: rotateY(360deg) scale(1.2);
    box-shadow: 0 0 40px rgba(255, 255, 255, 0.4);
}

.logo-sponsor-asignado img {
    max-width: 70%;
    max-height: 70%;
    filter: drop-shadow(0 10px 25px rgba(0, 0, 0, 0.4));
}

.logo-sponsor-asignado .icono-fallback {
    font-size: 3rem;
}

.sponsor-nombre {
    font-size: 1.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
}

.sponsor-descripcion {
    font-size: 1.1rem;
    color: var(--text-secondary);
    margin-top: 10px;
    line-height: 1.5;
    max-width: 300px;
}

.botones-asignacion {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-top: 40px;
    flex-wrap: wrap;
}

/* ===== VISTA DE LISTA DE MARCAS ===== */
.sponsors-container {
    background: rgba(255, 255, 255, 0.06);
    border-radius: var(--border-radius);
    padding: 50px;
    box-shadow: var(--box-shadow);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(255, 255, 255, 0.15);
    margin-bottom: 50px;
}

.header-sponsors {
    text-align: center;
    margin-bottom: 60px;
    padding-bottom: 40px;
    border-bottom: 3px solid rgba(255, 255, 255, 0.15);
    position: relative;
}

.header-sponsors::after {
    content: '';
    position: absolute;
    bottom: -3px;
    left: 50%;
    transform: translateX(-50%);
    width: 250px;
    height: 5px;
    background: linear-gradient(to right, var(--highlight-color), var(--gold-color));
    border-radius: 5px;
}

.header-sponsors h2 {
    font-size: var(--font-size-gigante);
    margin-bottom: 25px;
    background: linear-gradient(to right, var(--text-color), var(--gold-color));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    text-shadow: 0 0 30px rgba(255, 215, 0, 0.4);
    letter-spacing: 2px;
    font-weight: 800;
}

.contador-marcas {
    font-size: 1.8rem;
    color: var(--text-color);
    background: rgba(255, 255, 255, 0.15);
    padding: 15px 30px;
    border-radius: 35px;
    display: inline-block;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.2);
    font-weight: bold;
}

.grid-sponsors {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 40px;
}

.marca-card {
    background: rgba(255, 255, 255, 0.07);
    border-radius: var(--border-radius);
    padding: 35px;
    text-decoration: none;
    color: var(--text-color);
    transition: var(--transition);
    border: 2px solid rgba(255, 255, 255, 0.15);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(15px);
}

.marca-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, transparent, rgba(255, 255, 255, 0.05), transparent);
    z-index: 1;
}

.marca-card:hover {
    transform: translateY(-20px) scale(1.05);
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.7);
    border-color: rgba(255, 255, 255, 0.4);
}

.logo-marca {
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 150px;
    height: 150px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 50%;
    position: relative;
    z-index: 2;
    transition: var(--transition);
    border: 3px solid rgba(255, 255, 255, 0.2);
}

.marca-card:hover .logo-marca {
    transform: rotateY(360deg) scale(1.1);
    box-shadow: 0 0 50px rgba(255, 255, 255, 0.3);
}

.logo-marca img {
    max-width: 85%;
    max-height: 85%;
    filter: drop-shadow(0 10px 25px rgba(0, 0, 0, 0.4));
    transition: var(--transition);
}

.logo-marca .icono-fallback {
    font-size: 4.5rem;
    transition: var(--transition);
}

.marca-card:hover .logo-marca img,
.marca-card:hover .logo-marca .icono-fallback {
    transform: scale(1.3);
}

.nombre-marca {
    font-size: 2.2rem;
    font-weight: 800;
    margin-bottom: 15px;
    color: var(--text-color);
    position: relative;
    z-index: 2;
    text-transform: uppercase;
    letter-spacing: 1.5px;
}

.descripcion-marca {
    font-size: 1.2rem;
    color: var(--text-secondary);
    margin-bottom: 25px;
    position: relative;
    z-index: 2;
    min-height: 50px;
    line-height: 1.5;
}

.btn-ver-esloganes {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.25));
    padding: 15px 30px;
    border-radius: 35px;
    font-size: 1.1rem;
    font-weight: bold;
    transition: var(--transition);
    margin-top: auto;
    position: relative;
    z-index: 2;
    border: 2px solid rgba(255, 255, 255, 0.3);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.marca-card:hover .btn-ver-esloganes {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.25), rgba(255, 255, 255, 0.35));
    transform: scale(1.15);
    box-shadow: 0 10px 25px rgba(255, 255, 255, 0.3);
}

/* ===== VISTA DETALLE DE MARCA ===== */
.detalle-marca-container {
    background: rgba(255, 255, 255, 0.06);
    border-radius: var(--border-radius);
    padding: 60px;
    box-shadow: var(--box-shadow);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(255, 255, 255, 0.15);
}

.header-detalle-marca {
    text-align: center;
    margin-bottom: 80px;
    padding-bottom: 50px;
    border-bottom: 4px solid rgba(255, 255, 255, 0.2);
    position: relative;
}

.header-detalle-marca::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 50%;
    transform: translateX(-50%);
    width: 300px;
    height: 6px;
    background: linear-gradient(to right, var(--highlight-color), var(--gold-color));
    border-radius: 6px;
}

.logo-detalle {
    margin-bottom: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.logo-detalle img {
    max-width: 250px;
    max-height: 250px;
    filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.5));
    transition: var(--transition);
}

.logo-detalle .icono-fallback {
    font-size: 8rem;
    transition: var(--transition);
}

.nombre-marca-detalle {
    font-size: var(--font-size-gigante);
    margin-bottom: 20px;
    font-weight: 900;
    text-shadow: 0 0 40px rgba(255, 255, 255, 0.3);
    position: relative;
    letter-spacing: 3px;
}

/* ===== ESLÓGANES GIGANTES ===== */
.esloganes-container {
    display: grid;
    grid-template-columns: 1fr;
    gap: 60px;
    margin-bottom: 80px;
}

.eslogan-card {
    background: rgba(255, 255, 255, 0.08);
    border-radius: var(--border-radius);
    padding: 60px;
    border: 3px solid rgba(255, 255, 255, 0.2);
    position: relative;
    overflow: hidden;
    transition: var(--transition);
    display: flex;
    flex-direction: column;
    min-height: 450px;
}

.eslogan-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 10px;
    background: linear-gradient(to right, var(--highlight-color), var(--gold-color));
}

.eslogan-card:hover {
    transform: translateY(-15px) scale(1.02);
    box-shadow: 0 40px 80px rgba(0, 0, 0, 0.5);
    background: rgba(255, 255, 255, 0.12);
}

.eslogan-card.victoria {
    border-top-color: rgba(76, 175, 80, 0.7);
}

.eslogan-card.derrota {
    border-top-color: rgba(231, 76, 60, 0.7);
}

.eslogan-icono {
    font-size: 4rem;
    margin-bottom: 30px;
    text-align: center;
}

.eslogan-titulo {
    font-size: var(--font-size-muy-grande);
    margin-bottom: 40px;
    text-align: center;
    position: relative;
    padding-bottom: 25px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.eslogan-titulo::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 150px;
    height: 4px;
    background: currentColor;
    opacity: 0.8;
    border-radius: 4px;
}

.eslogan-texto {
    font-size: var(--font-size-grande);
    line-height: 1.7;
    text-align: center;
    color: #ffffff;
    flex-grow: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px;
    background: rgba(0, 0, 0, 0.2);
    border-radius: 25px;
    font-style: italic;
    border: 3px solid rgba(255, 255, 255, 0.1);
    font-weight: 700;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    letter-spacing: 1px;
}

.eslogan-texto::before {
    content: '"';
    font-size: 6rem;
    color: var(--highlight-color);
    opacity: 0.5;
    margin-right: 20px;
    line-height: 0;
    align-self: flex-start;
    margin-top: -20px;
}

.eslogan-texto::after {
    content: '"';
    font-size: 6rem;
    color: var(--highlight-color);
    opacity: 0.5;
    margin-left: 20px;
    line-height: 0;
    align-self: flex-end;
    margin-bottom: -20px;
}

/* ===== INFO ADICIONAL DE LA MARCA ===== */
.info-marca {
    background: rgba(255, 255, 255, 0.08);
    border-radius: var(--border-radius);
    padding: 40px;
    margin-top: 60px;
    border: 2px solid rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    gap: 40px;
}

.info-marca .logo-pequeno {
    flex-shrink: 0;
    width: 120px;
    height: 120px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid rgba(255, 255, 255, 0.3);
}

.info-marca .logo-pequeno img {
    max-width: 70%;
    max-height: 70%;
}

.info-marca .logo-pequeno .icono-fallback {
    font-size: 3rem;
}

.info-texto {
    flex-grow: 1;
}

.info-texto h4 {
    font-size: 2rem;
    margin-bottom: 15px;
    color: var(--text-color);
    font-weight: 800;
}

.info-texto p {
    color: var(--text-secondary);
    line-height: 1.8;
    font-size: 1.3rem;
}

/* ===== ANIMACIONES ===== */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20px);
    }
}

@keyframes pulse {
    0% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.2);
    }
    70% {
        transform: scale(1.1);
        box-shadow: 0 0 0 20px rgba(255, 255, 255, 0);
    }
    100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
    }
}

@keyframes glow {
    0%, 100% {
        text-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
    }
    50% {
        text-shadow: 0 0 40px rgba(255, 255, 255, 0.6);
    }
}

.marca-card, .eslogan-card, .header-sponsors, .jugador-sponsor-card {
    animation: fadeInUp 0.8s ease forwards;
}

.logo-detalle {
    animation: float 8s ease-in-out infinite;
}

.eslogan-card:hover .eslogan-icono {
    animation: pulse 2s infinite;
}

.eslogan-texto {
    animation: glow 4s ease-in-out infinite;
}

/* ===== EFECTOS ESPECIALES ===== */
.efecto-brillante {
    position: relative;
    overflow: hidden;
}

.efecto-brillante::after {
    content: '';
    position: absolute;
    top: -100%;
    left: -100%;
    width: 300%;
    height: 300%;
    background: linear-gradient(
        45deg,
        transparent 30%,
        rgba(255, 255, 255, 0.1) 50%,
        transparent 70%
    );
    transform: rotate(45deg);
    transition: var(--transition);
}

.efecto-brillante:hover::after {
    left: 100%;
}

/* ===== MODO PRESENTACIÓN PARA ESLÓGANES ===== */
.modo-presentacion {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.95);
    z-index: 1000;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px;
}

.modo-presentacion .eslogan-gigante {
    font-size: 5rem;
    line-height: 1.5;
    text-align: center;
    color: white;
    max-width: 1200px;
    font-weight: 900;
    text-shadow: 0 0 30px rgba(255, 255, 255, 0.5);
    animation: glow 3s ease-in-out infinite;
}

.modo-presentacion .marca-presentacion {
    font-size: 3rem;
    color: var(--gold-color);
    margin-top: 40px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 3px;
}

.modo-presentacion .btn-cerrar {
    position: absolute;
    top: 30px;
    right: 30px;
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    font-size: 2.5rem;
    width: 70px;
    height: 70px;
    border-radius: 50%;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modo-presentacion .btn-cerrar:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: rotate(90deg);
}

/* ===== BOTONES PARA MODO PRESENTACIÓN ===== */
.btn-presentacion {
    background: linear-gradient(135deg, #4CAF50, #2E7D32);
    padding: 15px 30px;
    border-radius: 35px;
    font-size: 1.2rem;
    font-weight: bold;
    border: none;
    color: white;
    cursor: pointer;
    transition: var(--transition);
    margin-top: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.btn-presentacion:hover {
    transform: scale(1.1);
    box-shadow: 0 15px 30px rgba(76, 175, 80, 0.4);
}

.btn-presentacion.rojo {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
}

.btn-presentacion.rojo:hover {
    box-shadow: 0 15px 30px rgba(231, 76, 60, 0.4);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 1200px) {
    .grid-sponsors {
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    }
    
    .grid-asignacion {
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    }
    
    .eslogan-texto {
        font-size: 2.2rem;
        padding: 30px;
    }
    
    .eslogan-card {
        padding: 50px;
        min-height: 400px;
    }
}

@media (max-width: 992px) {
    .sponsors-container, .detalle-marca-container, .asignacion-sponsors-container {
        padding: 40px;
    }
    
    .header-sponsors h2 {
        font-size: 3.5rem;
    }
    
    .nombre-marca-detalle {
        font-size: 4rem;
    }
    
    .grid-sponsors {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
    }
    
    .grid-asignacion {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
    }
    
    .eslogan-texto {
        font-size: 2rem;
        padding: 25px;
    }
    
    .eslogan-card {
        padding: 40px;
        min-height: 380px;
    }
    
    .modo-presentacion .eslogan-gigante {
        font-size: 4rem;
    }
}

@media (max-width: 768px) {
    .sponsors-container, .detalle-marca-container, .asignacion-sponsors-container {
        padding: 30px;
    }
    
    .header-sponsors h2 {
        font-size: 3rem;
    }
    
    .nombre-marca-detalle {
        font-size: 3.5rem;
    }
    
    .grid-sponsors {
        grid-template-columns: 1fr;
        gap: 25px;
    }
    
    .grid-asignacion {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .info-marca {
        flex-direction: column;
        text-align: center;
        gap: 30px;
    }
    
    .navegacion-inferior {
        flex-direction: column;
        align-items: center;
    }
    
    .botones-asignacion {
        flex-direction: column;
        align-items: center;
    }
    
    .button {
        width: 100%;
        max-width: 350px;
        justify-content: center;
        font-size: 1.2rem;
        padding: 20px;
    }
    
    .eslogan-card {
        min-height: 350px;
        padding: 30px;
    }
    
    .eslogan-texto {
        font-size: 1.8rem;
        padding: 20px;
    }
    
    .eslogan-titulo {
        font-size: 2.2rem;
    }
    
    .modo-presentacion .eslogan-gigante {
        font-size: 3rem;
    }
    
    .modo-presentacion .marca-presentacion {
        font-size: 2.2rem;
    }
    
    .jugador-info {
        flex-direction: column;
        gap: 15px;
    }
    
    .separador {
        display: none;
    }
}

@media (max-width: 576px) {
    body {
        padding: 15px;
    }
    
    .header-sponsors h2 {
        font-size: 2.5rem;
    }
    
    .nombre-marca-detalle {
        font-size: 2.8rem;
    }
    
    .eslogan-card {
        padding: 25px;
        min-height: 320px;
    }
    
    .eslogan-texto {
        font-size: 1.6rem;
        padding: 20px;
        line-height: 1.6;
    }
    
    .eslogan-titulo {
        font-size: 2rem;
    }
    
    .contador-marcas {
        font-size: 1.4rem;
        padding: 12px 25px;
    }
    
    .logo-marca {
        width: 130px;
        height: 130px;
    }
    
    .nombre-marca {
        font-size: 1.8rem;
    }
    
    .modo-presentacion .eslogan-gigante {
        font-size: 2.2rem;
        line-height: 1.4;
    }
    
    .modo-presentacion .marca-presentacion {
        font-size: 1.8rem;
    }
    
    .modo-presentacion .btn-cerrar {
        width: 60px;
        height: 60px;
        font-size: 2rem;
    }
    
    .jugador-sponsor-card {
        padding: 25px;
    }
    
    .jugador-nombre {
        font-size: 1.8rem;
    }
    
    .sponsor-nombre {
        font-size: 1.6rem;
    }
}

@media (max-width: 400px) {
    .eslogan-texto {
        font-size: 1.4rem;
    }
    
    .eslogan-titulo {
        font-size: 1.8rem;
    }
    
    .modo-presentacion .eslogan-gigante {
        font-size: 1.8rem;
    }
}

/* Fondo con partículas */
body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: 
        radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.04) 3px, transparent 3px),
        radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.03) 3px, transparent 3px),
        radial-gradient(circle at 40% 50%, rgba(255, 215, 0, 0.02) 2px, transparent 2px);
    background-size: 100px 100px, 120px 120px, 140px 140px;
    z-index: -1;
    animation: float 25s ease-in-out infinite;
}

/* Efecto de gradiente dinámico */
@keyframes gradientShift {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

.sponsors-container, .detalle-marca-container, .asignacion-sponsors-container {
    background: linear-gradient(-45deg, 
        rgba(26, 26, 46, 0.85), 
        rgba(22, 33, 62, 0.85), 
        rgba(15, 52, 96, 0.85), 
        rgba(233, 69, 96, 0.15));
    background-size: 400% 400%;
    animation: gradientShift 20s ease infinite;
}

/* Mejoras de contraste y legibilidad */
.eslogan-card.victoria .eslogan-titulo {
    color: #4cff4c;
    text-shadow: 0 0 20px rgba(76, 255, 76, 0.5);
}

.eslogan-card.derrota .eslogan-titulo {
    color: #ff6b6b;
    text-shadow: 0 0 20px rgba(255, 107, 107, 0.5);
}

/* Mejora de contraste para texto */
.eslogan-texto {
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6));
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* Estilo para el icono de jugador */
.jugador-icono {
    background: linear-gradient(135deg, rgba(233, 69, 96, 0.3), rgba(15, 52, 96, 0.3));
}
</style>
<!-- Iconos de Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <?php if ($marca_seleccionada && array_key_exists($marca_seleccionada, $marcas_sponsors)): ?>
            <!-- Mostrar detalle de la marca específica -->
            <?php $marca = $marcas_sponsors[$marca_seleccionada]; ?>
            
            <div class="detalle-marca-container">
                <div class="header-detalle-marca">
                    <div class="logo-detalle">
                        <?php if (isset($marca['logo']) && imagenExiste($marca['logo'])): ?>
                            <img src="<?php echo $marca['logo']; ?>" 
                                 alt="<?php echo $marca_seleccionada; ?>" 
                                 style="filter: drop-shadow(0 15px 30px rgba(0,0,0,0.6));">
                        <?php else: ?>
                            <div class="icono-fallback" style="font-size: 8rem; color: <?php echo $marca['color']; ?>;">
                                <?php echo $marca['icono']; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <h1 class="nombre-marca-detalle" style="color: <?php echo $marca['color']; ?>; text-shadow: 0 0 30px <?php echo $marca['color']; ?>80;">
                        <?php echo $marca_seleccionada; ?>
                    </h1>
                    <p style="color: var(--text-color); font-size: 1.8rem; max-width: 800px; margin: 0 auto; font-weight: 600; opacity: 0.9;">
                        <?php echo $marca['descripcion']; ?>
                    </p>
                </div>
                
                <div class="esloganes-container">
                    <!-- Eslogan Victoria -->
                    <div class="eslogan-card victoria efecto-brillante">
                        <div class="eslogan-icono" style="color: #4cff4c;">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <h3 class="eslogan-titulo" style="color: #4cff4c;">
                            <i class="fas fa-crown"></i> Eslogan para la VICTORIA
                        </h3>
                        <div class="eslogan-texto">
                            <?php echo $marca['eslogan_victoria']; ?>
                        </div>
                        <button class="btn-presentacion" onclick="mostrarPresentacion('<?php echo addslashes($marca['eslogan_victoria']); ?>', '<?php echo $marca_seleccionada; ?>')">
                            <i class="fas fa-expand"></i> Ver en pantalla completa
                        </button>
                    </div>
                    
                    <!-- Eslogan Derrota -->
                    <div class="eslogan-card derrota efecto-brillante">
                        <div class="eslogan-icono" style="color: #ff6b6b;">
                            <i class="fas fa-redo"></i>
                        </div>
                        <h3 class="eslogan-titulo" style="color: #ff6b6b;">
                            <i class="fas fa-heart-broken"></i> Eslogan para la DERROTA
                        </h3>
                        <div class="eslogan-texto">
                            <?php echo $marca['eslogan_derrota']; ?>
                        </div>
                        <button class="btn-presentacion rojo" onclick="mostrarPresentacion('<?php echo addslashes($marca['eslogan_derrota']); ?>', '<?php echo $marca_seleccionada; ?>')">
                            <i class="fas fa-expand"></i> Ver en pantalla completa
                        </button>
                    </div>
                </div>
                
                <div class="info-marca">
                    <div class="logo-pequeno" style="background: <?php echo $marca['color']; ?>40; border-color: <?php echo $marca['color']; ?>;">
                        <?php if (isset($marca['logo']) && imagenExiste($marca['logo'])): ?>
                            <img src="<?php echo $marca['logo']; ?>" alt="<?php echo $marca_seleccionada; ?>">
                        <?php else: ?>
                            <div class="icono-fallback" style="color: <?php echo $marca['color']; ?>;">
                                <?php echo $marca['icono']; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="info-texto">
                        <h4>Patrocinador Oficial del Torneo FIFA 26</h4>
                        <p><?php echo $marca_seleccionada; ?> es uno de los sponsors oficiales del Torneo FIFA 26. 
                        Sus creativos eslóganes se utilizarán para celebrar victorias y motivar en las derrotas durante todo el torneo. 
                        <strong>¡Disfruta de sus mensajes en grande!</strong></p>
                    </div>
                </div>
            </div>
            
            <div class="navegacion-inferior">
                <a href="sponsors.php" class="button button-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Volver a Sponsors
                </a>
                <a href="index.php" class="button">
                    <i class="fas fa-home"></i>
                    Volver al Inicio
                </a>
            </div>
            
        <?php else: ?>
            <!-- Mostrar sección de asignación de sponsors a jugadores -->
            <div class="asignacion-sponsors-container">
                <div class="header-asignacion">
                    <h2>Asignación de Sponsors a Jugadores</h2>
                    <div class="contador-asignacion">
                        <?php echo count($asignaciones); ?> Jugadores con Sponsors Asignados
                    </div>
                </div>
                
                <div class="grid-asignacion">
                    <?php foreach ($asignaciones as $jugador => $asignacion): ?>
                        <div class="jugador-sponsor-card efecto-brillante" 
                             style="border-color: <?php echo $asignacion['datos']['color']; ?>50;">
                            <div class="jugador-info">
                                <div class="jugador-icono">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="separador">➡</div>
                                <div class="logo-sponsor-asignado" 
                                     style="background: linear-gradient(135deg, 
                                            <?php echo $asignacion['datos']['color']; ?>40, 
                                            rgba(255,255,255,0.15)); 
                                            border-color: <?php echo $asignacion['datos']['color']; ?>70;">
                                    <?php if (isset($asignacion['datos']['logo']) && imagenExiste($asignacion['datos']['logo'])): ?>
                                        <img src="<?php echo $asignacion['datos']['logo']; ?>" alt="<?php echo $asignacion['sponsor']; ?>">
                                    <?php else: ?>
                                        <div class="icono-fallback" style="color: <?php echo $asignacion['datos']['color']; ?>;">
                                            <?php echo $asignacion['datos']['icono']; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="sponsor-asignado">
                                <h3 class="jugador-nombre"><?php echo $jugador; ?></h3>
                                <h4 class="sponsor-nombre" style="color: <?php echo $asignacion['datos']['color']; ?>;">
                                    <?php echo $asignacion['sponsor']; ?>
                                </h4>
                                <p class="sponsor-descripcion"><?php echo $asignacion['datos']['descripcion']; ?></p>
                                <a href="sponsors.php?marca=<?php echo urlencode($asignacion['sponsor']); ?>" 
                                   class="button button-secondary" style="margin-top: 20px; padding: 12px 25px; font-size: 1rem;">
                                    <i class="fas fa-bullhorn"></i> Ver Eslóganes
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="botones-asignacion">
                    <a href="sponsors.php?reasignar=true" class="button button-success">
                        <i class="fas fa-random"></i>
                        Reasignar Sponsors Aleatoriamente
                    </a>
                </div>
            </div>
            
            <!-- Mostrar lista de todas las marcas -->
            <div class="sponsors-container">
                <div class="header-sponsors">
                    <h2>Sponsors Oficiales</h2>
                    <div class="contador-marcas">
                        <?php echo count($marcas_sponsors); ?> Marcas Patrocinadoras
                    </div>
                </div>
                
                <div class="grid-sponsors">
                    <?php foreach ($marcas_sponsors as $nombre_marca => $datos_marca): ?>
                        <a href="sponsors.php?marca=<?php echo urlencode($nombre_marca); ?>" 
                           class="marca-card efecto-brillante"
                           style="border-color: <?php echo $datos_marca['color']; ?>50;">
                            <div class="logo-marca" 
                                 style="background: linear-gradient(135deg, 
                                        <?php echo $datos_marca['color']; ?>40, 
                                        rgba(255,255,255,0.15)); 
                                        border-color: <?php echo $datos_marca['color']; ?>70;">
                                <?php if (isset($datos_marca['logo']) && imagenExiste($datos_marca['logo'])): ?>
                                    <img src="<?php echo $datos_marca['logo']; ?>" alt="<?php echo $nombre_marca; ?>">
                                <?php else: ?>
                                    <div class="icono-fallback" style="color: <?php echo $datos_marca['color']; ?>;">
                                        <?php echo $datos_marca['icono']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <h3 class="nombre-marca" style="color: <?php echo $datos_marca['color']; ?>; text-shadow: 0 0 15px <?php echo $datos_marca['color']; ?>40;">
                                <?php echo $nombre_marca; ?>
                            </h3>
                            <p class="descripcion-marca">
                                <?php echo $datos_marca['descripcion']; ?>
                            </p>
                            <div class="btn-ver-esloganes">
                                <i class="fas fa-bullhorn"></i> Ver Eslóganes Gigantes
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="navegacion-inferior">
                <a href="index.php" class="button">
                    <i class="fas fa-home"></i>
                    Volver al Inicio
                </a>
                <a href="equipos.php" class="button button-secondary">
                    <i class="fas fa-futbol"></i>
                    Ver Equipos
                </a>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Modal para modo presentación -->
    <div id="modoPresentacion" class="modo-presentacion" style="display: none;">
        <button class="btn-cerrar" onclick="cerrarPresentacion()">
            <i class="fas fa-times"></i>
        </button>
        <div class="eslogan-gigante" id="esloganPresentacion"></div>
        <div class="marca-presentacion" id="marcaPresentacion"></div>
    </div>
    
    <script>
    // Efecto de iluminación al pasar el ratón
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.marca-card, .eslogan-card, .jugador-sponsor-card');
        
        cards.forEach(card => {
            card.addEventListener('mousemove', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                const angleX = (y - centerY) / 15;
                const angleY = (centerX - x) / 15;
                
                this.style.transform = `perspective(1200px) rotateX(${angleX}deg) rotateY(${angleY}deg) scale3d(1.05, 1.05, 1.05) translateY(-20px)`;
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'perspective(1200px) rotateX(0) rotateY(0) scale3d(1, 1, 1) translateY(0)';
            });
        });
        
        // Efecto de confeti para los títulos principales
        const mainTitles = document.querySelectorAll('.header-sponsors h2, .nombre-marca-detalle, .header-asignacion h2');
        mainTitles.forEach(title => {
            title.addEventListener('mouseenter', function() {
                this.style.animation = 'pulse 1s ease';
                setTimeout(() => {
                    this.style.animation = 'glow 3s ease-in-out infinite';
                }, 1000);
            });
        });
        
        // Efecto de brillo para los eslóganes
        const esloganes = document.querySelectorAll('.eslogan-texto');
        esloganes.forEach(eslogan => {
            eslogan.addEventListener('mouseenter', function() {
                this.style.animation = 'pulse 0.5s ease, glow 2s ease-in-out infinite';
            });
        });
    });
    
    // Funciones para modo presentación
    function mostrarPresentacion(eslogan, marca) {
        const modal = document.getElementById('modoPresentacion');
        const esloganElement = document.getElementById('esloganPresentacion');
        const marcaElement = document.getElementById('marcaPresentacion');
        
        esloganElement.textContent = eslogan;
        marcaElement.textContent = marca;
        
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Efecto de entrada
        setTimeout(() => {
            modal.style.opacity = '1';
        }, 10);
    }
    
    function cerrarPresentacion() {
        const modal = document.getElementById('modoPresentacion');
        modal.style.opacity = '0';
        
        setTimeout(() => {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }, 300);
    }
    
    // Cerrar modal con ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarPresentacion();
        }
    });
    
    // Cerrar modal haciendo click fuera
    document.getElementById('modoPresentacion').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarPresentacion();
        }
    });
    </script>
</body>
</html>