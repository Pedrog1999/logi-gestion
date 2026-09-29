<?php 

namespace App\Converter\Load;

use App\Dto\Response\Load\LoadResponse;
use App\Entity\Load\Load;

final class LoadToLoadResponseConverter {

    public function convert(Load $load): LoadResponse
    {
        return new LoadResponse(
            $load->getId(),
            $load->getType(),
            $load->getName(),
            $load->getCommission()
        );
    }
}