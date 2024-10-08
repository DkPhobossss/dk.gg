<?php
$this->args( 'hero_count' );

$this->macrotasks = DB\DOTA_2\Heroes_macrotask::DATA();
foreach ( array(
    DB\DOTA_2\Heroes_macrotask::MACRO_TASK_ROSHAN_PROTECT,
    DB\DOTA_2\Heroes_macrotask::MACRO_TASK_RUNES,
    DB\DOTA_2\Heroes_macrotask::MACRO_TASK_ROSHAN,
    DB\DOTA_2\Heroes_macrotask::MACRO_TASK_BAIT,
    DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_EARLY_TEMPO,
    DB\DOTA_2\Heroes_macrotask::MACRO_TASK_SCOUT,
    DB\DOTA_2\Heroes_macrotask::MACRO_TASK_MOVE,
    DB\DOTA_2\Heroes_macrotask::MACRO_TASK_CARRY_MID_TEMPO
) as $value)
{
    unset( $this->macrotasks[ $value ] );
}


$this->roles_description = \DOTA_2\Hero::roles();

$this->data = DB\DOTA_2\Heroes_role::get_random_heroes( intval( $this->hero_count ) );