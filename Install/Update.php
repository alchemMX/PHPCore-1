<?php

$this->db->query('
    ALTER TABLE ' . explode(' ', TABLE_FORGOT)[0] . ' CHANGE COLUMN IF EXISTS `code` forgot_code varchar(225) NOT NULL;
');

$this->db->query('
    ALTER TABLE ' . explode(' ', TABLE_VERIFY)[0] . ' CHANGE COLUMN IF EXISTS `code` verify_code varchar(225) NOT NULL;
');

$this->db->query('
    ALTER TABLE ' . explode(' ', TABLE_CONVERSATIONS)[0] . ' CHANGE COLUMN IF EXISTS `conversation_subject` conversation_name varchar(225) NOT NULL;
');

$this->db->query('
    ALTER TABLE ' . explode(' ', TABLE_PROFILE_POSTS)[0] . ' CHANGE COLUMN IF EXISTS `profile_post_time` profile_post_created varchar(225) NOT NULL;
');

$this->db->query('
    ALTER TABLE ' . explode(' ', TABLE_PROFILE_POSTS_COMMENTS)[0] . ' CHANGE COLUMN IF EXISTS `profile_post_comment_time` profile_post_comment_created varchar(225) NOT NULL;
');