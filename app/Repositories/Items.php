<?php

namespace App\Repositories;

use App\Models\Item;
use App\Http\Resources\Item as ItemResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\throwException;

class Items extends Repository
{
    public function all(): Repository
    {
        try {
            $tasks = Item::orderBy('created_at', 'DESC')->get();
        } catch (\Exception $e) {
            Log::error(
                'Something went wrong while getting the tasks from the database',
                [
                    'message' => $e->getMessage()
                ]
            );
            $message = $e->getMessage();
            $error = true;
        }

        return (new Repository())
            ->setItems($tasks ?? [])
            ->setError($error ?? false)
            ->setMessage($message??"");
    }

    public function edit($data, $id){
        try {
            $obItem = Item::find($id);
            if(!$obItem)
                throw new \Exception("element not found");
            if (isset($data->item['description']))
                $obItem->description = $data->item['description'];
            if (isset($data->item['title']))
                $obItem->title = $data->item['title'];
            $obItem->updated_at = Carbon::now();

            $obItem->save();
            $obItemResource = new ItemResource($obItem);
        } catch (\Exception $e) {
            Log::error(
                'Something went wrong while storing the task into the database',
                [
                    'message' => $e->getMessage()
                ]
            );
            $message = $e->getMessage();
            $error = true;
        }

        return (new Repository())
            ->setItems($obItemResource ?? [])
            ->setError($error ?? false)
            ->setMessage($message??"");
    }

    public function store($data): Repository
    {
        try {
            $obNewItem = new Item();
            $obNewItem->title = $data->item['title'];
            $obNewItem->user_id = $data->item['user_id'];
            $obNewItem->description = $data->item['description'] ?? '';
            $obNewItem->save();

            $singleItem = new ItemResource($obNewItem);
        } catch (\Exception $e) {
            Log::error(
                'Something went wrong while storing the task into the database',
                [
                    'message' => $e->getMessage()
                ]
            );
            $message = $e->getMessage();
            $error = true;
        }

        return (new Repository())
            ->setItems($singleItem ?? [])
            ->setError($error ?? false)
            ->setMessage($message??"");
    }

    public function show($id): Repository
    {
        try {
            $obItem = Item::find($id);
            if (!$obItem){
                throw new \Exception("Element not found");
            }
            $obItemResource = new ItemResource($obItem);
        } catch (\Exception $e) {
            Log::error(
                'Something went wrong while getting the task into the database',
                [
                    'message' => $e->getMessage()
                ]
            );
            $message = $e->getMessage();
            $error = true;
        }

        return (new Repository())
            ->setItems($obItemResource ?? [])
            ->setError($error ?? false)
            ->setMessage($message??"");
    }

    public function update($id, $data): Repository
    {
        try {
            $obItem = Item::find($id);
            $obItem->completed = (bool)$data->item['completed'];
            $obItem->updated_at = Carbon::now();
            $obItem->completed_at = $data->item['completed'] ? Carbon::now() : null;

            $obItem->save();
            $obItemResource = new ItemResource($obItem);
        } catch (\Exception $e) {
            Log::error(
                'Something went wrong while storing the task into the database',
                [
                    'message' => $e->getMessage()
                ]
            );
            $message = $e->getMessage();
            $error = true;
        }

        return (new Repository())
            ->setItems($obItemResource ?? [])
            ->setError($error ?? false)
            ->setMessage($message??"");
    }

    public function delete($id): Repository
    {
        try {
            $item =
                $this
                    ->show($id)
                    ->getItems();
            if (!$item)
                throw new \Exception("not found");
            $item->delete();
            $message = "Successfully deleted";
        } catch (\Exception $e) {
            Log::error(
                'Something went wrong while getting the task into the database',
                [
                    'message' => $e->getMessage()
                ]
            );
            $error = true;
            $message = $e->getMessage();
        }

        return (new Repository())
            ->setError($error ?? false)
            ->setMessage($message);
    }
}
