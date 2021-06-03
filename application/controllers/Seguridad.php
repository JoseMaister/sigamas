<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Seguridad extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function vencimiento_password(){
        $this->load->view('seguridad/password');
    }

    function recuperacion_password(){
        $this->load->view('seguridad/recuperacion_password');
    }

    function reiniciar_password($link){
        date_default_timezone_set('America/Chihuahua');
        $res = $this->Conexion->consultar("SELECT R.vencimiento, U.id, concat(U.nombre, ' ', U.paterno) as Name, U.activo, U.password from recuperacion_password R inner join usuarios U on U.id = R.usuario where R.link = '$link'", TRUE);

        $today = date("y-m-d H:i", strtotime("now"));
        $fecha = date("y-m-d H:i", strtotime($res->vencimiento));
        
        if($today > $fecha)
        {
            echo "LIGA VENCIDA";
        }
        else
        {
            $this->session->id = $res->id;
            $this->session->activo = $res->activo;
            $this->session->nombre = $res->Name;
            $this->session->password = $res->password;
            $this->session->vencimiento_password = date("y-m-d H:i", strtotime("last month"));

            redirect(base_url('inicio'));
        }
    }

    //                         __
    //                       .'  '.
    //                   _.-'/  |  \
    //      ,        _.-"   |  /    `-.
    //      |\    .-"       `--""-.__.'======================,
    //      \ '-'`        .___.--._)=========================|
    //       \            .'      |                          |
    //        |     /,_.-'        |        CODIGO AJAX       |
    //      _/   _.'(             |            BY            |
    //     /  ,-' \  \            |        ALEKS ORTIZ       |
    //     \  \    `-'            |                          |
    //      `-'                   '--------------------------'

    function ajax_changePass(){
        $pass = md5($this->input->post('password'));
        if(strtoupper($this->session->password) != strtoupper($pass))
        {
            $this->session->sess_destroy();
            echo $this->Conexion->modificar('usuarios', array('password' => $pass), array('vencimiento_password' => 'CURRENT_TIMESTAMP() + INTERVAL 30 day'), array('id' => $this->session->id));
        }
    }

    function ajax_recoverPass(){
        $noempleado = $this->input->post('noempleado');
        $correo = $this->input->post('correo');

        $res = $this->Conexion->consultar("SELECT id, correo, concat(nombre, ' ', paterno) as Name from usuarios where activo = 1 and no_empleado='$noempleado' and correo = '$correo' limit 1", TRUE);
        if($res)
        {
            $data['usuario'] = $res->id;
            $data['link'] = uniqid();
            $func['fecha'] = "CURRENT_TIMESTAMP()";
            $func['vencimiento'] = "CURRENT_TIMESTAMP() + interval 6 hour";
            $this->Conexion->insertar('recuperacion_password', $data, $func);


            $this->load->library('email');
            $logo = base_url('template/images/logo.png');
            $url = base_url('seguridad/reiniciar_password/') . $data['link'];

            $mensaje = "
                <img width='400' src='$logo'><br>
                <h1><font face='Times'>SIGA-MAS</font></h1>
                <h2>Recuperación de Contraseña</h2>
                <p>Ingresa a la liga debajo para reestablecer tu contraseña</p>
                <br>
                <a href='$url' class='btn btn-primary'>Reestablecer contraseña</a>";

            $this->email->from('tickets@masmetrologia.com', 'Soporte SIGA-MAS');
            $this->email->to($res->correo);

            $this->email->subject('Recuperación de Contraseña');
            $this->email->message($mensaje);

            $this->email->send();
            echo json_encode($res);
        }
    }

    function ajax_md5(){
        echo md5($this->input->post('text'));
    }

    function md5($texto){
        echo md5($texto);
    }


}
