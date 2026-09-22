<?php

namespace App\Services\Load;

use App\Models\LoadModel;

final class LoadDeleterService {

    private LoadModel $loadModel;
    private LoadFinderService $loadFinderService;

    public function __construct(){
        $this->loadModel = new LoadModel();
        $this->loadFinderService = new LoadFinderService();
    }

    public function delete(int $id): void 
    {
        $load = $this->loadFinderService->find($id);

        $this->loadModel->delete($load->getId());
    } 
}