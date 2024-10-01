<?php

namespace App\Http\Controllers;

use App\Repository\FetchDataRepository;

class DashboardController extends Controller
{
    /**
     * Show main page with balance and transactions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $imageRepository = new FetchDataRepository();
        $balanceAndOperations = $imageRepository->getBalanceAndOperation();

        return view('dashboard', [
            'balance' => $balanceAndOperations['balance'],
            'operations' => $balanceAndOperations['operations']
        ]);
    }

    /**
     * Method for AJAX request that will return data in JSON format
     *
     * @return array
     */
    public function fetchData()
    {
        $imageRepository = new FetchDataRepository();
        $balanceAndOperations = $imageRepository->getBalanceAndOperation();

        return $balanceAndOperations;
    }
}
