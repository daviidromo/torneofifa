<?php
require_once 'includes/config.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_autenticado']) || !isset($_SESSION['presentacion_iniciada'])) {
    header('Location: login.php');
    exit();
}

// Array de jugadores con sus videos
$videos_jugadores = [
    "Romo" => "presentacion/romo.mp4",
    "Reyes" => "presentacion/reyes.mp4", 
    "Figueroa" => "presentacion/figueroa.mp4",
    "Huevo" => "presentacion/huevo.mp4",
    "Josete" => "presentacion/josete.mp4",
    "Carlos" => "presentacion/carlos.mp4",
    "Jogi" => "presentacion/jogi.mp4",
    "Ivanoskyx" => "presentacion/ivanoskyx.mp4"
];

// Obtener el índice del jugador actual
$jugador_actual_index = $_SESSION['jugador_actual_index'] ?? 0;
$jugadores = $_SESSION['jugadores'];
$total_jugadores = count($jugadores);

// Verificar si hemos terminado la presentación
if ($jugador_actual_index >= $total_jugadores) {
    unset($_SESSION['presentacion_iniciada']);
    unset($_SESSION['jugador_actual_index']);
    header('Location: index.php');
    exit();
}

// Obtener datos del jugador actual
$jugador_actual = $jugadores[$jugador_actual_index];
$video_jugador = isset($videos_jugadores[$jugador_actual]) ? $videos_jugadores[$jugador_actual] : "videosW/default.mp4";

// Verificar si es el último jugador
$es_ultimo_jugador = ($jugador_actual_index + 1) == $total_jugadores;

// Avanzar al siguiente jugador cuando se presione el botón
if (isset($_POST['siguiente_jugador'])) {
    $_SESSION['jugador_actual_index'] = $jugador_actual_index + 1;
    header('Location: presentacion.php');
    exit();
}

