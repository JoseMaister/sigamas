<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function ajax_getMessages(){
        $idUser = $this->session->id;
        $to = $this->input->post("to");
        $res = $this->Conexion->consultar("SELECT *, if(usuario = $idUser, '1', '0') as Propio FROM chat WHERE JSON_CONTAINS(usuarios, '$idUser') and JSON_CONTAINS(usuarios, '$to')");
        echo json_encode($res);
    }

    function ajax_setMessage(){
        $usuarios = [intval($this->session->id)];
        array_push($usuarios, intval($this->input->post("to")));

        $data['usuario'] = $this->session->id;
        $data['usuarios'] = json_encode($usuarios);
        $data['mensaje'] = $this->input->post("message");
        $data['visto'] = "[]";
        $data['eliminar'] = "[]";
        
        $f["fecha"] = "CURRENT_TIMESTAMP()";

        $this->Conexion->insertar('chat', $data, $f);

        $data['type'] = 'message';
        $data['nombre'] = ucwords(strtolower($this->session->nombre));
        $data['para'] = $this->input->post("to");
        

        echo json_encode($data);
    }

    function ajax_setVisto(){
        $usuario = $this->session->id;
        $to = $this->input->post("to");
        //$this->Conexion->comando("UPDATE chat set visto = if(JSON_CONTAINS(visto, '$usuario'), visto, JSON_MERGE(visto, '$usuario')) WHERE JSON_CONTAINS(usuarios, '$usuario') and JSON_CONTAINS(usuarios, '$to');");        
        $this->Conexion->comando("UPDATE chat set visto = if(json_length(visto) = 0, JSON_OBJECT($usuario, current_timestamp()), if(!json_contains(JSON_KEYS(visto), '\"$usuario\"'), JSON_MERGE(visto, JSON_OBJECT($usuario, current_timestamp())), visto)) WHERE JSON_CONTAINS(usuarios, '$usuario') and JSON_CONTAINS(usuarios, '$to')");
        
        
        $data['type'] = 'read';
        $data['usuario'] = $usuario;
        $data['nombre'] = "Alejandro Ortiz";
        $data['para'] = $to;

        echo json_encode($data);
    }

    function ajax_cleanChatWindow(){
        $usuario = $this->session->id;
        $to = $this->input->post("to");

        $this->Conexion->comando("UPDATE chat set eliminar = if(JSON_CONTAINS(eliminar, '$usuario'), eliminar, JSON_MERGE(eliminar, '$usuario')) WHERE JSON_CONTAINS(usuarios, '$usuario') and JSON_CONTAINS(usuarios, '$to');");        
    }

    function ajax_setChatServer(){
        $id = $this->input->post('id');
        $chat_server = $this->input->post('chat_server');
        $this->Conexion->modificar("usuarios", array('chat_server' => $chat_server), null, array('id' => $id));

        $data['type'] = 'connect';
        $data['chat_server'] = $chat_server;
        echo json_encode($data);
    }

    function ajax_getChatUsers(){
        $usuario = $this->session->id;
        $res = $this->Conexion->consultar("SELECT U.id, U.chat_server, concat(CAP_FIRST(U.nombre), ' ',CAP_FIRST(U.paterno)) as Name, (SELECT count(*) from chat where JSON_CONTAINS(usuarios, '$usuario') and usuario = U.id and (!JSON_CONTAINS(JSON_KEYS(visto), '\"$usuario\"') or JSON_LENGTH(visto) = 0) and !JSON_CONTAINS(eliminar, '$usuario')) as Msjs from usuarios U where U.activo = 1 order by U.chat_server desc, Name");
        echo json_encode($res);
    }

    function ajax_saveChatWindows(){
        $this->session->chats = $this->input->post("chats");
    }

}
