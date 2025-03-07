<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	
<style>
  html {
      margin: 0px;
    } 
    body{
      /*background-color: #632432;*/
      font-family: Arial;
      font-size: 10px;
      margin: 0mm 10mm 10mm 10mm;
      padding: 0;
    }

    #main-container{
      margin: 30px auto;
      width: 100%;
    }
    header{
      position: fixed;
      margin-top: 20px;
      margin-bottom: 20px;
      margin-right: 20px;
      overflow: hidden;
    }
    footer {
          position: fixed;
          bottom: 0cm; 
          left: 1cm; 
          right: 0cm;
          height: 2cm;
    }

    table, td{
        border:1px solid black;
        border-collapse: collapse;
        text-align: center;
        padding: 5px;
    }
    table thead{
        font-weight: bold;
        color:white;
        background-color: #03a9f3;
    }
    table thead,th{
        
        border:1px solid white;
    }
    table tbody{
        background-color: #white;
    }
    .alinear-derecha{
      width: 300px;
      position: relative;
      right: -350px;
    }
    .alinear_izquierda{
      width: 300px;
      text-align: left;
      /*position:relative
      right: 0px;
      top:0px;*/
      margin-left: -150px;
      float: right;
    }
    .firmas{
      background-color: white;
      overflow: hidden;
      margin-top: 50px;
    }
    .firmas ul {
      display: inline-block;;
    }
    .firmas ul li {
      list-style: none;
    }
    .pagenum:before {
          content: counter(page);
    }
    .numero_pagina{
      /*position: relative;
        top: 0.3cm;
        left: 1.25cm;*/
    }
    .logo_dpgt{
      
      float: left;
    }
    .logo_mpd{
      float: right;
     margin-top: 5px;

    }
    .page-break {
    page-break-after: always;
}
	
	

