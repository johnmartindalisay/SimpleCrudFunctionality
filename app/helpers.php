<?php 


 if (!function_exists('dd')) {
 	
 	function dd($array){

		echo "<pre>";
        print_r($array);
        echo "</pre>";
 	}
 }


