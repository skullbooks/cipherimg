<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jkrille
 * Date: 20.12.12
 * Time: 12:34
 * To change this template use File | Settings | File Templates.
 */

echo '<h1>CIPHERimg</h1>';


$splitArray = array();

$width = 10;
$height = 10;

$source = @imagecreatefromjpeg( "../images/uploaded/test.jpg" );
$source_width = imagesx( $source );
$source_height = imagesy( $source );
$source_x = ceil($source_width / $width);
$source_y = ceil($source_height / $height);

for( $x = 0; $x < $source_x; $x++)
{
	for( $y = 0; $y < $source_y; $y++)
	{
		$im = @imagecreatetruecolor( $width, $height );
		imagecopyresized( $im, $source, 0, 0,
			$x * $width, $y * $height, $width, $height,
			$width, $height );

		$split = new stdClass();
		$split->x = $x;
		$split->y = $y;
		$split->image = $im;

		$splitArray[] = $split;
	}
}

shuffle($splitArray);

$newImage = imagecreatetruecolor($source_width, $source_height);

$newX = 0;
$newY = 0;

$html = '<style type="text/css">#test { width: '.$source_width.'px; height: '.$source_height.'px; position: relative; } #test div { position: absolute; width: '.$width.'px; height: '.$height.'px; background-image: url(http://cncws2.dev.diloc.de/git/cipherimg/images/download/test.png); }</style><div id="test">';

foreach ($splitArray as $split)
{
	if ($newX >= $source_x)
	{
		$newX = 0;
		$newY++;
	}
	$html .= '<div style="left: '.(($split->x)*$width).'px; top: '.(($split->y)*$height).'px; background-position: -'.(($newX)*$width).'px -'.(($newY)*$height).'px;"></div>';
	imagecopy($newImage, $split->image, $newX*$width, $newY*$height, 0, 0, $width, $height);
	$newX++;
}

$html .= '</div>';

imagepng($newImage, "../images/download/test.png");

echo '<img src="http://cncws2.dev.diloc.de/git/cipherimg/images/download/test.png" />';

echo $html;


