<?php
$this->args( 'selected' , 'data' , 'menu_type' );

switch ( $this->menu_type )
{
    case null :
    {
        $this->menu = $this->data;
        break;
    }
    
    case 'project' :
    {
        $this->menu = array(
            'project' => array(
                'url' => 'project' , 
                'name' => __('Organization'),
            ),
            'team' => array(
                'url' => 'project/team' , 
                'name' => __('Employers'),
            ),
            'press_pack' => array(
                'url' => 'project/press_pack' , 
                'name' => __('Press pack'),
            ),
        );
        break;
    }
    
    case 'read' : 
    {
        $this->menu = array(
            'news' => array(
                'url' => '' , 
                'name' => __('Team News'),
            ),
            'blogs' => array(
                'url' => 'blogs' , 
                'name' => __('Blogs'),
            ),
        );
        break;
    }
    
    case 'shop' : 
    {
        $this->menu = array();
        break;
    }
}

if ( isset( $this->selected ) )
{
    $this->menu[ $this->selected ]['selected'] = true; 
}
else
{
    reset($this->menu);
    $this->menu[ key( $this->menu ) ]['selected'] = true;
}