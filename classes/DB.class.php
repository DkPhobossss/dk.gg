<?php
/**
 *  DB\::select('')->cache()
 */
class Query
{

    public $query_data = null;
    public $table = null;

    private $key = null;
    private $expire = 0;



    public function cache( )
    {
        $args = func_get_args();
        $this->key = ( isset($this->table) ? $this->table . ':' : '' );
        
        if ( !empty($args) )
        {
            $this->key .= implode( ':' , $args );
        }
        else
        {
            //don't pass empty :/
            if ( !empty( $this->query_data['w'] ) )
                foreach ( $this->query_data['w'] as $key => $value)
                {
                    $this->key .= $key . ':' . $value . ':';
                }
            $this->key = substr($this->key, 0 , -1);
        }
    
        return $this;
    }

    
    public function expire( $expire = 0)
    {
        $this->expire = $expire;
        return $this;
    }

    public function row()
    {
        if ( !isset( $this->query_data ) )
        {
            throw new Exception\Fatal( 'query_data empty' );
        }
        
        if ( !isset( $this->key ) )
        {
            DB::$action = 'select_row';
            $result = call_user_func_array( 
                array('DB' , 'perform_query') , 
                array_merge( array( is_array($this->query_data) ? $this->compile_select() : $this->query_data ) ,  func_get_args() )
            );
        }
        else if ( ($result = Cache::get( $this->key ) ) === false )
        {
            DB::$action = 'select_row';
            $result = call_user_func_array( 
                array('DB' , 'perform_query') , 
                array_merge( array( is_array($this->query_data) ? $this->compile_select() : $this->query_data ) ,  func_get_args() )
            );
            
            Cache::set( $this->key, $result, $this->expire );
        }

        $this->clear();
        return $result;
    }

    public function rows()
    {
        if ( !isset( $this->query_data ) )
        {
            throw new Exception\Fatal( 'query_data empty' );
        }

        if ( isset( $this->key ) )
        {
            $result = Cache::get( $this->key );
            if ( $result === false )
            {
                DB::$action = 'select';

                $result = call_user_func_array(
                    array('DB' , 'perform_query') ,
                    array_merge( array( is_array($this->query_data) ? $this->compile_select() : $this->query_data ) ,  func_get_args() )
                );

                Cache::set( $this->key, $result, $this->expire );
            }
        }
        else
        {
            DB::$action = 'select';

            $result = call_user_func_array(
                array('DB' , 'perform_query') ,
                array_merge( array( is_array($this->query_data) ? $this->compile_select() : $this->query_data ) ,  func_get_args() )
            );
        }

        $this->clear();
        return $result;
    }
    
    public function value()
    {
        if ( !isset( $this->query_data ) )
        {
            throw new Exception\Fatal( 'query_data empty' );
        }

        if ( !isset( $this->key ) )
        {
            DB::$action = 'select_value';
            
            $result = call_user_func_array( 
                array('DB' , 'perform_query') , 
                array_merge( array( is_array($this->query_data) ? $this->compile_select() : $this->query_data ) ,  func_get_args() )
            );
        }
        else if ( ($result = Cache::get( $this->key ) ) === false )
        {
            DB::$action = 'select_value';

            $result = call_user_func_array( 
                array('DB' , 'perform_query') , 
                array_merge( array( is_array($this->query_data) ? $this->compile_select() : $this->query_data ) ,  func_get_args() )
            );

            Cache::set( $this->key, $result, $this->expire );
        }

        $this->clear();
        return $result;
    }

    private function clear()
    {
        $this->query_data = $this->key = $this->table = null;
        $this->expire = 0;
    }
    
