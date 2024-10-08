<?php
class Skills
{
    public const GLOBAL_SKILLS_PERSONAL_PERSEVERANCE = 1;
    public const GLOBAL_SKILLS_PERSONAL_CRITIC = 2;
    public const GLOBAL_SKILLS_PERSONAL_PLANNING = 3;
    public const GLOBAL_SKILLS_PERSONAL_COMMUNICATION = 4;
    public const GLOBAL_SKILLS_PERSONAL_HEALTH = 5;

    public static $GLOBAL_SKILLS_PERSONAL = array(
        'skills' => array(
            self::GLOBAL_SKILLS_PERSONAL_PERSEVERANCE,
            self::GLOBAL_SKILLS_PERSONAL_CRITIC,
            self::GLOBAL_SKILLS_PERSONAL_PLANNING,
            self::GLOBAL_SKILLS_PERSONAL_COMMUNICATION,
            self::GLOBAL_SKILLS_PERSONAL_HEALTH,
        )
    );

    public const GLOBAL_SKILLS_CHARACTER_CALM = 6;
    public const GLOBAL_SKILLS_CHARACTER_SELF_ANALYS = 7;
    public const GLOBAL_SKILLS_CHARACTER_CORRECT_THINKING = 8;
    public const GLOBAL_SKILLS_CHARACTER_HUMOR = 9;


    public static $GLOBAL_SKILLS_CHARACTER = array(
        'skills' => array(
            self::GLOBAL_SKILLS_CHARACTER_CALM,
            self::GLOBAL_SKILLS_CHARACTER_SELF_ANALYS,
            self::GLOBAL_SKILLS_CHARACTER_CORRECT_THINKING,
            self::GLOBAL_SKILLS_CHARACTER_HUMOR,
        )
    );

    public const GLOBAL_SKILLS_COMMON_GAME_REACTION_SPEED = 10;
    public const GLOBAL_SKILLS_COMMON_GAME_DECISION_SPEED = 11;
    public const GLOBAL_SKILLS_COMMON_GAME_ATTENTION = 12;
    public const GLOBAL_SKILLS_COMMON_GAME_INTELLECT_UNDERSTANDING = 13;
    public const GLOBAL_SKILLS_COMMON_GAME_CALCULATION_SPEED = 14;
    public const GLOBAL_SKILLS_COMMON_GAME_STEAL = 15;
    public const GLOBAL_SKILLS_COMMON_GAME_REPLAY_WORK = 16;


    public static $GLOBAL_SKILLS_COMMON_GAME = array(
        'skills' => array(
            self::GLOBAL_SKILLS_COMMON_GAME_REACTION_SPEED,
            self::GLOBAL_SKILLS_COMMON_GAME_DECISION_SPEED,
            self::GLOBAL_SKILLS_COMMON_GAME_ATTENTION,
            self::GLOBAL_SKILLS_COMMON_GAME_INTELLECT_UNDERSTANDING,
            self::GLOBAL_SKILLS_COMMON_GAME_CALCULATION_SPEED,
            self::GLOBAL_SKILLS_COMMON_GAME_STEAL,
            self::GLOBAL_SKILLS_COMMON_GAME_REPLAY_WORK,
        )
    );


    public const GLOBAL_SKILLS_GAME_LASTHIT = 17;
    public const GLOBAL_SKILLS_GAME_AGGRO = 18;
    public const GLOBAL_SKILLS_GAME_BLOCK = 19;
    public const GLOBAL_SKILLS_GAME_CREEP_EQUILIBRIUM = 20;
    public const GLOBAL_SKILLS_GAME_HARASS = 21;
    public const GLOBAL_SKILLS_GAME_SKILLSHOTS = 22;
    public const GLOBAL_SKILLS_GAME_HERO_ITEMS = 23;
    public const GLOBAL_SKILLS_GAME_MACRO_TASK_MECHANIC = 24;
    public const GLOBAL_SKILLS_GAME_POOL = 25;
    public const GLOBAL_SKILLS_GAME_RESOURCE_MANAGMENT = 26;
    public const GLOBAL_SKILLS_GAME_MINIMAP = 27;
    public const GLOBAL_SKILLS_GAME_LANING = 35;

    public const GLOBAL_SKILLS_GAME_HERO_MACRO_TASK = 28;
    public const GLOBAL_SKILLS_GAME_ALLIED_MACRO_TASK = 29;
    public const GLOBAL_SKILLS_GAME_HEROES_DRAFT = 36;

    public const GLOBAL_SKILLS_GAME_HERO_POOL = 30;
    public const GLOBAL_SKILLS_GAME_HERO_POOL_MECHANIC = 31;
    public const GLOBAL_SKILLS_GAME_HERO_SPECIAL_KNOWLEDGE = 32;
    public const GLOBAL_SKILLS_GAME_HERO_PICK = 33;
    public const GLOBAL_SKILLS_GAME_HERO_SIGNATURE = 34;

