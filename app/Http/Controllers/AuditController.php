<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AuditController extends Controller
{
    public static function logActivity(Request $request, $response, $status = 'success')
    {
        $user = Auth::user();
        $tenantId = $user->tenant_id ?? null;
        $userId = $user->id ?? null;
        $requestTime = now();
        $responseTime = now();
        $activity = [
            'tenant_id' => $tenantId,
            'user_id' => $userId,
            'request' => $request->all(),
            'request_time' => $requestTime,
            'response' => $response,
            'response_time' => $responseTime,
            'status' => $status,
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'ip' => $request->ip(),
        ];
        Log::info('AuditController@logActivity', $activity);
        // Optionally, persist to DB if you have an audit_logs table
        // DB::table('audit_logs')->insert($activity);
    }
}
