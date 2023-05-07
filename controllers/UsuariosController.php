<?php

namespace app\controllers;

use app\models\Usuarios;

class UsuariosController extends \yii\web\Controller
{   
    public $modelClass = 'app\models\Usuarios';
    public $enableCsrfValidation = false;
    
    public function actionBajaUsuario(){
        /**
         * Se da de baja al usuario con el usu_id que reciba esta funcion
         * Falta:
         *      Token: Falta un token para saber si es un administrador que requiere esta acción.
         */
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $datos = json_decode(file_get_contents('php://input'));

            if(Usuarios::bajaUsuario($datos->usu_id)){
                /**
                 * Falta: Motivo por el que se le da de baja que creo que tendria que crearse un logabm:
                 * 
                 * $logabm_usu_id = $datos->usu_id_admin
                 * $logabm_tabla = "usuarios"
                 * $logabm_accion_id = ?
                 * $logabm_nombre_accion = "Baja usuario"
                 * $logabm_modelo_viejo = ?
                 * $logabm_modelo_nuevo = ?
                 * $logabm_descripcion = $datos->causa
                 */
                //LogAbmController::altaLogAbm($logabm_usu_id, $logabm_tabla, $logabm_accion_id, $logabm_nombre_accion,   )

                return json_encode(array("codigo"=>0,"mensaje"=>"Usuario dado de baja"));
            }else{
                return json_encode(array("codigo"=>100,"mensaje"=>"No"));
            }
        }
    }


    public function actionObtenerUsuarioshabilitados(){
            /**
            * Listar los usuario habilitados para que el administrador los vea y de baja el que requiera.
            * Falta:
            *      Token: Falta un token para saber si es un administrador que requiere esta acción.
            */
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $listaUsuarios = Usuarios::obtenerUsuarioshabilitados();
            $listaUsuarios = UsuariosController::generarEstructuaUsuarioshabilitados($listaUsuarios);
            return json_encode(array("codigo" => 0, "mensaje" => "", "data" => $listaUsuarios));
        }
    }

    public function generarEstructuaUsuarioshabilitados($usuarios){
        
        $array = array();
        foreach($usuarios as $usuario)
        {
            $index = null;
            $index['id'] = $usuario['usu_id'];
            $index['documento'] = $usuario['usu_documento'];
            $index['nombre'] = $usuario['usu_nombre'];
            $index['apellido'] = $usuario['usu_apellido'];
            $index['mail'] = $usuario['usu_mail'];
            $index['telefono'] = $usuario['usu_telefono'];

            array_push($array,$index);
        }
        return $array;
    }  
}