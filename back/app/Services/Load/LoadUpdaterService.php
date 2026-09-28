<?php 

namespace App\Services\Load;

use App\Converter\Load\LoadToLoadResponseConverter;
use App\Dto\Request\Load\LoadRequest;
use App\Dto\Response\Load\LoadResponse;
use App\Models\LoadModel;
use App\Entity\Load\Load;

final class LoadUpdaterService {
    private LoadModel $loadModel;
    private LoadFinderService $loadFinderService;
    private LoadToLoadResponseConverter $converter;

    public function __construct() {
        $this->loadModel = new LoadModel();
        $this->loadFinderService = new LoadFinderService();
        $this->converter = new LoadToLoadResponseConverter();
    }

    public function update(LoadRequest $request, int $id): LoadResponse
    {
        $existingLoad = $this->loadFinderService->find($id);
        
        $loadToUpdate = new Load(
            $existingLoad->getId(),
            $request->getType(),
            $request->getName(),
            $request->getCommission(),
            $existingLoad->getCreatedAt(),
            $existingLoad->getUpdatedAt()
        );

        $updatedLoad = $this->loadModel->update($loadToUpdate);

        return $this->converter->convert($updatedLoad);
    }
}
