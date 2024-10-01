<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OperationGetRequest;

class OperationController extends Controller
{
    /**
     * @param OperationGetRequest $request
     * @return \Illuminate\Container\Container|mixed|object
     */
    public function index(OperationGetRequest $request)
    {
        $user = Auth::user();

        $query = Operation::where('user_id', $user->id);

        // Search
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        // Final format with sorting, searching and pagination
        $query->orderBy('created_at', 'desc');
        $operations = $query->paginate(5);
        $operations->appends($request->only('search'));

        // if AJAX
        if ($request->ajax()) {
            return view('components.operation-data', ['operations' => $operations]);
        }

        // if not AJAX
        return view('operation', ['operations' => $operations]);
    }
}
