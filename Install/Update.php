<?php

$this->db->query('ALTER TABLE ' . explode(' ', TABLE_PROFILE_POSTS)[0] . ' DROP COLUMN IF EXISTS profile_post_edited');
$this->db->query('ALTER TABLE ' . explode(' ', TABLE_PROFILE_POSTS)[0] . ' DROP COLUMN IF EXISTS is_edited');

$this->db->query('ALTER TABLE ' . explode(' ', TABLE_PROFILE_POSTS_COMMENTS)[0] . ' DROP COLUMN IF EXISTS profile_post_comment_edited');
$this->db->query('ALTER TABLE ' . explode(' ', TABLE_PROFILE_POSTS_COMMENTS)[0] . ' DROP COLUMN IF EXISTS is_edited');

$this->db->query('ALTER TABLE ' . explode(' ', TABLE_FORUMS)[0] . ' CHANGE COLUMN IF EXISTS `forum_icon_name` forum_icon varchar(225) NOT NULL');

$this->db->query('ALTER TABLE ' . explode(' ', TABLE_REPORTS_REASONS)[0] . ' CHANGE COLUMN IF EXISTS `reson_id` report_reason_id bigint(11) NOT NULL AUTO_INCREMENT');
$this->db->query('ALTER TABLE ' . explode(' ', TABLE_REPORTS_REASONS)[0] . ' CHANGE COLUMN IF EXISTS `reason_text` report_reason_text varchar(225) NOT NULL COLLATE utf8_general_ci');
$this->db->query('ALTER TABLE ' . explode(' ', TABLE_REPORTS_REASONS)[0] . ' CHANGE COLUMN IF EXISTS `reason_type` report_reason_type tinyint(1) NOT NULL');
$this->db->query('ALTER TABLE ' . explode(' ', TABLE_REPORTS_REASONS)[0] . ' CHANGE COLUMN IF EXISTS `reason_time` report_reason_time  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');