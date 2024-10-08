<?php

/** DK POWER!
 * http://www.tvysoftware.com/library/gettext-php_multilng.html
 * http://linuxcommand.org/man_pages/xgettext1.html
 * http://rus-linux.net/nlib.php?name=/MyLDP/algol/gnu-gettext-tricks.html
 * 
 * Принцип более-менее нормальной работы с gettext : 
 * 1) Коннектимся по ssh
 * 2) find /home/navisite/navi-gaming.com/ -type f \( -name "*.php" -o -name "*.tpl" \) -print > list 
 *    Создает файл list , в котором с каждой новой строчки будут именна файлов .пхп и .тпл нашего проекта - В принципе это можно попробовать сразу передать в п.3 - но так имо надежнее
 * 3) xgettext -o foba.po -L PHP -x /home/navisite/messages.po -F -D navi-gaming.com/ --files-from list --from-code=utf-8
 *    Создает файл трансляции foba.po парсит все файлы из list(предыдущий шаг) и пропускает те слова , что переведены в messages.po
 *    Грубо говоря , когда переводим файл - оставляем его под именем messages.po в корне, чтоб при новом поиске слов нам не писались уже переведенные слова
 * 4) Забираем этот файл и отдаем переводчику, он качает прогу как-то поЕдитор и с помощью ее перевеодит и отдает нам переведенный .по файл( Прогу надо поколупать )
 * 5) msgfmt foba.po - транслируем в foba.mo
 *    Собственно это скомпиленый файл
 * 6) foba.po -> messages.po , foba.mo => /locale/lang/LC_MESSAGES/name.mo
 * 7) Может быть кеш
 * 
 *  /locale/tmp/- 777
 *  /locale/tmp/files_list - 666
 *  /locale/tmp/foba_ru.po - 666
 *  /locale/tmp/foba_en.po - 666
 *  /locale/tmp/foba_ru.mo - 666
 *  /locale/tmp/foba_en.mo - 666
 *  /locale/tmp/history_en/ - 777
 * 
 *     +file
 *  /locale/tmp/history_ru/ - 777
 *     +file
 * 
 *  /locale/lang/LC_MESSAGES/ - 777
 */
class Localka
{
    const RU = "ru";
    const EN = "en";
    const DEFAULT_LANGUAGE = self::RU;

    const LANGUAGES = array( self::RU , self::EN );

    public static $lang;

    public static $lang_url;
    
    public static $settings = array(
        self::RU => array(
            "text" => "русский",
            "url"  =>  null,
            "accept_language" => "ru_RU",
            'gamepedia_url' => 'https://dota2-ru.gamepedia.com/',
            'language' => 'russian'
        ),
        self::EN => array(
            "text" => "english",
            "url"  => "en",
            "accept_language" => "en_US",
            'gamepedia_url' => 'https://dota2.gamepedia.com/',
            'language' => 'english'
        )
    );

    public static function create_js()
    {
        foreach ( self::LANGUAGES as $lang )
        {
            file_put_contents(
                Config::Public_HTML_PATH . 'js/lang/' . $lang . '.js',
                'var BOOK = ' . json_encode( self::BOOK[ $lang ], JSON_UNESCAPED_UNICODE )
            );
        }
    }

