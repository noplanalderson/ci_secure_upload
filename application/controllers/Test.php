<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	protected $image = '';

	protected $error = '';

	/**
	 * Index page or upload test page
	 * 
	 * This test perform single upload file with multiple image dimension
	 * using Secure_upload library for Codeigniter 3.x
	 * 
	 */
	public function index()
	{
		if(isset($_POST['upload']))
		{
			$filename = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
			$filename = preg_replace("/[^a-zA-Z0-9 \-_.]+/i", '', $filename);
			$filename = str_replace(' ', '-', $filename);

			// Define Image Dimensions
            $image_sizes = array(
                'thumb'     => array(200, 100),
                'phablet'   => array(300, 200),
                'tablet'    => array(500, 400),
                'large'     => array(800, 600),
            );
			
			$this->image = [];
			$this->error = [];

			foreach ($image_sizes as $size) :

				$config = array(
					'form_name' => 'image',
					'upload_path' => FCPATH . 'uploads',
					'allowed_types' => 'png|jpg|jpeg|webp',
					'max_size' => '5128',
					'detect_mime' => TRUE,
					'file_ext_tolower' => TRUE,
					'overwrite' => TRUE,
					'enable_salt' => TRUE,
					'file_name' => $filename . '_' . $size[0] . 'x' . $size[1],
					'extension' => 'webp',
					'quality' => '100%',
					'maintain_ratio' => TRUE,
					'width' => $size[0],
					'height' => $size[1]
				);

				$this->load->library('secure_upload');
				$this->secure_upload->initialize($config);

				if($this->secure_upload->doUpload())
				{
					$this->image[] = $this->secure_upload->data();
				}
				else
				{
					$this->error[] = $this->secure_upload->show_errors();
				}
			endforeach;

			$data['images'] = $this->image;
			$data['errors'] = $this->error;
		}
		else
		{
			$data['images'] = $this->image;
			$data['errors'] = $this->error;
		}

		$this->load->view('upload', $data);
	}
}
