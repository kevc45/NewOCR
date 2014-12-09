<?php

/**
* A simple wrapper for newocr.com
*
* Hi
*
* @package OCR
* @license http://opensource.org/licenses/MIT MIT
* @author Kevin Cushman
* @version 1.0.0b
*/
class OCR
{
	private $api = '';

	function __construct($api)
	{
		$this->api = $api;
	}

	/**
	* Gets the text from an image
	*
	* @param string $filename Location of file to upload
	* @param int $pageNum Page number in the multi-page documents such as PDF, TIFF, DJVU
	* @param Modes $psm Page segmentation mode
	* @param Langs $lang Language used for OCR
	* @param Rotation $rotation Image rotation in degrees
	*
	* @return mixed
	*/
	public function get_text($filename, $pageNum=1, $psm = Modes::AUTO, $lang=Langs::ENGLISH, $rotation = Rotation::OFF)
	{
		$id = $this->upload_image($filename);

		if($id === FALSE)
		{
			return false;
		}

		$text = $this->recognize($id, $pageNum, $psm, $lang, $rotation);

		return $text;
	}

	/**
	* Gets the text from an image
	*
	* @param string $fileID File ID obtained from upload_image
	* @param int $pageNum Page number in the multi-page documents such as PDF, TIFF, DJVU
	* @param Modes $psm Page segmentation mode
	* @param Langs $lang Language used for OCR
	* @param Rotation $rotation Image rotation in degrees
	*
	* @return mixed
	*/
	public function recognize($fileID='abc123', $pageNum=1, $psm = Modes::AUTO, $lang=Langs::ENGLISH, $rotation = Rotation::OFF)
	{
		/*
			Good:
			{"status":"success","data":{"text":"The quick brown fox...","progress":100}
			
			Bad:
			{"status":"error","message":"You already recognized image less than 1 minute ago"}
		*/

		$data = $this->call(array(CURLOPT_URL => 'http://api.newocr.com/v1/ocr?key=' . $this->api . '&file_id=' . $fileID . '&page=' . $pageNum . '&lang=' . $lang . '&psm=' . $psm));
		
		if($data === FALSE)
		{
			return false;
		}

		$data = str_replace("\r\n", '', $data); //wat... WHO USES A WINDOWS SERVER!
		$data = json_decode($data);
		
		if( (strtolower($data->status) == 'success' ? true : false)  ) //if success
		{
			return $data->data->text;
		}
		else
		{
			return false;
		}
	}


	/**
	* Calls the API
	*
	* @param array $opts cURL options 
	*
	* @return mixed
	*/
	public function call($opts=array())
	{
		$ch = curl_init();

		$opts[CURLOPT_RETURNTRANSFER] = true;

		curl_setopt_array($ch, $opts);

		$result = curl_exec($ch);

		$curlInfo = curl_getinfo($ch);
		$responseCode = (int)$curlInfo['http_code'];
		
		curl_close($ch);

		if($responseCode == 400)
		{
			return false;
		}

		return $result;
	}

	/**
	* Uploads an image used for recognition later
	*
	* @param string $filename Location of file to upload  
	*
	* @return string
	*/
	public function upload_image($filename)
	{
		/*
			Good: 
			{"status":"success","data":{"file_id":"4c8fe7d5a99d6a13edefd3dd9f1682f8","pages":1}}

			Bad:
			{"status":"error","message":"You have already uploaded the file less than 1 minute ago"}
		*/
		$filename = realpath($filename);

		if(!file_exists($filename))
		{
			return false;
		}

		$opts = array(
			CURLOPT_URL => 'http://api.newocr.com/v1/upload?key=' . $this->api,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => array('file' => '@' . $filename));

		$data = $this->call($opts);

		if($data === FALSE)
		{
			return false;
		}

		$data = json_decode($data);

		if( (strtolower($data->status) == 'success' ? true : false)  ) //if success
		{
			return $data->data->file_id;
		}
		else
		{
			return false;
		}
	}
}

abstract class Langs
{
	const ENGLISH = 'eng';

	//I'm lazy. :P
}

abstract class Modes
{
	const AUTO = 3;
	const UNIFORM = 6;
}

abstract class Rotation
{
	const OFF = 0; //270 also should work
	
	const RIGHT = 90;
	const LEFT = -90; //Don't know if this works

	const UPSIDE_DOWN = 180;
}