@extends('layouts.sistemaremi')

@section('header')

  {{-- <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap/dist/css/bootstrap.min.css') }}" /> --}}
  <link rel="stylesheet" href="{{ asset('plugins/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}"  type="text/css" />
  <link href="/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">


  <link rel="stylesheet" href="{{ asset('jqwidgets5.5.0/jqwidgets/styles/jqx.base.css') }} " type="text/css" />
  <link rel="stylesheet" href="{{ asset('jqwidgets5.5.0/jqwidgets/styles/jqx.ui-lightness.css') }} " type="text/css" />

  <style media="screen">
    .select2-container-multi{
      padding-left: 0px;padding-right: 0px;padding-top: 0px;
    }

    table.scroll , .scroll tr td{
    border:1px solid #E4E7EA;
    }
    .scroll tbody {
        display:block;
        height:200px;
        overflow:auto;
    }
    .scroll thead, .scroll tbody tr {
        display:table;
        width:100%;
        table-layout:fixed;
    }
    .scroll thead {
        width: calc( 100% - 1em )
    }
    table.scroll {
        width:100%;
    }


input[type=checkbox] + label {
  display: block;
  margin: 0.1em;
  cursor: pointer;
  padding: 0.1em;
}

input[type=checkbox] {
  display: none;
}

input[type=checkbox] + label:before {
  content: "\2714";
  border: 0.1em solid #000;
  border-radius: 0.1em;
  display: inline-block;
  width: 1.3em;
  height: 1.3em;
  padding-left: 0.2em;
  padding-bottom: 0.5em;
  margin-right: 0.2em;
  vertical-align: bottom;
  color: transparent;
  transition: .2s;
}

input[type=checkbox] + label:active:before {
  transform: scale(0);
}

input[type=checkbox]:checked + label:before {
  background-color: MediumSeaGreen;
  border-color: MediumSeaGreen;
  color: #fff;
}

input[type=checkbox]:disabled + label:before {
  transform: scale(1);
  border-color: #aaa;
}

input[type=checkbox]:checked:disabled + label:before {
  transform: scale(1);
  background-color: #bfb;
  border-color: #bfb;
}

.modal-dialog1 {
    position: relative;
    width: 500px;
    margin: auto;
    top: 130px;
}

  </style>
@endsection

@section('content')

  <div class="row bg-title">
      <!-- .page title -->
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">Administrador de indicadores</h4>
      </div>
      <!-- /.page title -->
      <!-- .breadcrumb -->
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
              <li><a href="{{ url('/sistemaremi/index') }}">Indicadores</a></li>
              <li class="active">Administrar indicadores</li>
          </ol>
      </div>
      <!-- /.breadcrumb -->
  </div>

  <div id="option1" class="row">
      <div class="col-lg-12 ">
          <div class="white-box">
            <h3 class="box-title m-b-0">Lista de indicadores</h3>
            <p class="text-muted m-b-30">Indicadores registrados por su usuario<button id ="btn-new" type="button" class="btn btn-info btn-lg" style="float: right;margin-top: -26px;"><i class="fa fa-plus"></i>Agregar Nuevo</button></p>

            <div class="row">
              <div id="FilterAdvanced" class="col-lg-3 hidden">
                  <div style="margin-top: 30px;">
                      <div>Filtrado por:</div>
                      <div id="columnchooser"></div>
                      <div style="float: left;  margin-top: 10px;" id="filterbox"></div>
                      <div style="float: left; margin-left: 20px; margin-top: 10px;">
                          <input type="button" id="applyFilter" value="Aplicar filtro" />
                          <input type="button" id="clearfilter" style="margin-top:20px;" value="Limpiar"/>
                      </div>
                  </div>
              </div>
              <div id="exportarData" class="col-lg-3 hidden">
                  <div style="margin-top: 30px;">
                      <div>Exportar a:</div>
                      <select class="form-control">
                          <option value="excel">Excel</option>
                      </select>
                      <label>
                        <input name="option_data" value="1" type="radio"> Contenido de tabla
                      </label>
                      <label>
                        <input name="option_data" value="2" type="radio"> Registro seleccionado
                      </label>
                      <div style="float: left; margin-left: 20px; margin-top: 10px;">
                        <button id="generarExport" type="button" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i> Generar Reporte</button>
                      </div>
                  </div>
              </div>
              <div id="jqxDataTable" class="col-lg-12">
                <p class="m-b-5">
                  <button onclick="showFilterAdvanced();" type="button" class="btn btn-warning btn-sm "><i class="fa fa-filter"></i> Filtrar por</button>
                  <button onclick="showExportarData();" type="button" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i> Exportar a</button>
                </p>
                <div id="dataTable"></div>
              </div>
            </div>

          </div>
      </div>
  </div>
  <div id="option2" class="row hidden">
      <div class="col-lg-12 ">
          <form id="formAdd" name="formAdd" action="javascript:save();" data-toggle="validator" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="id_indicador" value="">
            <input type="hidden" name="tap_next" value="">
            <!-- .row -->
            <div class="row">
              <div class="col-sm-12">
                  <div class="white-box">
                      <h3 class="box-title m-b-0">Información del Indicador</h3>
                      <p class="text-muted m-b-30">Completar todos los datos solicitados<button id ="btn-back" type="button" class="btn btn-info btn-lg" style="float: right;margin-top: -26px;"><i class="fa fa-arrow-left">Atras</i></button></p>

                      <div class="form-group row m-b-10">
                        <div class="col-md-1 p-l-0 p-r-0">
                          <label for="label" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 7px 20px 7px 3px;">Estado </label>

                        </div>
                        <div class="col-md-10 p-l-0">
                            <label id="estado_view" for="label" class="">&nbsp;&nbsp;&nbsp;&nbsp;Preliminar </label>
                            <input id="estado" type="hidden" name="estado" value="1">
                        </div>
                      </div>

                      <div class="form-group row m-b-10">
                        <div class="col-md-1 p-l-0 p-r-0">
                          <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 7px 95px 7px 3px;">Etapa</label>
                        </div>
                        <div class="col-md-11 p-l-0">
                          <label id="unaCaja" name="unaCaja" for="label" class="form-control" style="width: 100%;padding: 7px 95px 7px 3px;"></label>
                        </div>
                      </div>
                      <div class="form-group row m-b-10">
                        <div class="col-md-1 p-l-0 p-r-0">
                          <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 7px 95px 7px 3px;">Nombre</label>
                        </div>
                        <div class="col-md-11 p-l-0">
                           <label id="dosCaja" name="dosCaja" for="label" class="form-control" style="width: 100%;padding: 7px 95px 7px 3px;"></label>
                        </div>
                      </div>

<!-- <form>
  <input type="checkbox" id="fruit1" name="fruit-1" value="Apple">
  <label for="fruit1">Apple</label>
  <input type="checkbox" id="fruit2" name="fruit-2" value="Banana" disabled>
  <label for="fruit2">Banana</label>
  <input type="checkbox" id="fruit3" name="fruit-3" value="Cherry" checked disabled>
  <label for="fruit3">Cherry</label>
  <input type="checkbox" id="fruit4" name="fruit-4" value="Strawberry">
  <label for="fruit4">Strawberry</label>
</form>  -->


                    <hr>
                    <div class="row">
                      <div class="col-lg-12 col-sm-12 col-xs-12 p-l-0">
                              <div class="vtabs">
                                  <ul class="nav tabs-vertical media p-t-0 p-l-0 p-r-0" style="width:300px;">
                                    <li class="tab nav-item">
                                        <a id="tab-ini1" data-toggle="tab" class="nav-link ctrl-btn active" href="#info1" aria-expanded="false">
                                          <span class="visible-xs"><i class="fa fa-sitemap" style="font-size: 25px"></i></span>
                                          <span class="hidden-xs"><i class="fa fa-sitemap" style="font-size: 25px"></i> Alinear al PDES</span>
                                        </a>
                                    </li>
                                      <li class="tab nav-item">
                                          <a id="tab-ini2" data-toggle="tab" class="nav-link ctrl-btn" href="#info2" aria-expanded="true">
                                            <span class="visible-xs"><i class="fa fa-book" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-book" style="font-size: 25px"></i> Información básica </span>
                                          </a>
                                      </li>
 <!--                                      <li class="tab nav-item" hidden="hidden">
                                          <a id="tab-ini3" aria-expanded="false" class="nav-link ctrl-btn" data-toggle="tab" href="#info3">
                                            <span class="visible-xs"><i class="fa fa-building-o" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-building-o" style="font-size: 25px"></i> Método de cálculo</span>
                                          </a>
                                      </li> -->

                                      <li class="tab nav-item">
                                          <a id="tab-ini3" data-toggle="tab" class="nav-link ctrl-btn" href="#info3" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-eye" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-eye" style="font-size: 25px"></i> Metas y avances</span>
                                          </a>
                                      </li>
<!--                                       <li class="tab nav-item" hidden="hidden">
                                          <a id="tab-ini5" data-toggle="tab" class="nav-link ctrl-btn" href="#info5" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-briefcase" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-briefcase" style="font-size: 25px"></i> Fuente de datos</span>
                                          </a>
                                      </li> -->
                                      <li class="tab nav-item">
                                          <a id="tab-ini4" data-toggle="tab" class="nav-link ctrl-btn" href="#info4" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-cloud-upload" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-cloud-upload" style="font-size: 25px"></i> Archivos respaldo</span>
                                          </a>
                                      </li>
                                      <li class="tab nav-item">
                                          <a id="tab-ini5" data-toggle="tab" class="nav-link ctrl-btn" href="#info5" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-file-text" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-file-text" style="font-size: 25px"></i> Viabilidad del Indicador</span>
                                          </a>
                                      </li>
                                     <li class="tab nav-item">
                                          <a id="tab-ini6" data-toggle="tab" class="nav-link ctrl-btn" href="#info6" aria-expanded="false">
                                            <span class="visible-xs"><i class="fa fa-cog" style="font-size: 25px"></i></span>
                                            <span class="hidden-xs"><i class="fa fa-cog" style="font-size: 25px"></i> Secretaria Técnica CIMPDS</span>
                                          </a>
                                      </li>
                                  </ul>
                                  <div class="tab-content media p-t-0 p-l-0 p-r-0" style="width: 80%;">
                                      <div id="info1" class="tab-pane active">
<!--
                                          <div class="form-group row m-b-5 m-l-5 m-t-5">
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Nombre</label>
                                              </div>
                                            <div class="col-md-9 p-l-0">
                                                <input id="nombre" name="nombre" type="text" class="form-control"  placeholder="Nombre del indicador" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                          </div>

                                          <div class="form-group row m-b-5 m-l-5 m-t-5">
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Definición</label>
                                              </div>
                                            <div class="col-md-9 p-l-0">
                                                <textarea id="definicion" name="definicion" class="form-control" placeholder="Definición del indicador" required></textarea>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                          </div> -->

                                          <div class="col-md-12 list-group-item-success" style="margin-top: -9px;">
                                              <h4 style="width:100%;">Alinear al PDES</h4>
                                          </div>
                                          <p><h5>Ingrese los codigos PDES para agregar la articulación (Ayuda F9)</h5></p>
                                          <div class="col-md-12">
                                                <div class="row m-b-5 m-l-5 m-t-5" >
                                                    <div class="form-group col-md-2 p-l-0 p-r-0">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Pilar</label>
                                                    </div>
                                                    <div class="form-group col-md-1 p-l-0">
                                                        <input id="cod_pilar" name="cod_pilar" type="text" class="form-control input" placeholder="Pilar" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                        <div class="help-block with-errors"></div>
                                                    </div>

                                                    <div class="form-group col-md-2 p-l-0 p-r-0">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta</label>
                                                    </div>
                                                    <div class="form-group col-md-1 p-l-0">
                                                        <input id="cod_meta" name="cod_meta" type="text" class="form-control input" placeholder="Meta" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                        <div class="help-block with-errors"></div>
                                                    </div>

                                                    <div class="form-group col-md-2 p-l-0 p-r-0">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Resultado</label>
                                                    </div>
                                                    <div class="form-group col-md-2 p-l-0">
                                                        <input id="cod_resultado" name="cod_resultado" type="text" class="form-control input" placeholder="Resultado" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                        <div class="help-block with-errors"></div>
                                                    </div>

                                                    <div class="col-md-2 p-l-0 text-center">
                                                        <button type="button" class="btn btn-info btn-sm agregarART m-t-5"><i class="fa fa-plus-square"></i> Agregar</button>
                                                    </div>
                                                </div>
<!--                                                 <h5>Detalle de articulación</h5> -->
                                                <div id="datosART">
                                                    <div></div>
                                                </div>
<!--                                           <div class="col-md-12 list-group-item-success" style="margin-top: -9px;">
                                              <h4 style="width:100%;">Alinear al ODS</h4>
                                          </div>
                                          <p><h5>Ingrese los codigos ODS para agregar la articulación (Ayuda F10)</h5></p>
                                                <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                   <div class="col-md-3 p-l-0 p-r-0">
                                                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Comparabilidad ODS/PDES</label>
                                                    </div>

                                                    <div class="form-group col-md-4 p-l-0">
                                                          <select id="relac" name="relac" class="custom-select col-12 form-control enabledCampos" required>
                                                                <option value="">Seleccionar Relacion.......</option>
                                                                @foreach ($relacop as  $ind_op)
                                                                    <option value="{{ $ind_op->relacion_pdes_ods }}">{{ $ind_op->relacion_pdes_ods }}</option>
                                                                @endforeach
                                                          </select>
                                                          <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>

                                                <div class="row m-b-5 m-l-5 m-t-5" >
                                                    <div class="form-group col-md-2 p-l-0 p-r-0">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Objetivo</label>
                                                    </div>
                                                    <div class="form-group col-md-2 p-l-0">
                                                        <input id="cod_pilar1" name="cod_pilar1" type="text" class="form-control input" placeholder="Objetivo" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                        <div class="help-block with-errors"></div>
                                                    </div>

                                                    <div class="form-group col-md-1 p-l-0 p-r-0">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta</label>
                                                    </div>
                                                    <div class="form-group col-md-1 p-l-0">
                                                        <input id="cod_meta1" name="cod_meta1" type="text" class="form-control input" placeholder="Meta" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                        <div class="help-block with-errors"></div>
                                                    </div>

                                                    <div class="form-group col-md-2 p-l-0 p-r-0">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Indicador</label>
                                                    </div>
                                                    <div class="form-group col-md-2 p-l-0">
                                                        <input id="cod_resultado1" name="cod_resultado1" type="text" class="form-control input" placeholder="Indicador" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 0, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                        <div class="help-block with-errors"></div>
                                                    </div>

                                                    <div class="col-md-2 p-l-0 text-center">
                                                        <button type="button" class="btn btn-info btn-sm agregarART1 m-t-5"><i class="fa fa-plus-square"></i> Agregar</button>
                                                    </div>
                                                </div> -->
<!--                                                 <h5>Detalle de articulación</h5> -->
<!--                                                 <div id="datosART1">
                                                    <div></div>
                                                </div> -->

                                            </div>
                                      </div>

                                      <div id="info2" class="tab-pane ">
                                          <div class="col-md-12 list-group-item-success">
                                              <h4 style="width:100%;">Información Básica del indicador </h4>
                                          </div>
                                          <div class="col-md-12">

                                          <div class="form-group row m-b-5 m-l-5 m-t-5">
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Nombre</label>
                                              </div>
                                            <div class="col-md-9 p-l-0">
                                                <input id="nombre" name="nombre" type="text" class="form-control"  placeholder="Nombre del indicador">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                          </div>

                                          <div class="form-group row m-b-5 m-l-5 m-t-5">
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Definición</label>
                                              </div>
                                            <div class="col-md-9 p-l-0">
                                                <textarea id="definicion" name="definicion" class="form-control" placeholder="Definición del indicador"></textarea>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                          </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Etapa</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <select id="etapa" name="etapa" class="custom-select col-12 form-control" >
                                                      <option value="">Seleccionar...</option>
                                                      <option value="Etapa 1">Etapa 1</option>
                                                      <option value="Etapa 2">Etapa 2</option>
                                                      <option value="Etapa 3">Etapa 3</option>
                                                  </select>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                <div class="col-md-3 p-l-0 p-r-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Tipo</label>
                                                </div>
                                                <div class="col-md-9 p-l-0">
                                                    <select id="tipo" name="tipo" class="custom-select col-12 form-control">
                                                        <option value="">Seleccionar...</option>
                                                        @foreach ($tipos as  $item)
                                                              <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                              </div>

                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                <div class="col-md-3 p-l-0 p-r-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Unidad de medida</label>
                                                </div>
                                                <div class="col-md-9 p-l-0">
                                                    <select id="unidad_medida" name="unidad_medida" class="custom-select col-12 form-control">
                                                      <option value="">Seleccionar...</option>
                                                        @foreach ($unidades as  $item)
                                                              <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                              </div>


                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                <div class="col-md-3 p-l-0 p-r-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Frecuencia de reporte</label>
                                                </div>
                                                <div class="col-md-9 p-l-0">
                                                    <select id="frecuencia" name="frecuencia" class="custom-select col-12 form-control">
                                                        <option value="">Seleccionar...</option>
                                                        @foreach ($frecuencia as  $item)
                                                              <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                              </div>

                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                    <div class="col-md-3 p-l-0 p-r-0">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Serie disponible</label>
                                                    </div>
                                                    <div class="col-md-9 p-l-0">
                                                        <input id="serie_disponible" name="serie_disponible" type="text" class="form-control" placeholder="Tipo de indicador" >
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                              </div>
                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                <div class="col-md-3 p-l-0 p-r-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Variables de desagregación</label>
                                                </div>
                                                <div class="col-md-9 p-l-0">
                                                    <div class="select2-wrapper">
                                                      <?php /*
                                                      <select id="variables_desagregacion" name="variables_desagregacion[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple">
                                                          @foreach ($variables as  $item)
                                                                <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                                                          @endforeach
                                                      </select>
                                                      */ ?>
                                                      <textarea id="variables_desagregacion" name="variables_desagregacion" class="form-control" placeholder="Variables"></textarea>

                                                    </div>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                              </div>


<!--                                               <h5>Linea base del indicador</h5>
                                              <hr>
                                              <div class="row m-b-5 m-l-5 m-t-5" >
                                                  <div class="form-group col-md-3 p-l-0 p-r-0">
                                                    <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Fecha linea base</label>
                                                  </div>
                                                  <div class="form-group col-md-3 p-l-0">
                                                    <div class='input-group date' id='dateLB'>
                                                      <input name="linea_base_fecha" type='text' class="form-control" placeholder="mm/yyyy"/>
                                                      <span class="input-group-addon">
                                                          <span class="glyphicon glyphicon-calendar">
                                                          </span>
                                                      </span>
                                                    </div>
                                                    <div class="help-block with-errors"></div>
                                                  </div>
                                                  <div class="form-group col-md-3 p-l-0 p-r-0">
                                                    <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Valor linea base</label>
                                                  </div>
                                                  <div class="form-group col-md-3 p-l-0">
                                                      <input name="linea_base_valor" type="text" class="form-control input" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;" value="0.00">
                                                      <div class="help-block with-errors"></div>
                                                  </div>
                                              </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Fórmula</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                <textarea id="formula" name="formula" class="form-control" placeholder="Fórmula" rows="2" ></textarea>
                                                <div class="help-block with-errors"></div>
                                              </div>
                                            </div>
                                            <h5>Detallar fórmula</h5>
                                            <hr/> -->
                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Numerador</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <textarea id="numerador_detalle" name="numerador_detalle" class="form-control" placeholder="Numerador" rows="2" ></textarea>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>


                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                               <div class="col-md-3 p-l-0 p-r-0">
                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Fuente Numerador</label>
                                                 <h5>(<b>F8</b> agregar uno nuevo a la lista)</h5>
                                               </div>
                                               <div class="col-md-9 p-l-0">
                                                   <div class="select2-wrapper">
                                              <select id="fuente_datos" name="fuente_datos[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple">
                                                         @foreach ($fuente_datos as  $item)
                                                               <option value="{{ $item->id }}">{{$item->nombre}}</option>
                                                         @endforeach
                                                     </select>
                                                   </div>
                                                   <div class="help-block with-errors"></div>
                                               </div>
                                             </div>
<!--                                              <h5>Detalle fuente de datos seleccionado(s)</h5>
                                             <hr/> -->
                                             <div id="datosFDN">
                                             </div>

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Denominador</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <textarea id="denominador_detalle" name="denominador_detalle" class="form-control" placeholder="Denominador" rows="2" ></textarea>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>
                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                               <div class="col-md-3 p-l-0 p-r-0">
                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Fuente Denominador</label>
                                                 <h5>(<b>F8</b> agregar uno nuevo a la lista)</h5>
                                               </div>
                                               <div class="col-md-9 p-l-0">
                                                   <div class="select2-wrapper">
                                          <select id="fuente_datos_d" name="fuente_datos_d[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple">
                                                         @foreach ($fuente_datos as  $item)
                                                               <option value="{{ $item->id }}">{{$item->nombre}}</option>
                                                         @endforeach
                                                     </select>
                                                   </div>
                                                   <div class="help-block with-errors"></div>
                                               </div>
                                             </div>
<!--                                              <h5>Detalle fuente de datos seleccionado(s)</h5>
                                             <hr/> -->
                                             <div id="datosFDD">
                                             </div>
                                   <!--         </div> -->

                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Observaciones a la fuente de datos</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <textarea id="observacion" name="observacion" class="form-control" placeholder="Observaciones al indicador" rows="8" ></textarea>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div>

                                          </div>
                                      </div>


    <!--                                   <div id="info3" class="tab-pane">
                                          <div class="col-md-12 list-group-item-success">
                                              <h4 style="width:100%;">Método de cálculo del indicador</h4>
                                          </div>
                                          <div class="col-md-12"> -->

 <!--                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-2 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Fórmula</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                <textarea id="formula" name="formula" class="form-control" placeholder="Fórmula" rows="2" ></textarea>
                                                <div class="help-block with-errors"></div>
                                              </div>
                                            </div>
                                            <h5>Detallar fórmula</h5>
                                            <hr/>
                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-2 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Numerador</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <textarea id="numerador_detalle" name="numerador_detalle" class="form-control" placeholder="Numerador" rows="2" ></textarea>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div> -->
<!--                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-2 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Fuente numerador</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <input id="numerador_fuente" name="numerador_fuente" type="text" class="form-control"  placeholder="Tipo de indicador" >
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div> -->
  <!--                                           <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-3 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Denominador</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <textarea id="denominador_detalle" name="denominador_detalle" class="form-control" placeholder="Denominador" rows="2" ></textarea>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div> -->
<!--                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-2 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Fuente denominador</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <input id="denominador_fuente" name="denominador_fuente" type="text" class="form-control" placeholder="Tipo de indicador" >
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div> -->

                                   <!--        <div class="col-md-12"> -->
 <!--                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                               <div class="col-md-2 p-l-0 p-r-0">
                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Fuente</label>
                                                 <h5>(<b>F8</b> agregar uno nuevo a la lista)</h5>
                                               </div>
                                               <div class="col-md-9 p-l-0">
                                                   <div class="select2-wrapper">
                                                     <select id="fuente_datos" name="fuente_datos[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple">
                                                         @foreach ($fuente_datos as  $item)
                                                               <option value="{{ $item->id }}">{{$item->nombre}}</option>
                                                         @endforeach
                                                     </select>
                                                   </div>
                                                   <div class="help-block with-errors"></div>
                                               </div>
                                             </div> -->
<!--                                              <h5>Detalle fuente de datos seleccionado(s)</h5>
                                             <hr/> -->
<!--                                              <div id="datosFD">
                                             </div> -->
                                   <!--         </div> -->

<!--                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                              <div class="col-md-2 p-l-0 p-r-0">
                                                <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Observaciones a la fuente de datos</label>
                                              </div>
                                              <div class="col-md-9 p-l-0">
                                                  <textarea id="observacion" name="observacion" class="form-control" placeholder="Observaciones al indicador" rows="8" ></textarea>
                                                  <div class="help-block with-errors"></div>
                                              </div>
                                            </div> -->

                     <!--                      </div>
                                      </div> -->

                                      <div id="info3" class="tab-pane">  <!--  ANTES ERA 4 -->
                                           <div class="col-md-12 list-group-item-success">
                                               <h4 style="width:100%;">Metas y avances</h4>
                                           </div>
                                            <div class="col-md-12">
                                              <h5>Linea base del indicador</h5>
                                        <!--       <hr> -->
                                              <div class=" form-group row m-b-5 m-l-5 m-t-5" >
                                                  <div class="form-group col-md-3 p-l-0 p-r-0">
                                                    <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Fecha linea base</label>
                                                  </div>
                                                  <div class="form-group col-md-3 p-l-0">
                                                    <div class='input-group date' id='dateLB'>
                                                      <input name="linea_base_fecha" type='text' class="form-control" placeholder="dd/mm/yyyy"/>
                                                      <span class="input-group-addon">
                                                          <span class="glyphicon glyphicon-calendar">
                                                          </span>
                                                      </span>
                                                    </div>
                                                    <div class="help-block with-errors"></div>
                                                  </div>
                                                  <div class="form-group col-md-3 p-l-0 p-r-0">
                                                    <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Valor linea base</label>
                                                  </div>
                                                  <div class="form-group col-md-3 p-l-0">
                                                      <input name="linea_base_valor" type="text" class="form-control input" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;" value="0.00">
                                                      <div class="help-block with-errors"></div>
                                                  </div>
                                              </div>
                                            </div>
                                           <div class="col-md-12">
                                               <h5>Metas macro</h5>
                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                   <div class="col-md-2 p-l-0 p-r-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta 2020</label>
                                                   </div>
                                                   <div class="col-md-2 p-l-0">
                                                       <input id="id_meta_2020" name="id_meta_2020" type="hidden" class="form-control oculto" required>
                                                       <input id="meta_2020" name="meta_2020" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                       <div class="help-block with-errors"></div>
                                                   </div>

                                                   <div class="col-md-2 p-l-0 p-r-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta 2025</label>
                                                   </div>
                                                   <div class="col-md-2 p-l-0">
                                                       <input id="id_meta_2025" name="id_meta_2025" type="hidden" class="form-control oculto" required>
                                                       <input id="meta_2025" name="meta_2025" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                       <div class="help-block with-errors"></div>
                                                   </div>


                                                   <div class="col-md-2 p-l-0 p-r-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Meta 2030</label>
                                                   </div>
                                                   <div class="col-md-2 p-l-0">
                                                       <input id="id_meta_2030" name="id_meta_2030" type="hidden" class="form-control oculto" required>
                                                       <input id="meta_2030" name="meta_2030" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',',  'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                       <div class="help-block with-errors"></div>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-12">
                                       <!--       <hr/> -->
                                               <h5>Metas Parciales</h5>
                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                   <div class="form-group col-md-3 p-l-0 p-r-0 m-b-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Gestión 2016</label>
                                                   </div>
                                                   <div class="form-group col-md-3 p-l-0 m-b-0">
                                                       <input id="id_meta_2016" name="id_meta_2016" type="hidden" class="form-control oculto" required>
                                                       <input id="meta_2016" name="meta_2016" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                       <div class="help-block with-errors"></div>
                                                   </div>
                                               <div class="form-group col-md-3 p-l-0 p-r-0 m-b-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Unidad de medida</label>
                                                </div>
                                                  <div class="form-group col-md-3 p-l-0 m-b-0">
                                                      <label id="medida_2016" name="medida_2016" for="label" class="form-control"></label>
                                                      <div class="help-block with-errors"></div>
                                                </div>
                                              </div>
                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                   <div class="form-group col-md-3 p-l-0 p-r-0 m-b-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Gestión 2017</label>
                                                   </div>
                                                   <div class="form-group col-md-3 p-l-0 m-b-0">
                                                       <input id="id_meta_2017" name="id_meta_2017" type="hidden" class="form-control oculto" required>
                                                       <input id="meta_2017" name="meta_2017" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                       <div class="help-block with-errors"></div>
                                                   </div>
                                              <div class="form-group col-md-3 p-l-0 p-r-0 m-b-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Unidad de medida</label>
                                                </div>
                                                  <div class="form-group col-md-3 p-l-0 m-b-0">
                                                      <label id="medida_2017" name="medida_2017" for="label" class="form-control"></label>
                                                      <div class="help-block with-errors"></div>
                                                </div>
                                              </div>
                                              <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                   <div class="form-group col-md-3 p-l-0 p-r-0 m-b-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Gestión 2018</label>
                                                   </div>
                                                   <div class="form-group col-md-3 p-l-0 m-b-0">
                                                       <input id="id_meta_2018" name="id_meta_2018" type="hidden" class="form-control oculto" required>
                                                       <input id="meta_2018" name="meta_2018" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                       <div class="help-block with-errors"></div>
                                                   </div>
                                              <div class="form-group col-md-3 p-l-0 p-r-0 m-b-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Unidad de medida</label>
                                                </div>
                                                  <div class="form-group col-md-3 p-l-0 m-b-0">
                                                      <label id="medida_2018" name="medida_2018" for="label" class="form-control"></label>
                                                      <div class="help-block with-errors"></div>
                                                </div>
                                               </div>
                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                    <div class="form-group col-md-3 p-l-0 p-r-0 m-b-0">
                                                      <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Gestión 2019</label>
                                                    </div>
                                                    <div class="form-group col-md-3 p-l-0 m-b-0">
                                                        <input id="id_meta_2019" name="id_meta_2019" type="hidden" class="form-control oculto" required>
                                                        <input id="meta_2019" name="meta_2019" type="text" class="form-control input" placeholder="Valor" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;">
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                              <div class="form-group col-md-3 p-l-0 p-r-0 m-b-0">
                                                  <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Unidad de medida</label>
                                                </div>
                                                  <div class="form-group col-md-3 p-l-0 m-b-0">
                                                      <label id="medida_2019" name="medida_2019" for="label" class="form-control"></label>
                                                      <div class="help-block with-errors"></div>
                                                  </div>
                                                </div>
                                           </div>

                                           <div class="col-md-12">
           <!--                                   <hr/> -->
                                               <h4>Reportar avances</h4>
                                               <div class="row m-b-5 m-l-5 m-t-5" >
                                                   <div class="form-group col-md-3 p-l-0 p-r-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Fecha reporte</label>
                                                   </div>
                                                   <div class="form-group col-md-3 p-l-0">
                                                     <div class='input-group date' id='dateAV'>
                                                       <input name="avance_fecha_input" type='text' class="form-control" placeholder="mes/Año"/>
                                                       <span class="input-group-addon">
                                                           <span class="glyphicon glyphicon-calendar">
                                                           </span>
                                                       </span>
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                   </div>
                                                   <div class="form-group col-md-3 p-l-0 p-r-0">
                                                     <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Valor a reportar</label>
                                                   </div>
                                                   <div class="form-group col-md-3 p-l-0">
                                                       <input name="avance_valor_input" type="text" class="form-control input" placeholder="Valor"  value="0" data-inputmask="'alias': 'decimal', 'radixPoint': ',', 'groupSeparator': ',', 'autoGroup': false, 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" style="text-align: right;" >
                                                       <div class="help-block with-errors"></div>
                                                   </div>

<!--                                                <div class="form-group row-m-l-5" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Explicacion</label>
                                                 </div>
                                                 <div class="col-md-9 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <input id="arc_nombre_input" name="arc_nombre_input" type="text" class="form-control" placeholder="Nombre de respaldo" >
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                               </div> -->

<!--                                                    <div class="col-md-3 p-l-0 text-center">
                                                       <button type="button" class="btn btn-info btn-sm agregarAV m-t-5"><i class="fa fa-plus-square"></i> Agregar</button>
                                                   </div> -->
                                               </div>
                                                <div class="row m-b-5 m-l-5 m-t-5" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Explicacion</label>
                                                 </div>
                                                 <div class="col-md-6 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <textarea id="arc_nombre_input" name="arc_nombre_input" class="form-control" placeholder="Descripcion de fecha y valor reportado"></textarea>
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                                   <div class="col-md-3 p-l-0 text-center">
                                                       <button type="button" class="btn btn-info btn-sm agregarAV m-t-5"><i class="fa fa-plus-square"></i> Agregar</button>
                                                   </div>
                                               </div>

                                           </div>

                                           <div class="col-md-10">
                                             <h5>Listado de avances reportados</h5>
                                               <div class="row m-b-5 m-l-5 m-t-5" >
                                                 <table id="set_avance" class="table table-hover scroll table color-table danger-table table-hover table-bordered text-center">
                                                     <thead>
                                                         <tr>
                                                             <th class="col-sm-1"><center>#</center></th>
                                                             <th class="col-sm-3"><center>Fecha reportado</center></th>
                                                             <th class="col-sm-3"><center>Valor reportado</center></th>
                                                             <th class="col-sm-8"><center>Explicaciòn</center></th>
                                                             <th class="col-sm-1"><center> - </center></th>
                                                         </tr>
                                                     </thead>
                                                     <tbody>
                                                     </tbody>
                                                 </table>
                                              </div>
                                           </div>

                                           <div class="col-md-12">
                                               <br/>
                                               <br/>
                                               <br/>
                                           </div>
                                       </div>


<!--                                        <div id="info4" class="tab-pane">
                                           <div class="col-md-12 list-group-item-success">
                                               <h4 style="width:100%;">Fuente de datos del indicador</h4>
                                           </div>
                                           <div class="col-md-12">
                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >

                                               <div class="col-md-3 p-l-0 p-r-0">
                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Fuente</label>
                                                 <h5>(<b>F8</b> agregar uno nuevo a la lista)</h5>
                                               </div>
                                               <div class="col-md-9 p-l-0">
                                                   <div class="select2-wrapper">
                                                     <select id="fuente_datos" name="fuente_datos[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple">
                                                         @foreach ($fuente_datos as  $item)
                                                               <option value="{{ $item->id }}">{{$item->nombre}}</option>
                                                         @endforeach
                                                     </select>
                                                   </div>
                                                   <div class="help-block with-errors"></div>
                                               </div>
                                             </div>
                                             <h5>Detalle fuente de datos seleccionado(s)</h5>
                                             <hr/>
                                             <div id="datosFD">
                                             </div>
                                           </div>
                                       </div> -->

                                       <div id="info4" class="tab-pane"> <!--  ERA ANTES 6 -->
                                           <div class="col-md-12 list-group-item-success">
                                               <h4 style="width:100%;">Archivos respaldo</h4>
                                           </div>
                                           <div class="col-md-12">



                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Nombre de Respaldo</label>
                                                 </div>
                                                 <div class="col-md-9 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <input id="arc_nombre_input" name="arc_nombre_input" type="text" class="form-control" placeholder="Nombre de respaldo" >
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                               </div>
                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Adjuntar</label>
                                                 </div>
                                                 <div class="col-md-9 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <input type="file" id ="arc_archivo_input" name="arc_archivo_input" class="form-control p-t-0" accept=".xls,.xlsx,.cvs">
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                                 <div class="col-md-12 p-l-0 text-center">
                                                     <button type="button" class="btn btn-info btn-sm agregarARC m-t-5"><i class="fa fa-plus-square"></i> Agregar</button>
                                                 </div>
                                               </div>


                                             <h5>Archivos subidos</h5>
                                             <table id="datosARC" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                     <th>Descripcion de archivos</th>
                                                     <th>-</th>
                                                   </tr>
                                               </thead>
                                               <tbody >

                                               </tbody>
                                             </table>
                                           </div>
                                       </div>

                                     <div id="info5" class="tab-pane">
                                           <div class="col-md-12 list-group-item-success">
                                               <h4 style="width:100%;">Viabilidad de Indicador</h4>
                                           </div>
                                           <div class="col-md-12">
                       <!--                       <div class="form-group row m-b-5 m-l-5 m-t-5" > -->
                                              <h5>FORMULARIO EN CONSTRUCCION 1 !!!</h5>

<!--
                       <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Viabilidad modelo</h4>

                                <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Contenido de Viabilidad</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Recipient:</label>
                                                        <input type="text" class="form-control" id="recipient-name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="message-text" class="control-label">Message:</label>
                                                        <textarea class="form-control" id="message-text"></textarea>
                                                    </div>

                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-danger waves-effect waves-light">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <img src="../assets/images/alert/model.png" alt="default" data-toggle="modal" data-target="#responsive-modal" class="model_img img-responsive" />

                            </div>
                        </div>
                    </div> -->



            <div id="myModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog1">
                                        <div class="modal-content">
                                            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span aria-hidden="true">&times;</span></button><h5 class="modal-title" id="myModalLabel2">Contenido Viabilidad</h5></div>
                            <div class="modal-body">
                                   <form>
                                            <div class="form-group" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Nombre :</label>
                                                 </div>
                                                 <div class="col-md-9 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <input id="arc_nombre_ing" name="arc_nombre_ing" type="text" class="form-control" placeholder="Nombre del Archivo de Respaldo" >
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                               </div>
                                               <div class="form-group" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Adjuntar :</label>
                                                 </div>
                                                 <div class="col-md-9 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <input type="file" id ="arc_archivo_ing" name="arc_archivo_ing" class="form-control p-t-0" accept=".xls,.xlsx,.cvs">
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                                 <div class="col-md-12 p-l-0 text-center">
                                                     <button type="button" class="btn btn-info btn-sm agregarARCS m-t-5"><i class="fa fa-plus-square"></i> Agregar Sexo</button>
                                                 </div>
                                               </div>
                                      </form>
                                </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Cerrar</button>
                                          </div>
                                        </div>
                                    </div>
                                </div>


                  <div class="row form-group row m-b-5 m-l-5 m-t-5" >
                       <div class="col-md-2 p-l-0">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="chkCodeudor2">
                            <label class="custom-control-label" for="chkCodeudor2">SEXO</label>
                        </div>
                      </div>
                                     <div class="col-md-9 p-l-0">
                                          <!-- <h5>Archivos subidos</h5> -->
                                             <table id="datosARCS" class="table table-hover">
                                                <thead>
                                                    <tr>
<!--                                                      <th>Descripcion de archivos</th>
                                                     <th>-</th> -->
                                                   </tr>
                                               </thead>
                                               <tbody >

                                               </tbody>
                                             </table>
                                      </div>

                      </div>



            <div id="myModal3" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog1">
                                        <div class="modal-content">
                                            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span aria-hidden="true">&times;</span></button><h5 class="modal-title" id="myModalLabel3">Contenido Viabilidad</h5></div>
                            <div class="modal-body">
                                   <form>
                                            <div class="form-group" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Nombre :</label>
                                                 </div>
                                                 <div class="col-md-9 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <input id="arc_nomedad" name="arc_nomedad" type="text" class="form-control" placeholder="Nombre del Archivo de Respaldo" >
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                               </div>
                                               <div class="form-group" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Adjuntar :</label>
                                                 </div>
                                                 <div class="col-md-9 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <input type="file" id ="arc_archedad" name="arc_archedad" class="form-control p-t-0" accept=".xls,.xlsx,.cvs">
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                                 <div class="col-md-12 p-l-0 text-center">
                                                     <button type="button" class="btn btn-info btn-sm agregarARCED m-t-5"><i class="fa fa-plus-square"></i> Agregar Edad</button>
                                                 </div>
                                               </div>
                                      </form>
                                </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Cerrar</button>
                                          </div>
                                        </div>
                                    </div>
                                </div>


                  <div class="row form-group row m-b-5 m-l-5 m-t-5" >
                       <div class="col-md-2 p-l-0">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="chkCodeudor3">
                            <label class="custom-control-label" for="chkCodeudor3">EDAD</label>
                        </div>
                      </div>
                                     <div class="col-md-9 p-l-0">
                                          <!-- <h5>Archivos subidos</h5> -->
                                             <table id="datosARCED" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                     <th>Descripcion de archivos</th>
                                                     <th>-</th>
                                                   </tr>
                                               </thead>
                                               <tbody >

                                               </tbody>
                                             </table>
                                      </div>

                      </div>


<!--
                                               <div class="col-md-3 p-l-0 p-r-0">
                                                 <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;"> Fuente</label>
                                                 <h5>(<b>F8</b> agregar uno nuevo a la lista)</h5>
                                               </div>
                                               <div class="col-md-9 p-l-0">
                                                   <div class="select2-wrapper">
                                                     <select id="fuente_datos" name="fuente_datos[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple">
                                                         @foreach ($fuente_datos as  $item)
                                                               <option value="{{ $item->id }}">{{$item->nombre}}</option>
                                                         @endforeach
                                                     </select>
                                                   </div>
                                                   <div class="help-block with-errors"></div>
                                               </div> -->
                                    <!--          </div> -->
                                           </div>
                                       </div>
                                     <div id="info6" class="tab-pane">
                                           <div class="col-md-12 list-group-item-success">
                                               <h4 style="width:100%;">Secretaria Técnica CIMPDES</h4>
                                           </div>
                                           <div class="col-md-12">
                                             <h5>FORMULARIO EN CONSTRUCCION 2 !!!</h5>
                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                <div class="custom-control custom-switch">
                                  <input type="checkbox" name="checkbox1" class="custom-control-input" id="customSwitch1">
                                  <label class="custom-control-label" for="customSwitch1">SEXO</label>
                                </div>
                                             <div id="datosAFD">
                                             </div>

                                             </div>

                                             <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                <div class="custom-control custom-switch">
                                  <input type="checkbox" name="checkbox2" class="custom-control-input" id="customSwitch2">
                                  <label class="custom-control-label" for="customSwitch2">EDAD</label>
                                </div>
                                             <div id="datosAFD2">
                                             </div>

                                             </div>



          <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog1">
                    <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span aria-hidden="true">&times;</span></button><h5 class="modal-title" id="myModalLabel">Contenido Viabilidad</h5></div>
                            <div class="modal-body">
                                   <form>
                                            <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Nombre</label>
                                                 </div>
                                                 <div class="col-md-9 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <input id="arc_nombre_mod" name="arc_nombre_mod" type="text" class="form-control" placeholder="Nombre del Archivo de Respaldo" >
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                               </div>
                                               <div class="form-group row m-b-5 m-l-5 m-t-5" >
                                                 <div class="col-md-3 p-l-0 p-r-0">
                                                   <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 9px 0px 9px 3px;">Adjuntar</label>
                                                 </div>
                                                 <div class="col-md-9 p-l-0">
                                                     <div class="select2-wrapper">
                                                       <input type="file" id ="arc_archivo_mod" name="arc_archivo_mod" class="form-control p-t-0" accept=".xls,.xlsx,.cvs">
                                                     </div>
                                                     <div class="help-block with-errors"></div>
                                                 </div>
                                                 <div class="col-md-12 p-l-0 text-center">
                                                     <button type="button" class="btn btn-info btn-sm agregarARC8 m-t-5"><i class="fa fa-plus-square"></i> Agregar Mod</button>
                                                 </div>
                                               </div>
                                      </form>
                              </div>
                              <div class="modal-footer">
                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
<!--                                     <button type="button" class="btn btn-danger waves-effect waves-light">Save changes</button> -->
                              </div>
                </div>
            </div>
        </div>



                  <div class="row form-group row m-b-5 m-l-5 m-t-5" >
                       <div class="col-md-2 p-l-0">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="checkbox" class="custom-control-input" id="chkCodeudor">
                            <label class="custom-control-label" for="chkCodeudor"> Sexo MOdal</label>
                        </div>
                      </div>
                                     <div class="col-md-8 p-l-0">
                                          <!-- <h5>Archivos subidos</h5> -->
                                             <table id="datosARC8" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                     <th>Descripcion de archivos</th>
                                                     <th>-</th>
                                                   </tr>
                                               </thead>
                                               <tbody >

                                               </tbody>
                                             </table>
                                      </div>

                      </div>

                                           </div>
                                      </div>

                                  </div>
                              </div>

                      </div>
                    </div>

                    <div class="col-sm-12">
                            <div class="form-group text-center">
                              <button id="bt_guardar" type="submit" class="btn btn-info tap-btn">Guardar</button>
                              <button id="bt_siguiente" type="button" class="btn btn-info tap-btn">Siguiente</button>
                              <button type="button" class="btn btn-default btn-back">Cancelar</button>
                            </div>
                    </div>

                  </div>
              </div>


            </div>
            <!-- /.row -->
          </form>
      </div>
  </div>

  <div id="window" class="white-popup-block popup-basic admin-form mfp-with-anim" style="display: none;">
      <div class="panel panel-heading" >
        <section><span class="panel-title"><i class="fa fa-pencil"></i> Fuente de datos</span></section>
      </div>
      <div id="divcon">

        <form id="formAddFuente" name="formAddFuente" action="javascript:saveFuente();" data-toggle="validator">
          {{ csrf_field() }}
          <input type="hidden" name="id_indicador" value="">
          <!-- .row -->
          <div class="row" style="margin-right: 0px;">
            <div class="col-sm-12">
                <div class="white-box p-t-0 p-b-0 m-b-0">

                    <h3 class="box-title m-b-0">Registro de fuente de datos</h3>
                    <p class="text-muted m-b-10">Completar los datos minimos de la Fuente de Datos. <button id ="btn-new-fuente" type="submit" class="btn btn-info btn-sm" style="float: right;margin-top: -26px;"><i class="fa fa-plus"></i>Guardar</button></p>
                    <p class="text-warning m-t-0">Debe completar la informacion en Administracion de Fuente de Datos</p>
                    <div class="form-group row m-b-10">
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Nombre</label>
                      </div>
                      <div class="col-md-10 p-l-0">
                          <!--input id="fd_nombre" name="fd_nombre" type="text" class="form-control"  placeholder="Nombre de la fuente" !-->
                          <textarea id="fd_nombre" name="fd_nombre" class="form-control" placeholder="Nombre de la fuente" required></textarea>
                          <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class=" row m-b-10">
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Abreviación</label>
                      </div>
                      <div class="form-group col-md-4 p-l-0">
                          <input id="fd_acronimo" name="fd_acronimo" type="text" class="form-control"  placeholder="Abreviación" required>
                          <div class="help-block with-errors"></div>
                      </div>
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Tipo</label>
                      </div>
                      <div class="form-group col-md-4 p-l-0">
                          <select id="fd_tipo" name="fd_tipo" class="custom-select col-12 form-control" required>
                              <option value="">Seleccionar...</option>
                              @foreach ($fuente_tipos as  $item)
                                    <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                              @endforeach
                          </select>
                          <div class="help-block with-errors"></div>
                      </div>
                    </div>


                    <?php /*
                    <div class=" row m-b-10">
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="fd_periodicidad" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Periodicidad</label>
                      </div>
                      <div class="form-group col-md-4 p-l-0">
                          <select id="fd_periodicidad" name="fd_periodicidad" class="custom-select col-12 form-control">
                              <option value="">Seleccionar...</option>
                              @foreach ($frecuencia as  $item)
                                    <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                              @endforeach
                          </select>
                          <div class="help-block with-errors"></div>
                      </div>
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="fd_serie_datos" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Serie_datos</label>
                      </div>
                      <div class=" form-group col-md-4 p-l-0">
                          <input id="fd_serie_datos" name="fd_serie_datos" type="text" class="form-control"  placeholder="Serie datos disponible">
                          <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group row m-b-10">
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Cobertura</label>
                      </div>
                      <div class="col-md-10 p-l-0">
                          <select id="fd_cobertura_geografica" name="fd_cobertura_geografica[]" placeholder="Seleccionar..."  multiple="multiple" class="form-control select2 multiple">
                              @foreach ($dimensiones as  $item)
                                    <option value="{{ $item->nombre }}">{{$item->nombre}}</option>
                              @endforeach
                          </select>
                          <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group row m-b-10 p-t-20">
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Representatividad</label>
                      </div>
                      <div class="col-md-10 p-l-0">
                          <input id="fd_nivel_representatividad_datos" name="fd_nivel_representatividad_datos" type="text" class="form-control"  placeholder="Nivel representatividad de datos">
                          <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group row m-b-10">
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Variables</label>
                      </div>
                      <div class="col-md-10 p-l-0">
                          <textarea id="fd_variable" name="fd_variable" class="form-control" placeholder="Variables"></textarea>
                          <div class="help-block with-errors"></div>
                      </div>
                    </div>

                    <div class="form-group row m-b-10 p-t-20">
                      <div class="col-md-2 p-l-0 p-r-0">
                        <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100px;padding: 15px 130px 7px 3px;">Observaciones</label>
                      </div>
                      <div class="col-md-10 p-l-0">
                        <textarea id="fd_observacion" name="fd_observacion" class="form-control" placeholder="Observaciones"></textarea>
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>

                    <h3 class="box-title m-b-0">Relacionar Responsables</h3>



                    <ul class="nav nav-tabs" role="tablist">

                        <li role="presentation" class="active nav-item">
                          <a href="#lista" class="nav-link" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">
                            <span class="visible-xs"><i class="ti-user"></i></span>
                            <span class="hidden-xs">Lista </span>
                            <span id="cont_resp"class="label label-warning" style="font-size:15px;font-weight:bold;">0</span></a>
                        </li>
                        <li role="presentation" class="nav-item">
                          <a href="#registro" class="nav-link" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true">
                            <span class="visible-xs"><i class="ti-home"></i></span>
                            <span class="hidden-xs"> Registrar</span>
                          </a>
                        </li>

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="lista">
                          <table id="set_responsables" class="table table-hover scroll ">
                              <thead>
                                  <tr>
                                      <th style="width: 5%;">#</th>
                                      <th style="width: 90%;">Detalle responsable</th>
                                      <th style="width: 5%;"> - </th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                            <div class="clearfix"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="registro">

                              <div class="row">
                                  <div class="col-md-12">
                                    <div class="row">
                                          <div class="col-md-4 p-l-0 p-r-0">
                                            <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;" >Nombre entidad cabeza</label>
                                          </div>
                                          <div class="col-md-8 p-l-0">
                                            <input id="responsable_1" name="responsable_1" type="text" class="form-control"  placeholder="Nombre" required>
                                            <div class="help-block with-errors"></div>
                                          </div>

                                          <div class="col-md-4 p-l-0 p-r-0 text-right">
                                            <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;">Nombre sub entidad</label>
                                          </div>
                                          <div class="col-md-8 p-l-0">
                                            <input id="responsable_2" name="responsable_2" type="text" class="form-control"  placeholder="Nombre" required>
                                            <div class="help-block with-errors"></div>
                                          </div>

                                          <div class="col-md-4 p-l-0 p-r-0 text-right">
                                            <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;">Nombre sub entidad</label>
                                          </div>
                                          <div class="col-md-8 p-l-0">
                                            <input id="responsable_3" name="responsable_3" type="text" class="form-control"  placeholder="Nombre" required>
                                            <div class="help-block with-errors"></div>
                                          </div>

                                          <div class="col-md-4 p-l-0 p-r-0">
                                            <label for="textarea" class="col-form-label control-label list-group-item-info" style="width: 100%;padding: 15px 0px 7px 3px;">Número de referencia</label>
                                          </div>
                                          <div class="col-md-8 p-l-0">
                                            <input id="referencia" name="referencia" type="text" class="form-control"  placeholder="Nombre" required>
                                            <div class="help-block with-errors"></div>
                                          </div>
                                    </div>
                                  </div>
                              </div>
                              <div class="col-md-12 p-l-0 text-center">
                                  <button type="button" class="btn btn-info btn-sm agregarRS m-t-5"><i class="fa fa-plus-square"></i> Agregar</button>
                              </div>


                            </div>

                        </div>


                        */ ?>
                    </div>



                </div>
            </div>
        </div>

      </div>
  </div>









@endsection

@push('script-head')
  <!-- ... -->

    <script type="text/javascript" src="{{ asset('plugins/bower_components/moment/min/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/bower_components/moment/min/locales.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('plugins/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}" type="text/javascript"></script>


    <script src="{{ asset('js/jquery.inputmask.bundle.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxcore.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxwindow.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxbuttons.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxscrollbar.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdata.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdatatable.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxcheckbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxlistbox.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets5.5.0/jqwidgets/jqxdropdownlist.js') }}"></script>
    <script src="/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>
    <script type="text/javascript" src="{{ asset('js/jqwidgets-localization.js') }}"></script>

  <!-- Date Picker Plugin JavaScript -->

  <script type="text/javascript">
  var fechaAV = [];
  var valorAV = [];
  var estadoAV = [];
  var origenAV = [];

  var responsable1A = [];
  var responsable2A = [];
  var responsable3A = [];
  var referenciaA = [];
  var idAV = [];
    $(document).ready(function(){
      //$(".select2").select2();
      var theme = 'ui-lightness';

      $("#formAdd .select2").select2().attr('style','display:block; position:absolute; bottom: 0; left: 0; clip:rect(0,0,0,0);');
      $("#formAddFuente .select2").select2().attr('style','display:block; position:absolute; bottom: 0; left: 0; clip:rect(0,0,0,0);');
      $(".input").inputmask();
      $(function () {
                  $('#dateLB').datetimepicker({
                      viewMode: 'years',
                      format: 'DD/MM/YYYY',
                      locale: 'es'
                  });
                  $('#dateAV').datetimepicker({
                      viewMode: 'years',
                      format: 'MM/YYYY',
                      locale: 'es'
                  });
      });

  $('#chkCodeudor3').click(function()
        {
            if ($('#chkCodeudor3').is(":checked")) {
                $('#responsive-modal').modal('show');
            }else {
                $('#responsive-modal').modal('hide');
            }
        });

  $('#chkCodeudor').click(function()
        {
            if ($('#chkCodeudor').is(":checked")) {
                $('#myModal').modal('show');
            }else {
                $('#myModal').modal('hide');
            }
        });

  $('#chkCodeudor2').click(function()
        {
            if ($('#chkCodeudor2').is(":checked")) {
                $('#myModal2').modal('show');
            }else {
                $('#myModal2').modal('hide');
            }
        });

    $('#chkCodeudor3').click(function()
        {
            if ($('#chkCodeudor3').is(":checked")) {
                $('#myModal3').modal('show');
            }else {
                $('#myModal3').modal('hide');
            }
        });

$('#customSwitch1').click(function(){
  var result = $('input[name="checkbox1"]:checked');
  if(result.length>0){


              var html =  '<div class="form-group row m-b-5 m-l-5 m-t-5" >'+
                              '<div class="col-md-2 p-l-0 p-r-0">'+
                              '<label for="textarea" class="col-form-label control-label list-group-item-info"'+
                              'style="width: 100%;padding: 9px 0px 9px 3px;"> Nombre</label>'+
                                '</div>'+
                                    '<div class="col-md-9 p-l-0">'+
                                        '<div class="select2-wrapper">'+
                                            '<input id="arc_nombre_input" name="arc_nombre_input" type="text"'+
                                            'class="form-control" placeholder="Nombre de respaldo" >'+
                                                '</div>'+
                                                  '<div class="help-block with-errors"></div>'+
                                                '</div>'+
                                        '</div>'+
             '<div id="customSwitch12" class="form-group row m-b-5 m-l-5 m-t-5">'+
                          '<div class="col-md-2 p-l-0 p-r-0">'+
                          '<label for="textarea" class="col-form-label control-label list-group-item-info"'+ 'style="width: 100%;padding: 9px 0px 9px 3px;">Adjuntar</label>'+
                          '</div>'+
                            '<div class="col-md-9 p-l-0">'+
                                '<div class="select2-wrapper">'+
                                   '<input type="file" id ="arc_archivo_inputs" name="arc_archivo_inputs"'+
                                    'class="form-control p-t-0" accept=".xls,.xlsx,.cvs">'+
                                '</div>'+
                                '<div class="help-block with-errors">'+'</div>'+
                              '</div>'+
                              '<div class="col-md-1 p-l-0">'+
                              '<button type="button" class="btn btn-info btn-sm agregarARCS m-t-5">'+
                                '<i class="fa fa-plus-square">'+'</i>'+' Agregar Sexo</button>'+
                                '</div>'+
                          '</div>';
            // $("#datosARC1 > tbody").append(html);

            //         var html= '<div class="form-group col-md-3 p-l-0">&nbsp;HHHHHHHH</div>';
                    $("#datosAFD").append(html);
  }
  else{
                    $("#datosAFD").html("");
  }
});

$('#customSwitch2').click(function(){
  var result = $('input[name="checkbox2"]:checked');
  if(result.length>0){

            var html =  '<div id="customSwitch12" class="form-group row m-b-5 m-l-5 m-t-5">'+
                          '<div class="col-md-2 p-l-0 p-r-0">'+
                          '<label for="textarea" class="col-form-label control-label list-group-item-info"'+ 'style="width: 100%;padding: 9px 0px 9px 3px;">Adjuntar</label>'+
                          '</div>'+
                            '<div class="col-md-9 p-l-0">'+
                                '<div class="select2-wrapper">'+
                                   '<input type="file" id ="arc_archivo_input" name="arc_archivo_input"'+
                                    'class="form-control p-t-0" accept=".xls,.xlsx,.cvs">'+
                                '</div>'+
                                '<div class="help-block with-errors">'+'</div>'+
                              '</div>'+
                              '<div class="col-md-1 p-l-0">'+
                              '<button type="button" class="btn btn-info btn-sm agregarARC1 m-t-5">'+
                                '<i class="fa fa-plus-square">'+'</i>'+' Agregar Edad</button>'+
                                '</div>'+
                          '</div>';
            // $("#datosARC1 > tbody").append(html);

            //         var html= '<div class="form-group col-md-3 p-l-0">&nbsp;HHHHHHHH</div>';
                    $("#datosAFD2").append(html);
  }
  else{
                    $("#datosAFD2").html("");
  }
});

      $(".agregarART").click(function () {
         var codigo = $('input[name=cod_pilar]').val()+$('input[name=cod_meta]').val()+$('input[name=cod_resultado]').val();
         if(!$('#datosART').find("#ART"+codigo).length){
        $.ajax({
                url: "{{ url('/api/sistemaremi/setDataPdes') }}",
                data: { 'p': $('input[name=cod_pilar]').val(),'m':$('input[name=cod_meta]').val(),'r':$('input[name=cod_resultado]').val() },
                type: "get",
                dataType: 'json',
                success: function(data){
                  if(data.error == false){
                    //ip_id--;
                    var html = '<h5>Detalle de Articulación</h5>'+  //'<hr/>'+
                                '<div id="ART'+codigo+'" class="row">'+
                                  '<div class="media row col-lg-12 ">'+
                                      '<div class="col-lg-2 text-center">'+
                                          '<img src="/img/'+data.set[0].logo+'" alt="Pliar" width="100">'+
                                          '<a class="btn btn-block btn-info btn-sm m-t-10" onclick="quitarART('+codigo+',1);">Quitar</a>'+
                                      '</div>'+
                                      '<div class="row col-lg-10">'+
                                          '<input type="hidden" name="id_resultado_articulado[]" value="" />'+
                                          '<input type="hidden" name="resultado_articulado[]" value="'+data.set[0].id_resultado+'" />'+
                                          '<input type="hidden" id="EST'+codigo+'" name="estado_resultado_articulado[]" value="1" />'+
                                          '<div class="col-12"><b>'+data.set[0].pilar+':</b> '+data.set[0].desc_p+
                                          '</div>'+
                                             '<div class="col-12"><b>'+data.set[0].meta+':</b> '+data.set[0].desc_m+
                                          '</div>'+
                                          '<div class="col-12"><b>'+data.set[0].resultado+':</b> '+data.set[0].desc_r+
                                          '</div>'+
                                      '</div>'+
                                  '</div>'+
                                '</div>';
                    $("#datosART").append(html);

                  }else{
                      $.toast({
                       heading: data.title,
                       text: data.msg,
                       position: 'top-right',
                       loaderBg:'#ff6849',
                       icon: 'warning',
                       hideAfter: 3500

                     });
                  }
                },
                error:function(data){
                  if(data.status != 401){
                    $.toast({
                      heading: 'Error:',
                      text: 'Error al recuperar los datos.',
                      position: 'top-right',
                      loaderBg:'#ff6849',
                      icon: 'error',
                      hideAfter: 3500

                    });
                  }else{
                    window.location = '/login';
                  }
                }
          });
          // hacer algo aquí si el elemento existe
        }else{
            $.toast({
             heading: 'Alerta:',
             text: 'Ya existe la relación solicitada.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'warning',
             hideAfter: 3500

           });
        }

      });


      $(".agregarART1").click(function () {
         var codigo = $('input[name=cod_pilar1]').val()+$('input[name=cod_meta1]').val()+$('input[name=cod_resultado1]').val();
         var relacion = $('input[id=relac]').val();
         if(!$('#datosART1').find("#ART"+codigo).length){
        $.ajax({
                url: "{{ url('/api/sistemaremi/setDataODS') }}",
                data: { 'p': $('input[name=cod_pilar1]').val(),'m':$('input[name=cod_meta1]').val(),'r':$('input[name=cod_resultado1]').val() },
                type: "get",
                dataType: 'json',
                success: function(data){
                  if(data.error == false){
                    //ip_id--;
                    var html = '<h5>Detalle de Articulación</h5>'+  //'<hr/>'+
                                '<div id="ART'+codigo+'" class="row">'+
                                  '<div class="media row col-lg-12 ">'+
                                      '<div class="col-lg-2 text-center">'+
                                          '<img src="/img/'+data.set[0].logo+'" alt="Pliar" width="100">'+
                                          '<a class="btn btn-block btn-info btn-sm m-t-10" onclick="quitarART('+codigo+',1);">Quitar</a>'+
                                      '</div>'+
                                      '<div class="row col-lg-10">'+
                                          '<input type="hidden" name="id_resultado_articulado[]" value="" />'+
                                          '<input type="hidden" name="resultado_articulado[]" value="'+data.set[0].id_resultado+'" />'+
                                          '<input type="hidden" id="EST'+codigo+'" name="estado_resultado_articulado[]" value="1" />'+
                                          '<div class="col-12"><b>Relacion:</b>'+relacion+
                                          '</div>'+
                                          '<div class="col-12"><b>'+data.set[0].pilar+':</b> '+data.set[0].desc_p+
                                          '</div>'+
                                             '<div class="col-12"><b>'+data.set[0].meta+':</b> '+data.set[0].desc_m+
                                          '</div>'+
                                          '<div class="col-12"><b>'+data.set[0].resultado+':</b> '+data.set[0].desc_r+
                                          '</div>'+
                                      '</div>'+
                                  '</div>'+
                                '</div>';
                    $("#datosART1").append(html);

                  }else{
                      $.toast({
                       heading: data.title,
                       text: data.msg,
                       position: 'top-right',
                       loaderBg:'#ff6849',
                       icon: 'warning',
                       hideAfter: 3500

                     });
                  }
                },
                error:function(data){
                  if(data.status != 401){
                    $.toast({
                      heading: 'Error:',
                      text: 'Error al recuperar los datos.',
                      position: 'top-right',
                      loaderBg:'#ff6849',
                      icon: 'error',
                      hideAfter: 3500

                    });
                  }else{
                    window.location = '/login';
                  }
                }
          });
          // hacer algo aquí si el elemento existe
        }else{
            $.toast({
             heading: 'Alerta:',
             text: 'Ya existe la relación solicitada.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'warning',
             hideAfter: 3500

           });
        }

      });


      $(".agregarARCS").click(function () {
         var nombre = $('input[name=arc_nombre_ing]').val();
         nombre = nombre.replace(/\s/g,"_");
        // console.log("datos",nombre);
         var formData = new FormData($("#formAdd")[0]);
         if(!$('#datosARCS').find("#ARC"+nombre).length){
            $.ajax({
                    url: "{{ url('/api/sistemaremi/apiUploadArchivosRespaldos') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data){
                          if(data.error == false){
                          var html = '<tr id="ARC'+ nombre +'" class="">'+
                                          '<td>'+
                                              '<input type="hidden" name="arc_id[]" value="" />'+
                                              '<input type="hidden" name="arc_nombre[]" value="'+ data.item.nombre +'" />'+
                                              '<input type="hidden" name="arc_archivo[]" value="'+ data.item.archivo +'" />'+
                                              '<input type="hidden" id="EST'+nombre+'"name="arc_estado[]" value="1" />'+
                                              '<a href="/respaldos/'+data.item.archivo+'" style="cursor: pointer;">'+
                                              '<p>'+
                                                '<img src="/img/icono_indicadores/xls1.png" title="Descargar Archivos respaldo "> '+
                                                 data.item.nombre +
                                              '</p>'+
                                              '</a>'+
                                          '</td>'+
                                          '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARC(\''+nombre+'\',\''+data.item.archivo+'\',1);"> <i class="fa fa-close text-danger" alt="Eliminar"></i> </a></td>'+
                                      '</tr>';
                            $("#datosARCS > tbody").append(html);
                            $('input[name=arc_nombre_ing]').val('');
                            $('input[name=arc_archivo_ing]').val('');
                          }else{
                              $.toast({
                               heading: data.title,
                               text: data.msg,
                               position: 'top-right',
                               loaderBg:'#ff6849',
                               icon: 'warning',
                               hideAfter: 3500
                             });
                          }
                    },
                    error:function(data){
                      if(data.status != 401){
                        $.toast({
                          heading: 'Error:',
                          text: 'Error al recuperar los datos1.',
                          position: 'top-right',
                          loaderBg:'#ff6849',
                          icon: 'error',
                          hideAfter: 3500

                        });
                      }else{
                        window.location = '/login';
                      }
                    }
          });
                  // hacer algo aquí si el elemento existe
        }else{
            $.toast({
             heading: 'Alerta:',
             text: 'Ya existe un archivo con ese nombre.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'warning',
             hideAfter: 3500

           });
        }

      });


      $(".agregarARCED").click(function () {
         var nombre = $('input[name=arc_nomedad]').val();
         nombre = nombre.replace(/\s/g,"_");
         //console.log("DATOS",nombre);
         var formData = new FormData($("#formAdd")[0]);
         if(!$('#datosARCED').find("#ARC"+nombre).length){
            $.ajax({
                    url: "{{ url('/api/sistemaremi/apiUploadArchivoRespaldoEdad') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data){
                          if(data.error == false){
                          var html = '<tr id="ARC'+ nombre +'" class="">'+
                                          '<td>'+
                                              '<input type="hidden" name="arc_id[]" value="" />'+
                                              '<input type="hidden" name="arc_nombre[]" value="'+ data.item.nombre +'" />'+
                                              '<input type="hidden" name="arc_archivo[]" value="'+ data.item.archivo +'" />'+
                                              '<input type="hidden" id="EST'+nombre+'"name="arc_estado[]" value="1" />'+
                                              '<a href="/respaldos/'+data.item.archivo+'" style="cursor: pointer;">'+
                                              '<p>'+
                                                '<img src="/img/icono_indicadores/xls1.png" title="Descargar Archivos respaldo "> '+
                                                 data.item.nombre +
                                              '</p>'+
                                              '</a>'+
                                          '</td>'+
                                          '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARC(\''+nombre+'\',\''+data.item.archivo+'\',1);"> <i class="fa fa-close text-danger" alt="Eliminar"></i> </a></td>'+
                                      '</tr>';
                            $("#datosARCED > tbody").append(html);
                            $('input[name=arc_nomedad]').val('');
                            $('input[name=arc_archedad]').val('');
                          }else{
                              $.toast({
                               heading: data.title,
                               text: data.msg,
                               position: 'top-right',
                               loaderBg:'#ff6849',
                               icon: 'warning',
                               hideAfter: 3500
                             });
                          }
                    },
                    error:function(data){
                      if(data.status != 401){
                        $.toast({
                          heading: 'Error:',
                          text: 'Error al recuperar los datos.',
                          position: 'top-right',
                          loaderBg:'#ff6849',
                          icon: 'error',
                          hideAfter: 3500

                        });
                      }else{
                        window.location = '/login';
                      }
                    }
          });
                  // hacer algo aquí si el elemento existe
        }else{
            $.toast({
             heading: 'Alerta:',
             text: 'Ya existe un archivo con ese nombre.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'warning',
             hideAfter: 3500

           });
        }

      });


      $(".agregarARC8").click(function () {
         var nombre = $('input[name=arc_nombre_mod]').val();
         nombre = nombre.replace(/\s/g,"_");
         //console.log("WWWW",nombre);
         var formData = new FormData($("#formAdd")[0]);
         if(!$('#datosARC8').find("#ARC"+nombre).length){
            $.ajax({
                    url: "{{ url('/api/sistemaremi/apiUploadArchivoRespaldoMod') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data){
                          if(data.error == false){
                          var html = '<tr id="ARC'+ nombre +'" class="">'+
                                          '<td>'+
                                              '<input type="hidden" name="arc_id[]" value="" />'+
                                              '<input type="hidden" name="arc_nombre[]" value="'+ data.item.nombre +'" />'+
                                              '<input type="hidden" name="arc_archivo[]" value="'+ data.item.archivo +'" />'+
                                              '<input type="hidden" id="EST'+nombre+'"name="arc_estado[]" value="1" />'+
                                              '<a href="/respaldos/'+data.item.archivo+'" style="cursor: pointer;">'+
                                              '<p>'+
                                                '<img src="/img/icono_indicadores/xls1.png" title="Descargar Archivos respaldo "> '+
                                                 data.item.nombre +
                                              '</p>'+
                                              '</a>'+
                                          '</td>'+
                                          '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARC(\''+nombre+'\',\''+data.item.archivo+'\',1);"> <i class="fa fa-close text-danger" alt="Eliminar"></i> </a></td>'+
                                      '</tr>';
                            $("#datosARC8 > tbody").append(html);
                            $('input[name=arc_nombre_mod]').val('');
                            $('input[name=arc_archivo_mod]').val('');
                          }else{
                              $.toast({
                               heading: data.title,
                               text: data.msg,
                               position: 'top-right',
                               loaderBg:'#ff6849',
                               icon: 'warning',
                               hideAfter: 3500
                             });
                          }
                    },
                    error:function(data){
                      if(data.status != 401){
                        $.toast({
                          heading: 'Error:',
                          text: 'Error al recuperar los datos1.',
                          position: 'top-right',
                          loaderBg:'#ff6849',
                          icon: 'error',
                          hideAfter: 3500

                        });
                      }else{
                        window.location = '/login';
                      }
                    }
          });
                  // hacer algo aquí si el elemento existe
        }else{
            $.toast({
             heading: 'Alerta:',
             text: 'Ya existe un archivo con ese nombre.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'warning',
             hideAfter: 3500

           });
        }

      });


      $(".agregarARC").click(function () {
         var nombre = $('input[name=arc_nombre_input]').val();
         nombre = nombre.replace(/\s/g,"_");

         var formData = new FormData($("#formAdd")[0]);
         if(!$('#datosARC').find("#ARC"+nombre).length){
            $.ajax({
                    url: "{{ url('/api/sistemaremi/apiUploadArchivoRespaldo') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data){
                          if(data.error == false){
                          var html = '<tr id="ARC'+ nombre +'" class="">'+
                                          '<td>'+
                                              '<input type="hidden" name="arc_id[]" value="" />'+
                                              '<input type="hidden" name="arc_nombre[]" value="'+ data.item.nombre +'" />'+
                                              '<input type="hidden" name="arc_archivo[]" value="'+ data.item.archivo +'" />'+
                                              '<input type="hidden" id="EST'+nombre+'"name="arc_estado[]" value="1" />'+
                                              '<a href="/respaldos/'+data.item.archivo+'" style="cursor: pointer;">'+
                                              '<p>'+
                                                '<img src="/img/icono_indicadores/xls1.png" title="Descargar Archivos respaldo "> '+
                                                 data.item.nombre +
                                              '</p>'+
                                              '</a>'+
                                          '</td>'+
                                          '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARC(\''+nombre+'\',\''+data.item.archivo+'\',1);"> <i class="fa fa-close text-danger" alt="Eliminar"></i> </a></td>'+
                                      '</tr>';
                            $("#datosARC > tbody").append(html);
                            $('input[name=arc_nombre_input]').val('');
                            $('input[name=arc_archivo_input]').val('');
                          }else{
                              $.toast({
                               heading: data.title,
                               text: data.msg,
                               position: 'top-right',
                               loaderBg:'#ff6849',
                               icon: 'warning',
                               hideAfter: 3500
                             });
                          }
                    },
                    error:function(data){
                      if(data.status != 401){
                        $.toast({
                          heading: 'Error:',
                          text: 'Error al recuperar los datos1.',
                          position: 'top-right',
                          loaderBg:'#ff6849',
                          icon: 'error',
                          hideAfter: 3500

                        });
                      }else{
                        window.location = '/login';
                      }
                    }
          });
                  // hacer algo aquí si el elemento existe
        }else{
            $.toast({
             heading: 'Alerta:',
             text: 'Ya existe un archivo con ese nombre.',
             position: 'top-right',
             loaderBg:'#ff6849',
             icon: 'warning',
             hideAfter: 3500

           });
        }

      });



      $("#generarExport").click(function() {
          //cantidad de datos
          var selection = $("#dataTable").jqxDataTable('getSelection');
          var optionSel = $('input:radio[name=option_data]:checked').val();
          var orden = false;//agregar configuracion de la tabla
          var direccion = 'ASC';//agregar configuracion de la tabla
          var ids = "";
          switch(optionSel) {
              case "1":
                  $('#tabledataTable > tbody > tr').each(function() {
                     ids += $(this).attr("data-key")+",";

                  });
                   console.log(ids);
                  location.href = "{{ url('/api/sistemaremi/apiExportDataindicador') }}?ids=" + ids + "&orden=" + orden + "&dir=" + direccion;
                  break;
              case "2":
                  if(selection.length > 0){
                    if (selection && selection.length > 0) {
                        var rows = $("#dataTable").jqxDataTable('getRows');
                        for (var i = 0; i < selection.length; i++) {
                            var rowData = selection[i];
                            ids += rowData.id;
                            if (i < selection.length - 1) {
                              ids += ", ";
                            }
                        }
                      location.href = "{{ url('/api/sistemaremi/apiExportDataindicador') }}?ids=" + ids + "&orden=" + orden + "&dir=" + direccion;
                    }
                  }else{
                    $.toast({
                      heading: 'Error:',
                      text: 'Seleccione algún registro de la tabla.',
                      position: 'top-right',
                      loaderBg:'#ff6849',
                      icon: 'error',
                      hideAfter: 3500
                    });
                  }
              break;
              default:
                $.toast({
                  heading: 'Error:',
                  text: 'Configure su reporte.',
                  position: 'top-right',
                  loaderBg:'#ff6849',
                  icon: 'error',
                  hideAfter: 3500
                });
              break;
          }

      });



      var ip_id = -1000;

      $(".agregarAV").click(function () {

        if( $("input[name=avance_fecha_input]").val() != ""){

           var idAV = $('input[name=avance_fecha_input]').val().replace('/', '');
           var valor = ( $("input[name=avance_valor_input]").val() ? $("input[name=avance_valor_input]").val():0);
           if(!$('#set_avance').find("#AV"+idAV).length){

              fechaAV.push($('input[name=avance_fecha_input]').val());
              valorAV.push(valor);
              estadoAV.push(1);
              origenAV.push(1);
              actualizarListaAvance();

          }else{
              $.toast({
               heading: 'Alerta:',
               text: 'Ya existe valor en la fecha reportada.',
               position: 'top-right',
               loaderBg:'#ff6849',
               icon: 'warning',
               hideAfter: 3500
             });
            }
        }else{
          $.toast({
           heading: 'Error:',
           text: 'Llene los campos para agregar avance.',
           position: 'top-right',
           loaderBg:'#ff6849',
           icon: 'error',
           hideAfter: 3500
         });

        }
      });


      $(".agregarRS").click(function () {

        if( $("input[name=responsable_1]").val() != ""){

              responsable1A.push($('input[name=responsable_1]').val());
              responsable2A.push($('input[name=responsable_2]').val());
              responsable3A.push($('input[name=responsable_3]').val());
              referenciaA.push($('input[name=referencia]').val());

              actualizarListaResponsable();


        }else{
          $.toast({
           heading: 'Error:',
           text: 'Llene los campos para agregar responsable.',
           position: 'top-right',
           loaderBg:'#ff6849',
           icon: 'error',
           hideAfter: 3500
         });

        }
      });


    var url = '{{ url('api/sistemaremi/apiSetIndicadores') }}';
    // prepare the data
    var source =
    {
        dataType: "json",
        dataFields: [
            { name: 'id', type: 'int' },
            { name: 'codigo', type: 'string' },
            { name: 'nombre', type: 'string' },
            { name: 'tipo', type: 'string' },
            { name: 'logo', type: 'string' }
        ],
        id: 'id',
        url: url
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#dataTable").jqxDataTable(
    {
        source: dataAdapter,
          width:"100%",
          height:"400px",
        //width:"100%",
        theme:theme,
        columnsResize: true,
        filterable: true,
        filterMode: 'simple',
        //pageable: true,
        //pagerButtonsCount: 10,
        localization: getLocalization('es'),
        //pageSize: 5,
        columns: [
          { text: 'Logo', dataField: 'logo', width: 100,
                cellsRenderer: function (row, column, value, rowData) {
                    if(rowData.logo){
                        var image = "<div style='margin: 5px; margin-bottom: 3px;'>";
                        var imgurl = rowData.logo ;
                        var img = '<img width="60" height="60" style="display: block;" src="/img/icono_indicadores/' + imgurl + '"/>';
                        image += img;
                        image += "</div>";
                        return image;
                    }else{
                      return "";
                    }

                }
          },
          { text: 'Nombre del indicador', minWidth: 300,dataField: 'nombre' },
          { text: 'Codigo', dataField: 'codigo', width: 200,cellsAlign: 'center' },
          { text: 'Opciones', width: 120,
                cellsRenderer: function (row, column, value, rowData) {
                     // if({%%})
                        var abm = "<div style='margin: 5px; margin-bottom: 3px;'>";
                        var inputEdit = '<button onclick="btn_update('+rowData.id+')" class="btn btn-sm btn-info "><span>Editar</span> <i class="fa fa-pencil m-l-5"></i></button>';
                        var inputDelete = '<button onclick="btn_delete('+rowData.id+')" class="btn btn-sm btn-danger  m-t-10"><span>Eliminar &nbsp; &nbsp;</span> <i class="fa fa-trash-o m-l-5"></i></button>';
                        abm += inputEdit;
                        abm += inputDelete;
                        abm += "</div>";
                        return abm;

                }
          },
      ]
    });


      // create buttons, listbox and the columns chooser dropdownlist.
            $("#applyFilter").jqxButton();
            $("#clearfilter").jqxButton();
            $("#filterbox").jqxListBox({
              checkboxes: true,
              filterable: false,
              //searchMode: 'containsignorecase',
              width: "100%",
              height: 150
            });
            $("#columnchooser").jqxDropDownList({
                autoDropDownHeight: true, selectedIndex: 0, width: 160, height: 25,
                source: [
                  { label: 'Nombre', value: 'nombre' },
                  { label: 'Codigo', value: 'codigo' }

                ]
            });

         // updates the listbox with unique records depending on the selected column.
            var updateFilterBox = function (dataField) {

                $("#dataTable").jqxDataTable('clearFilters');
                var filterBoxAdapter = new $.jqx.dataAdapter(source,
                {
                    uniqueDataFields: [dataField],
                    autoBind: true,
                    async:false
                });
                var uniqueRecords = filterBoxAdapter.records;
                uniqueRecords.splice(0, 0, '(Todo)');
                $("#filterbox").jqxListBox({ source: uniqueRecords, displayMember: dataField });
                $("#filterbox").jqxListBox('checkAll');
            }
            updateFilterBox('nombre');
            // handle select all item.
            var handleCheckChange = true;
            $("#filterbox").on('checkChange', function (event) {
                if (!handleCheckChange)
                    return;

                if (event.args.label != '(Todo)') {
                    // update the state of the "Select All" listbox item.
                    handleCheckChange = false;
                    $("#filterbox").jqxListBox('checkIndex', 0);
                    var checkedItems = $("#filterbox").jqxListBox('getCheckedItems');
                    var items = $("#filterbox").jqxListBox('getItems');
                    if (checkedItems.length == 1) {
                        $("#filterbox").jqxListBox('uncheckIndex', 0);
                    }
                    else if (items.length != checkedItems.length) {
                        $("#filterbox").jqxListBox('indeterminateIndex', 0);
                    }
                    handleCheckChange = true;
                }
                else {
                    // check/uncheck all items if "Select All" is clicked.
                    handleCheckChange = false;
                    if (event.args.checked) {
                        $("#filterbox").jqxListBox('checkAll');
                    }
                    else {
                        $("#filterbox").jqxListBox('uncheckAll');
                    }
                    handleCheckChange = true;
                }
            });
            // handle columns selection.
            $("#columnchooser").on('select', function (event) {
                updateFilterBox(event.args.item.value);
            });
            // builds and applies the filter.
            var applyFilter = function (dataField) {
                $("#dataTable").jqxDataTable('clearFilters');
                var filtertype = 'stringfilter';
                if (dataField == 'date') filtertype = 'datefilter';
                if (dataField == 'price' || dataField == 'quantity') filtertype = 'numericfilter';
                // create a new group of filters.
                var filtergroup = new $.jqx.filter();
                // get listbox's checked items.
                var checkedItems = $("#filterbox").jqxListBox('getCheckedItems');
                if (checkedItems.length == 0) {
                    var filter_or_operator = 1;
                    var filtervalue = "Empty";
                    var filtercondition = 'equal';
                    var filter = filtergroup.createfilter(filtertype, filtervalue, filtercondition);
                    filtergroup.addfilter(filter_or_operator, filter);
                }
                else {
                    for (var i = 0; i < checkedItems.length; i++) {
                        var filter_or_operator = 1;
                        // set filter's value.
                        var filtervalue = checkedItems[i].label;
                        // set filter's condition.
                        var filtercondition = 'equal';
                        // create new filter.
                        var filter = filtergroup.createfilter(filtertype, filtervalue, filtercondition);
                        // add the filter to the filter group.
                        filtergroup.addfilter(filter_or_operator, filter);
                    }
                }
                // add the filters.
                $("#dataTable").jqxDataTable('addFilter', dataField, filtergroup);
                // apply the filters.
                $("#dataTable").jqxDataTable('applyFilters');
            }
            // clears the filter.
            $("#clearfilter").click(function () {
                $("#dataTable").jqxDataTable('clearFilters');
            });
            // applies the filter.
            $("#applyFilter").click(function () {
                var dataField = $("#columnchooser").jqxDropDownList('getSelectedItem').value;
                applyFilter(dataField);
            });



    $(".ctrl-btn").click(function () {
      var activo = $(this).attr('href');
      var next =  activo.substr(-1,1) ;
    //  if(next == 6){
        //$("#bt_siguiente").addClass('hidden');
        $("#bt_siguiente").removeClass('hidden');
        $("#bt_guardar").removeClass('hidden');
   /*   }else{
        $("#bt_siguiente").removeClass('hidden');
        $("#bt_guardar").addClass('hidden');
      }  */
    });


    $(".tap-btn").click(function () {
      var activo = $(".nav-item a.active").attr('href');

      var next =  activo.substr(-1,1) ;
      next++;
      $('input[name="tap_next"]').attr("value",next);
      if(next == 6){
        $("#bt_siguiente").addClass('hidden');
        $("#bt_guardar").removeClass('hidden');
      }
      $("#tab-ini"+next).removeClass('disabled');
      $("#tab-ini"+next ).trigger( "click" );

    });


    function createElements() {
         $('#window').jqxWindow({
             resizable: false,
             isModal: true,
             autoOpen: false,
             width: '40%',
             height: '35%',
             minWidth: 330,
             minHeight: '10%',
             //cancelButton: $("#Cancel"),
             modalOpacity: 0.01,
             draggable: true
         });
         $('#window').jqxWindow('focus');
     }
     createElements();




     $("#fuente_datos").change(function () {
         $("#datosFDN").html('');
         $.ajax({
               url: "{{ url('/api/sistemaremi/apiSetFuenteDatos') }}",
               data: { 'fuente': $(this).val()},
               type: "get",
               dataType: 'json',
               success: function(date){
                 $.each(date.item, function(i, data) {
                     var html= '<div class="row">'+
                                     '<div class="media row col-lg-12 ">'+
                                         '<div class="row col-lg-12">'+
                                              '<h5>&nbsp;&nbsp;&nbsp;&nbsp;Detalle de la fuente de datos seleccionado(s)</h5>'+
                                              '<hr/>'+
                                              '<div class="col-12" style="font-size:20px"><b>Nombre:</b> '+data.nombre+' ('+data.acronimo+')</div>'+
                                              '<div class="col-6"><b>Tipo:</b> '+data.tipo+'</div>'+
                                              '<div class="col-6"><b>Periodicidad:</b> '+data.periodicidad+'.</div>'+
                                              '<div class="col-6"><b>Serie de datos:</b> '+data.serie_datos+'.</div>'+
                                              '<div class="col-6"><b>Cobertura geográfica:</b>'+data.cobertura_geografica+'</div>'+
                                              '<div class="col-6"><b>Principales variables:</b> '+data.variable+'.</div>'+
                                              '<div class="col-6"><b>Nivel de representatividad de datos:</b> '+data.nivel_representatividad_datos+'</div>'+
                                              '<div class="col-12"><b>Observaciones:</b> '+data.observacion+'.</div>'+
                                        '</div>'+
                                    '</div>'+
                                 '</div>';
                     $("#datosFDN").append(html);
                 });

               },
               error:function(data){
                 if(data.status != 401){
                   console.log("no se recupero nada");
                 }else{
                   window.location = '/login';
                 }
               }
         });
     });


     $("#fuente_datos_d").change(function () {
         $("#datosFDD").html('');
         $.ajax({
               url: "{{ url('/api/sistemaremi/apiSetFuenteDatos') }}",
               data: { 'fuente': $(this).val()},
               type: "get",
               dataType: 'json',
               success: function(date){
                 $.each(date.item, function(i, data) {
                     var html= '<div class="row">'+
                                     '<div class="media row col-lg-12 ">'+
                                         '<div class="row col-lg-12">'+
                                              '<h5>&nbsp;&nbsp;&nbsp;&nbsp;Detalle de la fuente de datos seleccionado(s)</h5>'+
                                              '<hr/>'+
                                              '<div class="col-12" style="font-size:20px"><b>Nombre:</b> '+data.nombre+' ('+data.acronimo+')</div>'+
                                              '<div class="col-6"><b>Tipo:</b> '+data.tipo+'</div>'+
                                              '<div class="col-6"><b>Periodicidad:</b> '+data.periodicidad+'.</div>'+
                                              '<div class="col-6"><b>Serie de datos:</b> '+data.serie_datos+'.</div>'+
                                              '<div class="col-6"><b>Cobertura geográfica:</b>'+data.cobertura_geografica+'</div>'+
                                              '<div class="col-6"><b>Principales variables:</b> '+data.variable+'.</div>'+
                                              '<div class="col-6"><b>Nivel de representatividad de datos:</b> '+data.nivel_representatividad_datos+'</div>'+
                                              '<div class="col-12"><b>Observaciones:</b> '+data.observacion+'.</div>'+
                                        '</div>'+
                                    '</div>'+
                                 '</div>';
                     $("#datosFDD").append(html);
                 });

               },
               error:function(data){
                 if(data.status != 401){
                   console.log("no se recupero nada");
                 }else{
                   window.location = '/login';
                 }
               }
         });
     });


    });
    //fin document
    function actualizarListaAvance(){
      var cav= 1;
      $("#set_avance > tbody").html("");
      $.ajax({
            url: "{{ url('/api/sistemaremi/apiSourceOrderbyArray') }}",
            type: "GET",
            dataType: 'json',
            data:{'fechas':fechaAV,'valores':valorAV,'estados':estadoAV},
            success: function(date){
                  if(date.error == false){
                      $.each(date.item, function(i, data) {
                        if(estadoAV[data.index]==1){
                            var html = '<tr id="AV'+ data.valor.replace('/', '') +'">'+
                                           '<td>'+
                                               '<input type="hidden" name="id_avance[]" value="'+ (idAV[data.index] ? idAV[data.index] : "") +'" /><input type="hidden" id="AVEST'+data.valor.replace('/', '')+'" name="avance_estado[]" value="1" />'+cav+
                                            '</td>'+
                                           '<td>'+
                                              '<input type="hidden" name="avance_fecha[]" value="'+ data.valor +'" />'+
                                               data.valor+
                                            '</td>'+
                                            '<td>'+
                                              '<input type="hidden" name="avance_valor[]" value="'+ valorAV[data.index]+'" />'+
                                               valorAV[data.index]+
                                            '</td>'+
                                            '<td>'+
                                              "ddfdsf dfsdf dfs sdfs fasff afdfsdfafsdfsfddsffsdfsdfafd sdfsdfasdfasdf asdf"+
                                            '</td>'+
                                            '<td>'+'<center>'+
                                              '<a data-toggle="tooltip" data-original-title="Borrar" onclick="quitarAV(\''+ data.valor.replace('/', '')+'\','+origenAV[data.index]+','+data.index+');" style="cursor: pointer;"> <i class="fa fa-close text-danger"></i> </a>'+
                                            '</center>'+'</td>'+
                                      '</tr>';
                            $("#set_avance > tbody").append(html);
                            cav++;
                          }else{
                            var html = '<tr id="0AV'+ data.valor.replace('/', '') +'" class="hidden">'+
                                            '<td>'+
                                               '<input type="hidden" name="id_avance[]" value="'+ (idAV[data.index] ? idAV[data.index] : "") +'" /><input type="hidden" id="AVEST'+data.valor.replace('/', '')+'" name="avance_estado[]" value="0" />'+cav+
                                            '</td>'+
                                             '<td>'+
                                              '<input type="hidden" name="avance_fecha[]" value="'+ data.valor +'" />'+
                                               data.valor+
                                            '</td>'+
                                             '<td>'+
                                              '<input type="hidden" name="avance_valor[]" value="'+ valorAV[data.index]+'" />'+
                                               valorAV[data.index]+
                                            '</td>'+
                                             '<td>'+
                                              'ddfdsf dfsdf dfs sdfs fasff afdfsdfafsdfsfddsffsdfsdfafd sdfsdfasdfasdf asdf'+
                                            '</td>'+
                                             '<td>'+'<center>'+
                                              '<a data-toggle="tooltip" data-original-title="Borrar" onclick="quitarAV(\''+ data.valor.replace('/', '')+'\','+origenAV[data.index]+','+data.index+');"> <i class="fa fa-close text-danger"></i> </a>'+
                                            '</center>'+'</td>'+
                                      '</tr>';
                            $("#set_avance > tbody").append(html);
                          }

                     });

               }
            },
            error:function(data){
              alert("Error recuperar los datos.");
            }
      });



    }

    function actualizarListaResponsable(){
      var cav= 1;
      $("#set_responsables > tbody").html("");

      $.ajax({
            url: "{{ url('/api/sistemaremi/apiSourceOrderbyArray2') }}",
            type: "GET",
            dataType: 'json',
            data:{'responsable1':responsable1A,'responsable2':responsable2A,'responsable3':responsable3A,'referencia':referenciaA},
            success: function(date){
                  if(date.error == false){
                      $.each(date.item, function(i, data) {
                            var html = '<tr id="RS'+cav+'">'+
                                            '<td style="width: 5%;">'+
                                               cav+
                                            '</td>'+
                                            '<td style="width: 90%;">'+
                                                 '<input type="hidden" name="responsable_nivel_1[]" value="'+ responsable1A[data.index] +'" />'+
                                                 '<input type="hidden" name="responsable_nivel_2[]" value="'+ responsable2A[data.index] +'" />'+
                                                 '<input type="hidden" name="responsable_nivel_3[]" value="'+ responsable3A[data.index] +'" />'+
                                                 '<input type="hidden" name="numero_referencia[]" value="'+ referenciaA[data.index] +'" />'+
                                                 '<b>Entidad Cabeza:</b> '+responsable1A[data.index]+'<br/>'+
                                                 '<b>Sub entidad:</b> '+ responsable2A[data.index]+'<br/>'+
                                                 '<b>Sub entidad:</b> '+ responsable3A[data.index] +'<br/>'+
                                                 '<b>Número referencia:</b> '+ referenciaA[data.index]+
                                            '</td>'+
                                            '<td style="width: 5%;">'+
                                              '<a data-toggle="tooltip" data-original-title="Borrar" onclick="quitarRS('+cav+','+data.index+');" style="cursor: pointer;"> <i class="fa fa-close text-danger"></i> </a>'+
                                            '</td>'+
                                      '</tr>';
                            $("#set_responsables > tbody").append(html);
                            cav++;
                     });
                    $("#cont_resp").html(cav-1);
               }else{
                 $("#cont_resp").html(0);
               }
            },
            error:function(data){
              alert("Error recuperar los datos.");
            }
      });



    }
    function quitarART(ele,tipo){
        if(tipo == 1){
          $('#ART'+ele).remove();
        }else{
          $('#ART'+ele).addClass('hidden');
          $('#EST'+ele).val(0);
          $('#ART'+ele).attr("id",'0ART'+ele);
        }

    }

    function quitarAV(ele,tipo,index){

        if(tipo == 1){
          $('#AV'+ele).remove();
          fechaAV.splice(index, 1);
          valorAV.splice(index, 1);
          estadoAV.splice(index, 1);
          origenAV.splice(index, 1);
        }else{
          estadoAV[index] = 0;
        }

        actualizarListaAvance();
    }
    function quitarRS(ele,index){


          $('#RS'+ele).remove();
          responsable1A.splice(index, 1);
          responsable2A.splice(index, 1);
          responsable3A.splice(index, 1);
          referenciaA.splice(index, 1);

        actualizarListaResponsable();
    }

    function quitarARC(ele,archivo,tipo){
      var res = confirm("Esta seguro de quitar el archivo?");
          if (res == true) {
            if(tipo == 1){
                 $.ajax({
                       type: "GET",
                       dataType: 'json',
                       url: "{{ url('/api/sistemaremi/apiDeleteArchivo') }}",
                       data: {archivo: archivo},
                       success: function(data){
                           $('#ARC'+ele).remove();
                       },
                       error:function(data){
                         if(data.status != 401){
                           alert("Error recuperar al eliminar.");
                         }else{
                           window.location = '/login';
                         }
                       }
                   });
            }else{
              $('#ARC'+ele).addClass('hidden');
              $('#EST'+ele).val(0);
              $('#ARC'+ele).attr("id",'0ARC'+ele);
            }
        }

    }


    function editarI(ele){
       alert(ele);
    }

    function deleteI(ele){
       alert(ele);
    }

    $('#btn-back, .btn-back').click(function() {
       $("#unaCaja").html("");
       $("#dosCaja").html("");
       $('#option1').removeClass('hidden');
       //$('#nivel_1').addClass('show');
       $('#option2').removeClass('show');
       $('#option2').addClass('hidden');

       $("#formAdd")[0].reset();
       $("#formAddFuente")[0].reset();
       $('.with-errors').html('');
       $('.form-group').removeClass('has-error');
       //$("#variables_desagregacion").val('').trigger('change');
       $("#datosART").html("");
       $("#datosART1").html("");
       $("#fuente_datos").val('').trigger('change');
       $("#fuente_datos_d").val('').trigger('change');
       $("#fd_cobertura_geografica").val('').trigger('change');
       //$("#fd_variable").val('').trigger('change');
       $("#medida_2016").html("");
       $("#medida_2017").html("");
       $("#medida_2018").html("");
       $("#medida_2019").html("");
       $("#cont_resp").html(0);
       $("#datosFDN").html("");
       $("#datosFDD").html("");
       fechaAV = [];
       valorAV = [];
       estadoAV = [];
       origenAV = [];
       responsable1A = [];
       responsable2A = [];
       responsable3A = [];
       referenciaA = [];
       idAV = [];
       $("#set_avance > tbody").html("");
       $("#datosARC > tbody").html("");
       $("#datosARCS > tbody").html("");
       $("#datosARCED > tbody").html("");
       $("#set_responsables > tbody").html("");
       $('input[name="id_indicador"]').val(null);
       $("#tab-ini1" ).trigger( "click" );
    });
    $('#btn-new, .btn-new ').click(function() {
       $('#option2').removeClass('hidden');
       $('#option1').removeClass('show');
       $('#option1').addClass('hidden');
       $('#tab-ini2').addClass('disabled'); // desactiva boton de formulario
       $('#tab-ini3').addClass('disabled');
       $('#tab-ini4').addClass('disabled');
       $('#tab-ini5').addClass('disabled');
       $('#tab-ini6').addClass('disabled');

    });

    function agregarSexo() {


    }

    function btn_update(ele) {
      $("#btn-new" ).trigger( "click" );
       $.ajax({
             url: "{{ url('/api/sistemaremi/apiDataSetIndicador') }}",
             type: "GET",
             dataType: 'json',
             data:{'id':ele},
             success: function(data){
               if(data.error == false){
                    for(var i=1;i<data.indicador[0].form_activo+1;i++){
                        $('#tab-ini'+i).removeClass('disabled');
                    }

                   //$("#mod_cod_m").val(data.meta).trigger('change');  medida_2016
                    var html= '<div class="form-group">&nbsp;'+data.indicador[0].etapa+'</div>';
                    $("#unaCaja").append(html);

                    var html= '<div class="form-group">&nbsp;'+data.indicador[0].nombre+'</div>';
                    $("#dosCaja").append(html);

                    var html= '<div>'+data.indicador[0].unidad_medida+'</div>';
                     $("#medida_2016").append(html);

                    var html= '<div>'+data.indicador[0].unidad_medida+'</div>';
                      $("#medida_2017").append(html);

                    var html= '<div>'+data.indicador[0].unidad_medida+'</div>';
                      $("#medida_2018").append(html);

                    var html= '<div>'+data.indicador[0].unidad_medida+'</div>';
                      $("#medida_2019").append(html);

                   $('input[name="id_indicador"]').val(data.indicador[0].id);
                   $('input[name="nombrev"]').val(data.indicador[0].nombre);
                   $('input[name="nombre"]').val(data.indicador[0].nombre);
                   $('textarea[name="definicion"]').val(data.indicador[0].definicion);
                   $('select[name=etapa]').val(data.indicador[0].etapa);
                   $('select[name=tipo]').val(data.indicador[0].tipo);
                   $('select[name=unidad_medida]').val(data.indicador[0].unidad_medida);
                   $('select[name=frecuencia]').val(data.indicador[0].frecuencia);
                   /*if(data.indicador[0].variables_desagregacion){
                     $("#variables_desagregacion").val(data.indicador[0].variables_desagregacion.split(",")).trigger('change');
                   }*/
                   $('textarea[name="variables_desagregacion"]').val(data.indicador[0].variables_desagregacion);

                   if(data.indicador[0].linea_base_mes){
                     $('input[name="linea_base_fecha"]').val(data.indicador[0].linea_base_mes+'/'+data.indicador[0].linea_base_anio);
                   }
                   $('input[name="linea_base_valor"]').val(data.indicador[0].linea_base_valor);
                   $('textarea[name="formula"]').val(data.indicador[0].formula);
                   $('textarea[name="numerador_detalle"]').val(data.indicador[0].numerador_detalle);
                   $('input[name="numerador_fuente"]').val(data.indicador[0].numerador_fuente);
                   $('textarea[name="denominador_detalle"]').val(data.indicador[0].denominador_detalle);
                   $('input[name="denominador_fuente"]').val(data.indicador[0].denominador_fuente);
                   $('input[name="serie_disponible"]').val(data.indicador[0].serie_disponible);
                   $('textarea[name="observacion"]').val(data.indicador[0].observacion);

                   if(data.indicador[0].fuente_datos){
                     $("#fuente_datos").val(data.indicador[0].fuente_datos.split(",")).trigger('change');
                   }

                   if(data.indicador[0].fuente_datos_d){
                     $("#fuente_datos_d").val(data.indicador[0].fuente_datos_d.split(",")).trigger('change');
                   }

                  $.each(data.pdes, function(i, data) {
                   var html = '<h5>Detalle de Articulación</h5>'+'<hr/>'+
                               '<div id="ART'+data.cod_p+data.cod_m+data.cod_r+'" class="row">'+
                                 '<div class="media row col-lg-12 ">'+
                                     '<div class="col-lg-2 text-center">'+
                                         '<img src="/img/'+data.logo+'" alt="Pliar" width="100">'+
                                         '<a class="btn btn-block btn-info btn-sm m-t-10" onclick="quitarART('+data.cod_p+data.cod_m+data.cod_r+',2);">Quitar</a>'+
                                     '</div>'+
                                     '<div class="row col-lg-10">'+
                                         '<input type="hidden" name="id_resultado_articulado[]" value="'+data.id+'" />'+
                                         '<input type="hidden" name="resultado_articulado[]" value="'+data.id_resultado+'" />'+
                                         '<input type="hidden" id="EST'+data.cod_p+data.cod_m+data.cod_r+'" name="estado_resultado_articulado[]" value="1" />'+
                                         '<div class="col-12"><b>'+data.pilar+':</b> '+data.desc_p+
                                         '</div>'+
                                         '<div class="col-12"><b>'+data.meta+':</b> '+data.desc_m+
                                         '</div>'+
                                         '<div class="col-12"><b>'+data.resultado+':</b> '+data.desc_r+
                                         '</div>'+
                                     '</div>'+
                                 '</div>'+
                               '</div>';
                   $("#datosART").append(html);
                  });
                  $.each(data.metas, function(i, data) {
                     $('input[name="id_meta_'+data.gestion+'"]').val(data.id);
                     $('input[name="meta_'+data.gestion+'"]').val(data.valor);
                  });


                  $.each(data.avances, function(i, data) {
                      fechaAV.push(data.fecha_generado_mes+'/'+data.fecha_generado_anio);
                      valorAV.push(data.valor);
                      estadoAV.push(1);
                      origenAV.push(2);
                      idAV.push(data.id);
                  });
                  actualizarListaAvance();


                  $.each(data.archivos, function(i, data) {
                      var nombre = data.nombre.replace(/\s/g,"_");
                      var html = '<tr id="ARC'+ nombre +'" class="">'+
                                      '<td>'+
                                          '<input type="hidden" name="arc_id[]" value="'+data.id+'" />'+
                                          '<input type="hidden" name="arc_nombre[]" value="'+ data.nombre +'" />'+
                                          '<input type="hidden" name="arc_archivo[]" value="'+ data.archivo +'" />'+
                                          '<input type="hidden" id="EST'+nombre+'"name="arc_estado[]" value="1" />'+
                                          '<a href="/respaldos/'+data.archivo+'" style="cursor: pointer;">'+
                                          '<p>'+
                                            '<img src="/img/icono_indicadores/xls.png" title="Descargar Archivos respaldo "> '+
                                             data.nombre +
                                          '</p>'+
                                          '</a>'+
                                      '</td>'+
                                      '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARC(\''+nombre+'\',\''+data.archivo+'\',2);"> <i class="fa fa-close text-danger"></i> </a></td>'+
                                  '</tr>';
                       $("#datosARC > tbody").append(html);
                  });

                  $.each(data.archivos, function(i, data) {
                      var nombre = data.nombre.replace(/\s/g,"_");
                      var html2 = '<tr id="ARC'+ nombre +'" class="">'+
                                      '<td>'+
                                          '<input type="hidden" name="arc_id[]" value="'+data.id+'" />'+
                                          '<input type="hidden" name="arc_nombre[]" value="'+ data.nombre +'" />'+
                                          '<input type="hidden" name="arc_archivo[]" value="'+ data.archivo +'" />'+
                                          '<input type="hidden" id="EST'+nombre+'"name="arc_estado[]" value="1" />'+
                                          '<a href="/respaldos/'+data.archivo+'" style="cursor: pointer;">'+
                                          '<p>'+
                                            '<img src="/img/icono_indicadores/xls1.png" title="Descargar Archivos respaldo "> '+
                                             data.nombre +
                                          '</p>'+
                                          '</a>'+
                                      '</td>'+
                                      '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARC(\''+nombre+'\',\''+data.archivo+'\',2);"> <i class="fa fa-close text-danger"></i> </a></td>'+
                                  '</tr>';
                       $("#datosARCS > tbody").append(html2);
                  });

                  $.each(data.archivos, function(i, data) {
                      var nombre = data.nombre.replace(/\s/g,"_");
                      var html3 = '<tr id="ARC'+ nombre +'" class="">'+
                                      '<td>'+
                                          '<input type="hidden" name="arc_id[]" value="'+data.id+'" />'+
                                          '<input type="hidden" name="arc_nombre[]" value="'+ data.nombre +'" />'+
                                          '<input type="hidden" name="arc_archivo[]" value="'+ data.archivo +'" />'+
                                          '<input type="hidden" id="EST'+nombre+'"name="arc_estado[]" value="1" />'+
                                          '<a href="/respaldos/'+data.archivo+'" style="cursor: pointer;">'+
                                          '<p>'+
                                            '<img src="/img/icono_indicadores/xls1.png" title="Descargar Archivos respaldo "> '+
                                             data.nombre +
                                          '</p>'+
                                          '</a>'+
                                      '</td>'+
                                      '<td><a data-toggle="tooltip" data-original-title="Borrar" style="cursor: pointer;" onclick="quitarARC(\''+nombre+'\',\''+data.archivo+'\',2);"> <i class="fa fa-close text-danger"></i> </a></td>'+
                                  '</tr>';
                       $("#datosARCED > tbody").append(html3);
                  });

               }else{
                   $.toast({
                    heading: data.title,
                    text: data.msg,
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'warning',
                    hideAfter: 3500
                  });
               }
             },
             error:function(data){
               if(data.status != 401){
                 $.toast({
                   heading: 'Error:',
                   text: 'Error al recuperar los datos.',
                   position: 'top-right',
                   loaderBg:'#ff6849',
                   icon: 'error',
                   hideAfter: 3500
                 });
               }else{
                 window.location = '/login';
               }
             }
       });

    }

    function btn_delete(ele) {
        swal({
          title: "Está seguro?",
          text: "No podrá recuperar este registro!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Si, eliminar!",
          closeOnConfirm: false
        }, function(){
             $.ajax({
                   url: "{{ url('/api/sistemaremi/apiDeleteIndicador') }}",
                   data: { '_token': $('input[name=_token]').val(),'id_indicador': ele },
                   type: "delete",
                   dataType: 'json',
                   success: function(date){
                       $("#dataTable").jqxDataTable("updateBoundData");
                       swal("Eliminado!", "Se ha eliminado tu registro.", "success");
                   },
                   error:function(data){
                     if(data.status != 401){
                       alert("Error recuperar los datos.");
                     }else{
                       window.location = '/login';
                     }

                   }
             });
        });
    }


    function save(){
      swal({
        title: "Guardar?",
        text: "Se completo el llenado de los datos solicitados!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Guardar!",
        closeOnConfirm: false
      },function(){
            $.ajax({
                  type: "POST",
                  url: "{{ url('/api/sistemaremi/apiSaveIndicador') }}",
                  dataType: 'json',
                  data: $("#formAdd").serialize() , // Adjuntar los campos del formulario enviado.
                  success: function(data){
                    if(data.error == false){
                        $('input[name="id_indicador"]').attr("value",data.idindicador);
                        var tap_next=0;
                        // $("#btn-back" ).trigger( "click" );
                        // $("#dataTable").jqxDataTable("updateBoundData");
                        swal("Guardado!", "Se ha guardado correctamente.", "success");
                    }else{
                        $.toast({
                         heading: data.title,
                         text: data.msg,
                         position: 'top-right',
                         loaderBg:'#ff6849',
                         icon: 'warning',
                         hideAfter: 3500
                       });
                    }
                  },
                  error:function(data){
                    if(data.status != 401){
                      $.toast({
                        heading: 'Error:',
                        text: 'Error al recuperar los datos.',
                        position: 'top-right',
                        loaderBg:'#ff6849',
                        icon: 'error',
                        hideAfter: 3500

                      });
                    }else{
                      window.location = '/login';
                    }

                  }
            });
      });
    }

    function saveFuente(){

      var r = confirm("Guardar la fuente de datos?");
      if (r == true) {
        $.ajax({
              type: "POST",
              url: "{{ url('/api/sistemaremi/apiSaveFuente') }}",
              dataType: 'json',
              data: $("#formAddFuente").serialize() , // Adjuntar los campos del formulario enviado.
              success: function(data){
                if(data.error == false){
                    updateComboFuente();
                }else{
                    $.toast({
                     heading: data.title,
                     text: data.msg,
                     position: 'top-right',
                     loaderBg:'#ff6849',
                     icon: 'warning',
                     hideAfter: 3500
                   });
                }
              },
              error:function(data){
                if(data.status != 401){
                  $.toast({
                    heading: 'Error:',
                    text: 'Error al recuperar los datos.',
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'error',
                    hideAfter: 3500

                  });
                }else{
                  window.location = '/login';
                }

              }
        });
      } else {
          txt = "You pressed Cancel!";
      }

    }

    //Evento del boton nuevo
    function win_fuente(){
      $('#divcon').animate({scrollTop : 0}, 500);
      var offset = $("#side-menu").offset();
      $("#window").jqxWindow({ position: { x: parseInt(offset.left) + 30  , y: parseInt(offset.top) + (180) } });
          $("#window").css('visibility', 'visible');
          $('#window').jqxWindow('open');
          $('#window').jqxWindow('focus');
          $("#formAddFuente")[0].reset();
          $("#fd_cobertura_geografica").val('').trigger('change');
          //$("#fd_variable").val('').trigger('change');
          $("#set_responsables > tbody").html("");
          $("#cont_resp").html(0);
    }
    $(document).keydown(function(tecla){
          if (tecla.keyCode == 119) {
            var offset = $("#side-menu").offset();
            $("#window").jqxWindow({ position: { x: parseInt(offset.left) + 30  , y: parseInt(offset.top) + (180) } });
                $("#window").css('visibility', 'visible');
                $('#window').jqxWindow('open');
                $('#window').jqxWindow('focus');
                $("#formAddFuente")[0].reset();
                $("#fd_cobertura_geografica").val('').trigger('change');
                //$("#fd_variable").val('').trigger('change');
                $("#set_responsables > tbody").html("");
                $("#cont_resp").html(0);
          }
    });

    function updateComboFuente(){
        var combo = $("#fuente_datos").val();
        var arraySel = JSON.parse("[" + combo + "]");
        $("#fuente_datos").empty();
        $.ajax({
              type: "get",
              url: "{{ url('/api/sistemaremi/apiUpdateComboFuente') }}",
              dataType: 'json',
              success: function(data){
                  $.each(data.item, function(i, data) {
                      if($.inArray(data.id, arraySel) == -1){
                        $("#fuente_datos").append('<option value="'+data.id+'">'+data.nombre+'</option>');
                      }else{
                        $("#fuente_datos").append('<option value="'+data.id+'" selected>'+data.nombre+'</option>');
                      }
                  });
                  $('#window').jqxWindow('close');
                  $("#formAddFuente")[0].reset();
                  $("#fd_cobertura_geografica").val('').trigger('change');
                  //$("#fd_variable").val('').trigger('change');
                  $("#set_responsables > tbody").html("");
              },
              error:function(data){
                if(data.status != 401){
                  $.toast({
                    heading: 'Error:',
                    text: 'Error al recuperar los datos.',
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'error',
                    hideAfter: 3500
                  });
                }else{
                  window.location = '/login';
                }

              }
        });
    }

     // create buttons, listbox and the columns chooser dropdownlist.
            $("#applyFilter").jqxButton();
            $("#clearfilter").jqxButton();
            $("#filterbox").jqxListBox({
              checkboxes: true,
              filterable: false,
              //searchMode: 'containsignorecase',
              width: "100%",
              height: 150
            });
            $("#columnchooser").jqxDropDownList({
                autoDropDownHeight: true, selectedIndex: 0, width: 160, height: 25,
                source: [
                  { label: 'Responsable', value: 'responsable' },
                  { label: 'Estado', value: 'estado' },
                  { label: 'Nombre', value: 'nombre' },
                  { label: 'Tipo', value: 'tipo' }

                ]
            });
            // updates the listbox with unique records depending on the selected column.
            var updateFilterBox = function (dataField) {

                $("#dataTable").jqxDataTable('clearFilters');
                var filterBoxAdapter = new $.jqx.dataAdapter(source,
                {
                    uniqueDataFields: [dataField],
                    autoBind: true,
                    async:false
                });
                var uniqueRecords = filterBoxAdapter.records;
                uniqueRecords.splice(0, 0, '(Todo)');
                $("#filterbox").jqxListBox({ source: uniqueRecords, displayMember: dataField });
                $("#filterbox").jqxListBox('checkAll');
            }
            updateFilterBox('responsable');
            // handle select all item.
            var handleCheckChange = true;
            $("#filterbox").on('checkChange', function (event) {
                if (!handleCheckChange)
                    return;

                if (event.args.label != '(Todo)') {
                    // update the state of the "Select All" listbox item.
                    handleCheckChange = false;
                    $("#filterbox").jqxListBox('checkIndex', 0);
                    var checkedItems = $("#filterbox").jqxListBox('getCheckedItems');
                    var items = $("#filterbox").jqxListBox('getItems');
                    if (checkedItems.length == 1) {
                        $("#filterbox").jqxListBox('uncheckIndex', 0);
                    }
                    else if (items.length != checkedItems.length) {
                        $("#filterbox").jqxListBox('indeterminateIndex', 0);
                    }
                    handleCheckChange = true;
                }
                else {
                    // check/uncheck all items if "Select All" is clicked.
                    handleCheckChange = false;
                    if (event.args.checked) {
                        $("#filterbox").jqxListBox('checkAll');
                    }
                    else {
                        $("#filterbox").jqxListBox('uncheckAll');
                    }
                    handleCheckChange = true;
                }
            });
            // handle columns selection.
            $("#columnchooser").on('select', function (event) {
                updateFilterBox(event.args.item.value);
            });
            // builds and applies the filter.
            var applyFilter = function (dataField) {
                $("#dataTable").jqxDataTable('clearFilters');
                var filtertype = 'stringfilter';
                if (dataField == 'date') filtertype = 'datefilter';
                if (dataField == 'price' || dataField == 'quantity') filtertype = 'numericfilter';
                // create a new group of filters.
                var filtergroup = new $.jqx.filter();
                // get listbox's checked items.
                var checkedItems = $("#filterbox").jqxListBox('getCheckedItems');
                if (checkedItems.length == 0) {
                    var filter_or_operator = 1;
                    var filtervalue = "Empty";
                    var filtercondition = 'equal';
                    var filter = filtergroup.createfilter(filtertype, filtervalue, filtercondition);
                    filtergroup.addfilter(filter_or_operator, filter);
                }
                else {
                    for (var i = 0; i < checkedItems.length; i++) {
                        var filter_or_operator = 1;
                        // set filter's value.
                        var filtervalue = checkedItems[i].label;
                        // set filter's condition.
                        var filtercondition = 'equal';
                        // create new filter.
                        var filter = filtergroup.createfilter(filtertype, filtervalue, filtercondition);
                        // add the filter to the filter group.
                        filtergroup.addfilter(filter_or_operator, filter);
                    }
                }
                // add the filters.
                $("#dataTable").jqxDataTable('addFilter', dataField, filtergroup);
                // apply the filters.
                $("#dataTable").jqxDataTable('applyFilters');
            }
            // clears the filter.
            $("#clearfilter").click(function () {
                $("#dataTable").jqxDataTable('clearFilters');
            });
            // applies the filter.
            $("#applyFilter").click(function () {
                var dataField = $("#columnchooser").jqxDropDownList('getSelectedItem').value;
                applyFilter(dataField);
            });

    function showFilterAdvanced() {

      if ($('#FilterAdvanced').hasClass('hidden')){
            $('#exportarData').removeClass('hidden')
            $('#exportarData').addClass('hidden')
            $("#dataTable").jqxDataTable({filterable: false});
            $('#FilterAdvanced').removeClass('hidden')
            $('#jqxDataTable').removeClass('col-lg-12');
            $('#jqxDataTable').fadeIn(500).addClass('col-lg-9');
      }else{
        $("#dataTable").jqxDataTable({filterable: true});
          $('#FilterAdvanced').addClass('hidden')
          $('#jqxDataTable').removeClass('col-lg-9');
          $('#jqxDataTable').fadeIn(500).addClass('col-lg-12');
        }
    }
    function showExportarData() {

      if ($('#exportarData').hasClass('hidden')){
            $("#dataTable").jqxDataTable({filterable: true});
            $('#FilterAdvanced').removeClass('hidden')
            $('#FilterAdvanced').addClass('hidden')

            $('#exportarData').removeClass('hidden')
            $('#jqxDataTable').removeClass('col-lg-12');
            $('#jqxDataTable').fadeIn(1000).addClass('col-lg-9');

      }else{

          $('#exportarData').addClass('hidden')
          $('#jqxDataTable').removeClass('col-lg-9');
          $('#jqxDataTable').fadeIn(1000).addClass('col-lg-12');
        }
    }



  </script>
@endpush
