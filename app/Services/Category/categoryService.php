<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Services\Category\categoryInterface as CategoryCategoryInterface;
use Illuminate\Support\Facades\DB;

class categoryService implements CategoryCategoryInterface
{
    public function model()
    {
        return new Category();
    }

    public function store($request)
    {
        return DB::transaction(function () use ($request) {

            $data = [
                'name' => htmlspecialchars($request['name']),
            ];

            $this->model()->create($data);
        });
    }

    public function update($id, $request)
    {
        return DB::transaction(function () use ($id, $request) {

            $data = [
                'name' => htmlspecialchars($request['name']),
            ];

            $this->model()->find($id)->update($data);
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $this->model()->find($id)->delete();
        });
    }
}
