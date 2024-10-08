<?php

class Output
{

    static private $head = '';
    static private $body = '';
    static private $title = '';
    static public $base = '/'; //default RU
    static public $wysywyg = 0;//count of added wysywyg on page
    static public $ckfinder = 0;//count of ckfinders
    static public $wysywyg_file_path;//default file_path for ckfinder open

    static public $jquery = 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js';
    static public $jquery_ui = 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js';
    
    static public $debug = array();//output of cache , db queries

    static public $socials = array(
        'twitter' => array(
            'url' => 'https://twitter.com/dkphobos',
            'text' => 'Twitter'
        ),
        'instagram' => array(
            'url' => 'https://www.instagram.com/dkphobos_df/',
            'text' => 'Instagram'
        ),
        'discord' => array(
            'text' => 'Discord DkPhobos#4626'
        ),
        'twitch' => array(
            'url' => 'https://www.twitch.tv/Dk_Phobos',
            'text' => 'Twitch'
        ),
        'steam' => array(
            'url' => 'https://steamcommunity.com/id/Dk_Phobos',
            'text' => 'Steam'
        ),
        'vk' => array(
            'url' => 'https://vk.com/dkphobos_df',
            'text' => 'VK'
        ),
        'youtube-play' => array(
            'url' => 'https://www.youtube.com/c/DkPhobos',
            'text' => 'Youtube'
        ),
        'facebook' => array(
            'url' => 'https://www.facebook.com/kucherya.alexander',
            'text' => 'Facebook'
        ),
    );

    static public $admin_panel_words;
    CONST ADMIN_EDIT = 'edit';
    CONST ADMIN_GLOBAL_EDIT = 'edit_global';
    CONST ADMIN_DELETE = 'delete';
    CONST ADMIN_HIDE = 'hide';
    CONST ADMIN_SHOW = 'show';
    CONST ADMIN_ADD = 'add';
    CONST ADMIN_UPDATE = 'update';
    
    static public function js_scroll()
    {
        self::js( 'js/jquery.scroll' );
        return '<div id="page-scroll-up" class="a none" title="' . __('Top') . '"></div>';
    }

    static public function js( $filename, $domain = '' , $script_data = null )
    {
        static $data = array();
        if ( isset( $data[ $filename ] ) )
        {
            return;
        }
        $data[$filename] = true;
        
        if ( empty( $domain ) )
        {
            $filename .= ".js";
            $time = filemtime( ( Config::Public_HTML_PATH . $filename ) );
            self::$head .= '<script type="text/javascript" src="' . Config::$static_url . $filename . '?t=' . $time . '"></script>';
        }
        else
        {
            self::$head .= '<script type="text/javascript" src="' . $domain . '/' . $filename . '">' . $script_data . '</script>';
        }
    }

    static public function cdn_js( $url )
    {
        self::$head .= '<script type="text/javascript" src="' . $url . '"></script>';
    }

    static public function add_to_head( $string )
    {
        self::$head .= $string;
    }


    static public function jquery( $ui = false )
    {
        self::cdn_js( self::$jquery );
        if ( $ui )
        {
            //<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
            self::cdn_js( self::$jquery_ui );
        }
    }


    static public function css( $filename )
    {
        static $data = array();
        if ( isset( $data[ $filename ] ) )
        {
            return;
        }

        $data[$filename] = true;

        $time = filemtime( Config::Public_HTML_PATH . $filename . '.css');

        self::$head .= '<link rel="stylesheet" type="text/css" href="' . Config::$static_url . $filename . '.css?t=' . $time . '"></link>';
    }

    static public function favicon( $filename = 'favicon.ico' )
    {
        self::$head .= '<link rel="icon" href="' . Config::$static_url . $filename . '" type="image/x-icon"/>
        <link rel="shortcut icon" href="' . Config::$static_url . $filename . '" type="image/x-icon"/>
        <link rel="apple-touch-icon" sizes="180x180" href="' . Config::$static_url . 'images/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="' . Config::$static_url . 'images/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="' . Config::$static_url . 'images/favicon/favicon-16x16.png">
        <link rel="manifest" href="' . Config::$static_url . 'manifest/site.webmanifest">';
    }

