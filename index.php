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
            justify-content: flex-start;
            padding: 0 50px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .banner img {
            height: 160px;
            width: auto;
            margin-right: 20px;
        }
        .banner-text {
            text-align: center;
            margin-left: auto;
            padding-right: 40px;
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
        <h4>Some Text</h4>
        <p>Contenido relevante aquí..</p>
    </div>

    <div class="well">
        <h4>Upcoming Events</h4>
        <p>Descripción de los eventos..</p>
    </div>

    <div class="well">
        <h4>Visit Our Blog</h4>
        <p>Resumen de los artículos del blog..</p>
    </div>
</div>


</div>

<hr>

</div>


<div class="container text-center">    

	<?php 

	if ($institucionNombre == "institucionNombre" ){

		echo "<font color='red' size='3'>Reemplace el archivo example.config_title.php por config_title.php y configure los nombres de su institución</font>";

	} 

	?>

  <h3><?=$institucionNombre?></h3>

  <br>


  <hr>

</div>


<br>


<footer class="container-fluid text-center">

  <p><?=$footerText?></p>

</footer>


</body>

</html>