<?php
//no direct file access
if(count(get_included_files()) ==1){$z="HTTP/1.0 404 Not Found";header($z);die($z);}


// this is by far the worst Hack i ever done
// This complete idiotic piece of code needs $admin but is a frontend module !!!
// Who ever programmed this piece of shit in first place must be completely braindead !!!
// UNBELIEVABLE!!!!
$admin=&$wb;

function language_menu($ext='txt') {
    // Work-out we should check for existing page_code
    if (defined('PAGE_LANGUAGES') && (PAGE_LANGUAGES==true)) {
        global $database;

        if (!preg_match("/jpg|png|gif|txt|TXT/", $ext)) $ext='txt';
        include_once __DIR__.'/lang.functions.php';
        include_once(get_module_language_file(basename(dirname(__FILE__))));
        $langIcons  = array();
        echo '<div id="langmenu">'.PHP_EOL;
        $langIcons = set_language_icon(PAGE_ID, $ext);

        if( sizeof($langIcons) > 1 ) {
            foreach( $langIcons as $key=>$value ) {
                print $value;
            }
        }
        print "\t".'</div>'.PHP_EOL;
    }
    return true;
}

function language_array() {
    
    // Work-out we should check for existing page_code
    if (defined('PAGE_LANGUAGES') && (PAGE_LANGUAGES==true)) {
        global $database;
        include_once __DIR__.'/lang.functions.php';
        include_once(get_module_language_file(basename(dirname(__FILE__))));
        
        $aList = set_language_array(PAGE_ID);
    }
    
    return $aList;
}

/**
    @brief Display googles  hreflang links

    @param bool $output Echo content on true , return content on false
    @param bool $show_recent Show recent Page [true|false]
    @param bool $show_x_default Show x-default [true|false]
    @return string Returns generated lines only on $output===true

*/
function language_hreflang ($output=true, $show_recent=true, $show_x_default=true){
    // Used for prefered Render type HTML5 or XHTML ... 
    $end_tag=" /";

    if (defined('WB_RENDER') AND WB_RENDER !="xhtml" )
        $end_tag=" ";

    // output var
    $out="\n";

    if ($show_x_default==true) {
        $out.="\t\t".'<link rel="alternate" hreflang="x-default" href="'.WB_URL.'" '.$end_tag.'>'.PHP_EOL;
    }

    // Lets walk the language array 
    $aLangLinks = language_array();
	foreach($aLangLinks as $key=>$link){
        // If recent Language schould not be linked
		if($show_recent!==true AND LANGUAGE == $key ) continue; 
		$out.="\t\t".'<link rel="alternate" hreflang="'.strtolower($key).'" href="'.$link['url'].'" '.$end_tag.'>'.PHP_EOL;
	}
    if ($output===true) echo $out;
    else                return $out;
}

