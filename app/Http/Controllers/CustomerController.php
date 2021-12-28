<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function customerWithHighestSpending(){
        $customerObject =  DB::select('SELECT customers.customerNumber, (select sum(orderdetails.priceEach*orderdetails.quantityOrdered)) as total FROM customers, orders, orderdetails WHERE orders.orderNumber = orderdetails.orderNumber and orders.customerNumber = customers.customerNumber GROUP by customers.customerNumber ORDER BY total DESC LIMIT 0,1');
        $customer = Customer::find($customerObject[0]->customerNumber);
        $customer->setAttribute('totalPurchased', $customerObject[0]->total);
        return $customer;
    }

    public function customerWithHighestOrders(){
        return Customer::withCount('orders')->orderBy('orders_count','desc')->first();
    }
}
