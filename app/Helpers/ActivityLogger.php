<?php

namespace App\Helpers;

use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Log an action to Firebase Realtime Database
     * 
     * @param string $action Tipe aksi (misal: Create, Update, Delete)
     * @param string $description Deskripsi singkat aksi
     * @param array $details Detail tambahan (opsional)
     */
    public static function log($action, $description, $details = [])
    {
        try {
            $credentialsPath = config('firebase.projects.app.credentials');

            // Use Realtime Database instead of Firestore
            $factory = (new Factory)
                ->withServiceAccount($credentialsPath)
                ->withDatabaseUri(config('firebase.projects.app.database.url'));

            $database = $factory->createDatabase();

            $user = Auth::user();

            $logData = [
                'admin_id' => $user ? $user->id : null,
                'admin_name' => $user ? $user->name : 'System',
                'admin_email' => $user ? $user->email : '-',
                'action' => $action,
                'description' => $description,
                'details' => $details,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now()->toIso8601String(),
                'timestamp' => time()
            ];

            // Simpan ke Realtime Database under 'activity_logs'
            $database->getReference('activity_logs')->push($logData);

            return true;
        } catch (\Exception $e) {
            \Log::error('Firebase Logging Error: ' . $e->getMessage());
            return false;
        }
    }
}
