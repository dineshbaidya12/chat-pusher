<?php

namespace App\Http\Controllers;

use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class statusController extends Controller
{
    public function updateStatus(Request $request)
    {
        $userid = Auth::user();
        $status = $request->input('status');
        $user = UserInformation::where('user_id', 1)->first();
        if ($user) {
            $user->status = $status;
            $user->save();
        }
        return response()->json(['message' => 'Status updated successfully' . $status]);
    }
}
