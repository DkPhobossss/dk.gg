<?php

namespace DB;

use DB;


DB::exec("SET NAMES 'utf8'");
DB::exec("SET CHARACTER SET 'utf8'");
DB::exec("SET SESSION collation_connection = 'utf8_general_ci'");

abstract class Table
{
    static $table_name;
    
    // = array( field1 , field2:field3 , ) || field1:field2 => example: 1) name:lang , 2)array(id,  name:lang) , 
    static $cache_fields = null;
    
    static $cache_expire;
    
    static $fields = array(
        /* 'field_name' => array(
          'type' => 'int',
          'length' => 11, //array(1 , 2 , 3)
          'length_min' => 10 ,
          'decorators' => function() {} || 'trim' ,
          'null' => true ,
          'default' => 1 ,
          'regexp' => '\w{3,100}'
          ) */
    );
    static $decorators;

    public static function select( $fields = '*', $where = false, $order = false, $limit = false, $group = false , $for_update = false)
    {
        return DB::select( static::$table_name, $fields, $where, $order, $limit, $group , $for_update);
    }
    
    public static function select_calc( $fields = '*', $where = false, $order = false, $limit = false, $group = false , $for_update = false)
    {
        return DB::select_calc( static::$table_name, $fields, $where, $order, $limit, $group , $for_update);
    }
    
    public static function select_for_update( $fields = '*', $where = false, $order = false, $limit = false, $group = false )
    {
        return DB::select( static::$table_name, $fields, $where, $order, $limit, $group , true );
    }

    public static function exists( array $where , $for_update = false)
    {
        $result = DB::select( static::$table_name, array( key( $where ) ), $where , false , false , false , $for_update )->row();
        return empty( $result ) ? FALSE : TRUE;
    }

    public static function insert( array $data)
    {
        return DB::insert( static::$table_name, $data);
    }
    
    public static function insert_ignore( array $data )
    {
        return DB::insert( static::$table_name, $data , true , true );
    }
    
    public static function insert_multiply( array $fields , array $values , $escape = true , $ignore = false )
    {
        return DB::insert_multiply( static::$table_name, $fields,  $values , $escape , $ignore );
    }

    public static function update( array $data, array $where )
    {
        if ( isset( static::$cache_fields ) )//drop cache
        {
            self::clear_cache( $where );
        }
        return DB::update( static::$table_name, $data, $where );
    }

    public static function delete( array $where )
    {
        if ( isset( static::$cache_fields ) )//drop cache
        {
            self::clear_cache( $where );
        }
        return DB::delete( static::$table_name, $where );
    }

    public static function if_not_insert_update( array $insert_data, array $update_data )
    {
        return DB::if_not_insert_update( static::$table_name, $insert_data, $update_data );
    }

    public static function replace( array $data )
    {
        return DB::replace( static::$table_name, $data );
    }

    public static function truncate( $check = false )
    {
        return DB::truncate( static::$table_name, $check );
    }

    public static function auto_increment()
    {
        $data = DB::select( 'information_schema`.`tables', array( 'key' => 'AUTO_INCREMENT' ), array( 'table_name' => static::$table_name ) )->row();
        return $data['AUTO_INCREMENT'];
    }

    public static function insert_row( array $data )
    {
        //test
        $data = array_intersect_key( $data , static::$fields );
        
        $errors = array( );
        $field = null;
        foreach ( static::$fields as $key => $row )
        {
            $field = & $data[$key];

            if ( !isset( $field ) )
            {
                if ( !array_key_exists( 'default', $row ) )
                {
                    $errors[static::$table_name . '.' . $key] =  "<b>$key</b>: " . ( 'Field is not set' );
                    continue;
                }
                $field = $row['default'];
            }

            if ( isset( $field['disable_update'] ) && empty( $field['pseudo_primary'] ) )
            {
                $errors[static::$table_name . '.' . $key] =  "<b>$key</b>: " . ( 'Field is not set' );
                coninue;
            }

            if ( ( $field = self::field_format( $row, $field ) ) === false )
            {
                $errors[static::$table_name . '.' . $key] = "<b>$key: </b>" . ( isset( $row['error'] ) ? $row['error'] : ( 'Data is incorrect' ) );
            }

        }
        unset( $field );


        if ( !empty( $errors ) )
        {
            throw new \Exception\User( $errors );
        }

        return DB::insert( static::$table_name, $data, false );
    }

