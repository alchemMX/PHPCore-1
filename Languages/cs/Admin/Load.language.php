<?php

$language = [];

foreach (glob(ROOT . '/Languages/cs/Admin/*.php') as $path) {
    if (basename($path) != 'Load.language.php') {
        require $path;
    }
}

$language = array_merge($language, array(
    
    'L_BY' => 'od',

    'L_ICON' => 'Ikona',
    'L_ICON_LIST' => 'Seznam ikon',
    'L_ICON_LIST_DESC' => 'Po kliknutí na tlačítko budete přesměrování na stránku FontAwesome',
    'L_ICON_NAME' => 'Název ikony',
    'L_ICON_STYLE' => 'Styl ikony',
    
    'L_FAS' => 'fas',
    'L_FAR' => 'far',
    'L_FAB' => 'fab',

    'L_INFO' => 'Informace',
    'L_EDIT' => 'Upravit',

    'L_SEND' => 'Poslat',

    'L_HOST' => 'Server',
    'L_PORT' => 'Port',

    'L_DELETED_USER' => 'Smazaný uživatel',

    'L_USERS' => 'Uživatelů',
    'L_OPTIONS' => 'Možnosti',

    'L_RECORD' => 'Záznam',

    'L_UPDATE_ALERT' => 'Aktualizace',
    'L_UPDATE_ALERT_DESC' => 'Je k dispozici nová aktualizace!',

    'L_TODAY' => 'Dnes',
    'L_AT' => 'v',
    'L_TOMORROW' => 'Včera',
    'L_BACK' => 'Zpět',

    'L_REGISTERED' => 'Registrován',

    'L_NO' => 'Ne',
    'L_YES' => 'Ano',

    'L_NONE' => 'Žádná',
    'L_LINK' => 'Odkaz',

    'L_DETAILS' => 'Podrobnosti',

    'L_REMOVE' => 'Smazat',
    'L_INTERNAL_ERROR' => 'Byla nalezena interní chyba!',

    'L_CONTENT_TYPE' => 'Typ obsahu',
    'L_CONTENT_LIST' => [
        'Topic' => 'Téma',
        'Post' => 'Příspěvek',
        'ProfilePost' => 'Profilový příspěvek',
        'ProfilePostComment' => 'Profilový komentář'
    ],

    'L_RECORD_ID' => 'ID záznamu',

    'L_ONLINE' => 'Online',

    'L_DELETE' => 'Smazat',
    'L_SHOW' => 'Zobrazit',

    'L_SUBMIT' => 'Odeslat',

    'L_TOPIC_NAME' => 'Název tématu',
    'L_AUTHOR' => 'Autor obsahu',

    'L_NAME' => 'Název',
    'L_TEXT' => 'Text',
    'L_EMAIL' => 'Email',
    'L_USERNAME' => 'Uživatelské jméno',
    'L_DESCRIPTION' => 'Popis',

    'L_PASSWORD' => 'Heslo',
    'L_PASSWORD_VERIFY' => 'Oveření hesla',

    'L_PASSWORD_NEW' => 'Nové heslo', 
    'L_PASSWORD_DESC' => 'Heslo musí obsahovat minimálně 6 znaků', 

    'L_TOPIC_ID' => 'ID Tématu',
    'L_TOPIC_ID_DESC' => 'ID pod kterým je téma uchováno v databázi',
    'L_POST_ID' => 'ID Příspěvku',
    'L_POST_ID_DESC' => 'ID pod kterým je příspěvek uchován v databázi',
    'L_PROFILE_POST_ID' => 'ID Profilového příspěvku',
    'L_PROFILE_POST_ID_DESC' => 'ID pod kterým je profilový příspěvek uchován v databázi',
    'L_PROFILE_POST_COMMENT_ID' => 'ID Profilového komentáře',
    'L_PROFILE_POST_COMMENT_ID_DESC' => 'ID pod kterým je profilový komentář uchován v databázi',

    'L_POST_TOPIC_NAME' => 'Téma ve kterém se příspěvek nachází',
    'L_TOPIC_NAME' => 'Název tématu',

    'L_ALERT' => 'Bezpečnostní informace',

    'L_MOVE_UP' => 'Posunout nahoru',
    'L_MOVE_DOWN' => 'Posunout dolů',
    'L_MAIN_ADMIN' => 'Hlavní správce',
    'L_EXTERNAL_LINK' => 'Externí odkaz',
    'L_ON_EVERY_WEBSITE_PAGE' => 'Bude zobrazeno na každé stránce',

    'L_KEY' => 'Klíč',
    'L_SHOW_MORE' => 'Zobrazit více',
    'L_CREATED_BY' => 'Vytvořil',

    'L_TAB_POST' => 'Příspěvky',
    'L_TAB_TOPIC' => 'Témata',
    'L_TAB_PROFILEPOST' => 'Profilové příspěvky',
    'L_TAB_ADMIN' => 'Administrátorský panel',
));
