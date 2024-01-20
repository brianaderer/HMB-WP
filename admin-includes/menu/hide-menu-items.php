<?php
if( !current_user_can( 'administrator' ) ):
    remove_menu_page( 'themes.php' );
    remove_menu_page( 'plugins.php' );
    remove_menu_page( 'users.php' );
    remove_menu_page( 'tools.php' );
    remove_menu_page( 'options-general.php' );
    remove_menu_page( 'edit.php?post_type=acf-field-group' );
    remove_menu_page( 'admin.php?page=graphiql-ide' );
    remove_menu_page( 'tools.php' );
endif;