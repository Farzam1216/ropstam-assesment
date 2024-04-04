<?php

namespace App\Services\Car;

use App\Models\Car;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Services\Car\CarInterface;

class CarService implements CarInterface
{
    public function model()
    {
        return new Car();
    }

    public function store($request)
    {
        return  DB::transaction(function () use ($request) {

            $category = Category::find(htmlspecialchars($request['category_id']));
            if (isset($category)) {

                $data = [
                    'category_id' => htmlspecialchars($request['category_id']),
                    'name' => htmlspecialchars($request['name']),
                    'color' => htmlspecialchars($request['color']),
                    'model' => htmlspecialchars($request['model']),
                    'make' => htmlspecialchars($request['make']),
                    'registration_no' => htmlspecialchars($request['registration_no']),
                ];

                $this->model()->create($data);
            }
        });
    }

    public function update($id, $request)
    {
        return DB::transaction(function () use ($id, $request) {
            $category = Category::find(htmlspecialchars($request['category_id']));
            if (isset($category)) {
                $data = [
                    'category_id' => htmlspecialchars($request['category_id']),
                    'name' => htmlspecialchars($request['name']),
                    'color' => htmlspecialchars($request['color']),
                    'model' => htmlspecialchars($request['model']),
                    'make' => htmlspecialchars($request['make']),
                    'registration_no' => htmlspecialchars($request['registration_no']),
                ];
                $this->model()->find($id)->update($data);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Category not found',
                ], 500);
            }
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $this->model()->find($id)->delete();
        });
    }
}
