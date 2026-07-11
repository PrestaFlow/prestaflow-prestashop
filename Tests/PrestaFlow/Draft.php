<?php

namespace Tests\PrestaFlow;

use PrestaFlow\Library\Tests\TestsSuite;

class Draft extends TestsSuite
{
    public $draft = true;

    public function init()
    {
        $this
            ->describe('PrestaFlow: draft')
            ;
        ;
    }
}
