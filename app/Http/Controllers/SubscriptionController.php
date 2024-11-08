<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;


class SubscriptionController extends Controller
{
    
    public function Subs(Request $request, $user_id)
    {
        $validated = $request->validate([
            'renewed_at' => 'required|date',
            'expired_at' => 'required|date',
        ]);

        $subscription = Subscription::create([
            'user_id' => $user_id,
            'renewed_at' => $validated['renewed_at'],
            'expired_at' => $validated['expired_at'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Abonelik işleminiz başarılı bir şekilde tamamlanmıştır.',
            'subscription' => $subscription,
        ], 201);
    }

    public function SubUpdate(Request $request, $user_id,$subscriptionId) {

        $validated = $request->validate([
            'renewed_at' => 'required|date',
            'expired_at' => 'required|date',
        ]);

        $subscription = Subscription::where('user_id', $user_id)->findOrFail($subscriptionId);

        $subscription->update([
            'renewed_at' => $validated['renewed_at'],
            'expired_at' => $validated['expired_at'],
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Abonelik başariyla güncellendi.',
            'subscription' => $subscription
        ], 200);
    }
    public function SubDelete($user_id) {
        
        $subscription = Subscription::where('user_id', $user_id)->first();

        $subscription->delete();
    }


}
    