    static public function encoding( $charset = 'utf-8' )
    {
        self::$head .= '<meta http-equiv="content-type" content="text/html; charset=' . $charset . '" />';
    }

    static public function title( $name = false , $return = false )
    {
        static $title = '';

        if ( $return !== false )
        {
            return $title;
        }
        if ( $name === false )
        {
            self::$head .= '<title>' . $title . ' - ' .  __( 'seo_title_suffix')  . '</title>';
        }
        else
        {
            $title = $name;
        }
    }

    static public function keywords( $text = false , $return = false )
    {
        static $keywords;

        if ( $return !== false )
        {
            return $keywords;
        }
        if ( $text === false )
        {
            self::$head .= '<meta name="keywords" content="' . ( isset( $keywords ) ? $keywords : ( 'seo_keywords_default' ) ) . '" />';
        }
        else
        {
            $keywords = $text;
        }
    }

    static public function description( $text = false , $return = false)
    {
        static $description = '';

        if ( $return !== false )
        {
            return $description;
        }
        if ( $text === false )
        {
            self::$head .= '<meta name="description" content="' . $description . '" />';
        }
        else
        {
            $description = $text;
        }
    }
    
    static public function seo( array &$data )
    {
        self::title( $data['seo_title'] );
        self::description( $data['seo_description'] );
        self::keywords( $data['seo_keywords'] );
    }

    static public function error( $msg )
    {
        if ( !empty( $msg ) )
        {
            return '<div class="error">' . $msg . '</div>';
        }
    }

    static public function errors( $errors, $messages )
    {
        foreach ( $errors as $key => $value )
        {
            if ( $value )
            {
                return '<div class="error">' . ( isset( $messages[$key] ) ? $messages[$key] : $key ) . '</div>';
            }
        }
        return '';
    }

    static public function base()
    {
        self::$head .= '<base href="' . self::$base . '"></base>';
    }

    static public function text( $string )
    {
        return htmlspecialchars( $string );
    }

    static public function pages( $number, $count, $margin )
    {
        if ( $count < $margin * 2 + 1 )
        {
            return range( 1, $count );
        }

        $number = min( $count, max( $number, 1 ) );

        $min = $number - $margin;
        $max = $number + $margin;
        if ( $min < 1 )
        {
            $max += 1 - $min;
            $min = 1;
        }
        elseif ( $max > $count )
        {
            $min -= $max - $count;
            $max = $count;
        }
        if ( $min <= 3 )
        {
            $min = 1;
        }
        if ( $max >= $count - 2 )
        {
            $max = $count;
        }
        $result = range( $min, $max );
        if ( $min > 3 )
        {
            array_unshift( $result, 1, 'prev' );
        }

        if ( $max < $count - 2 )
        {
            array_push( $result, 'next', $count );
        }

        return $result;
    }

    static public function head()
    {
        self::base();
        self::encoding( Config::encoding );
        self::title();
        self::description();
        self::keywords();
        self::favicon();
        self::wysywyg();

        return self::$head;
    }

    static public function body( $content = false )
    {
        if ( $content === false )
        {
            return self::$body;
        }
        else
        {
            self::$body = &$content;
        }
    }

    static public function json( $data, $die = true )
    {
        //header('Content-type: application/json');
        print json_encode( $data );
        if ( $die )
        {
            die();
        }
    }

    static public function input_session()
    {
        return '<input type="hidden" name="' . Session::get( 'session_var' ) . '" value="' . Session::get( 'session_value' ) . '">';
    }

    static public function href_session()
    {
        return Session::get( 'session_var' ) . '=' . Session::get( 'session_value' );
    }


