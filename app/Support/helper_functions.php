<?php

use Illuminate\Database\Eloquent\Model;

function lang_english(): bool
{
	$request = request();
	$pref = "ur";

    if (($p = $request->cookie('lang_pref')) || ($p = $request->header('X-Lang-Pref'))) {
    	if ($p == 'en' || $p == 'ur') {
	        $pref = $p;
    	}
    }
    
    return $pref == "en";
}

function lang_urdu(): bool
{
	$request = request();
	$pref = "ur";

    if (($p = $request->cookie('lang_pref')) || ($p = $request->header('X-Lang-Pref'))) {
    	if ($p == 'en' || $p == 'ur') {
	        $pref = $p;
    	}
    }

    return $pref == "ur";
}

function convert_to_lang_pref($data)
{
	$is_en = lang_english();
	if ($data instanceof Model) {

		foreach ($data->getAttributes() as $key => $value) {
			if ($is_en && ($pos = strrpos($key, "_en", -1))) {
				$new_key = substr($key, 0, $pos);
				$data[$new_key] = $value;
				// var_dump($key, $new_key, $value);
				// echo "<br>";
			} else if (!$is_en && ($pos = strrpos($key, "_ur", -1))) {
				$new_key = substr($key, 0, $pos);
				$data[$new_key] = $value;
				// var_dump("=======", $key, $new_key, $value);
				// echo "<br>";
			}
		}
	}


	if ($data instanceof \Illuminate\Database\Eloquent\Collection) {

		foreach ($data as $d) {
			if ($d instanceof Model) {
				convert_to_lang_pref($d);
			}
		}
	}
}