<?php
//set up our custom error logging first
function logger( mixed $input ): void {
	error_log( print_r( $input, true ) );
}

//now include all the rest of our code

//composer files. theme isn't working? try running composer install?
require_once( 'vendor/autoload.php' );
require_once( 'test/test.php' );

$dotenv = Dotenv\Dotenv::createImmutable( __DIR__ );
$dotenv->load();

function return_dirs( $path ): array {
	return glob( $path, GLOB_ONLYDIR );
}
function return_files( $path ): array {
	return glob( $path );
}

$blocks_path =  trailingslashit( get_stylesheet_directory() ) . 'blocks/*';
$blocks_dirs = return_dirs( $blocks_path );

foreach( $blocks_dirs as $blocks_dir ):
		$array = explode( '/', $blocks_dir );
		$slug = array_pop( $array );
		$path = $blocks_dir . '/' . $slug . '.php';
		if( file_exists( $path ) ):
				require_once( $path );
			endif;
	endforeach;

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