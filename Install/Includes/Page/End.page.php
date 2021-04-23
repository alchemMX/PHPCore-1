<?php

namespace Page;

/**
 * End page
 */
class End extends Page
{
    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        $this->templateName = 'End';
    }
}