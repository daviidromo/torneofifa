<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reproductor de Sonidos - Torneo FIFA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            --border-radius: 10px;
            --box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
            color: var(--text-color);
            min-height: 100vh;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* ===== HEADER ===== */
        .header-sonidos {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header-sonidos h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: var(--text-color);
        }

        .path-info {
            margin-bottom: 15px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.15);
            color: var(--text-color);
            border: none;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
        }

        .button:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .header-sonidos p {
            font-size: 1.1rem;
            color: var(--text-secondary);
            max-width: 800px;
            margin: 0 auto;
        }

        /* ===== SECCIÓN DE JUGADORES CON CANCIONES ===== */
        .players-section {
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: var(--box-shadow);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .section-title {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .section-title i {
            font-size: 2rem;
            margin-right: 15px;
            color: var(--gold-color);
        }

        .section-title h2 {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .players-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
        }

        .player-card {
            background: rgba(255, 255, 255, 0.08);
            border-radius: var(--border-radius);
            padding: 20px;
            text-align: center;
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .player-card:hover {
            background: rgba(255, 255, 255, 0.12);
        }

        .player-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            font-weight: bold;
        }

        .player-name {
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 1.4rem;
            color: var(--text-color);
        }

        .player-song {
            font-size: 1rem;
            color: var(--text-secondary);
            margin-bottom: 15px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .player-controls {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .player-play-btn {
            background: linear-gradient(135deg, var(--highlight-color), #ff6b6b);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 700;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            flex: 1;
            justify-content: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .player-play-btn:hover {
            transform: scale(1.05);
        }

        .player-play-btn.playing {
            background: linear-gradient(135deg, #4CAF50, #2E7D32);
        }

        /* ===== SECCIÓN DE SONIDOS ===== */
        .sonidos-section {
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: var(--box-shadow);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
        }

        .category {
            background: rgba(255, 255, 255, 0.08);
            border-radius: var(--border-radius);
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .category-title {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .category-title i {
            font-size: 1.8rem;
            margin-right: 15px;
            color: var(--gold-color);
        }

        .category-title h2 {
            font-size: 1.6rem;
            font-weight: 700;
        }

        .sound-list {
            display: grid;
            gap: 10px;
        }

        .sound-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            padding: 15px;
            display: flex;
            align-items: center;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .sound-item:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .sound-info {
            flex-grow: 1;
        }

        .sound-name {
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 1.2rem;
            color: var(--text-color);
        }

        .sound-details {
            font-size: 0.9rem;
            color: var(--text-secondary);
            display: flex;
            justify-content: space-between;
        }

        .play-btn {
            background: linear-gradient(135deg, var(--highlight-color), #ff6b6b);
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            margin-left: 15px;
            transition: var(--transition);
            font-size: 1.2rem;
        }

        .play-btn:hover {
            transform: scale(1.1);
        }

        .play-btn.playing {
            background: linear-gradient(135deg, #4CAF50, #2E7D32);
        }

        /* ===== CONTROLES GLOBALES ===== */
        .global-controls {
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: var(--box-shadow);
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .control-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .control-btn {
            background: linear-gradient(135deg, var(--highlight-color), #ff6b6b);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 700;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: var(--transition);
            min-width: 180px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .control-btn:hover {
            transform: scale(1.05);
        }

        .control-btn.stop {
            background: linear-gradient(135deg, #0072CE, #0033A0);
        }

        .control-btn.random {
            background: linear-gradient(135deg, #4CAF50, #2E7D32);
        }

        .volume-control {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-top: 15px;
        }

        .volume-control label {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .volume-slider {
            width: 200px;
            height: 10px;
            -webkit-appearance: none;
            appearance: none;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            outline: none;
        }

        .volume-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--highlight-color), #ff6b6b);
            cursor: pointer;
        }

        /* ===== FOOTER ===== */
        footer {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        footer p {
            font-size: 1rem;
            color: var(--text-secondary);
            font-weight: 600;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .players-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .categories {
                grid-template-columns: 1fr;
            }
            
            .control-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .control-btn {
                width: 100%;
                max-width: 300px;
            }
        }

        @media (max-width: 576px) {
            .players-grid {
                grid-template-columns: 1fr;
            }
            
            .header-sonidos h1 {
                font-size: 2rem;
            }
            
            .section-title {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
            
            .section-title i {
                margin-right: 0;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header-sonidos">
            <h1><i class="fas fa-futbol"></i> Reproductor de Sonidos - Torneo FIFA</h1>
            <div class="path-info">
                <a href="index.php" class="button"><i class="fas fa-folder"></i> Volver al índice</a>
            </div>
            <p>Reproduce los sonidos OGG de tu torneo de FIFA con un solo clic</p>
        </header>

        <!-- Sección de jugadores con canciones -->
        <div class="players-section">
            <div class="section-title">
                <i class="fas fa-music"></i>
                <h2>Canciones de Jugadores</h2>
            </div>
            <p style="text-align: center; margin-bottom: 20px; color: var(--text-secondary); font-size: 1rem;">
                Selecciona un jugador para reproducir su canción asignada
            </p>
            
            <div class="players-grid" id="players-container">
                <!-- Los jugadores se cargarán aquí -->
            </div>
        </div>

        <!-- Sección de sonidos -->
        <div class="sonidos-section">
            <div class="categories">
                <div class="category">
                    <div class="category-title">
                        <i class="fas fa-users"></i>
                        <h2>Reacciones del Público</h2>
                    </div>
                    <div class="sound-list" id="public-sounds">
                        <!-- Los sonidos del público se cargarán aquí -->
                    </div>
                </div>

                <div class="category">
                    <div class="category-title">
                        <i class="fas fa-user-friends"></i>
                        <h2>Jugadores y Comentaristas</h2>
                    </div>
                    <div class="sound-list" id="player-sounds">
                        <!-- Los sonidos de jugadores y comentaristas se cargarán aquí -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Controles globales -->
        <div class="global-controls">
            <div class="section-title" style="justify-content: center; border: none;">
                <i class="fas fa-sliders-h"></i>
                <h2>Controles Globales</h2>
            </div>
            
            <div class="control-buttons">
                <button class="control-btn" id="play-all">
                    <i class="fas fa-play"></i> Reproducir Todos
                </button>
                <button class="control-btn stop" id="stop-all">
                    <i class="fas fa-stop"></i> Detener Todos
                </button>
                <button class="control-btn random" id="random-sound">
                    <i class="fas fa-random"></i> Sonido Aleatorio
                </button>
            </div>
            
            <div class="volume-control">
                <label for="volume">
                    <i class="fas fa-volume-up"></i> Volumen:
                </label>
                <input type="range" id="volume" class="volume-slider" min="0" max="1" step="0.1" value="0.7">
            </div>
        </div>

        <footer>
            <p>Reproductor de sonidos para Torneo FIFA | Total: 15 archivos OGG + 8 canciones de jugadores</p>
        </footer>
    </div>

    <script>
    // Datos de los sonidos
    const sounds = [
        { name: "abucheos", date: "21/12/2025 11:39", type: "OGG", size: "18 KB", category: "public" },
        { name: "dondeCR7", date: "21/12/2025 11:39", type: "OGG", size: "18 KB", category: "public" },
        { name: "aplausos", date: "21/12/2025 11:38", type: "OGG", size: "16 KB", category: "public" },
        { name: "goool", date: "17/12/2025 11:01", type: "OGG", size: "23 KB", category: "public" },
        { name: "latatata", date: "21/12/2025 11:42", type: "OGG", size: "17 KB", category: "player" },
        { name: "oles", date: "21/12/2025 11:39", type: "OGG", size: "35 KB", category: "public" },
        { name: "siuuuuuu", date: "21/12/2025 11:38", type: "OGG", size: "20 KB", category: "public" },
        { name: "trompeta", date: "21/12/2025 11:40", type: "OGG", size: "24 KB", category: "public" },
        { name: "alpalo", date: "21/12/2025 11:41", type: "OGG", size: "10 KB", category: "player" },
        { name: "AncaraMessi", date: "21/12/2025 11:41", type: "OGG", size: "32 KB", category: "player" },
        { name: "benzemaa", date: "21/12/2025 11:41", type: "OGG", size: "17 KB", category: "player" },
        { name: "cristianoo", date: "21/12/2025 11:41", type: "OGG", size: "23 KB", category: "player" },
        { name: "ibai", date: "21/12/2025 11:39", type: "OGG", size: "14 KB", category: "player" },
        { name: "pejino", date: "21/12/2025 11:40", type: "OGG", size: "21 KB", category: "player" }
    ];

    // Datos de los jugadores con sus canciones
    const players = [
        { id: 1, name: "Romo", song: "Romo", avatar: "R", color: "#00b4db" },
        { id: 2, name: "Jogi", song: "Jogi", avatar: "J", color: "#ff416c" },
        { id: 3, name: "Josete", song: "Josete", avatar: "J", color: "#ffb347" },
        { id: 4, name: "Huevo", song: "Huevo", avatar: "H", color: "#7b68ee" },
        { id: 5, name: "Carlos", song: "Carlos", avatar: "C", color: "#32cd32" },
        { id: 6, name: "Ivanoskyx", song: "Ivanoskyx", avatar: "I", color: "#ff69b4" },
        { id: 7, name: "Figueroa", song: "Figueroa", avatar: "F", color: "#1e90ff" },
        { id: 8, name: "Reyes", song: "Reyes", avatar: "R", color: "#ffd700" }
    ];

    // Elementos de audio activos
    let activeAudios = [];
    let currentPlaying = null;

    // Cargar jugadores con canciones
    function loadPlayers() {
        const playersContainer = document.getElementById('players-container');
        
        players.forEach(player => {
            // Crear elemento de jugador
            const playerElement = document.createElement('div');
            playerElement.className = 'player-card';
            playerElement.innerHTML = `
                <div class="player-avatar" style="background: linear-gradient(135deg, ${player.color}, ${player.color}80);">
                    ${player.avatar}
                </div>
                <div class="player-name">${player.name}</div>
                <div class="player-song">Canción: ${player.song}.ogg</div>
                <div class="player-controls">
                    <button class="player-play-btn" data-player="${player.id}" data-song="${player.song}">
                        <i class="fas fa-play"></i> Reproducir
                    </button>
                </div>
            `;
            
            playersContainer.appendChild(playerElement);
        });
        
        // Añadir event listeners a los botones de jugadores
        document.querySelectorAll('.player-play-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const songName = this.getAttribute('data-song');
                const playerId = this.getAttribute('data-player');
                
                if (this.classList.contains('playing')) {
                    stopAllSounds();
                    resetAllButtons();
                } else {
                    playPlayerSong(songName, this, playerId);
                }
            });
        });
    }

    // Reproducir canción de jugador
    function playPlayerSong(songName, buttonElement, playerId) {
        // Detener todos los sonidos activos
        stopAllSounds();
        resetAllButtons();
        
        // Crear elemento de audio
        const audio = new Audio(`sonidos/${songName}.ogg`);
        audio.volume = document.getElementById('volume').value;
        
        // Actualizar estado del botón
        buttonElement.classList.add('playing');
        buttonElement.innerHTML = '<i class="fas fa-stop"></i> Detener';
        
        // Reproducir sonido
        audio.play().catch(error => {
            console.error("Error al reproducir el audio:", error);
            buttonElement.classList.remove('playing');
            buttonElement.innerHTML = '<i class="fas fa-play"></i> Reproducir';
        });
        
        currentPlaying = { audio, button: buttonElement, type: 'player' };
        
        // Restaurar el botón cuando termine el sonido
        audio.onended = function() {
            buttonElement.classList.remove('playing');
            buttonElement.innerHTML = '<i class="fas fa-play"></i> Reproducir';
            currentPlaying = null;
        };
    }

    // Cargar sonidos en las categorías
    function loadSounds() {
        const publicContainer = document.getElementById('public-sounds');
        const playerContainer = document.getElementById('player-sounds');
        
        sounds.forEach(sound => {
            // Crear elemento de sonido
            const soundElement = document.createElement('div');
            soundElement.className = 'sound-item';
            soundElement.innerHTML = `
                <div class="sound-info">
                    <div class="sound-name">${sound.name}</div>
                    <div class="sound-details">
                        <span>${sound.type}</span>
                        <span>${sound.size}</span>
                        <span>${sound.date}</span>
                    </div>
                </div>
                <button class="play-btn" data-sound="${sound.name}">
                    <i class="fas fa-play"></i>
                </button>
            `;
            
            // Agregar a la categoría correspondiente
            if (sound.category === 'public') {
                publicContainer.appendChild(soundElement);
            } else {
                playerContainer.appendChild(soundElement);
            }
        });
        
        // Añadir event listeners a los botones de reproducción
        document.querySelectorAll('.play-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const soundName = this.getAttribute('data-sound');
                
                if (this.classList.contains('playing')) {
                    stopAllSounds();
                    resetAllButtons();
                } else {
                    playSound(soundName, this);
                }
            });
        });
    }

    // Reproducir un sonido específico
    function playSound(soundName, buttonElement) {
        // Detener todos los sonidos activos
        stopAllSounds();
        resetAllButtons();
        
        // Crear elemento de audio
        const audio = new Audio(`sonidos/${soundName}.ogg`);
        audio.volume = document.getElementById('volume').value;
        
        // Actualizar estado del botón
        buttonElement.classList.add('playing');
        buttonElement.innerHTML = '<i class="fas fa-stop"></i>';
        
        // Reproducir sonido
        audio.play().catch(error => {
            console.error("Error al reproducir el audio:", error);
            buttonElement.classList.remove('playing');
            buttonElement.innerHTML = '<i class="fas fa-play"></i>';
        });
        
        currentPlaying = { audio, button: buttonElement, type: 'sound' };
        
        // Restaurar el botón cuando termine el sonido
        audio.onended = function() {
            buttonElement.classList.remove('playing');
            buttonElement.innerHTML = '<i class="fas fa-play"></i>';
            currentPlaying = null;
        };
    }

    // Resetear todos los botones a su estado inicial
    function resetAllButtons() {
        // Resetear botones de jugadores
        document.querySelectorAll('.player-play-btn').forEach(btn => {
            btn.classList.remove('playing');
            btn.innerHTML = '<i class="fas fa-play"></i> Reproducir';
        });
        
        // Resetear botones de sonidos
        document.querySelectorAll('.play-btn').forEach(btn => {
            btn.classList.remove('playing');
            btn.innerHTML = '<i class="fas fa-play"></i>';
        });
    }

    // Detener todos los sonidos
    function stopAllSounds() {
        if (currentPlaying && currentPlaying.audio) {
            currentPlaying.audio.pause();
            currentPlaying.audio.currentTime = 0;
        }
        currentPlaying = null;
    }

    // Reproducir todos los sonidos en secuencia
    function playAllSounds() {
        stopAllSounds();
        resetAllButtons();
        
        let index = 0;
        
        function playNext() {
            if (index < sounds.length) {
                const sound = sounds[index];
                const button = document.querySelector(`.play-btn[data-sound="${sound.name}"]`);
                
                if (button) {
                    button.click();
                    
                    // Configurar para reproducir el siguiente cuando termine
                    if (currentPlaying && currentPlaying.audio) {
                        currentPlaying.audio.onended = function() {
                            index++;
                            playNext();
                        };
                    } else {
                        index++;
                        setTimeout(playNext, 1000);
                    }
                } else {
                    index++;
                    playNext();
                }
            }
        }
        
        playNext();
    }

    // Reproducir un sonido aleatorio
    function playRandomSound() {
        const randomIndex = Math.floor(Math.random() * sounds.length);
        const randomSound = sounds[randomIndex];
        
        // Encontrar el botón correspondiente
        const button = document.querySelector(`.play-btn[data-sound="${randomSound.name}"]`);
        if (button) {
            button.click();
        }
    }

    // Inicializar controles
    document.addEventListener('DOMContentLoaded', function() {
        loadPlayers();
        loadSounds();
        
        // Configurar controles globales
        document.getElementById('play-all').addEventListener('click', playAllSounds);
        document.getElementById('stop-all').addEventListener('click', function() {
            stopAllSounds();
            resetAllButtons();
        });
        document.getElementById('random-sound').addEventListener('click', playRandomSound);
        
        // Configurar control de volumen
        document.getElementById('volume').addEventListener('input', function() {
            const volume = this.value;
            if (currentPlaying && currentPlaying.audio) {
                currentPlaying.audio.volume = volume;
            }
        });
        
        // Añadir atajos de teclado
        document.addEventListener('keydown', function(e) {
            // Espacio para detener todos los sonidos
            if (e.code === 'Space') {
                e.preventDefault();
                stopAllSounds();
                resetAllButtons();
            }
            
            // R para sonido aleatorio
            if (e.code === 'KeyR') {
                e.preventDefault();
                playRandomSound();
            }
        });
    });
</script>
</body>
</html>