    private function compile_select()
    {
        $query = 'SELECT ';
        
        if ( isset( $this->query_data['calc'] ) )
        {
            $query .= ' SQL_CALC_FOUND_ROWS ';
        }
        
        if ( $this->query_data['f'] == '*' )
        {
            $query .= '*';
        }
        else
        {
            if ( !is_array( $this->query_data['f'] ) )
            {
                throw new Exception\Fatal( 'Invalid select fields. Use array' );
            }

            $value = reset( $this->query_data['f'] );
            $key = key( $this->query_data['f'] );

            $query .= (!is_int( $key ) ? "`$key` AS " : "") . "`$value`";

            while ( ($value = next( $this->query_data['f'] )) !== false )
            {
                $key = key( $this->query_data['f'] );
                $query .= " ," . (!is_int( $key ) ? "`$key` AS " : "" ) . "`$value`";
            }
        }

        $query .= ' FROM `' . $this->table . '`';

        if ( is_array( $this->query_data['w'] ) )
        {
            $query .= DB::compile_where( $this->query_data['w'] );
        }


        if ( is_array( $this->query_data['g'] ) )
        {
            $query .= " GROUP BY `" . implode( '` , `', $this->query_data['g'] ) . "`";
        }


        if ( is_array( $this->query_data['o'] ) )
        {
            $query .= " ORDER BY ";
            $i = 0;
            foreach ( $this->query_data['o'] as $value )
            {
                $query .= ( ++$i % 2 ) ? " `$value` " : "$value ,";
            }
            $query = substr( $query , 0 , -1 );
        }

        if ( is_array( $this->query_data['l'] ) )
        {
            $query .= ' LIMIT ' . intval( $this->query_data['l'][0] ) . " , " . intval( $this->query_data['l'][1] );
        }
        
        if ( $this->query_data['u'] )
        {
            $query .= ' FOR UPDATE';
        }
        
        return $query;
    }
    
}

class DB
{

    private static $config = array
        (
        "db" => "",
        "user" => "",
        "password" => "",
        "host" => "",
        "prefix" => "",
        "encoding" => ""
    );
    private static $show_sql = true;
    private static $query_id = ""; //res of mysqli_query
    private static $query_count = 0;
    private static $connection_id = "";
    public static $action = ""; //insert , select , etc
    private static $CQuery;
    public static $error = null;

    static function connect( array $config )
    {
        self::$config = $config;

        if ( !self::$connection_id = mysqli_connect( self::$config['host'], self::$config['user'], self::$config['password'], self::$config['db'] ) )
        {
            return self::error( 'wrong connection id' );
        }


        self::$CQuery = new Query();
        return @mysqli_query( self::$connection_id,"SET CHARACTER SET '" . self::$config['encoding'] . "'" );
    }

    static function pconnect( array $config )
    {
        self::$config = $config;
        return false;
    }

    public static function select( $table, $fields = '*', $where = false, $order = false, $limit = false, $group = false , $for_update = false )
    {
        self::$CQuery->table = $table;
        self::$CQuery->query_data = array( 'f' => $fields , 'w' => $where , 'o' => $order , 'l' => $limit , 'g' => $group , 'u' => $for_update) ;
        return self::$CQuery;
    }
    
    public static function select_calc( $table, $fields = '*', $where = false, $order = false, $limit = false, $group = false , $for_update = false )
    {
        self::$CQuery->table = $table;
        self::$CQuery->query_data = array( 'f' => $fields , 'w' => $where , 'o' => $order , 'l' => $limit , 'g' => $group , 'u' => $for_update , 'calc' => true ) ;
        return self::$CQuery;
    }

    /**
     * 0-> query('Select blabla FROM table WHERE id=%d')
     * 1->param
     * ...
     * n->param
     * @return type 
     */
    public static function exec()
    {
        $args = func_get_args();
        $query = vsprintf( array_shift( $args ), array_map( function($item)
                {
                    return DB::security( $item );
                }, $args ) );

        if ( strpos( $query, 'SELECT' ) === 0 )
        {
            self::$CQuery->query_data = $query;
            return self::$CQuery;
        }
        
        return self::perform_query( $query );
    }
    
    
    /**
     * SELECT exec
     */
    public static function _exec()
    {
        $args = func_get_args();
        $query = vsprintf( array_shift( $args ), array_map( function($item)
                {
                    return DB::security( $item );
                }, $args ) );


        self::$CQuery->query_data = $query;
        return self::$CQuery;
    }

    public static function insert( $table, array $data , $escape = true , $ignore = false )
    {
        self::$action = "insert";
        return self::perform_query( "INSERT " . ( $ignore ? 'IGNORE' : '' ) . " INTO `$table` (`" .
                implode( '` , `', array_keys( $data ) ) . "`) VALUES( " . ( $escape ? implode( ',', array_map( array( 'self', 'security' ), array_values( $data ) ) )  
                                                                                    : implode( ',' , array_values( $data ) ) ) 
                                                                    . ")" );
    }
    
