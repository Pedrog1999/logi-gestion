<?php 

namespace App\Services\Load;

use App\Converter\Load\LoadToLoadResponseConverter;
use App\Dto\Response\Load\LoadResponse;
use App\Models\LoadModel;

final class LoadSearcherService {

    private LoadModel $loadModel;
    private LoadToLoadResponseConverter $converter;

    public function __construct() {
        $this->loadModel = new LoadModel();
        $this->converter = new LoadToLoadResponseConverter();
    }

    /**
     * @return LoadResponse[]
     */
    public function search(): array
    {
        $loads = $this->loadModel->search();

        $responses = [];
        foreach ($loads as $load) {
            $responses[] = $this->converter->convert($load);
        }

        return $responses;
    }
}
