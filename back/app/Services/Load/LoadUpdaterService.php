<?php 

namespace App\Services\Load;

use App\Converter\Load\LoadToLoadResponseConverter;
use App\Dto\Request\Load\LoadRequest;
use App\Dto\Response\Load\LoadResponse;
use App\Models\LoadModel;
use App\Entity\Load;

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
        $load = $this->loadFinderService->find($id);
        
        $this->loadModel->update(
            $request->getType(),
            $request->getName(),
            $request->getCommission(),
            $load->getId()
        );

        $updatedLoad = new Load(
            $load->getId(),
            $request->getType(),
            $request->getName(),
            $request->getCommission(),
            $load->getCreatedAt(),
            $load->getUpdatedAt()
        );

        return $this->converter->convert($updatedLoad);
    }
}
