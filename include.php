<?php
//no direct file access
if(count(get_included_files()) ==1){$z="HTTP/1.0 404 Not Found";header($z);die($z);}



if(!function_exists('language_menu'))
{
    function language_menu($ext='gif')
    {
	    global $database;
		$mod_path = str_replace('\\', '/', dirname(__FILE__));
		$mod_rel = str_replace($_SERVER['DOCUMENT_ROOT'],'',str_replace('\\', '/', $mod_path ));
		$mod_name = basename($mod_path);
		include('lang.functions.php');
	    // Work-out we should check for existing page_code
        $field_set = $database->field_exists(TABLE_PREFIX.'pages', 'page_code');
	    if (defined('PAGE_LANGUAGES') && (PAGE_LANGUAGES==true) && ($field_set==true))
	    {
			include(get_module_language_file($mod_name));
			$langIcons  = array();
			print '<div id="langmenu">'.PHP_EOL;
			$langIcons = set_language_icon(PAGE_ID,$ext );

            if( sizeof($langIcons) > 1 )
            {
				foreach( $langIcons as $key=>$value )
				{
					print $value;
				}
			}
		}
		print '</div>'.PHP_EOL;
	    return true;
    }
    return false;
}
//