    public static function insert_multiply( $table , array $fields , array $values , $escape = true , $ignore = false )
    {
        self::$action = "insert";
        
        return self::perform_query( "INSERT " . ( $ignore ? 'IGNORE' : '' ) . " INTO `$table` (`" .
                implode( '` , `', $fields ) . "`) VALUES " . ( $escape ? implode(',' , array_map( function( $array ) { return '(' . implode( ',', array_map( array( 'DB', 'security' ), $array ) )  . ')'; } , $values ) ) 
                                                                                    : implode(',' , array_map( function( $array ) { return '(' . implode(',' , $array) . ')'; } , $values ) ) ) 
                                                                    );
    }

    public static function update( $table, array $data, $where , $escape = true )
    {
        if ( !is_array( $where ) && ($where !== 'ALL') )
        {
            return self::error( 'UPDATE called without condition' );
        }

        self::$action = "update";
        $query = "UPDATE `$table` SET " . self::compile_set( $data , $escape );

        if ( $where === 'ALL' )
        {
            return $query;
        }

        $query .= self::compile_where( $where );
        return self::perform_query( $query );
    }

    public static function delete( $table, array $where )
    {
        if ( empty( $where ) )
        {
            return self::error( 'DELETE without condition' );
        }

        self::$action = "delete";
        return self::perform_query( "DELETE FROM `$table` " . self::compile_where( $where ) );
    }

    public static function truncate( $table, $check = false )
    {
        if ( !$check )
        {
            return self::error( 'TRUNCATE without apply' );
        }

        self::$action = "truncate";
        return self::perform_query( "TRUNCATE `$table`" );
    }

    //affected rows. 1 - if insert , 2 if update
    public static function if_not_insert_update( $table, array $insert_data, array $update_data )
    {
        self::$action = "if_not_insert_update";
        return self::perform_query( "INSERT INTO `$table` (`" .
                implode( '` , `', array_keys( $insert_data ) ) . "`) VALUES( " . implode( ',', array_map( array( 'self', 'security' ), array_values( $insert_data ) ) ) . ")"
                . ' ON DUPLICATE KEY UPDATE ' . self::compile_set( $update_data ) );
    }

    public static function replace( $table, array $data )
    {
        self::$action = "insert";
        return self::perform_query( "REPLACE INTO `$table` (`" .
                implode( '` , `', array_keys( $data ) ) . "`) VALUES( " . implode( ',', array_map( array( 'self', 'security' ), array_values( $data ) ) ) . ")" );
    }
    

    /**
     * For field = field+1 queris use
     * data = array(field => array(field => -10)); etc..
     * @param array $data
     * @return string 
     */
    private static function compile_set( array &$data , $escape = true )
    {
        $value = reset( $data );
        $key = key( $data );

        $set = " `$key`  = " . ( $escape    ? ( is_array( $value ) ? ( reset( $value ) ) 
                                                                : self::security( $value ) ) 
                                            : $value );

        while ( ($value = next( $data )) !== false )
        {
            $key = key( $data );
            $set .= " , `$key`  = " . ( $escape ?  (is_array( $value )  ? ( reset( $value ) ) 
                                                                        : self::security( $value ) )
                                                : $value );
        }

        return $set;
    }

    public static function compile_where( array $data )
    {
        $value = reset( $data );
        $key = key( $data );

        $condition = ' WHERE ' . self::compile_where_key_value( $key, $value );
        $f = false;
        while ( ($value = next( $data )) !== false )
        {
            $key = key( $data );

            if ( $value === 'OR' || $value === 'AND' )
            {
                $condition .= " $value ";
                $f = true;
            }
            else
            {
                $condition .= ($f ? " " : " AND ") . self::compile_where_key_value( $key, $value );
                $f = false;
            }
        }

        return $condition;
    }

    private static function compile_where_key_value( &$key, &$value )
    {
        if ( !is_array( $value ) )
        {
            if ( is_null ( $value ) )
            {
                return " `$key` IS NULL ";
            }
            else
            {
                return " `$key` = " . self::security( $value );
            }
        }

        $symbol = end( $value );
        if ( in_array( $symbol, array( '=', '>', '>=', '<', '<=', '<>', '!=', 'IS', 'IS NOT' ), true ) )
        {
            return " `$key` $symbol " . self::security( reset( $value ) );
        }
        elseif ( mb_strpos( $symbol, 'LIKE' ) !== false )
        {
            return " `$key` LIKE " . self::security( str_replace( array( '%', '_' ), '', reset( $value ) ) . (substr( $symbol, -1, 1 ) == '%' ? '%' : '') );
        }
        else
        {
            return " `$key` IN (" . self::secure_IN( $value ) . ")";
        }

        return self::error( 'Compile where called with wrong symbol' );
    }

