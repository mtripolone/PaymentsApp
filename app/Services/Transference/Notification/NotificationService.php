<?php

namespace App\Services\Transference\Notification;

use App\Models\User;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class NotificationService
{
    public function notifyClient(User $payee, String $message)
    {
        try {
            $client = new Client();
            $client->request('POST', config('services.notification.address'));
            return $this->sendNotification($payee, $message);
        } catch (Exception $e) {
            $this->sendNotification($payee, "Envio de notificação indisponivel!");
            throw new Exception('Não foi possivel enviar a notificação!', Response::HTTP_SERVICE_UNAVAILABLE, $e);
        }
    }

    private function sendNotification(User $payee, string $message): void
    {
        $filename = 'notifications/' . now()->format('Ymd_His') . '_' . $payee->id . '.txt';
        Storage::disk('local')->put($filename, $message);
    }
}
