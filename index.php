<?php
require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torneo FIFA 26</title>
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
    --success-color: #4CAF50;
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
    overflow-x: hidden;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* ===== HEADER PRINCIPAL ===== */
header {
    text-align: center;
    padding: 40px 20px;
    margin-bottom: 40px;
    position: relative;
    overflow: hidden;
}

header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 80%, rgba(233, 69, 96, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(15, 52, 96, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(255, 215, 0, 0.05) 0%, transparent 50%);
    z-index: -1;
}

header h1 {
    font-size: 4rem;
    margin-bottom: 10px;
    background: linear-gradient(to right, var(--text-color), var(--highlight-color));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    text-shadow: 0 0 20px rgba(233, 69, 96, 0.3);
    letter-spacing: 2px;
    position: relative;
    display: inline-block;
}

header h1::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 200px;
    height: 3px;
    background: var(--gradient-accent);
    border-radius: 3px;
}

.subtitle {
    font-size: 1.5rem;
    color: var(--text-secondary);
    margin-top: 10px;
    font-weight: 300;
}

/* ===== MENÚ PRINCIPAL ===== */
.menu-principal {
    margin-bottom: 50px;
}

.menu-principal h2 {
    text-align: center;
    font-size: 2.2rem;
    margin-bottom: 30px;
    color: var(--text-color);
    position: relative;
    display: inline-block;
    left: 50%;
    transform: translateX(-50%);
}

.menu-principal h2::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 100%;
    height: 2px;
    background: var(--gradient-accent);
    border-radius: 2px;
}

.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
}

/* Ajuste para pantallas grandes: 3 columnas */
@media (min-width: 1200px) {
    .menu-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

.menu-item, .bracket-item {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 30px 25px;
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
    backdrop-filter: blur(10px);
}

/* Elemento de sponsors - ocupa 3 columnas */
.sponsor-item {
    grid-column: span 3;
    background: rgba(255, 215, 0, 0.08);
    border: 2px solid rgba(255, 215, 0, 0.3);
    padding: 40px 30px;
    position: relative;
}

.sponsor-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, 
        transparent 0%, 
        rgba(255, 215, 0, 0.1) 25%, 
        rgba(255, 215, 0, 0.05) 50%, 
        rgba(255, 215, 0, 0.1) 75%, 
        transparent 100%);
    z-index: -1;
}

.sponsor-item .menu-icon {
    color: var(--gold-color);
    font-size: 4rem;
    margin-bottom: 25px;
    text-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
}

.sponsor-item h3 {
    font-size: 2rem;
    background: linear-gradient(to right, var(--gold-color), #ffed4e);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    margin-bottom: 15px;
}

.sponsor-item p {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.9);
    max-width: 800px;
    margin: 0 auto;
}

.sponsor-item:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 40px rgba(255, 215, 0, 0.2);
    border-color: rgba(255, 215, 0, 0.5);
    background: rgba(255, 215, 0, 0.12);
}

.menu-item::before, .bracket-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, transparent, rgba(255, 255, 255, 0.03), transparent);
    z-index: -1;
}

.menu-item:hover, .bracket-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.6);
    border-color: rgba(255, 255, 255, 0.3);
}

.menu-icon, .bracket-icon {
    font-size: 3.5rem;
    margin-bottom: 20px;
    transition: var(--transition);
}

.menu-item:hover .menu-icon, .bracket-item:hover .bracket-icon {
    transform: scale(1.2);
}

.menu-item h3, .bracket-item h3 {
    font-size: 1.5rem;
    margin-bottom: 10px;
    color: var(--text-color);
}

.menu-item p, .bracket-item p {
    color: var(--text-secondary);
    font-size: 0.95rem;
}

/* Estilos especiales para elementos del bracket */
.bracket-item {
    background: rgba(255, 215, 0, 0.05);
    border: 1px solid rgba(255, 215, 0, 0.2);
    grid-column: span 2;
}

.bracket-item:hover {
    background: rgba(255, 215, 0, 0.1);
    box-shadow: 0 15px 35px rgba(255, 215, 0, 0.2);
}

.bracket-icon {
    color: var(--gold-color);
}

/* ===== ESTADO ACTUAL ===== */
.estado-actual {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: var(--box-shadow);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.estado-actual h3 {
    font-size: 1.8rem;
    margin-bottom: 25px;
    text-align: center;
    color: var(--text-color);
    position: relative;
    display: inline-block;
    left: 50%;
    transform: translateX(-50%);
}

.estado-actual h3::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 100%;
    height: 2px;
    background: var(--gradient-accent);
    border-radius: 2px;
}

