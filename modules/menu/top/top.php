<?
$this->args( 'url' , 'separator' , 'extra', 'error' );

$this->menu = array(
    array( 'url' =>  ''    , 'name' => __( 'Root' ) ),
    array( 'url' =>  'learn', 'name' => __( 'Learn' ) ),
    array( 'url' =>  'digitize', 'name' => __( 'Digitize' ) ),
    array( 'url' =>  'watch', 'name' => __( 'Watch' ) ),
    array( 'url' =>  'read', 'name' => __( 'Read' ) ),
    array( 'url' =>  'about', 'name' => __( 'About_me' ) ),
    array( 'url' => 'ti_10', 'name' => __( 'TI-10' )   , 'disabled' => true ),
);

if ( isset ( $this->extra ) )
{
    $this->menu = array_merge( $this->menu , $this->extra );
}
