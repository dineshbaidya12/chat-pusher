<?php

namespace App\Http\Controllers;

use App\Events\AccesptFriendRequest;
use App\Events\LeftBarBrodacast;
use App\Events\MessageSeenBroadcast;
use App\Events\PusherBroadcast;
use App\Events\SendFriendRequest;
use App\Events\TypingStatus;
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
        return view('home', compact('connections', 'requestsLists', 'authUser'));
    }

    public function getMessage($id, $username)
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

            $unseenMessages = Message::where('reciever', $authUserId)->where('sender', $id)->where('status', 'unseen')->count();
            Message::where('reciever', $authUserId)->where('sender', $id)->where('status', 'unseen')->update(['status' => 'seen']);

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

            $connectionId = $this->connectionId($otherPersoneId,  $authUserId);

            if ($unseenMessages > 0) {
                broadcast(new MessageSeenBroadcast($otherPersoneId, $authUserId, $connectionId))->toOthers();
            }

            $response = [
                'html' => view('chats', compact('messages', 'otherPersoneName', 'otherPersonImage', 'otherPersoneId', 'connectionId'))->render(),
                'connectionId' => $connectionId,
            ];

            return response()->json($response);
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
                $id = $connectionId;
                $formattedTime = $now->format('h:iA');
                $unreadMsg = DB::table('messages')->where('sender', $authUser->id)->where('reciever', $request->id)->where('status', 'unseen')->count();
                $unreadMsg = $unreadMsg > 9 ? '9+' : $unreadMsg;
                broadcast(new PusherBroadcast($message, $id, $formattedTime, $msgId))->toOthers();
                broadcast(new LeftBarBrodacast($request->id, $id, $message, $unreadMsg, $msgId))->toOthers();
            } catch (\Exception $err) {
                dd($err);
            }
            return response()->json(['status' => true, 'time' => Carbon::parse($now)->format('h:iA'), 'message' => $message, 'msgid' => $msgId]);
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

    public function newUsers(){
        $authUser = Auth::user();
        $newUsers = User::where('type', 'user')->where('status', 'active')->whereNot('id', $authUser->id)->orderBy('created_at', 'DESC')->limit(50)->select('name', 'username', 'email', 'profile_pic', 'id')->get();
        $response = "";
        foreach ($newUsers as $user) {
            if ($user->id == $authUser->id) {
                continue;
            }
            $profilePic = '';
            if ($user->profile_pic != '') {
                $profilePic = asset('user_profile_picture/thumb/' . $user->profile_pic);
            } else {
                $profilePic = asset('assets/images/dummy-imgs/default-profile-picture.jpg');
            }

            $response .= "
                <div class='col-6 col-lg-4 col-md-6 searched-user'>
                <div class='user-searched-wrpper'>
                    <div class='searched-user-img'>
                        <img src=\"$profilePic\" alt=\"$user->username\">
                    </div>
                </div>
                <p class='searched-names'>$user->name($user->username)</p>
                <p class='searched-desc'>$user->email</p>
                <button class='request-connection-btn' data-id=\"$user->id\" data-name=\"$user->name ($user->username)\">Request</button>
            </div>
            ";
        }
        $response == '' ? $response = '<p class="no-user-found">No User Found</p>' :  $response;

        return response()->json(['status' => true, 'message' => $response]);
    }

    public function searchUser($username = "")
    {
        try {
            $authUser = Auth::user();
            if($username == '---'){
                $users = User::where('status', 'active')->where('type', 'user')->select('id', 'name', 'username', 'profile_pic', 'email')->limit(50)->get();
            }else{
                $users = User::where('username', 'like', '%' . $username . '%')->orWhere('name', 'like', '%' . $username . '%')->where('status', 'active')->where('type', 'user')->select('id', 'name', 'username', 'profile_pic', 'email')->limit(50)->get();
            }
            $response = '';
            foreach ($users as $user) {
                if ($user->id == $authUser->id) {
                    continue;
                }
                $profilePic = '';
                if ($user->profile_pic != '') {
                    $profilePic = asset('user_profile_picture/thumb/' . $user->profile_pic);
                } else {
                    $profilePic = asset('assets/images/dummy-imgs/default-profile-picture.jpg');
                }

                $response .= "
                    <div class='col-6 col-lg-4 col-md-6 searched-user'>
                    <div class='user-searched-wrpper'>
                        <div class='searched-user-img'>
                            <img src=\"$profilePic\" alt=\"$user->username\">
                        </div>
                    </div>
                    <p class='searched-names'>$user->name($user->username)</p>
                    <p class='searched-desc'>$user->email</p>
                    <button class='request-connection-btn' data-id=\"$user->id\" data-name=\"$user->name ($user->username)\">Request</button>
                </div>
                ";
            }
            $response == '' ? $response = '<p class="no-user-found">No User Found</p>' :  $response;

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
            $reqSenderId = $authUser->id;
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
            $countReq = ConnectionModel::where(function ($query) use ($id) {
                $query->where('first_user', $id)
                    ->orWhere('second_user', $id);
            })
                ->where('status', 'requested')
                ->where('requested_by', '!=', $id)
                ->count();
            $connectionId = $connection->id;
            broadcast(new SendFriendRequest($id, $reqSenderId, $countReq, $connectionId))->toOthers();
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
            $authId = $authUser->id;

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
                        <div class="user-details-div col-9" id="user-details-' . $connection->id . '">
                            <p class="m-0 user-name">
                                ' . $userD->name . '
                            </p>
                            <p class="m-0 message-details" id="conv-' . $connection->id . '">
                                <span style="color:grey;">No Conversation Yet</span>
                            </p>
                            <span class="unread-msg-count" id="user-unread-' . $connection->id . '" >0</span>                       
                        </div>
                    </div>
                    <span class="separtor"></span>
                    ';
                    $countReq = ConnectionModel::where(function ($query) use ($authId) {
                        $query->where('first_user', $authId)
                            ->orWhere('second_user', $authId);
                    })
                        ->where('status', 'requested')
                        ->where('requested_by', '!=', $authId)
                        ->count();
                    broadcast(new AccesptFriendRequest($authId, $otherUser, $connection->id))->toOthers();
                    return response()->json(['status' => true, 'accept' => true, 'message' => "Connection request accepted succesfully", 'data' => ['htmlStructure' => $htmlStructureAdded, 'countreq' => $countReq]]);
                } else {
                    $connection->delete();
                    $countReq = ConnectionModel::where(function ($query) use ($authId) {
                        $query->where('first_user', $authId)
                            ->orWhere('second_user', $authId);
                    })
                        ->where('status', 'requested')
                        ->where('requested_by', '!=', $authId)
                        ->count();
                    return response()->json(['status' => true, 'accept' => false, 'message' => "Connection request rejected succesfully", 'data' => ['countreq' => $countReq]]);
                }
            } else {
                return response()->json(['status' => false, 'message' => "You don't have access to that connection"]);
            }
        } catch (\Exception $err) {
            // dd($err);
            return response()->json(['status' => false, 'message' => 'Something went wrong.']);
        }
    }

    public function seenMsg($id)
    {
        $msg = Message::find($id);
        if ($msg) {
            if ($msg->status == 'unseen') {
                $msg->status = 'seen';
                $msg->update();
                $connectionId = $this->connectionId($msg->sender, $msg->reciever);
                broadcast(new MessageSeenBroadcast($msg->sender, $msg->reciever, $connectionId))->toOthers();
                return 'seen';
            }
            return 'diff status';
        }
        return 'no msg';
    }

    public function typingStatusChange(Request $request)
    {
        try {
            $authUser = Auth::user();
            if ($request->id == '') {
                return response()->json(['status' => false, 'message' => 'Id is required']);
            }
            broadcast(new TypingStatus($request->id, $authUser->id))->toOthers();
            return response()->json(['status' => true, 'message' => 'status updated']);
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => 'something went wrong']);
        }
    }

    public function forwardMessage(Request $request)
    {
        try {
            $authUser = Auth::user();
            if ($request->messageId == '') {
                return response()->json(['status' => false, 'message' => 'message not found']);
            }

            $message = Message::where('id', $request->messageId)->where('status', '!=', 'deleted')->first();
            if (!$message) {
                return response()->json(['status' => false, 'message' => 'message not found']);
            }

            foreach ($request->checkedIds as $user) {
                $selectedUser = User::find($user);
                if (!$selectedUser) {
                    //user not exist
                    continue;
                }
                $connection = ConnectionModel::where(function ($query) use ($user, $authUser) {
                    $query->where('first_user', $user)
                        ->where('second_user', $authUser->id);
                })->orWhere(function ($query) use ($user, $authUser) {
                    $query->where('first_user', $authUser->id)
                        ->where('second_user', $user);
                })->where('status', 'connected')
                    ->first();

                if (!$connection) {
                    //connection not exist
                    continue;
                }

                $theMessage = new Message();
                $theMessage->message = $message->message;
                $theMessage->sender = $authUser->id;
                $theMessage->reciever = $user;
                $theMessage->status = 'unseen';
                $theMessage->forward = 'yes';
                $theMessage->time = Carbon::now();
                $theMessage->save();

                $connection->last_message = $theMessage->id;
                $connection->update();

                $formattedTime = Carbon::now()->format('h:iA');
                $unreadMsg = Message::where('sender', $authUser->id)->where('reciever', $user)->where('status', 'unseen')->count();
                $unreadMsg = $unreadMsg > 9 ? '9+' : $unreadMsg;
                broadcast(new PusherBroadcast($theMessage->message, $connection->id, $formattedTime, $theMessage->id, 'true'))->toOthers();
                broadcast(new LeftBarBrodacast($user, $connection->id, $theMessage->message, $unreadMsg, $theMessage->id))->toOthers();
            }

            return response()->json(['status' => true, 'message' => \Illuminate\Support\Str::limit(strip_tags($theMessage->message), 30)]);
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => 'something went wrong.']);
        }
    }
    public function test(){
        echo 'asdasd';
    }
}
