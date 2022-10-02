<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InwordRequest;
use App\Models\Inword;
use App\Models\Item;
use App\Models\Party;
use App\Models\Stock;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InwordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.inword.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parties = Party::all();
        $items = Item::all();
        return view('admin.inword.create', compact('parties', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(InwordRequest $request)
    {
        $inwordData = $request->all();
        $itemId = Item::where('item_name',$request->item_name)->pluck('id')->first();
        $inwordData['item_id'] = $itemId;
        $inwordData['amount'] = $inwordData['quantity'] * $inwordData['rate'];
        $createInword = Inword::create($inwordData);

        $createStock = $request->all();
        $createStock['inword_id'] = $createInword['id'];
        $createStock['item_id'] = $itemId;
        $createStock['amount'] = $createStock['quantity'] * $createStock['rate'];
        $createStock = Stock::create($createStock);


        if ($createInword || $createStock) {
            return view('admin.inword.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Inword $inword)
    {
        $parties = Party::all();
        $items = Item::all();
        return view('admin.inword.edit', compact('inword', 'parties', 'items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(InwordRequest $request, Inword $inword)
    {
        $updateDate = $request->all();
        $updateDate['amount'] = $updateDate['quantity'] * $updateDate['rate'];
        $requestUpdated = $inword->update($updateDate);

        if ($requestUpdated) {
            return redirect(route('admin.inwords.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inword $inword)
    {
        if ($inword->delete()) {
            return response(['msg' => 'Inword has been deleted', 'status' => 1]);
        } else {
            return response(['msg' => 'Inword is safe', 'status' => 0]);
        }
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {

            $inwords = Inword::whereDate('created_at', '>=', date('Y-m-d', strtotime($request->startDate)))
                ->whereDate('created_at', '<=', date('Y-m-d', strtotime($request->endDate)))->get();

            return DataTables::of($inwords)
                ->editColumn('party_name', function ($inwords) {
                    if (!empty($inwords->party_name)) {
                        return $inwords->party_name;
                    } else {
                        return '';
                    }
                })
                ->editColumn('item_name', function ($inwords) {
                    if (!empty($inwords->item_name)) {
                        return $inwords->item_name;
                    } else {
                        return '';
                    }
                })
                ->editColumn('quantity', function ($inwords) {
                    if (!empty($inwords->quantity)) {
                        return $inwords->quantity;
                    } else {
                        return '';
                    }
                })
                ->editColumn('rate', function ($inwords) {
                    if (!empty($inwords->rate)) {
                        return $inwords->rate;
                    } else {
                        return '';
                    }
                })
                ->editColumn('amount', function ($inwords) {
                    if (!empty($inwords->amount)) {
                        return $inwords->amount;
                    } else {
                        return '';
                    }
                })
                ->editColumn('created_at', function ($inwords) {
                    if (!empty($inwords->created_at)) {
                        return date('d-m-Y', strtotime($inwords->created_at));
                    } else {
                        return '';
                    }
                })
                ->editColumn('action', function ($inwords) {
                    $delete = '<a href="javascript:void(0)"  data-remote="' . route('admin.inwords.destroy', ['inword' => $inwords->id]) . '" class="btn btn-danger waves-effect waves-float waves-light delete-link" title="Delete Model"><i class="fa fa-trash"></i></a>';
                    $edit = '<a href="' . route('admin.inwords.edit', ['inword' => $inwords->id]) . '" class="btn btn-info waves-effect waves-float waves-light" title="Edit Model"><i class="fa fa-pencil"></i></a>';
                    return $edit . ' ' . ' ' . $delete;
                })
                ->addIndexColumn()
                ->rawColumns(['party_name', 'item_name', 'quantity', 'rate', 'amount', 'created_at', 'action'])
                ->setTotalRecords($inwords->count())
                ->make(true);
        }
    }
}
