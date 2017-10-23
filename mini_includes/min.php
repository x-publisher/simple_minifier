
<?php
/*    
    Name : Simple Minifier
	  version: 1.0 
	  This document is licensed as free software under the terms of the
	  MIT License: http://www.opensource.org/licenses/mit-license.php
	  This plugin uses online webservices from javascript-minifier.com and cssminifier.com
	  This services are property of Andy Chilton, http://chilts.org/  
*/

    function minifyJS($arra){
		minify_js_data($arra, 'https://javascript-minifier.com/raw');
	}
	
	function minifyCSS($arra){
		minify_css_data($arra, 'https://cssminifier.com/raw');
	}

	function minify_css_data($arra, $url) {
		foreach ($arra as $key => $value) {
            $cssData = "";
            $cssData .= file_get_contents($key);
            $comment = "\n" . '/*==================' .$key. '===============*/' . "\n";
            $combined = $comment . getMinified($url, $cssData);            
            file_put_contents('../minify/minify.css', $combined . PHP_EOL , FILE_APPEND | LOCK_EX);
		}
  			echo '<p><font color="green">CSS Compressed!</font> You can copy and add into your page</p><textarea style="width:100%; padding:10px;" rows="2"><link rel="stylesheet" type="text/css" href="minify/minify.css"></textarea><br><a href="../minify/minify.css" target="_blank">Check minified CSS File</a></p><hr>';    
    }

	function minify_js_data($arra, $url) {
		foreach ($arra as $key => $value) {
            $jsData = "";
            $jsData .= file_get_contents($key);
            $comment = "\n" . '/*==================' .$key. '===============*/' . "\n";
            $combined = $comment . getMinified($url, $jsData);            
            file_put_contents('../minify/minify.js', $combined . PHP_EOL , FILE_APPEND | LOCK_EX);
		}
  			echo '<p><font color="green">JS Compressed!</font> You can copy and add into your page</p><textarea style="width:100%; padding:10px;" rows="2"><script type="text/javascript" src="minify/minify.js"></script></textarea><br><a href="../minify/minify.js" target="_blank">Check minified JS File</a></p>';      
	}

	function getMinified($url, $content) {
		$postdata = array('http' => array(
	        'method'  => 'POST',
	        'header'  => 'Content-type: application/x-www-form-urlencoded',
	        'content' => http_build_query( array('input' => $content) ) ) );
		return file_get_contents($url, false, stream_context_create($postdata));
	}
	
?>
