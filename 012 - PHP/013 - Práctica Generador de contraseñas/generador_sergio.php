<?php
function generar_contrasena($nivel) {
    switch ($nivel) {
        case "baja":
            return strval(rand(1000, 9999));
        case "media":
            return rand(1000, 9999) . chr(rand(65, 90));
        case "alta":
            $caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*";
            return substr(str_shuffle(str_repeat($caracteres, 8)), 0, 12);
        default:
            return "";
    }
}

$resultado = "";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nivel"])) {
    $resultado = generar_contrasena($_POST["nivel"]);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Generador de Pass</title>

<style>
  /* Reset */
  * {
    margin: 0; padding: 0; box-sizing: border-box;
  }

  body {
    background: black;
    color: #00ff66;
    font-family: 'Courier New', Courier, monospace;
    overflow: hidden;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
  }

  /* Canvas de fondo Matrix */
  #matrix {
    position: fixed;
    top: 0; left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 0;
  }

  .contenedor {
    position: relative;
    background: rgba(0,0,0,0.85);
    border: 1px solid #00ff66;
    border-radius: 12px;
    box-shadow: 0 0 15px #00ff66aa;
    padding: 30px;
    width: 360px;
    z-index: 1;
    text-align: center;
  }

  h1 {
    margin-bottom: 20px;
    font-size: 1.8rem;
    text-shadow: 0 0 8px #00ff66;
  }

  form {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  button[name="nivel"] {
    background: transparent;
    border: 1.8px solid #00ff66;
    padding: 12px;
    border-radius: 6px;
    color: #00ff66;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
    font-family: inherit;
  }

  button[name="nivel"]:hover {
    background: #00ff66;
    color: black;
    box-shadow: 0 0 12px #00ff66;
  }

  #resultado {
    margin-top: 25px;
    animation: fadeIn 0.4s ease-in-out;
  }

  #pass {
    background: black;
    border: none;
    color: #00ff66;
    font-size: 18px;
    letter-spacing: 1.5px;
    padding: 12px;
    border-radius: 6px;
    width: 100%;
    text-align: center;
    box-shadow: inset 0 0 10px #00ff66aa;
    font-family: 'Courier New', Courier, monospace;
  }

  button#copiarBtn {
    margin-top: 10px;
    padding: 10px;
    border-radius: 6px;
    border: none;
    background: #00ff66;
    color: black;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 0 15px #00ff66aa;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
  }

  button#copiarBtn:hover {
    background: #00e655;
    box-shadow: 0 0 20px #00ff66;
  }

  #copiado {
    margin-top: 8px;
    color: #0f0;
    font-weight: bold;
    display: none;
    text-shadow: 0 0 8px #0f0;
  }

  @keyframes fadeIn {
    from {opacity: 0; transform: translateY(-10px);}
    to {opacity: 1; transform: translateY(0);}
  }
</style>
</head>
<body>

<canvas id="matrix"></canvas>

<div class="contenedor">
  <h1>🔐 Generador de Pass</h1>
  <form method="POST" autocomplete="off">
    <button type="submit" name="nivel" value="baja">Nivel Bajo</button>
    <button type="submit" name="nivel" value="media">Nivel Medio</button>
    <button type="submit" name="nivel" value="alta">Nivel Alto</button>
  </form>

  <?php if (!empty($resultado)) : ?>
  <div id="resultado">
    <input id="pass" type="text" readonly value="<?php echo htmlspecialchars($resultado); ?>" />
    <button id="copiarBtn" onclick="copiar()">Copiar</button>
    <p id="copiado">¡Contraseña copiada!</p>
  </div>
  <?php endif; ?>
</div>

<script>
// Copiar contraseña al portapapeles
function copiar() {
  const input = document.getElementById('pass');
  input.select();
  input.setSelectionRange(0, 99999);
  document.execCommand('copy');

  const msg = document.getElementById('copiado');
  msg.style.display = 'block';
  setTimeout(() => {
    msg.style.display = 'none';
  }, 2000);
}

// Código para efecto matrix
const canvas = document.getElementById('matrix');
const ctx = canvas.getContext('2d');

let width = window.innerWidth;
let height = window.innerHeight;
canvas.width = width;
canvas.height = height;

const letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$%^&*+-=';
const fontSize = 16;
const columns = Math.floor(width / fontSize);

const drops = [];
for (let x = 0; x < columns; x++) {
  drops[x] = Math.floor(Math.random() * height / fontSize);
}

function draw() {
  ctx.fillStyle = 'rgba(0, 0, 0, 0.05)';
  ctx.fillRect(0, 0, width, height);

  ctx.fillStyle = '#00ff66'; // color verde matrix
  ctx.font = fontSize + 'px Courier New';

  for (let i = 0; i < drops.length; i++) {
    const text = letters.charAt(Math.floor(Math.random() * letters.length));
    ctx.fillText(text, i * fontSize, drops[i] * fontSize);

    if (drops[i] * fontSize > height && Math.random() > 0.975) {
      drops[i] = 0;
    }
    drops[i]++;
  }
}

setInterval(draw, 50);

// Ajustar tamaño canvas al cambiar ventana
window.addEventListener('resize', () => {
  width = window.innerWidth;
  height = window.innerHeight;
  canvas.width = width;
  canvas.height = height;
});
</script>

</body>
</html>
