<?php
namespace DB\Abstr;

abstract class Video
{

    abstract public function get_from_server( $channel, $start, $count );
    abstract public function iframe( $id );
    abstract public function playlists( $channel , $start = 1, $count = 25 );
    abstract public function comment_link( $id );
   
}