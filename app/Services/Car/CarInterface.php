<?php

namespace App\Services\Car;

interface CarInterface
{
    public function model();

    public function store($inputs);

    public function update($id, $request);

    public function destroy($id);

}
