<?php

namespace Page;

/**
 * Installation
 */
class Installation extends Page
{
    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        $this->templateName = 'Installation';

        $this->data->data([
            'install' => true
        ]);
    }
}