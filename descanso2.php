<?php
require_once 'includes/config.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_autenticado'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descanso 1 - Torneo FIFA 26</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #000;
            color: #fff;
            overflow: hidden;
            height: 100vh;
        }

        /* Contenedor del video en pantalla completa */
        .video-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .video-descanso {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Overlay para el contenido en esquina inferior derecha */
        .overlay {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        /* Contenido principal */
        .contenido-descanso {
            max-width: 400px;
            padding: 25px;
            background: rgba(26, 26, 46, 0.9);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 215, 0, 0.5);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7);
        }

        .titulo-descanso {
            font-size: 2.5rem;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #ffd700, #ffed4e, #ffd700);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
        }

        .subtitulo-descanso {
            font-size: 1.3rem;
            margin-bottom: 15px;
            color: #b0b0b0;
        }

        .mensaje-descanso {
            font-size: 1rem;
            margin-bottom: 20px;
            line-height: 1.4;
            color: #ffffff;
        }

        /* Botones */
        .botones-descanso {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .boton-volver, .boton-siguiente-descanso {
            background: rgba(233, 69, 96, 0.9);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 3px 10px rgba(233, 69, 96, 0.3);
        }

        .boton-volver:hover, .boton-siguiente-descanso:hover {
            background: rgba(233, 69, 96, 1);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(233, 69, 96, 0.5);
        }

        .boton-siguiente-descanso {
            background: rgba(255, 215, 0, 0.9);
            color: #1a1a2e;
            box-shadow: 0 3px 10px rgba(255, 215, 0, 0.3);
        }

        .boton-siguiente-descanso:hover {
            background: rgba(255, 215, 0, 1);
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.5);
        }

        /* Temporizador */
        .temporizador {
            position: fixed;
            top: 20px;
            left: 20px;
            background: rgba(0, 0, 0, 0.7);
            padding: 12px 20px;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: bold;
            z-index: 100;
            border: 2px solid rgba(255, 215, 0, 0.5);
            color: #ffd700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Animaciones */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .contenido-descanso {
            animation: fadeInUp 0.8s ease;
        }

        /* Efectos de partículas */
        .particulas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        .particula {
            position: absolute;
            width: 3px;
            height: 3px;
            background: rgba(255, 215, 0, 0.4);
            border-radius: 50%;
            animation: float 8s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            50% {
                transform: translateY(-80px) translateX(80px);
                opacity: 0;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .overlay {
                bottom: 15px;
                right: 15px;
                left: 15px;
                align-items: center;
            }
            
            .contenido-descanso {
                max-width: 100%;
                text-align: center;
                padding: 20px;
            }
            
            .titulo-descanso {
                font-size: 2rem;
            }
            
            .subtitulo-descanso {
                font-size: 1.1rem;
            }
            
            .mensaje-descanso {
                font-size: 0.9rem;
            }
            
            .botones-descanso {
                justify-content: center;
            }
            
            .temporizador {
                top: 15px;
                left: 15px;
                padding: 10px 15px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .overlay {
                bottom: 10px;
                right: 10px;
                left: 10px;
            }
            
            .contenido-descanso {
                padding: 15px;
            }
            
            .titulo-descanso {
                font-size: 1.8rem;
            }
            
            .subtitulo-descanso {
                font-size: 1rem;
            }
            
            .mensaje-descanso {
                font-size: 0.85rem;
            }
            
            .botones-descanso {
                flex-direction: column;
                align-items: center;
            }
            
            .boton-volver, .boton-siguiente-descanso {
                width: 100%;
                max-width: 200px;
                justify-content: center;
                padding: 8px 16px;
                font-size: 0.85rem;
            }
        }

        /* Efecto de brillo sutil en el contenido */
        .contenido-descanso::before {
            content: '';
            position: absolute;
            top: -2px;
            right: -2px;
            bottom: -2px;
            left: -2px;
            background: linear-gradient(45deg, transparent, rgba(255, 215, 0, 0.1), transparent);
            border-radius: 17px;
            z-index: -1;
            animation: shine 3s ease-in-out infinite;
        }

        @keyframes shine {
            0%, 100% {
                opacity: 0.3;
            }
            50% {
                opacity: 0.7;
            }
        }
    </style>
    <!-- Iconos de Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Video de fondo en pantalla completa -->
    <div class="video-container">
        <video class="video-descanso" autoplay muted loop playsinline>
            <source src="img/descanso2.mp4" type="video/mp4">
            Tu navegador no soporta el elemento de video.
        </video>
    </div>

    <!-- Efectos de partículas -->
    <div class="particulas" id="particulas"></div>

    <!-- Overlay con contenido en esquina inferior derecha -->
    <div class="overlay">
        <div class="contenido-descanso">
            <h1 class="titulo-descanso">DESCANSO 2</h1>
            <h2 class="subtitulo-descanso">Tiempo para Recargar</h2>
            <p class="mensaje-descanso">
                Aprovecha este momento para descansar y prepararte para la siguiente ronda.
            </p>
            
            <div class="botones-descanso">
                <a href="index.php" class="boton-volver">
                    <i class="fas fa-home"></i>
                    Inicio
                </a>
                <a href="descanso2.php" class="boton-siguiente-descanso">
                    <i class="fas fa-forward"></i>
                    Siguiente
                </a>
            </div>
        </div>
    </div>

    <!-- Temporizador -->
    <div class="temporizador">
        <i class="fas fa-clock"></i>
        <span id="tiempo-transcurrido">00:00</span>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const videoDescanso = document.querySelector('.video-descanso');
            const temporizador = document.getElementById('tiempo-transcurrido');
            
            // Temporizador
            let segundos = 0;
            const actualizarTemporizador = () => {
                segundos++;
                const minutos = Math.floor(segundos / 60);
                const segs = segundos % 60;
                temporizador.textContent = `${minutos.toString().padStart(2, '0')}:${segs.toString().padStart(2, '0')}`;
            };
            
            setInterval(actualizarTemporizador, 1000);
            
            // Crear partículas
            function crearParticulas() {
                const contenedor = document.getElementById('particulas');
                const cantidad = 15;
                
                for (let i = 0; i < cantidad; i++) {
                    const particula = document.createElement('div');
                    particula.className = 'particula';
                    
                    // Posición aleatoria
                    particula.style.left = Math.random() * 100 + 'vw';
                    particula.style.top = Math.random() * 100 + 'vh';
                    
                    // Tamaño aleatorio
                    const tamaño = Math.random() * 2 + 1;
                    particula.style.width = tamaño + 'px';
                    particula.style.height = tamaño + 'px';
                    
                    // Opacidad aleatoria
                    particula.style.opacity = Math.random() * 0.3 + 0.1;
                    
                    // Animación con delay aleatorio
                    particula.style.animationDelay = Math.random() * 8 + 's';
                    particula.style.animationDuration = (Math.random() * 4 + 6) + 's';
                    
                    contenedor.appendChild(particula);
                }
            }
            
            crearParticulas();
            
            // Asegurar que el video se reproduzca correctamente
            videoDescanso.play().catch(error => {
                console.log('Error al reproducir el video:', error);
            });
        });
    </script>
</body>
</html>