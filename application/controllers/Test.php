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
			// Get Image's filename without extension
			$filename = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);

			// Remove another character except alphanumeric, space, dash, and underscore in filename
			$filename = preg_replace("/[^a-zA-Z0-9 \-_]+/i", '', $filename);

			// Remove space in filename
			$filename = str_replace(' ', '-', $filename);

			// Define Image Dimension(s)
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
					'form_name' => 'image', // Form upload's name
					'upload_path' => FCPATH . 'uploads', // Upload Directory. Default : ./uploads
					'allowed_types' => 'png|jpg|jpeg|webp', // Allowed Extension
					'max_size' => '5128', // Maximun image size. Default : 5120
					'detect_mime' => TRUE, // Detect image mime. TRUE|FALSE
					'file_ext_tolower' => TRUE, // Force extension to lower. TRUE|FALSE
					'overwrite' => TRUE, // Overwrite file. TRUE|FALSE
					'enable_salt' => TRUE, // Enable salt for image's filename. TRUE|FALSE
					'file_name' => $filename . '_' . $size[0] . 'x' . $size[1], // New Image's Filename
					'extension' => 'webp', // New Imaage's Extension. Default : webp
					'quality' => '100%', // New Image's Quality. Default : 95%
					'maintain_ratio' => TRUE, // Maintain image's dimension ratio. TRUE|FALSE
					'width' => $size[0], // New Image's width. Default : 800px
					'height' => $size[1], // New Image's Height. Default : 600px
					'cleared_path' => FCPATH . 'uploads/cleared' // New Image's Location after clearing. Default : FCPATH . 'uploads/cleared'
				);

				// Load Library
				$this->load->library('secure_upload');

				// Send library configuration
				$this->secure_upload->initialize($config);

				// Run Library
				if($this->secure_upload->doUpload())
				{
					// Get Image(s) Data
					$this->image[] = $this->secure_upload->data();
				}
				else
				{
					// Get Image(s) Error if Failure on Uploading Image
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
