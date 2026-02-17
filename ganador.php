<?php
require_once 'includes/config.php';
require_once 'includes/funciones.php';

// Verificar que hay un campeón, si no, redirigir a eliminatorias
if (!isset($_SESSION['campeon'])) {
    header('Location: eliminatorias.php');
    exit();
}

// Array de jugadores con sus videos
$videos_jugadores = [
    "Romo" => "videosW/romo.mp4",
    "Reyes" => "videosW/reyes.mp4", 
    "Figueroa" => "videosW/figueroa.mp4",
    "Huevo" => "videosW/huevo.mp4",
    "Josete" => "videosW/josete.mp4",
    "Carlos" => "videosW/carlos.mp4",
    "Jogi" => "videosW/jogi.mp4",
    "Ivanoskyx" => "videosW/ivanoskyx.mp4"
];

// Función para obtener el video del jugador
function obtenerVideoJugador($nombre_jugador) {
    global $videos_jugadores;
    return isset($videos_jugadores[$nombre_jugador]) ? $videos_jugadores[$nombre_jugador] : "videos/default.mp4";
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

// Buscar qué jugador tiene asignado el equipo campeón
$jugador_campeon = null;
if (isset($_SESSION['asignaciones'])) {
    foreach ($_SESSION['asignaciones'] as $asignacion) {
        if ($asignacion['equipo'] === $_SESSION['campeon']) {
            $jugador_campeon = $asignacion['jugador'];
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Campeón! - Torneo FIFA 26</title>
    <style>
        :root {
            --primary-color: #1a1a2e;
            --secondary-color: #16213e;
            --accent-color: #0f3460;
            --highlight-color: #e94560;
            --gold-color: #ffd700;
            --text-color: #ffffff;
            --border-radius: 15px;
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .campeon-container {
            text-align: center;
            max-width: 800px;
            width: 100%;
        }

        .confeti {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: -1;
        }

        .header-campeon {
            margin-bottom: 40px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .header-campeon::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--gold-color), transparent);
        }

        .header-campeon h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            background: linear-gradient(to right, var(--gold-color), #ffa500);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
        }

        .campeon-content {
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            padding: 40px;
            backdrop-filter: blur(10px);
            border: 2px solid var(--gold-color);
            box-shadow: 0 0 50px rgba(255, 215, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .campeon-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="100" height="100" opacity="0.1"><path fill="%23FFD700" d="M50,15 L60,40 L85,40 L65,55 L75,80 L50,65 L25,80 L35,55 L15,40 L40,40 Z"/></svg>');
            background-size: 100px;
            z-index: -1;
        }

        .video-campeon-container {
            margin: 20px 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .video-campeon {
            width: 300px;
            height: 300px;
            border-radius: 50%;
            object-fit: cover;
            border: 8px solid var(--gold-color);
            box-shadow: 0 0 40px rgba(255, 215, 0, 0.7);
            transition: var(--transition);
        }

        .video-campeon:hover {
            transform: scale(1.05);
            box-shadow: 0 0 60px rgba(255, 215, 0, 0.9);
        }

        .campeon-nombre {
            font-size: 4rem;
            font-weight: bold;
            margin: 20px 0;
            text-transform: uppercase;
            letter-spacing: 3px;
            background: linear-gradient(to right, var(--text-color), var(--gold-color));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
        }

        .campeon-equipo {
            font-size: 2rem;
            margin: 20px 0;
            color: var(--gold-color);
        }

        .trophy-icon {
            font-size: 5rem;
            margin: 20px 0;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .mensaje-felicidades {
            font-size: 1.3rem;
            margin: 20px 0;
            line-height: 1.6;
        }

        .navegacion {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
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

        /* Efectos de confeti */
        @keyframes fall {
            0% { transform: translateY(-100px) rotate(0deg); }
            100% { transform: translateY(100vh) rotate(360deg); }
        }

        .confeti-piece {
            position: absolute;
            width: 10px;
            height: 10px;
            background: var(--gold-color);
            top: -10px;
            animation: fall linear forwards;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-campeon h1 {
                font-size: 2rem;
            }
            
            .campeon-nombre {
                font-size: 2.5rem;
            }
            
            .campeon-equipo {
                font-size: 1.5rem;
            }
            
            .video-campeon {
                width: 250px;
                height: 250px;
            }
        }

        @media (max-width: 480px) {
            .video-campeon {
                width: 200px;
                height: 200px;
            }
            
            .campeon-nombre {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Efecto de confeti -->
    <div class="confeti" id="confetti"></div>

    <div class="campeon-container">
        <div class="header-campeon">
            <h1>¡FELICIDADES!</h1>
            <p>Tenemos un nuevo campeón del Torneo FIFA 26</p>
        </div>
        
        <div class="campeon-content">
            
            <!-- Video del jugador campeón -->
            <div class="video-campeon-container">
                <video class="video-campeon" autoplay muted loop playsinline>
                    <source src="<?php echo obtenerVideoJugador($jugador_campeon); ?>" type="video/mp4">
                    Tu navegador no soporta el elemento video.
                </video>
            </div>
            
            <div class="campeon-nombre"><?php echo $jugador_campeon; ?></div>
            <div class="campeon-equipo">con <?php echo $_SESSION['campeon']; ?></div>
                        <div class="trophy-icon">🏆</div>

            <div class="mensaje-felicidades">
                <p>¡Increíble desempeño durante todo el torneo!</p>
                <p>Has demostrado ser el mejor entre los mejores.</p>
            </div>
            
            <div class="navegacion">
                <a href="index.php" class="button">🏠 Volver al Inicio</a>
                <a href="eliminatorias.php" class="button">📊 Ver Eliminatorias</a>
                <a href="estadisticas.php" class="button button-success">📈 Ver Estadísticas</a>
            </div>
        </div>
    </div>

    <script>
        // Efecto de confeti
        function crearConfeti() {
            const confettiContainer = document.getElementById('confetti');
            const colors = ['#ffd700', '#ffed4e', '#ffa500', '#ffffff', '#e94560'];
            const confettiCount = 150;

            for (let i = 0; i < confettiCount; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confeti-piece';
                
                // Posición aleatoria
                confetti.style.left = Math.random() * 100 + 'vw';
                
                // Tamaño aleatorio
                const size = Math.random() * 10 + 5;
                confetti.style.width = size + 'px';
                confetti.style.height = size + 'px';
                
                // Color aleatorio
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                
                // Animación con duración y delay aleatorios
                const duration = Math.random() * 3 + 2;
                const delay = Math.random() * 2;
                confetti.style.animation = `fall ${duration}s linear ${delay}s forwards`;
                
                confettiContainer.appendChild(confetti);
                
                // Eliminar el confeti después de que termine la animación
                setTimeout(() => {
                    confetti.remove();
                }, (duration + delay) * 1000);
            }
        }

        // Crear confeti continuamente
        crearConfeti();
        setInterval(crearConfeti, 3000);

        // Reproducir sonido de campeón
        window.addEventListener('DOMContentLoaded', function() {
            const audio = new Audio('himnos/campeoness.mp3');
            audio.play().catch(function(error) {
                console.log('Error al reproducir el sonido:', error);
            });
        });

        // Asegurar que el video se reproduzca correctamente
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.querySelector('.video-campeon');
            video.play().catch(function(error) {
                console.log('Error al reproducir el video:', error);
                // Intentar reproducir nuevamente si hay error
                setTimeout(() => {
                    video.play();
                }, 1000);
            });
        });
    </script>
</body>
</html>