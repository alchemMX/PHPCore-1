<?php

namespace Page;

/**
 * Error
 */
class Insert extends Page
{
    /**
     * @var array $settings Page settings
     */
    protected array $settings = [
        'template' => 'Error'
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body() {

        $q = new \Model\Database\Query();

        for ($i = 20; $i <= 120; $i++) {

            $q->insert(TABLE_REPORTS_REASONS, [
                'report_id' => '5',
                'user_id' => '1',
                'reason_type' => '1',
                'reason_text' => 'Sed ac dolor sit amet purus malesuada congue. Nulla turpis magna, cursus sit amet, suscipit a, interdum id, felis. Mauris tincidunt sem sed arcu. Phasellus rhoncus.'
            ]);
            sleep(2);
        }
        exit();
    }
}