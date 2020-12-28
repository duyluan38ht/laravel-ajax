<?php


namespace App\Http\Services;


use App\Http\Repositories\CustomerRepository;

class CustomerService
{
    protected $customerRepo;

    public function __construct(CustomerRepository $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }

    public function getAll()
    {
//        return $this->customerRepo->getAll();
    }
//    public function addCustomer($data){
//         $this->customerRepo->addCustomer($data);
//    }
}
