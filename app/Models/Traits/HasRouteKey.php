<?php

namespace App\Models\Traits;

use Jenssegers\Optimus\Optimus;

trait HasRouteKey
{
    public function getRouteKey()
    {
        return app(Optimus::class)->encode($this->getKey());
    }
}