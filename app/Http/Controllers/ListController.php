<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\LineItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::has('items')->with('items')->get();

        // Group and Sort Line Items by Department Name
        $lineItems = LineItem::with('item.department')->get()
            ->groupBy('item.department.name')
            ->sortKeys()
            ->transform(function ($items) {
                $items = [
                    'items' => $items->sortBy('line_item_id')->transform(function ($item) {
                        return [
                            'line_item_id' => $item->line_item_id,
                            'name' => $item->item->name,
                            'purchased' => $item->purchased,
                            'quantity' => $item->quantity
                        ];
                    })->values()
                ];

                return $items;
            });

        return Request()->expectsJson()
            ? Response()->json(compact('departments', 'lineItems'))
            : Inertia::render('List/Index', compact('departments', 'lineItems'));
    }
}
