<?
class Template
{

    public static function content_DEEP( $title, $description, $module = null )
    {
        return "<div class='top_medium'>    
                            <div class='square'></div>
                            <div class='square'></div>
                            <div class='square'></div>
                        " . $module->module('/blocks/breadcrumb' , $title ) . "<div class='row'>$description</div></div>";
    }

    public static function content_DEFAULT( $title, $module )
    {
        return '<div id="default_template">' . $module->module('/blocks/breadcrumb' , $title ) . '</div>';
    }

    public static function content_DESCRIPTION( $title, $description, $module )
    {
        return "<div class='top_small'>
                " . $module->module('/blocks/breadcrumb' , $title ) . "
            <div class='row'>
                <div class='info'>
                    $description
                </div>
            </div>
            </div>";
    }

    /**
     * @string $module_data
     *
     * /module_path/value:value2|path_2:/module_path_2/arg1:value,arg2:value2
     *
     * \MODULE $MODULE
     */
    public static function render_modules( $content , $module_data, $MODULE )
    {
        $modules = explode('|' , $module_data );
        foreach ( $modules as $module_string )
        {
            $data = explode(':' , $module_string );
            $data[0] = '/blocks/' . $data[0];
            if ( file_exists( Config::SITE_ROOT . 'modules' .  $data[0] ) )
            {
                $temp_module_content = call_user_func_array( array( $MODULE, 'module' ), $data );

                $content = str_replace( '{{' . $data[0] . '}}' , $temp_module_content , $content, $count );
                if ( $count === 0 )
                {
                    $content .= $temp_module_content;
                }
            }
        }

        return $content;
    }
}