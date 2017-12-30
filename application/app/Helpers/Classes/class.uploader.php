<?php

namespace App\Helpers\Classes;

use File;

//use Intervention\Image\ImageManager;

/**
* This uploader will help upload,delete,resize files 
*/
class Uploader
{
	
	function __construct()
	{
	}

	public static function upload($file,$path,$config=[]){

		if(!file_exists($path)){
			mkdir($path, 0755, true);
		}

		$width = !empty($config['width']) ? $config['width'] : 0;
		$height = !empty($config['height']) ? $config['height'] : 0;
		$ratio = !empty($config['ratio']) ? $config['ratio'] : 0;
		$fileName = !empty($config['file_name']) ? $config['file_name'] : '';

		$extension = $file->getClientOriginalExtension(); // getting image extension

	    if(empty($fileName)){
	    	$fileName = str_slug($file->getClientOriginalName()).'-'.time().'.'.$extension;
	    }else{
	    	$fileName = $fileName.'.'.$extension;
	    }

	    $file->move($path, $fileName); // uploading file to given path
	    
	    return $path.'/'.$fileName;


	    //TODO: for resizing image
		// create instance
		/*$img = new ImageManager();
        $img->make($file);

		if(!empty($width) && !empty($height)){
			
			// resize image to fixed size
			$img->resize($width, $height);

		}elseif(!empty($width) && empty($height)){

			if($ratio){
				// resize the image to a width of 300 and constrain aspect ratio (auto height)
				$img->resize($width, null, function ($constraint) {
				    $constraint->aspectRatio();
				});
			}else{
				// resize only the width of the image
				$img->resize($width, null);
			}

		}elseif(empty($width) && !empty($height)){

			if($ratio){
				// resize the image to a height of 200 and constrain aspect ratio (auto width)
				$img->resize(null, $height, function ($constraint) {
				    $constraint->aspectRatio();
				});
			}else{
				// resize only the height of the image
				$img->resize(null, $height);
			}
		}*/		
	}

	public static function delete($path){
		if(file_exists($path)){
			return File::delete($path);
		}else{
			return false;
		}
	}
}