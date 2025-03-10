@extends('layouts.sistemaremi')

@section('header')
  <style>
  .amcharts-export-menu-top-right {
    top: 10px;
    right: 0;
  }
  .amcharts-chart-div a {display:none !important;}
  #chartdivAvance {
  	width	: 100%;
  	height	: 300px;
  }

  </style>
@endsection

@section('content')

  <div class="row bg-title m-b-5">
      <!-- .page title -->
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">Detalle Indicador</h4>
      </div>
      <!-- /.page title -->
      <!-- .breadcrumb -->
      {{-- <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
              <li><a href="{{ url('/sistemaremi/setIndicadores') }}">Indicadores</a></li>
              <li class="active">Detalle Indicador</li>
          </ol>
      </div> --}}
      <!-- /.breadcrumb -->
  </div>
  <!-- .row -->
  <button onclick="window.history.back();" class="btn btn-info btn-sm">Regresar a la lista</button><br/><br/>
  <div class="row">
      <div class="col-md-12">
          <div class="white-box">
            <div class="row">
                <div id="HTMLtoPDF" class="col-md-12">

                  <div class="row media" style="margin-right:6px;margin-left:6px;" > <!--style="padding-right: 0px;padding-top: 0px;padding-left: 0px;"-->
                      <div class="col-lg-2 col-xs-12">
                        <center>
                              <img class="media-object" src="/img/icono_indicadores/IND_1.png"  style="width: auto; height: auto;">
                        </center>
                      </div>
                      <div class="col-lg-10 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 ">
                                  <label style="color:#000000;font-weight: bold;">{{ mb_strtoupper(strtolower($indicador->nombre)) }}</label>
                            </div>
                            <div class="col-lg-12">
                                  <label><b><u>Definición:</u></b> {{$indicador->definicion}}</label>
                            </div>
                        </div>
                      </div>
                      <div class="col-lg-12 col-xs-12">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 text-center">
                                <p class="text-muted card-footer" >Último valor reportado:</p>
                                @if(isset($avance->valor))
                                    <p> {{ $avance->valor }} </p>
                                    <p> {{ $avance->fecha_generado_dia }}/{{ $avance->fecha_generado_mes }}/{{ $avance->fecha_generado_anio }} </p>
                                @endif
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 text-center">
                                <p class="text-muted card-footer"> Unidad de medida: </p>
                                <p> {{$indicador->unidad_medida}} </p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 text-center">
                                <p class="text-muted card-footer">Meta PDES al 2020</p>
                                @foreach ($metas as $item)
                                  @if ($item->gestion == 2020)
                                      <p>{{number_format($item->valor,4,',','.')}}</p>
                                  @endif
                                @endforeach

                            </div>
                          </div>
                      </div>
                  </div>
                  <div class="row media" style="margin-right:6px;margin-left:6px;" > <!--style="padding-right: 0px;padding-top: 0px;padding-left: 0px;"-->
                    <div class="col-lg-12 col-sm-12">
                        <h5>Gráfica de Avance</h5>
                        <div id="chartdivAvance"></div>
                    </div>
                  </div>

                  <div class="col-lg-12 col-sm-12">
                      <div class="panel panel-success">
                          <div class="panel-heading" style="background-color: #468E9B;">
                              <div class="pull-left" style="margin-top: -9px;">
                                <a href="#" data-perform="panel-collapse">
                                  <i class="ti-minus"></i> Metas y avance
                                </a>
                              </div>
                          </div>
                          <div class="panel-wrapper collapse in" aria-expanded="true">
                              <div class="panel-body table-responsive ">

                                          <table class="table table-hover ">
                                            <thead>
                                              <tr>
                                                    <th>Gestión</th>
                                                  @foreach ($metasAvance as $item)
                                                    <th>{{ $item->dimension}} </th>
                                                  @endforeach
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <tr>
                                                    <th>Metas</th>
                                                  @foreach ($metasAvance as $item)
                                                    <td>{{number_format($item->meta,4,',','.')}}</td>
                                                  @endforeach
                                              </tr>
                                              <tr>
                                                    <th>Avance</th>
                                                  @foreach ($metasAvance as $item)
                                                    <td>{{number_format($item->avance,4,',','.')}}</td>
                                                  @endforeach
                                              </tr>
                                            </tbody>
                                          </table>
                              </div>
                          </div>
                      </div>
                  </div>





                  <div class="col-lg-12 col-sm-12">
                      <div class="panel panel-success">
                          <div class="panel-heading" style="background-color: #468E9B;">

                              <div class="pull-left" style="margin-top: -9px;">
                                <a href="#" data-perform="panel-collapse">
                                  <i class="ti-minus"></i> Articulación PDES
                                </a>
                              </div>
                          </div>
                          <div class="panel-wrapper collapse in" aria-expanded="true">
                              <div class="panel-body">
                                    <div class="row">
                                        @foreach ($pdes as $item)
                                          <div class="row">
                                                <div class="media row col-lg-12 ">
                                                    <div class="col-lg-2 text-center">
                                                        <img src="/img/{{$item->logo}}" alt="Pliar" width="100">
                                                    </div>
                                                    <div class="row col-lg-10">
                                                        <div class="col-12"><b>{{$item->pilar}}:</b> {{$item->desc_p}}</div>
                                                        <div class="col-12"><b>{{$item->meta}}:</b> {{$item->desc_m}}</div>
                                                        <div class="col-12"><b>{{$item->resultado}}:</b> {{$item->desc_r}}</div>
                                                    </div>
                                                </div>
                                          </div>
                                        @endforeach
                                    </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-12 col-sm-12">
                      <div class="panel panel-success">
                          <div class="panel-heading" style="background-color: #468E9B;">

                              <div class="pull-left" style="margin-top: -9px;">
                                <a href="#" data-perform="panel-collapse">
                                  <i class="ti-minus"></i> Articulación ODS
                                </a>
                              </div>
                          </div>
                          <div class="panel-wrapper collapse in" aria-expanded="true">
                              <div class="panel-body">
                                    <div class="row">
                                        @foreach ($ods as $item)
                                          <div class="row">
                                                <div class="media row col-lg-12 ">
                                                    <div class="col-lg-2 text-center">
                                                        <img src="/img/{{$item->logo}}" alt="Objetivo" width="100">
                                                    </div>
                                                    <div class="row col-lg-10">
                                                        <div class="col-12"><b>Comparabilidad:</b> {{$item->comparabilidad_ods_pdes}}<hr class="m-t-0 m-b-10"/></div>
                                                        <div class="col-12"><b>{{$item->objetivo}}:</b> {{$item->desc_o}}</div>
                                                        <div class="col-12"><b>{{$item->meta}}:</b> {{$item->desc_m}}</div>
                                                        <div class="col-12"><b>{{$item->indicador}}:</b> {{$item->desc_i}}</div>
                                                    </div>
                                                </div>
                                          </div>
                                        @endforeach
                                    </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-12 col-sm-12">
                      <div class="panel panel-success">
                          <div class="panel-heading" style="background-color: #468E9B;">

                              <div class="pull-left" style="margin-top: -9px;">
                                <a href="#" data-perform="panel-collapse">
                                  <i class="ti-minus"></i> Información básica
                                </a>
                              </div>
                          </div>
                          <div class="panel-wrapper collapse in" aria-expanded="true">
                              <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Código</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: {{$indicador->codigo}}</p>
                                    </div>

                                    <div class="col-lg-4 col-sm-6">
                                      <b>Tipo de indicador</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: {{$indicador->tipo}}</p>
                                    </div>

                                    <div class="col-lg-4 col-sm-6">
                                      <b>Variables de desagregación</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: <?php echo str_replace(',',', ',$indicador->variables_desagregacion)?></p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Serie disponible</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: {{$indicador->serie_disponible}}</p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Fecha de línea base</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: {{$indicador->linea_base_mes}}/{{$indicador->linea_base_anio}}</p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Valor actual de línea base</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: {{number_format($indicador->linea_base_valor,4,',','.')}} </p>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                      <b>Plazo en Años</b>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                      <p>: {{$indicador->plazo_anios}} </p>
                                    </div>

                                </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="col-lg-12 col-sm-12">
                      <div class="panel panel-success">
                          <div class="panel-heading" style="background-color: #468E9B;">

                              <div class="pull-left" style="margin-top: -9px;">
                                <a href="#" data-perform="panel-collapse">
                                  <i class="ti-minus"></i> Método de cálculo
                                </a>
                              </div>
                          </div>
                          <div class="panel-wrapper collapse in" aria-expanded="true">
                              <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-6">
                                          <b>Fórmula de cálculo</b>
                                        </div>
                                        <div class="col-lg-8 col-sm-6">
                                          <p><textarea name="name" rows="4" style="width:100%" readonly disabled>{{ $indicador->formula }}</textarea></p>
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                          <br/>
                                        </div>
                                        <div class="col-lg-12">
                                            <h5><b>Parámetros de la Fórmula</b></h5>
                                            <hr/>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                          <b>Numerador</b>
                                        </div>
                                        <div class="col-lg-8 col-sm-6">
                                          <p>: {{$indicador->numerador_detalle}}</p>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                          <b>Fuente del numerador</b>
                                        </div>
                                        <div class="col-lg-8 col-sm-6">
                                          @foreach ($descFuenteNumerador as $key => $value)
                                            <div class="col-12" style="font-size:20px"><b>Nombre:&nbsp;</b>
                                                {{$value->nombre}} ({{$value->acronimo}})</div>
                                             <div class="row">
                                                <div class="col-6"><b>Tipo:&nbsp;</b>{{$value->tipo}}</div>

                                              <div class="col-6"><b>Periodicidad:&nbsp;</b>{{$value->periodicidad}}</div>
                                             </div>
                                             <div class="row">
                                              <div class="col-6"><b>Serie de datos:&nbsp;</b>{{$value->serie_datos}}</div>
                                              <div class="col-6"><b>Cobertura geográfica:&nbsp;</b>{{$value->cobertura_geografica}}</div>
                                             </div>
                                             <div class="row">
                                              <div class="col-12"><b>Principales variables:&nbsp;</b><p align="justify">{{$value->variable}}</p></div>
                                              <div class="col-6"><b>Nivel de representatividad de datos:&nbsp;</b>{{$value->nivel_representatividad_datos}}</div>
                                             </div>
                                              <div class="col-12"><b>Observaciones:&nbsp;</b><p align="justify">{{$value->observacion}}</p></div>
                                          @endforeach
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                          <b>Denominador</b>
                                        </div>
                                        <div class="col-lg-8 col-sm-6">
                                          <p>: {{$indicador->denominador_detalle}}</p>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                          <b>Fuente del denominador</b>
                                        </div>
                                        <div class="col-lg-8 col-sm-6"><p>:</p>
                                          @foreach ($descFuenteDenominador as $key => $values)
                                            <div class="col-12" style="font-size:20px"><b>Nombre:&nbsp;</b>{{$values->nombre}}  ({{$values->acronimo}})</div>
                                            <div class="row">
                                             <div class="col-6"><b>Tipo:&nbsp;</b>{{$values->tipo}}</div>
                                             <div class="col-6"><b>Periodicidad:&nbsp;</b>{{$values->periodicidad}}</div>
                                            </div>
                                            <div class="row">
                                             <div class="col-6"><b>Serie de datos:&nbsp;</b>{{$values->serie_datos}}</div>
                                             <div class="col-6"><b>Cobertura geográfica:&nbsp;</b>{{$values->cobertura_geografica}}</div>
                                            </div>
                                            <div class="row">
                                             <div class="col-12"><b>Principales variables:&nbsp;</b><p align="justify">{{$values->variable}}</p></div>
                                             <div class="col-6"><b>Nivel de representatividad de datos:&nbsp;</b>{{$values->nivel_representatividad_datos}}</div>
                                            </div>
                                             <div class="col-12"><b>Observaciones:&nbsp;</b><p align="justify">{{$values->observacion}}</p></div>
                                          @endforeach
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                          <b>Observaciones a la fuente de datos</b>
                                        </div>
                                        <div class="col-lg-8 col-sm-6">
                                          <p>: {{$indicador->observacion}}</p>
                                        </div>
                                    </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="col-lg-12 col-sm-12">
                      <div class="panel panel-success">
                          <div class="panel-heading" style="background-color: #468E9B;">

                              <div class="pull-left" style="margin-top: -9px;">
                                <a href="#" data-perform="panel-collapse">
                                  <i class="ti-minus"></i> Viabilidad de Indicador
                                </a>
                              </div>
                          </div>
                          <div class="panel-wrapper collapse in" aria-expanded="true">
                              <div class="panel-body">
                                    <div class="row">
                                      <div class="col-lg-4 col-sm-6">
                                        <b>Estado</b>
                                      </div>
                                      <div class="col-lg-8 col-sm-6">
                                        <p>: {{$estado_desc}}</p>
                                      </div>
                                      <div class="col-lg-4 col-sm-6">
                                        <b>Etapa</b>
                                      </div>
                                      <div class="col-lg-8 col-sm-6">
                                        <p>: {{$indicador->etapa}}</p>
                                      </div>
                                      <div class="col-lg-4 col-sm-6">
                                        <b>Frecuencia de reporte</b>
                                      </div>
                                      <div class="col-lg-8 col-sm-6">
                                        <p>: {{$indicador->frecuencia_reporte}}</p>
                                      </div>
                                      <div class="col-lg-4 col-sm-6">
                                        <b>Sectores Relacionados</b>
                                      </div>
                                      <div class="col-lg-8 col-sm-6">
                                        @foreach ($sectoresRelacionados as $key => $value)
                                            <p>: {{$value->denominacion}}</p>
                                        @endforeach
                                      </div>
                                      <div class="col-lg-12 col-sm-12">
                                        <h3>Tipo de Brecha para Reportar el Indicador</h3>
                                      </div>
                                      <div class="col-lg-4 col-sm-6">
                                        <b>Brecha de Datos</b>
                                      </div>
                                      <div class="col-lg-8 col-sm-6">
                                        <p>: {{$dataBrechaDatos}}</p>
                                      </div>
                                      <div class="col-lg-4 col-sm-6">
                                        <b>Brecha de Metodología</b>
                                      </div>
                                      <div class="col-lg-8 col-sm-6">
                                        <p>: {{$dataBrechaMetodologia}}</p>
                                      </div>
                                      <div class="col-lg-4 col-sm-6">
                                        <b>Brecha de Capacitación</b>
                                      </div>
                                      <div class="col-lg-8 col-sm-6">
                                        <p>: {{$dataBrechaCapacitacion}}</p>
                                      </div>

                                      <div class="col-lg-4 col-sm-6">
                                        <b>Brecha de Financiamiento</b>
                                      </div>
                                      <div class="col-lg-8 col-sm-6">
                                        <p>: {{$dataBrechaFinanciamiento}}</p>
                                      </div>



                                    </div>
                              </div>
                          </div>
                      </div>
                  </div>



                </div>


                <div id="editor"></div>
                <div class="col-md-3 hidden">
                    <div class="row" style="margin-right:6px;margin-left:6px;" > <!--style="padding-right: 0px;padding-top: 0px;padding-left: 0px;"-->
                        <div class="panel panel-success" style="border: 1px solid transparent;border-color: #d6e9c6;width:100%">
                            <div class="panel-heading panel-heading-c2" style="color: #3c763d; background-color: #dff0d8;border-color: #d6e9c6;"> Ficha indicador </div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body text-center">
                                    {{-- <a onclick="HTMLtoPDF()" style="cursor: pointer;"><img src="/img/icono_indicadores/pdf.png" title="Descargar ficha indicador "></a> --}}
                                    <a onclick="generarFicha()" style="cursor: pointer;"><img src="/img/icono_indicadores/pdf.png" title="Descargar ficha indicador "></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-right:6px;margin-left:6px;" > <!--style="padding-right: 0px;padding-top: 0px;padding-left: 0px;"-->
                        <div class="panel panel-success" style="border: 1px solid transparent;border-color: #d6e9c6;width:100%">
                            <div class="panel-heading panel-heading-c2" style="color: #3c763d; background-color: #dff0d8;border-color: #d6e9c6;"> Archivos respaldo </div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                @if($archivos)
                                  <div class="panel-body text-center">
                                        <p>
                                          Ningún archivo
                                        </p>
                                  </div>
                                @else
                                  @foreach ($archivos as $item)
                                    <div class="panel-body text-center">
                                        <a href="/respaldos/{{$item->archivo}}" style="cursor: pointer;">
                                          <p>
                                            <img src="/img/icono_indicadores/xls.png" title="Descargar Archivos respaldo ">
                                          </p>
                                            {{$item->nombre}}
                                        </a>
                                    </div>
                                  @endforeach
                                @endif

                            </div>
                        </div>
                    </div>

                </div>
            </div>


          </div>
      </div>
  </div>





