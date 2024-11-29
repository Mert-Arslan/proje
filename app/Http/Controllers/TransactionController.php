<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;


class TransactionController extends Controller
{
    public function TransactionFunc(Request $request, $id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'Kullanıcı bulunamadı.'], 404);
    }

    $validated = $request->validate([
        'subscription_id' => 'required|exists:subscriptions,id',
        'price' => 'required|numeric',
    ]);

    $transaction = Transaction::create([
        'user_id' => $user->id,
        'subscription_id' => $validated['subscription_id'],
        'price' => $validated['price'],
    ]);

    return response()->json(['transaction' => $transaction], 201);
}
}
