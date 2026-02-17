<?php
require_once 'includes/config.php';

// Procesar eliminación de jugador
if (isset($_POST['eliminar_jugador'])) {
    $jugador_eliminar = $_POST['jugador_eliminar'];
    
    // Eliminar jugador de la lista
    if (($key = array_search($jugador_eliminar, $_SESSION['jugadores'])) !== false) {
        unset($_SESSION['jugadores'][$key]);
        $_SESSION['jugadores'] = array_values($_SESSION['jugadores']); // Reindexar array
    }
    
    // Eliminar asignación de equipo si existe
    if (isset($_SESSION['asignaciones'])) {
        foreach ($_SESSION['asignaciones'] as $key => $asignacion) {
            if ($asignacion['jugador'] === $jugador_eliminar) {
                unset($_SESSION['asignaciones'][$key]);
                $_SESSION['asignaciones'] = array_values($_SESSION['asignaciones']);
                break;
            }
        }
    }
    
    header('Location: jugadores.php');
    exit();
}

// Procesar adición de jugador
if (isset($_POST['agregar_jugador']) && !empty($_POST['nuevo_jugador'])) {
    $nuevo_jugador = trim($_POST['nuevo_jugador']);
    
    if (count($_SESSION['jugadores']) < 8 && !in_array($nuevo_jugador, $_SESSION['jugadores'])) {
        $_SESSION['jugadores'][] = $nuevo_jugador;
    }
    
    header('Location: jugadores.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jugadores - Torneo FIFA 26</title>
    <link rel="stylesheet" href="css/estilo.css">
    
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
    max-width: 1200px;
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

.navegacion-inferior {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 40px;
    flex-wrap: wrap;
}

/* ===== CONTENEDOR PRINCIPAL ===== */
.jugadores-container {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: var(--box-shadow);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

/* ===== HEADER DE JUGADORES ===== */
.header-jugadores {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
}

.header-jugadores::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: var(--gradient-accent);
    border-radius: 2px;
}

.header-jugadores h2 {
    font-size: 2.2rem;
    background: linear-gradient(to right, var(--text-color), var(--highlight-color));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    text-shadow: 0 0 10px rgba(233, 69, 96, 0.3);
}

.contador-jugadores {
    background: rgba(255, 255, 255, 0.1);
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: bold;
    color: var(--highlight-color);
}

/* ===== MENSAJE DE ALERTA ===== */
.mensaje-alerta {
    background: rgba(243, 156, 18, 0.2);
    border: 1px solid rgba(243, 156, 18, 0.5);
    border-radius: var(--border-radius);
    padding: 15px 20px;
    margin-bottom: 25px;
    color: var(--warning-color);
    text-align: center;
}

/* ===== GRID DE JUGADORES ===== */
.grid-jugadores {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.jugador-card {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 25px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: var(--transition);
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

.jugador-info {
    margin-bottom: 20px;
}

.nombre-jugador {
    font-size: 1.4rem;
    font-weight: bold;
    margin-bottom: 10px;
    color: var(--text-color);
}

.equipo-asignado {
    margin-bottom: 10px;
}

.equipo-jugador {
    background: rgba(76, 175, 80, 0.2);
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.9rem;
    color: var(--success-color);
    border: 1px solid rgba(76, 175, 80, 0.3);
}

.sin-equipo {
    background: rgba(108, 117, 125, 0.2);
    color: var(--text-secondary);
    border: 1px solid rgba(108, 117, 125, 0.3);
}

.estado-sorteo {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    color: var(--text-secondary);
}

.icono-estado {
    font-size: 1.1rem;
}

.acciones-jugador {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.btn-ver-equipo {
    background: rgba(15, 52, 96, 0.5);
    color: var(--text-color);
    padding: 8px 15px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.85rem;
    transition: var(--transition);
    border: 1px solid rgba(15, 52, 96, 0.7);
}

.btn-ver-equipo:hover {
    background: rgba(15, 52, 96, 0.7);
    transform: scale(1.05);
}

.btn-eliminar {
    background: rgba(231, 76, 60, 0.3);
    color: white;
    border: 1px solid rgba(231, 76, 60, 0.5);
    padding: 8px 15px;
    border-radius: 6px;
    font-size: 0.85rem;
    cursor: pointer;
    transition: var(--transition);
}

.btn-eliminar:hover {
    background: rgba(231, 76, 60, 0.5);
    transform: scale(1.05);
}

/* ===== FORMULARIO AGREGAR JUGADOR ===== */
.form-agregar-jugador {
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    padding: 25px;
    margin-bottom: 30px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.form-agregar-jugador h3 {
    font-size: 1.5rem;
    margin-bottom: 20px;
    color: var(--highlight-color);
    text-align: center;
}

.form-group {
    display: flex;
    gap: 15px;
    margin-bottom: 10px;
    flex-wrap: wrap;
}

.input-jugador {
    flex: 1;
    min-width: 250px;
    padding: 12px 15px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--border-radius);
    color: var(--text-color);
    font-size: 1rem;
    transition: var(--transition);
}

.input-jugador:focus {
    outline: none;
    border-color: var(--highlight-color);
    box-shadow: 0 0 5px rgba(233, 69, 96, 0.5);
}

.input-jugador::placeholder {
    color: var(--text-secondary);
}

/* ===== ESTADO COMPLETADO ===== */
.estado-completado {
    text-align: center;
    padding: 20px;
    background: rgba(76, 175, 80, 0.1);
    border-radius: var(--border-radius);
    margin-top: 20px;
    border: 1px solid rgba(76, 175, 80, 0.3);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(76, 175, 80, 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(76, 175, 80, 0); }
    100% { box-shadow: 0 0 0 0 rgba(76, 175, 80, 0); }
}

.estado-completado p {
    color: #155724;
    font-weight: 600;
    margin: 0;
}

.estado-completado a {
    color: #155724;
    text-decoration: underline;
    font-weight: bold;
}

.estado-completado a:hover {
    color: #0d4620;
}

/* ===== RESUMEN DEL ESTADO ===== */
.resumen-estado {
    margin-top: 30px;
    padding: 25px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.resumen-estado h4 {
    color: var(--highlight-color);
    margin-bottom: 20px;
    text-align: center;
    font-size: 1.3rem;
}

.grid-resumen {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.item-resumen {
    text-align: center;
    padding: 20px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--border-radius);
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: var(--transition);
}

.item-resumen:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.1);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
}

.item-resumen .icono {
    font-size: 2.5rem;
    margin-bottom: 10px;
}

.item-resumen .titulo {
    font-weight: 600;
    margin-bottom: 5px;
    color: var(--text-color);
}

.item-resumen .valor {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--highlight-color);
}

.item-resumen .estado {
    font-size: 1.1rem;
    font-weight: 700;
    margin-top: 5px;
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

.jugador-card, .item-resumen {
    animation: fadeInUp 0.6s ease forwards;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .header-jugadores {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .grid-jugadores {
        grid-template-columns: 1fr;
    }
    
    .form-group {
        flex-direction: column;
    }
    
    .input-jugador {
        min-width: auto;
    }
    
    .acciones-jugador {
        justify-content: center;
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
    
    .grid-resumen {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .header-jugadores h2 {
        font-size: 1.8rem;
    }
    
    .jugador-card {
        padding: 20px;
    }
    
    .nombre-jugador {
        font-size: 1.2rem;
    }
    
    .form-agregar-jugador {
        padding: 20px;
    }
}

/* Efectos especiales */
.jugador-card:nth-child(odd) {
    border-left: 3px solid var(--highlight-color);
}

.jugador-card:nth-child(even) {
    border-left: 3px solid var(--accent-color);
}

/* Indicador visual para jugadores con equipo */
.jugador-card:has(.equipo-jugador:not(.sin-equipo))::after {
    content: '✅';
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 1.2rem;
}
</style>
</head>
<body>
    <div class="container">
        <div class="jugadores-container">
            <div class="header-jugadores">
                <h2>👤 Gestión de Jugadores</h2>
                <div class="contador-jugadores">
                    <?php echo count($_SESSION['jugadores']); ?> de 8 jugadores
                </div>
            </div>
            
            <?php if (count($_SESSION['jugadores']) < 8): ?>
                <div class="mensaje-alerta">
                    <strong>⚠️ Atención:</strong> Necesitas tener 8 jugadores registrados para poder realizar el sorteo de equipos.
                </div>
            <?php endif; ?>
            
            <div class="grid-jugadores">
                <?php 
                $jugadores_con_equipo = 0;
                if (!empty($_SESSION['jugadores'])):
                    foreach ($_SESSION['jugadores'] as $jugador): 
                        $equipo_asignado = null;
                        // Buscar si el jugador tiene equipo asignado
                        if (isset($_SESSION['asignaciones'])) {
                            foreach ($_SESSION['asignaciones'] as $asignacion) {
                                if ($asignacion['jugador'] === $jugador) {
                                    $equipo_asignado = $asignacion['equipo'];
                                    $jugadores_con_equipo++;
                                    break;
                                }
                            }
                        }
                ?>
                    <div class="jugador-card">
                        <div class="jugador-info">
                            <div class="nombre-jugador"><?php echo htmlspecialchars($jugador); ?></div>
                            <div class="equipo-asignado">
                                <span class="equipo-jugador <?php echo $equipo_asignado ? '' : 'sin-equipo'; ?>">
                                    <?php echo $equipo_asignado ? '⚽ ' . $equipo_asignado : '⏳ Sin equipo asignado'; ?>
                                </span>
                            </div>
                            <div class="estado-sorteo">
                                <span class="icono-estado">
                                    <?php echo $equipo_asignado ? '✅' : '❌'; ?>
                                </span>
                                <span><?php echo $equipo_asignado ? 'Equipo asignado' : 'Esperando sorteo'; ?></span>
                            </div>
                        </div>
                        <div class="acciones-jugador">
                            <?php if ($equipo_asignado): ?>
                                <a href="equipos.php?jugador=<?php echo urlencode($jugador); ?>" class="btn-ver-equipo">
                                    👀 Ver equipo
                                </a>
                            <?php else: ?>
                                <span class="btn-ver-equipo" style="background: #6c757d; cursor: not-allowed;">
                                    👀 Ver equipo
                                </span>
                            <?php endif; ?>
                            
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="jugador_eliminar" value="<?php echo htmlspecialchars($jugador); ?>">
                                <button type="submit" name="eliminar_jugador" class="btn-eliminar" 
                                        onclick="return confirm('¿Estás seguro de que quieres eliminar a <?php echo htmlspecialchars($jugador); ?>?')">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                <?php 
                    endforeach; 
                else:
                ?>
                    <div style="text-align: center; padding: 40px; grid-column: 1 / -1;">
                        <p style="color: #6c757d; font-size: 1.2rem;">No hay jugadores registrados todavía.</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if (count($_SESSION['jugadores']) < 8): ?>
                <div class="form-agregar-jugador">
                    <h3 style="color: var(--primary); margin-bottom: 20px;">➕ Agregar Nuevo Jugador</h3>
                    <form method="POST">
                        <div class="form-group">
                            <input type="text" name="nuevo_jugador" class="input-jugador" 
                                   placeholder="Nombre del jugador" required
                                   maxlength="50">
                            <button type="submit" name="agregar_jugador" class="button button-success">
                                Agregar Jugador
                            </button>
                        </div>
                        <p style="color: #6c757d; margin-top: 10px; font-size: 0.9rem;">
                            Quedan <?php echo 8 - count($_SESSION['jugadores']); ?> espacios disponibles.
                        </p>
                    </form>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 20px; background: #d4edda; border-radius: 10px; margin-top: 20px;">
                    <p style="color: #155724; font-weight: 600; margin: 0;">
                        ✅ ¡Perfecto! Tienes los 8 jugadores necesarios. 
                        <a href="sorteo.php" style="color: #155724; text-decoration: underline;">
                            Puedes proceder al sorteo de equipos
                        </a>
                    </p>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($_SESSION['jugadores']) && count($_SESSION['jugadores']) >= 8): ?>
                <div style="margin-top: 30px; padding: 20px; background: #2b4163; border-radius: 10px;">
                    <h4 style="color: var(--primary); margin-bottom: 15px;">📊 Resumen del Estado</h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                        <div style="text-align: center; padding: 15px; background: #1e375b; border-radius: 8px;">
                            <div style="font-size: 2rem; margin-bottom: 5px;">👤</div>
                            <div style="font-weight: 600;">Jugadores</div>
                            <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">
                                <?php echo count($_SESSION['jugadores']); ?>/8
                            </div>
                        </div>
                        <div style="text-align: center; padding: 15px; background: #1e375b; border-radius: 8px;">
                            <div style="font-size: 2rem; margin-bottom: 5px;">⚽</div>
                            <div style="font-weight: 600;">Equipos Asignados</div>
                            <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">
                                <?php echo $jugadores_con_equipo; ?>/8
                            </div>
                        </div>
                        <div style="text-align: center; padding: 15px; background: #1e375b; border-radius: 8px;">
                            <div style="font-size: 2rem; margin-bottom: 5px;">📋</div>
                            <div style="font-weight: 600;">Estado</div>
                            <div style="font-size: 1.1rem; font-weight: 700; color: <?php echo $jugadores_con_equipo == 8 ? '#28a745' : '#ffc107'; ?>;">
                                <?php echo $jugadores_con_equipo == 8 ? 'Completado' : 'Pendiente'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="navegacion-inferior">
            <a href="index.php" class="button">🏠 Volver al Inicio</a>
            <?php if (count($_SESSION['jugadores']) >= 8): ?>
                <a href="sorteo.php" class="button button-success">🎲 Ir al Sorteo</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>