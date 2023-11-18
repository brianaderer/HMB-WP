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
$admin_path =  trailingslashit( get_stylesheet_directory() ) . 'admin_includes/*' ;
function enqueue_includes( string $path ):void{
	$dirs = return_dirs( $path );
	foreach ( $dirs as $dir ):
			$files = array_filter( return_files( $path . '/*' ), 'is_file' );
			if(  $files ):
				foreach( $files as $file ):
					if( $file ):
						require_once( $file );
					endif;
				endforeach;
			endif;
		endforeach;
}

enqueue_includes( $path );
if( is_admin() ):
	enqueue_includes( $admin_path );
endif;
//Pencils Down. No more Edits to the Functions file. Make an Include.