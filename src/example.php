<?php

require_once 'ocr.php';

$OCR = new OCR('API KEY');

$result = $OCR->get_text('test.png');

if($result !== FALSE)
{
	echo $result;
}
else
{
	echo 'Could not get text.';
}

echo PHP_EOL;