.estado-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 25px;
}

.estado-item {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 20px;
    text-align: center;
    transition: var(--transition);
    border: 1px solid rgba(255, 255, 255, 0.1);
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

/* ===== BOTONES DE DESCANSO ===== */
.botones-descanso {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.boton-descanso {
    background: rgba(255, 215, 0, 0.1);
    border: 1px solid rgba(255, 215, 0, 0.3);
    border-radius: var(--border-radius);
    padding: 15px 20px;
    text-decoration: none;
    color: var(--gold-color);
    text-align: center;
    font-weight: bold;
    font-size: 1.1rem;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.boton-descanso:hover {
    background: rgba(255, 215, 0, 0.2);
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(255, 215, 0, 0.2);
    border-color: rgba(255, 215, 0, 0.5);
}

.boton-descanso i {
    font-size: 1.3rem;
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

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

@keyframes sponsorGlow {
    0% {
        box-shadow: 0 0 20px rgba(255, 215, 0, 0.3);
    }
    50% {
        box-shadow: 0 0 40px rgba(255, 215, 0, 0.6);
    }
    100% {
        box-shadow: 0 0 20px rgba(255, 215, 0, 0.3);
    }
}

header, .menu-item, .bracket-item, .estado-item, .boton-descanso {
    animation: fadeInUp 0.6s ease forwards;
}

.sponsor-item {
    animation: fadeInUp 0.8s ease forwards, sponsorGlow 3s infinite;
}

.menu-item:nth-child(1) { animation-delay: 0.1s; }
.menu-item:nth-child(2) { animation-delay: 0.2s; }
.menu-item:nth-child(3) { animation-delay: 0.3s; }
.menu-item:nth-child(4) { animation-delay: 0.4s; }
.menu-item:nth-child(5) { animation-delay: 0.5s; }
.menu-item:nth-child(6) { animation-delay: 0.6s; }
.menu-item:nth-child(7) { animation-delay: 0.1s; }
.menu-item:nth-child(8) { animation-delay: 0.2s; }
.menu-item:nth-child(9) { animation-delay: 0.3s; }
.sponsor-item { animation-delay: 0.4s; }
.bracket-item:nth-child(1) { animation-delay: 0.5s; }
.bracket-item:nth-child(2) { animation-delay: 0.6s; }
.boton-descanso:nth-child(1) { animation-delay: 0.7s; }
.boton-descanso:nth-child(2) { animation-delay: 0.8s; }

/* Efecto de brillo en elementos importantes */
.menu-item:hover .menu-icon {
    animation: pulse 1s infinite;
}

.sponsor-item:hover .menu-icon {
    animation: pulse 0.8s infinite;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 1200px) {
    .sponsor-item {
        grid-column: span 2;
    }
}

@media (max-width: 1024px) {
    .menu-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    }
    
    .bracket-item {
        grid-column: span 1;
    }
    
    .sponsor-item {
        grid-column: span 2;
    }
}

@media (max-width: 768px) {
    header h1 {
        font-size: 3rem;
    }
    
    .subtitle {
        font-size: 1.2rem;
    }
    
    .menu-grid {
        grid-template-columns: 1fr;
    }
    
    .sponsor-item,
    .bracket-item {
        grid-column: span 1;
    }
    
    .sponsor-item {
        padding: 30px 20px;
    }
    
    .sponsor-item .menu-icon {
        font-size: 3rem;
    }
    
    .sponsor-item h3 {
        font-size: 1.8rem;
    }
    
    .estado-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .botones-descanso {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    header h1 {
        font-size: 2.5rem;
    }
    
    .menu-principal h2, .estado-actual h3 {
        font-size: 1.5rem;
    }
    
    .estado-grid {
        grid-template-columns: 1fr;
    }
    
    .menu-item, .bracket-item {
        padding: 20px 15px;
    }
    
    .sponsor-item {
        padding: 25px 15px;
    }
    
    .menu-icon, .bracket-icon {
        font-size: 2.5rem;
    }
    
    .sponsor-item .menu-icon {
        font-size: 2.5rem;
    }
    
    .sponsor-item h3 {
        font-size: 1.5rem;
    }
    
    .sponsor-item p {
        font-size: 1rem;
    }
    
    .boton-descanso {
        padding: 12px 15px;
        font-size: 1rem;
    }
}

/* Efectos de partículas de fondo */
body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: 
        radial-gradient(circle at 10% 20%, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
        radial-gradient(circle at 90% 80%, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
        radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
    background-size: 50px 50px, 70px 70px, 90px 90px;
    z-index: -1;
}

/* Estilo para el video grupal */
.foto-grupal {
    max-width: 100%;
    width: 600px;
    height: auto;
    margin-top: 30px;
    border-radius: var(--border-radius);
    border: 5px solid var(--highlight-color);
    box-shadow: var(--box-shadow);
    object-fit: cover;
    animation: fadeInUp 0.8s ease forwards;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

/* Ajuste responsive para el video */
@media (max-width: 768px) {
    .foto-grupal {
        width: 100%;
        margin-top: 20px;
        border-width: 3px;
    }
}
</style>
    <!-- Iconos de Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>EL MUNDIAL - III EDICIÓN</h1>
            <p class="subtitle">8 amigos, 8 equipos, un campeón</p>
            <video class="foto-grupal" autoplay muted loop playsinline>
                <source src="presentacion/index.mp4" type="video/mp4">
                Tu navegador no soporta el elemento de video.
            </video>
        </header>
        
        <div class="menu-principal">
            <h2>Menú Principal</h2>
            <div class="menu-grid">
                <a href="jugadores.php" class="menu-item">
                    <div class="menu-icon">👤</div>
                    <h3>Jugadores</h3>
                    <p>Gestionar participantes del torneo</p>
                </a>
                
                <a href="equipos.php" class="menu-item">
                    <div class="menu-icon">⚽</div>
                    <h3>Equipos</h3>
                    <p>Ver equipos disponibles</p>
                </a>
                
                <a href="sorteo.php" class="menu-item">
                    <div class="menu-icon">🎲</div>
                    <h3>Sorteo</h3>
                    <p>Asignar equipos a jugadores</p>
                </a>
                
                <a href="grupos.php" class="menu-item">
                    <div class="menu-icon">📊</div>
                    <h3>Grupos</h3>
                    <p>Sorteo y calendario</p>
                </a>
                
                <a href="eliminatorias.php" class="menu-item">
                    <div class="menu-icon">🏅</div>
                    <h3>Cuadro de Eliminatorias</h3>
                    <p>Ver bracket completo y resultados</p>
                </a>
                
                <a href="estadisticas.php" class="menu-item">
                    <div class="menu-icon">🏆</div>
                    <h3>Estadísticas y Records</h3>
                    <p>Máximos goleadores, mejores jugadores y records</p>
                </a>
                
                <!-- NUEVAS SECCIONES AÑADIDAS -->
                <a href="login.php" class="menu-item">
                    <div class="menu-icon">🔐</div>
                    <h3>Iniciar Sesión</h3>
                    <p>Acceso administradores y jugadores</p>
                </a>
                
                <a href="comentaristas.php" class="menu-item">
                    <div class="menu-icon">🎤</div>
                    <h3>Comentaristas</h3>
                    <p>Panel de comentarios y narradores</p>
                </a>
                
                <a href="sonidos.php" class="menu-item">
                    <div class="menu-icon">🔊</div>
                    <h3>Banco de Sonidos</h3>
                    <p>SIUUU, abucheos, animación y efectos</p>
                </a>
                
                <!-- SPONSORS - OCUPA 3 COLUMNAS -->
                <a href="sponsors.php" class="menu-item sponsor-item">
                    <div class="menu-icon">💼</div>
                    <h3>Sponsors y Patrocinadores</h3>
                    <p>Conoce a nuestros patrocinadores oficiales que hacen posible este torneo</p>
                </a>
            </div>
        </div>
        
        <div class="estado-actual">
            <h3>Estado del Torneo</h3>
            <div class="estado-grid">
                <div class="estado-item">
                    <span>Jugadores registrados:</span>
                    <strong><?php echo isset($_SESSION['jugadores']) ? count($_SESSION['jugadores']) : 0; ?></strong>
                </div>
                <div class="estado-item">
                    <span>Equipos asignados:</span>
                    <strong><?php echo isset($_SESSION['asignaciones']) ? count($_SESSION['asignaciones']) : 0; ?> de 8</strong>
                </div>
            </div>
            
            <!-- Botones de Descanso -->
            <div class="botones-descanso">
                <a href="descanso1.php" class="boton-descanso">
                    <i class="fas fa-coffee"></i>
                    Descanso 1
                </a>
                <a href="descanso2.php" class="boton-descanso">
                    <i class="fas fa-utensils"></i>
                    Descanso 2
                </a>
            </div>
        </div>
    </div>
</body>
</html>