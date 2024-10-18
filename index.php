<!DOCTYPE html>

<html lang="en">

<head>

 <!---->

 <?php

$ruta_raiz = ".";


include_once "$ruta_raiz/config_title.php";

 ?>

  <title><?=$institucionSigla?></title>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  
  <link rel="stylesheet" href="estilos/navbar.css">

  
  <script src="jsindex/jquery.min.js"></script>

  <script src="jsindex/bootstrap.min.js"></script>

  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        .banner {
            background-color: #2A66A1;
            height: 160px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .banner img {
            height: 160px;
            width: auto;
            display: block; 
            text-align: center;
            padding: 15px 10px;
        }
        .banner-text {
            text-align: center;
            padding-right: 40px;
            padding: 15px 10px;
        }
        .banner h2 {
            font-family: 'Poppins', sans-serif;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
            margin: 5px;
        }
        .banner h2:first-of-type {
            font-size: 3.5rem;
            font-weight: 500;
        }
        .banner h2:last-of-type {
            font-size: 4.0rem;
            font-weight: 600;
        }
        .btn-ingresar {
            color: white;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            background-color: transparent;
            border: 2px solid white;
            padding: 15px 10px;
            font-size: 1.8rem;
            text-align: center;
            border-radius: 12px;
            box-shadow: 8px 8px 24px rgba(0, 0, 0, 0.2);
            transition: all 0.7s ease;
        }
        .btn-ingresar:hover {
            background-color: white;
            color: #30659a;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.3);
        }

        .banner-image {
        width: 300px; /* Ancho deseado */
        height: auto; /* Mantener la proporción */
        display: block; /* Hace que el <img> se comporte como un bloque */
        margin: 0 auto;
        text-align: center;
        }

        body {
        font-family: 'Poppins', sans-serif; /* Tipografía moderna */
    }

    .well {
        background-color: #f8f9fa; /* Color de fondo */
        border: 1px solid #ddd; /* Borde claro */
        border-radius: 10px; /* Bordes redondeados */
        padding: 20px; /* Espaciado interno */
        margin-bottom: 20px; /* Espaciado entre secciones */
        transition: box-shadow 0.3s; /* Sombra al pasar el ratón */
        height: 130px; /* Altura fija */
    }

    .well:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Sombra al pasar el ratón */
    }

    .well h3 {
        margin-bottom: 10px; /* Espaciado debajo del encabezado */
        font-size: 1.5rem; /* Tamaño del encabezado */
        color: #2A66A1; /* Color del texto */
    }

    .well p {
        font-size: 1.1rem; /* Tamaño de fuente del párrafo */
        line-height: 1.4; /* Espaciado entre líneas */
    }

    /* footer conf */

    footer {
    background-color: #2A66A1; /* Color de fondo del footer */
    color: white; /* Color del texto */
    padding: 20px; /* Espaciado interno */
    margin-top: 20px; /* Espacio superior */
    position: relative; /* Para poder usar el efecto de sombra */
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2); /* Sombra superior */
}

footer p {
    margin: 0; /* Sin márgenes */
    font-size: 1rem; /* Tamaño del texto */
}

footer .footer-links {
    margin-top: 10px; /* Espacio superior entre el texto y los enlaces */
}

footer .footer-links a {
    color: white; /* Color de los enlaces */
    margin: 0 10px; /* Espaciado entre enlaces */
    text-decoration: none; /* Sin subrayado */
}

footer .footer-links a:hover {
    text-decoration: underline; /* Subrayado al pasar el ratón */
}

/* boody */
.container {
    background-color: #f1f1f1; /* Fondo claro */
    border-radius: 10px; /* Bordes redondeados */
    padding: 20px; /* Espaciado interno */
    margin-top: 20px; /* Espaciado superior */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Sombra suave */
}

.container h3 {
    color: #2A66A1; /* Color del título */
    font-size: 2rem; /* Tamaño del título */
    margin-bottom: 15px; /* Espaciado inferior */
}

.container p {
    font-size: 1.1rem; /* Tamaño de fuente del párrafo */
    line-height: 1.6; /* Espaciado entre líneas */
    color: #333; /* Color del texto */
}

.alert {
    color: red; /* Color de alerta */
    font-size: 1rem; /* Tamaño del texto de alerta */
    margin-bottom: 20px; /* Espaciado inferior */
    font-weight: bold; /* Negrita */
}

hr {
    border: 1px solid #2A66A1; /* Línea horizontal */
    margin: 20px 0; /* Espaciado vertical */
}
    </style>

  <script type="text/JavaScript">

            function irLogin(admin) {

                try{

                var x = screen.width - 20;

                var y = screen.height - 80;

                var param = "";

                if (admin == 1) param = "?txt_administrador=1";

                ventana=window.open("./login.php"+param,"QUIPUX","toolbar=no,directories=no,menubar=no,status=no,scrollbars=yes, width="+x+", height="+y);

                ventana.focus();

                ventana.moveTo(10, 40);

                }

                catch(e){

                    
                }

            }

        </script>

