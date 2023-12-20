<?php

namespace App\Http\Controllers;

use App\Models\Connection as ConnectionModel;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Mews\Purifier\Facades\Purifier;

class mainController extends Controller
{

    protected function authenticateUser($firstUser, $secondUser)
    {
        $isFirstUser = ConnectionModel::where('first_user', $firstUser)->Where('second_user', $secondUser)->first();
        if (!$isFirstUser) {
            $isSecondUser = ConnectionModel::where('second_user', $firstUser)->Where('first_user', $secondUser)->first();
            if (!$isSecondUser) {
                return false;
            } else {
                return true;
            }
        }
        return true;
    }

    protected function connectionId($firstUser, $secondUser)
    {
        $isFirstUser = ConnectionModel::where('first_user', $firstUser)->Where('second_user', $secondUser)->select('id')->first();
        if (!$isFirstUser) {
            $isSecondUser = ConnectionModel::where('second_user', $firstUser)->Where('first_user', $secondUser)->select('id')->first();
            if (!$isSecondUser) {
                return false;
            } else {
                return $isSecondUser->id;
            }
        }
        return $isFirstUser->id;
    }

    public function index()
    {
        $authUser = Auth::user();
        $connections = ConnectionModel::where(function ($query) use ($authUser) {
            $query->where('connections.first_user', $authUser->id)
                ->orWhere('connections.second_user', $authUser->id);
        })
            ->where('connections.status', 'connected')
            ->orderBy('connected_from', 'ASC')
            ->select('id', 'first_user', 'second_user', 'last_message')
            ->get();

        $requestsLists = ConnectionModel::where(function ($query) use ($authUser) {
            $query->where('connections.first_user', $authUser->id)
                ->orWhere('connections.second_user', $authUser->id);
        })
            ->where('connections.status', 'requested')
            ->whereNOt('connections.requested_by', $authUser->id)
            ->orderBy('created_at', 'ASC')
            ->select('id', 'first_user', 'second_user', 'last_message', 'created_at')
            ->get();

        // dd($requestsLists->toArray());
        return view('home', compact('connections', 'requestsLists'));
    }

    // public function sendMsg(Request $request)
    // {
    //     $cleanContent = Purifier::clean($request->input('type_message'));
    //     $contentWithLineBreaks = nl2br($cleanContent);
    //     dd($contentWithLineBreaks);
    // }

    // public function userChats($username)
    // {
    //     try {
    //         $authUser = Auth::user();
    //     } catch (\Exception $err) {
    //         return redirect()->back()->with('error', 'Something went wrong. ' . $err);
    //     }
    // }

