<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    use ApiResponser;

    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        $data = $this->customerService->getAllData();
        return $this->collectionData($data);
    }

    public function show(int $id)
    {
        $data = $this->customerService->getDataById($id);
        return $this->singleData($data);
    }

    public function store(Request $request)
    {
        $data = $this->customerService->createData($request);
        return $this->singleData($data);
    }

    public function update(int $id, Request $request)
    {
        $data = $this->customerService->updateData($id, $request);
        return $this->singleData($data);
    }

    public function destroy(int $id)
    {
        $this->customerService->deleteData($id);
        return $this->successResponse([
            'message' => 'Customer deleted successfully',
        ]);
    }
}
