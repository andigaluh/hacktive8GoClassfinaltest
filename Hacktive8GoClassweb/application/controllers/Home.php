<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '../vendor/autoload.php';
use \Firebase\JWT\JWT;

class Home extends CI_Controller {

    private $secretkey = '13iloveu3000'; //ubah dengan kode rahasia apapun

    function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('form_validation');
    }

	public function index() {
        $json_url = "http://localhost:8989/posts";
        $json = $this->http_get_request($json_url);
        $data = json_decode($json,TRUE);
        $arrData = array('data'=>$data);
        
        $this->load->view('partials/header');
        $this->load->view('pages/home',$arrData);
        $this->load->view('partials/footer');
    }

    public function detail($id) {
        $json_url = "http://localhost:8989/posts/".$id;
        $json = $this->http_get_request($json_url);
        $data = json_decode($json,TRUE);
        
        $arrData = isset($data['error']) ? array('data'=>array(), 'status'=>0) : array('data'=>$data,'status'=>1);

        $this->load->view('partials/header');
        $this->load->view('pages/detail',$arrData);
        $this->load->view('partials/footer');
    }

    public function about() {
        $json_url = "http://localhost:8989/statis/1";
        $json = $this->http_get_request($json_url);
        $data = json_decode($json,TRUE);
        
        $arrData = isset($data['error']) ? array('data'=>array(), 'status'=>0) : array('data'=>$data,'status'=>1);

        $this->load->view('partials/header');
        $this->load->view('pages/about',$arrData);
        $this->load->view('partials/footer');
    }

    public function contact() {
        $this->load->view('partials/header');
        $this->load->view('pages/contact');
        $this->load->view('partials/footer');
    }

    public function submit_contact() {

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('partials/header');
            $this->load->view('pages/contact');
            $this->load->view('partials/footer');

        }
        else
        {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $message = $this->input->post('message');
            $postField = array(
                'name'=>$name,
                'email'=>$email,
                'message'=>$message,
            );

            $json_url = "http://localhost:8989/contact";
            $json = $this->http_post_request($json_url,$postField);
            $data = json_decode($json,TRUE);

            if(isset($data['error'])) {
                $this->session->set_flashdata('err_message',$data['error']);
                redirect('contact');    
            }
            $this->session->set_flashdata('success_message','Your message successfully submitted, thank you.');
            redirect('contact');
        }
    }

    public function login() {
        $this->load->view('partials/header');
        $this->load->view('pages/login');
        $this->load->view('partials/footer');
    }

    public function submit_login() {
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('partials/header');
            $this->load->view('pages/login');
            $this->load->view('partials/footer');
        }
        else
        {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $postField = array(
                'email'=>$email,
                'password'=>$password,
            );

            $json_url = "http://localhost:8989/login";
            $json = $this->http_post_request($json_url,$postField);
            $data = json_decode($json,TRUE);

            if(isset($data['error'])) {
                $this->session->set_flashdata('err-message',$data['error']);
                redirect(site_url('login'));
            }else{
                //$jwt = $this->input->get_request_header('Authorization');
                $jwt = $data;
                try {
                        $decode = JWT::decode($jwt,$this->secretkey,array('HS256'));

                        $auth = "Authorization: Bearer ".$jwt;
                        $json_url = "http://localhost:8989/users/".$decode->user_id;
                        $json = $this->http_get_auth_request($json_url,$auth);
                        $data = json_decode($json,TRUE);
                        
                        $newdata = array(
                            'jwt' => $jwt,
                            'authorized' => $decode->authorized,
                            'exp' => $decode->exp,
                            'user_id' => $decode->user_id,
                            'user_name' => $data['nickname']
                        );
                        
                        $this->session->set_userdata($newdata);
                        redirect(site_url('dashboard'));
                        
                    } catch (Exception $e) {
                        $this->session->set_flashdata('err-message','Token invalid');
                        redirect(site_url('login'));
                    }
            }
        }
    }

    public function dashboard(){
        
        if(($this->session->userdata('authorized') != TRUE)) {
            $this->session->set_flashdata('err-message','UnAuthorized, please login!');
            redirect(site_url('login'));
        }

        $jwt = $this->session->userdata('jwt');
        $user_id = $this->session->userdata('user_id');
        $auth = "Authorization: Bearer ".$jwt;

        $json_url = "http://localhost:8989/users/".$user_id;
        $json = $this->http_get_auth_request($json_url,$auth);
        $data = json_decode($json,TRUE);

        $arrData = (isset($data['error'])) ? array('data' => array(), 'status' => 0) : array('data' => $data,'status' => 1);
        
        $this->load->view('partials/header');
        $this->load->view('pages/admin-dashboard',$arrData);
        $this->load->view('partials/footer');
    }

    public function adminPosts(){
        
        if(($this->session->userdata('authorized') != TRUE)) {
            $this->session->set_flashdata('err-message','UnAuthorized, please login!');
            redirect(site_url('login'));
        }

        $jwt = $this->session->userdata('jwt');
        $user_id = $this->session->userdata('user_id');
        $auth = "Authorization: Bearer ".$jwt;

        $json_url = "http://localhost:8989/postsAll";
        $json = $this->http_get_auth_request($json_url,$auth);
        $data = json_decode($json,TRUE);

        $arrData = (isset($data['error'])) ? array('data' => array(), 'status' => 0) : array('data' => $data,'status' => 1);
        
        $this->load->view('partials/header');
        $this->load->view('pages/admin-posts',$arrData);
        $this->load->view('partials/footer');
    }

    public function adminCreatePost() {

        if(($this->session->userdata('authorized') != TRUE)) {
            $this->session->set_flashdata('err-message','UnAuthorized, please login!');
            redirect(site_url('login'));
        }

        $jwt = $this->session->userdata('jwt');
        $user_id = $this->session->userdata('user_id');
        $auth = "Authorization: Bearer ".$jwt;

        $this->load->view('partials/header');
        $this->load->view('pages/admin-create-post');
        $this->load->view('partials/footer');
    }

    public function adminSubmitPost() {
       

        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('subtitle', 'subtitle', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('partials/header');
            $this->load->view('pages/admin-create-post');
            $this->load->view('partials/footer');
        }
        else
        {
            if(strlen($_FILES['userfile']['tmp_name']) > 0) {
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 2000;
                $config['max_width']            = 1024;
                $config['max_height']           = 1024;
                $config['file_name']           = uniqid();

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());
                        $this->load->view('partials/header');
                        $this->load->view('pages/admin-create-post',$error);
                        $this->load->view('partials/footer');
                }
                else
                {
                        $dataImage = $this->upload->data();
                        $imageName = $dataImage['file_name'];
                        $imageURL = base_url().'uploads/'.$imageName;
                        $imageStatus = TRUE;
                }
            }else{
                $imageStatus = FALSE;
                $imageName = '';
                $imageURL = '';
            }

            $title = $this->input->post('title');
            $subtitle = $this->input->post('subtitle');
            $content = $this->input->post('content');
            

            $jwt = $this->session->userdata('jwt');
            $user_id = $this->session->userdata('user_id');
            $auth = "Authorization: Bearer ".$jwt;

            $postField = array(
                'title' => $title,
                'subtitle' => $subtitle,
                'content' => $content,
                'image_name' => $imageName,
                'image_url' => $imageURL,
                'author_id' => $user_id
            );

            $json_url = "http://localhost:8989/posts";
            $json = $this->http_post_auth_request($json_url,$auth,$postField);
            $data = json_decode($json,TRUE);

            if(isset($data['error'])){
                $this->session->set_flashdata('err_message',$data['error']);
                redirect(site_url('adminPosts'));
            }

            $this->session->set_flashdata('success_message','Success submit a post');
            redirect(site_url('adminPosts'));

        }
    }

    public function adminPost($id=0) {

        if(($this->session->userdata('authorized') != TRUE)) {
            $this->session->set_flashdata('err-message','UnAuthorized, please login!');
            redirect(site_url('login'));
        }

        $jwt = $this->session->userdata('jwt');
        $user_id = $this->session->userdata('user_id');
        $auth = "Authorization: Bearer ".$jwt;

        $json_url = "http://localhost:8989/postsAll/".$id;
        $json = $this->http_get_request($json_url);
        $data = json_decode($json,TRUE);
        
        $arrData = isset($data['error']) ? array('data'=>array(), 'status'=>0) : array('data'=>$data,'status'=>1);

        $this->load->view('partials/header');
        $this->load->view('pages/admin-edit-post',$arrData);
        $this->load->view('partials/footer');

    }

    public function adminUpdatePost($id) {

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('subtitle', 'SubTitle', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            die('validation_errors');
            redirect(site_url('adminPost/'.$id),'refresh');
        }
        else
        {
            if(strlen($_FILES['userfile']['tmp_name']) > 0) {
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 5000;
                $config['max_width']            = 2048;
                $config['max_height']           = 2048;
                $config['file_name']           = uniqid();

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());
                        redirect(site_url('adminPost/'.$id),'refresh');
                }
                else
                {
                        $dataImage = $this->upload->data();
                        $imageName = $dataImage['file_name'];
                        $imageURL = base_url().'uploads/'.$imageName;
                        $imageStatus = TRUE;
                }
            }else{
                $imageStatus = FALSE;
                $imageName = '';
                $imageURL = '';
            }

            $title = $this->input->post('title');
            $subtitle = $this->input->post('subtitle');
            $content = $this->input->post('content');
            $is_publish = $this->input->post('is_publish');

            $jwt = $this->session->userdata('jwt');
            $user_id = $this->session->userdata('user_id');
            $auth = "Authorization: Bearer ".$jwt;

            $postField = array(
                'title' => $title,
                'subtitle' => $subtitle,
                'content' => $content,
                'image_name' => $imageName,
                'image_url' => $imageURL,
                'is_publish' => (int)$is_publish,
                'author_id' => $user_id
            );

            $json_url = "http://localhost:8989/posts/".$id;
            $json = $this->http_put_auth_request($json_url,$auth,$postField);
            $data = json_decode($json,TRUE);

            $arrData = isset($data['error']) ? array('data'=>array(), 'status'=>0) : array('data'=>$data,'status'=>1);

            if(isset($data['error'])) {
                $this->session->set_flashdata('error_message',$data['error']);
                redirect(site_url('adminPost/'.$id),'refresh');
            }

            $this->session->set_flashdata('success_message','Success update');
            redirect(site_url('adminPosts'));

        }
    }

    public function adminDeletePost($id) {
        if(($this->session->userdata('authorized') != TRUE)) {
            $this->session->set_flashdata('err-message','UnAuthorized, please login!');
            redirect(site_url('login'));
        }

        $jwt = $this->session->userdata('jwt');
        $user_id = $this->session->userdata('user_id');
        $auth = "Authorization: Bearer ".$jwt;

        $json_url = "http://localhost:8989/posts/".$id;
        $json = $this->http_del_auth_request($json_url,$auth);
        $data = json_decode($json,TRUE);

        if(isset($data['error'])) {
            $this->session->set_flashdata('error_message',$data['error']);
            redirect(site_url('adminPosts'));
        }

            $this->session->set_flashdata('success_message','Success Delete');
            redirect(site_url('adminPosts'));

    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(site_url('login'));

    }

    function http_get_request($url){
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);      
        return $output;
    }

    function http_post_request($url,$postField=array()) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        $payload = json_encode($postField);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close ($ch);
        return $server_output;
    }

    function http_get_auth_request($url,$auth){
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json',$auth));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);      
        return $output;
    }

    function http_post_auth_request($url,$auth,$postField=array()){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json',$auth));
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        $payload = json_encode($postField);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close ($ch);
        return $server_output;
    }

    function http_put_auth_request($url,$auth,$postField=array()){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json',$auth));
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        $payload = json_encode($postField);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close ($ch);
        return $server_output;
    }

    function http_del_auth_request($url,$auth){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json',$auth));
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close ($ch);
        return $server_output;
    }
}
