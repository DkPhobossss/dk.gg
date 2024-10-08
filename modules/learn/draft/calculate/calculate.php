<?php

$this->teams = array(
    DOTA_2\Draft::TEAM_RADIANT => \DOTA_2\Hero::roles(),
    DOTA_2\Draft::TEAM_DIRE => \DOTA_2\Hero::roles()
);

$this->heroes = \DB\DOTA_2\Heroes::get_list();
