<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	protected $image = array(
		'file_name' => '',
		'image_type' => '',
		'image_size_str' => array('width' => '', 'height' => ''),
		'file_size' => '',
		'full_path' => ''
	);

	protected $error = '';

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
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if(isset($_POST['upload']))
		{
			$filename = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
			$filename = preg_replace("/[^a-zA-Z0-9 \-_.]+/i", '', $filename);
			$filename = str_replace(' ', '-', $filename);

			$config = array(
				'form_name' => 'image',
				'upload_path' => FCPATH . 'uploads',
				'allowed_types' => 'png|jpg|jpeg|webp',
				'max_size' => '5128',
				'detect_mime' => TRUE,
				'file_ext_tolower' => TRUE,
				'overwrite' => TRUE,
				'add_salt' => TRUE,
				'file_name' => $filename,
				'extension' => 'webp',
				'quality' => '100%',
				'maintain_ratio' => TRUE,
				'width' => 800,
				'height' => 600
			);

			$this->load->library('secure_upload');
			$this->secure_upload->initialize($config);

			if($this->secure_upload->doUpload())
			{
				$this->image = $this->secure_upload->data();
			}
			else
			{
				$this->error = $this->secure_upload->show_errors();
			}

			$this->secure_upload->removeOriginalImage();

			$data['image'] = $this->image;
			$data['error'] = $this->error;
		}
		else
		{
			$data['image'] = $this->image;
			$data['error'] = $this->error;
		}

		$this->load->view('welcome_message', $data);
	}
}
