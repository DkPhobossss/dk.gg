<?php

$this->access = Auth::rule( Auth::WIKI );

$this->data = DB\Learn\Glossary::get_popular_terms( 4 );

