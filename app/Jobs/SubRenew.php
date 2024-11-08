<?php

namespace App\Jobs;


use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SubRenew implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $now = Carbon::now();

        
        $subscriptions = Subscription::where('expired_at', '<', $now)->get();

        foreach ($subscriptions as $subscription) {
            
            $subscription->renewed_at = $now;
            $subscription->expired_at = $now->copy()->addMonth(); 

           
            $subscription->save();
        }
    }
}
