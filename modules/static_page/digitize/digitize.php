<?php

$this->text_blocks = DB\Text_blocks::get_by_page( DB\Text_blocks::PAGE_DIGITIZE );
$this->data = Skills::get();