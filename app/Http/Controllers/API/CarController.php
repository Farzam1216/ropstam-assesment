<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarStoreRequest;
use App\Models\Car;
use App\Services\Car\CarInterface;
use Illuminate\Http\Request;

class CarController extends Controller
{
    private $carInterface;

    public function __construct(CarInterface $carInterface)
    {
        $this->carInterface = $carInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Car::with('category')->get();

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarStoreRequest $request)
    {
        //

        try {
            //code...
          $car=  $this->carInterface->store($request);
            return response()->json([
                'message' => 'Car created successfully',
                'success' => true,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarStoreRequest $request, $id)
    {
        //
        try {
            //code...
            $this->carInterface->update($id,$request);
            return response()->json([
                'message' => 'Car updated successfully',
                'success' => true,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        try {
            //code...
            $this->carInterface->destroy($id);
            return response()->json([
                'message' => 'Car deleted successfully',
                'success' => true,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
