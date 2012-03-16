<?php
$arrTostr = array();
$arrTostr['a']['b'] = '';
if(empty($arrTostr)){
	echo 'ok';
}else{
	echo 'no';
}
echo '<br/>';
if(isset($arrTostr['a']['b'])){
	echo 'pok';
}else{
	echo 'pno';
}
