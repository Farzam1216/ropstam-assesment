<?php

namespace App\Services\Category;

interface categoryInterface
{
    public function model();

    public function store($inputs);

    public function update($id, $request);

    public function destroy($id);


}
