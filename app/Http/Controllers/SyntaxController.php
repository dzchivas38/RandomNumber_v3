<?php

namespace App\Http\Controllers;

use App\Models\Syntax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;


class SyntaxController extends Controller
{
    public function getAll()
    {
        try {
            $results = DB::table('tbl_syntax')->get();
            return $results;
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function createSyntax(Request $rq){
        $syntax = new Syntax();
        $syntax->setName($rq->input("Name"));
        $syntax->setActionTypeId($rq->input("ActionTypeId"));
        $syntax->setDescription($rq->input("Description"));
        $syntax->setSyntaxForm($rq->input("SyntaxForm"));
        try{
            $result = DB::table('tbl_syntax')->insert($syntax->jsonSerialize());
            return ['success' => $result];
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
}
