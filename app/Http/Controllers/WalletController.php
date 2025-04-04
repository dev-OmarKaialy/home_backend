<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function topUp(Request $request)
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:1',
                'reference' => 'nullable|string'
            ]);


            $wallet = Wallet::firstOrCreate(
                ['user_id' => Auth::user()->id],
                ['balance' => 0]
            );

            // Create transaction
            $transaction = Transaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'deposit',
                'amount' => $request->amount,
                'reference' => $request->reference,
            ]);

            // Update wallet balance
            $wallet->increment('balance', $request->amount);

            return ApiResponse::success($transaction);

        } catch (\Exception $e) {
            return ApiResponse::error(401,$e->getMessage());
        }
    }
    public function getBalance(Request  $request){
        return ApiResponse::success( Auth::user()->wallet);
    }
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'reference' => 'nullable|string'
        ]);
{
            $wallet = Wallet::where('user_id', Auth::user()->id)->first();

            if (!$wallet || $wallet->balance < $request->amount) {
                return ApiResponse::error(400,'No Balance',null);
            }

            // Create transaction
            $transaction = Transaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'withdrawal',
                'amount' => $request->amount,
                'reference' => $request->reference,
            ]);

            // Deduct from wallet balance
            $wallet->decrement('balance', $request->amount);

            return ApiResponse::success($transaction);
        };
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Wallet $wallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}
