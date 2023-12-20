<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getUserDetails($id)
    {
        try {
            $user = User::where('id', $id)->where('status', 'active')->first();
            if (!$user) {
                return false;
            }
            return $user;
        } catch (\Exception $err) {
            return false;
        }
    }

    function formatTimeAgo($timestamp)
    {
        $currentTime = now();
        $timeDifference = $currentTime->diffInSeconds($timestamp);

        if ($timeDifference < 60) {
            return 'Just a moment ago';
        } elseif ($timeDifference < 3600) {
            $minutes = floor($timeDifference / 60);
            return "$minutes minute" . ($minutes > 1 ? 's' : '') . ' ago';
        } elseif ($timeDifference < 86400) {
            $hours = floor($timeDifference / 3600);
            return "$hours hour" . ($hours > 1 ? 's' : '') . ' ago';
        } elseif ($timeDifference < 432000) {
            $days = floor($timeDifference / 86400);
            return "$days day" . ($days > 1 ? 's' : '') . ' ago';
        } else {
            return $timestamp->format('Y-m-d H:i:s');
        }
    }
}
