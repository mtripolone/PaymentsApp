<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Transference\Notification\NotificationService;
use Illuminate\Support\Facades\Log;

class NotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private readonly User $payee,
        private readonly string $message
    ) { }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(NotificationService $notification): void
    {
        $notification->notifyClient($this->payee, $this->message);
    }
}
