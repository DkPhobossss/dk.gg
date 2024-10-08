<?php

class File
{
    protected $row;
    
    static protected $extensions = array (
        'image/bmp' => 'bmp',
        'image/gif' => 'gif',
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'cfg' => 'cfg'
    );
    
    static protected $options = array (
        'max_size' => '50000000', //50MB
        'min_size' => 1,
    );
    
    

    static public function temp( $filename , $t = false )
    {
        $result = new static ( );
        $result->row[ 'filename' ] = $t ? ( Server::temp_dir() . $filename ) : $filename;

        $result->check_extension ();

        return $result;
    }

    public function size()
    {
        if ( !isset( $this->row[ 'size' ] ) )
        {
            $this->row[ 'size' ] = filesize ( $this->filename () );
        }
        
        return $this->row[ 'size' ];
    }
    
    public function filename( $new_filename = null )
    {
        if ( isset( $new_filename ) )
        {
            $this->row[ 'filename' ] = $new_filename;
        }
        
        return $this->row[ 'filename' ];
    }

    public static function tempdir()
    {
        return \Server::path ( 'uploads', 'tmp' );
    }

    public function hash( $content = null )
    {
        if ( isset( $content ) )
        {
            $this->row[ 'hash' ] = sha1( $content );
        }
        elseif ( !isset( $this->row[ 'hash' ] ) )
        {
            $this->row[ 'hash' ] =  sha1_file( $this->filename() );
        }
        
        return $this->row[ 'hash' ];
    }

    public function type( $type = null )
    {
        if ( isset( $type ) )
        {
            $this->row[ 'type' ] = $type;
        }
        elseif ( !isset ( $this->row[ 'type' ] ) )
        {
            $fileinfo = \finfo_open ( FILEINFO_MIME_TYPE );
            $this->row[ 'type' ] = \finfo_file ( $fileinfo, $this->filename() );
            finfo_close ( $fileinfo );
        }

        return $this->row[ 'type' ];
    }

    protected function check_extension()
    {
        if ( !isset ( static::$extensions[ $this->type () ] ) )
        {
            throw new \Exception\User ( 'Unsupported extension : ' . $this->type () );
        }
    }

    public function extension()
    {
        if ( !isset ( static::$extensions[ $this->type () ] ) )
        {
            return false;
        }

        return static::$extensions[ $this->type () ];
    }


    public function check_size( )
    {
        if ( $this->size() > static::$options['max_size'] )
        {
            throw new Exception\User('File is too big. Max : ' . static::$options['max_size'] );
        }
        
        if ( $this->size() < static::$options['min_size'] )
        {
            throw new Exception\User('File is too small. Min : ' . static::$options['min_size'] );
        }

        return $this;
    }

    public function content()
    {
        return file_get_contents ( $this->filename () );
    }
    
    
    public function move_uploaded_file( $new_path )
    {
        $file_name = $new_path . $this->system_name();
         
        if ( !file_exists( $file_name ) )
        {
            if ( !move_uploaded_file( $this->filename() , $file_name ) )
            {
                throw new Exception\User( 'Cant move file ' . $file_name );
            }
        }
        
        
        $this->row[ 'filename' ] = $file_name;
        return $this;
    }
    
    public function system_name()
    {
        return $this->hash() . '.' . $this->extension();
    }
    
    public function __clone() 
    {
        $this->row = array( 'filename' => $this->row[ 'filename' ] );
    }
}