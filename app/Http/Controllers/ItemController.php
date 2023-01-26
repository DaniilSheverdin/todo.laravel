<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Item::orderBy('created_at', 'DESC')->get();
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
     * @return Item
     */
    public function store(Request $request): Item
    {
        $obNewItem = new Item();

        $obNewItem->title = $request->item['title'];
        $obNewItem->user_id = $request->item['user_id'];
        $obNewItem->description = $request->item['description'] ?? '';
        $obNewItem->save();

        return $obNewItem;
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
    public function edit(Request $request, $id)
    {
        $obItem = Item::find($id);

        if($obItem){
            if (isset($request->item['description']))
                $obItem->description = $request->item['description'];
            if (isset($request->item['title']))
                $obItem->title = $request->item['title'];
            $obItem->updated_at = Carbon::now();

            $obItem->save();
            return $obItem;
        }

        return "not found";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return
     */
    public function update(Request $request, $id)
    {
        $obItem = Item::find($id);

        if($obItem){
            $obItem->completed = (bool)$request->item['completed'];
            $obItem->updated_at = Carbon::now();
            $obItem->completed_at = $request->item['completed'] ? Carbon::now() : null;

            $obItem->save();
            return $obItem;
        }

        return "not found";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $obItem = Item::find($id);

        if($obItem){
            $obItem->delete();
            return "Successfully deleted.";
        }
        return "not found";
    }
}
