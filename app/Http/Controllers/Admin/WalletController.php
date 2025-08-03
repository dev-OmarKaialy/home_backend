<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('wallet.user')->orderBy('created_at', 'desc')->get();
        return view('wallets.index', compact('transactions'));
    }

    public function approve($id)
    {
        $transaction = Transaction::with('wallet')->findOrFail($id);

        if ($transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'Transaction already handled.');
        }

        $wallet = $transaction->wallet;

        if ($transaction->type === 'deposit') {
            $wallet->increment('balance', $transaction->amount);
        } elseif ($transaction->type === 'withdrawal') {
            if ($wallet->balance < $transaction->amount) {
                return redirect()->back()->with('error', 'Insufficient balance for withdrawal.');
            }
            $wallet->decrement('balance', $transaction->amount);
        }

        $transaction->status = 'approved';
        $transaction->save();

        return redirect()->back()->with('success', 'Transaction approved successfully.');
    }

    public function reject($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'Transaction already handled.');
        }

        $transaction->status = 'rejected';
        $transaction->save();

        return redirect()->back()->with('success', 'Transaction rejected successfully.');
    }
}
