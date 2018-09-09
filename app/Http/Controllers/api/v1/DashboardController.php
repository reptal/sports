<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Models\Team;

class DashboardController extends Controller
{

    //
    public function index()
    {
        $user = \Auth::user();
        //get team and players count
        $teams = Team::where('user_id', $user->id)
          ->count();
        $players = Player::whereHas(
          'team', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        });
        $players = $players->count();
        $data = [
          'error'   => false,
          'message' => '',
          'data'    => [
            'teams'   => $teams,
            'players' => $players,
          ],
        ];
        //send response
        return response()->json($data, 200);
    }
}