    public const BOOK = array(
        self::RU =>array(
            "Select_cat" => "Выберите категорию",
            "Mactotask_main" => "Основные",
            "Mactotask_stable" => "Защита",
            "Mactotask_greed" => "Жадность",
            "Mactotask_agro" => "Агрессия",
            "Draft_battle_tempo_description" => "Сила драфта на каждом этапе игры.</br>Чем выше значение, тем сильнее пик на этом этапе игры.</br>Зависит от <a target='_blank' href='learn/glossarij/battle_tempo'>боевых темпов</a> героев, <a target='_blank' href='learn/glossarij/macro_task_teamfight'>тимфайта</a> и других <a target='_blank' href='learn/glossarij/macro_task'>макро-задач</a>",
            "Draft_analysys_description" => "Алгоритм <b>не учитвает</b> <a target='_blank' href='learn/glossarij/macro_task#synergy'>синергию</a> и <a target='_blank' href='learn/glossarij/macro_task#counter-pick'>контр-синергию</a> между героями.</br>В некоторых случаях анализ может быть не точным",
            "Draft_analysys" =>  "Анализ драфта",
            "Analysis" => "Анализ",
            "Refresh" => "Обновить",
            "Clean" => "Очистить",
            "dire" => "Силы Тьмы",
            "radiant" => "Силы Света",
            "Draft:calculate:title" => "Оценка драфта",
            "Draft:title" => "Выбор героя",
            "Macrotask_fight" => "Сражение" ,
            "Macrotask_objects" => "Объекты" ,
            "Macrotask_support" => "Поддержка" ,
            "min" => "мин",
            "Late_game" => "Поздняя игра",
            "Mid_game" => "Мидгейм",
            "Early_game" => "Ранняя игра",
            "Laning_stage" => "Лайнинг",
            "How_hard_is_to_handle_hero" => "Степень силы героя в рукопашном сражении по сравнению с другими",
            "More_information" => "Больше информации",
            "Hero_battle_tempo" => "Боевой темп",
            "No" => "Нет",
            "Yes" => "Да",
            "More_detailed_info" => "Более подробно о навыке",
            "Manacost" => "Требует маны",
            "Cooldown" => "Перезарядка",
            "Bkb_pierce" => "Пробивает невосприимчивость к магии",
            "Pure" => "Чистый",
            "Physical" => "Физический",
            "Magical" => "Магический",
            "Damage_type" => "Тип урона",
            "Edit_all_heroes_macrotasks" => "Редактировать все макрозадачи героев",
            "Macrotasks" => "Макрозадачи",
            "Macrotask_description_6" => "Прекрасно",
            "Macrotask_description_5" => "Очень хорошо",
            "Macrotask_description_4" => "Хорошо",
            "Macrotask_description_3" => "Средне",
            "Macrotask_description_2" => "Плохо",
            "Macrotask_description_1" => "Очень плохо",
            "Macrotask_description_0" => "Отвратительно",
            "Edit_hero_enemies_synergy" => "Редактировать анти-синергию с вражескими героями",
            "Edit_hero_allies_synergy" => "Редактировать синергию с союзниками",
            "Press_role_button_to_get_content" => "Нажмите кнопку выбора роли, чтоб получить описание",
            "Possible_game_roles" => "Возможные игровые роли",
            "Role" => "Игровая роль",
            "Role_Carry_2" => "Керри",
            "Role_Mid_2" => "Мид",
            "Role_Offlane_2" => "Оффлейн",
            "Role_Soft_support_2" => "Саппорт",
            "Role_Hard_support_2" => "Фулл саппорт",
            "Role_Carry" => "Легкая линия",
            "Role_Mid" => "Центральная линия",
            "Role_Offlane" => "Сложная линия",
            "Role_Soft_support" => "Частичная поддержка",
            "Role_Hard_support" => "Полная поддержка",
            "Armor" => "Броня",
            "Start_armor" => "Базовая броня",
            "Attack_reload" => "Интервал между атаками(сек)",
            "Attack_per_sec" => "Атак в секунду",
            "Damage" => "Урон",
            "MP_reg" => "Регенерация маны",
            "Start_mp" => "Начальная мана",
            "Start_mpreg" => "Начальная регенерация маны",
            "MP" => "Мана",
            "HP_reg" => "Регенерация здоровья",
            "HP" => "Здоровье",
            "Start_dmg_max" => "Базовый максимальный урон",
            "Start_dmg_min" => "Базовый минимальный урон",
            "Start_hpreg" => "Базовая регенерация здоровья",
            "Start_hp" => "Базовое здоровье",
            "Total_base_stats_inc" => "Прирост базовых статов",
            "Total_base_stats" => "Сумма базовых статов",
            "Strength_inc" => "Прирост силы",
            "Agility_inc" => "Прирост ловкости",
            "Intelligence_inc" => "Прирост интеллекта",
            "on_lvl" => "на уровне",
            "Primary_attribute" => "Основной атрибут",
            "Primary_attributes" => "Основные характеристики",
            "Hero" => "Герой",
            "Heroes_1" => "Описания всех героев",
            "Heroes_2" => "Популярные игровые роли",
            "Heroes_3" => "<a href='learn/glossarij/macro_task'>Макро-задачи</a>",
            "Heroes_4" => "Гайды на героев",
            "Heroes_5" => "<a href='learn/glossarij/synergy'>Синергия</a> и <a href='learn/glossarij/counter_pick'>контр-пики</a>",
            "Draft_1" => "Уникальный алгоритм по подбору героев",
            "Draft_2" => "Модуль для выбора героев в ММе",
            "Draft_3" => "Объяснение <a href='learn/glossarij/macro_task'>макро-задач</a> каждого драфта",
            "Draft_4" => "Учитывание <a href='learn/glossarij/synergy'>синергий</a> и <a href='learn/glossarij/counter_pick'>контр-пиков</a>",
            "Draft_5" => "Шансы на победу",
            "Draft_6" => "API для киберспортивных трансляций",
            "Glossary_1" => "Обширная база знаний",
            "Glossary_2" => "Гайды и видео по микро и макро механикам",
            "Glossary_3" => "Таблицы сравнений",
            "Glossary_4" => "Теория макро-игры, как тренировать микро навыки",
            "Glossary_5" => "Словарь игровых терминов",
            "Education_1" => "Как научиться играть в доту",
            "Education_2" => "Персональные тренировки",
            "Education_3" => "<a href='learn/glossarij/education#school'>Школа Dota 2</a>",
            "Education_4" => "Отзывы",
            "Education_5" => "Как поднять рейтинг",
            "Education" => "Обучение",
            "Heroes" => "Герои",
            "Draft" => "Выбор героя Dota 2",
            "Letter" => "Буква",
            "Heroes_list" => "Список героев",
            "Attack_interval" => "Интервал между атаками",
            "Attack_count" => "Количество атак",
            "second" => "секунда",
            "in second" => "в секунду",
            "in seconds" => "в секундах",
            "Aghanim_effect" => "Эффект от Аганима",
            "Talent_tree" => "Древо талантов",
            "Aghanim" => "Аганим",
            "for" => "для",
            "Aghanims_reason" => "что дает аганим",
            "Talents" => "Таланты",
            "Description" => "Описание",
            "Number_of_legs" => "Количество ног",
            "Strength" => "Сила",
            "Agility" => "Ловкость",
            "Intelligence" => "Интеллект",
            "Base_stats" => "Атрибуты",
            "Attack_stats" => "Атака",
            "Defend_stats" => "Защита",
            "Move_stats" => "Перемещение",
            "Melee_fighter" => "Ближний бой",
            "Attack" => "Урон",
            "Attack_speed" => "Скорость атаки",
            "Attack_range" => "Дальность атаки",
            "Attack_animation" => "Анимация атаки",
            "Projectile_speed" => "Скорость полета снаряда",
            "Armor" => "Броня",
            "Magic_resistance" => "Магическое сопротивление",
            "Damage_block" => "Блокирование урона",
            "Move_speed" => "Скорость передвижения",
            "Turn_rate" => "Скорость поворота",
            "Vision_day/night" => "Дальность обзора днем/ночью",
            "Collision_size" => "Размер модельки героя",
            "Edit_hero_role_description" => "Редактировать описание игровой роли",
            "Edit_hero_role" => "Редактировать игровую роль",
            "Add_hero_role" => "Добавить игровую роль",
            "Update_hero" => "Синхронизировать героя",
            "Update_hero_with_description" => "Синхронизировать героя с описанием",
            "Update_heroes_list" => "Синхронизировать ВСЕХ героев",
            "Update_heroes_aghanims" => "Синхронизировать аганимов",
            "Update_heroes_talents" => "Синхронизировать описания талантов",
            "Popular_terms" => "ПОПУЛЯРНЫЕ ТЕРМИНЫ",
            "error_forbidden" => "Доступ зарпещен",
            "error_fatal" => "Ошибка сервера",
            "error_not_found" => 'Запрашиваемая страница не найдена',
            "go back" => "Назад",
            "seo_title_suffix" => Config::SITE_NAME,
            "password_short" => "Длина пароля КРАЙНЕ мала(хотя бы 8 символов)",
            "password_mismatch" => "Пароли не совпадают",
            "email_not_correct" => "Email указан не верно",
            "email_exist" => "Такой email уже используется",
            "email_not_exist" => "Такого email не существует",
            "login_not_correct" => "Логин может содержать только английские буквы, цифры и нижнее подчеркивание, минимум 3 символа",
            "login_and_password_invalid" => "Логин и пароль не найдены",
            "login_exist" => "Такой логин уже используется",
            "name_not_correct" => "Длина имени должна быть более 2 символов",
            "captcha_check_failed" => "Проверка на капчу не пройдена. Попробуйте еще раз",
            "protector_spam" => "Вы слишком часто выполняете это действие. Попробуйте позже",
            "register_on_site" => "Регистрация на сайте",
            "registered_on_site" => "Спасибо за регистрацию на сайте!",
            "your_login_is" => "Ваш логин",
            "your_password_is" => "Ваш пароль",
            "mail_error" => "Ошибка при отправке email",
            "user_register_error" => "Ошибка при регистрации пользователя",
            "here" => "здесь",
            "activated_link" => "Чтоб активировать ваш аккаунт, нажмите",
            "register_success" => "Вы успешно зарегистрировались. Чтоб активировать аккаунт, перейдите по ссылке в письме.",
            "User_activation" => "Активация пользователя",
            "User_activation_success" => "Ваш аккаунт удачно авторизован",
            "error_User_activation_0" => "Ваш аккаунт не авторизован",
            "error_already_logon"=> "Вы уже залогинены",
            "or" => "или",
            "Register" => "Зарегистрироваться",
            "Registration" => "Регистрация",
            "Login" => "Войти",
            "Forgot_password" => "Забыли пароль",
            "Send" => "Отправить",
            "logout" => "Выйти",
            "forgot_password_theme" => "Восстановление пароля",
            "to_recover_your_password" => "чтоб восстановить пароль",
            "forgot_password_send_success" => "Вам на почту высланы инструкции по восстановлению пароля",
            "Forgot_password_success" => "Пароль успешно изменен",
            "Click_on_link" => "Нажмите по ссылке",
            "forgot_password_hash_expired" => "Время действия данного кода истекло",
            "Hello" => "Привет",
            "Socials" => "Мои социальные сети",
            "Under_construction" => "В разработке",
            "Root" => "Начни",
            "Learn" => "Учись",
            "Digitize" => "Оцифруйся",
            "Digitize:description" => "Описание страницы оцифруй себя",
            "Digitize:keywords" => "Ключевые слова страницы оцифруй себя",
            "Watch" => "Смотри",
            "Read" => "Читай",
            "About_me" => "Узнай",
            "Waiting for TI 10" => "Ожидание The International 10",
            "Edit" => "Редактировать",
            "Edit global" => "Редактировать Глобально",
            "Delete"=> "Удалить",
            "Hide" => "Спрятать",
            "Show" => "Показать",
            "Add" => "Добавить",

            "Global_skill_personal_name" => "Навыки личности",
            "Global_skill_character_name" => "Навыки характера",
            "Global_skill_common_game_name" => "Навыки общеигровые",
            "Global_skill_game_name" => "Навыки игровые",

            "GLOBAL_SKILLS_PERSONAL_PERSEVERANCE" => "Усидчивость",
            "SKILLS_PERSONAL_CRITIC" => "Прислушиваться к критике",
            "GLOBAL_SKILLS_PERSONAL_PLANNING" => "Планирование",
            "GLOBAL_SKILLS_PERSONAL_COMMUNICATION" => "Коммуникация и работа в команде",
            "GLOBAL_SKILLS_PERSONAL_HEALTH" => "Здоровое тело и дух",
            "GLOBAL_SKILLS_CHARACTER_CALM" => "Спокойствие",
            "GLOBAL_SKILLS_CHARACTER_SELF_ANALYS" => "Самоанализ",
            "GLOBAL_SKILLS_CHARACTER_CORRECT_THINKING" => "Фокус на себе",
            "GLOBAL_SKILLS_CHARACTER_HUMOR" => "Юмор и приятность",

            "GLOBAL_SKILLS_COMMON_GAME_REACTION_SPEED" => "Скорость реакции",
            "GLOBAL_SKILLS_COMMON_GAME_DECISION_SPEED" => "Скорость и правильность принятия решений",
            "GLOBAL_SKILLS_COMMON_GAME_ATTENTION" => "Внимание",
            "GLOBAL_SKILLS_COMMON_GAME_INTELLECT_UNDERSTANDING" => "Стратегическое понимание игры",
            "GLOBAL_SKILLS_COMMON_GAME_CALCULATION_SPEED" => "Быстрый счет",
            "GLOBAL_SKILLS_COMMON_GAME_STEAL" => "Воровство чужих идей",

            "GLOBAL_SKILLS_GAME_LASTHIT" => "Ластхит",
            "GLOBAL_SKILLS_GAME_AGGRO" => "Реагр крипов",
            "GLOBAL_SKILLS_GAME_BLOCK" => "Блок крипов",
            "GLOBAL_SKILLS_GAME_HARASS" => "Харас",
            "GLOBAL_SKILLS_GAME_SKILLSHOTS" => "Скиллшоты",
            "GLOBAL_SKILLS_GAME_LANING" => "Лайнинг",
            "GLOBAL_SKILLS_GAME_HERO_ITEMS" => "Итемизация героя",
            "GLOBAL_SKILLS_GAME_POOL" => "Пулинг и стак крипов",
            "GLOBAL_SKILLS_GAME_RESOURCE_MANAGMENT" => "Управление расходниками",
            "GLOBAL_SKILLS_GAME_MINIMAP" => "Использование миникарты",
            "GLOBAL_SKILLS_GAME_HERO_MACRO_TASK" => "Понимание макро-задач вашего героя",
            "GLOBAL_SKILLS_GAME_ALLIED_MACRO_TASK" => "Понимание макро-задач всех героев",
            "GLOBAL_SKILLS_GAME_HERO_POOL" => "Пул героев",
            "GLOBAL_SKILLS_GAME_HERO_POOL_MECHANIC" => "Игра на своем пуле героев",
            "GLOBAL_SKILLS_GAME_HERO_SPECIAL_KNOWLEDGE" => "Углубленные знания о героях",
            "GLOBAL_SKILLS_GAME_HERO_PICK" => "Правильный выбор своего героя",
            "GLOBAL_SKILLS_GAME_HERO_SIGNATURE" => "Сигнатурный пул героев",
            "GLOBAL_SKILLS_GAME_HEROES_DRAFT" => "Выбор героев",
            "GLOBAL_SKILLS_COMMON_GAME_REPLAY_WORK" => "Работа с реплеями",
            "GLOBAL_SKILLS_GAME_CREEP_EQUILIBRIUM" => "Крип-эквилибриум",
            "GLOBAL_SKILLS_GAME_MACRO_TASK_MECHANIC" => "Механическое выполнение макро-задач",

            "Know more" => "Узнать больше",
            "Table_of_skill_calculation" => "Таблица оценки уровня игры и зоны роста",
            "Skills_description" => "Описание навыков",
            'Clickable' => 'Кликабельно',
            'Enter_your_mmr' => 'Введите ваш ммр',
            'Select_mmr_you_want' => 'Выберите желаемый ммр',
            'Your_skills' => 'Ваши навыки',
            'Expected_skills' => 'Навыки на этом ммр',
            'Result' => 'Результат',
            'Necessary_skills' => 'Необходимые навыки',
            'Advices' => 'Советы',
            'Share' => 'Поделиться',
            'Share_in_VK' => 'Поделиться во Вконтакте',
            'Share_on_facebook' => 'Поделиться в Фейсбуке',
            'Share_link_on_twitter' => 'Поделиться ссылкой в Твиттере',
            'Tweet' => 'Твитнуть',
            'Save' => 'Сохранить',

            'Digitize_social_text' => 'Очень крутая таблица для оцифровки',

            'Glossary' => 'Глоссарий',
            'Glossary_text' => 'Раздел, в котором расшифрован дотерский сленг.</br>
            Список специальных терминов, сокращений, понятий, толкований непонятных слов и выражений, т.е. словарь с элементами справочной информации о малознакомых словах, либо словах, утративших свое значение или новых, только формирующих свои смыслы и значения в области киберспорта и DOTA 2.',

            'seo_title_glossarij' => 'Глоссарий',
            'seo_description_glossarij' => 'Раздел, где есть расшифровка всякого дотерского сленга.',
            'seo_keywords_glossarij' => '',



        ),
        self::EN => array(
            "Role_Hard_support_2" => "Hard support",
            "Role_Soft_support_2" => "Soft support",
            "Role_Offlane_2" => "Offlane",
            "Role_Mid_2" => "Mid",
            "Role_Carry_2" => "Carry",
            "Macrotask_description_6" => "Perfect",
            "Macrotask_description_5" => "Very good",
            "Macrotask_description_4" => "Good",
            "Macrotask_description_3" => "Normal",
            "Macrotask_description_2" => "Bad",
            "Macrotask_description_1" => "Very bad",
            "Macrotask_description_0" => "Awful",
            "Каталог" => "Catalogue",
            "События" => "Events",
            "Статьи" => "Arcticles",
            "Video" => "Video",
            "Контакты" => "Contacts",
            "Гарантия" => "Garanty",
        )
    );



