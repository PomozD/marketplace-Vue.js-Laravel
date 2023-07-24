<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public static function getCategory() {
        $query = DB::table("Categories")
            ->select(["Categories.Name"])
            ->get();

        $res = [];

        foreach ($query as $category){
            $res[] = [
                "category" => $category->Name,
                "types"=>self::getTypes($category->Name)
            ];
        }

        return $res;

    }

    public static function getTypes($category) {
        $query = DB::table("Categories")
            ->select(["Type.Name"])
            ->leftJoin("Type", "Categories.ID", "=", "Type.Category_ID")
            ->where("Categories.Name", $category)
            ->get();

        return $query;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
