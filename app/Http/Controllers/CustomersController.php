<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::with('company')
            ->withLastInteractionDate()
            ->orderByName()
            ->paginate();

        return view('scope.customers', ['customers' => $customers]);
    }
}