    public static function update_row( array $data, array $where )
    {
        $errors = array( );
        $field_info = null;
        foreach ( $data as $key => &$value )
        {
            $field_info = & static::$fields[$key];
            if ( !isset( $field_info ) || isset( $field_info['disable_update'] ) )
            {
                unset( $data[$key] ); //unknown field or can't update
            }
            else
            {
                if ( ( $value = self::field_format( $field_info, $value ) ) === false )
                {
                    $errors[static::$table_name . '.' . $key] = "<b>$key: </b>". ( isset( $field_info['error'] ) ? $field_info['error'] : ( 'Ошибка проверки данных' ) );
                }
            }
        }
        unset( $value );
        unset( $field_info );
        
        if ( empty($data) )
        {
            throw new \Exception\User( 'Update data empty' );
        }

        if ( !empty( $errors ) )
        {
            throw new \Exception\User( $errors );
        }

        
        foreach ( static::$fields as $key => $value )
        {
            if ( $value['type'] == 'bool' && !isset( $data[ $key ] ) )
            {
                $data[ $key ] = 0;
            }
        }
        
        return DB::update( static::$table_name, $data, $where , false );
    }
    
    
    /**
     * static::cache_fields
     * @param type $where 
     */
    private static function clear_cache( array $where )
    {
        $cache_key = '';
        foreach ( $where as $key => $value )
        {
            if ( !is_array ( $value ) )
                $cache_key .= $key . ':' ;
        }
        $cache_key = substr( $cache_key, 0, -1 );
        
        foreach ( ( !is_array( static::$cache_fields ) ? array( static::$cache_fields ) : static::$cache_fields ) as $value )
        {
            if ( $cache_key == $value )//strspn( $cache_key , $value ) == strlen( $cache_key ) - if no order
            {
                $cache_key = '';

                foreach ( $where as $key => $value2 )
                {
                    if ( !is_array ( $value2 ) )
                    $cache_key .= ":$key:$value2";
                }
                
                return \Cache::clear( static::$table_name . $cache_key );
            }
        }
        return false;
    }
    

    private static function field_format( $field_info, $value )
    {
        if ( !empty( $field_info['null'] ) && ( is_null( $value ) || $value === '' ) )
        {
            return 'NULL';
        }
        
        if ( $field_info['type'] == 'date_time')
        {
            $value = $value[0] . ' ' . $value['hour'] . ':' . $value['min'] . ':00';
        }
        
        if ( isset( $field_info['decorators'] ) )
        {
            if ( is_object( $field_info['decorators'] ) && $field_info['decorators'] instanceof \Closure )
            {
                $value = $field_info['decorators']( $value );
            }
            else
            {
                if ( !isset( self::$decorators[$field_info['decorators']] ) || !( ($decorator = self::$decorators[$field_info['decorators']]) instanceof \Closure ) )
                {
                    throw new \Exception\Fatal( 'Cant call ' . $field_info['decorators'] );
                }

                $value = $decorator( $value );
            }
        }

        if ( isset( $field_info['min'] ) && ( intval( $value ) < $field_info['min'] ) )
        {
            return false;
        }

        if ( isset( $field_info['max'] ) && ( intval( $value ) > $field_info['max'] ) )
        {
            return false;
        }

        if ( isset( $field_info['regexp'] ) && (!mb_ereg_match( $field_info['regexp'], $value ) ) )
        {
            return false;
        }

        if ( isset( $field_info['check'] ) && !$field_info['check']( $value ) )
        {
            return false;
        }

        switch ( $field_info['type'] )
        {
            case 'varchar' :
            case 'text' :
            case 'html' :
            case 'browse' :
                $length = mb_strlen( $value );
                if ( !empty( $field_info['length'] ) && $length > $field_info['length'] )
                {
                    return false;
                }
                if ( !empty( $field_info['length_min'] ) && $length < $field_info['length_min'] )
                {
                    return false;
                }
                break;
            case 'enum' :
                if ( !in_array( $value, $field_info['length'], true ) )
                {
                    return false;
                }
                break;
        }
        
        if ( $field_info['type'] == 'browse' )
        {
            if ( isset( $field_info['width'] ) || isset( $field_info['height'] ) )
            {
                $size = getimagesize( $value );
				if ( is_null( $size ) || ( ( isset( $field_info['width'] ) && $size[0] != $field_info['width'] ) || ( isset( $field_info['height'] ) && $size[1] != $field_info['height'] ) ) )
                {
                    //throw new \Exception\User(__('Image must be ') . ( '[ width: ' . ( isset( $field_info['width']  ) ? $field_info['width'] : 'undefined' )  . ' , height : ' . ( isset( $field_info['height']  ) ? $field_info['height'] : 'undefined' ) . ' ]' ) );
                }
            }
        }
        
        

        switch ( $field_info['type'] )
        {
            case 'int' :
                return intval( $value );
            case 'float' :
                return floatval( $value );
            case 'bool' :
                return empty( $value ) ? 0 : 1;
            case 'date' : 
            {
               if ( ( $t = strtotime( $value ) )  !=  0 )
               {
                   return '"' . date('Y-m-d' , $t ) . '"';
               };
               return 'NULL';//hm
            }
            case 'timestamp' :
                if ( $value === 'CURRENT_TIMESTAMP' )
                {
                    $value = time();
                }
                return '"' . date( 'Y-m-d H:i:s', $value ) . '"';
            case 'date_time' :
            {
                $time = strtotime( $value );
                if ( empty( $field_info['past'] ) )
                {
                    if ( $time < time() )
                    {
                        return FALSE;
                    }
                }
                
                return '"' . date( 'Y-m-d H:i:s', $time ) . '"';
            }
            default :
                return '"' . \DB::ecape_string( $value ) . '"';
        }
    }

