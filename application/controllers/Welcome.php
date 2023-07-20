<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index($offset = 0)
	{
		// pagination config
        $config['base_url'] = base_url().'index.php/welcome/index';
        $config['total_rows'] = $this->db->count_all('post');
//$this->db->count_all('posts');
        $config['per_page'] = 12;
        $config['uri_segment'] = 3;
        //$config['attributes'] = array('class' => 'pagination-link');
        // Customize the CSS classes
$config['full_tag_open'] = '<nav><ul class="flex items-center space-x-2">';
$config['full_tag_close'] = '</ul></nav>';
$config['num_tag_open'] = '<li class="px-3 py-1 rounded-md bg-gray-200 text-gray-800 hover:bg-gray-300">';
$config['num_tag_close'] = '</li>';
$config['cur_tag_open'] = '<li class="px-3 py-1 rounded-md bg-blue-500 text-white hover:bg-blue-600">';
$config['cur_tag_close'] = '</li>';
$config['prev_link'] = '&laquo;';
$config['prev_tag_open'] = '<li class="px-3 py-1 rounded-md bg-gray-200 text-gray-800 hover:bg-gray-300">';
$config['prev_tag_close'] = '</li>';
$config['next_link'] = '&raquo;';
$config['next_tag_open'] = '<li class="px-3 py-1 rounded-md bg-gray-200 text-gray-800 hover:bg-gray-300">';
$config['next_tag_close'] = '</li>';

// init pagination
        $this->pagination->initialize($config);
$this->db->limit($config['per_page'], $offset);
$this->db->order_by('id', 'DESC');
$query =  $this->db->get('post');
                $data['post'] = $query->result();
                //var_dump($data);
$this->load->view('templates/header_tailwind');
                $this->load->view('tailwind1', $data);
$this->load->view('templates/footer_tailwind');
	}

public function view($slug = NULL){
        $query = $this->db->get_where('post', array('slug' => $slug));
        $data['post'] = $query->row();
        //var_dump($query->row()->id);
        //var_dump($this->post_model->get_next_posts($data['post']->id));
        if(empty($data['post'])){
            show_404();
        }

        $data['title'] = $data['post']->title;
        $this->load->view('templates/header_tailwind');
        $this->load->view('view', $data);
        $this->load->view('templates/footer_tailwind');
    }

public function viewt($slug = NULL){
      $this->load->helper('captcha');
      if(!$this->session->has_userdata('rcode')){
        $this->session->set_userdata('rcode', base64_encode(random_bytes(10)));
      }
        $data['post'] = $this->post_model->get_products($slug);
        //var_dump($data['post']->id);
        //var_dump($this->post_model->get_next_posts($data['post']->id));
        if(empty($data['post'])){
            show_404();
        }

        $data['title'] = $data['post']->name;
        $q = $this->db->get_where('product', array('product_id' => $data['post']->product_id));
$data['des'] = $q->row();
if(!$this->session->has_userdata('pvisited')){
  $_SESSION['pvisited'] = [];
}
  array_push($_SESSION['pvisited'], $data['post']->product_id);
  $data['count_visit'] = count(array_unique($_SESSION['pvisited']));
        if($data['count_visit'] > 9){
          $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
          $encryptedValue = openssl_encrypt($this->session->userdata('rcode'), 'aes-256-cbc', $this->config->item('encryption_key'), 0, $iv);
          $data['your_code'] = base64_encode($encryptedValue . '::' . $iv);
          $dcode = array(
           'rcode' => $this->session->userdata('rcode'),
           'ycode' => $data['your_code'],
          'visited' => json_encode($_SESSION['pvisited']),
          'ipaddr' => $_SERVER['REMOTE_ADDR'],
          'time' => time()
        );
          $this->db->insert('bbb2', $dcode);
        }else {$data['your_code'] = '';}
        $this->load->view('templates/header');
        $this->load->view('posts/view', $data);
        $this->load->view('templates/footer');
    }

}
