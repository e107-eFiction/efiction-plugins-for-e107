<?php
 
//e107::lan('efiction'); loaded in e_module
 
require_once e_PLUGIN."efiction/includes/queries.php";

$newcaptcha = efiction::settings('captcha');

if($newcaptcha && extension_loaded('gd'))
{
	define('USE_IMAGECODE', TRUE);
}
else
{
	define('USE_IMAGECODE', FALSE);
}
 
e107::css('efiction', 'vendors/select2.min.css');
e107::css('efiction', 'vendors/select2-bootstrap.min.css');
e107::js('footer', e_PLUGIN.'efiction/vendors/select2.full.js', 'jquery');


$code = '
    if ($().select2) {
      $(".select2-single, .select2-multiple").select2({
        theme: "bootstrap",
        placeholder: "",
        width: "100%",  
        maximumSelectionSize: 10,
        containerCssClass: ":all:"
      });

	  $(".select2-simple").select2({
        theme: "bootstrap",
        placeholder: "",
        minimumResultsForSearch: Infinity,  
       
        containerCssClass: ":all:"
      });

    }';


e107::js('footer-inline', $code, 'jquery');
 
 
if(!isset($_GET['action']) || $_GET['action'] != "printable") {
  e107::js('url',  e_PLUGIN."efiction/includes/javascript.js" , 'jquery' );
  if(!empty($tinyMCE)) {
     
   
  }
}
 
 
//e107::js('url', _BASEDIR."tinymce/js/tinymce/tinymce.min.js" , 'jquery' );
e107::js('footer', 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.11/tinymce.min.js'); 

$mceScript =  "
 
tinymce.init({
     document_base_url : '".SITEURL."',
	 selector: 'textarea.useeditor',
     menubar: false,
     language: 'en',
     skin: 'lightgray',
	 min_height: 200,
     theme: 'modern',
	 plugins: [
	    'autolink lists link image charmap paste preview hr anchor pagebreak',
	    'searchreplace wordcount visualblocks visualchars code fullscreen',
	    'insertdatetime media nonbreaking save table contextmenu directionality',
	    'emoticons  textcolor colorpicker textpattern toc textcolor table code '
	 ],
	toolbar1: 'undo redo | styleselect | bold italic underline strikethrough | link | alignleft aligncenter alignright alignjustify',
	toolbar2: 'preview | bullist numlist | forecolor backcolor | code|  wordcount',
    external_plugins: {'e107':'".e_PLUGIN_ABS."tinymce/plugins/e107/plugin.js'},
	image_advtab: true,
	extended_valid_elements: 'i[*], object[*],embed[*],bbcode[*]',
	convert_fonts_to_spans: true,
    });
 
";
 

 e107::js('footer-inline',$mceScript,'jquery' );

 

 