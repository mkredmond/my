<?php

use App\Flash\Flash;

/**
 * [flash description]
 * @param  [type] $title   [description]
 * @param  [type] $message [description]
 * @return [type]          [description]
 */
function flash($title = null, $message = null)
{
	$flash = app(Flash::class);

	if(func_num_args() == 0){
		return $flash;
	}

	return $flash->info($title, $message);
}