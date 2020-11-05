<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Codeigniter Secure Upload Image</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}

	.credits {
		font-style: italic;
		font-family: Cambria;
	}

	</style>
</head>
<body>

<div id="container">
	<h1>Image Upload Test using Secure Upload Image</h1>

	<div id="body">

		<p>Upload your image here:</p>
		<code>
			<?= form_open_multipart();?>
			<?= form_upload('image');?>
			<?= form_submit('upload', 'Upload!');?>
			<?= form_close();?>
		</code>

		<p>Success Result</p>
		<code>
			<?php 
			if(!empty($images)):
			foreach ($images as $image) :?>
				File Name : <?= $image['file_name'];?><br/>
				File Ext : <?= $image['image_type'];?><br/>
				File Dimension : <?= $image['image_size_str']['width'] .' x ' . $image['image_size_str']['height'];?><br/>
				File Size : <?= $image['file_size'];?><br/>
				File Path : <?= $image['cleared_path'];?><br/>
				File Full Path : <?= $image['full_path'];?>
				<hr/>
			<?php endforeach; endif;?>
		</code>

		<?php 
		if(!empty($images)):
		foreach ($images as $image) :?>
			<code><img src="<?= site_url('uploads/cleared/'.$image['file_name']);?>" ></code>
		<?php endforeach; endif;?>

		<p>Error Result</p>
		<code>
			<?php 
			if(!empty($errors)):
				foreach ($errors as $error) :
				 echo $error.'<br/>';
				endforeach;
			endif;
			?>
		</code>

		<p class="credits">Credits : Muhammad Ridwan Na'im, MTCNA & Anrie 'Riesurya' Suryaningrat, S.Si, M.TI, Apt.</p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>