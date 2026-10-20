
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Mil Flores, centro cultural de Berazategui. Un espacio para la música, la cultura y nuevas propuestas artísticas.">
    <meta name="theme-color" content="#111111">

    <title>Mil Flores | Centro Cultural</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600;700;800;900&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --fondo: #111111;
            --fondo-claro: #191919;
            --naranja: #ffd600;
            --blanco: #f5f2ed;
            --gris: #aaa7a2;
        }

        * {
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background: var(--fondo);
            color: var(--blanco);
            font-family: 'DM Sans', Arial, sans-serif;
        }

        a {
            color: inherit;
        }

        /* NAVEGACIÓN */

        .encabezado {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
            padding: 20px 7%;
            background: #101010;
            border-bottom: 1px solid #292929;
        }

        .marca {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .flor {
            color: var(--naranja);
            font-size: 43px;
            line-height: 1;
        }

        .marca-texto strong {
            display: block;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 30px;
            font-weight: 900;
            line-height: 1;
            letter-spacing: 1px;
        }

        .marca-texto small {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            letter-spacing: 4px;
        }

        .menu {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .menu a {
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            transition: color 0.2s;
        }

        .menu a:hover {
            color: var(--naranja);
        }

        /* PORTADA */

        .portada {
            min-height: 610px;
            display: flex;
            align-items: center;
            padding: 75px 8%;
            background:
                linear-gradient(90deg,
                    rgba(10, 10, 10, 0.98) 0%,
                    rgba(10, 10, 10, 0.83) 43%,
                    rgba(10, 10, 10, 0.2) 100%),
                url('foto1.png')
                center 48% / cover no-repeat;
        }

        .portada-contenido {
            max-width: 620px;
        }

        .ubicacion {
            color: var(--naranja);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        h1 {
            margin: 20px 0 0;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(64px, 10vw, 120px);
            font-weight: 900;
            line-height: 0.85;
            letter-spacing: -2px;
            text-transform: uppercase;
        }

        .subtitulo-portada {
            margin-top: 18px;
            font-size: clamp(15px, 2vw, 20px);
            font-weight: 700;
            letter-spacing: 7px;
        }

        .raya {
            width: 95px;
            height: 5px;
            margin: 25px 0;
            background: var(--naranja);
            transform: skewX(-25deg);
        }

        .texto-portada {
            max-width: 440px;
            color: #d2cfca;
            font-size: 17px;
            line-height: 1.8;
        }

        .botones {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 32px;
        }

        .boton {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 15px 22px;
            border: 2px solid var(--naranja);
            border-radius: 3px;
            background: var(--naranja);
            color: #111;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.7px;
            text-decoration: none;
            transition: 0.2s;
        }

        .boton:hover {
            background: transparent;
            color: var(--naranja);
        }

        .boton-secundario {
            border-color: #777;
            background: transparent;
            color: white;
        }

        .boton-secundario:hover {
            border-color: var(--naranja);
            background: var(--naranja);
            color: #111;
        }

        /* SECCIÓN DE PROPUESTAS */

        .propuestas {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 65px;
            align-items: center;
            padding: 85px 9%;
            background:
                radial-gradient(ellipse at 15% 50%, #202020 0%, #151515 65%);
        }

        .etiqueta {
            color: var(--naranja);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        h2 {
            margin: 14px 0 20px;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(36px, 5vw, 54px);
            font-weight: 800;
            line-height: 1;
            text-transform: uppercase;
        }

        h2 span {
            color: var(--naranja);
        }

        .texto-seccion {
            color: var(--gris);
            font-size: 15px;
            line-height: 1.9;
        }

        .pasos {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }

        .paso {
            min-height: 175px;
            padding: 25px 20px;
            border: 1px solid #343434;
            background: rgba(255, 255, 255, 0.02);
            transition: border-color 0.2s, transform 0.2s;
        }

        .paso:hover {
            transform: translateY(-4px);
            border-color: var(--naranja);
        }

        .paso .numero {
            color: var(--naranja);
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 35px;
            font-weight: 800;
        }

        .paso h3 {
            margin: 14px 0 8px;
            font-size: 14px;
            text-transform: uppercase;
        }

        .paso p {
            margin: 0;
            color: var(--gris);
            font-size: 12px;
            line-height: 1.7;
        }

        /* FRANJA VISUAL */

        .franja {
            min-height: 260px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 55px 20px;
            text-align: center;
            background:
                linear-gradient(rgba(0,0,0,0.63), rgba(0,0,0,0.75)),
                url('https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?auto=format&fit=crop&w=1800&q=85')
                center 55% / cover no-repeat;
        }

        .franja h2 {
            margin: 0;
            font-size: clamp(40px, 7vw, 76px);
            letter-spacing: 2px;
        }

        .franja p {
            color: #e1ddd8;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 4px;
        }

        /* PIE DE PÁGINA */

        footer {
            padding: 35px 8% 20px;
            background: #0c0c0c;
        }

        .pie-superior {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 25px;
            padding-bottom: 28px;
        }

        .pie-superior p {
            color: var(--gris);
            font-size: 13px;
            line-height: 1.8;
        }

        .pie-superior strong {
            color: var(--blanco);
        }

        .pie-inferior {
            padding-top: 20px;
            border-top: 1px solid #303030;
            color: #777;
            font-size: 10px;
            letter-spacing: 2px;
            text-align: center;
        }

        /* CELULARES Y TABLETS */

        @media (max-width: 760px) {
            .encabezado {
                flex-direction: column;
                padding: 18px 5%;
            }

            .menu {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
                gap: 12px 20px;
            }

            .menu a {
                font-size: 11px;
            }

            .portada {
                min-height: 560px;
                padding: 65px 7%;
                background-position: 58% center;
            }

            .subtitulo-portada {
                letter-spacing: 4px;
            }

            .texto-portada {
                font-size: 15px;
            }

            .propuestas {
                grid-template-columns: 1fr;
                gap: 35px;
                padding: 65px 7%;
            }

            .paso {
                padding: 20px 15px;
            }

            .pie-superior {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }

        @media (max-width: 400px) {
            .pasos {
                grid-template-columns: 1fr;
            }

            .botones {
                flex-direction: column;
                align-items: stretch;
            }

            .boton {
                text-align: center;
            }

            .logo-mil-flores {
                width: 55px;
                height: 55px;
                object-fit: contain;
                display: block;
                flex-shrink: 0;
            }

            .marca-texto strong {
                font-size: 26px;
            }
        }
    </style>
</head>

<body>

<header class="encabezado">

    <a href="index.php" class="marca">
        <img src="img/logo-mil-flores.png"
            alt="Logo de Mil Flores"
            class="logo-mil-flores">

        <span class="marca-texto">
            <strong>MIL FLORES</strong>
            <small>CENTRO CULTURAL</small>
        </span>
    </a>

    <nav class="menu">
        <a href="index.php">INICIO</a>
        <a href="calendario.php">CALENDARIO</a>
        <a href="#propuestas">PROPUESTAS</a>
    </nav>

</header>

<main>

    <section class="portada">

        <div class="portada-contenido">

            <div class="ubicacion">Berazategui · Buenos Aires</div>

            <h1>Mil<br>Flores</h1>

            <div class="subtitulo-portada">
                CENTRO CULTURAL
            </div>

            <div class="raya"></div>

            <p class="texto-portada">
                Un espacio para la música, la cultura y las nuevas
                propuestas. Un lugar para encontrarse, compartir
                y hacer sonar nuevas ideas.
            </p>

            <div class="botones">

                <a href="calendario.php" class="boton">
                    CONSULTAR FECHAS DISPONIBLES <span>→</span>
                </a>

                <a href="#propuestas" class="boton boton-secundario">
                    PRESENTÁ TU PROPUESTA
                </a>

            </div>

        </div>

    </section>

    <section class="propuestas" id="propuestas">

        <div>

            <div class="etiqueta">El escenario también puede ser tuyo</div>

            <h2>
                ¿Tenés una idea?<br>
                <span>Hagámosla sonar.</span>
            </h2>

            <p class="texto-seccion">
                ¿Tenés una banda, un proyecto musical o una propuesta
                artística? En Mil Flores queremos conocer lo que hacés.
                Consultá las fechas disponibles y contanos qué te gustaría
                compartir en nuestro espacio.
            </p>

            <a href="calendario.php" class="boton">
                ENVIAR UNA PROPUESTA <span>→</span>
            </a>

        </div>

</main>

</body>
</html>
