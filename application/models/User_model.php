<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function User()
    {
        return $this->db->get_where('users', ['id' => $this->session->userdata('id')])->row_array();
    }
}

/* End of file User_model.php */
