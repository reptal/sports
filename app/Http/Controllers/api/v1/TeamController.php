<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;

class TeamController extends Controller
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
        //create query
        $teams = Team::withCount('players')
          ->where('user_id', $user->id)
          ->orderBy($orderColumn, $orderType);
        if ($paginate == 0) {
            //unlimited data
            $teams = $teams->get();
            $data = [
              'error'   => false,
              'message' => '',
              'data'    => [
                'teams'    => $teams,
                'pagination' => [],
              ],
            ];
        } else {
            //limited data with pagination
            $teams = $teams->paginate($paginate);
            $data = [
              'error'   => false,
              'message' => '',
              'data'    => [
                'teams'    => $teams->getCollection(),
                'pagination' => [
                  'total'        => $teams->total(),
                  'per_page'     => $teams->perPage(),
                  'current_page' => $teams->currentPage(),
                  'last_page'    => $teams->lastPage(),
                  'from'         => $teams->firstItem(),
                  'to'           => $teams->lastItem(),
                ],
              ],
            ];
        }
        //send response
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
    public function store(CreateTeamRequest $request)
    {
        //get user
        $user = \Auth::user();
        //create data
        $team = New Team();
        $team->name = $request->validated()['name'];
        $team->slug = $request->validated()['slug'];
        //save new team
        $user->teams()->save($team);
        $data = [
          'error'   => false,
          'message' => __('translate.team added'),
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
    public function show(Team $team)
    {
        //we have the team
        $data = [
          'error'   => false,
          'message' => '',
          'data'    => [
            'team' => $team,
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
    public function update(UpdateTeamRequest $request, Team $team)
    {
        //make data
        $team->name = $request->validated()['name'];
        $team->slug = $request->validated()['slug'];
        //update team
        $team->update();
        //send response
        $data = [
          'error'   => false,
          'message' => __('translate.team updated'),
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

    /**
     * @param \App\Models\Team $team
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPlayers(Team $team)
    {
        //load players relation
        $team = $team->load('players');
        $data = [
          'error'   => false,
          'message' => '',
          'data'    => [
            'team' => $team,
          ],
        ];
        return response()->json($data, 200);
    }
}
