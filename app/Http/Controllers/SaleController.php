<?php

namespace App\Http\Controllers;

use App\Services\SaleService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    use ApiResponser;

    protected $saleService; 

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function index()
    {
        $data = $this->saleService->getAllData();
        return $this->collectionData($data);
    }

    public function show(string $id)
    {
        $data = $this->saleService->getDataById($id);
        return $this->singleData($data);
    }

    public function store(Request $request)
    {
        $data = $this->saleService->createData($request);
        return $this->singleData($data);
    }

    public function update(string $id, Request $request)
    {
        $data = $this->saleService->updateData($id, $request);
        return $this->singleData($data);
    }

    public function destroy(string $id)
    {
        $this->saleService->deleteData($id);
        return $this->successResponse([
            'message' => 'Sale deleted successfully',
        ]);
    }
}
