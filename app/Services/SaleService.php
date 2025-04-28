<?php

namespace App\Services;

use App\Repositories\SaleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'items' => 'required|array|min:1',
            'items.*.product_code' => 'required|exists:products,code',
            'items.*.qty' => 'required|integer|min:1',
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

        return DB::transaction(function () use ($request) {
            $sale = $this->saleRepository->create([
                'date' => $request->date,
                'customer_id' => $request->customer_id,
                'subtotal' => $request->subtotal,
            ]);

            foreach ($request->items as $item) {
                $sale->saleItems()->create([
                    'product_code' => $item['product_code'],
                    'qty' => $item['qty']
                ]);
            }

            $sale->load('saleItems');

            return $sale;
        });
    }

    public function updateData(int $id, Request $request)
    {
        $this->validateRequest($request);

        return DB::transaction(function () use ($request, $id) {
            $sale = $this->saleRepository->update($id, [
                'date' => $request->date,
                'customer_id' => $request->customer_id,
                'subtotal' => $request->subtotal,
            ]);

            $sale->saleItems()->delete();

            foreach ($request->items as $item) {
                $sale->saleItems()->create([
                    'product_code' => $item['product_code'],
                    'qty' => $item['qty']
                ]);
            }


            $sale->load('saleItems');

            return $sale;
        });
    }

    public function deleteData(int $id): void
    {
        $this->saleRepository->delete($id);
    }
}