    public static function label_element( $field, $value = '', $element_class = null , $wrap = true )
    {
        if ( $wrap )
        {
            $html = "<fieldset><legend>" .  ( empty( static::$fields[$field]['default'] ) && empty( static::$fields[$field]['null'] )  ? '<span title="Required" class="red">*</span>' : '' ) . $field . ( isset(static::$fields[$field]['comment']) ? ' ( ' . static::$fields[$field]['comment'] . ' ) ' : '' ) . "</legend>";
            $name = 'name="field[' . $field . ']"';
        }
        else
        {
            $html = '';
            $name = 'name="field[' . $field . ']"';
        }

        
        switch ( static::$fields[$field]['type'] )
        {
            case 'varchar' :
            case 'int' :
            case 'float' :
                {
                    $html .= '<input type="text" ' . $name. ' value="' . $value . '" ' . ( isset( $element_class ) ? ( 'class="' . $element_class . '"' ) : '' ) . ( isset( static::$fields[$field]['length'] ) ? ' maxlength="' . static::$fields[$field]['length'] . '"' : '') . '/>';
                    break;
                }
            case 'html':
            case 'text':
                {
                    if ( static::$fields[$field]['type'] === 'html' )
                    {
                        $html .= '<textarea style="height:500px;" id="wysywyg_' . ++\Output::$wysywyg . '" ' . $name. ' ' . ( isset( $element_class ) ? ( 'class="' . $element_class . '"' ) : '' ) . '>' . $value . '</textarea>';
                    }
                    else
                    {
                        if ( static::$fields[$field]['decorators'] == 'trim_nl2br' )
                        {
                            $value = strip_tags( $value );
                        }
                        $html .=  '<textarea ' . ( isset( static::$fields[$field]['length'] ) ? ' maxlength="' . static::$fields[$field]['length'] . '"' : '') . ' ' .  $name. ' ' . ( isset( $element_class ) ? ( 'class="' . $element_class . '"' ) : '' ) . '>' . $value . '</textarea>';
                    }
                    break;
                }
            case 'enum':
                {
                    $html .= '<select ' . $name. '>';
                    foreach ( static::$fields[$field]['length'] as $key => $val )
                    {
                        if ( is_array( $val ) )
                        {
                            $val = key( $val );
                        }
                        $html .=  '<option ' . ( $val == $value ? 'selected' : '' ) . ' value="' . $val . '">' . $key .  '</option>';
                    }
                    $html .= '</select>';
                    break;
                }
            case 'browse' : 
                {
                    if ( isset ( static::$fields[$field]['folder'] ) )
                    {
                        $folder = static::$fields[$field]['folder'];
                        if ( is_file( \Helper::url2path( $value ) ) )
                        {
                            $url_dir = mb_substr( $value , 0 , mb_strrpos( $value , '/' ) + 1 );
                            $folder = str_replace( \Config::$ckfinderbase . mb_strtolower( static::$fields[$field]['file_type'] ) . '/' , '' , $url_dir );
                        }
                    }
                    else
                    {
                        $folder = '';
                    }
                    
                    \Output::$ckfinder++;
                    $html .= '<input id="ck_finder_' . $field . '" ' . $name. ' type="text" value="' . $value . '" ' . ( isset( static::$fields[$field]['length'] ) ? ' maxlength="' . static::$fields[$field]['length'] . '"' : '') .' />'
                        . (empty($value) ? '' : '<img src="' . $value . '" alt="image" title="image" onclick="selectFileWithCKFinder( \'ck_finder_' . $field . '\' );" />')
                        . '<br><br><button type="button" class="right" onclick="selectFileWithCKFinder( \'ck_finder_' . $field . '\' );" />Browse Server</button>';
                    break;
                }
            case 'date' : 
                {
                    \Output::js( 'js/jquery.date_picker' );
                    \Output::css( 'css/jquery.date_picker' );
                    $html .= '<input maxlength="10" ' . $name. ' class="date_picker ' .  $element_class  . '" value="' . $value . '" />';
                    break;
                }
            case 'bool' : 
                {
                    $html .= ' <input type="checkbox" ' . $name. ' ' . (!empty($value) ? 'checked' : '') . '/>';
                    break;
                }
            case 'date_time':
                {
                    if ( $value )
                    {
                        list( $day , $hour ) = explode ( ' ', $value );
                        list( $hour, $min ) = explode( ':' , $hour );
                    }
                    else
                    {
                        list( $day , $hour , $min ) = explode( ' ' , date('Y-m-d H i') );
                        $min = $min + ( 5 - $min % 5 );
                    }
                
                    \Output::js( 'js/jquery.date_picker' );
                    \Output::css( 'css/jquery.date_picker' );
                    $html .= 'Date: <input ' . ( empty( static::$fields[$field]['past'] ) ? ( 'from="' . date('Y-m-d') . '"' ) : '' ) . ' maxlength="10" name="field[' . $field . '][]" class="date_picker ' .  $element_class  . '" value="' . $day . '" />';
                    
                    $html .= ' Hour: <select style="width:auto;" name="field[' . $field . '][hour]">';
                    for ( $i = 0; $i <=23; $i++ )
                    {
                        $t = sprintf( "%02d" , $i );
                        $html .= '<option value="' . $t . '" ' . ( $t == $hour  ? 'selected' : '' ) . '>' . $t . '</option>';
                    }
                    $html .= '</select>';
                    
                    $html .= ' Min: <select style="width:auto;" name="field[' . $field . '][min]">';
                    for ( $i = 0; $i <= 55; $i += 5 )
                    {
                        $t = sprintf( "%02d" , $i );
                        $html .= '<option value="' . $t . '" ' . ( $t == $min  ? 'selected' : '' ) . '>' . $t . '</option>';
                    }
                    $html .= '</select>';
                    
                    break;
                }
            default :
                {
                    return 'unsupport_field_type';
                }
        }
        
        return $html . ( !$wrap ? '' : '</fieldset>' );
    }

