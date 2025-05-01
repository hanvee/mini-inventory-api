<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponser;

    protected $productService;

    public function __construct(ProductService $productService) 
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $data = $this->productService->getAllData();
        return $this->collectionData($data);
    }

    public function show(string $id)
    {
        $data = $this->productService->getDataById($id);
        return $this->singleData($data);
    }
    
    public function store(Request $request)
    {
        $data = $this->productService->createData($request);
        return $this->singleData($data);
    }

    public function update(string $id, Request $request)
    {
        $data = $this->productService->updateData($id, $request);
        return $this->singleData($data);
    }

    public function destroy(string $id)
    {
        $this->productService->deleteData($id);
        return $this->successResponse([
            'message' => 'Product deleted successfully',
        ]);
    }

}