</style>
</head>
	
	<body>
        <header>
          <div>
            <img class="logo_mpd" src="img/mpd_jpeg_reportes.jpeg" height="40px" width="250px" />  
          </div>
          <div class="logo_dgpt">
             <img  src="img/DGPT.jpeg" height="40px" width="250px" />   
          </div>
        </header>
        <br>
        <br>
        <h2>DATOS DEL MUNICIPIO:</h2>
        <div><strong>DENOMINACION:</strong> {{ strtoupper($institucion->denominacion) }}</h3>
        <div><strong>SIGLA: </strong>{{ $institucion->sigla }}</div>
        <div><strong>CODIGO:</strong> {{ $institucion->codigo }}</div>
        <div><strong>GRUPO CLASIFICADOR:</strong> {{ $institucion->clasificador }}</div>
        <br>
        <br>

		<div id="main-container">
			<h1>CUADRO Nº5</h1>
			<h2>EVALUACION GESTION RIESGOS</h2>
			<h3>GESTION : 2016 - 2018</h3>
			<table class="table table-bordered" >
                <thead >
                  <tr style="color:#fff; background:rgb(36, 136, 181);">
                    <td  style="vertical-align:middle" rowspan="3">ACCION ETA</td>
                    <td  style="vertical-align:middle" rowspan="2" colspan="3">PLANIFICACION</td>
                    <td  style="vertical-align:middle" colspan="11" >EN RELACION A LA PROGRAMACION DE RECURSOS</td>
                    <td  style="vertical-align:middle" colspan="11" >EN RELACION A LA PROGRAMACION DE ACCIONES</td>
                    <td style="vertical-align:middle" rowspan="3" >CAUSAS DE VARIACION</td>
                  </tr>
                  <tr style="color:#fff; background:rgb(36, 136, 181);">
                    <td style="vertical-align:middle" colspan="2" >2016</td>
                    <td style="vertical-align:middle" colspan="2" >2017</td>
                    <td style="vertical-align:middle" colspan="2" >2018</td>
                    <td style="vertical-align:middle" rowspan="2" >TOTAL<br/>PRES. PROGRAMADO<br/>(2016-2018)</td>
                    <td style="vertical-align:middle" rowspan="2">TOTAL<br/> PRES. EJECUTADO<br/>(2016-2018)</td>
                    <td style="vertical-align:middle" rowspan="2">% EJEC.</td>
                    <td style="vertical-align:middle" rowspan="2">META AL<br/> 2020</td>
                    <td style="vertical-align:middle" rowspan="2">% EJEC. <br/>AL 2020</td>
                    <td style="vertical-align:middle" colspan="2">2016</td>
                    <td style="vertical-align:middle" colspan="2">2017</td>
                    <td style="vertical-align:middle" colspan="2">2018</td>
                    <td style="vertical-align:middle" rowspan="2" >TOTAL <br/>PROGRAMACION DE ACCIONES<br/>(2016-2018)</td>
                    <td style="vertical-align:middle" rowspan="2">TOTAL<br/> ACCIONES EJECUTADO<br/>(2016-2018)</td>
                    <td style="vertical-align:middle" rowspan="2">% EJEC.</td>
                    <td style="vertical-align:middle" rowspan="2">META <br/>AL 2020</td>
                    <td style="vertical-align:middle" rowspan="2">% EJEC. <br/>AL 2020</td>
                  </tr>
                  <tr style="color:#fff; background:rgb(36, 136, 181);">
                    <td>PTDI/<br/>PGTC</td>
                    <td>PEI</td>
                    <td>POA</td>
                    <td style="vertical-align:middle">P</td>
                    <td style="vertical-align:middle">E</td>
                    <td style="vertical-align:middle">P</td>
                    <td style="vertical-align:middle" >E</td>
                    <td style="vertical-align:middle" >P</td>
                    <td style="vertical-align:middle" >E</td>
                    <td style="vertical-align:middle">P</td>
                    <td style="vertical-align:middle">E</td>
                    <td style="vertical-align:middle">P</td>
                    <td style="vertical-align:middle" >E</td>
                    <td style="vertical-align:middle" >P</td>
                    <td style="vertical-align:middle" >E</td>
                   
                  </tr>
                </thead>
                <tbody>
                @foreach($datos as $f)
                  <tr>
                    <td>{{ $f->descripcion_accion_eta }}</td>
                    <td>X</td>
                    <td></td>
                    <td>X</td>
                    <td>{{ $f->recurso_programado_2016 }}</td>
                    <td>{{ $f->recurso_ejecutado_2016 }}</td>
                    <td>{{ $f->recurso_programado_2017 }}</td>
                    <td>{{ $f->recurso_ejecutado_2017 }}</td>
                    <td>{{ $f->recurso_programado_2018 }}</td>
                    <td>{{ $f->recurso_ejecutado_2018 }}</td>
                    <td>{{ $f->recurso_total_programado_2016_2018 }}</td>
				    <td>{{ $f->recurso_total_ejecutado_2016_2018 }}</td>
				    <td>{{ $f->recurso_porcentaje_ejecutado }}</td>
				    <td>{{ $f->recurso_meta_programado_al_2020 }}</td>
    				<td>{{ $f->recurso_porcentaje_ejecucion_al_2020 }}</td>
    				<td>{{ $f->accion_programado_2016 }}</td>
				    <td>{{ $f->accion_ejecutado_2016 }}</td>
				    <td>{{ $f->accion_programado_2017 }}</td>
				    <td>{{ $f->accion_ejecutado_2017 }}</td>
				    <td>{{ $f->accion_programado_2018 }}</td>
				    <td>{{ $f->accion_ejecutado_2018 }}</td>
				    <td>{{ $f->accion_total_programado_2016_2018 }}</td>
				    <td>{{ $f->accion_total_ejecutado_2016_2018 }}</td>
				    <td>{{ $f->accion_porcentaje_ejecutado }}</td>
				    <td>{{ $f->accion_meta_al_2020 }}</td>
				    <td>{{ $f->accion_porcentaje_ejecucion_al_2020 }}</td>
                    <td>{{ $f->causas_de_variacion }}</td>
                    
                  </tr>
                @endforeach
                </tbody>
                
      </table>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <div style="page-break-after: always;">
              <div class="firmas">
                <div class="alinear_izquierda">
                    <ul >
                      <li class="alinear"><strong>Aprobado MAE:</strong></li>
                      <li class="alinear"><strong>Nombre:.................................................</strong></li>
                      <li class="alinear"><strong>Firma:.....................................................</strong></li>
                      <li class="alinear"><strong style="color:white;">.</strong></li>
                    </ul>
                </div>
                <div class="alinear-derecha">
                  <ul >
                      <li class="alinear"><strong>Elaborado por:</strong></li>
                      <li class="alinear"><strong>Nombre:.................................................</strong></li>
                      <li class="alinear"><strong>Cargo:....................................................</strong></li>
                      <li class="alinear"><strong>Firma:.....................................................</strong></li>
                    </ul>
                </div>
              </div>
            </div>
		</div>
    <footer >
      <p class="numero_pagina"><?php echo date("d/m/Y  H:i:s");?></p>
    </footer>

    <script type="text/php">
         if (isset($pdf)) {
            $x = 900;
            $y = 565;
            $text = "Pagina {PAGE_NUM} de {PAGE_COUNT}";
            $font = null;
            $size = 8;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>
	</body>
</html>