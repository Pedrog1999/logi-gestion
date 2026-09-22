<?php 

namespace App\Services\Load;

use App\Converter\Load\LoadToLoadResponseConverter;
use App\Dto\Request\Load\LoadRequest;
use App\Dto\Response\Load\LoadResponse;
use App\Entity\Load;
use App\Models\LoadModel;

final class LoadCreatorService {

    private LoadModel $loadModel;
    private LoadToLoadResponseConverter $converter;

    public function __construct() {
        $this->loadModel = new LoadModel();
        $this->converter = new LoadToLoadResponseConverter();
    }

    public function create(LoadRequest $request): LoadResponse
    {
        $id = $this->loadModel->insert(
            $request->getType(),
            $request->getName(),
            $request->getCommission()
        );

        $load = new Load(
            $id,
            $request->getType(),
            $request->getName(),
            $request->getCommission()
        );

        return $this->converter->convert($load);
    }
}