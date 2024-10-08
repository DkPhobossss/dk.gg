<?php

class File_uploader
{
    static public $options = array(
        'thumbnail_height' => 100,
        'thumbnail_width' => 100,
        'max_preview_height' => 600,
        'max_preview_width' => 800,
    );
    
    public static function init()
    {
        self::$options = array_merge( self::$options , array(
            'dir'           => Config::SITE_ROOT . 'uploads/',
            'gallery_dir'   => Config::SITE_ROOT . 'uploads/gallery/',
            'files_dir'     => Config::SITE_ROOT . 'uploads/files/'
        ));
    }

    public static function upload_gallery_images( $gallery_id , $files , $descriptions )
    {
        Server::check_writeble( self::$options['gallery_dir'] );
        
        $gallery_dir = self::$options['gallery_dir'] . $gallery_id . '/';
        
        if ( !Server::mkdir( $gallery_dir ) )
            Server::check_writeble( $gallery_dir );
        
        $errors = array();
        $inserted = 0;
        for ( $i = 0; $i < count( $files['name'] ); $i++ ) 
        {
            //some error
            if ( $files['error'][ $i ] > 0 )
            {
                $errors[ $files['name'][$i] ] =  self::error( $files['error'][$i] );
            }
            else
            {
                $img = array();
                
                try 
                {
                    $CImage = Image::temp( $files['tmp_name'][$i] )->check_size()->ckeckXY( self::$options['thumbnail_width'], self::$options['thumbnail_height'] )->gallery_format()->move_uploaded_file( $gallery_dir );
                    $CImage_thumbnail =  clone $CImage;
                    $CImage_src = clone $CImage;
                    
                    $img['source'] = $CImage->system_name();
                    
                    $CImage_thumbnail->resize_region( self::$options['thumbnail_width'] , self::$options['thumbnail_height'] )->save( $gallery_dir );
                    $img['preview'] = $CImage_thumbnail->system_name();
                    
                    $CImage_src->resize( self::$options['max_preview_width'] , self::$options['max_preview_height'] , true )->save( $gallery_dir );
                    $img['src'] = $CImage_src ->system_name();
                    
                    
                    $titles = array();
                    
                    foreach( Localka::$settings as $lang => $row )
                    {
                        $titles[ 'title_' . $lang ] = isset( $descriptions['title_' . $lang][ $i ] ) ? trim( strip_tags( $descriptions['title_' . $lang][ $i ] ) ) : '';
                    }

                    
                    if ( DB::insert( 'watch_gallery_photo' , array_merge( array(
                        'gallery_id'=> $gallery_id,
                        'type'      => $CImage->type() ,
                        'width'     => $CImage->width(),
                        'height'    => $CImage->height(),
                        'size'      => $CImage->size(),
                        'source'    => $img['source'],
                        'src'       => $img['src'],
                        'preview'   => $img['preview'],
                    ) , $titles ) ) )
                    {
                        $inserted++;
                    }
                }
                catch ( Exception\User $e )
                {
                    $errors[ $files['name'][$i] ] =  $e->getErrors();
                    
                    foreach( $img as $t )
                    {
                        if ( file_exists( $t ) )
                        {
                            unlink( $t );
                        }
                    }
                }
            }
        }

        if ( $inserted )
        {
            DB\Watch\Gallery::update( array( 'photos' => array('`photos` + ' . $inserted ) ), array( 'id' => $gallery_id, ) );
        }
        
        if ( !empty( $errors ) )
            throw new Exception\User( $errors );
        
        return true;
    }
    
    
    private static function error( $code )
    {
        $codes = array(
            UPLOAD_ERR_INI_SIZE     => 'UPLOAD_ERR_INI_SIZE' ,
            UPLOAD_ERR_FORM_SIZE    => 'UPLOAD_ERR_FORM_SIZE' ,
            UPLOAD_ERR_PARTIAL      => 'UPLOAD_ERR_PARTIAL' ,
            UPLOAD_ERR_NO_FILE      => 'UPLOAD_ERR_NO_FILE' ,
            UPLOAD_ERR_NO_TMP_DIR   => 'UPLOAD_ERR_NO_TMP_DIR' ,
            UPLOAD_ERR_CANT_WRITE   => 'UPLOAD_ERR_CANT_WRITE' ,
            UPLOAD_ERR_EXTENSION    => 'UPLOAD_ERR_EXTENSION' ,
        );
        
        return isset( $codes[ $code ] ) ? $codes[ $code ] : 'UNKNOWN';
    }
}

File_uploader::init();