    /**
     * args : 
     * 1-st arg : string classes
     * 2 - N args : array( RULE_ID , ELEMENT , ADMIN_HREF ) OR HTML
     * 
     * @see /modules/partners/partners.tpl
     * @return html 
     */
    static public function admin_panel( )
    {
        $args = func_get_args();
        $class = array_shift( $args );
         
        $show = false;
        $buffer = '';
        foreach ( $args as $value )
        {
            if ( !is_array( $value ) )
            {
                $buffer .= $value;
            }
            else
            {
                if ( is_null( $value[0] ) || Auth::rule( $value[0] ) )
                {
                    $show = true;
                    $url = ( strpos ( $value[2] , 'http://') === FALSE ? Page::admin( $value[2] ) : $value[2] );
                    if ( in_array( $value[1] , array( self::ADMIN_DELETE , self::ADMIN_HIDE, self::ADMIN_SHOW , self::ADMIN_UPDATE ) ) )
                    {
                        $buffer .= '<a href="' . ( $url . '&' . self::href_session() ) . '" class="' . $value[1] . '" onclick="return window.confirm(&apos;' . ( 'Вы уверены?' ) . '&apos;);">' . ( isset( $value[3]  ) ? $value[3] : self::$admin_panel_words[ $value[1] ] ) . '</a>';
                    }
                    else
                    {
                        $buffer .= '<a href="' .  $url . '" class="' . $value[1] . '">' . ( isset( $value[3]  ) ? $value[3] : self::$admin_panel_words[ $value[1] ] ) . '</a>';
                    }
                }
            }
        }

        if ( !$show )
        {
            return '';
        }

        return '<div class="popup admin ' . $class . '">'
            . '<img src="' . Config::$static_url . 'images/system/edit.png" alt="edit" title="edit">'
            . '<div class="popup_menu">' . $buffer . '</div>'
            . '</div>';
    }
    
    
    static public function edit( $rule , $path, $class = '' )
    {
        if ( !is_null ( $rule ) && !Auth::rule( $rule ) )
        {
            return false;
        }

        return '<a class="' . $class . '" href="' . Page::admin( $path ) . '"><img src="' . Config::$static_url . 'images/system/edit.png" alt="edit" title="edit"></a>';
    }
    
    
    static public function add( $rule , $path, $class = '' )
    {
        if ( !is_null ( $rule ) && !Auth::rule( $rule ) )
        {
            return false;
        }

        return '<a class="' . $class . '" href="' . Page::admin( $path ) . '"><img src="' . Config::$static_url . 'images/system/add.png" alt="add" title="add"></a>';
    }
    
    static public function delete( $rule, $path, $class = '' )
    {
        if ( !is_null ( $rule ) && !Auth::rule( $rule ) )
        {
            return false;
        }

        return '<a onclick="return window.confirm(\'' . ( 'Вы уверены?' ) . '\')" class="' . $class . '" href="' . Page::admin( $path . '&' . self::href_session() ) . '"><img src="' . Config::$static_url . 'images/system/delete.png" alt="delete" title="delete"></a>';
    }

    static private function wysywyg()
    {
        if ( self::$wysywyg )
        {
            self::js( 'js/ckeditor/ckeditor' );
            self::js( 'js/ckeditor/config' );
            self::js( 'js/ckfinder/ckfinder.js' , 'http://' . Input::server('HTTP_HOST') );

            $editors = $subfolder =  '';
            if ( isset( self::$wysywyg_file_path ) )
            {
                $subfolder = ", startupPath : '" . self::$wysywyg_file_path . "'";
            }

            for ($i = 1; $i <= self::$wysywyg ; $i++)
            {
                $editors .= "var editor_$i = CKEDITOR.replace('wysywyg_" . $i . "');CKFinder.setupCKEditor( editor_$i , { basePath : '/js/ckfinder' $subfolder } );";
            }
            self::$head .= '<script type="text/javascript">$(document).ready(function() {CKEDITOR.config.language = "' . Localka::$lang . '";CKEDITOR.config.templates_files = [ "/js/ckeditor/plugins/templates/templates/navi_' . Localka::$lang . '.js" ]; '. $editors . '});</script>';
        }

        if ( self::$ckfinder )
        {
            if ( !self::$wysywyg )
            {
                self::js( 'js/ckfinder/ckfinder.js' , 'http://' . Input::server('HTTP_HOST') );
            }
            self::js( 'js/ckfinder_select_file' );
        }
    }

