<?php
/*    
      Name : Simple Minifier
      Author: Ronald Aug
	  version: 1.0 
	  This document is licensed as free software under the terms of the
	  MIT License: http://www.opensource.org/licenses/mit-license.php
	  This plugin uses online webservices from javascript-minifier.com and cssminifier.com
	  This services are property of Andy Chilton, http://chilts.org/  
*/
$html_dir = 'html'; // css files directory
$css_dir = 'css'; // css files directory
$js_dir = 'js'; // js files directory
?>

<html><head><title>Simple Minifier</title><style>body{background:#f6f7f9;}.wrap{max-width:400px; margin:30px auto; padding:10px;}input[type="submit"]:hover{background:#000; cursor:pointer;}input[type="submit"]{padding:10px 40px; color:#fff; background:#333; border:0; border-radius:20px; -moz-border-radius:20px; -webkit-border-radius:20px;}.note{color:red; font-size:12px;}.wrap h2{text-align:center;}.footer{margin:100px auto; text-align:center; width:100%;}</style></head><body><div class="wrap"><h2>Simple Minifier<span style="font-size:10px; color:#555;">V-1.0</span></h2><p align="right"><a href="mini_includes/documentation.html" target="_blank">Documentaion</a></p>
<?php
/* LIST ALL HTML FILES */
function listHTML($dir){
echo '<br>Files under /html/ Folder<br><textarea style="padding:10px; width:100%;" rows="5">';
foreach (new DirectoryIterator($dir) as $file) {
  if ($file->isFile()) {
      $sp_exten = pathinfo($file);
      $extension =  $sp_exten['extension'];
      if ($extension === 'html'){
          echo $file . "\n";
      }
}
}
echo '</textarea><br>';
}

/* LIST ALL CSS FILES */
function listCSS($dir){
echo '<br><p class="note">Note: All CSS files will be compressed into a single file. So, make sure you order them correctly inside the below box.</p>Files under /css/ Folder<br><textarea name="css_data" style="padding:10px; width:100%;" rows="5">';
foreach (new DirectoryIterator($dir) as $file) {
  if ($file->isFile()) {
      $sp_exten = pathinfo($file);
      $extension =  $sp_exten['extension'];
      if ($extension === 'css'){
          echo $file . "\n";
      }
}
}
echo '</textarea><br>';
}

/* LIST ALL JS FILES */
function listJS($dir){
echo '<br><p class="note">Note: All JS files will be compressed into a single file. So, make sure you order them correctly inside the below box.</p>Files under /js/ Folder<br><textarea name="js_data" style="padding:10px; width:100%;" rows="5">';
foreach (new DirectoryIterator($dir) as $file) {
  if ($file->isFile()) {
      $sp_exten = pathinfo($file);
      $extension =  $sp_exten['extension'];
      if ($extension === 'js'){
          echo $file . "\n";
      }
}
}
echo '</textarea><br>';
}

if(!$sock = @fsockopen('www.google.com', 80)){
    echo '<p>This plugin uses an online service provided by Andy Chilton, http://chilts.org/.<br> So, Please connect to the internet.</p>';
}else{
    echo '<form action="mini_includes/minify.php" method="POST"><br>Select to disable | <input type="checkbox" name="html_status" value="off"> HTML | <input type="checkbox" name="css_status" value="off"> CSS | <input type="checkbox" name="js_status" value="off"> JS';
    listHTML($html_dir);
    echo '<br>';
    listCSS($css_dir);
    echo '<br>';
    listJS($js_dir);
    echo '<p align="center"><input type="submit" value="Minify"><p></form>';
}
?>
<div class="footer">Reach me : <a href="https://fb.com/ai.tgi" target="_blank">fb</a> | <a href="https://www.ronaldaug.ml" target="_blank">https://www.ronaldaug.ml</a></div>
</div></body></html>