    public function getMessage($id, $username)
    {
        try {
            if ($id == 0) {
                return response()->json(['status' => false, 'message' => 'Something went wrong.']);
            }
            $authUser = Auth::user();

            if (!$this->authenticateUser($authUser->id, $id)) {
                return response()->json(['status' => false, 'message' => 'Sorry, You are not connected with ' . $username]);
            }

            //validation Passed Connected now retrive the message

            $authUserId = $authUser->id;

            $messages = Message::where(function ($query) use ($authUserId, $id) {
                $query->where('sender', $authUserId)
                    ->where('reciever', $id);
            })
                ->orWhere(function ($query) use ($authUserId, $id) {
                    $query->where('sender', $id)
                        ->where('reciever', $authUserId);
                })
                ->orderBy('time', 'ASC')
                ->get();

            Message::where('reciever', $authUserId)->where('status', 'unseen')->update(['status' => 'seen']);

            $otherPersoDetails = User::where('id', $id)->select('id', 'name', 'profile_pic')->first();
            // dd($otherPersoDetails->toArray());
            $otherPersoneName = $otherPersoDetails->name;
            $dbImage = $otherPersoDetails->profile_pic;

            if ($dbImage == null || $dbImage == '') {
                $otherPersonImage = asset('assets/images/dummy-imgs/default-profile-picture.jpg');
            } else {
                $otherPersonImage = asset('user_profile_picture/thumb/' . $dbImage);
            }
            $otherPersoneId = $otherPersoDetails->id;

            return view('chats', compact('messages', 'otherPersoneName', 'otherPersonImage', 'otherPersoneId'));
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => 'Something went wrong ' . $err]);
        }
    }

    public function SendMessageAjax(Request $request)
    {
        try {

            $rules = [
                'id' => 'required|numeric',
                'message' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Validation Failed']);
            }

            $authUser = Auth::user();
            if (!$this->authenticateUser($authUser->id, $request->id)) {
                return response()->json(['status' => false, 'message' => 'Authentication Failed']);
            }

            // Authentication Passed Now Insert The Message

            $now = Carbon::now();
            $cleanContent = Purifier::clean($request->message);
            $message = nl2br($cleanContent);

            $msgId = DB::table('messages')->insertGetId([
                'message' => $message ?? 'Server Issue',
                'sender' =>  $authUser->id,
                'reciever' => $request->id,
                'status' => 'unseen',
                'time' => $now
            ]);

            $connectionId = $this->connectionId($authUser->id, $request->id);
            try {
                $connection = ConnectionModel::where('id', $connectionId)->first();
                $connection->last_message = $msgId;
                $connection->update();
            } catch (\Exception $err) {
                dd($err);
            }
            return response()->json(['status' => true, 'time' => Carbon::parse($now)->format('h:iA'), 'message' => $message]);
        } catch (\Exception $err) {
            dd($err);
            return response()->json(['status' => false, 'message' => 'Something went wrong ' . $err]);
        }
    }

    public function getMessageRealtime($id, $username)
    {
        try {
            if ($id == 0 || $id == '') {
                return response()->json(['status' => false, 'message' => 'Something went wrong.']);
            }
            $authUser = Auth::user();

            if (!$this->authenticateUser($authUser->id, $id)) {
                return response()->json(['status' => false, 'message' => 'Sorry, You are not connected with ' . $username]);
            }

            //validation Passed Connected now retrive the message
            $authUserId = $authUser->id;
            $messages = Message::where('reciever', $authUserId)->where('sender', $id)->where('status', 'unseen')->get();
            Message::where('reciever', $authUserId)->where('sender', $id)->where('status', 'unseen')->update(['status' => 'seen']);
            return view('realtime-chats', compact('messages'));
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => 'Something went wrong ' . $err]);
        }
    }

    public function searchUser($username)
    {
        try {
            if ($username == '') {
                return response()->json(['status' => true, 'message' => '']);
            }
            $authUser = Auth::user();
            $users = User::where('username', 'like', '%' . $username . '%')->orWhere('name', 'like', '%' . $username . '%')->where('status', 'active')->where('type', 'user')->whereNotIn('id', [$authUser->id])->select('id', 'name', 'username', 'profile_pic')->limit(50)->get();
            $response = '';
            foreach ($users as $user) {
                $profilePic = '';
                if ($user->profile_pic != '') {
                    $profilePic = asset('user_profile_picture/thumb/' . $user->profile_pic);
                } else {
                    $profilePic = asset('assets/images/dummy-imgs/default-profile-picture.jpg');
                }

                $response .= "<li data-id=\"$user->id\" data-name=\"$user->name ($user->username)\"><img src=\"$profilePic\" alt=\"$user->username\" class=\"suggestion-users\">$user->name ($user->username)</li>";
            }

            return response()->json(['status' => true, 'message' => $response]);
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => $err]);
        }
    }

    public function sendRequest(Request $request)
    {
        try {
            $id = $request->id;
            $authUser = Auth::user();
            if ($id == 0 || $id == '') {
                return response()->json(['status' => false, 'message' => "Something went wrong please reload and check again."]);
            }
            //Check for user exist
            $user = User::where('id', $id)->select('id', 'username', 'name', 'status')->first();
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'User not found.']);
            }
            //Check for user active or not
            if ($user->status != 'active') {
                return response()->json(['status' => false, 'message' => 'User account is not active.']);
            }
            //Check for already connected first user
            $friendListsFirst = ConnectionModel::where('first_user', $authUser->id)->where('second_user', $id)->first();
            if ($friendListsFirst) {
                if ($friendListsFirst->status == 'connected') {
                    return response()->json(['status' => false, 'message' => 'You already have connection with ' . $user->name . ' (' . $user->username . ')']);
                } else if ($friendListsFirst->status == 'requested' && $friendListsFirst->requested_by == $authUser->id) {
                    return response()->json(['status' => false, 'message' => 'You have already send connection request to ' . $user->name . ' (' . $user->username . ')']);
                } else if ($friendListsFirst->status == 'requested' && $friendListsFirst->requested_by == $id) {
                    return response()->json(['status' => false, 'message' => $user->name . ' (' . $user->username . ') already send you connection request please check request list to accept.']);
                } else if ($friendListsFirst->status == "blocked") {
                    return response()->json(['status' => false, 'message' => 'This conversation is blocked']);
                }
            }
            //Check for already connected second user
            $friendListsSecond = ConnectionModel::where('second_user', $authUser->id)->where('first_user', $id)->first();
            if ($friendListsSecond) {
                if ($friendListsSecond->status == 'connected') {
                    return response()->json(['status' => false, 'message' => 'You already have connection with ' . $user->name . ' (' . $user->username . ')']);
                } else if ($friendListsSecond->status == 'requested' && $friendListsSecond->requested_by == $authUser->id) {
                    return response()->json(['status' => false, 'message' => 'You have already send connection request to ' . $user->name . ' (' . $user->username . ')']);
                } else if ($friendListsSecond->status == 'requested' && $friendListsSecond->requested_by == $id) {
                    return response()->json(['status' => false, 'message' => $user->name . ' (' . $user->username . ') already send you connection request please check request list to accept.']);
                } else if ($friendListsSecond->status == "blocked") {
                    return response()->json(['status' => false, 'message' => 'This conversation is blocked']);
                }
            }
            //check for block list


            //Send friend requiest
            $connection = new ConnectionModel();
            $connection->first_user = $authUser->id;
            $connection->second_user = $id;
            $connection->status = 'requested';
            $connection->requested_by = $authUser->id;
            $connection->save();
            return response()->json(['status' => true, 'message' => 'Connection request send to ' . $user->name . ' (' . $user->username . ')']);
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => $err]);
        }
    }

    public function acceptRejectRequest(Request $request)
    {
        try {
            $rules = [
                'id' => 'required|numeric',
                'action' => 'required|in:accept,reject'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Validation Failed']);
            }

            $authUser = Auth::user();

            $connection = ConnectionModel::find($request->id);
            if (!$connection) {
                return response()->json(['status' => false, 'message' => 'Connection Not Found']);
            }

            if ($connection->first_user == $authUser->id || $connection->second_user == $authUser->id) {
                $otherUser = $connection->first_user == $authUser->id ? $connection->second_user : $connection->first_user;
                $userD = User::find($otherUser);
                if (!$userD) {
                    return response()->json(['status' => false, 'message' => "User not found"]);
                }
                if ($request->action == 'accept') {
                    $connection->status = 'connected';
                    $connection->connected_from = Carbon::now();
                    $connection->update();

                    if ($userD->profile_pic == '') {
                        $dp = asset('assets/images/dummy-imgs/default-profile-picture.jpg');
                    } else {
                        $dp = asset('user_profile_picture/thumb/' . $userD->profile_pic);
                    }

                    $htmlStructureAdded = '
                    <div class="row indivisual-user" data-id="' . $userD->id . '" data-username="' . $userD->username . '" data-name="' . $userD->name . '">
                        <div class="user-image-div col-3">
                            <img src="' . $dp . '" 
                            alt="' . $userD->name . '" class="users-dp">
                        </div>
                        <div class="user-details-div col-9">
                            <p class="m-0 user-name">
                                ' . $userD->name . '
                            </p>
                            <p class="m-0 message-details">
                                <span style="color:grey;">No Conversation Yet</span>
                            </p>
                                                                
                        </div>
                    </div>
                    ';
                    return response()->json(['status' => true, 'message' => "Connection request accepted succesfully", 'data' => ['htmlStructure' => $htmlStructureAdded]]);
                } else {
                    $connection->delete();
                    return response()->json(['status' => true, 'message' => "Connection request rejected succesfully"]);
                }
            } else {
                return response()->json(['status' => false, 'message' => "You don't have access to that connection"]);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => 'Something went wrong.']);
        }
    }
}
