<?php

ini_set( "display_errors", TRUE );
error_reporting( E_ALL );

if( array_key_exists( "HTTP_USER_AGENT", $_SERVER )
&& strpos( $_SERVER[ 'HTTP_USER_AGENT' ], "GitHub" ) !== FALSE
&& array_key_exists( "HTTP_X_GITHUB_EVENT", $_SERVER )
&& $_SERVER[ 'HTTP_X_GITHUB_EVENT' ] == "push"
&& array_key_exists( "HTTP_X_GITHUB_DELIVERY", $_SERVER )
&& array_key_exists( "payload", $_POST ) ) {

$s = shell_exec( 'git reset --hard 2>&1' )
. "\n" . shell_exec( 'git pull 2>&1' );

$f = fopen( dirname( __FILE__ ) . "/push.txt", "w" );
fwrite( $f, "\n" . $_POST[ 'payload' ] . "\n\n\n"
. print_r( json_decode( $_POST[ 'payload' ], TRUE ), TRUE )
. "\n\n\n" . $s . "\n\n" );
fclose( $f );


} else {

echo "nope.";

}