    public const BOOK_TEMP = array(
        self::RU =>array(
            "GLOBAL_SKILLS_PERSONAL_PERSEVERANCE_text" => "Без труда не выловить и рыбку из пруда, а без усидчивости не достичь вершин. Необходимый навык для того, чтоб играть много игр",
            "SKILLS_PERSONAL_CRITIC_text" => "Достаточно часто мы не видим всей картины, а слушая критику, мы получаем возможность взглянуть на наши действия и навыки под другим углом и расширить кругозор.
             Важно отделять конструктивную информацию от ложной",
            "GLOBAL_SKILLS_PERSONAL_PLANNING_text" => " Без хорошего плана вы будете делать всё «как всегда». Умение планировать существенно экономит время для достижения результата",
            "GLOBAL_SKILLS_PERSONAL_COMMUNICATION_text" => "Навык, который позволяет эффективно взаимодействовать с людьми с целью передачи информации. 
            Кто лучше, быстрее и эффективнее передает информацию(и не ругается!), у того выше шансы на победу. 
            Если хотите совсем заморочиться и быть молодцом, почитайте про синтонное общение",
            "GLOBAL_SKILLS_PERSONAL_HEALTH_text" => "Тут все просто. Если вас клонировать и сделать более развитым физически, ментально, духовно и выбить всякие левые мысли из головы - вы будете лучше играть в доту(и не только!)",
            "GLOBAL_SKILLS_CHARACTER_CALM_description_1" => "Часто пребывать в состоянии душевного равновесия",
            "GLOBAL_SKILLS_CHARACTER_CALM_description_2" => "Умение распознавать состояние тильта и выходить из него (или вовремя прекращать играть)",
            "GLOBAL_SKILLS_CHARACTER_CALM_description_3" => "Умение не попадать в тильт",
            "GLOBAL_SKILLS_CHARACTER_CALM_description_4" => "Отсутсвие волнения в важных матчах",
            "GLOBAL_SKILLS_CHARACTER_CALM_text" => "Навык, позволяющий вам не терять концентрацию, лицо и здравый смысл",
            "GLOBAL_SKILLS_CHARACTER_SELF_ANALYS_text" => "Чтобы становиться лучше, нужно пониматься над каким аспектом работать.
            Конечно, вы можете обратиться за помощью к профессионалу, например, <a href='learn#price'>ко мне</a>, но можете это сделать и сами",
            "GLOBAL_SKILLS_CHARACTER_CORRECT_THINKING_text" => "Какая разница, как кто сыграл? Ну правда! Хотите быть сильнее - находите возможности для роста и в таких ситуациях. 
            Не ищите виноватых, думайте только о своей игре и о том, что можно было сделать лучше",
            "GLOBAL_SKILLS_CHARACTER_HUMOR_text" => "Унылые вялые луни не особо к себе распологают, а вот с веселыми и позитивными людьми можно хоть и на край света пойти.</br></br>
            <ul class='list'><li>Умение быть остроумным притягивает внимание других людей. Человек с юмором ценится в любой компании, он интересен. Почему?
            Потому что приносит положительные эмоции, заряд бодрости, радости. 
            У большинства людей такого умения нет, вот поэтому все стремятся получить то, чего у них нет.</li>
            
            <li>Смех является способом решать конфликты, или не допускать их. Юмор обесценивает значимость обиды, переживания, поэтому тема измены, расставания, любовного треугольника очень популярна в анекдотах, афоризмах, шутках.
            Лучший способ привлечь внимание – это рассказать анекдот, афоризм, во время и к месту. Внимание людей сосредотачивается там, где интересно, весело, и отвлекается от нудности, официозности, невыразительности.</li>
            
            <li>Защита от дураков (и некоторых близких) с помощью юмора наиболее эффективна, так как метафорически можно описать всю нелепость неадекватного глупого поведения, но в то же время, избежать дополнительных «наездов» от эмоциональных агрессоров.</li>
            
            <li>Популярность у противоположного пола имеют, как правило, люди весёлые.
            Нестандартность, творчество, яркость, всегда привлекают и девушек и молодых людей. 
            Юмор своего избранника, часто, девушки ставят впереди его физической привлекательности. 
            Правильно, зачем ей симпатичный и тупой, такого подругам не покажешь, или лучше так, покажешь, но надо, чтобы он молчал, а девушки любят разговаривать и слушать.
            Если мужчина разговаривает скучно, противно, его и воспринимают, как скучного и противного.</li></ul></br>
            Такие дела",

            "GLOBAL_SKILLS_COMMON_GAME_REACTION_SPEED_description_1" => "230 - 270мс и 2 звезды в osu",
            "GLOBAL_SKILLS_COMMON_GAME_REACTION_SPEED_description_2" => "210 - 250мс и 3 звезды в osu",
            "GLOBAL_SKILLS_COMMON_GAME_REACTION_SPEED_description_3" => "200 - 230мс и 4-5 звезд osu",
            "GLOBAL_SKILLS_COMMON_GAME_REACTION_SPEED_description_4" => "150 - 200мс и 6+ звезд в osu",
            "GLOBAL_SKILLS_COMMON_GAME_REACTION_SPEED_text" => "Насколько быстро вы реагируете на внезапные события или смену обстановки. 
            Проверить можете <a target='_blank' href='https://mozgion.ru/test-trenazher-na-skorost-reakcii/'>тут</a>. Также, я использую <a target='_blank' href='https://osu.ppy.sh/'>osu!</a>, как критерий.</br>
            Мои результаты: 190-220 мс и 6-7 звезд в osu",
            "GLOBAL_SKILLS_COMMON_GAME_DECISION_SPEED_description_1" => "Решения о базовых взаимодействиях с командой, инициации и контр-инициации:</br>
            Начать или контр-инициировать тимфайт.</br>Остаться фармить/пушить или прилететь к команде на драку или защиту объекта.</br>Доафрмить артефакты или сделать какое-то действие",
            "GLOBAL_SKILLS_COMMON_GAME_DECISION_SPEED_description_2" => "Один из моих законов доты: если вы выполняете одно и то же действие (макро-задачу) - ваш шанс погибнуть будет увеличиваться с каждой секундой.
            Примеры: если вы будете фармить одну и ту же линию, одни и те же кэмпы в лесу, осаждать одну и ту же вышку, выходить и отрезать пачки несколько минут подряд - то рано или поздно оппоненту это надоест и он соберет ганг-отряд и словит вас.
            Обладание этим навыком 2-го уровня подразумевает то, что вы понимаете, когда и на что нужно сменить сферу деятельности в игре (сместиться на другую линию, самому пойти в атаку и тд).
            В идеале, конечно, максимально задолбать и саботировать вражескую команду, почувствовать, что она идет на вас и принять решение о другой макро-задаче",
            "GLOBAL_SKILLS_COMMON_GAME_DECISION_SPEED_description_3" => "Вы очень уверены в себе и способны быстро принимать не стандартные решения в очень сложных ситуациях. Размен тронами, размен сторонами, быстрые смоки в рошана (проигрывая большое преимущество)",
            "GLOBAL_SKILLS_COMMON_GAME_DECISION_SPEED_text" => "Насколько быстро вы примаете решения и просчитываете варианты в стрессовых ситуациях.
            Достигается при накоплении определенного опыта подобных ситуаций, уверенности в себе, идеальной механики, навыка <a href='digitize#skill_14'>быстрого счета</a>, хорошей <a href='digitize#skill_5'>физической и ментальной формы</a>, <a href='digitize#skill_6'>спокойствия</a>",
            'GLOBAL_SKILLS_COMMON_GAME_DECISION_image_text' => 'Проигрывая более 35000 по золоту против команды Team Secret, Miracle с командой принимают гениальные не стандартные решения для победы',

            "GLOBAL_SKILLS_COMMON_GAME_ATTENTION_description_1" => "Вы успеваете следить за откатами своих способностей, замечать приход и уход союзных героев, замечать состояние и предметы героев в пределах своего экрана",
            "GLOBAL_SKILLS_COMMON_GAME_ATTENTION_description_2" => "На этапе лайнинга вы способны уследить за действиями всех героев и куда двигается каждый крип.
            Вы примерно в курсе, как у всех дела, на уровне: хорошо или плохо, иногда вы подмечаете появление важного таланта/ключевого артефакта/лвла у другого героя",
            "GLOBAL_SKILLS_COMMON_GAME_ATTENTION_description_3" => "Вас тяжело загангать, поскольку вы видите движения героев на мини-карте и успеваете прочитать или услышать мисс.
            На этапе лайнинга вы в курсе всех лвлов, артефактов, локаций героев. В тимфайте вы видите что происходит в пределах вашего экрана, кто и что потратил, кто умер и жив, кого нужно фокусить, а кому помочь",
            "GLOBAL_SKILLS_COMMON_GAME_ATTENTION_description_4" => "Вы в курсе всех лвлов, артефактов, состояний ключевых способностей, байбеков, локаций героев. В тимфайте вы видите абсолютно всю драку, кто и что потратил, кто умер и жив, кого нужно фокусить, а кому помочь",
            "GLOBAL_SKILLS_COMMON_GAME_ATTENTION_text" => "Объём внимания — это количество объектов, которые охватываются вниманием, одномоментно, одновременно. 
            Объём внимания обычно колеблется у взрослых в пределах от 4 до 6 объектов, у подростков (в зависимости от возраста) от 2 до 5 объектов. 
            Человек с большим объёмом внимания может заметить больше предметов, явлений, событий.</br>
            В доте позволяет захватывать гораздо больше информации, быстрее принимать решения, быть в курсе всех событый, таймингов, артефактов, состояния героев.
            Развивать можно на практике, специально прокликивая всех героев и считывая информацию о них. Рекомендую <a target='_blank' href='https://osu.ppy.sh/'>osu!</a> и <a target='_blank' href='https://ru.wikipedia.org/wiki/Таблица_Шульте'>таблицы шульте</a> ",

            "GLOBAL_SKILLS_COMMON_GAME_INTELLECT_UNDERSTANDING_description_1" => "Вы понимаете, как работает экономика в доте, зачем нужны роли и позиции и почему люди играют на узком пуле, 
            почему существуют саппорты и кор-герои, какая цель в игре и какие <a href='digitize#skill_29'>макро-задачи</a> являются более приоритетными и важными",
            "GLOBAL_SKILLS_COMMON_GAME_INTELLECT_UNDERSTANDING_description_2" => "Вы видите основной win-condition вашей и вражеской команды, неплохо знаете все <a href='digitize#skill_29'>макро-задачи</a> и хорошо ориентируетесь в аспектах <a href='digitize#skill_336'>драфта своего героя</a>. 
            Знаете и используете понятие создания спейса или как саботировать игру вражеской команде",
            "GLOBAL_SKILLS_COMMON_GAME_INTELLECT_UNDERSTANDING_description_3" => "Вы видите несколько путей для победы вашей и вражеской команды, досконально знаете все <a href='digitize#skill_29'>макро-задачи</a> и хорошо ориентируетесь в аспектах <a href='digitize#skill_36'>драфта героев</a>. 
            Отказ от своих личных благ в игре в пользу командных или для другой роли, либо наоборот, - если ваша основная задача заключается в том, чтоб выиграть игру",
            "GLOBAL_SKILLS_COMMON_GAME_INTELLECT_UNDERSTANDING_text" => "Навык, позволяющий: смотреть на игру - как на стратегию, на проблемы на карте - как на макро-задачи, на героев - как на исполнителей макро-задач",

            "GLOBAL_SKILLS_COMMON_GAME_CALCULATION_SPEED_description_1" => "Вы можете быстро рассчитать, сколько примерно вы нанесете урона или сколько сможете впитать.
            Сражаясь с оппонентом буквально по нескольким секундам противостояния, вы понимаете - победите вы или нет",
            "GLOBAL_SKILLS_COMMON_GAME_CALCULATION_SPEED_description_2" => "Вы быстро можете понять исход хаосного или неожиданного тимфайта и <a href='digitize#skill_11'>принять решение</a> об отсуплении или преследовании",
            "GLOBAL_SKILLS_COMMON_GAME_CALCULATION_SPEED_description_3" => "Идеальные знания об атакующем и защитном темпах, игра на грани в очень острых ситуациях",
            "GLOBAL_SKILLS_COMMON_GAME_CALCULATION_SPEED_text" => "Как быстро вам мозг проводит математические вычисления и насколько далеко и правильно он может предвидеть какое-то событие",

            "GLOBAL_SKILLS_COMMON_GAME_STEAL_description_1" => "Вы иногда замечаете новые не стандартные (не метовые) сборки, пики героев, выполнения макро-задач во всех ваших играх и в играх, которые вы смотрите.
            У вас получается оценить эффективность и хорошо применить это на практике",
            "GLOBAL_SKILLS_COMMON_GAME_STEAL_description_2" => "Вы всегда замечаете новые не стандартные (не метовые) сборки, пики героев, выполнения макро-задач.
            На этом уровне навыка вы дополнительно просматриваете игры с других регионов в поисках новых идей.
            У вас получается оценить эффективность и хорошо применить это на практике",
            "GLOBAL_SKILLS_COMMON_GAME_STEAL_text" => "Наше время довольно ограничено, и тратить время на создание колеса (а тем более, - квадратного колеса) - не всегда целесообразно. 
            Навык о том, как перенимать чужие идеи и эффективно их применять",
            "GLOBAL_SKILLS_COMMON_GAME_STEAL_image_text" => "ppp",

            "GLOBAL_SKILLS_COMMON_GAME_REPLAY_WORK_description_1" => "Просмотр своих проигранных игр на предмет выявления ошибок, которые привели к поражению",
            "GLOBAL_SKILLS_COMMON_GAME_REPLAY_WORK_description_2" => "Просмотр всех своих игр на предмет того, что можно было сделать лучше во всех аспектах.
            Анализ оппонента противоположной роли, подмечание каких-то интересных вещей и их <a href='digitize#skill_15'>применение</a> в будущих своих играх",
            "GLOBAL_SKILLS_COMMON_GAME_REPLAY_WORK_description_3" => "Просмотр реплеев топовых коллективов и слежение за всеми игроками и ролями для всестороннего улучшения своей игры, развития макро",
            "GLOBAL_SKILLS_COMMON_GAME_REPLAY_WORK_text" => "Просмотр записей для анализа ошибок получения новой информации и вещей, которые можно сделать лучше",


            "GLOBAL_SKILLS_GAME_LASTHIT_description_1" => "60% всех ласт-хитов на фри-фарме",
            "GLOBAL_SKILLS_GAME_LASTHIT_description_2" => "70% всех ласт-хитов на фри-фарме",
            "GLOBAL_SKILLS_GAME_LASTHIT_description_3" => "80% всех ласт-хитов на фри-фарме",
            "GLOBAL_SKILLS_GAME_LASTHIT_description_4" => "90% всех ласт-хитов на фри-фарме",
            "GLOBAL_SKILLS_GAME_LASTHIT_description_5" => "100% всех ласт-хитов на фри-фарме",
            "GLOBAL_SKILLS_GAME_LASTHIT_description_6" => "80% всех ласт-хитов с постоянным пушем линии",
            "GLOBAL_SKILLS_GAME_LASTHIT_description_7" => "90% всех ласт-хитов с постоянным пушем линии",
            "GLOBAL_SKILLS_GAME_LASTHIT_description_8" => "100% всех ласт-хитов с постоянным пушем линии",
            "GLOBAL_SKILLS_GAME_LASTHIT_description_9" => "80% всех ласт-хитов с постоянным пушем линии + идеальное добитие крипа",
            "GLOBAL_SKILLS_GAME_LASTHIT_description_10" => "100% всех ласт-хитов с постоянным пушем линии + идеальное добитие крипа",
            "GLOBAL_SKILLS_GAME_LASTHIT_text" => "Умение добивать крипов. 
            Чем лучше вы это делаете, тем больше денег вы заработаете и тем меньше получит оппонент. 
            Идеальным ластхитом по крипу считается ситуация, когда в момент смерти он имеет столько хп, сколько вы наносите урона.
            Тогда сопернику на линии очень тяжело помешать вам в ластхите",

            "GLOBAL_SKILLS_GAME_AGGRO_description_1" => "Не получать много урона от крипов при реагре",
            "GLOBAL_SKILLS_GAME_AGGRO_description_2" => "Умение оттягивать кучку крипов для более комфортного ластхита",
            "GLOBAL_SKILLS_GAME_AGGRO_description_3" => "Умение оттягивать нужного крипа из кучи для ластхита",
            "GLOBAL_SKILLS_GAME_AGGRO_description_4" => "Использование вражеских героях на соседних линиях для реагра",
            "GLOBAL_SKILLS_GAME_AGGRO_description_5" => "Способность тащить за собой всю пачку крипов постоянно агря ее, знать и чувствовать тайминги пропадания агра от крипов",
            "GLOBAL_SKILLS_GAME_AGGRO_description_6" => "Понимание баланса линии (в плане крипов) и умение его менять (собирать большую пачку крипов или ломать лайн), использование реагра при стоянии линии 1х1 практически для каждого крипа",
            "GLOBAL_SKILLS_GAME_AGGRO_text" => "Умение для вашего блага использовать алгоритм искусственного интеллекта (крипов) при выборе цели, которую он будет атаковать.  
            Это зачастую нужно, чтоб снять агрессию со своих крипов или заставить вражеских крипов двигаться в вашу сторону. 
            Правильное использование позволяет существенно усилить ластхит и лайнинг, в перспективе овладеть навыком <a href='digitize#skill_20'>крип-эквилибриума</a>",

            "GLOBAL_SKILLS_GAME_BLOCK_description_1" => "16/20/28 секунд - это среднее время пробега крипов с базы до пушки на центральной/сложной/легкой линии на ранних минутах.</br>
            При вашем блоке крипы должны прибежать на лайн на 2 секунды позже",
            "GLOBAL_SKILLS_GAME_BLOCK_description_2" => "При вашем блоке крипы должны прибежать на лайн на 3 секунды дольше",
            "GLOBAL_SKILLS_GAME_BLOCK_description_3" => "При вашем блоке крипы должны прибежать на лайн на 4 секунды дольше",
            "GLOBAL_SKILLS_GAME_BLOCK_description_4" => "При вашем блоке крипы должны прибежать на лайн на 5 секунд дольше",
            "GLOBAL_SKILLS_GAME_BLOCK_description_5" => "При вашем блоке крипы должны прибежать на лайн на 6 секунд дольше",
            "GLOBAL_SKILLS_GAME_BLOCK_text" => "Навык, позволяющий угадывать движения любых юнитов и эффективно преграждать им дорогу, тем самым замедляя скорость передвижения.
            Используется а ситуациях, когда вам нужно замедлить вражеского героя, а никаких способностей у вас нет.
            Также нужен для того, чтоб ваша волна крипов пришла на линию позже и оказалась ближе к вашей вышке, давая вам большую безопасность. 
            Блокирование вражеских крипов между вышками на их лёгкой линии (если оппонент не мешает) позволяет первой вашей волне придти под вражескую вышку и довольно быстро погибнуть. 
            За счёт этого 2–ая волна крипов уже придёт под вашу вышку и вы будете в комфортной позиции",
            "GLOBAL_SKILLS_GAME_BLOCK_image_text" => "Обратите внимание на блок крипов от АИ бота и как он реализует то, что первая волна крипов будет у него на ХГ",

            "GLOBAL_SKILLS_GAME_CREEP_EQUILIBRIUM_description" => "GLOBAL_SKILLS_GAME_CREEP_EQUILIBRIUM_description",
            "GLOBAL_SKILLS_GAME_CREEP_EQUILIBRIUM_text" => "Умение управлять крипами на этапе лайнинга, оперировать не только своими хп, но и хп своих крипов. 
            Подобная техника позволяет создавать удобные и безопасные ситуации для ластхита и получения меньшего урона от хараса, грамотно разделять пачки крипов, либо наоборот - умение скопить много крипов и пустить их на оппонента.
            Достигается при максимальном понимании <a href='digitize#skill_18'>реагра</a> и <a href='digitize#skill_21'>хараса</a>",

            "GLOBAL_SKILLS_GAME_HARASS_text" => "Процесс нанесения урона вражеским героям на этапе лайнинга с целью их последующего убийства, ограждения от заработка денег и опыта. 
            Умение побеждать на линии за счет правильных ударов при реагре, попадания скиллами, выбивания расходников (ну и вовремя приносить свои)",
            "GLOBAL_SKILLS_GAME_HARASS_description_1" => "В равных матч-апах размениваться себе в плюс. Не получать слишком много урона, если вас начинают харасить и умение <a href='digitize#skill_18'>реагрить</a> для этого",
            "GLOBAL_SKILLS_GAME_HARASS_description_2" => "В равных матч-апах размениваться себе в плюс, при этом максимально <a href='digitize#skill_17'>ластхитить</a>. Понимание, когда нужно и можно зонить оппонента",
            "GLOBAL_SKILLS_GAME_HARASS_description_3" => "Доскональное понимание любых матч-апов в плане размена. Понимание, когда вам нужно денаить крипа, а когда ударить оппонента (если шанса добить почти нет и оппонент добивает хорошо). 
            Если возможно, всегда давать удар при реагре. Умное использование способностей, чтоб пробить оппонента, при этом не ломая линию",

            "GLOBAL_SKILLS_GAME_SKILLSHOTS_text" => "Навык эффективного использования способностей героев и предметов",
            "GLOBAL_SKILLS_GAME_SKILLSHOTS_description_1" => "Использовать хоткеи на заклинания и иметь достаточно внимания на их использование",
            "GLOBAL_SKILLS_GAME_SKILLSHOTS_description_2" => "Использовать хоткеи на заклинания и хоткеи на половину инвентаря и иметь достаточно внимания на их использование",
            "GLOBAL_SKILLS_GAME_SKILLSHOTS_description_3" => "Использовать хоткеи на заклинания и хоткеи на весь инвентарь и иметь достаточно внимания на их использовани",
            "GLOBAL_SKILLS_GAME_SKILLSHOTS_description_4" => "Попадать ненаправленными или АОЕ заклинаниями с шансом ~ 50%",
            "GLOBAL_SKILLS_GAME_SKILLSHOTS_description_5" => "Попадать ненаправленными или АОЕ заклинаниями с шансом ~ 75%",
            "GLOBAL_SKILLS_GAME_SKILLSHOTS_description_6" => "Близкое к идеалу знания АОЕ скиллшота или его ренж и каст-тайм",
            "GLOBAL_SKILLS_GAME_SKILLSHOTS_description_7" => "Попадать ненаправленными или АОЕ заклинаниями с шансом ~ 100%",
            "GLOBAL_SKILLS_GAME_SKILLSHOTS_description_8" => "Попадать ненаправленными или АОЕ заклинаниями с шансом ~ 100% по нескольким целям или по важной цели",

            "GLOBAL_SKILLS_GAME_LANING_text" => "Навык эффективного стояния на линии. 
            Игра начинается с фазы стояния на линиях и результатом ее является фундамент стратегии каждой команды и стартовый темп всех герев.
            Поскольку это яляется основой, тотальный проигрышь этой стадии может привести к поражению уже на 10-ой минуте",
            "GLOBAL_SKILLS_GAME_LANING_description_1" => "Базовое владение всеми микро-механиками",
            "GLOBAL_SKILLS_GAME_LANING_description_2" => "Продвинутое владение всеми микро-механиками, использование <a href='digitize#skill_27'>мини-карты</a>, хорошее <a href='digitize#skill_26'>управление расходниками</a>, 
            создание ситуаций на линии для доступа к начальным объектам (руны, аванпосты, вышки)",
            "GLOBAL_SKILLS_GAME_LANING_description_3" => "Вы примерно знаете какой матч-ап сильнее или слабее, и умеете это реализовывать. Пулы и все базовые основы стояния линии выполняются хорошо.
            Из-за нехватки знаний о разных стилях стояния линии и специфике вражеских героев и ролей, вы не набираете много преимущества на линии или не камбекаете",
            "GLOBAL_SKILLS_GAME_LANING_description_4" => "Вы заранее знаете исход любого матч-апа в процентах и умеете пошатнуть его в свою сторону, используя разные стили стояния линии и любые мелкие ошибки оппонента. Понимание, когда нужно свапнуться линиями или уйти в лес.
             </br>Ваш <a href='digitize#skill_17'>ластхит</a>, <a href='digitize#skill_18'>реагр</a> и <a href='digitize#skill_21'>харас</a> на очень высоком уровне",
            "GLOBAL_SKILLS_GAME_LANING_description_5" => "Вы заранее знаете исход любого матч-апа в процентах и умеете пошатнуть его в свою сторону используя разные стили стояния на линии, 
            <a href='digitize#skill_20'>крип-эквилибриум</a> и любые мелкие ошибки оппонента. Понимание, когда нужно свапнуться линиями или уйти в лес.
            Вы умеете стоять на всех линиях.</br>Ваш <a href='digitize#skill_17'>ластхит</a>, <a href='digitize#skill_18'>реагр</a> и <a href='digitize#skill_21'>харас</a> на почти или максимальном уровне",

            "GLOBAL_SKILLS_GAME_HERO_ITEMS_text" => "Знания всех популярных итем-билдов на героя и умение их грамотно использовать",
            "GLOBAL_SKILLS_GAME_HERO_ITEMS_description_1" => "Не покупать на зевса яшу и молнии, а на лича скади. Шучу! Просто знать кому и что купить",
            "GLOBAL_SKILLS_GAME_HERO_ITEMS_description_2" => "Знание всех популярных билдов и в каких ситуациях их использовать",
            "GLOBAL_SKILLS_GAME_HERO_ITEMS_description_3" => "Знание всех популярных билдов и в каких ситуациях их использовать ориентируясь на свои/вражеские крит-массы и темпы",
            "GLOBAL_SKILLS_GAME_HERO_ITEMS_description_4" => "Понимание и креатив необычных сборок в уникальных и контр-пиковых ситуациях (Например: Джаггернаут Миракла с Radians и Ethereal Blade)",
            "GLOBAL_SKILLS_GAME_MACRO_TASK_MECHANIC" => "Правильное механическое выполнение макро-задач",
            "GLOBAL_SKILLS_GAME_MACRO_TASK_MECHANIC_text" => "Как и какие условия должны быть выполнены для реализации ваших основных марко-задач.
            Например: понимание, как эффективно фармить и не умирать. Как правильно атаковать вражеского героя или проводить осаду обьектов.
            Как правильно и безопасно пушить линии. Где должны быть поставлены варды и произведена задача разведки. Какие и сколько ресурсов нужно на это использовать",

            "GLOBAL_SKILLS_GAME_POOL_text" => "Базовый навык отвода своих крипов на нейтральные лагеря или стак этих крипов с целью заработать золотишко и опыт, выровнять линию или лишить оппонента опыта",
            "GLOBAL_SKILLS_GAME_POOL_description_1" => "Вам относительно часто удается запулить или застакать любой кемп",
            "GLOBAL_SKILLS_GAME_POOL_description_2" => "Вам всегда удается запулить или застакать любой кемп",

            "GLOBAL_SKILLS_GAME_RESOURCE_MANAGMENT_text" => "Навык быстрой покупки в магазине, использования курьера, эффективного восполнения ресурсов (выкладывая вещи на пол или в бэкпак), 
            закупки перед смертью (использование функции быстрой покупки)",

            "GLOBAL_SKILLS_GAME_MINIMAP_text" => "Навык эффективного сбора информации с миникарты",
            "GLOBAL_SKILLS_GAME_MINIMAP_description_1" => "Вы базово используете мини-карту и иногда поглядываете на неё для того, чтоб определить где находятся союзники и враги,  какие лесные кемпы ещё не зафармлены и куда двигаются крипы.
            Использование мини-карты, если нужно, для перемещений, отправки подконтрольных существ",
            "GLOBAL_SKILLS_GAME_MINIMAP_description_2" => "Выполняя технические макро-задачи (фарм, перемещение и прочие) - ваш фокус внимания <b>иногда</b> на миникарте. 
            Вы <b>иногда</b> отслеживаете движения и появление всех героев и <b>редко</b> перемещаетесь в активные области, чтобы посмотреть за событием или прокликать героев и собрать информацию",
            "GLOBAL_SKILLS_GAME_MINIMAP_description_3" => "Выполняя технические макро-задачи (фарм, перемещение и прочие) - ваш фокус внимания <b>всегда</b> на миникарте. 
            Вы <b>всегда</b> отслеживаете движения и появление всех героев и <b>часто</b> перемещаетесь в активные области, чтобы посмотреть за событием или прокликать героев и собрать информацию.
            Нужно очень развитое <a href='digitize#skill_12'>внимание</a>",

            "GLOBAL_SKILLS_GAME_HERO_MACRO_TASK_text" => "Знание о том, какие макро-задачи должен выполнять ваш герой и какова ваша роль в любой игровой момент времени.
            Выбор и выполнение из списка задач самых важных и приоритетных. Постоянное осознание того, какую макро-задачу вы выполняете в данный момент времени и к какой приступите через 30 секунд",

            "GLOBAL_SKILLS_GAME_ALLIED_MACRO_TASK_text" => "Знание о том, какие макро-задачи выполняют все союзные герои.
            Фактически перестройка мышления на паттерн того, что карта доты - это абстрактная игровая доска, а союзные герои - фигуры, которые максимально быстро, эффективно и надежно решают все проблемы, которые возникают на этой доске и следуют к победе.
            Постоянное осознание того, какие макро-задачи выполняют все герои вашей команды и к какой приступят через 30 секунд",

            "GLOBAL_SKILLS_GAME_HERO_POOL_text" => "Уверенные знания на определенном количестве героев.
            <a href='digitize#skill_23'>Правильная итемизация</a>, <a href='digitize#skill_28'>понимание макро-задач</a>",
            "GLOBAL_SKILLS_GAME_HERO_POOL_description_1" => "3 героя",
            "GLOBAL_SKILLS_GAME_HERO_POOL_description_2" => "6 героя",
            "GLOBAL_SKILLS_GAME_HERO_POOL_description_3" => "10 героя",
            "GLOBAL_SKILLS_GAME_HERO_POOL_description_4" => "14 героя",
            "GLOBAL_SKILLS_GAME_HERO_POOL_description_5" => "Больше 14 героев и герои с других позиций",

            "GLOBAL_SKILLS_GAME_HERO_POOL_MECHANIC_text" => "Уверенная игра и <a href='digitize#skill_35'>лайнинг</a> на определенном количестве героев.
            Хороший уровень микро и <a href='digitize#skill_22'>скиллшотов</a>, правильное механическое <a href='digitize#skill_24'>выполнение макро-задач</a>",
            "GLOBAL_SKILLS_GAME_HERO_POOL_MECHANIC_description_1" => "3 героя",
            "GLOBAL_SKILLS_GAME_HERO_POOL_MECHANIC_description_2" => "6 героев",
            "GLOBAL_SKILLS_GAME_HERO_POOL_MECHANIC_description_3" => "10 героев",
            "GLOBAL_SKILLS_GAME_HERO_POOL_MECHANIC_description_4" => "Более 10 героев",

            "GLOBAL_SKILLS_GAME_HERO_SPECIAL_KNOWLEDGE_text" => "Глубокие знания о контр-пиках или хороших союзниках. В каких стратегиях эти знания могут быть очень эффективны, а в каких ситуациях у вас не будет геймлпея.
            Анализ ситуаций, где эти герои будучи взятыми на последние пики, - полностью сломают игру оппоненту и приведут команду к победе. 
            Если вы кор-игрок, то обязательными будут знания о всех темпах и крит-массах героя",
            "GLOBAL_SKILLS_GAME_HERO_SPECIAL_KNOWLEDGE_description_1" => "2 героя",
            "GLOBAL_SKILLS_GAME_HERO_SPECIAL_KNOWLEDGE_description_2" => "4 героев",
            "GLOBAL_SKILLS_GAME_HERO_SPECIAL_KNOWLEDGE_description_3" => "7 героев",
            "GLOBAL_SKILLS_GAME_HERO_SPECIAL_KNOWLEDGE_description_4" => "Более 7 героев",

            "GLOBAL_SKILLS_GAME_HERO_PICK_description" => "GLOBAL_SKILLS_GAME_HERO_PICK_description",
            "GLOBAL_SKILLS_GAME_HERO_PICK_text" => "Умение правильно выбирать героя на своей роли. Для того, чтоб овладеть этим навыком, нужны следующее навыки:</br></br><ul class='list'>
            <li><a href='digitize#skill_28'>Понимание макро-задач вашего героя</a>.</li>
            <li>Иметь достаточный <a href='digitize#skill_30'>пул героев</a> (хотя бы 6-10).</li>
            <li>Хорошая игра на этом <a href='digitize#skill_31'>пуле героев</a>.</li>
            <li><a href='digitize#skill_32'>углубленные знания о героях</a>.</li>
            </ul></br>
            Критическим для оппонента может быть ваш <a href='digitize#skill_34'>сигнатурный пул героев</a>",

            "GLOBAL_SKILLS_GAME_HERO_SIGNATURE_description_1" => "1 герой",
            "GLOBAL_SKILLS_GAME_HERO_SIGNATURE_description_2" => "2 героя",
            "GLOBAL_SKILLS_GAME_HERO_SIGNATURE_description_3" => "3 героя",
            "GLOBAL_SKILLS_GAME_HERO_SIGNATURE_description_4" => "4 и более героя",
            "GLOBAL_SKILLS_GAME_HERO_SIGNATURE_text" => "Количество героев, на которых вы достигли огромного мастерства. Вы знаете и владеете глубокими нюансами механики, макро и итем-билдов, о которых 99% игроков даже не догадываются",

            "GLOBAL_SKILLS_GAME_HEROES_DRAFT_text" => "Умение драфтить героев для всей команды.
            Навык развивается с опытом, наработкой знаний по абсолтюно всем героям (какие <a href='digitize#skill_24'>макро-задачи</a> выполняют и как, хорошие связки или контр-пики), изучением <a href='digitize#skill_13'>стратегий</a>, <a href='digitize#skill_16'>просмотром реплеев</a>",


        ),
        self::EN => array(
            "Каталог" => "Catalogue",
            "События" => "Events",
            "Статьи" => "Arcticles",
            "Video" => "Video",
            "Контакты" => "Contacts",
            "Гарантия" => "Garanty",
        )
    );



    
    public static $langs = array( self::RU , self::EN  );

