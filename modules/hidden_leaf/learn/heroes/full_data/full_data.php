<?php

$this->macrotasks = DB\DOTA_2\Heroes_macrotask::DATA();

$this->data = DB\DOTA_2\Heroes_role::get_all_heroes_roles();

$this->roles_description = \DOTA_2\Hero::roles();