    public static function LIKE_security( $value )
    {
        return str_replace( array( '%', '_' ), array( '\%', '\_' ), $value );
    }

    public static function perform_query( )
    {
        $args = func_get_args();
        $query = array_shift( $args );
        
        self::$query_count++;
        if ( self::$show_sql )
        {
            Output::$debug['DB'][] = htmlspecialchars( $query );
        }

        if ( !self::$query_id = mysqli_query( self::$connection_id, $query ) )
        {
            if ( mysqli_errno( self::$connection_id ) == 1062 ) //duplicate key
            {
                throw new Exception( mysqli_error( self::$connection_id ) . "\r\n$query" );
            }
            return self::error( "mySQL query error: $query" );
        }

        switch ( self::$action )
        {
            case "select" :
                {
                    $result = call_user_func_array( array('self' , 'fetch_result'),  $args );
                    self::free_result( self::$query_id );
                    break;
                }
            case "select_row" :
                {
                    $result = call_user_func_array( array('self' , 'fetch_row'),  $args );
                    self::free_result( self::$query_id );
                    break;
                }
            case "select_value" :
                {
                    $result = call_user_func_array( array('self' , 'fetch_value'),  $args );
                    self::free_result( self::$query_id );
                    break;
                }
            case "insert" :
                {
                    $result = self::insert_id();
                    break;
                }
            case "update" :
            case "delete" :
            case "if_not_insert_update" :
                {
                    $result = self::affected_rows();
                    break;
                }
            default :
                {
                    if ( is_resource ( self::$query_id) )
                    {
                        $result = self::fetch_result( );
                        self::free_result( self::$query_id );
                    }
                    else
                    {
                        $result =  true;
                    }
                }
        }

        self::$action = '';
        return $result;
    }

    
    /**
     *
     * @param string $index
     * @param string OR true $value
     * @param string $index2
     * @return type 
     * 
     *  1) 0 -> array( x->2 , y->3 )    ==      ->rows()
     *  2) x -> array( y->3)            ==      ->rows(x) [x - distinct , else use 4]
     *  3) x -> y                       ==      ->rows(x,y)
     *  4) x -> array( 0-> array( y->1 ) , 1-> array( y -> 2) ) ==      -> rows(x,true)
     *  5) x -> array( y-> array( z->1 ) , y-> array( z -> 2) ) ==      -> rows(x,true,y) 
     * 
     */
    private static function fetch_result( $index = false, $value = false , $index2 = false, $value2 = false )
    {
        $result = array( );
        if ( !$index )
        {
            while ( $row = mysqli_fetch_assoc( self::$query_id ) )
            {
                $result[] = $row;
            }
        }
        elseif ( $value === false )
        {
            while ( $row = mysqli_fetch_assoc( self::$query_id ) )
            {
                $key = $row[$index];
                unset( $row[$index] );
                $result[$key] = $row;
            }
        }
        elseif ( is_string ( $value ) )
        {
            while ( $row = mysqli_fetch_assoc( self::$query_id ) )
            {
                $result[$row[$index]] = $row[ $value ];
            }
        }
        elseif ( $value === true )
        {
            if ( is_string( $index2 ) )
            {
                if ( $value2 === false )
                {
                    while ( $row = mysqli_fetch_assoc( self::$query_id ) )
                    {
                        $key = $row[$index];
                        $key2 = $row[$index2];
                        unset( $row[$index] );
                        unset( $row[$index2] );

                        $result[$key][$key2] = $row;
                    }
                }
                else
                {
                    while ( $row = mysqli_fetch_assoc( self::$query_id ) )
                    {
                        $key = $row[$index];
                        $key2 = $row[$index2];
                        unset( $row[$index] );
                        unset( $row[$index2] );

                        $result[$key][$key2][] = $row;
                    }
                }
            }
            else
            {
                while ( $row = mysqli_fetch_assoc( self::$query_id ) )
                {
                    $key = $row[$index];
                    unset( $row[$index] );
                    $result[$key][] = $row;
                }
            }
        }

        return $result;
    }

