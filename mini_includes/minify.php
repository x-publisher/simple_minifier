<?php
/*    
      Name : Simple Minifier
	  version: 1.0 
	  This document is licensed as free software under the terms of the
	  MIT License: http://www.opensource.org/licenses/mit-license.php
	  This plugin uses online webservices from javascript-minifier.com and cssminifier.com
	  This services are property of Andy Chilton, http://chilts.org/  
*/

?>
<html><head><title>Simple Minifier</title><style>body{background:#f6f7f9;}.wrap{max-width:400px; margin:30px auto; padding:10px;}.wrap h2{text-align:center;}.note{color:red;font-size:12px;}.footer{margin:100px auto; text-align:center; width:100%;}</style></head><body><div class="wrap"><h2>Simple Minifier<span style="font-size:10px; color:#555;">V-1.0</span></h2><p align="right"><a href="mini_includes/documentation.html" target="_blank">Documentaion</a></p>

<?php
echo '<div class="wrap">';
	include_once("min.php");


/* POST data to CSS array */
if(isset($_POST['css_data'])){
$css_data = explode("\n", $_POST['css_data']);
foreach ($css_data as $css_file) {
    if(!empty($css_file) && $css_file !== null ){
    $c_input = '../css/'.trim($css_file);
    $c_output = '../minify/'.trim($css_file); 
    $cssArray[$c_input] = $c_output;
    }
}
}


/* POST data to JS array */
if(isset($_POST['js_data'])){
$js_data = explode("\n", $_POST['js_data']);
foreach ($js_data as $js_file) {
    if(!empty($js_file) && $js_file !== null ){
    $j_input = '../js/'.trim($js_file);
    $j_output = '../minify/'.trim($js_file); 
    $jsArray[$j_input] = $j_output;
    }
}
}

/* HTML minify function */
$html_dir = '../html'; // html files directory
function minifyHTML($dir){
    echo '<p><font color="green">HTML Compressed!</font> Check out ';
foreach (new DirectoryIterator($dir) as $file) {
  if ($file->isFile()) {
      $sp_exten = pathinfo($file);
      $extension =  $sp_exten['extension'];
      if ($extension === 'html'){
        echo ' <b>' . $file . '</b> ';
        $htmlFile = array(
           'filename' => $file,
        ); 
      }
  }
        if(!empty($htmlFile['filename'])){
              $htmlData = "";
              $htmlData = file_get_contents($dir.'/'. $htmlFile['filename']);
              //remove redundant (white-space) characters
                $replace = array(
                    //remove tabs before and after HTML tags
                    '/\>[^\S ]+/s'   => '>',
                    '/[^\S ]+\</s'   => '<',
                    //shorten multiple whitespace sequences; keep new-line characters because they matter in JS!!!
                    '/([\t ])+/s'  => ' ',
                    //remove leading and trailing spaces
                    '/^([\t ])+/m' => '',
                    '/([\t ])+$/m' => '',
                    // remove JS line comments (simple only); do NOT remove lines containing URL (e.g. 'src="http://server.com/"')!!!
                    '~//[a-zA-Z0-9 ]+$~m' => '',
                    //remove empty lines (sequence of line-end and white-space characters)
                    '/[\r\n]+([\t ]?[\r\n]+)+/s'  => "\n",
                    //remove empty lines (between HTML tags); cannot remove just any line-end characters because in inline JS they can matter!
                    '/\>[\r\n\t ]+\</s'    => '><',
                    //remove "empty" lines containing only JS's block end character; join with next line (e.g. "}\n}\n</script>" --> "}}</script>"
                    '/}[\r\n\t ]+/s'  => '}',
                    '/}[\r\n\t ]+,[\r\n\t ]+/s'  => '},',
                    //remove new-line after JS's function or condition start; join with next line
                    '/\)[\r\n\t ]?{[\r\n\t ]+/s'  => '){',
                    '/,[\r\n\t ]?{[\r\n\t ]+/s'  => ',{',
                    //remove new-line after JS's line end (only most obvious and safe cases)
                    '/\),[\r\n\t ]+/s'  => '),',
                    //remove quotes from HTML attributes that does not contain spaces; keep quotes around URLs!
                    '~([\r\n\t ])?([a-zA-Z0-9]+)="([a-zA-Z0-9_/\\-]+)"([\r\n\t ])?~s' => '$1$2=$3$4', //$1 and $4 insert first white-space character found before/after attribute
                );
                $htmlData = preg_replace(array_keys($replace), array_values($replace), $htmlData);

                //remove optional ending tags (see http://www.w3.org/TR/html5/syntax.html#syntax-tag-omission )
                $remove = array(
                    '</option>', '</li>', '</dt>', '</dd>', '</tr>', '</th>', '</td>'
                );
                $htmlData = str_ireplace($remove, '', $htmlData);
                file_put_contents('../'.$htmlFile['filename'], $htmlData);
        }
}
echo ' files in root folder.</p><hr>';
}




$cssExist = '../minify/minify.css';
$jsExist = '../minify/minify.js';

if(isset($_POST['html_status'])){ 
    echo 'HTML function disable!<br>';
}else{
minifyHTML($html_dir);
}

if (file_exists($cssExist)) {
    echo '<p class="note">CSS failed to compressed! <br>The file <b>minify.css</b> exists in <b>"/minify/"</b> folder, please delete it first.</p><hr>';
}else {
    if(isset($_POST['css_status'])){ 
    echo 'CSS function disable!<br>';
    }else{
        minifyCSS($cssArray);
    }
}

if (file_exists($jsExist)) {
    echo '<p class="note">JS failed to compressed! <br>The file <b>minify.js</b> exists in <b>"/minify/"</b> folder, please delete it first.</p>';
} else {
if(isset($_POST['js_status'])){
    echo 'JS function disable!<br>';
}else{
    minifyJS($jsArray);
}
}
?>
<div class="footer">Reach me : <a href="https://fb.com/ai.tgi" target="_blank">fb</a> | <a href="https://www.ronaldaug.ml" target="_blank">https://www.ronaldaug.ml</a></div>
</div></body></html>
