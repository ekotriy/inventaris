<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->model('auth_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        if ($this->session->userdata('username')) {
            redirect('home');
        }
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[12]');
        if ($this->form_validation->run() == FALSE) {
            $data['judul'] = 'Login';
            $this->load->view('templates/header', $data);
            $this->load->view('login/login');
            $this->load->view('templates/footer');
        } else {
            $this->_login();
        }
    }

    public function _login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $user = $this->db->get_where('users', ['username' => $username])->row_array();

        // jika ada user
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $data = [
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'name' => $user['name']
                ];
                $this->session->set_userdata($data);
                redirect('home');
            } else {
                $this->session->set_flashdata('pesan', '< class="alert alert-success alert-dismissible fade show" role="alert">
                Password Salah !<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Email tidak terdaftar<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('auth');
        }
    }

    public function register()
    {
        if ($this->session->userdata('username')) {
            redirect('home');
        }

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');

        $this->form_validation->set_rules('role', 'Status', 'trim|required');
        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[6]|max_length[12]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Password', 'trim|required|min_length[6]|max_length[12]|matches[password1]');

        if ($this->form_validation->run() == FALSE) {
            $data['judul'] = 'Daftar';
            $this->load->view('templates/header', $data);
            $this->load->view('login/regis');
            $this->load->view('templates/footer');
        } else {
            $data = [
                'username'  => htmlspecialchars($this->input->post('username', true)),
                'nama'      => htmlspecialchars($this->input->post('nama', true)),
                'role'      => $this->input->post('role', true),
                'foto'      => 'default.jpg',
                'password'  => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'date_created' => date("Y-m-d H:i:s"),
                'date_updated' => date("Y-m-d H:i:s")

            ];
            $this->db->insert('users', $data);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Selamat ! kamu berhasil terdaftar <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>');
            redirect('auth');
        }
    }

    public function reset()
    {;
        $username = $this->input->post('username',true);
        $passwordlama = $this->input->post('password_lama',true);
        $passwordbaru = $this->input->post('password1',true);

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password_lama', 'Password Lama', 'required|trim');
        $this->form_validation->set_rules('password1', 'Password Baru', 'required|trim|min_length[6]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Konfirmasi Password Baru', 'required|trim|min_length[6]|matches[password1]');

        if ($this->form_validation->run() == FALSE) {
            $data['judul'] = 'Daftar';
            $this->load->view('templates/header', $data);
            $this->load->view('login/reset');
            $this->load->view('templates/footer');
        } else {
            $user = $this->db->get_where('users', ['username' => $username])->row_array();
            if ($user) {
                $datau['users'] = $this->db->get_where('users', ['username' => $username])->row_array();
                if (password_verify($passwordlama, $datau['users']['password'])) {
                    if ($passwordlama == $passwordbaru) {
                        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Password tidak boleh sama !<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
                        redirect('auth/reset');
                    } else {
                        $data = [
                            'password' => password_hash($passwordbaru, PASSWORD_DEFAULT),
                            'date_updated' => date("Y-m-d H:i:s")

                        ];
                        $this->db->where('username', $username);
                        $this->db->update('users', $data);
                        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Password berhasil dirubah<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
                        redirect('auth');
                    }
                } else {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Password Salah<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>');
                    redirect('auth/reset');
                }
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">Username tidak terdaftar !<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>');
                redirect('auth/reset');
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('name');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Anda berhasil keluar<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>');
        redirect('auth');
    }
}
/* End of file Auth.php */