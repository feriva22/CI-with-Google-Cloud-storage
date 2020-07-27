<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model(array('m_staff'));
        
        $this->auth->set_module('dashboard');
        $this->auth->authenticate();
	}
	
	public function index()
	{
		$data = array();

        $data['page_title'] = 'Dashboard';
        $data['plugin'] = array();
        $data['custom_js'] = array(
            'data' => $data,
            'src'  => 'backend/__scripts/dashboard'
        );
        $data['assets_js'] = array();
        $data['groups'] = $this->auth->getUsergroup();
        $data['session'] = $this->auth->getUser();
        $data['staff'] = $this->m_staff->get('stf_id = '.$this->auth->getUserid(),NULL,1);
        
        render_backendpage('backend/dashboard/index',$data);
    }

    /*
    public function get_notif(){
        if(!$this->input->is_ajax_request()) show_404();

        $view = $this->input->post('view');
        if($view != ''){
            $sql_update = 'UPDATE notification SET ntf_status = '.SEEN.' WHERE ntf_status = '.UNSEEN;
            $this->m_notification->custom_query($sql_update,FALSE);
        }

        $renderPage = ""; //html rendered
        $notif_data = $this->m_notification->get("","ntf_id DESC",5,0);
        $count_unseen = 0;

        $notif_type = $this->config->item('notif_type');

        foreach($notif_data as $notif){
            if($notif->ntf_status == UNSEEN){
                $count_unseen++;
            }
            $renderPage = $renderPage.'
                <a href="'.$notif->ntf_url.'" class="media">
                <span class="d-flex">
                    <i class="'.$notif_type[$notif->ntf_type]['icon'].'"></i> 
                </span>
                <span class="media-body">
                    <span class="heading-font-family media-heading">'.$notif->ntf_title.'</span>
                    <br>
                    <span class="media-content">'.$notif->ntf_detail.'</span>
                </span>
                </a>';
        }

        json_response('success','Sukses get notif',array(
                                            'raw' => $notif_data,
                                            'render' => $renderPage,
                                            'unseen_count' => $count_unseen
                        ));
    }*/
    
}
