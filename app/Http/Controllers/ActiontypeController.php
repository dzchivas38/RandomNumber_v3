<?php

namespace App\Http\Controllers;

use App\Models\ActionType;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class ActiontypeController extends Controller
{
    public function getAll()
    {
        try{
            $data = DB::select('select * from tbl_actiontype');
            return $data;
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function createActionType(Request $rq){
        $actionType = new ActionType();
        $actionType->setName($rq->input("Name"));
        $actionType->setActionTypeLevel($rq->input("ActionTypeLevel"));
        $actionType->setIsFirstChirld($rq->input("IsFirstChirld"));
        $actionType->setDescription($rq->input("Description"));
        $actionType->setCode($rq->input("Code"));
        $actionType->setUnit($rq->input("Unit"));
        try{
            $result = DB::table('tbl_actiontype')->insert($actionType->jsonSerialize());
            return ['success' => $result];
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
    public function deleteItem(Request $rq){
        $Id = $rq->input("Id");
        try{
            $result = DB::table('tbl_actiontype')->where('Id', '=', $Id)->delete();
            return ['success' => $result];
        }catch (\ErrorException $e){
            return $e->getMessage();
        }
    }
    public function updateItem(Request $rq){
        $Id = $rq->input("Id");
        $actionType = new ActionType();
        $actionType->setId($rq->input("Id"));
        $actionType->setName($rq->input("Name"));
        $actionType->setActionTypeLevel($rq->input("ActionTypeLevel"));
        $actionType->setIsFirstChirld($rq->input("IsFirstChirld"));
        $actionType->setDescription($rq->input("Description"));
        $actionType->setCode($rq->input("Code"));
        $actionType->setUnit($rq->input("Unit"));
        try{
            $result = DB::table('tbl_actiontype')
                ->where('id', $Id)
                ->update($actionType->jsonSerialize());
            return ['success' => $result];
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
}
