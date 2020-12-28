<?php

namespace App\Http\Controllers;

use App\Http\Services\CustomerService;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        $customers = Customer::all();
        return response()->json($customers, 200);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $customer = new Customer();
        $customer->fill($request->all());
        $customer->save();
        return response()->json($customer,200);
    }


    public function show()
    {

    }

    public function edit($id)
    {
        $customer=Customer::findOrFail($id);
        return response()->json($customer,200);
    }


    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->fill($request->all());
        $customer->save();
        return response()->json($customer,200);
    }


    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return response()->json($customer,200);

    }

    public function search($key){
        $customer=DB::table('customers')->where('customer_name','like','%'.$key.'%')->get();
        return response()->json($customer,200);
    }
}
