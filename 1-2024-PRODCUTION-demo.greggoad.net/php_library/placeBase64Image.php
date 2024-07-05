<?php 
function PlaceBase64Image($data, $dest){
	file_put_contents($dest, base64_decode(explode(',',$data)[1]));
}
?>