</head>

<body>


<header class="banner">
        <div>
            <img src="imagenes/logolisto.png" alt="Logo de la Institución">
        </div>
        <div class="banner-text">
            <h2>INSTITUTO SUPERIOR TECNOLÓGICO PARTICULAR</h2>
            <h2>"BOLÍVAR MADERO VARGAS"</h2>
        </div>
        <div>
            <a href="javascript:void(0);" onclick="irLogin(1);" class="btn-ingresar">
                <span class="glyphicon glyphicon-log-in"></span> Ingresar al Sistema
            </a>
        </div>
    </header>


<div class="container">

<br>
<br>

<div class="row">

  <div class="col-sm-8">

    <div id="myCarousel" class="carousel slide" data-ride="carousel">

      <!-- Indicators -->

      <ol class="carousel-indicators">

        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>

        <li data-target="#myCarousel" data-slide-to="1"></li>

      </ol>


      <!-- Wrapper for slides -->

      <div class="carousel-inner" role="listbox">

        <div class="item active">

          <img src="<?=$banner1?>" alt="Image" class="banner-image">

          <div class="carousel-caption">

            
            <p><a src=<?=$linkBanner1?>><?=$nombreLinkBanner1?></a></p>

          </div>      

        </div>


        <div class="item">

          <img src="<?=$banner2?>" alt="Image" class="banner-image">

          <div class="carousel-caption">

            
          <p><a src=<?=$linkBanner2?>><?=$nombreLinkBanner2?></a></p>

          </div>      

        </div>

      </div>


      <!-- Left and right controls -->

      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">

        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>

        <span class="sr-only">Previous</span>

      </a>

      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">

        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>

        <span class="sr-only">Next</span>

      </a>

    </div>

  </div>

  <div class="col-sm-4">
    <div class="well">
        <h4>Quipux</h4>
        <p>Sistema de gestión documental del Instituto Bolivar Madero Vargas, desarrollado por estudiantes para optimizar procesos.</p>
    </div>

    <div class="well">
        <h4>Próximos Eventos</h4>
        <p>¡Participa en nuestros talleres y charlas para enriquecer tu experiencia educativa!</p>
    </div>

    <div class="well">
        <h4>Visita Nuestro Blog</h4>
        <p>Entérate de las últimas noticias y recursos útiles para la comunidad del IBMV.</p>
    </div>
</div>



</div>

<hr>

</div>


<div class="container text-center">
    <?php if ($institucionNombre == "institucionNombre") : ?>
        <div class="alert">
            Reemplace el archivo example.config_title.php por config_title.php y configure los nombres de su institución.
        </div>
    <?php endif; ?>

    <h3>PROYECTO</h3>
    <p>
        "TRANSFORMACIÓN DIGITAL Y OPTIMIZACIÓN DE LA GESTIÓN DOCUMENTAL INSTITUCIONAL A TRAVÉS DE QUIPUX EN EL INSTITUTO SUPERIOR TECNOLÓGICO PARTICULAR 'BOLÍVAR MADERO VARGAS'"
    </p>

    <h3>RESUMEN</h3>
    <p>
        El Instituto Superior Tecnológico Particular "Bolívar Madero Vargas" ha implementado el sistema Quipux con el objetivo de optimizar su gestión documental. Esta herramienta de digitalización permite un manejo más eficiente de los documentos, facilitando su organización y acceso en formato electrónico. 
    </p>
    
    <h3>OBJETIVOS</h3>
    <h4>Objetivo General:</h4>
    <p>
        Optimizar la gestión documental en el Instituto mediante la implementación del sistema Quipux.
    </p>

    <h4>Objetivos Específicos:</h4>
    <ul>
        <li>Automatizar el manejo y organización de los documentos institucionales.</li>
        <li>Garantizar la seguridad y confidencialidad de la información.</li>
        <li>Aumentar la eficiencia administrativa.</li>
    </ul>

    <h3>ACTIVIDADES</h3>
    <h4>1. Análisis y Planificación</h4>
    <p>
        Realizar reuniones con directivos y personal administrativo para definir las necesidades del sistema.
    </p>
    
    <h4>2. Instalación y Configuración del Sistema</h4>
    <p>
        Preparar el entorno de trabajo e instalar el sistema Quipux Comunitario.
    </p>
    
    <h4>3. Capacitación del Personal</h4>
    <p>
        Desarrollar manuales y realizar talleres de formación con el personal administrativo.
    </p>

    <hr>
    <h3><?=$institucionNombre?></h3>
</div>


<br>


<footer class="container-fluid text-center">
    <p>&copy; 2024 Instituto Superior Tecnológico Particular "Bolívar Madero Vargas". Todos los derechos reservados.</p>
    <div class="footer-links">
        <a href="#">Política de Privacidad</a> |
        <a href="#">Términos de Uso</a> |
        <a href="#">Contacto</a>
    </div>
</footer>



</body>

</html>