    static private function wysywyg_ckedtior_5()
    {
        if ( self::$wysywyg )
        {
            self::js( 'js/ckeditor/build/ckeditor.js' , Config::$root_url );
            self::js( 'js/ckfinder/ckfinder.js', Config::$root_url );

            $editors = $subfolder =  '';
            if ( isset( self::$wysywyg_file_path ) )
            {
                $subfolder = ", startupPath : '" . self::$wysywyg_file_path . "'";
            }

            for ($i = 1; $i <= self::$wysywyg ; $i++)
            {
                $editors .= "ClassicEditor
                    .create( document.querySelector( '#wysywyg_$i' ), {
                ckfinder: {
                    uploadUrl: '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
                },
				toolbar: {
					items: [
                         'ckfinder', 
                         'imageUpload', 
                         '|',
						'heading',
						'|',
						'fontSize',
						'link',
						'alignment',
						'bulletedList',
						'numberedList',
						'|',
						'indent',
						'outdent',
						'|',
						'blockQuote',
						'insertTable',
						'mediaEmbed',
						'horizontalLine',
						'removeFormat', 
						'Templates',
					]
				},
				language: 'ru',
				resize: {
                    minHeight: 500,
                },
				image: {
					toolbar: [
						'imageTextAlternative',
						'imageStyle:full',
						'imageStyle:side'
					]
				},
				table: {
					contentToolbar: [
						'tableColumn',
						'tableRow',
						'mergeTableCells',
						'tableCellProperties',
						'tableProperties'
					]
				},
				licenseKey: '',
				
			} ).then( editor => {
                     
                    } )
                    .catch( error => {
                        console.error( error );
                    } );";
            }
            self::$head .= '<script type="text/javascript">$(document).ready(function() {' . $editors . '  ClassicEditor.builtinPlugins.map( plugin => plugin.pluginName );});</script>';
        }

        if ( self::$ckfinder )
        {
            if ( !self::$wysywyg )
            {
                self::js( 'js/ckfinder/ckfinder.js', Config::$root_url );
            }
            self::js( 'js/ckfinder_select_file.js', Config::$root_url );
        }
    }
    
    
    static public function admin_title( $title , $lang = true )
    {
        $title .= ( $lang ?  ' , lang = ' . Localka::$lang  : '' );
        self::title( strip_tags( $title ) );
        return "<h1>$title</h1>";
    }
    
    public static function affected_rows( $count = null )
    {
        return isset( $count ) ? '<div class="success">' . ('OK. Измненео строк:') . ' ' . $count .'</div>' 
                        : '';
    }
    
    
    public static function table_header( array $fields , $url , $counter_width = null )
    {
        $html = '<tr>';
        if ( isset ( $counter_width ) )
        {
            $html .= '<td width="' . $counter_width . '">#</td>';
        }
        foreach ( $fields as $key => $row )
        {
            $html .= '<td width="' . $row['width'] . '">';
            if ( !isset ( $row['order'] ) )
            {
                $html .= $row['text'];
            }
            else
            {
                if ( isset( $row['selected'] ) )
                {
                    $html .= '<a order_type="' . $row['order'] . '" href="' . $url . 'field=' . $key . '&order=' . ( $row['order'] == 'ASC' ? 'DESC' : 'ASC' ) . ( isset( $_GET['page'] ) ? '&page=' . $_GET['page'] : '' ) . '">' . $row['text'] . '</a>';
                }
                else
                {
                    $html .= '<a href="' . $url . 'field=' . $key . '&order=' . $row['order'] . '">' . $row['text'] . '</a>';
                }
            }
            $html .= '</td>';
        }
        return $html . '</tr>';
    }
    
