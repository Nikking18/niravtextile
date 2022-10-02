<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.items.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|unique:items,item_name',
            'description' => 'required',
        ], [
            'item_name.unique' => 'Item name is already exists !',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $itemsData = $request->all();
        $createItem = Item::create($itemsData);

        if ($createItem) {
            return view('admin.items.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('admin.items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $updateDate = $request->all();
        $requestUpdated = $item->update($updateDate);

        if ($requestUpdated) {
            return redirect(route('admin.items.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        if ($item->delete()) {
            return response(['msg' => 'Item has been deleted', 'status' => 1]);
        } else {
            return response(['msg' => 'Item is safe', 'status' => 0]);
        }
    }

    public function getData()
    {
        $items = Item::query();
        return DataTables::of($items)
            ->editColumn('item_name', function ($items) {
                if (!empty($items->item_name)) {
                    return $items->item_name;
                } else {
                    return '';
                }
            })
            ->editColumn('description', function ($items) {
                if (!empty($items->description)) {
                    return $items->description;
                } else {
                    return '';
                }
            })
            ->editColumn('created_at', function ($items) {
                if (!empty($items->created_at)) {
                    return date('d-m-Y', strtotime($items->created_at));
                } else {
                    return '';
                }
            })
            ->editColumn('action', function ($items) {
                $delete = '<a href="javascript:void(0)"  data-remote="' . route('admin.items.destroy', ['item' => $items->id]) . '" class="btn btn-danger waves-effect waves-float waves-light delete-link" title="Delete Model"><i class="fa fa-trash"></i></a>';
                $edit = '<a href="' . route('admin.items.edit', ['item' => $items->id]) . '" class="btn btn-info waves-effect waves-float waves-light" title="Edit Model"><i class="fa fa-pencil"></i></a>';
                return $edit . ' ' . ' ' . $delete;
            })
            ->addIndexColumn()
            ->rawColumns(['item_name', 'description', 'action'])
            ->setTotalRecords($items->count())
            ->make(true);
    }

}
