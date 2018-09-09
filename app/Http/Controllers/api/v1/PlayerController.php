<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        isset($_GET['limit']) ? $paginate = $_GET['limit']
          : $paginate = config('settings.paginate');

        //set user and order columns
        $orderColumn = 'id';
        $orderType = 'desc';
        $user = \Auth::user();
        //create query to get only players that is  in current user team
        $players = Player::whereHas(
          'team', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }
        );
        $players->with('team')
          ->orderBy($orderColumn, $orderType);

        if ($paginate == 0) {
            //unlimited data
            $players = $players->get();
            $data = [
              'error'   => false,
              'message' => '',
              'data'    => [
                'players'    => $players,
                'pagination' => [],
              ],
            ];
        } else {
            //limited data with pagination
            $players = $players->paginate($paginate);
            $data = [
              'error'   => false,
              'message' => '',
              'data'    => [
                'players'    => $players->getCollection(),
                'pagination' => [
                  'total'        => $players->total(),
                  'per_page'     => $players->perPage(),
                  'current_page' => $players->currentPage(),
                  'last_page'    => $players->lastPage(),
                  'from'         => $players->firstItem(),
                  'to'           => $players->lastItem(),
                ],
              ],
            ];
        }

        //send response with pagination and players data

        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePlayerRequest $request)
    {
        //create data
        $player = New Player();
        $player->first_name = $request->validated()['first_name'];
        $player->last_name = $request->validated()['last_name'];
        $player->team_id = $request->validated()['team'];
        //save new team
        $player->save();
        $data = [
          'error'   => false,
          'message' => __('translate.player added'),
          'data'    => [],
        ];
        //send response
        return response()->json($data, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        //we have the team
        $data = [
          'error'   => false,
          'message' => '',
          'data'    => [
            'player' => $player,
          ],
        ];
        //send response
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlayerRequest $request, Player $player)
    {
        //make data
        $player->first_name = $request->validated()['first_name'];
        $player->last_name = $request->validated()['last_name'];
        $player->team_id = $request->validated()['team'];
        //update player
        $player->update();
        //send response
        $data = [
          'error'   => false,
          'message' => __('translate.player updated'),
          'data'    => [],
        ];
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
