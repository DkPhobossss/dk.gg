<?php
    $this->args( 'html_class' , 'class' , 'id' , 'url' , 'page' );
    $Comment_class = $this->class;
    
    $this->fields = array(
        'id' => array(
            'text' => __('New'),
            'order' => 'ASC'
        ),
        'rating' => array(
            'text' => __('Best'),
            'order' => 'DESC'
        )
    );


    if ( !array_key_exists( $field = ( Input::request( 'field', 'id' ) ), $this->fields ) )
    {
        $field = 'id';
    }

    $this->fields[ $field ][ 'selected' ] = true;
    $this->fields[ $field ][ 'order' ] = ( $order = Input::request('order') == 'ASC' ? 'ASC' : ( Input::request('order') == 'DESC' ? 'DESC' : $this->fields[ $field ]['order'] )  );


    if ( $this->page === 'last')
    {
        $this->comments = $Comment_class::get_short_comments( $this->id , null , $Comment_class::$comments_per_page , $field, $order , true );
        
        $this->total = DB::get_found_rows();
        $total_pages = ceil( $this->total / $Comment_class::$comments_per_page );
        
        $this->page = $total_pages;
    }
    else
    {
        $this->comments = $Comment_class::get_short_comments( $this->id , $this->page , $Comment_class::$comments_per_page , $field, $order  );
        
        $this->total = DB::get_found_rows();
        $total_pages = ceil( $this->total / $Comment_class::$comments_per_page );
    }
    
    $this->pagination_html = $this->module( '/blocks/pagination' , 'right_text'  , $total_pages , $this->page , $this->url . '?page=' , false , 'comments' );
    
    
    $this->offset = ( $this->page - 1 ) * $Comment_class::$comments_per_page;