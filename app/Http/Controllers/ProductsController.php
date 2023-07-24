<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public static function getItem(Request $request) {
        $category = $request['category'];
        $type = $request['type'];
        $sortingValue = $request['sortingValue'];
        $filtresValue = json_decode($request['filtresValue']);
        $searchText = $request['searchText'];

        $query = DB::table("Products")
            ->selectRaw("Products.ID, Products.Name, Products.Price, Products.Count, Products.Composition, Products.Main_Photo,
        Products.Secondary_Photo_first, Products.Secondary_Photo_second, Type.Name as 'Type', Categories.Name as 'Category',
        Sizes.Size, Sexs.Sex as 'Sex'")
            ->join("Type", "Products.Type_ID", "=", "Type.ID")
            ->join("Categories", "Type.Category_ID", "=", "Categories.ID")
            ->join("Sizes", "Products.Size_ID", "=", "Sizes.ID")
            ->join("Sexs", "Products.Sex_ID", "=", "Sexs.ID")
            ->where("Categories.Name", $category);

        if($type != '') {
            $query = $query ->where("Type.Name", $type);
        }

        if($searchText != '') {
            $query = $query ->where("Products.Name", "LIKE", "%$searchText%");
        } else {
            $query = $query ->where("Products.Name", "LIKE", "%%");
        }

        if ($filtresValue !== "" && count($filtresValue) > 0) {
            $query = $query->whereIn("Sizes.Size", $filtresValue);
        }

        switch ($sortingValue) {
            case 'asc':
                $query = $query ->orderBy("Products.Price", "ASC");
                break;
            case 'desc':
                $query = $query ->orderBy("Products.Price", "DESC");
                break;
        }

        $query = $query ->get();

        $arr_item = [];

        for ($i = 0 ; $i < count($query) ; ++$i) {
            if($query[$i]->Main_Photo) {
                $query[$i]->Main_Photo = str_replace('https://drive.google.com/file/d/', 'https://drive.google.com/uc?export=view&id=', $query[$i]->Main_Photo);
                $query[$i]->Main_Photo = str_replace('/view?usp=drive_link', '', $query[$i]->Main_Photo);
            }
            $arr_item[] = $query[$i];
        }

        $res = [];

        if (!count($arr_item) > 0) {
            $res = [
                "status" => false,
                "type" => 1,
                "message" => "Произошла ошибка"
            ];
        } else {
            $res = [
                "status" => true,
                "type" => 0,
                "message" => "200 ok",
                "item"=> $arr_item
            ];
        }

        return $res;
    }

    public static function getSize() {
        $query = DB::table("Sizes")
            ->select("Sizes.Size")
            ->get();

        $res = [];

        if(count($query) > 0) {
            $res = [
                "status" => true,
                "type" => 0,
                "message" => "200 ok",
                "size"=> $query
            ];
        } else {
            $res = [
                "status" => false,
                "type" => 1,
                "message" => "Произошла ошибка"
            ];
        }

        return $res;
    }

    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
