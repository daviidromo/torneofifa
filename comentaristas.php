<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruleta de Comentaristas por Equipo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: #fff;
            min-height: 100vh;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            width: 100%;
        }

        h1 {
            font-size: 2.8rem;
            color: #f8c630;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 1.2rem;
            color: #ddd;
            max-width: 800px;
            margin: 0 auto;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            width: 100%;
            max-width: 1400px;
        }

        .panel {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .players-panel {
            flex: 1;
            min-width: 300px;
            max-width: 500px;
        }

        .roulette-panel {
            flex: 2;
            min-width: 500px;
            max-width: 700px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .results-panel {
            flex: 1;
            min-width: 300px;
            max-width: 400px;
        }

        .panel-title {
            font-size: 1.8rem;
            color: #f8c630;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .panel-title i {
            font-size: 1.5rem;
        }

        .player-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .player-card {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .player-card:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-3px);
        }

        .player-card.selected-playing {
            background: rgba(220, 53, 69, 0.2);
            border-color: #dc3545;
        }

        .player-card.selected-commentator-a {
            background: rgba(40, 167, 69, 0.2);
            border-color: #28a745;
        }

        .player-card.selected-commentator-b {
            background: rgba(0, 123, 255, 0.2);
            border-color: #007bff;
        }

        .player-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6c5ce7, #a29bfe); /* Color por defecto para todos los jugadores en la lista */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
        }

        .player-info {
            flex-grow: 1;
        }

        .player-name {
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .player-status {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .controls {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 50px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(to right, #f8c630, #ff9f00);
            color: #1a1a2e;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(248, 198, 48, 0.4);
        }

        .btn-primary:disabled {
            background: #666;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .roulette-container {
            width: 400px;
            height: 400px;
            position: relative;
            margin: 30px 0;
        }

        .roulette-wheel {
            width: 100%;
            height: 100%;
            position: relative;
            transition: transform 4s cubic-bezier(0.17, 0.67, 0.21, 0.99);
            border-radius: 50%;
            overflow: hidden;
        }

        /* Ruleta con círculo completo usando 6 sectores de 60 grados cada uno */
        .roulette-sector {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            clip-path: polygon(50% 50%, 50% 0%, 100% 0%);
            transform-origin: center;
            border-radius: 50%;
        }

        /* Colores de los sectores - círculo completo */
        .sector-0 { 
            background-color: #FF6B6B;
            transform: rotate(0deg);
        }
        
        .sector-1 { 
            background-color: #4ECDC4;
            transform: rotate(60deg);
        }
        
        .sector-2 { 
            background-color: #FFD166;
            transform: rotate(120deg);
        }
        
        .sector-3 { 
            background-color: #06D6A0;
            transform: rotate(180deg);
        }
        
        .sector-4 { 
            background-color: #118AB2;
            transform: rotate(240deg);
        }
        
        .sector-5 { 
            background-color: #9D4EDD;
            transform: rotate(300deg);
        }

        /* Estilos para sectores seleccionados */
        .roulette-sector.selected {
            opacity: 0.5;
            position: relative;
        }

        .roulette-sector.selected::after {
            content: "✓";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-60deg); /* Ajustar la rotación para que el checkmark esté derecho */
            font-size: 3rem;
            color: white;
            font-weight: bold;
            text-shadow: 0 0 10px rgba(0,0,0,0.8);
            z-index: 5;
        }

        .roulette-sector-content {
            position: absolute;
            top: 30%;
            left: 70%;
            transform: rotate(30deg);
            transform-origin: center;
            width: 80px;
            text-align: center;
            z-index: 2;
        }

        .player-number {
            font-weight: bold;
            font-size: 1.8rem;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .player-initial {
            font-weight: bold;
            font-size: 1.5rem;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .roulette-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            background: #1a1a2e;
            border-radius: 50%;
            z-index: 10;
            border: 5px solid #f8c630;
            box-shadow: 0 0 15px rgba(248, 198, 48, 0.5);
        }

        .roulette-pointer {
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 60px;
            z-index: 20;
        }

        .pointer-triangle {
            width: 0;
            height: 0;
            border-left: 20px solid transparent;
            border-right: 20px solid transparent;
            border-top: 40px solid #dc3545;
            filter: drop-shadow(0 0 5px rgba(220, 53, 69, 0.7));
        }

        .results-container {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .result-card {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
        }

        .result-title {
            font-size: 1.3rem;
            margin-bottom: 15px;
            color: #f8c630;
        }

        .selected-player {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .selected-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: bold;
            color: #1a1a2e;
        }

        .selected-name {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .selected-team {
            font-size: 1.1rem;
            padding: 8px 20px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
        }

        .team-a {
            color: #4ECDC4;
            border: 2px solid #4ECDC4;
        }

        .team-b {
            color: #FF6B6B;
            border: 2px solid #FF6B6B;
        }

        .history-list {
            margin-top: 15px;
            max-height: 150px;
            overflow-y: auto;
        }

        .history-item {
            padding: 8px 12px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .history-item span {
            color: #f8c630;
            font-weight: bold;
        }

        .instructions {
            max-width: 800px;
            margin-top: 30px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            font-size: 1rem;
            line-height: 1.6;
        }

        .instructions h3 {
            color: #f8c630;
            margin-bottom: 10px;
        }

        .instructions ol {
            padding-left: 20px;
        }

        .instructions li {
            margin-bottom: 8px;
        }

        .counter {
            font-size: 1.2rem;
            margin-top: 10px;
            color: #f8c630;
            font-weight: bold;
        }

        .color-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
            justify-content: center;
        }

        .color-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
            padding: 5px 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
        }

        .color-box {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .selection-info {
            margin-top: 15px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            font-size: 1.1rem;
            text-align: center;
            color: #f8c630;
        }

        .selection-step {
            margin-top: 15px;
            font-size: 1.1rem;
            text-align: center;
            padding: 10px;
            border-radius: 10px;
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        @media (max-width: 1100px) {
            .container {
                flex-direction: column;
                align-items: center;
            }
            
            .panel {
                width: 100%;
                max-width: 700px;
            }
            
            .roulette-container {
                width: 350px;
                height: 350px;
            }
        }

        @media (max-width: 600px) {
            .roulette-container {
                width: 300px;
                height: 300px;
            }
            
            h1 {
                font-size: 2.2rem;
            }
            
            .player-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="fas fa-dharmachakra"></i> Ruleta de Comentaristas por Equipo</h1>
        <p class="subtitle">Selecciona qué 2 jugadores están en el partido, luego gira la ruleta dos veces para seleccionar un comentarista para cada equipo.</p>
    </div>

    <div class="container">
        <div class="panel players-panel">
            <h2 class="panel-title"><i class="fas fa-users"></i> Jugadores</h2>
            <div class="counter" id="selectedCounter">Seleccionados para jugar: 0/2</div>
            <div class="player-list" id="playerList">
                <!-- Los jugadores se cargarán aquí con JavaScript -->
            </div>
            
            <div class="controls">
                <button class="btn btn-primary" id="spinButton" disabled>
                    <i class="fas fa-play"></i> Girar Ruleta
                </button>
                <button class="btn btn-secondary" id="resetButton">
                    <i class="fas fa-redo"></i> Reiniciar Todo
                </button>
            </div>
            
            <div class="selection-info" id="selectionInfo">
                Esperando selección de jugadores para el partido...
            </div>
            
            <div class="selection-step" id="selectionStep">
                Paso 1: Selecciona 2 jugadores para el partido
            </div>
            
            <div class="instructions" style="margin-top: 25px; padding: 15px; font-size: 0.9rem;">
                <h3>Instrucciones:</h3>
                <ol>
                    <li>Haz clic en 2 jugadores para marcarlos como "EN EL PARTIDO".</li>
                    <li>Los 6 jugadores restantes estarán disponibles en la ruleta.</li>
                    <li>Haz clic en "Girar Ruleta" para seleccionar el primer comentarista (Equipo A).</li>
                    <li>Haz clic en "Girar Ruleta" de nuevo para seleccionar el segundo comentarista (Equipo B).</li>
                    <li>Los colores en la ruleta corresponden a cada jugador disponible.</li>
                </ol>
            </div>
        </div>
        
        <div class="panel roulette-panel">
            <h2 class="panel-title"><i class="fas fa-dharmachakra"></i> Ruleta</h2>
            <div class="color-legend" id="colorLegend">
                <!-- La leyenda de colores se generará con JavaScript -->
            </div>
            <div class="roulette-container">
                <div class="roulette-wheel" id="rouletteWheel">
                    <!-- Los sectores de la ruleta se generarán con JavaScript -->
                </div>
                <div class="roulette-center"></div>
                <div class="roulette-pointer">
                    <div class="pointer-triangle"></div>
                </div>
            </div>
            <div class="controls">
                <div class="counter" id="spinCounter">Giros realizados: 0/2 
            </div>
        </div>
        
        <div class="panel results-panel">
            <h2 class="panel-title"><i class="fas fa-trophy"></i> Resultados</h2>
            <div class="results-container">
                <div class="result-card">
                    <h3 class="result-title">Comentarista Equipo A</h3>
                    <div class="selected-player" id="commentatorA">
                        <div class="selected-avatar">?</div>
                        <div class="selected-name">Por seleccionar</div>
                        <div class="selected-team team-a">Equipo A</div>
                    </div>
                </div>
                
                <div class="result-card">
                    <h3 class="result-title">Comentarista Equipo B</h3>
                    <div class="selected-player" id="commentatorB">
                        <div class="selected-avatar">?</div>
                        <div class="selected-name">Por seleccionar</div>
                        <div class="selected-team team-b">Equipo B</div>
                    </div>
                </div>
                
                <div class="result-card">
                    <h3 class="result-title">Jugadores en el Partido</h3>
                    <div class="selected-player" id="playingPlayers">
                        <div class="selected-avatar"><i class="fas fa-users"></i></div>
                        <div class="selected-name" id="playingNames">Por seleccionar</div>
                        <div class="selected-team" style="color: #dc3545; border-color: #dc3545;">En el partido</div>
                    </div>
                </div>
                
                <div class="result-card">
                    <h3 class="result-title">Historial de Selecciones</h3>
                    <div class="history-list" id="historyList">
                        <!-- El historial se cargará aquí con JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Botón Volver al Inicio -->
    <div style="margin: 30px 0; text-align: center;">
        <a href="index.php" class="btn btn-primary" style="text-decoration: none;">
            <i class="fas fa-home"></i> 🏠 Volver al Inicio
        </a>
    </div>
    <script>
        // Datos de los jugadores iniciales
        const players = [
            { id: 1, name: "Huevo", number: 1, initial: "C" },
            { id: 2, name: "Romo", number: 2, initial: "A" },
            { id: 3, name: "Figueroa", number: 3, initial: "D" },
            { id: 4, name: "Reyes", number: 4, initial: "J" },
            { id: 5, name: "Ivanoskyx", number: 5, initial: "M" },
            { id: 6, name: "Jogi", number: 6, initial: "R" },
            { id: 7, name: "Josete", number: 7, initial: "F" },
            { id: 8, name: "Carlos", number: 8, initial: "S" }
        ];

        // Variables de estado
        let selectedPlayingPlayers = [];
        let roulettePlayers = []; // Jugadores que están en la ruleta (6 jugadores)
        let commentatorA = null;
        let commentatorB = null;
        let rouletteAngle = 0;
        let isSpinning = false;
        let spinCount = 0;
        let selectionHistory = [];
        let colorMap = {}; // Mapa de colores por jugador (solo para la ruleta)

        // Colores disponibles para la ruleta (6 colores)
        const colors = [
            { name: "Rojo", value: "#FF6B6B", class: "sector-0" },
            { name: "Turquesa", value: "#4ECDC4", class: "sector-1" },
            { name: "Amarillo", value: "#FFD166", class: "sector-2" },
            { name: "Verde", value: "#06D6A0", class: "sector-3" },
            { name: "Azul", value: "#118AB2", class: "sector-4" },
            { name: "Morado", value: "#9D4EDD", class: "sector-5" }
        ];

        // Elementos DOM
        const playerListElement = document.getElementById('playerList');
        const rouletteWheelElement = document.getElementById('rouletteWheel');
        const spinButton = document.getElementById('spinButton');
        const resetButton = document.getElementById('resetButton');
        const commentatorAElement = document.getElementById('commentatorA');
        const commentatorBElement = document.getElementById('commentatorB');
        const playingNamesElement = document.getElementById('playingNames');
        const historyListElement = document.getElementById('historyList');
        const selectedCounterElement = document.getElementById('selectedCounter');
        const spinCounterElement = document.getElementById('spinCounter');
        const colorLegendElement = document.getElementById('colorLegend');
        const selectionInfoElement = document.getElementById('selectionInfo');
        const selectionStepElement = document.getElementById('selectionStep');

        // Inicializar la aplicación
        function init() {
            renderPlayerList();
            setupEventListeners();
            updateButtons();
            updateSelectionInfo();
        }

        // Renderizar lista de jugadores
        function renderPlayerList() {
            playerListElement.innerHTML = '';
            
            players.forEach(player => {
                const playerCard = document.createElement('div');
                playerCard.className = 'player-card';
                
                const isPlaying = selectedPlayingPlayers.find(p => p.id === player.id);
                const isCommentatorA = commentatorA && commentatorA.id === player.id;
                const isCommentatorB = commentatorB && commentatorB.id === player.id;
                
                if (isPlaying) {
                    playerCard.classList.add('selected-playing');
                } else if (isCommentatorA) {
                    playerCard.classList.add('selected-commentator-a');
                } else if (isCommentatorB) {
                    playerCard.classList.add('selected-commentator-b');
                }
                
                // NOTA: Todos los jugadores en la lista tienen el mismo color por defecto (púrpura gradiente)
                // Solo en la ruleta tendrán colores diferentes según su posición
                
                playerCard.innerHTML = `
                    <div class="player-icon">${player.number}</div>
                    <div class="player-info">
                        <div class="player-name">${player.name}</div>
                        <div class="player-status">
                            ${isPlaying ? "EN EL PARTIDO" : 
                              isCommentatorA ? "COMENTARISTA EQUIPO A" :
                              isCommentatorB ? "COMENTARISTA EQUIPO B" :
                              roulettePlayers.find(p => p.id === player.id) ? "DISPONIBLE en ruleta" : 
                              "NO DISPONIBLE"}
                        </div>
                    </div>
                `;
                
                playerCard.addEventListener('click', () => togglePlayingPlayer(player));
                playerListElement.appendChild(playerCard);
            });
            
            selectedCounterElement.textContent = `Seleccionados para jugar: ${selectedPlayingPlayers.length}/2`;
            
            if (selectedPlayingPlayers.length > 0) {
                const names = selectedPlayingPlayers.map(p => p.name.split(' ')[0]).join(' y ');
                playingNamesElement.textContent = names;
            } else {
                playingNamesElement.textContent = "Por seleccionar";
            }
        }

        // Alternar jugador seleccionado para jugar
        function togglePlayingPlayer(player) {
            if (selectedPlayingPlayers.length >= 2 && !selectedPlayingPlayers.find(p => p.id === player.id)) {
                alert("Solo puedes seleccionar 2 jugadores para el partido. Deselecciona uno primero.");
                return;
            }
            
            const index = selectedPlayingPlayers.findIndex(p => p.id === player.id);
            
            if (index !== -1) {
                selectedPlayingPlayers.splice(index, 1);
            } else {
                selectedPlayingPlayers.push(player);
            }
            
            // Si ya tenemos 2 jugadores, configurar la ruleta
            if (selectedPlayingPlayers.length === 2) {
                setupRoulette();
            } else {
                clearRoulette();
            }
            
            renderPlayerList();
            renderRoulette();
            updateButtons();
        }

        // Configurar la ruleta
        function setupRoulette() {
            // Los jugadores en la ruleta son los que NO están seleccionados para jugar
            roulettePlayers = players.filter(p => 
                !selectedPlayingPlayers.find(sp => sp.id === p.id)
            );
            
            // Asignar colores a los jugadores en la ruleta
            roulettePlayers.forEach((player, index) => {
                if (index < colors.length) {
                    colorMap[player.id] = colors[index];
                }
            });
            
            // Resetear comentaristas
            commentatorA = null;
            commentatorB = null;
            spinCount = 0;
            rouletteAngle = 0; // Resetear el ángulo de la ruleta
            
            // Actualizar visualizaciones
            commentatorAElement.innerHTML = `
                <div class="selected-avatar">?</div>
                <div class="selected-name">Por seleccionar</div>
                <div class="selected-team team-a">Equipo A</div>
            `;
            
            commentatorBElement.innerHTML = `
                <div class="selected-avatar">?</div>
                <div class="selected-name">Por seleccionar</div>
                <div class="selected-team team-b">Equipo B</div>
            `;
            
            spinCounterElement.textContent = "Giros realizados: 0/2";

        }

        // Limpiar la ruleta
        function clearRoulette() {
            roulettePlayers = [];
            colorMap = {};
            rouletteAngle = 0;
        }

        // Renderizar ruleta
        function renderRoulette() {
            rouletteWheelElement.innerHTML = '';
            colorLegendElement.innerHTML = '';
            
            if (roulettePlayers.length === 0) {
                rouletteWheelElement.innerHTML = `
                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; text-align: center; padding: 20px;">
                        <div>
                            <h3 style="color: #f8c630; margin-bottom: 10px;">Esperando selección</h3>
                            <p>Selecciona 2 jugadores para el partido para activar la ruleta.</p>
                        </div>
                    </div>
                `;
                return;
            }
            
            // Crear un sector por cada jugador en la ruleta (siempre 6)
            roulettePlayers.forEach((player, index) => {
                const sector = document.createElement('div');
                sector.className = `roulette-sector ${colors[index].class}`;
                sector.dataset.playerId = player.id;
                
                // Marcar como seleccionado si ya fue elegido como comentarista
                const isSelected = (commentatorA && commentatorA.id === player.id) || 
                                   (commentatorB && commentatorB.id === player.id);
                
                if (isSelected) {
                    sector.classList.add('selected');
                }
                
                const sectorContent = document.createElement('div');
                sectorContent.className = 'roulette-sector-content';
                
                // Ajustar la posición del contenido para cada sector
                const rotation = index * 60; // 60 grados por sector
                sectorContent.style.transform = `rotate(${30 - rotation}deg)`; // Ajustar para que el texto quede derecho
                
                sectorContent.innerHTML = `
                    <div class="player-number">${player.number}</div>
                    <div class="player-initial">${player.initial}</div>
                `;
                
                sector.appendChild(sectorContent);
                rouletteWheelElement.appendChild(sector);
            });
            
            // Crear leyenda de colores
            roulettePlayers.forEach((player, index) => {
                if (index < colors.length) {
                    const colorItem = document.createElement('div');
                    colorItem.className = 'color-item';
                    
                    let statusText = "Disponible";
                    let statusClass = "";
                    
                    if (commentatorA && commentatorA.id === player.id) {
                        statusText = "Comentarista Equipo A";
                        statusClass = "team-a";
                    } else if (commentatorB && commentatorB.id === player.id) {
                        statusText = "Comentarista Equipo B";
                        statusClass = "team-b";
                    }
                    
                    colorItem.innerHTML = `
                        <div class="color-box" style="background-color: ${colors[index].value}"></div>
                        <span>${player.name}:</span>
                        <span class="${statusClass}">${statusText}</span>
                    `;
                    colorLegendElement.appendChild(colorItem);
                }
            });
            
            // Aplicar rotación actual
            rouletteWheelElement.style.transform = `rotate(${rouletteAngle}deg)`;
        }

        // Girar la ruleta
        function spinRoulette() {
            if (isSpinning || spinCount >= 2 || roulettePlayers.length !== 6) return;
            
            isSpinning = true;
            spinButton.disabled = true;
            
            // Filtrar jugadores disponibles (que no hayan sido seleccionados como comentaristas)
            const availablePlayers = roulettePlayers.filter(player => 
                !(commentatorA && commentatorA.id === player.id) && 
                !(commentatorB && commentatorB.id === player.id)
            );
            
            if (availablePlayers.length === 0) {
                isSpinning = false;
                spinButton.disabled = false;
                return;
            }
            
            // Seleccionar un jugador aleatorio de los disponibles
            const randomIndex = Math.floor(Math.random() * availablePlayers.length);
            const selectedPlayer = availablePlayers[randomIndex];
            
            // Encontrar el índice del jugador en la lista de roulettePlayers
            const playerIndex = roulettePlayers.findIndex(p => p.id === selectedPlayer.id);
            
            // Calcular el ángulo necesario para que el puntero apunte al jugador seleccionado
            // Cada sector tiene 60 grados (360/6)
            // Queremos que el puntero (en la parte superior) apunte al centro del sector
            // El puntero está en 0 grados (parte superior), así que necesitamos girar la ruleta
            // para que el sector seleccionado quede en la parte superior
            
            // El centro del sector está en: playerIndex * 60 + 30 grados
            // Pero como la ruleta gira en sentido horario, necesitamos ajustar
            const sectorCenterAngle = playerIndex * 60 + 30;
            
            // Girar la ruleta varias vueltas completas más el ángulo necesario
            const extraSpins = 5; // Número de vueltas completas adicionales
            const targetAngle = extraSpins * 360 + (360 - sectorCenterAngle);
            
            // Aplicar la animación
            rouletteAngle = targetAngle;
            rouletteWheelElement.style.transform = `rotate(${rouletteAngle}deg)`;
            
            // Determinar el jugador seleccionado después de la animación
            setTimeout(() => {
                if (spinCount === 0) {
                    // Primer comentarista - Equipo A
                    commentatorA = selectedPlayer;
                    
                    // Actualizar visualización del comentarista A
                    commentatorAElement.innerHTML = `
                        <div class="selected-avatar" style="background: linear-gradient(135deg, ${colorMap[selectedPlayer.id].value}, ${adjustColor(colorMap[selectedPlayer.id].value, -20)})">${selectedPlayer.number}</div>
                        <div class="selected-name">${selectedPlayer.name}</div>
                        <div class="selected-team team-a">Equipo A</div>
                    `;
                    
                    // Agregar al historial
                    selectionHistory.unshift({
                        player: selectedPlayer.name,
                        team: "Equipo A",
                        color: colorMap[selectedPlayer.id].name,
                        time: new Date().toLocaleTimeString(),
                        date: new Date().toLocaleDateString()
                    });
                    
                } else if (spinCount === 1) {
                    // Segundo comentarista - Equipo B
                    commentatorB = selectedPlayer;
                    
                    // Actualizar visualización del comentarista B
                    commentatorBElement.innerHTML = `
                        <div class="selected-avatar" style="background: linear-gradient(135deg, ${colorMap[selectedPlayer.id].value}, ${adjustColor(colorMap[selectedPlayer.id].value, -20)})">${selectedPlayer.number}</div>
                        <div class="selected-name">${selectedPlayer.name}</div>
                        <div class="selected-team team-b">Equipo B</div>
                    `;
                    
                    // Agregar al historial
                    selectionHistory.unshift({
                        player: selectedPlayer.name,
                        team: "Equipo B",
                        color: colorMap[selectedPlayer.id].name,
                        time: new Date().toLocaleTimeString(),
                        date: new Date().toLocaleDateString()
                    });
                }
                
                isSpinning = false;
                spinButton.disabled = false;
                
                // Incrementar contador de giros
                spinCount++;
                spinCounterElement.textContent = `Giros realizados: ${spinCount}/2`;
                
                // Actualizar interfaz
                renderPlayerList();
                renderRoulette();
                updateHistory();
                updateButtons();
                updateSelectionInfo();
                
            }, 4000); // Duración de la animación (4 segundos)
        }

        // Reiniciar la aplicación
        function resetApp() {
            // Resetear estado
            selectedPlayingPlayers = [];
            roulettePlayers = [];
            commentatorA = null;
            commentatorB = null;
            rouletteAngle = 0;
            isSpinning = false;
            spinCount = 0;
            colorMap = {};
            
            // Resetear visualizaciones
            commentatorAElement.innerHTML = `
                <div class="selected-avatar">?</div>
                <div class="selected-name">Por seleccionar</div>
                <div class="selected-team team-a">Equipo A</div>
            `;
            
            commentatorBElement.innerHTML = `
                <div class="selected-avatar">?</div>
                <div class="selected-name">Por seleccionar</div>
                <div class="selected-team team-b">Equipo B</div>
            `;
            
            playingNamesElement.textContent = "Por seleccionar";
            spinCounterElement.textContent = "Giros realizados: 0/2";
            
            // Actualizar interfaz
            renderPlayerList();
            renderRoulette();
            updateHistory();
            updateButtons();
            updateSelectionInfo();
        }

        // Actualizar historial
        function updateHistory() {
            historyListElement.innerHTML = '';
            
            if (selectionHistory.length === 0) {
                historyListElement.innerHTML = '<div class="history-item">No hay selecciones anteriores</div>';
                return;
            }
            
            selectionHistory.forEach(entry => {
                const historyItem = document.createElement('div');
                historyItem.className = 'history-item';
                historyItem.innerHTML = `<span>${entry.player}</span> seleccionado para ${entry.team} (${entry.color}) el ${entry.date} a las ${entry.time}`;
                historyListElement.appendChild(historyItem);
            });
        }

        // Actualizar estado de botones
        function updateButtons() {
            // Habilitar botón de girar solo si hay exactamente 2 jugadores seleccionados para jugar y no hemos llegado a 2 giros
            spinButton.disabled = isSpinning || selectedPlayingPlayers.length !== 2 || spinCount >= 2;
        }

        // Actualizar información de selección
        function updateSelectionInfo() {
            if (selectedPlayingPlayers.length < 2) {
                selectionInfoElement.textContent = `Selecciona ${2 - selectedPlayingPlayers.length} jugador(es) más para el partido`;
                selectionInfoElement.style.color = "#f8c630";
                selectionStepElement.textContent = "Paso 1: Selecciona 2 jugadores para el partido";
                selectionStepElement.style.background = "rgba(40, 167, 69, 0.1)";
                selectionStepElement.style.borderColor = "rgba(40, 167, 69, 0.3)";
            } else if (spinCount === 0) {
                selectionInfoElement.textContent = "¡Listo! Gira la ruleta para seleccionar el comentarista del Equipo A";
                selectionInfoElement.style.color = "#4ECDC4";
                selectionStepElement.textContent = "Paso 2: Gira la ruleta para seleccionar el comentarista del Equipo A";
                selectionStepElement.style.background = "rgba(78, 205, 196, 0.1)";
                selectionStepElement.style.borderColor = "rgba(78, 205, 196, 0.3)";
            } else if (spinCount === 1) {
                selectionInfoElement.textContent = "Ahora gira la ruleta para seleccionar el comentarista del Equipo B";
                selectionInfoElement.style.color = "#FF6B6B";
                selectionStepElement.textContent = "Paso 3: Gira la ruleta para seleccionar el comentarista del Equipo B";
                selectionStepElement.style.background = "rgba(255, 107, 107, 0.1)";
                selectionStepElement.style.borderColor = "rgba(255, 107, 107, 0.3)";
            } else if (spinCount === 2) {
                selectionInfoElement.textContent = "¡Selección completada! Ambos comentaristas han sido asignados";
                selectionInfoElement.style.color = "#06D6A0";
                selectionStepElement.textContent = "¡Completado! Ambos comentaristas han sido seleccionados";
                selectionStepElement.style.background = "rgba(6, 214, 160, 0.1)";
                selectionStepElement.style.borderColor = "rgba(6, 214, 160, 0.3)";
            }
        }

        // Función para ajustar colores (oscurecer o aclarar)
        function adjustColor(color, amount) {
            let usePound = false;
            
            if (color[0] === "#") {
                color = color.slice(1);
                usePound = true;
            }
            
            const num = parseInt(color, 16);
            let r = (num >> 16) + amount;
            
            if (r > 255) r = 255;
            else if (r < 0) r = 0;
            
            let b = ((num >> 8) & 0x00FF) + amount;
            
            if (b > 255) b = 255;
            else if (b < 0) b = 0;
            
            let g = (num & 0x0000FF) + amount;
            
            if (g > 255) g = 255;
            else if (g < 0) g = 0;
            
            return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16).padStart(6, '0');
        }

        // Configurar event listeners
        function setupEventListeners() {
            spinButton.addEventListener('click', spinRoulette);
            resetButton.addEventListener('click', resetApp);
        }

        // Inicializar la aplicación cuando se carga la página
        document.addEventListener('DOMContentLoaded', init);
    </script>
</body>
</html>