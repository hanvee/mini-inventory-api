<?php

namespace App\Services;

use App\Enums\CategoryEnum;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

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
            'category' => ['required', new Enum(CategoryEnum::class)],
            'price' => 'required|numeric|min:0',
            'color' => 'required|string|max:255'
        ]);
    }

    public function getAllData()
    {
        return $this->productRepository->getAll();
    }

    public function getDataById(string $id): Product
    {
        return $this->productRepository->getById($id);
    }

    public function createData(Request $request): Product
    {
        $this->validateRequest($request);

        $productCode = 'PRD_' . Str::upper(Str::random(6));

        return $this->productRepository->create([
            'product_code' => $productCode, 
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'color' => $request->color
        ]);
    }

    public function updateData(string $id, Request $request): Product
    {
        $this->validateRequest($request);

        return $this->productRepository->update($id, [
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'color' => $request->color
        ]);
    }

    public function deleteData(string $id): void
    {
        $this->productRepository->delete($id);
    }
}