// Si se solicita mostrar el video directamente
$mostrar_video_directamente = isset($_POST['mostrar_video']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presentación - Torneo FIFA 26</title>
    <style>
        :root {
            --primary-color: #1a1a2e;
            --secondary-color: #16213e;
            --accent-color: #0f3460;
            --highlight-color: #e94560;
            --gold-color: #ffd700;
            --text-color: #ffffff;
            --text-secondary: #b0b0b0;
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
            overflow: hidden;
        }

        .presentacion-container {
            width: 100%;
            max-width: 1000px;
            text-align: center;
            position: relative;
        }

        .etapa-nombre {
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            padding: 60px 40px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            margin-bottom: 30px;
            animation: fadeIn 1s ease;
        }

        .etapa-video {
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            padding: 40px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .nombre-jugador {
            font-size: 4rem;
            font-weight: bold;
            margin-bottom: 20px;
            background: linear-gradient(to right, var(--text-color), var(--highlight-color));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 0 20px rgba(233, 69, 96, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .mensaje-bienvenida {
            font-size: 1.5rem;
            color: var(--text-secondary);
            margin-bottom: 30px;
        }

        /* Contenedor para videos verticales */
        .video-container {
            width: 100%;
            max-width: 400px; /* Ancho máximo para videos verticales */
            margin: 0 auto 30px;
            position: relative;
        }

        .video-jugador {
            width: 100%;
            height: auto;
            border-radius: var(--border-radius);
            object-fit: contain; /* Mostrar todo el video sin recortar */
            border: 5px solid var(--gold-color);
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.5);
            background-color: #000; /* Fondo negro para áreas vacías */
        }

        .contador {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.7);
            padding: 10px 15px;
            border-radius: 20px;
            font-weight: bold;
            z-index: 100;
        }

        .boton-siguiente {
            background: var(--accent-color);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: var(--border-radius);
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .boton-siguiente:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
            background: var(--highlight-color);
        }

        .progreso {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: rgba(255, 255, 255, 0.1);
            z-index: 100;
        }

        .progreso-barra {
            height: 100%;
            background: linear-gradient(135deg, #e94560, #ff6b6b, #ff8e8e);
            width: <?php echo ($jugador_actual_index / $total_jugadores) * 100; ?>%;
            transition: width 0.5s ease;
        }

        .instruccion {
            font-size: 1rem;
            color: var(--text-secondary);
            margin-top: 10px;
            font-style: italic;
        }

        /* Control de música */
        .control-musica {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            z-index: 100;
            transition: var(--transition);
        }

        .control-musica:hover {
            transform: scale(1.1);
            background: rgba(0, 0, 0, 0.9);
        }

        .control-musica i {
            font-size: 1.5rem;
            color: var(--gold-color);
        }

        /* Botón de activar sonido */
        .activar-sonido {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            background: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: var(--border-radius);
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid var(--gold-color);
        }

        .boton-activar-sonido {
            background: var(--highlight-color);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: var(--border-radius);
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        .boton-activar-sonido:hover {
            transform: scale(1.05);
            background: var(--gold-color);
            color: var(--primary-color);
        }

        .mensaje-activar-sonido {
            margin-bottom: 15px;
            color: var(--text-color);
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .nombre-jugador {
                font-size: 2.5rem;
            }
            
            .video-container {
                max-width: 90%;
            }
            
            .etapa-nombre, .etapa-video {
                padding: 30px 20px;
            }
            
            .boton-siguiente {
                padding: 12px 25px;
                font-size: 1.1rem;
            }
        }

        @media (max-width: 480px) {
            .nombre-jugador {
                font-size: 2rem;
            }
            
            .video-container {
                max-width: 95%;
            }
            
            .mensaje-bienvenida {
                font-size: 1.2rem;
            }
            
            .boton-siguiente {
                padding: 10px 20px;
                font-size: 1rem;
            }
            
            .control-musica {
                width: 40px;
                height: 40px;
                bottom: 15px;
                left: 15px;
            }
            
            .control-musica i {
                font-size: 1.2rem;
            }
            
            .activar-sonido {
                width: 90%;
                padding: 15px;
            }
            
            .boton-activar-sonido {
                padding: 12px 25px;
                font-size: 1.1rem;
            }
        }
    </style>
    <!-- Iconos de Font Awesome para el control de música -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Barra de progreso -->
    <div class="progreso">
        <div class="progreso-barra"></div>
    </div>
    
    <!-- Contador -->
    <div class="contador">
        <?php echo ($jugador_actual_index + 1) . " / " . $total_jugadores; ?>
    </div>
    
    <!-- Control de música -->
    <div class="control-musica" id="controlMusica">
        <i class="fas fa-volume-up"></i>
    </div>
    
    <!-- Elemento de audio para la música de fondo -->
    <audio id="musicaFondo" loop>
        <source src="himnos/presentacion.mp3" type="audio/mpeg">
        Tu navegador no soporta el elemento de audio.
    </audio>
    
    <!-- Botón para activar sonido (se muestra si la música no inicia automáticamente) -->
    <div class="activar-sonido" id="activarSonido" style="display: none;">
        <div class="mensaje-activar-sonido">
            🔊 Activa el sonido para una mejor experiencia
        </div>
        <button class="boton-activar-sonido" id="botonActivarSonido">
            Activar Sonido
        </button>
    </div>
    
    <div class="presentacion-container">
        <?php if (!$mostrar_video_directamente): ?>
            <!-- Etapa 1: Mostrar nombre del jugador -->
            <div class="etapa-nombre">
                <div class="nombre-jugador">
                    <?php echo $jugador_actual; ?>
                </div>
                <div class="mensaje-bienvenida">
                    ¡Bienvenido al Torneo FIFA 26!
                </div>
                
                <form method="POST">
                    <button type="submit" name="mostrar_video" class="boton-siguiente">
                        ▶️ Ver Presentación
                    </button>
                </form>
            </div>
            
        <?php else: ?>
            <!-- Etapa 2: Mostrar video del jugador -->
            <div class="etapa-video">
                <div class="nombre-jugador" style="font-size: 2.5rem; margin-bottom: 20px;">
                    <?php echo $jugador_actual; ?>
                </div>
                
                <div class="video-container">
                    <video class="video-jugador" autoplay loop muted playsinline>
                        <source src="<?php echo $video_jugador; ?>" type="video/mp4">
                        Tu navegador no soporta el elemento video.
                    </video>
                </div>
                
                <form method="POST">
                    <button type="submit" name="siguiente_jugador" class="boton-siguiente">
                        <?php echo $es_ultimo_jugador ? '🏆 Finalizar Presentación' : '⏭️ Siguiente Jugador'; ?>
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const musicaFondo = document.getElementById('musicaFondo');
            const controlMusica = document.getElementById('controlMusica');
            const iconoMusica = controlMusica.querySelector('i');
            const activarSonido = document.getElementById('activarSonido');
            const botonActivarSonido = document.getElementById('botonActivarSonido');
            
            // Configuración inicial
            musicaFondo.volume = 0.5;
            
            // Estado guardado
            const musicaEstado = localStorage.getItem('musicaEstado');
            const musicaTiempo = localStorage.getItem('musicaTiempo');
            
            function iniciarMusica() {
                if (musicaEstado === 'reproduciendo') {
                    musicaFondo.currentTime = parseFloat(musicaTiempo) || 0;
                    reproducirMusica();
                } else {
                    // Si no hay estado guardado, intentar reproducir
                    reproducirMusica();
                }
            }
            
            function reproducirMusica() {
                const promise = musicaFondo.play();
                if (promise !== undefined) {
                    promise.then(() => {
                        // Éxito en la reproducción
                        iconoMusica.className = 'fas fa-volume-up';
                        controlMusica.style.background = 'rgba(0, 0, 0, 0.7)';
                        localStorage.setItem('musicaEstado', 'reproduciendo');
                        activarSonido.style.display = 'none';
                    }).catch(error => {
                        // Fallo - requerir interacción del usuario
                        console.log('Reproducción automática bloqueada:', error);
                        activarSonido.style.display = 'block';
                        controlMusica.style.cursor = 'pointer';
                        controlMusica.title = "Haz clic para activar la música";
                    });
                }
            }
            
            function pausarMusica() {
                musicaFondo.pause();
                iconoMusica.className = 'fas fa-volume-mute';
                controlMusica.style.background = 'rgba(233, 69, 96, 0.7)';
                localStorage.setItem('musicaEstado', 'pausada');
            }
            
            // Iniciar música al cargar la página
            iniciarMusica();
            
            // Control de clic en el ícono de música
            controlMusica.addEventListener('click', function() {
                if (musicaFondo.paused) {
                    reproducirMusica();
                } else {
                    pausarMusica();
                }
            });
            
            // Botón para activar sonido manualmente
            botonActivarSonido.addEventListener('click', function() {
                reproducirMusica();
                activarSonido.style.display = 'none';
            });
            
            // Guardar progreso cada segundo
            setInterval(() => {
                if (!musicaFondo.paused) {
                    localStorage.setItem('musicaTiempo', musicaFondo.currentTime);
                    localStorage.setItem('musicaEstado', 'reproduciendo');
                }
            }, 1000);
            
            // Asegurar que el video se reproduzca correctamente
            const video = document.querySelector('.video-jugador');
            if (video) {
                video.play().catch(function(error) {
                    console.log('Error al reproducir el video:', error);
                    // Si el video no se reproduce automáticamente, agregar control manual
                    document.querySelector('.boton-siguiente').addEventListener('click', function() {
                        video.play();
                    });
                });
            }
            
            // Manejar el envío del formulario para el último jugador
            const formSiguiente = document.querySelector('form[method="POST"]');
            if (formSiguiente) {
                formSiguiente.addEventListener('submit', function(e) {
                    // Solo limpiar el localStorage si es el último jugador y vamos a finalizar
                    const contador = document.querySelector('.contador');
                    if (contador) {
                        const [actual, total] = contador.textContent.split(' / ');
                        if (parseInt(actual) >= parseInt(total)) {
                            // Es el último jugador - limpiar localStorage
                            setTimeout(function() {
                                localStorage.removeItem('musicaTiempo');
                                localStorage.removeItem('musicaEstado');
                            }, 1000);
                        } else {
                            // No es el último jugador - guardar estado actual
                            localStorage.setItem('musicaTiempo', musicaFondo.currentTime);
                            localStorage.setItem('musicaEstado', musicaFondo.paused ? 'pausada' : 'reproduciendo');
                        }
                    }
                });
            }
            
            // Prevenir que se limpie el estado accidentalmente durante la navegación
            window.addEventListener('beforeunload', function() {
                // Solo mantener el estado si no es el último jugador
                const contador = document.querySelector('.contador');
                if (contador) {
                    const [actual, total] = contador.textContent.split(' / ');
                    if (parseInt(actual) < parseInt(total)) {
                        // No es el último jugador, mantener el estado
                        localStorage.setItem('musicaTiempo', musicaFondo.currentTime);
                        localStorage.setItem('musicaEstado', musicaFondo.paused ? 'pausada' : 'reproduciendo');
                    }
                }
            });
        });
    </script>
</body>
</html>