<?php namespace BFACP\Http\Controllers\Api;

use BFACP\Repositories\PlayerRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use MainHelper;

class PlayersController extends BaseController
{
    private $repository;

    public function __construct(PlayerRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    public function index()
    {
        $limit = $this->request->get('limit', FALSE);

        $name = $this->request->get('player', NULL);

        $players = $this->repository->getAllPlayers($limit, $name);

        return MainHelper::response($players, NULL, NULL, NULL, FALSE, TRUE);
    }

    /**
     * Get a player by their player database id
     * @param  integer $id
     */
    public function show($id)
    {
        $player = $this->repository->setopts([
                    'ban.previous',
                    'reputation',
                    'infractionsGlobal',
                    'infractionsServer.server',
                    'stats.server',
                    'sessions.server'
                ], true)->getPlayerById($id);

        return MainHelper::response($player, NULL, NULL, NULL, FALSE, TRUE);
    }
}
