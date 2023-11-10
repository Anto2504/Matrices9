<?php
session_start();

if (!isset($_SESSION['matrices9'])) {
    $_SESSION['matrices9'] = generarMatrizAleatoria();
    $_SESSION['intentos'] = 0;
    $_SESSION['puntos'] = 0;
    $_SESSION['nivel'] = 2;
    $_SESSION['seleccionadas'] = [];
}

if (isset($_POST['celda'])) {
    $celda = $_POST['celda'];
    
    if (!isset($_SESSION['seleccionadas'][$celda])) {
        $celda = explode(',', $celda);
        $celdaIndice = [$celda[0], $celda[1]];

        $_SESSION['puntos'] += $_SESSION['matrices9'][$celdaIndice[0]][$celdaIndice[1]];
        $_SESSION['seleccionadas'][$celdaIndice[0]][$celdaIndice[1]] = true;
        
        $_SESSION['intentos'];

        if ($_SESSION['puntos'] >= 15) {
            header("Location: victoria.php");
            exit;
        } elseif ($_SESSION['intentos'] >= 2) {
            header("Location: game_over.php");
            exit;
        }
    }
}

if (isset($_POST['recargar'])) {
    $_SESSION['intentos'] = 0;
    $_SESSION['puntos'] = 0;
    $_SESSION['seleccionadas'] = [];
    $_SESSION['matrices9'] = generarMatrizAleatoria();
}

function generarMatrizAleatoria() {
    $numeros = range(1, 9);
    shuffle($numeros);
    return array_chunk($numeros, 3);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MATRICES9 - Nivel 2</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        form {
            text-align: center;
        }
    </style>
</head>
<body>
    <div>
        <h1>MATRICES9 - Nivel 2</h1>
        <p>Oportunidades: <?php echo $_SESSION['intentos']; ?>/2</p>
        <p>Puntos actuales: <?php echo $_SESSION['puntos']; ?></p>

        <form method="post" action="">
            <?php
            foreach ($_SESSION['matrices9'] as $filaIndice => $fila) {
                echo '<div>';
                foreach ($fila as $celdaIndice => $celda) {
                    echo '<button type="submit" name="celda" value="' . $filaIndice . ',' . $celdaIndice . '">' . $celda . '</button>';
                }
                echo '</div>';
            }
            ?>
            <button type="submit" name="recargar">Recargar</button>
        </form>
    </div>
</body>
</html>
