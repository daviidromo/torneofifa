<?php
require_once 'includes/config.php';

// Procesar el formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $nombre_jugador = trim($_POST['nombre_jugador'] ?? '');
    
    // Verificar si el jugador existe
    if (in_array($nombre_jugador, $_SESSION['jugadores'])) {
        $_SESSION['usuario_autenticado'] = $nombre_jugador;
        $_SESSION['presentacion_iniciada'] = true;
        $_SESSION['jugador_actual_index'] = 0;
        
        header('Location: presentacion.php');
        exit();
    } else {
        $error = "Jugador no encontrado. Verifica tu nombre.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Torneo FIFA 26</title>
    <style>
        :root {
            --primary-color: #1a1a2e;
            --secondary-color: #16213e;
            --accent-color: #0f3460;
            --highlight-color: #e94560;
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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
            padding: 40px;
            box-shadow: var(--box-shadow);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
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

        .login-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 3px;
            background: var(--gradient-accent);
            border-radius: 3px;
        }

        .login-header h2 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            background: linear-gradient(to right, var(--text-color), var(--highlight-color));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 0 10px rgba(233, 69, 96, 0.3);
        }

        .login-header p {
            font-size: 1.1rem;
            color: var(--text-secondary);
        }

        .form-group {
            margin-bottom: 25px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: var(--text-color);
        }

        .form-control {
            width: 100%;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--border-radius);
            color: var(--text-color);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--highlight-color);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 5px rgba(233, 69, 96, 0.5);
        }

        .form-control::placeholder {
            color: var(--text-secondary);
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: var(--gradient-accent);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: var(--transition);
            margin-bottom: 20px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .error-message {
            background: rgba(231, 76, 60, 0.2);
            border: 1px solid rgba(231, 76, 60, 0.5);
            border-radius: var(--border-radius);
            padding: 15px;
            margin-bottom: 20px;
            color: #e74c3c;
            text-align: center;
        }

        .lista-jugadores {
            margin-top: 25px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: var(--border-radius);
        }

        .lista-jugadores h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: var(--text-secondary);
        }

        .jugadores-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
        }

        .jugador-tag {
            background: rgba(255, 255, 255, 0.1);
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9rem;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }
            
            .login-header h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2>Bienvenido</h2>
            <p>Ingresa tu nombre para acceder al torneo</p>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="error-message">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="nombre_jugador">Tu Nombre</label>
                <input type="text" id="nombre_jugador" name="nombre_jugador" class="form-control" 
                       placeholder="Escribe exactamente tu nombre" required 
                       value="<?php echo $_POST['nombre_jugador'] ?? ''; ?>">
            </div>
            
            <button type="submit" name="login" class="btn-login">
                🚀 Iniciar Sesión
            </button>
        </form>
        
        <div class="lista-jugadores">
            <h3>Jugadores Registrados</h3>
            <div class="jugadores-grid">
                <?php if (isset($_SESSION['jugadores'])): ?>
                    <?php foreach ($_SESSION['jugadores'] as $jugador): ?>
                        <div class="jugador-tag"><?php echo htmlspecialchars($jugador); ?></div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: var(--text-secondary);">No hay jugadores registrados</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>