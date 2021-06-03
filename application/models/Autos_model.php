<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Autos_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->db->reconnect();
    }

    function getCatalogo()
    {
        $this->db->select('A.*, ifnull(concat(U.nombre," ",U.paterno),"N/A") as Responsable, (SELECT max(fecha) from autos_revisiones where auto=A.id) as Ultrev, (SELECT max(id) from autos_revisiones where auto=A.id) as IdUltrev');
        $this->db->from('autos A');
        $this->db->join('usuarios U', 'A.responsable = U.id', 'LEFT');
        $res = $this->db->get();
        if($res->num_rows() > 0)
        {
            return $res;
        }
        else
        {
            return false;
        }
    }

    function getRevPendientes()
    {
        $this->db->select('A.*, ifnull(concat(U.nombre," ",U.paterno),"N/A") as Responsable, (SELECT max(fecha) from autos_revisiones where auto=A.id) as Ultrev, (SELECT max(id) from autos_revisiones where auto=A.id) as IdUltrev');
        $this->db->from('autos A');
        $this->db->join('usuarios U', 'A.responsable = U.id', 'LEFT');
        $this->db->having('Ultrev + INTERVAL 7 DAY < ','CURRENT_TIMESTAMP()',FALSE);
        $this->db->or_having('Ultrev');
        $res = $this->db->get();
        if($res->num_rows() > 0)
        {
            return $res;
        }
        else
        {
            return false;
        }
    }

    function getRevHoy()
    {
        $this->db->select('A.*, (SELECT max(fecha) from autos_revisiones where auto=A.id) as Ultrev, (SELECT max(id) from autos_revisiones where auto=A.id) as IdUltrev');
        $this->db->from('autos A');
        $this->db->having('Ultrev > ','current_date()',FALSE);
        $res = $this->db->get();
        if($res->num_rows() > 0)
        {
            return $res;
        }
        else
        {
            return false;
        }
    }

    function getProxMttos()
    {
      $this->db->select('A.*');
      $this->db->from('autos A');
      $this->db->where('A.kilometraje + 1000 > ','A.proximo_mtto', FALSE);
      $this->db->where('A.proximo_mtto != ','0', FALSE);
      $res = $this->db->get();
      if($res->num_rows() > 0)
      {
          return $res;
      }
      else
      {
          return false;
      }
    }


    function getAuto($id_auto)
    {
        $this->db->where('id',$id_auto);
        $res = $this->db->get('autos');
        if($res->num_rows() > 0)
        {
            return $res->row();
        }
        else
        {
            return false;
        }
    }

    function getResponsable($id)
    {
      if(isset($id))
      {
        $this->db->where('id', $id);
        $res = $this->db->get('usuarios');
        if($res->num_rows() > 0)
        {
            return $res->row();
        }
        else
        {
            return false;
        }
      }
      else
      {
        return false;
      }

    }

    function updateAuto($id_auto, $datos)
    {
        $this->db->where('id', $id_auto);
        $this->db->update('autos', $datos);
    }

    function saveChecklist($datos)
    {
        $this->db->set('fecha', 'current_timestamp()', FALSE);
        $exito = $this->db->insert('autos_revisiones', $datos);
        $id = $this->db->insert_id();
        return array('EXITO' => $exito, 'ID' => $id);
    }

    function saveTempPhotos($data)
    {
      $this->db->set('fecha', 'current_timestamp()', FALSE);
      if($this->db->insert('temp', $data))
      {
        return $this->db->insert_id();
      }
      else
      {
        return 0;
      }
    }

    function deleteTempPhotos($id_temp)
    {
      $this->db->where('id', $id_temp);
      if($this->db->delete('temp'))
      {
        return TRUE;
      }
      else
      {
        return FALSE;
      }
    }

    function getHallazgoFoto($idFoto)
    {
      $this->db->select('foto');
      $this->db->where('id',$idFoto);
      $res = $this->db->get('revisiones_hallazgos');
      if($res->num_rows() > 0)
      {
          return $res->row();
      }
      else
      {
          return false;
      }
    }

    function saveHallazgosCarroceria($datos)
    {
        $query = "INSERT into revisiones_hallazgos (revision,tipo,descripcion,foto) (SELECT '" . $datos['revision'] . "', 'CARROCERIA', texto, archivo from temp where iu='" . $datos['iu'] . "');";
        $query2 = "DELETE from temp where iu='" . $datos['iu'] . "'";
        if($this->db->query($query));
        {
          $this->db->query($query2);
        }
    }

    function saveHallazgos($datos)
    {
      return $this->db->insert('revisiones_hallazgos', $datos);
    }

    function getHallazgosCarroceria($id_revision)
    {
      $array = array('revision' => $id_revision, 'tipo' => 'Carroceria');
      $this->db->select('id,descripcion');
      $this->db->where($array);
      $query = $this->db->get('revisiones_hallazgos');
      if ($query->num_rows() > 0) {
          return $query;
      } else {
          return false;
      }
    }

    function getHallazgosOtros($id_revision)
    {
      $array = array('revision' => $id_revision, 'tipo !=' => 'Carroceria');
      $this->db->where($array);
      $query = $this->db->get('revisiones_hallazgos');
      if ($query->num_rows() > 0) {
          return $query;
      } else {
          return false;
      }
    }

    function getRevisiones($auto)
    {
        $this->db->select('R.id, R.fecha, ifnull(concat(U.nombre," ",U.paterno),"N/A") as User, (SELECT count(*) from revisiones_hallazgos where revision=R.id) as Hallazgos');
        $this->db->from('autos_revisiones R');
        $this->db->join('usuarios U', 'R.usuario = U.id', 'LEFT');
        $this->db->where('auto', $auto);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    function getRevision($id_revision)
    {
        $this->db->select('R.*, ifnull(concat(U.nombre," ",U.paterno),"N/A") as User');
        $this->db->from('autos_revisiones R');
        $this->db->join('usuarios U', 'R.usuario = U.id', 'LEFT');
        $this->db->where('R.id', $id_revision);
        $res = $this->db->get();
        if($res->num_rows() > 0)
        {
            return $res->row();
        }
        else
        {
            return false;
        }
    }

    function getChecklist($id)
    {
        $this->db->select('checklist');
        $this->db->from('autos_revisiones');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    function getMotorPlacasKm($auto)
    {
        $this->db->select('combustible, placas, kilometraje');
        $this->db->from('autos');
        $this->db->where('id', $auto);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $res = $query->row();
            return $res;
        } else {
            return 'ERROR';
        }
    }
}
