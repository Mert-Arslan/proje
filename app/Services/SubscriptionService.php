<?php
namespace App\Services;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class SubscriptionService
{
    public function createSubscription($userId, $data)
    {
        $user = User::find($userId);
        if (!$user) {
            throw new \Exception('Kullanıcı bulunamadı', 404);
        }

        $validated = Validator::make($data, [
            'renewed_at' => 'required|date',
            'expired_at' => 'required|date',
        ])->validate();

        return Subscription::create(array_merge($validated, ['user_id' => $user->id]));
    }

    public function updateSubscription($userId, $subscriptionId, $data)
    {
        $subscription = Subscription::where('user_id', $userId)
            ->find($subscriptionId);

        if (!$subscription) {
            throw new \Exception('Abonelik bulunamadı', 404);
        }

        $validated = Validator::make($data, [
            'renewed_at' => 'nullable|date',
            'expired_at' => 'nullable|date|after:renewed_at',
        ])->validate();

        $subscription->update($validated);

        return $subscription;
    }

    public function deleteSubscription($userId, $subscriptionId)
    {
        $subscription = Subscription::where('user_id', $userId)
            ->find($subscriptionId);

        if (!$subscription) {
            throw new \Exception('Abonelik bulunamadı', 404);
        }

        $subscription->delete();

        return true;
    }
}
