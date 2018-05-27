<?php

namespace App\Http\Controllers;

use App\Models\CashOut;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class PlayerController extends Controller
{
    public function getAll()
    {
        $users = DB::select('select * from tbl_player');
        return $users;
    }
    public function getCashOutByPlayerId($playerId){
        try{
            $player_join_cash_out = DB::table('tbl_player')
                ->join('tbl_cashout', 'tbl_player.Id', '=', 'tbl_cashout.PlayerId')
                ->join('tbl_actiontype', 'tbl_cashout.ActionTypeId', '=', 'tbl_actiontype.Id')
                ->select('tbl_player.Id', 'tbl_player.Name',
                    'tbl_cashout.InCoin','tbl_cashout.OutCoin','tbl_actiontype.Name',
                    'tbl_actiontype.ActionTypeLevel','tbl_actiontype.Code','tbl_actiontype.Unit',
                    'tbl_actiontype.IsFirstChirld')
                ->where('tbl_player.Id', '=', $playerId)
                ->get();
            return $player_join_cash_out;
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    //PlayerId
    public function modalGetCashOutPostId(Request $rq){
        $playerId = $rq->input('PlayerId');
        try{
            $player_join_cash_out = DB::table('tbl_player')
                ->join('tbl_cashout', 'tbl_player.Id', '=', 'tbl_cashout.PlayerId')
                ->join('tbl_actiontype', 'tbl_cashout.ActionTypeId', '=', 'tbl_actiontype.Id')
                ->select('tbl_player.Id',
                    'tbl_cashout.InCoin','tbl_cashout.OutCoin','tbl_actiontype.Name',
                    'tbl_actiontype.ActionTypeLevel','tbl_actiontype.Code','tbl_actiontype.Unit',
                    'tbl_actiontype.IsFirstChirld')
                ->where('tbl_player.Id', '=', $playerId)
                ->get();

            return [
                'success' => true,
                'data'   => $player_join_cash_out
            ];
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function createCashOut(Request $rq){
        $cashOut = new CashOut();
        $cashOut->setActionTypeId($rq->input('ActionTypeId'));
        $cashOut->setPlayerId($rq->input('PlayerId'));
        $cashOut->setInCoin($rq->input('InCoin'));
        $cashOut->setOutCoin($rq->input('OutCoin'));
        try{
            $result = DB::table('tbl_cashout')->insert($cashOut->jsonSerialize());
            return ['success' => $result];
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
    public function createPlayer(Request $rq){
        $player = new Player();
        $player->setName($rq->input("Name"));
        $player->setPhoneNumber($rq->input("PhoneNumber"));
        $player->setPlayerTypeId($rq->input("PlayerTypeId"));
        $player->setIsDelete($rq->input("isDelete"));
        $player->setDescription($rq->input("Description"));
        try{
            $result = DB::table('tbl_player')->insert($player->jsonSerialize());
            return ['success' => $result];
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
}
