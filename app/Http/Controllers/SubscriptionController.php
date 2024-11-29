<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\SubscriptionService;

class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    // Abonelik Oluşturma
    public function createSubscription(Request $request, $id)
    {
        try {
            $subscription = $this->subscriptionService->createSubscription($id, $request->all());
            return response()->json(['subscription' => $subscription], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 400);
        }
    }

    // Yeni Abonelik Kaydı
    public function addSubscription(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Kullanıcı bulunamadı.'], 404);
        }

        $validated = $request->validate([
            'renewed_at' => 'required|date',
            'expired_at' => 'required|date|after:renewed_at',
        ]);

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'renewed_at' => $validated['renewed_at'],
            'expired_at' => $validated['expired_at'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Abonelik başarıyla oluşturuldu.',
            'subscription' => $subscription,
        ], 201);
    }

    // Abonelik Güncelleme
    public function updateSubscription(Request $request, $id, $subscription_id)
    {
        $user = User::find($id);
        $subscription = Subscription::find($subscription_id);

        if (!$user || !$subscription || $subscription->user_id !== $user->id) {
            return response()->json(['message' => 'Kullanıcı veya abonelik bulunamadı.'], 404);
        }

        $validated = $request->validate([
            'renewed_at' => 'nullable|date',
            'expired_at' => 'nullable|date|after:renewed_at',
        ]);

        $subscription->update($validated);

        return response()->json([
            'message' => 'Abonelik başarıyla güncellendi.',
            'subscription' => $subscription,
        ], 200);
    }

    // Abonelik Silme
    public function deleteSubscription($id, $subscription_id)
    {
        $user = User::find($id);
        $subscription = Subscription::find($subscription_id);

        if (!$user || !$subscription || $subscription->user_id !== $user->id) {
            return response()->json(['message' => 'Kullanıcı veya abonelik bulunamadı.'], 404);
        }

        $subscription->delete();

        return response()->json(['message' => 'Abonelik başarıyla silindi.'], 200);
    }
}