    public static function countries()
    {
        return array(
            "ua" => "Ukraine", 
            "ru" => "Russian Federation", 
            "by" => "Belarus", 
            "kz" => "Kazakhstan",
            "pl" => "Poland", 
            "us" => "United States",
            "af" => "Afghanistan", 
            "al" => "Albania", 
            "dz" => "Algeria",
            "as" => "American Samoa", 
            "ad" => "Andorra", 
            "ao" => "Angola",
            "ai" => "Anguilla", 
            "aq" => "Antarctica", 
            "ag" => "Antigua and Barbuda",
            "ar" => "Argentina", 
            "am" => "Armenia", 
            "aw" => "Aruba",
            "au" => "Australia", 
            "at" => "Austria", 
            "az" => "Azerbaijan",
            "bs" => "Bahamas", 
            "bh" => "Bahrain", 
            "bd" => "Bangladesh",
            "bb" => "Barbados", 
            "be" => "Belgium",
            "bz" => "Belize", 
            "bj" => "Benin", 
            "bm" => "Bermuda",
            "bt" => "Bhutan", 
            "bo" => "Bolivia", 
            "ba" => "Bosnia and Herzegovina",
            "bw" => "Botswana", 
            "bv" => "Bouvet Island",
            "br" => "Brazil",
            "io" => "British Indian Ocean Territory", 
            "bn" => "Brunei Darussalam", 
            "bg" => "Bulgaria",
            "bf" => "Burkina Faso", 
            "bi" => "Burundi", 
            "kh" => "Cambodia",
            "cm" => "Cameroon", 
            "ca" => "Canada",
            "cv" => "Cape Verde",
            "ky" => "Cayman Islands", 
            "cf" => "Central African", 
            "td" => "Chad",
            "cl" => "Chile", 
            "cn" => "China", 
            "cx" => "Christmas Island",
            "cc" => "Cocos (Keeling) Islands", 
            "co" => "Colombia", 
            "km" => "Comoros",
            "cg" => "Congo, Republic",
            "cd" => "Congo", 
            "ck" => "Cook Islands",
            "cr" => "Costa Rica", 
            "ci" => "CÃ´te d\"Ivoire", 
            "hr" => "Croatia",
            "cu" => "Cuba", 
            "cy" => "Cyprus", 
            "cz" => "Czech Republic",
            "dk" => "Denmark",
            "dj" => "Djibouti", 
            "dm" => "Dominica",
            "do" => "Dominican Republic", 
            "ec" => "Ecuador", 
            "eg" => "Egypt",
            "sv" => "El Salvador", 
            "en" => "England", 
            "gq" => "Equatorial Guinea",
            "er" => "Eritrea",
            "ee" => "Estonia", 
            "et" => "Ethiopia", 
            "fk" => "Falkland Islands",
            "fo" => "Faroe Islands",
            "fj" => "Fiji", 
            "fi" => "Finland",
            "fr" => "France", 
            "gf" => "French Guiana", 
            "pf" => "French Polynesia",
            "tf" => "French Southern Territories", 
            "ga" => "Gabon", "gm" => "Gambia",
            "ge" => "Georgia", 
            "de" => "Germany", 
            "gh" => "Ghana",
            "gi" => "Gibraltar", 
            "gr" => "Greece", 
            "gl" => "Greenland",
            "gd" => "Grenada", 
            "gp" => "Guadeloupe", 
            "gu" => "Guam",
            "gt" => "Guatemala", 
            "gn" => "Guinea", 
            "gw" => "Guinea-Bissau",
            "gy" => "Guyana", 
            "ht" => "Haiti", 
            "hm" => "Heard Island and McDonald Islands",
            "va" => "Vatican City State", 
            "hn" => "Honduras", 
            "hk" => "Hong Kong",
            "hu" => "Hungary", 
            "is" => "Iceland", 
            "in" => "India",
            "id" => "Indonesia", 
            "ir" => "Iran", 
            "iq" => "Iraq",
            "ie" => "Ireland", 
            "il" => "Israel",
            "it" => "Italy",
            "jm" => "Jamaica", 
            "jp" => "Japan", 
            "jo" => "Jordan",
            "ke" => "Kenya", 
            "ki" => "Kiribati",
            "kp" => "Korea", 
            "kr" => "Korea, Republic of", 
            "kw" => "Kuwait",
            "kg" => "Kyrgyzstan", 
            "la" => "Lao People\"s Democratic Republic", 
            "lv" => "Latvia",
            "lb" => "Lebanon", 
            "ls" => "Lesotho", 
            "lr" => "Liberia",
            "ly" => "Libyan Arab Jamahiriya", 
            "li" => "Liechtenstein", 
            "lt" => "Lithuania",
            "lu" => "Luxembourg", "mo" => "Macao", "mk" => "Macedonia",
            "mg" => "Madagascar", "mw" => "Malawi", "my" => "Malaysia",
            "mv" => "Maldives", "ml" => "Mali", "mt" => "Malta",
            "mh" => "Marshall Islands", "mq" => "Martinique", "mr" => "Mauritania",
            "mu" => "Mauritius", "yt" => "Mayotte", "mx" => "Mexico",
            "fm" => "Micronesia, Federated States of", "md" => "Moldova", "mc" => "Monaco",
            "mn" => "Mongolia", "ms" => "Montserrat", "ma" => "Morocco",
            "mz" => "Mozambique", "mm" => "Myanmar", "na" => "Namibia",
            "nr" => "Nauru", "np" => "Nepal", "nl" => "Netherlands",
            "an" => "Netherlands Antilles", "nc" => "New Caledonia", "nz" => "New Zealand",
            "ni" => "Nicaragua", "ne" => "Niger", "ng" => "Nigeria",
            "nu" => "Niue", "nf" => "Norfolk Island", "mp" => "Northern Mariana Islands",
            "no" => "Norway", "om" => "Oman", "pk" => "Pakistan",
            "pw" => "Palau", "ps" => "Palestinian Territory, Occupied", "pa" => "Panama",
            "pg" => "Papua New Guinea", "py" => "Paraguay", "pe" => "Peru",
            "ph" => "Philippines", "pn" => "Pitcairn",
            "pt" => "Portugal", "pr" => "Puerto Rico", "qa" => "Qatar",
            "re" => "Reunion", "ro" => "Romania",
            "rw" => "Rwanda", "sh" => "Saint Helena", "kn" => "Saint Kitts and Nevis",
            "lc" => "Saint Lucia", "pm" => "Saint Pierre and Miquelon", "vc" => "Saint Vincent and the Grenadines",
            "ws" => "Samoa", "sm" => "San Marino", "st" => "Sao Tome and Principe",
            "sa" => "Saudi Arabia", "scotland" => "Scotland", "sn" => "Senegal",
            "cs" => "Serbia and Montenegro", "sc" => "Seychelles", "sl" => "Sierra Leone",
            "sg" => "Singapore", "sk" => "Slovakia", "si" => "Slovenia",
            "sb" => "Solomon Islands",
            "so" => "Somalia", "za" => "South Africa", "gs" => "South Georgia and the South Sandwich Islan",
            "es" => "Spain", "lk" => "Sri Lanka", "sd" => "Sudan",
            "sr" => "Suriname", "sj" => "Svalbard and Jan Mayen", "sz" => "Swaziland",
            "se" => "Sweden", "ch" => "Switzerland", "sy" => "Syrian Arab Republic",
            "tw" => "Taiwan", "tj" => "Tajikistan", "tz" => "Tanzania, United Republic of",
            "th" => "Thailand", "tl" => "Timor-Leste", "tg" => "Togo",
            "tk" => "Tokelau", "to" => "Tonga", "tt" => "Trinidad and Tobago",
            "tn" => "Tunisia", "tr" => "Turkey", "tm" => "Turkmenistan",
            "tc" => "Turks and Caicos Islands", "tv" => "Tuvalu", "ug" => "Uganda",
            "ae" => "United Arab Emirates", "gb" => "United Kingdom",
            "um" => "United States Minor Outlying Islands", "uy" => "Uruguay",
            "uz" => "Uzbekistan", "vu" => "Vanuatu", "ve" => "Venezuela",
            "vn" => "Viet Nam", "vg" => "Virgin Islands, British", "vi" => "Virgin Islands, U.S.", "wales" => "Wales",
            "wf" => "Wallis and Futuna", "wales" => "Wales", "eh" => "Western Sahara",
            "ye" => "Yemen", "zm" => "Zambia", "zw" => "Zimbabwe",
        );
    }

    public static function get_country( $key )
    {
        $countries = self::countries();
        return isset( $countries[$key] ) ? $countries[$key] : false;
    }
   
}

//Localka::create_js();