<?php

namespace App\Services;

use App\Repositories\SaleRepository;
use Illuminate\Http\Request;

class SaleService
{
    protected $saleRepository;

    public function __construct(SaleRepository $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    public function validateRequest(Request $request): void
    {
        $request->validate([
            'date' => 'required|string|max:255',
            'customer_id' => 'required|integer|exists:customers,id',
            'subtotal' => 'required|numeric|min:0',
        ]);
    }

    public function getAllData()
    {
        return $this->saleRepository->getAll();
    }

    public function getDataById(int $id)
    {
        return $this->saleRepository->getById($id);
    }

    public function createData(Request $request)
    {
        $this->validateRequest($request);

        return $this->saleRepository->create([
            'date' => $request->date,
            'customer_id' => $request->customer_id,
            'subtotal' => $request->subtotal,
        ]);
    }

    public function updateData(int $id, Request $request)
    {
        $this->validateRequest($request);

        return $this->saleRepository->update($id, [
            'date' => $request->date,
            'customer_id' => $request->customer_id,
            'subtotal' => $request->subtotal,
        ]);
    }

    public function deleteData(int $id): void
    {
        $this->saleRepository->delete($id);
    }
}