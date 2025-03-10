<?php

namespace App\Http\Controllers\PlanificacionTerritorial;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Plataforma\Instituciones;
use App\Models\Plataforma\Regiones;
use App\Models\PlanificacionTerritorial\EtapasEstado;
use App\Models\PlanificacionTerritorial\FinancieroPoa;
use App\Models\PlanificacionTerritorial\Parametros;
use App\Models\PlanificacionTerritorial\SeguimientoGestiones;
use App\Models\PlanificacionTerritorial\GestionRiesgos;
use App\Models\PlanificacionTerritorial\GestionSeleccionada;





class FinancieroController extends BasecontrollerController
{
  public function listaAvanceObjetivos(){
    $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();

    /*********Verificar Gestion Activa**************/
    /*$gestionActiva = SeguimientoGestiones::where('id_periodo_plan', $planActivo->id)
                                          ->where('activo',true)
                                          ->first(); */




    $user = \Auth::user();

    $gestionActiva =  GestionSeleccionada::where('id_institucion', $user->id_institucion)
                                          ->where('activo',true)
                                           ->first();

    $estadoModulo = \DB::select("select estado_etapa from sp_eta_estado_etapas_seguimiento
                                                    where id_institucion =  $user->id_institucion
                                                    and valor_campo_etapa = 'sFisicaFinanciera'
                                                    and gestion = $gestionActiva->gestion");
    //dd($estadoModulo);
    if($estadoModulo[0]->estado_etapa == "En Elaboración"){
      $estado_etapa = true;
    }else{
      $estado_etapa = false;
    }


    $objetivo_indicador = \DB::select("select 
                                              catEta.nombre_accion_eta,
                                              objetivos.id_accion_eta as agregador,

                                              objetivos.id as id_accion_eta_objetivo,
                                              objetivos.nombre_objetivo  as descripcion,
                                              
                                              concat(arti.linea_base_cantidad,' ',arti.linea_base_unidad,' ',arti.linea_base_descripcion) as linea_base,
                                              indi.nombre_indicador,
                                              p_indi.valor,
                                              p_recu.monto
                                      from sp_eta_etapas_plan as plan,
                                        sp_eta_objetivos_eta as objetivos,
                                        sp_eta_articulacion_objetivo_indicador as arti,
                                        sp_eta_indicadores as indi,
                                        sp_eta_programacion_indicador as p_indi,
                                        
                                        sp_eta_programacion_recursos as p_recu,
                                        
                                        sp_eta_catalogo_acciones_eta as catEta,

                                        sp_eta_articulacion_catalogos as artPmra
                                      where plan.id_institucion = $user->id_institucion
                                        and objetivos.id_etapas_plan = plan.id
                                        and objetivos.id = arti.id_objetivo_eta
                                        and objetivos.id_accion_eta = catEta.id
                                        and objetivos.id_accion_eta = artPmra.id_accion_eta
                                        and arti.id_indicador = indi.id
                                        and arti.id = p_indi.id_articulacion_objetivo_indicador
                                        and arti.id = p_recu.id_articulacion_objetivo_indicador
                                        and p_indi.gestion = '$gestionActiva->gestion'
                                        and p_recu.gestion = '$gestionActiva->gestion'");
    //dd($objetivo_indicador);
    


    foreach ($objetivo_indicador as $riesgo) {
      $is_checked = \DB::select("select id,
                                        id_accion_eta,
                                        activo
                                    from sp_eta_gestion_riesgos
                                      where id_institucion = $user->id_institucion
                                      and gestion = $gestionActiva->gestion
                                      and id_accion_eta = $riesgo->id_accion_eta_objetivo
                                      ");
                                      //dd($is_checked);
      if($is_checked){
        $riesgo->id_gestion_riesgos = $is_checked[0]->id;//enviando id en la tabla gestion_riesgos
        $riesgo->es_gestion_riesgos = $is_checked[0]->activo;//enviando true or false
        $riesgo->gestion_riesgos = $is_checked[0]->activo;//enviando true or false
      }
    }
    //buscando si lo planificado ha sido comparado con el POA
    foreach ($objetivo_indicador as $r) {
      $id_accion_eta = $r->id_accion_eta_objetivo;
      
      $verificar = FinancieroPoa::where('id_accion_eta',$id_accion_eta)
                                  ->where('gestion',$gestionActiva->gestion)
                                  ->where('activo',true)
                                  ->where('id_intitucion',$user->id_institucion)
                                  ->get();
     
                                  
      if($verificar->count()>0){

        foreach ($verificar as $v) {
          $r->id_financiero_poa = $v->id;
          $r->monto_poa_planificado = $v->monto_poa_planificado ;
          $r->monto_poa_ejecutado = $v->monto_poa_ejecutado ;
          $r->monto_poa_porcentaje = $v->monto_poa_porcentaje ;
          $r->accion_poa_programado = $v->accion_poa_programado ;
          $r->accion_poa_ejecutado = $v->accion_poa_ejecutado ;
          $r->accion_poa_porcentaje = $v->accion_poa_porcentaje ;
          $r->porcentaje_ptdi = $v->porcentaje_ptdi ;
          $r->porcentaje_accion_ptdi = $v->porcentaje_accion_ptdi  ;
          $r->porcentaje_pei = $v->porcentaje_pei ;
          $r->causas_variacion     = $v->causas_variacion;

          

        }

      }else{
        //no hay valores
        $r->id_financiero_poa = "";
        $r->monto_poa_planificado = 0;
        $r->monto_poa_ejecutado = 0;
        $r->monto_poa_porcentaje = 0;
        $r->accion_poa_programado = 0;
        $r->accion_poa_ejecutado = 0;
        $r->accion_poa_porcentaje = 0;
        $r->porcentaje_ptdi = 0;
        $r->porcentaje_accion_ptdi = 0;
        $r->porcentaje_pei = 0;
        $r->causas_variacion = "";
      }
    }

    //SELECCIONANDO PROGRAMAS GLOBALES
    $distint = \DB::select("select 
                                    DISTINCT objetivos.id_accion_eta as agregador,
                                    UPPER(nombre_accion_eta ) as nombre_programa
                            from sp_eta_etapas_plan as plan,
                              sp_eta_objetivos_eta as objetivos,
                              sp_eta_articulacion_objetivo_indicador as arti,
                              sp_eta_indicadores as indi,
                              sp_eta_programacion_indicador as p_indi,
                              sp_eta_programacion_recursos as p_recu,
                              
                              sp_eta_catalogo_acciones_eta as catEta,
                              
                              sp_eta_articulacion_catalogos as artPmra
                              where plan.id_institucion = $user->id_institucion
                              and objetivos.id_etapas_plan = plan.id
                              and objetivos.id = arti.id_objetivo_eta
                              
                              and objetivos.id_accion_eta = catEta.id
                              
                              and objetivos.id_accion_eta = artPmra.id_accion_eta
                              and arti.id_indicador = indi.id
                              and arti.id = p_indi.id_articulacion_objetivo_indicador
                              and arti.id = p_recu.id_articulacion_objetivo_indicador
                              and p_indi.gestion = '$gestionActiva->gestion'
                              and p_recu.gestion = '$gestionActiva->gestion'
                              ORDER BY agregador");
    $programas = \DB::select("select 
                                    DISTINCT objetivos.id_accion_eta as agregador,
                                    UPPER(nombre_accion_eta ) as nombre_programa
                            from sp_eta_etapas_plan as plan,
                              sp_eta_objetivos_eta as objetivos,
                              sp_eta_articulacion_objetivo_indicador as arti,
                              sp_eta_indicadores as indi,
                              sp_eta_programacion_indicador as p_indi,
                              sp_eta_programacion_recursos as p_recu,
                              
                              sp_eta_catalogo_acciones_eta as catEta,
                              
                              sp_eta_articulacion_catalogos as artPmra
                              where plan.id_institucion = $user->id_institucion
                              and objetivos.id_etapas_plan = plan.id
                              and objetivos.id = arti.id_objetivo_eta
                              
                              and objetivos.id_accion_eta = catEta.id
                              
                              and objetivos.id_accion_eta = artPmra.id_accion_eta
                              and arti.id_indicador = indi.id
                              and arti.id = p_indi.id_articulacion_objetivo_indicador
                              and arti.id = p_recu.id_articulacion_objetivo_indicador
                              and p_indi.gestion = '$gestionActiva->gestion'
                              and p_recu.gestion = '$gestionActiva->gestion'
                              ORDER BY agregador");
    //ADICIONANDO AL PROGRAMA GLOBAL OBJETIVOS ETA
    $totales_programa = [];
    $orden = 1;
     $j = 0;
    foreach ($distint as $programa) {
      $programa->orden = $orden++;
      $id_programa = $programa->agregador;

      $i = 0;
     
      $objetivo_eta = [];
      $total_ptdi_planificado = 0;
      $total_ptdi_porcentaje_ejecutado = 0;
      $total_accion_ptdi_planificado = 0;
      $total_accion_ptdi_ejecutado = 0;
      $total_monto_poa_planificado = 0;
      $total_monto_poa_ejecutado = 0;
      $total_monto_poa_porcentaje = 0;
      $total_accion_poa_planificado = 0;
      $total_accion_poa_ejecutado = 0;
      $total_accion_poa_porcentaje = 0;
      $totales = [];
      $contador_objetivos_eta = 0;

      foreach ($objetivo_indicador as $obj) {
        if($id_programa == $obj->agregador){
          $objetivo_eta[$i] = $obj;
          //TOTALES
          $total_ptdi_planificado = $total_ptdi_planificado + $obj->monto;
          $total_ptdi_porcentaje_ejecutado = $total_ptdi_porcentaje_ejecutado + $obj->porcentaje_ptdi;
          $total_accion_ptdi_planificado = $total_accion_ptdi_planificado + $obj->valor;
          $total_accion_ptdi_ejecutado = $total_accion_ptdi_ejecutado + $obj->porcentaje_ptdi;
          $total_monto_poa_planificado = $total_monto_poa_planificado + $obj->monto_poa_planificado;
          $total_monto_poa_ejecutado = $total_monto_poa_ejecutado + $obj->monto_poa_ejecutado;
          $total_monto_poa_porcentaje = $total_monto_poa_porcentaje + $obj->monto_poa_porcentaje;
          $total_accion_poa_planificado = $total_accion_poa_planificado + $obj->accion_poa_programado;
          $total_accion_poa_ejecutado = $total_accion_poa_ejecutado + $obj->accion_poa_ejecutado;
          $total_accion_poa_porcentaje = $total_accion_poa_porcentaje + $obj->accion_poa_porcentaje;
          $contador_objetivos_eta++;
          //TOTALES
          $i++;
        }
        
      }
      
      $totales['agregador'] = $programa->agregador;
      $totales['total_ptdi_planificado'] = $total_ptdi_planificado;
      $totales['total_ptdi_porcentaje_ejecutado'] = $total_ptdi_porcentaje_ejecutado;
      $totales['total_accion_ptdi_planificado'] = $total_accion_ptdi_planificado;
      $totales['total_accion_ptdi_ejecutado'] = $total_accion_ptdi_ejecutado;
      $totales['total_monto_poa_planificado'] = $total_monto_poa_planificado;
      $totales['total_monto_poa_ejecutado'] = $total_monto_poa_ejecutado;
      $totales['total_monto_poa_porcentaje'] = $total_monto_poa_porcentaje/$contador_objetivos_eta;
      $totales['total_accion_poa_planificado'] = $total_accion_poa_planificado;
      $totales['total_accion_poa_ejecutado'] = $total_accion_poa_ejecutado;
      $totales['total_accion_poa_porcentaje'] = $total_accion_poa_porcentaje/$contador_objetivos_eta;
      $programa->objetivos_eta_programa = $objetivo_eta;
      $totales_programa[$j] = $totales;
      $j++;
      $programa->ver = false;

    }
    
    return \Response::json(['objEta'=>$objetivo_indicador,
                            'planActivo'=>$planActivo->descripcion,
                            'gestionActiva'=>$gestionActiva->gestion,
                            'estado_modulo' =>$estado_etapa,
                            'plan_activo'=>$planActivo->descripcion,
                            'gestion_activa'=>$gestionActiva->gestion,
                            'distinc' => $distint,
                            'programas' => $programas,
                            'totales_programa' => $totales_programa ]);
  }


  public function saveFinancieroPoa(Request $request){  

    $user = \Auth::user();
    $planActivo = Parametros::where('categoria','periodo_plan')
                                ->where('activo',true)
                                ->first();

    /*********Verificar Gestion Activa**************/
    /*$gestionActiva = SeguimientoGestiones::where('id_periodo_plan', $planActivo->id)
                                          ->where('activo',true)
                                          ->first(); */
    $gestionActiva =  GestionSeleccionada::where('id_institucion', $user->id_institucion)
                                          ->where('activo',true)
                                           ->first();



    $poa =  $request->datos;//arrayPoa
    //dd($poa);
    //dd($poa['gestion_riesgos']);
    $eta_gestion_riegos = $request->eta_gestion_riegos;
    /*foreach ($eta_gestion_riegos as $g) {
      $gestion_riesgo = new GestionRiesgos();
      $gestion_riesgo->id_accion_eta = $poa['id_accion_eta_objetivo'];
      $gestion_riesgo->id_institucion = $user->id_institucion;
      $gestion_riesgo->gestion = $gestionActiva->gestion;
      $gestion_riesgo->activo = true;
      $gestion_riesgo->save();
    }*/
    $user = \Auth::user();
    $gestion = $gestionActiva->gestion;

    if($poa['id_financiero_poa'] == ""){
        //nuevo registro
        $r = new FinancieroPoa();
        $r->id_accion_eta = $poa['id_accion_eta_objetivo'];
        $r->monto_poa_planificado = $poa['monto_poa'];
        $r->monto_poa_ejecutado = $poa['ejecutado'];
        $r->monto_poa_porcentaje = $poa['porcentaje_poa_programado'];
        $r->accion_poa_programado = $poa['programado_accion'];
        $r->accion_poa_ejecutado = $poa['ejecutado_accion'];
        $r->accion_poa_porcentaje = $poa['porcentaje_poa_accion'];
        $r->porcentaje_ptdi = $poa['porcentaje_ptdi'];
        $r->porcentaje_accion_ptdi = $poa['porcentaje_accion_ptdi'];
        //porcentaje_accion_ptdi
        $r->porcentaje_pei = $poa['porcentaje_pei'];
        $r->causas_variacion = $poa['causas_variacion'];
        $r->user = $user->id_institucion;
        $r->id_intitucion =$user->id_institucion;
        $r->gestion = $gestionActiva->gestion;
        $r->activo = true;
        $r->save();

        $gestion_riesgo = new GestionRiesgos();
        $gestion_riesgo->id_accion_eta = $poa['id_accion_eta_objetivo'];
        $gestion_riesgo->id_institucion = $user->id_institucion;
        $gestion_riesgo->gestion = $gestionActiva->gestion;
        $gestion_riesgo->activo = $poa['gestion_riesgos']; 
        $gestion_riesgo->save();

        


        return \Response::json(array(
            'error' => false,
            'title' => "Success!",
            'msg' => "se creo con exito")
        );
     
    }else{
      
        //actualizar registro POA
        $id_financiero_poa = $poa['id_financiero_poa'];

        $r = FinancieroPoa::find($id_financiero_poa);
        //$r = FinancieroPoa::where('id',$id_financiero_poa);
        $r->id_accion_eta = $poa['id_accion_eta_objetivo'];
        $r->monto_poa_planificado = $poa['monto_poa'];
        $r->monto_poa_ejecutado = $poa['ejecutado'];
        $r->monto_poa_porcentaje = $poa['porcentaje_poa_programado'];
        $r->accion_poa_programado = $poa['programado_accion'];
        $r->accion_poa_ejecutado = $poa['ejecutado_accion'];
        $r->accion_poa_porcentaje = $poa['porcentaje_poa_accion'];
        $r->porcentaje_ptdi = $poa['porcentaje_ptdi'];
        $r->porcentaje_accion_ptdi = $poa['porcentaje_accion_ptdi'];
        $r->porcentaje_pei = $poa['porcentaje_pei'];
        $r->causas_variacion = $poa['causas_variacion'];
        $r->user = $user->id_institucion;
        $r->id_intitucion =$user->id_institucion;
        $r->gestion = $gestionActiva->gestion;
        $r->activo = true;
        $r->save();

        $id_gestion_riesgo = $poa['id_gestion_riesgos'];
        $gestion_riesgo = GestionRiesgos::find($id_gestion_riesgo);
        $gestion_riesgo->id_accion_eta = $poa['id_accion_eta_objetivo'];
        $gestion_riesgo->id_institucion = $user->id_institucion;
        $gestion_riesgo->gestion = $gestionActiva->gestion;
        $gestion_riesgo->activo = $poa['gestion_riesgos'];;
        $gestion_riesgo->save();


        
        /*if($poa['gestion_riesgos'] == "false"){
          if()
          $id_gestion_riesgo = $poa['id_gestion_riesgos'];
          //dd($id_gestion_riesgo);
          $gestion_riesgo = GestionRiesgos::find($id_gestion_riesgo);
          //dd($gestion_riesgo);
          $gestion_riesgo->id_accion_eta = $poa['id_accion_eta_objetivo'];
          $gestion_riesgo->id_institucion = $user->id_institucion;
          $gestion_riesgo->gestion = $gestionActiva->gestion;
          $gestion_riesgo->activo = false;
          $gestion_riesgo->save();
        }*/
        
        return \Response::json(array(
            'error' => false,
            'title' => "Success!",
            'msg' => "Se actualizo con exito.")
        );
        
    }
  }

}