    public static $GLOBAL_SKILLS_GAME = array(
        'skills' => array(
                self::GLOBAL_SKILLS_GAME_LASTHIT,
                self::GLOBAL_SKILLS_GAME_AGGRO,
                self::GLOBAL_SKILLS_GAME_BLOCK,
                self::GLOBAL_SKILLS_GAME_CREEP_EQUILIBRIUM,
                self::GLOBAL_SKILLS_GAME_LANING,
                self::GLOBAL_SKILLS_GAME_HARASS,
                self::GLOBAL_SKILLS_GAME_SKILLSHOTS,
                self::GLOBAL_SKILLS_GAME_HERO_ITEMS,
                self::GLOBAL_SKILLS_GAME_MACRO_TASK_MECHANIC,
                self::GLOBAL_SKILLS_GAME_POOL,
                self::GLOBAL_SKILLS_GAME_RESOURCE_MANAGMENT,
                self::GLOBAL_SKILLS_GAME_MINIMAP ,
                //macro
                self::GLOBAL_SKILLS_GAME_HERO_MACRO_TASK ,
                self::GLOBAL_SKILLS_GAME_ALLIED_MACRO_TASK ,
                self::GLOBAL_SKILLS_GAME_HEROES_DRAFT,
                self::GLOBAL_SKILLS_GAME_HERO_POOL,
                self::GLOBAL_SKILLS_GAME_HERO_POOL_MECHANIC,
                self::GLOBAL_SKILLS_GAME_HERO_SPECIAL_KNOWLEDGE,
                self::GLOBAL_SKILLS_GAME_HERO_PICK,
                self::GLOBAL_SKILLS_GAME_HERO_SIGNATURE,
            )
    );

    public static $data;

    public const MMR_RANGE_1 = 10;
    public const MMR_RANGE_2 = 20;
    public const MMR_RANGE_3 = 30;
    public const MMR_RANGE_4 = 40;
    public const MMR_RANGE_5 = 50;
    public const MMR_RANGE_6 = 60;
    public const MMR_RANGE_7 = 70;
    public const MMR_RANGE_8 = 80;
    public const MMR_RANGE_9 = 90;
    public const MMR_RANGE_10 = 100;
    public const MMR_RANGE_11 = 110;
    public const MMR_RANGE_12 = 120;
    public const MMR_RANGE_13 = 130;

    public const MMR = array(
        self::MMR_RANGE_1 => array(0, 2001),
        self::MMR_RANGE_2 => array(2002, 2617),
        self::MMR_RANGE_3 => array(2618, 3079),
        self::MMR_RANGE_4 => array(3080, 3541),
        self::MMR_RANGE_5 => array(3542, 4003),
        self::MMR_RANGE_6 => array(4004, 4619),
        self::MMR_RANGE_7 => array(4620, 5019),
        self::MMR_RANGE_8 => array(5020, 5649),
        self::MMR_RANGE_9 => array(5650, 5999),
        self::MMR_RANGE_10 => array(6000, 7249),
        self::MMR_RANGE_11 => array(7250, 8599),
        self::MMR_RANGE_12 => array(8600, 8999),
        self::MMR_RANGE_13 => array(9000, 10000)
    );

    public const RANKS = array(
        array(
            'start' => 0,
            'url' => '/images/medals/1-1.png',
            'text' => 'Herald'
        ),
        array(
            'start' => 154,
            'url' => '/images/medals/1-2.png',
            'text' => 'Herald'
        ),
        array(
            'start' => 308,
            'url' => '/images/medals/1-3.png',
            'text' => 'Herald'
        ),
        array(
            'start' => 462,
            'url' => '/images/medals/1-4.png',
            'text' => 'Herald'
        ),
        array(
            'start' => 616,
            'url' => '/images/medals/1-5.png',
            'text' => 'Herald'
        ),
        array(
            'start' => 770,
            'url' => '/images/medals/2-1.png',
            'text' => 'Guardian',
            'select' => true
        ),
        array(
            'start' => 924,
            'url' => '/images/medals/2-2.png',
            'text' => 'Guardian'
        ),
        array(
            'start' => 1078,
            'url' => '/images/medals/2-3.png',
            'text' => 'Guardian'
        ),
        array(
            'start' => 1232,
            'url' => '/images/medals/2-4.png',
            'text' => 'Guardian'
        ),
        array(
            'start' => 1386,
            'url' => '/images/medals/2-5.png',
            'text' => 'Guardian'
        ),
        array(
            'start' => 1540,
            'url' => '/images/medals/3-1.png',
            'text' => 'Crusader',
            'select' => true
        ),
        array(
            'start' => 1694,
            'url' => '/images/medals/3-2.png',
            'text' => 'Crusader'
        ),
        array(
            'start' => 1848,
            'url' => '/images/medals/3-3.png',
            'text' => 'Crusader'
        ),
        array(
            'start' => 2002,
            'url' => '/images/medals/3-4.png',
            'text' => 'Crusader'
        ),
        array(
            'start' => 2156,
            'url' => '/images/medals/3-5.png',
            'text' => 'Crusader'
        ),
        array(
            'start' => 2310,
            'url' => '/images/medals/4-1.png',
            'text' => 'Archon',
            'select' => true
        ),
        array(
            'start' => 2464,
            'url' => '/images/medals/4-2.png',
            'text' => 'Archon'
        ),
        array(
            'start' => 2618,
            'url' => '/images/medals/4-3.png',
            'text' => 'Archon'
        ),
        array(
            'start' => 2772,
            'url' => '/images/medals/4-4.png',
            'text' => 'Archon'
        ),
        array(
            'start' => 2926,
            'url' => '/images/medals/4-5.png',
            'text' => 'Archon'
        ),
        array(
            'start' => 3080,
            'url' => '/images/medals/5-1.png',
            'text' => 'Legend',
            'select' => true
        ),
        array(
            'start' => 3234,
            'url' => '/images/medals/5-2.png',
            'text' => 'Legend'
        ),
        array(
            'start' => 3388,
            'url' => '/images/medals/5-3.png',
            'text' => 'Legend'
        ),
        array(
            'start' => 3542,
            'url' => '/images/medals/5-4.png',
            'text' => 'Legend'
        ),
        array(
            'start' => 3696,
            'url' => '/images/medals/5-5.png',
            'text' => 'Legend'
        ),
        array(
            'start' => 3850,
            'url' => '/images/medals/6-1.png',
            'text' => 'Ancient',
            'select' => true
        ),
        array(
            'start' => 4004,
            'url' => '/images/medals/6-2.png',
            'text' => 'Ancient'
        ),
        array(
            'start' => 4158,
            'url' => '/images/medals/6-3.png',
            'text' => 'Ancient'
        ),
        array(
            'start' => 4312,
            'url' => '/images/medals/6-4.png',
            'text' => 'Ancient'
        ),
        array(
            'start' => 4466,
            'url' => '/images/medals/6-5.png',
            'text' => 'Ancient'
        ),
        array(
            'start' => 4620,
            'url' => '/images/medals/7-1.png',
            'text' => 'Divine',
            'select' => true
        ),
        array(
            'start' => 4820,
            'url' => '/images/medals/7-2.png',
            'text' => 'Divine'
        ),
        array(
            'start' => 5020,
            'url' => '/images/medals/7-3.png',
            'text' => 'Divine'
        ),
        array(
            'start' => 5220,
            'url' => '/images/medals/7-4.png',
            'text' => 'Divine'
        ),
        array(
            'start' => 5420,
            'url' => '/images/medals/7-5.png',
            'text' => 'Divine'
        ),
        array(
            'start' => 5650,
            'url' => '/images/medals/8-1.png',
            'text' => 'Immortal',
            'select' => true
        ),

        array(
            'start' => 7250,
            'url' => '/images/medals/8-2.png',
            'text' => 'Immortal top 1000',
            'select' => true
        ),
        array(
            'start' => 8600,
            'url' => '/images/medals/8-3.png',
            'text' => 'Immortal top 100',
            'select' => true
        ),
        array(
            'start' => 9700,
            'url' => '/images/medals/8-4.png',
            'text' => 'Immortal top 10',
            'select' => true
        ),
    );

