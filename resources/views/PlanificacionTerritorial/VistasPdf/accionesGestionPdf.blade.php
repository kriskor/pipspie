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
      margin: 0 auto;
      width: 100%;
    }
    header{
      margin-top: 10px;
      margin-bottom: 10px;
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
		padding: 3px;
	}
	table thead{
		font-weight: bold;
		color:white;
		background-color: #03a9f3;
	}
	table thead,th{
		
		border:1px solid white;
	}
	table tbody,tr,td{
		background-color: #white;
		border:1px solid black;
	}
	
    .alinear{
      margin-bottom: 10px;

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
          position: relative;
      top: 0.3cm;
      left: 1.25cm;
    }
    .logo_dpgt{
      
      float: left;
    }
    .logo_mpd{
      float: right;
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
			<h3>CUADRO Nº2</h3>
			<h3>SEGUIMIENTO A LAS ACCIONES</h3>
			<h4>GESTION : {{ $gestionActiva->gestion }}</h4>
			<table style="width: 100%">
				<thead>
					<tr>
						<th colspan="4">ARTICULACION PDES</th>
						<th rowspan="2">INSCRITO PTDI/PGTC ACCION ETA</th>
						<th rowspan="2">INSCRITO PEI</th>
						<th rowspan="2">PROYECTOS POA</th>
						<th rowspan="2">CAT. PROG.</th>
						
					</tr>
					<tr>
						<th>P</th>
						<th>M</th>
						<th>R</th>
						<th>A</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($objetivo_indicador as $mifuente) 
					     
	          			@if($mifuente->cantidad_proyectos_poa >0)
							<tr>
								<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->cod_p }}</td>
								<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->cod_m }}</td>
								<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->cod_r }}</td>
								<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->cod_a }}</td>
								<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->nombre_accion_eta }}</td>
								<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">PEI</td>
								<td>{{ $mifuente->primer_poa->nombre }}</td>
								<td>{{ $mifuente->primer_poa->categoria_programatica }}</td>
							</tr>
							@foreach($mifuente->poa as $p)
							<tr>
								<td>{{ $p->nombre}}</td>
								<td>{{ $p->categoria_programatica }}</td>

							</tr>
							@endforeach	
						@else
						<tr>
						<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->cod_p }}</td>
						<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->cod_m }}</td>
						<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->cod_r }}</td>
						<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->cod_a }}</td>
						<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">{{ $mifuente->nombre_accion_eta }}</td>
						<td rowspan="{{ $mifuente->cantidad_proyectos_poa }}">PEI</td>
						<td colspan="2">NO TIENE PROYECTOS POA</td>			
						</tr>
	          			@endif
	        		@endforeach
				</tbody>	
			</table>
			<br>
		    <br>
		    <br>
		    <br>
		    <br>
		    <br>
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
		<footer >
	      <p class="numero_pagina"><?php echo date("d/m/Y  H:i:s");?></p>
	    </footer>
	<script type="text/php">
		 if (isset($pdf)) {
		    $x = 700;
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