    public static function add_decorator( $field, $function )
    {
        static::$fields[$field]['decorators'] = $function;
    }

}

Table::$decorators = array(
    'trim' => function ( $value )
    {
        return trim( $value );
    },
    'trim_no_iframe' => function ( $value )
    {
        return strip_tags( trim( $value ), '<p><a><br><div><hr><img><span><table><tr><td><th><tbody><thead><ul><li><ol><b><strong><i><s><sup><sub><h2><h3><h4><h5>' );
    },
    'trim_no_html' => function ( $value )
    {
        return htmlspecialchars( trim( $value ) );
    },
    'trim_no_tags' => function ( $value )
    {
        return strip_tags( $value );
    },
    'trim_nohtml_noquotes' => function ( $value )
    {
        return htmlspecialchars( trim( $value ) , ENT_QUOTES );
    },
    'trim_only_spaces' => function ( $value )
    {
        return strip_tags( trim( $value ) , '<p><div><br><br><br><br><br><br><br>' );
    },
    'trim_basic_editor' => function ( $value )
    {
        $value = strip_tags( trim( $value ) , '<p><div><br><strong><b><s><u><i><ul><ol><li><sup><sub><a><img>' );

        $dom = new \DOMDocument;
        $dom->loadHTML( $value );
        
        $xpath = new \DOMXPath( $dom );
        $nodes = $xpath->query('//@*');
        
        foreach ($nodes as $node) 
        {
            if ( $node->parentNode->tagName == 'a' && $node->nodeName == 'href' )
            {
                if ( filter_var( $node->value, FILTER_VALIDATE_URL ) === FALSE )
                {
                    //not valid URL
                    $node->parentNode->removeAttribute( $node->nodeName );
                }
                else
                {
                    $url = parse_url( $node->value , PHP_URL_HOST );
                    if ( strpos( $url, \Config::domain ) === FALSE )
                    {
                        $node->parentNode->setAttribute('target', '_blank');
                        $node->parentNode->setAttribute('rel', 'nofollow');
                    }
                }
            }
            elseif ( $node->parentNode->tagName == 'img' )
            {
                if ( $node->nodeName == 'alt' || $node->nodeName == 'title' || $node->nodeName == 'width' || $node->nodeName == 'height' )
                {
                    //all ok
                }
                elseif ( $node->nodeName == 'src' )
                {
                    if ( filter_var( $node->value, FILTER_VALIDATE_URL ) === FALSE )
                    {
                        //not valid URL
                        $node->parentNode->removeAttribute( $node->nodeName );
                    }
                }
                else
                {
                    $node->parentNode->removeAttribute( $node->nodeName );
                }
            }
            else
            {
                $node->parentNode->removeAttribute($node->nodeName);
            }
        }
            
        return preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $dom->saveHTML()) );
    },
    'trim_nl2br' => function( $value )
    {
        return nl2br( htmlspecialchars( trim( $value ) ) , true );
    }
);