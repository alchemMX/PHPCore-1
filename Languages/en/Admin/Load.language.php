<?php

$language = [];

foreach (glob (ROOT. '/Languages/en/Admin/*.php') as $path) {
    if (basename ($path)!= 'Load.language.php') {
        require $path;
    }
}

$language = array_merge ($language, array (

    'L_BY' => 'from',

    'L_ICON' => 'Icon',
    'L_ICON_LIST' => 'Icon List',
    'L_ICON_LIST_DESC' => 'Clicking on the button will open the FontAwesome page in a new window',
    'L_ICON_NAME' => 'Icon Name',
    'L_ICON_STYLE' => 'Icon Style',

    'L_FAS' => 'fas',
    'L_FAR' => 'far',
    'L_FAB' => 'fab',

    'L_INFO' => 'Information',
    'L_EDIT' => 'Edit',

    'L_SEND' => 'Send',

    'L_HOST' => 'Server',
    'L_PORT' => 'Port',

    'L_DELETED_USER' => 'Deleted User',

    'L_USERS' => 'Users',
    'L_OPTIONS' => 'Options',

    'L_RECORD' => 'Record',

    'L_UPDATE_ALERT' => 'Update',
    'L_UPDATE_ALERT_DESC' => 'New update available!',

    'L_TODAY' => 'Today',
    'L_AT' => 'v',
    'L_TOMORROW' => 'Yesterday',
    'L_BACK' => 'Back',

    'L_REGISTERED' => 'Registered',

    'L_NO' => 'No',
    'L_YES' => 'Yes',

    'L_NONE' => 'None',
    'L_LINK' => 'Link',

    'L_DETAILS' => 'Details',

    'L_REMOVE' => 'Delete',
    'L_INTERNAL_ERROR' => 'An internal error was found!',

    'L_CONTENT_TYPE' => 'Content Type',
    'L_CONTENT_LIST' => [
        'Topic' => 'Topic',
        'Post' => 'Post',
        'ProfilePost' => 'Profile Post',
        'ProfilePostComment' => 'Profile Comment'
    ],

    'L_RECORD_ID' => 'Record ID',

    'L_ONLINE' => 'Online',

    'L_DELETE' => 'Delete',
    'L_SHOW' => 'View',

    'L_SUBMIT' => 'Submit',

    'L_TOPIC_NAME' => 'Topic Name',
    'L_AUTHOR' => 'Content Author',

    'L_NAME' => 'Name',
    'L_TEXT' => 'Text',
    'L_EMAIL' => 'Email',
    'L_USERNAME' => 'Username',
    'L_DESCRIPTION' => 'Description',

    'L_PASSWORD' => 'Password',
    'L_PASSWORD_VERIFY' => 'Password Verification',

    'L_PASSWORD_NEW' => 'New Password',
    'L_PASSWORD_DESC' => 'Password must contain at least 6 characters',

    'L_TOPIC_ID' => 'Topic ID',
    'L_TOPIC_ID_DESC' => 'ID under which the topic is stored in the database',
    'L_POST_ID' => 'Post ID',
    'L_POST_ID_DESC' => 'ID under which the post is stored in the database',
    'L_PROFILE_POST_ID' => 'Profile Post ID',
    'L_PROFILE_POST_ID_DESC' => 'ID under which the profile post is stored in the database',
    'L_PROFILE_POST_COMMENT_ID' => 'Profile Comment ID',
    'L_PROFILE_POST_COMMENT_ID_DESC' => 'ID under which the profile comment is stored in the database',

    'L_POST_TOPIC_NAME' => 'Topic',
    'L_TOPIC_NAME' => 'Topic Name',

    'L_ALERT' => 'Security Information',

    'L_MOVE_UP' => 'Move Up',
    'L_MOVE_DOWN' => 'Scroll Down',
    'L_MAIN_ADMIN' => 'General Manager',
    'L_EXTERNAL_LINK' => 'External link',

    'L_KEY' => 'Key',
    'L_SHOW_MORE' => 'Show more',
    'L_CREATED_BY' => 'Created by',

    'L_TAB_POST' => 'Posts',
    'L_TAB_TOPIC' => 'Topics',
    'L_TAB_PROFILEPOST' => 'Profile Posts',
    'L_TAB_ADMIN' => 'Admin Panel',
));
