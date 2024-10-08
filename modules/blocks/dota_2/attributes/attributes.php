<?php
$this->args('primary_attribute');

$this->data = DB\DOTA_2\Heroes::get_by_attr( $this->primary_attribute );

