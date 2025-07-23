<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class WalletController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using('admin'), except: ['getBalance','createTransactionRequest']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function createTransactionRequest(Request $request)
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
                'type' => $request->type,
                'amount' => $request->amount,
                'reference' => $request->reference,
                'status' => 'pending'
            ]);

            return ApiResponse::success($transaction);
        } catch (\Exception $e) {
            return ApiResponse::error(401, $e->getMessage());
        }
    }

    public function getBalance(Request  $request)
    {
        return ApiResponse::success(Auth::user()->wallet);
    }
    public function approveTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status !== 'pending') {
            return ApiResponse::error(400, 'Transaction already handled');
        }

        // اعتماد المعاملة
        $transaction->status = 'approved';
        $transaction->save();

        $wallet = $transaction->wallet;

        if ($transaction->type === 'deposit') {
            $wallet->increment('balance', $transaction->amount);
        } elseif ($transaction->type === 'withdrawal') {
            if ($wallet->balance < $transaction->amount) {
                return ApiResponse::error(400, 'Insufficient balance');
            }
            $wallet->decrement('balance', $transaction->amount);
        }

        return ApiResponse::success($transaction);
    }

    public function rejectTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status !== 'pending') {
            return ApiResponse::error(400, 'Transaction already handled');
        }

        $transaction->status = 'rejected';
        $transaction->save();

        return ApiResponse::success($transaction);
    }


    public function index()
    {
        return ApiResponse::success(Transaction::get());
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
        try {
            $wallet->delete();
            return ApiResponse::success('Wallet deleted successfully', 200);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to delete wallet', 500, $e->getMessage());
        }
    }
}
