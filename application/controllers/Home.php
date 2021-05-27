<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
        $this->load->library('form_validation');
    }

    public function index()
    {
        // $session = $this->session->userdata('id');
        // var_dump($session);
        // die;
        $data['user'] = $this->user->user();
        $data['judul'] = 'Home';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('home/home');
        $this->load->view('templates/footer', $data);
    }

    public function profil()
    {
        $data['user'] = $this->user->user();
        $data['judul'] = 'Profil';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('home/profil', $data);
        $this->load->view('templates/footer', $data);
    }

}

/* End of file Home.php */
