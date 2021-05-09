<?php

$this->db->query('ALTER TABLE ' . explode(' ', TABLE_REPORTS_REASONS)[0] . ' CHANGE COLUMN IF EXISTS `report_reason_type` report_reason_type tinyint(1) NOT NULL DEFAULT "0"');