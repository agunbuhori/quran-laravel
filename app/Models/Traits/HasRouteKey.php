<?php

namespace App\Models\Traits;

use Jenssegers\Optimus\Optimus;

trait HasRouteKey
{
    public function getSecretKey()
    {
        return app(Optimus::class)->encode($this->getKey());
    }
}