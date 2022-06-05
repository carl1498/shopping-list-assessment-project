<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\ItemList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ItemListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::has('items')->with('items')->get();
        $itemList = ItemList::with('item.department')->get()->sortBy('item.department.name')->values();

        $itemLists = ItemList::with('item.department')->get()
            ->groupBy('item.department.name')
            ->sortKeys()
            ->transform(function ($items) {
                $items = [
                    'items' => $items->sortBy('id')->transform(function ($item) {
                        return [
                            'id' => $item->id,
                            'name' => $item->item->name,
                            'purchased' => $item->purchased,
                            'quantity' => $item->quantity
                        ];
                    })->values()
                ];

                return $items;
            });

        return Request()->expectsJson()
            ? Response()->json(compact('departments', 'itemLists'))
            : Inertia::render('ItemList/Index', compact('departments', 'itemLists'));
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
        $input = $request->validate([
            "quantity" => ["required", "min:1"],
            "item_id" => ["required", "exists:items,id"],
        ]);

        return Response()->json(['success' => ItemList::create( $input )]);
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
    public function update(Request $request, ItemList $list)
    {
        $input = $request->validate([
            "purchased" => ["sometimes", "boolean"],
            "quantity" => ["sometimes", "integer"],
        ]);

        return Response()->json(['success' => $list->update( $input )]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemList $list)
    {
        return Response()->json(['success' => $list->delete()]);
    }
}
