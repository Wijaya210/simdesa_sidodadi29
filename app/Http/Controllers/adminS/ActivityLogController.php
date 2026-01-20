<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Log;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = [];

        try {
            // Inisialisasi Firebase Realtime Database
            $factory = (new Factory)
                ->withServiceAccount(config('firebase.projects.app.credentials'))
                ->withDatabaseUri(config('firebase.projects.app.database.url'));

            $database = $factory->createDatabase();

            // Ambil SEMUA data tanpa orderBy (AMAN)
            $reference = $database->getReference('activity_logs');
            $values = $reference->getValue();

            if (!empty($values) && is_array($values)) {

                // Flatten data (buang push ID)
                foreach ($values as $key => $value) {
                    if (is_array($value)) {
                        $logs[] = $value;
                    }
                }

                // Urutkan dari TERBARU ke TERLAMA berdasarkan timestamp
                usort($logs, function ($a, $b) {
                    return ($b['timestamp'] ?? 0) <=> ($a['timestamp'] ?? 0);
                });

                // Batasi 100 data terbaru
                $logs = array_slice($logs, 0, 100);
            }

        } catch (\Throwable $e) {
            Log::error('Error fetching Firebase activity logs: '.$e->getMessage());
        }

        return view('admins.logs.index', compact('logs'));
    }
}
