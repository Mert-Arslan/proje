<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class TransactionService
{
    public function createTransaction($userId, $data)
    {
        
        $user = User::find($userId);
        if (!$user) {
            throw new \Exception('Kullanıcı bulunamadı', 404);
        }

       
        $validated = Validator::make($data, [
            'subscription_id' => 'required|exists:subscriptions,id',
            'price' => 'required|numeric',
        ])->validate();

       
        return Transaction::create([
            'user_id' => $user->id,
            'subscription_id' => $validated['subscription_id'],
            'price' => $validated['price'],
        ]);
    }
}
