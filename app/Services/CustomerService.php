<?php 

namespace App\Services;

use App\Enums\GenderEnum;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function validateRequest(Request $request): void
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'gender' => ['required', new Enum(GenderEnum::class)],
            'address' => 'required|string|max:255'
        ]);
    }

    public function getAllData()
    {
        return $this->customerRepository->getAll();
    }

    public function getDataById(int $id)
    {
        return $this->customerRepository->getById($id);
    }

    public function createData(Request $request)
    {
        $this->validateRequest($request);

        return $this->customerRepository->create([
            'name' => $request->name,
            'city' => $request->city,
            'gender' => $request->gender,
            'address' => $request->address,
        ]);
    }

    public function updateData(int $id, Request $request)
    {
        $this->validateRequest($request);

        return $this->customerRepository->update($id, [
            'name' => $request->name,
            'city' => $request->city,
            'gender' => $request->gender,
            'address' => $request->address,
        ]);
    }

    public function deleteData(int $id): void
    {
        $this->customerRepository->delete($id);
    }

    
}   