    public static function delete_success()
    {
        return self::admin_title( ('Удаление') ) . 
                    '<div class="success">
                        OK.
                    </div>
                    <a onclick="history.go(-1)">back</a>';
    }
    
   
    
    public static function date_format( $time , $timestamp = false )
    {
        $time = $timestamp ? $time : strtotime( $time );
        $diff = time() - $time;
        
        if ( $diff < 0 )
        {
            return strftime( '%e %B %Y, %H:%M' , $time );//return date( 'j F Y, H:i' , $time );
        }

        if ( $diff < 60)
        {
            return $diff . ' ' . __('seconds') . ' ' . __('ago');
        }
        
        if( $diff < 3600 )
        {
            return round( $diff/60 ) . ' ' . __('minutes') . ' ' . __('ago');
        }
        
        if( $diff < 86400 )
        {
            return round( $diff / 3600 ) . ' ' . __('hours') . ' ' . __('ago');
        }
        
        if ( $diff < 259200 )//3 days
        {
            return round( $diff / 86400 ) . ' ' . __('days') . ' ' . __('ago');
        }
        
        return strftime( '%e %B %Y, %H:%M' , $time );//return date( 'j F Y, H:i' , $time );
    }
    
    public static function date_to_string( $date )//1 Январь 1970
    {
        return strftime( '%e %B %Y' , strtotime( $date ) );//return date( 'j F Y, H:i' , $time );
    }
    
    public static function  date_dayname( $date )
    {
        return strftime( '%A, %e %B' , strtotime( $date ) );//суббота, 5 июля
    }
    
    public static function  date_dayname_full( $date )
    {
        return strftime( '%A, %e %B %H:%M' , strtotime( $date ) );//суббота, 5 июля
    }
    
    
    public static function short_future_date( $time )
    {
        $interval = date_diff( date_create(), date_create( $time ) )->format("%yY,%mM,%dd,%hh,%im,%ss");
        
        $s = '';
        foreach ( explode(',', $interval ) as $format )
        {
            if ( $format[0] != '0' )
            {
                if ( $s != '' )
                {
                    $s .= $format;
                    break;
                }
                else
                {
                    $s .= $format . ' ';
                }
            }
        }
        return $s;
    }
    
    
    public static function _print( )
    {
        echo '<pre>';
        foreach ( func_get_args() as $value )
        {
            print_r( $value );
        }
        echo '</pre>';
    }
    
    
    public static function price( $price , $class = 'more' )
    {
        return "<span class='price round_medium $class'>$price</span>";
    }
    
    
    public static function date_picker( $name, $value = null, $class = null, $from = null )
    {
        
        self::js( 'js/jquery.date_picker' );
        self::css( 'css/jquery.date_picker' );
        return '<input maxlength="10" readony="readonly" name="' . $name. '" class="date_picker ' . $class . '" value="' . $value . '"' . ( isset( $from ) ? (' from="' . $from . '"' ) : '' ) . ' />';
    }
    
   
}

Output::$admin_panel_words = array(
    Output::ADMIN_EDIT          => __('Edit') ,
    Output::ADMIN_GLOBAL_EDIT   => __('Edit global') ,
    Output::ADMIN_DELETE        => __('Delete') ,
    Output::ADMIN_HIDE          => __('Hide') ,
    Output::ADMIN_SHOW          => __('Show') ,
    Output::ADMIN_ADD           => __('Add') ,
    Output::ADMIN_UPDATE           => __('Update') ,
);