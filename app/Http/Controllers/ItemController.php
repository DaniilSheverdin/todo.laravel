<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use App\Repositories\Items;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    protected $itemsRepository;

    public function __construct()
    {
        $this->itemsRepository = new Items();
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tasksFetch =
            $this
                ->itemsRepository
                ->all();

        if ($tasksFetch->hasError()) {
            return response()->json($tasksFetch->getMessage(), 500);
        }

        return response()->json($tasksFetch->getItems());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $itemsStore =
            $this
                ->itemsRepository
                ->store($request);

        if ($itemsStore->hasError()) {
            return response()->json($itemsStore->getMessage(), 500);
        }

        return response()->json($itemsStore->getItems(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $tasksFetch =
            $this
                ->itemsRepository
                ->show($id);

        if ($tasksFetch->hasError()) {
            return response()->json($tasksFetch->getMessage(), 500);
        }

        return response()->json($tasksFetch->getItems());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit(Request $request, int $id): JsonResponse
    {
        $itemsFetch =
            $this
                ->itemsRepository
                ->edit($request, $id);

        if ($itemsFetch->hasError()) {
            return response()->json($itemsFetch->getMessage(), 500);
        }

        return response()->json($itemsFetch->getItems());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $itemsFetch =
            $this
                ->itemsRepository
                ->update($request, $id);

        if ($itemsFetch->hasError()) {
            return response()->json($itemsFetch->getMessage(), 500);
        }

        return response()->json($itemsFetch->getItems());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $itemsFetch =
            $this
                ->itemsRepository
                ->delete($id);

        if ($itemsFetch->hasError()) {
            return response()->json($itemsFetch->getMessage(), 500);
        }

        return response()->json($itemsFetch->getMessage());
    }
}