@endsection

@push('script-head')
  <script type="text/javascript" src="{{ asset('js/amcharts.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/serial.js') }}"></script>
  <script type="text/javascript">
  var data =  <?php echo $grafica; ?>;
    $(document).ready(function(){
        var chartData = [{"dimension":"Ene","avance":2.0,"meta":5.0},{"dimension":"Feb","avance":8.0,"meta":9.0},{"dimension":"Mar","avance":8.0,"meta":8.0}];
        if(1==(Math.floor((Math.random() * 2) + 1))){

          var chart = AmCharts.makeChart("chartdivAvance", {
                "type": "serial",
                "theme": "light",
                "fontSize":9,
                "legend": {
                    "marginLeft":20,
                    "marginRight":0,
                    "autoMargins":false
                },
                "dataProvider": data,
                "graphs": [{
                    "title": "Avances",
                    "type": "column",
                    //"lineColor": "#00749F",  //B5CFE8
                    "lineColor": "#00749F",
                    "fillColors": "#00749F",
                    //"bullet": "diamond",
                    "bulletSize":12,
                    "bulletBorderThickness": 1,
                    "fillAlphas": 0.9,
                    "lineAlpha": 0.2,
                    "valueField": "avance"
                },{
                    "title": "Metas",
                    "type": "column",
                    //"lineColor": "#FF0000",//1D4168
                    "lineColor": "#FF0000",
                    "fillColors": "#FF0000",
                    //"bullet": "round",
                    "bulletBorderThickness": 1,
                    "textAlign": "left",
                    "fillAlphas": 0.9,
                    "lineAlpha": 0.2,
                    "color": "#000000",
                    "clustered": false,
                    "columnWidth": 0.5,
                    "valueField": "meta"




                }],
                "chartCursor": {
                    "cursorPosition": "mouse"
                },
                "categoryField": "dimension",
                "categoryAxis": {
                    "gridCount": data.length,
                    "autoGridCount": false
                }
          });
      }else{
            var chart = AmCharts.makeChart("chartdivAvance", {
                        "type": "serial",
                        "theme": "light",
                        "fontSize":9,
                        "legend": {
                            "marginLeft":20,
                            "marginRight":0,
                            "autoMargins":false
                        },
                        "dataProvider": data,
                        "graphs": [{
                            "title": "Avances",
                            "lineColor": "#00749F",
                            "bullet": "diamond",
                            "bulletSize":12,
                            "bulletBorderThickness": 1,
                            "valueField": "avance"
                        },{
                            "title": "Metas",
                            "lineColor": "#FF0000",
                            "bullet": "round",
                            "bulletBorderThickness": 1,
                            "valueField": "meta"
                        }],
                        "chartCursor": {
                            "cursorPosition": "mouse"
                        },
                        "categoryField": "dimension",
                        "categoryAxis": {
                            "gridCount": data.length,
                            "autoGridCount": false
                        }
            });
      }
  });

 function generarFicha(){
    window.location.href = '/sistemarime/generatePdf/'+{{ $indicador->id }};
 }
 </script>
@endpush
