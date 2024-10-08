<?php

class Image extends File
{

    static protected $extensions = array (
        'image/gif' => 'gif',
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
    );
    static protected $options = array (
        'max_size' => '5000000', //5MB
        'min_size' => 1,
    );
    
    private $CWorker;

    public static function temp( $filename, $t = false )
    {
        $result = new static ( );
        $result->row[ 'filename' ] = $t ? ( Server::temp_dir() . $filename ) : $filename;

        $result->check_extension();
        $result->CWorker = new Imagick(  );
        
        $result->CWorker->readImage( $result->row[ 'filename' ] );

        return $result;
    }

    public function gallery_format()
    {
        switch ( $this->extension() )
        {
            case 'gif' : 
                {
                    /*$this->CWorker->setImageBackgroundColor( 'white' );
                    $this->CWorker = $this->CWorker->flattenImages();

                    $this->CWorker->setImageFormat( 'jpg' );
                    $this->type( 'image/jpeg' );
                    */
                    break;
                }
        }

        return $this;
    }

    public function ckeckXY( $min_width , $min_height )
    {
        if ( $this->width() < $min_width )
        {
            throw new Exception\User( 'Min width : ' . $min_width );
        }

        if ( $this->height() < $min_height )
        {
            throw new Exception\User( 'Min height : ' . $min_height );
        }

        return $this;
    }

    private function set_sizes()
    {
        $size = getimagesize( $this->filename() );
        $this->row[ 'width' ] = $size ? $size[ 0 ] : null;
        $this->row[ 'height' ] = $size ? $size[ 1 ] : null;
    }

    public function width()
    {
        if ( !array_key_exists( 'width', $this->row ) )
        {
            $this->set_sizes();
        }

        return $this->row[ 'width' ];
    }

    public function height()
    {
        if ( !array_key_exists( 'height', $this->row ) )
        {
            $this->set_sizes();
        }

        return $this->row[ 'height' ];
    }

    private function resize_filter()
    {
        return Imagick::FILTER_CATROM;
    }

    public function resize( $width, $height, $bestfit = false )
    {
        if ( $this->width() <= $width && $this->height() <= $height )
        {
            
        }
        else
        {
            $this->CWorker->resizeImage( $width, $height, $this->resize_filter(), 1, $bestfit);
            $this->set_sizes();
            $this->_null();
        }
        
        return $this;
    }
    
    public function resize_region( $width, $height, $type = 'center' )
    {
        if ( $this->width() <= $width && $this->height() <= $height )
        {
        
        }
        else
        {
            $this->CWorker->cropThumbnailImage( $width, $height );
            
            $this->set_sizes();
            $this->_null();
        }
        
        return $this;
    }
    
    private function _null()
    {
        unset( $this->row['size'] );
        unset( $this->row['hash'] );
    }
    
    
    public function save( $new_path )
    {
        $this->filename( $new_path . $this->hash( $this->CWorker->getImageBlob() ) . '.' . $this->extension() );

        $this->CWorker->writeImage( $new_path . $this->system_name() );
        
        return $this;
    }
    
    
    public function __clone() 
    {
        $this->row = array( 'filename' => $this->row[ 'filename' ] );
        
        $this->CWorker = new Imagick( $this->row[ 'filename' ] );
    }
}