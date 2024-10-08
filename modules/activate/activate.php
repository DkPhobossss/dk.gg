<?php

$this->args( 'user_id' , 'activated_hash' );

if ( Auth::id() )
{
    _Error::render( _Error::FORBIDDEN );
}

if ( !DB\User::update( array('activated' => 1) , array(
                                                        'id' => $this->user_id,
                                                        'activated_hash' => $this->activated_hash
                                                    )
))
{
    _Error::render( _Error::NOT_FOUND );
}