<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public static function postUser(Request $request) {
        $name = $request['name'];
        $surname = $request['surname'];
        $email = $request['email'];
        $password = $request['password'];

        $query = DB::table("Profiles")
            ->select(["*"])
            ->where("Profiles.Email", $email)
            ->get();

        $res = [];

        if (count($query) > 0) {
            $res[] = [
                "status" => false,
                "type" => 1,
                "message" => "Пользователь с таким Email уже зарегистрирован"
            ];

        } else {

            $newpassword = md5($password);

            $user = [];

            if($email == 'adminadmin@mail.com' && $newpassword == md5('adminadmin')){
                $user = [
                    "ID" => NULL,
                    "Email" => $email,
                    "Password" => $newpassword,
                    "Name" => $name,
                    "Surname" => $surname,
                    "Role" => 'admin',
                ];

                DB::table("Profiles")->insert([$user]);
            } else {
                $user = [
                    "ID" => NULL,
                    "Email" => $email,
                    "Password" => $newpassword,
                    "Name" => $name,
                    "Surname" => $surname,
                    "Role" => 'user',
                ];
                DB::table("Profiles")->insert([$user]);
            }

            $res[] = [
                "status" => true,
                "type" => 0,
                "message" => "Регистрация прошла успешно!"
            ];
        }

        return $res;
    }

    public static function getUser(Request $request) {
        $email = $request['email'];
        $password = $request['password'];

        $query = DB::table("Profiles")
            ->select(["*"])
            ->where("Profiles.Email", $email)
            ->where("Profiles.Password", md5($password))
            ->get();

        $res = [];

        if(count($query) > 0) {
            $res[] = [
                "status" => true,
                "type" => 0,
                "message" => "Вход успешен!",
                "user"=>$query
            ];

        } else {
            $_SESSION['user'] = [
                "id" => $query->ID,
                "name" => $query->Name,
                "surname" => $query->Surname,
                "email" => $query->Email,
                "password" => $query->Password,
            ];

            $res[] = [
                "status" => false,
                "type" => 1,
                "message" => "Пользователя с таким Email не существует или неправильный пароль",
            ];
        }

        return $res;
    }

    public static function getUserInfo(Request $request) {
        $id = $request['id'];

        $query = DB::table("Profiles")
            ->select(["*"])
            ->where("Profiles.ID", $id)
            ->get();

        if (count($query) > 0) {
            $res[] = [
                "status" => false,
                "type" => 1,
                "message" => "200 ok",
                "userInfo"=>$query
            ];
        } else {
            $res[] = [
                "status" => false,
                "type" => 1,
                "message" => "Пользователя с таким ID не существует"
            ];
        }

        return $res;
    }

    public static function getAllProducts() {
        $query = DB::table("Products")
            ->selectRaw("Products.ID, Products.Name, Products.Price, Products.Count, Products.Composition, Products.Main_Photo,
        Products.Secondary_Photo_first, Products.Secondary_Photo_second, Type.Name as 'Type', Categories.Name as 'Category',
        Sizes.Size, Sexs.Sex as 'Sex'")
            ->join("Type", "Products.Type_ID", "=", "Type.ID")
            ->join("Categories", "Type.Category_ID", "=","Categories.ID")
            ->join("Sizes", "Products.Size_ID", "=","Sizes.ID")
            ->join("Sexs", "Products.Sex_ID", "=","Sexs.ID")
            ->get();

        return self::outputElements($query);
    }

    public static function getCategory() {
        $query = DB::table("Categories")
            ->select(["Categories.Name"])
            ->get();

        return self::outputElements($query);
    }
    public static function getSex(Request $request) {
        $query = DB::table("Sexs")
            ->select(["Sexs.Sex"])
            ->get();

        return self::outputElements($query);
    }
    public static function getSize(Request $request) {
        $query = DB::table("Sizes")
            ->select(["Sizes.Size"])
            ->get();

        return self::outputElements($query);
    }
    public static function getType(Request $request) {
        $categoryName = $request['categoryname'];

        $query = DB::table("Type")
            ->select("Type.Name")
            ->join("Categories", "Type.Category_ID", "Categories.ID")
            ->where("Categories.Name", $categoryName)
            ->get();

        return self::outputElements($query);
    }

    public static function addProduct(Request $request) {
        $item_name = $request['item_name'];
        $item_size = $request['item_size'];
        $item_sex = $request['item_sex'];
        $item_category = $request['item_category'];
        $item_type = $request['item_type'];
        $item_price = $request['item_price'];
        $newPrice = (int)$item_price;
        $item_count = $request['item_count'];
        $newCount = (int)$item_count;
        $item_composition = $request['item_composition'];
        $item_mainPhoto = $request['item_mainPhoto'];
        $item_fsPhoto = $request['item_fsPhoto'];
        $item_ssPhoto = $request['item_ssPhoto'];

        $selectSize = DB::table("Sizes")
            ->select(["Sizes.ID"])
            ->where("Sizes.Size", $item_size)
            ->first();

        $newRowSize = (int)$selectSize->ID;

        $selectType = DB::table("Type")
            ->select("Type.ID")
            ->join("Categories", "Type.Category_ID", "Categories.ID")
            ->where("Type.Name", $item_type)
            ->where("Categories.Name", $item_category)
            ->first();

        $newRowType = (int)$selectType->ID;

        $selectSex = DB::table("Sexs")
            ->select(["Sexs.ID"])
            ->where("Sexs.Sex", $item_sex)
            ->first();

        $newRowSex = (int)$selectSex->ID;

        $select = DB::table("Products")
            ->selectRaw("Products.Name, Products.Size_ID")
            ->where("Products.Name", $item_name)
            ->where("Products.Size_ID", $newRowSize)
            ->get();

        $res = [];

        if(count($select) == 0 ) {
            $newProduct = [
                "ID" => NULL,
                "Name" => $item_name,
                "Size_ID" => $newRowSize,
                "Sex_ID" => $newRowSex,
                "Type_ID" => $newRowType,
                "Price" => $newPrice,
                "Count" => $newCount,
                "Composition" => $item_composition,
            ];

            if($item_mainPhoto != ''){
                $item_mainPhoto = str_replace('https://drive.google.com/file/d/', 'https://drive.google.com/uc?export=view&id=', $item_mainPhoto);
                $item_mainPhoto = str_replace('/view?usp=share_link', '', $item_mainPhoto);
                $newProduct['Main_Photo'] = $item_mainPhoto;
            }

            if($item_fsPhoto != ''){
                $item_fsPhoto = str_replace('https://drive.google.com/file/d/', 'https://drive.google.com/uc?export=view&id=', $item_fsPhoto);
                $item_fsPhoto = str_replace('/view?usp=share_link', '', $item_fsPhoto);
                $newProduct['Secondary_Photo_first'] = $item_fsPhoto;
                //$newProduct->Secondary_Photo_first = self::correctPhotoLink($item_fsPhoto);
            }

            if($item_ssPhoto != ''){
                $item_ssPhoto = str_replace('https://drive.google.com/file/d/', 'https://drive.google.com/uc?export=view&id=', $item_ssPhoto);
                $item_ssPhoto = str_replace('/view?usp=share_link', '', $item_ssPhoto);
                $newProduct['Secondary_Photo_second'] = $item_ssPhoto;
            }

            DB::table("Products")->insert([$newProduct]);

            $res[] = [
                "status" => true,
                "type" => 0,
                "message" => "200 ok",
            ];

        } else {
            $res[] = [
                "status" => false,
                "type" => 1,
                "message" => "Произошла ошибка",
            ];
        }

        return $res;
    }
    public static function editProduct(Request $request) {
        $id = $request['itemId'];
        $intID = (int)$id;
        $name = $request['name'];
        $size = $request['size'];
        $sex = $request['sex'];
        $category = $request['category'];
        $type = $request['type'];
        $price = $request['price'];
        $newPrice = (int)$price;
        $count = $request['count'];
        $newCount = (int)$count;
        $composition = $request['composition'];
        $main_photo = $request['main_photo'];
        $first_sec_photo = $request['first_sec_photo'];
        $second_sec_photo = $request['second_sec_photo'];

        $res = [];

        $selectSize = DB::table("Sizes")
            ->select(["Sizes.ID"])
            ->where("Sizes.Size", $size)
            ->first();

        if(empty($selectSize)) {
            $res[] = [
                "status" => false,
                "type" => 1,
                "message" => "Произошла ошибка"
            ];

            return $res;

        } else {
            $newRowSize = (int)$selectSize->ID;
        }

        $selectType = DB::table("Type")
            ->select("Type.ID")
            ->join("Categories", "Type.Category_ID", "Categories.ID")
            ->where("Type.Name", $type)
            ->where("Categories.Name", $category)
            ->first();

        if(empty($selectType)) {
            $res[] = [
                "status" => false,
                "type" => 1,
                "message" => "Произошла ошибка"
            ];

            return $res;

        } else {
            $newRowType = (int)$selectType->ID;
        }

        $selectSex = DB::table("Sexs")
            ->select(["Sexs.ID"])
            ->where("Sexs.Sex", $sex)
            ->first();

        if(empty($selectSex)) {
            $res[] = [
                "status" => false,
                "type" => 1,
                "message" => "Произошла ошибка"
            ];

            return $res;

        } else {
            $newRowSex = (int)$selectSex->ID;
        }

        $editProduct = [];

        if($name != ''){
            $editProduct['Products.Name'] = $name;
        }

        if($size != ''){
            $editProduct['Products.Size_ID'] = $newRowSize;
        }

        if($sex != ''){
            $editProduct['Products.Sex_ID'] = $newRowSex;
        }

        if($type != ''){
            $editProduct['Products.Type_ID'] = $newRowType;
        }

        if($price != ''){
            $editProduct['Products.Price'] = $newPrice;
        }

        if($count != ''){
            $editProduct['Products.Count'] = $newCount;
        }

        if($composition != ''){
            $editProduct['Products.Composition'] = $composition;
        }

        if($main_photo != ''){
            $main_photo = str_replace('https://drive.google.com/file/d/', 'https://drive.google.com/uc?export=view&id=', $main_photo);
            $main_photo = str_replace('/view?usp=share_link', '', $main_photo);
            $editProduct['Products.Main_Photo'] = $main_photo;
        }

        if($first_sec_photo != ''){
            $first_sec_photo = str_replace('https://drive.google.com/file/d/', 'https://drive.google.com/uc?export=view&id=', $first_sec_photo);
            $first_sec_photo = str_replace('/view?usp=share_link', '', $first_sec_photo);
            $editProduct['Products.Secondary_Photo_first'] = $first_sec_photo;
        }

        if($second_sec_photo != ''){
            $second_sec_photo = str_replace('https://drive.google.com/file/d/', 'https://drive.google.com/uc?export=view&id=', $second_sec_photo);
            $second_sec_photo = str_replace('/view?usp=share_link', '', $second_sec_photo);
            $editProduct['Products.Secondary_Photo_second'] = $second_sec_photo;
        }
//        $implode_arr = implode(", ", $editProduct);

        $query = DB::table("Products")
            ->where("Products.ID", $intID)
            ->update($editProduct);

        if($query) {
            $res[] = [
                "status" => true,
                "type" => 0,
                "message" => "200 ok"
            ];
        } else {
            $res[] = [
                "status" => false,
                "type" => 1,
                "message" => "Произошла ошибка"
            ];
        }

        return $res;
    }
    public static function deleteProduct(Request $request) {
        $itemId = $request['id'];

        $delete = DB::table("Products")
            ->where("Products.ID", $itemId)
            ->delete();

        return $delete;
    }
    public static function addCategory(Request $request) {
        $categoryname = $request['categoryName'];

        $select = DB::table("Categories")
            ->select("Categories.Name")
            ->where("Categories.Name", $categoryname)
            ->get();

        $res = [];

        if(!count($select) > 0) {
            $insert = DB::table("Categories")->insert(["ID" => NULL, "Name" => $categoryname]);

            if($insert) {
                $res = [
                    "status" => true,
                    "type" => 0,
                    "message" => "200 ok"
                ];
            } else {
                $res = [
                    "status" => false,
                    "type" => 1,
                    "message" => "Произошла ошибка",
                ];
            }
        } else {
            $res = [
                "status" => false,
                "type" => 1,
                "message" => "Произошла ошибка",
            ];
        }

        return $res;

    }
    public static function deleteCategory(Request $request) {
        $categoryName = $request['categoryName'];

        $select = DB::table("Categories")
            ->select("Categories.Name")
            ->where("Categories.Name", $categoryName)
            ->get();

        $res = [];

        if(!count($select) > 0) {
            $res = [
                "status" => false,
                "type" => 1,
                "message" => "Произошла ошибка",
            ];
        } else {
            $delete = DB::table("Categories")
                ->where("Categories.Name", $categoryName)
                ->delete();

            if($delete) {
                $res = [
                    "status" => true,
                    "type" => 0,
                    "message" => "200 ok",
                ];

            } else {
                $res = [
                    "status" => false,
                    "type" => 1,
                    "message" => "Произошла ошибка",
                ];
            }
        }

        return $res;
    }
    public static function addType(Request $request) {
        $categoryname = $request['categoryName'];
        $type = $request['type'];

        $select = DB::table("Type")
            ->select("Type.Name")
            ->join("Categories", "Type.Category_ID", "=", "Categories.ID")
            ->where("Categories.Name", $categoryname)
            ->where("Type.Name", $type)
            ->get();

        $res = [];

        if(!count($select) > 0) {
            $checkCategoryID = DB::table("Categories")
                ->select("Categories.ID")
                ->where("Categories.Name", $categoryname)
                ->first();

            $insert = DB::table("Type")->insert(["ID" => NULL, "Category_ID" => $checkCategoryID->ID, "Name" => $type]);

            if($insert) {
                $res = [
                    "status" => true,
                    "type" => 0,
                    "message" => "Тип добавлен"
                ];
            } else {
                $res = [
                    "status" => false,
                    "type" => 1,
                    "message" => "Произошла ошибка",
                ];
            }
        } else {
            $res = [
                "status" => false,
                "type" => 1,
                "message" => "Такой тип уже существует",
            ];
        }

        return $res;
    }
    public static function deleteType(Request $request) {
        $categoryname = $request['categoryName'];
        $type = $request['type'];

        $select = DB::table("Type")
            ->select("Type.Name")
            ->join("Categories", "Type.Category_ID", "=", "Categories.ID")
            ->where("Categories.Name", $categoryname)
            ->where("Type.Name", $type)
            ->get();

        $res = [];

        if(count($select) > 0) {
            $checkCategoryID = DB::table("Categories")
                ->select("Categories.ID")
                ->where("Categories.Name", $categoryname)
                ->first();

            $delete = DB::table("Type")
                ->where("Type.Name", $type)
                ->where("Type.Category_ID", $checkCategoryID->ID)
                ->delete();

            if($delete) {
                $res = [
                    "status" => true,
                    "type" => 0,
                    "message" => "Тип удален"
                ];
            } else {
                $res = [
                    "status" => false,
                    "type" => 1,
                    "message" => "Произошла ошибка",
                ];
            }
        } else {
            $res = [
                "status" => false,
                "type" => 1,
                "message" => "Такого типа не существует",
            ];
        }

        return $res;
    }

    public static function outputElements(\Illuminate\Support\Collection $query): array
    {
        $arr_elements = [];

        for ($i = 0; $i < count($query); ++$i) {
            $arr_elements[] = $query[$i];
        }

        $res = [];

        if (!count($arr_elements) > 0) {
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
                "item" => $arr_elements,
            ];
        }

        return $res;
    }
    public static function correctPhotoLink(\Illuminate\Support\Collection $photo): array
    {
        $photo = str_replace('https://drive.google.com/file/d/', 'https://drive.google.com/uc?export=view&id=', $photo);
        $photo = str_replace('/view?usp=share_link', '', $photo);

        return $photo;
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
