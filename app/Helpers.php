<?php

use Jenssegers\Optimus\Optimus;

/**
 * Get the Optimus instance.
 *
 * @return \Jenssegers\Optimus\Optimus
 */
if (! function_exists('optimus'))
{
    function optimus(): Optimus
    {
        return app(Optimus::class);
    }
}