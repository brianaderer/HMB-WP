<?php
//set up our custom error logging first
function logger( mixed $input ): void {
	error_log( print_r( $input, true ) );
}

//now include all the rest of our code

function return_dirs( $path ): array {
	return glob( $path, GLOB_ONLYDIR );
}
function return_files( $path ): array {
	return glob( $path );
}

$path =  trailingslashit( get_stylesheet_directory() ) . 'includes/*' ;
$dirs = return_dirs( $path );
foreach ( $dirs as $dir ):
		$file = array_filter( return_files( $path . '/*' ), 'is_file' );
		if(  $file[0] ):
			require_once( $file[0] );
		endif;
	endforeach;


//Pencils Down. No more Edits to the Functions file. Make an Include.