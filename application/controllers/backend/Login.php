<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library(array('auth'));
        $this->load->model(array('m_staff'));

	}
	
	public function index()
	{   
        if($this->auth->isLogin()){
            return redirect('backend/dashboard');
        }

		$data = array();

        $data['page_title'] = 'Login';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/login'
        );
        $data['assets_js'] = array();

        render_backendpage('backend/login/index',$data,FALSE,FALSE,FALSE,
                            'backend/__base/header_login',
                            'backend/__base/footer_login');

    }
    
    public function authenticate(){
        //only ajax is allowed
		if(!$this->input->is_ajax_request()) show_404();

		$res = $this->auth->backendLogin(USERNAME_PASSWORD);

        if(!$res){
            json_response('error','Username/password not found');
        }else{
            if(is_string($res))
                json_response('error',trim($res));
            else
                json_response('success','success login',array(
                                                    'redir'   => 'backend/dashboard'));
        }
        

    }

    public function change_password(){
        if(!$this->input->is_ajax_request()) show_404();

        $this->auth->authenticate();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('current_password'  , 'Password Sekarang'  , 'required|trim|max_length[255]');
        $this->form_validation->set_rules('chg_password'  , 'Passoword Diubah'  , 'required|trim|max_length[255]');

        if($this->form_validation->run()){
            $current_time = date('Y-m-d H:i:s');

            $current_user = $this->m_staff->get('stf_id = '.$this->auth->getUserid(). ' AND stf_status != '.DELETED,null,1);
            //check current password same or not
            
            if(!password_verify($this->input->post('current_password'),$current_user->stf_password)){
                echo json_encode(array('status' => 'error','message' => 'Password Tidak Sama dengan Password Saat Ini !'));
                exit;
            }

            $this->m_staff->update_multiple_column(array(
                                                'stf_password' => password_hash($this->input->post('chg_password'),PASSWORD_DEFAULT),
                                                'stf_updated' => $current_time
            ),$current_user->stf_id);
            
            if($this->db->affected_rows() > 0){
                echo json_encode(array('status' => 'success','message' => 'Sukses Mengganti Password Akun, Silahkan Login Kembali'));
            }else{
                json_encode(array('status' => 'error','message' => 'Gagal mengganti Password Akun'));
            }
        }else{
            json_encode(array('status' => 'error','message' => validation_errors()));
        }
    }

    public function logout(){
        if($this->auth->logout()){
            $this->auth->showBackendLoginForm();
        }
        return false;
    }
}