    private static function fetch_row( $index = false )
    {
        $row = mysqli_fetch_assoc( self::$query_id );

        if ( empty( $row ) )
        {
            return array( );
        }
        elseif ( !$index )
        {
            return $row;
        }
        
        $key = $row[$index];
        unset( $row[$index] );
        
        return $result[$key] = $row;
    }
    
    private static function fetch_value( $field = null , $is_array = false )
    {
        if ( $is_array )
        {
            $result = array( );
            while ( $row = mysqli_fetch_assoc( self::$query_id ) )
            {
                $result[] = $row[$field];
            }
            
            return $result;
        }
        else
        {
            if ( !($row = mysqli_fetch_assoc( self::$query_id ) ) )
            {
                return FALSE;
            }

            return isset( $field ) ? $row[$field] : reset( $row ) ;
        }
    }

    public static function debug( $show = false )
    {
        self::$show_sql = $show;
    }

    public static function affected_rows()
    {
        return mysqli_affected_rows( self::$connection_id );
    }

    public static function num_rows()
    {
        return mysqli_num_rows( self::$query_id );
    }
    
    public static function _insert_id()
    {
        return mysqli_insert_id( self::$connection_id );
    }

    public static function insert_id()
    {
        if ( ( $rows = mysqli_affected_rows( self::$connection_id ) ) >= 0 )
        {
            return ( $id = mysqli_insert_id( self::$connection_id ) ) === 0 ? $rows : $id;
        }

        return FALSE;
    }

    public static function total_queries()
    {
        return self::$query_count;
    }

    private static function free_result()
    {
        @mysqli_free_result( self::$query_id );
    }

    public static function close()
    {
        if ( self::$connection_id )
            return mysqli_close( self::$connection_id );
    }

    static private function error( $error )
    {
        $error .= " mySQL error: " . mysqli_error( self::$connection_id ) . " ";
        $error .= " mySQL error code: " . mysqli_errno( self::$connection_id ) . " ";
        
        self::$error = $error;
        throw new Exception\Fatal( "$error" );
    }

    
    public static function secure_IN( $array )
    {
        return implode( ',', array_map( array( 'self', 'security' ), $array ) );
    }
    
    //no magic quotes , php > 4.3.0	
    public static function security( $value )
    {
        return is_null( $value ) ? 'NULL' 
                                :  ( is_int( $value ) ? intval( $value ) 
                                                    : ( is_float( $value )  ? floatval( $value ) 
                                                                             : ( "'" . self::ecape_string( $value ) . "'" )  ) );
    }
    
    public static function ecape_string( $value )
    {
        return mysqli_real_escape_string( self::$connection_id, $value  );
    }

    public static function transaction()
    {
        mysqli_query( self::$connection_id, "SET autocommit=0"  );
        mysqli_query( self::$connection_id, "START TRANSACTION"  );
        return mysqli_query( self::$connection_id , "BEGIN"  );
    }

    public static function commit()
    {
        return mysqli_query(  self::$connection_id, "COMMIT" );
    }

    public static function rollback()
    {
        return mysqli_query( self::$connection_id,"ROLLBACK" );
    }

    public static function get_found_rows()
    {
        self::$query_id = mysqli_query( self::$connection_id,"SELECT FOUND_ROWS()" );
        $data = self::fetch_row(  );
        return reset( $data );
    }

    public static function set_variable( $variable, $value )
    {
        return mysqli_query( self::$connection_id,"SET @" . $variable . " = '" . $value . "'" );
    }
    
    public static function set_variables( array $variables )
    {
        $query = '';
        foreach ( $variables as $key => $value ) 
        {
            $query .= "@$key = '$value' ,";
        }
        return mysqli_query( self::$connection_id,"SET " . substr( $query , 0 , -1 ) );
    }

    public static function get_variable( $variable )
    {
        self::$query_id = mysqli_query( self::$connection_id,"SELECT @" . $variable );
        $t = self::fetch_row( );
        return reset( $t );
    }
    
    
    public static function get_variables( )
    {
        self::$query_id = mysqli_query( self::$connection_id,"SELECT @" . implode( ',@', func_get_args() )  );
        return self::fetch_row();
    }

}

DB::connect( Config::$DB );