    public static function ranks_json()
    {
        return json_encode( self::RANKS );
    }


    public static function get()
    {
        return array(
            //personal
            self::GLOBAL_SKILLS_PERSONAL_PERSEVERANCE => array(
                'range' => array(
                    self::MMR_RANGE_8 => ___('GLOBAL_SKILLS_PERSONAL_PERSEVERANCE_description'),
                ),
                'name' => __('GLOBAL_SKILLS_PERSONAL_PERSEVERANCE'),
                'description' => ___('GLOBAL_SKILLS_PERSONAL_PERSEVERANCE_text'),
                'image' => '1.jpg',
                'image_text' => ___('GLOBAL_SKILLS_PERSONAL_PERSEVERANCE_image_text'),
            ),
            self::GLOBAL_SKILLS_PERSONAL_CRITIC => array(
                'range' => array(
                    self::MMR_RANGE_6 => ___('SKILLS_PERSONAL_CRITIC_description'),
                ),
                'name' => __('SKILLS_PERSONAL_CRITIC'),
                'description' => ___('SKILLS_PERSONAL_CRITIC_text'),
                'image' => '2.jpg',
                'image_text' => ___('SKILLS_PERSONAL_CRITIC_image_text'),
            ),
            self::GLOBAL_SKILLS_PERSONAL_PLANNING => array(
                'range' => array(
                    self::MMR_RANGE_6 => ___('GLOBAL_SKILLS_PERSONAL_PLANNING_description'),
                ),
                'name' => __('GLOBAL_SKILLS_PERSONAL_PLANNING'),
                'description' => ___('GLOBAL_SKILLS_PERSONAL_PLANNING_text'),
                'image' => '3.jpg',
                'image_text' => ___('GLOBAL_SKILLS_PERSONAL_PLANNING_image_text'),
            ),
            self::GLOBAL_SKILLS_PERSONAL_COMMUNICATION => array(
                'range' => array(
                    self::MMR_RANGE_8 => ___('GLOBAL_SKILLS_PERSONAL_COMMUNICATION_description'),
                ),
                'name' => __('GLOBAL_SKILLS_PERSONAL_COMMUNICATION'),
                'description' => ___('GLOBAL_SKILLS_PERSONAL_COMMUNICATION_text'),
                'image' => '4.jpg',
                'image_text' => ___('GLOBAL_SKILLS_PERSONAL_COMMUNICATION_image_text'),
            ),
            self::GLOBAL_SKILLS_PERSONAL_HEALTH => array(
                'range' => array(
                    self::MMR_RANGE_9 => ___('GLOBAL_SKILLS_PERSONAL_HEALTH_description'),
                ),
                'name' => __('GLOBAL_SKILLS_PERSONAL_HEALTH'),
                'description' => ___('GLOBAL_SKILLS_PERSONAL_HEALTH_text'),
                'image' => '5.jpg',
                'image_text' => ___('GLOBAL_SKILLS_PERSONAL_HEALTH_image_text'),
            ),
            //character
            self::GLOBAL_SKILLS_CHARACTER_CALM => array(
                'range' => array(
                    self::MMR_RANGE_6 =>  ___("GLOBAL_SKILLS_CHARACTER_CALM_description_1"),
                    self::MMR_RANGE_8 => ___("GLOBAL_SKILLS_CHARACTER_CALM_description_2"),
                    self::MMR_RANGE_11 => ___("GLOBAL_SKILLS_CHARACTER_CALM_description_3"),
                    self::MMR_RANGE_12 =>  ___("GLOBAL_SKILLS_CHARACTER_CALM_description_4"),
                ),
                'name' => __('GLOBAL_SKILLS_CHARACTER_CALM'),
                'description' => ___('GLOBAL_SKILLS_CHARACTER_CALM_text'),
                'image' => '6.jpg',
                'image_text' => ___('GLOBAL_SKILLS_CHARACTER_CALM_image_text'),
            ),
            self::GLOBAL_SKILLS_CHARACTER_SELF_ANALYS => array(
                'range' => array(
                    self::MMR_RANGE_7 => ___('GLOBAL_SKILLS_CHARACTER_SELF_ANALYS_description'),
                ),
                'name' => __('GLOBAL_SKILLS_CHARACTER_SELF_ANALYS'),
                'description' => ___('GLOBAL_SKILLS_CHARACTER_SELF_ANALYS_text'),
                'image' => '7.jpg',
                'image_text' =>  ___('GLOBAL_SKILLS_CHARACTER_SELF_ANALYS_image_text'),
            ),
            self::GLOBAL_SKILLS_CHARACTER_CORRECT_THINKING => array(
                'range' => array(
                    self::MMR_RANGE_10 => ___('GLOBAL_SKILLS_CHARACTER_CORRECT_THINKING_description'),
                ),
                'name' => __('GLOBAL_SKILLS_CHARACTER_CORRECT_THINKING'),
                'description' => ___('GLOBAL_SKILLS_CHARACTER_CORRECT_THINKING_text'),
                'image' => '8.jpg',
                'image_text' => ___('GLOBAL_SKILLS_CHARACTER_CORRECT_THINKING_image_text'),
            ),
            self::GLOBAL_SKILLS_CHARACTER_HUMOR => array(
                'range' => array(
                    self::MMR_RANGE_4 => ___('GLOBAL_SKILLS_CHARACTER_HUMOR_description'),
                ),
                'name' => __('GLOBAL_SKILLS_CHARACTER_HUMOR'),
                'description' => ___('GLOBAL_SKILLS_CHARACTER_HUMOR_text'),
                'image' => '9.jpg',
                'image_text' => ___('GLOBAL_SKILLS_CHARACTER_HUMOR_image_text'),
            ),
            //common_game
            self::GLOBAL_SKILLS_COMMON_GAME_REACTION_SPEED => array(
                'range' => array(
                    self::MMR_RANGE_2 => ___('GLOBAL_SKILLS_COMMON_GAME_REACTION_SPEED_description_1'),
                    self::MMR_RANGE_6 => ___('GLOBAL_SKILLS_COMMON_GAME_REACTION_SPEED_description_2'),
                    self::MMR_RANGE_10 => ___('GLOBAL_SKILLS_COMMON_GAME_REACTION_SPEED_description_3'),
                    self::MMR_RANGE_12 => ___('GLOBAL_SKILLS_COMMON_GAME_REACTION_SPEED_description_4'),
                ),
                'name' => __('GLOBAL_SKILLS_COMMON_GAME_REACTION_SPEED'),
                'description' => ___('GLOBAL_SKILLS_COMMON_GAME_REACTION_SPEED_text'),
                'image' => '10.jpg',
                'image_text' => ___('GLOBAL_SKILLS_COMMON_GAME_REACTION_SPEED_image_text'),
            ),
            self::GLOBAL_SKILLS_COMMON_GAME_DECISION_SPEED => array(
                'range' => array(
                    self::MMR_RANGE_4 => ___('GLOBAL_SKILLS_COMMON_GAME_DECISION_SPEED_description_1'),
                    self::MMR_RANGE_10 => ___('GLOBAL_SKILLS_COMMON_GAME_DECISION_SPEED_description_2'),
                    self::MMR_RANGE_12 => ___('GLOBAL_SKILLS_COMMON_GAME_DECISION_SPEED_description_3'),
                ),
                'name' => __('GLOBAL_SKILLS_COMMON_GAME_DECISION_SPEED'),
                'description' => ___('GLOBAL_SKILLS_COMMON_GAME_DECISION_SPEED_text'),
                'youtube_data' => 'https://www.youtube.com/embed/QXefX43VILg?start=564&autoplay=1',
                'image_text' =>  ___('GLOBAL_SKILLS_COMMON_GAME_DECISION_image_text'),
                'image' => '11.jpg',
            ),
            self::GLOBAL_SKILLS_COMMON_GAME_ATTENTION => array(
                'range' => array(
                    self::MMR_RANGE_5 => ___('GLOBAL_SKILLS_COMMON_GAME_ATTENTION_description_1'),
                    self::MMR_RANGE_9 => ___('GLOBAL_SKILLS_COMMON_GAME_ATTENTION_description_2'),
                    self::MMR_RANGE_11 => ___('GLOBAL_SKILLS_COMMON_GAME_ATTENTION_description_3'),
                    self::MMR_RANGE_13 => ___('GLOBAL_SKILLS_COMMON_GAME_ATTENTION_description_4'),
                ),
                'name' => __('GLOBAL_SKILLS_COMMON_GAME_ATTENTION'),
                'description' => ___('GLOBAL_SKILLS_COMMON_GAME_ATTENTION_text'),
                'image' => '12.jpg',
                'image_text' => ___('GLOBAL_SKILLS_COMMON_GAME_ATTENTION_image_text'),
            ),
            self::GLOBAL_SKILLS_COMMON_GAME_INTELLECT_UNDERSTANDING => array(
                'range' => array(
                    self::MMR_RANGE_7 => ___('GLOBAL_SKILLS_COMMON_GAME_INTELLECT_UNDERSTANDING_description_1'),
                    self::MMR_RANGE_11 => ___('GLOBAL_SKILLS_COMMON_GAME_INTELLECT_UNDERSTANDING_description_2'),
                    self::MMR_RANGE_12 => ___('GLOBAL_SKILLS_COMMON_GAME_INTELLECT_UNDERSTANDING_description_3'),
                ),
                'name' => __('GLOBAL_SKILLS_COMMON_GAME_INTELLECT_UNDERSTANDING'),
                'description' => ___('GLOBAL_SKILLS_COMMON_GAME_INTELLECT_UNDERSTANDING_text'),
                'image' => '13.jpg',
                'image_text' => ___('GLOBAL_SKILLS_COMMON_GAME_INTELLECT_UNDERSTANDING_image_text'),
            ),
            self::GLOBAL_SKILLS_COMMON_GAME_CALCULATION_SPEED => array(
                'range' => array(
                    self::MMR_RANGE_5 => ___('GLOBAL_SKILLS_COMMON_GAME_CALCULATION_SPEED_description_1'),
                    self::MMR_RANGE_10 => ___('GLOBAL_SKILLS_COMMON_GAME_CALCULATION_SPEED_description_2'),
                    self::MMR_RANGE_12 => ___('GLOBAL_SKILLS_COMMON_GAME_CALCULATION_SPEED_description_3'),
                ),
                'name' => __('GLOBAL_SKILLS_COMMON_GAME_CALCULATION_SPEED'),
                'description' => ___('GLOBAL_SKILLS_COMMON_GAME_CALCULATION_SPEED_text'),
                'image' => '14.jpg',
                'image_text' => ___('GLOBAL_SKILLS_COMMON_GAME_CALCULATION_SPEED_image_text'),
            ),
            self::GLOBAL_SKILLS_COMMON_GAME_STEAL => array(
                'range' => array(
                    self::MMR_RANGE_6 => ___('GLOBAL_SKILLS_COMMON_GAME_STEAL_description_1'),
                    self::MMR_RANGE_11 => ___('GLOBAL_SKILLS_COMMON_GAME_STEAL_description_2'),
                ),
                'name' => __('GLOBAL_SKILLS_COMMON_GAME_STEAL'),
                'description' => ___('GLOBAL_SKILLS_COMMON_GAME_STEAL_text'),
                'image' => '15.jpg',
                'image_text' => ___('GLOBAL_SKILLS_COMMON_GAME_STEAL_image_text'),
            ),
            self::GLOBAL_SKILLS_COMMON_GAME_REPLAY_WORK => array(
                'range' => array(
                    self::MMR_RANGE_7 => ___('GLOBAL_SKILLS_COMMON_GAME_REPLAY_WORK_description_1'),
                    self::MMR_RANGE_9 => ___('GLOBAL_SKILLS_COMMON_GAME_REPLAY_WORK_description_2'),
                    self::MMR_RANGE_11 => ___('GLOBAL_SKILLS_COMMON_GAME_REPLAY_WORK_description_3'),
                ),
                'name' => __('GLOBAL_SKILLS_COMMON_GAME_REPLAY_WORK'),
                'description' => ___('GLOBAL_SKILLS_COMMON_GAME_REPLAY_WORK_text'),
                'image' => '16.jpg',
                'image_text' => ___('GLOBAL_SKILLS_COMMON_GAME_REPLAY_WORK_image_text'),
            ),
            //game
            //micro
            self::GLOBAL_SKILLS_GAME_LASTHIT => array(
                'range' => array(
                    self::MMR_RANGE_1 => ___('GLOBAL_SKILLS_GAME_LASTHIT_description_1'),
                    self::MMR_RANGE_2 => ___('GLOBAL_SKILLS_GAME_LASTHIT_description_2'),
                    self::MMR_RANGE_3 => ___('GLOBAL_SKILLS_GAME_LASTHIT_description_3'),
                    self::MMR_RANGE_4 => ___('GLOBAL_SKILLS_GAME_LASTHIT_description_4'),
                    self::MMR_RANGE_5 => ___('GLOBAL_SKILLS_GAME_LASTHIT_description_5'),
                    self::MMR_RANGE_6 => ___('GLOBAL_SKILLS_GAME_LASTHIT_description_6'),
                    self::MMR_RANGE_7 => ___('GLOBAL_SKILLS_GAME_LASTHIT_description_7'),
                    self::MMR_RANGE_8 => ___('GLOBAL_SKILLS_GAME_LASTHIT_description_8'),
                    self::MMR_RANGE_10 => ___('GLOBAL_SKILLS_GAME_LASTHIT_description_9'),
                    self::MMR_RANGE_12 => ___('GLOBAL_SKILLS_GAME_LASTHIT_description_10'),
                ),
                'name' => __('GLOBAL_SKILLS_GAME_LASTHIT'),
                'description' => ___('GLOBAL_SKILLS_GAME_LASTHIT_text'),
                'image' => '17.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_LASTHIT_image_text'),
            ),
            self::GLOBAL_SKILLS_GAME_AGGRO => array(
                'range' => array(
                    self::MMR_RANGE_1 => ___('GLOBAL_SKILLS_GAME_AGGRO_description_1'),
                    self::MMR_RANGE_3 => ___('GLOBAL_SKILLS_GAME_AGGRO_description_2'),
                    self::MMR_RANGE_5 => ___('GLOBAL_SKILLS_GAME_AGGRO_description_3'),
                    self::MMR_RANGE_7 => ___('GLOBAL_SKILLS_GAME_AGGRO_description_4'),
                    self::MMR_RANGE_9 => ___('GLOBAL_SKILLS_GAME_AGGRO_description_5'),
                    self::MMR_RANGE_12 => ___('GLOBAL_SKILLS_GAME_AGGRO_description_6'),
                ),
                'name' => __('GLOBAL_SKILLS_GAME_AGGRO'),
                'description' => ___('GLOBAL_SKILLS_GAME_AGGRO_text'),
                'image' => '18.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_AGGRO_image_text'),
            ),
            self::GLOBAL_SKILLS_GAME_BLOCK => array(
                'range' => array(
                    self::MMR_RANGE_1 => ___('GLOBAL_SKILLS_GAME_BLOCK_description_1'),
                    self::MMR_RANGE_3 => ___('GLOBAL_SKILLS_GAME_BLOCK_description_2'),
                    self::MMR_RANGE_5 => ___('GLOBAL_SKILLS_GAME_BLOCK_description_3'),
                    self::MMR_RANGE_8 => ___('GLOBAL_SKILLS_GAME_BLOCK_description_4'),
                    self::MMR_RANGE_11 => ___('GLOBAL_SKILLS_GAME_BLOCK_description_5'),
                ),
                'name' => __('GLOBAL_SKILLS_GAME_BLOCK'),
                'description' => ___('GLOBAL_SKILLS_GAME_BLOCK_text'),
                'youtube_data' => 'https://www.youtube.com/embed/92tn67YDXg0?start=1058&autoplay=1',
                'image' => '19.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_BLOCK_image_text'),
            ),
            self::GLOBAL_SKILLS_GAME_CREEP_EQUILIBRIUM => array(
                'range' => array(
                    self::MMR_RANGE_12 => null,
                ),
                'name' => __('GLOBAL_SKILLS_GAME_CREEP_EQUILIBRIUM'),
                'description' => ___('GLOBAL_SKILLS_GAME_CREEP_EQUILIBRIUM_text'),
                'image' => '20.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_CREEP_EQUILIBRIUM_image_text'),
            ),
            self::GLOBAL_SKILLS_GAME_HARASS => array(
                'range' => array(
                    self::MMR_RANGE_4 => ___('GLOBAL_SKILLS_GAME_HARASS_description_1'),
                    self::MMR_RANGE_7 => ___('GLOBAL_SKILLS_GAME_HARASS_description_2'),
                    self::MMR_RANGE_10 => ___('GLOBAL_SKILLS_GAME_HARASS_description_3'),
                ),
                'name' => __('GLOBAL_SKILLS_GAME_HARASS'),
                'description' => ___('GLOBAL_SKILLS_GAME_HARASS_text'),
                'image' => '21.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_HARASS_image_text'),
            ),
            self::GLOBAL_SKILLS_GAME_SKILLSHOTS => array(
                'range' => array(
                    self::MMR_RANGE_1 => ___('GLOBAL_SKILLS_GAME_SKILLSHOTS_description_1'),
                    self::MMR_RANGE_2 => ___('GLOBAL_SKILLS_GAME_SKILLSHOTS_description_2'),
                    self::MMR_RANGE_3 => ___('GLOBAL_SKILLS_GAME_SKILLSHOTS_description_3'),
                    self::MMR_RANGE_5 => ___('GLOBAL_SKILLS_GAME_SKILLSHOTS_description_4'),
                    self::MMR_RANGE_7 => ___('GLOBAL_SKILLS_GAME_SKILLSHOTS_description_5'),
                    self::MMR_RANGE_9 => ___('GLOBAL_SKILLS_GAME_SKILLSHOTS_description_6'),
                    self::MMR_RANGE_10 => ___('GLOBAL_SKILLS_GAME_SKILLSHOTS_description_7'),
                    self::MMR_RANGE_12 => ___('GLOBAL_SKILLS_GAME_SKILLSHOTS_description_8'),
                ),
                'name' => __('GLOBAL_SKILLS_GAME_SKILLSHOTS'),
                'description' => ___('GLOBAL_SKILLS_GAME_SKILLSHOTS_text'),
                'image' => '22.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_SKILLSHOTS_image_text'),
            ),
            self::GLOBAL_SKILLS_GAME_LANING => array(
                'range' => array(
                    self::MMR_RANGE_4 => ___('GLOBAL_SKILLS_GAME_LANING_description_1'),
                    self::MMR_RANGE_7 => ___('GLOBAL_SKILLS_GAME_LANING_description_2'),
                    self::MMR_RANGE_9 => ___('GLOBAL_SKILLS_GAME_LANING_description_3'),
                    self::MMR_RANGE_11 => ___('GLOBAL_SKILLS_GAME_LANING_description_4'),
                    self::MMR_RANGE_12 => ___('GLOBAL_SKILLS_GAME_LANING_description_5'),
                ),
                'name' => __('GLOBAL_SKILLS_GAME_LANING'),
                'description' => ___('GLOBAL_SKILLS_GAME_LANING_text'),
                'image' => '35.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_LANING_image_text'),
            ),
            self::GLOBAL_SKILLS_GAME_HERO_ITEMS => array(
                'range' => array(
                    self::MMR_RANGE_3 => ___('GLOBAL_SKILLS_GAME_HERO_ITEMS_description_1'),
                    self::MMR_RANGE_6 => ___('GLOBAL_SKILLS_GAME_HERO_ITEMS_description_2'),
                    self::MMR_RANGE_9 => ___('GLOBAL_SKILLS_GAME_HERO_ITEMS_description_3'),
                    self::MMR_RANGE_12 => ___('GLOBAL_SKILLS_GAME_HERO_ITEMS_description_4'),
                ),
                'name' => __('GLOBAL_SKILLS_GAME_HERO_ITEMS'),
                'description' => ___('GLOBAL_SKILLS_GAME_HERO_ITEMS_text'),
                'image' => '23.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_HERO_ITEMS_image_text'),
            ),
            self::GLOBAL_SKILLS_GAME_MACRO_TASK_MECHANIC => array(
                'range' => array(
                    self::MMR_RANGE_11 => ___('GLOBAL_SKILLS_GAME_MACRO_TASK_MECHANIC_description'),
                ),
                'name' => __('GLOBAL_SKILLS_GAME_MACRO_TASK_MECHANIC'),
                'description' => ___('GLOBAL_SKILLS_GAME_MACRO_TASK_MECHANIC_text'),
                'image' => '24.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_MACRO_TASK_MECHANIC_image_text'),
            ),
            self::GLOBAL_SKILLS_GAME_POOL => array(
                'range' => array(
                    self::MMR_RANGE_3 => ___('GLOBAL_SKILLS_GAME_POOL_description_1'),
                    self::MMR_RANGE_10 => ___('GLOBAL_SKILLS_GAME_POOL_description_2'),
                ),
                'name' => __('GLOBAL_SKILLS_GAME_POOL'),
                'description' => ___('GLOBAL_SKILLS_GAME_POOL_text'),
                'image' => '25.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_POOL_image_text'),
            ),
            self::GLOBAL_SKILLS_GAME_RESOURCE_MANAGMENT => array(
                'range' => array(
                    self::MMR_RANGE_6 => ___('GLOBAL_SKILLS_GAME_RESOURCE_MANAGMENT_description'),
                ),
                'name' => __('GLOBAL_SKILLS_GAME_RESOURCE_MANAGMENT'),
                'description' => ___('GLOBAL_SKILLS_GAME_RESOURCE_MANAGMENT_text'),
                'image' => '26.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_RESOURCE_MANAGMENT_image_text'),
            ),
            self::GLOBAL_SKILLS_GAME_MINIMAP => array(
                'range' => array(
                    self::MMR_RANGE_2 => ___('GLOBAL_SKILLS_GAME_MINIMAP_description_1'),
                    self::MMR_RANGE_7 => ___('GLOBAL_SKILLS_GAME_MINIMAP_description_2'),
                    self::MMR_RANGE_10 => ___('GLOBAL_SKILLS_GAME_MINIMAP_description_3'),
                ),
                'name' => __('GLOBAL_SKILLS_GAME_MINIMAP'),
                'description' => ___('GLOBAL_SKILLS_GAME_MINIMAP_text'),
                'image' => '27.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_MINIMAP_image_text'),
            ),
            //macro
            self::GLOBAL_SKILLS_GAME_HERO_MACRO_TASK => array(
                'range' => array(
                    self::MMR_RANGE_11 => ___('GLOBAL_SKILLS_GAME_HERO_MACRO_TASK_description'),
                ),
                'name' => __('GLOBAL_SKILLS_GAME_HERO_MACRO_TASK'),
                'description' => ___('GLOBAL_SKILLS_GAME_HERO_MACRO_TASK_text'),
                'image' => '28.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_HERO_MACRO_TASK_image_text'),
            ),
            self::GLOBAL_SKILLS_GAME_ALLIED_MACRO_TASK => array(
                'range' => array(
                    self::MMR_RANGE_12 => ___('GLOBAL_SKILLS_GAME_ALLIED_MACRO_TASK_description'),
                ),
                'name' => __('GLOBAL_SKILLS_GAME_ALLIED_MACRO_TASK'),
                'description' => ___('GLOBAL_SKILLS_GAME_ALLIED_MACRO_TASK_text'),
                'image' => '29.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_ALLIED_MACRO_TASK_image_text'),
            ),
            self::GLOBAL_SKILLS_GAME_HEROES_DRAFT => array(
                'range' => array(
                    self::MMR_RANGE_11 => ___('GLOBAL_SKILLS_GAME_HEROES_DRAFT_description'),
                ),
                'name' => __('GLOBAL_SKILLS_GAME_HEROES_DRAFT'),
                'description' => ___('GLOBAL_SKILLS_GAME_HEROES_DRAFT_text'),
                'image' => '36.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_HEROES_DRAFT_image_text'),
            ),
            //heroes
            self::GLOBAL_SKILLS_GAME_HERO_POOL => array(
                'range' => array(
                    self::MMR_RANGE_3 => ___('GLOBAL_SKILLS_GAME_HERO_POOL_description_1'),
                    self::MMR_RANGE_5 => ___('GLOBAL_SKILLS_GAME_HERO_POOL_description_2'),
                    self::MMR_RANGE_8 => ___('GLOBAL_SKILLS_GAME_HERO_POOL_description_3'),
                    self::MMR_RANGE_10 => ___('GLOBAL_SKILLS_GAME_HERO_POOL_description_4'),
                    self::MMR_RANGE_12 => ___('GLOBAL_SKILLS_GAME_HERO_POOL_description_5'),
                ),
                'name' => __('GLOBAL_SKILLS_GAME_HERO_POOL'),
                'description' => ___('GLOBAL_SKILLS_GAME_HERO_POOL_text'),
                'image' => '30.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_HERO_POOL_image_text'),
            ),
            self::GLOBAL_SKILLS_GAME_HERO_POOL_MECHANIC => array(
                'range' => array(
                    self::MMR_RANGE_4 => ___('GLOBAL_SKILLS_GAME_HERO_POOL_MECHANIC_description_1'),
                    self::MMR_RANGE_6 => ___('GLOBAL_SKILLS_GAME_HERO_POOL_MECHANIC_description_2'),
                    self::MMR_RANGE_9 => ___('GLOBAL_SKILLS_GAME_HERO_POOL_MECHANIC_description_3'),
                    self::MMR_RANGE_12 => ___('GLOBAL_SKILLS_GAME_HERO_POOL_MECHANIC_description_4'),
                ),
                'name' => __('GLOBAL_SKILLS_GAME_HERO_POOL_MECHANIC'),
                'description' => ___('GLOBAL_SKILLS_GAME_HERO_POOL_MECHANIC_text'),
                'image' => '31.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_HERO_POOL_MECHANIC_image_text'),
            ),
            self::GLOBAL_SKILLS_GAME_HERO_SPECIAL_KNOWLEDGE => array(
                'range' => array(
                    self::MMR_RANGE_7 => ___('GLOBAL_SKILLS_GAME_HERO_SPECIAL_KNOWLEDGE_description_1'),
                    self::MMR_RANGE_9 => ___('GLOBAL_SKILLS_GAME_HERO_SPECIAL_KNOWLEDGE_description_2'),
                    self::MMR_RANGE_11 => ___('GLOBAL_SKILLS_GAME_HERO_SPECIAL_KNOWLEDGE_description_3'),
                    self::MMR_RANGE_12 => ___('GLOBAL_SKILLS_GAME_HERO_SPECIAL_KNOWLEDGE_description_4'),
                ),
                'name' => __('GLOBAL_SKILLS_GAME_HERO_SPECIAL_KNOWLEDGE'),
                'description' => ___('GLOBAL_SKILLS_GAME_HERO_SPECIAL_KNOWLEDGE_text'),
                'image' => '32.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_HERO_SPECIAL_KNOWLEDGE_image_text'),
            ),
            self::GLOBAL_SKILLS_GAME_HERO_PICK => array(
                'range' => array(
                    self::MMR_RANGE_9 => ___('GLOBAL_SKILLS_GAME_HERO_PICK_description'),
                ),
                'name' => __('GLOBAL_SKILLS_GAME_HERO_PICK'),
                'description' => ___('GLOBAL_SKILLS_GAME_HERO_PICK_text'),
                'image' => '33.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_HERO_PICK_image_text'),
            ),
            self::GLOBAL_SKILLS_GAME_HERO_SIGNATURE => array(
                'range' => array(
                    self::MMR_RANGE_8 => ___('GLOBAL_SKILLS_GAME_HERO_SIGNATURE_description_1'),
                    self::MMR_RANGE_10 => ___('GLOBAL_SKILLS_GAME_HERO_SIGNATURE_description_2'),
                    self::MMR_RANGE_11 => ___('GLOBAL_SKILLS_GAME_HERO_SIGNATURE_description_3'),
                    self::MMR_RANGE_12 => ___('GLOBAL_SKILLS_GAME_HERO_SIGNATURE_description_4'),
                ),
                'name' => __('GLOBAL_SKILLS_GAME_HERO_SIGNATURE'),
                'description' => ___('GLOBAL_SKILLS_GAME_HERO_SIGNATURE_text'),
                'image' => '34.jpg',
                'image_text' => ___('GLOBAL_SKILLS_GAME_HERO_SIGNATURE_image_text'),
            ),
        );
    }

    public static function data_json()
    {
        $data = self::get();
        foreach ( $data as $key => $row )
        {
            $data[$key] = array('range' => array_keys ( $row['range'] ) );
        }
        return json_encode( $data );
    }

    public static function ranges_json()
    {
        return json_encode( self::MMR );
    }
}

Skills::$GLOBAL_SKILLS_PERSONAL['name'] = ___('Global_skill_personal_name');
Skills::$GLOBAL_SKILLS_CHARACTER['name'] = ___('Global_skill_character_name');
Skills::$GLOBAL_SKILLS_COMMON_GAME['name'] = ___('Global_skill_common_game_name');
Skills::$GLOBAL_SKILLS_GAME['name'] = ___('Global_skill_game_name');
