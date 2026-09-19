<?php 

namespace App\Converter\Load;

use DateTime;
use App\Entity\Load;

final class PrimitiveToLoadConverter {
    public function convert(object $primitive): Load
    {
        return new Load(
            $primitive->id,
            $primitive->type,
            $primitive->name,
            $primitive->commission
        );
    }
}
