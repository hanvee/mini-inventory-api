<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function validateRequest(Request $request): void
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
    }

    public function getAllData()
    {
        return $this->productRepository->getAll();
    }

    public function getDataById(int $id): Product
    {
        return $this->productRepository->getById($id);
    }

    public function createData(Request $request): Product
    {
        $this->validateRequest($request);

        return $this->productRepository->create([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
        ]);
    }

    public function updateData(int $id, Request $request): Product
    {
        $this->validateRequest($request);

        return $this->productRepository->update($id, [
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
        ]);
    }

    public function deleteData(int $id): void
    {
        $this->productRepository->delete($id);
    }
}