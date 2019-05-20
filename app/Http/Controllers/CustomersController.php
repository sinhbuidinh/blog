<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index(Request $request)
    {
        //don't have order => default order by name
        $order_field = $request->get('order');
        $search = $request->get('search');
        $customers = Customer::with('company')
            ->withLastInteraction()
            ->whereSearch($search)
            ->orderByField($order_field)
            ->paginate();

        return view('scope.customers', [
            'customers' => $customers,
            'order_field' => $order_field,
            'search' => $search
        ]);
    }
}