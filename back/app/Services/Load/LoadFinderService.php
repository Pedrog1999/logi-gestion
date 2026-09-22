<?php 

namespace App\Services\Load;

use App\Converter\Load\LoadToLoadResponseConverter;
use App\Dto\Response\Load\LoadResponse;
use App\Entity\Load;
use App\Models\LoadModel;
use App\Exception\Load\LoadNotFoundException;

final class LoadFinderService {

    private LoadModel $loadModel;
    private LoadToLoadResponseConverter $converter;

    public function __construct() {
        $this->loadModel = new LoadModel();
        $this->converter = new LoadToLoadResponseConverter();
    }

    public function find(int $id): Load 
    {
        $load = $this->loadModel->find($id);

        if (empty($load)) {
            throw new LoadNotFoundException($id);
        }

        return $load;
    }

    public function findResponse(int $id): LoadResponse
    {
        $load = $this->find($id);
        
        $response = $this->converter->convert($load);

        return $response;
    }
}