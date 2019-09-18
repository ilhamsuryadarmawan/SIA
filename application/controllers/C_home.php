<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_home extends CI_Controller {

    private $header_data;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array("url"));
        $this->load->model('M_home');

        if($_SERVER['SERVER_NAME'] == 'localhost')
        {
            redirect(current_url(), 'refresh');
        }

        if(isset($this->uri->segments[1]))
            $this->header_data['controller'] = $this->uri->segments[1];
        else
        $this->header_data['controller'] = 'home';
        
    }

	public function index()
	{
        $this->load->view('headerMenu', $this->header_data);
        $data['namaAkun']=$this->M_home->getAllNamaAkun();
        $this->load->view('home',$data);
        $this->load->view('footer');
    }
    
    public function tambahJurnal()
    {
        echo $this->M_home->tambahJurnal($_POST);
    }
}
