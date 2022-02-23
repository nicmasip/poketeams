<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\ItemCreateRequest;
use App\Http\Requests\ItemEditRequest;

class ItemController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('userverified');
        $this->middleware('advanced', ['except' => ['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['items'] = Item::all();
        return view('item.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemCreateRequest $request)
    {
        $data = [];
        $data['message'] = 'A new item has been inserted successfully.';
        $data['type'] = 'success';
        $item = new Item($request->all());
        try {
            $result = $item->save();
        } catch(Exception $e) {
            $result = false;
        }
        if(!$result) {
            $data['message'] = 'The item cannot be inserted.';
            $data['type'] = 'danger';
            return back()->withInput()->with($data);
        }
        return redirect('item')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        $data = [];
        $data['item'] = $item;
        return view('item.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $data = [];
        $data['item'] = $item;
        return view('item.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(ItemEditRequest $request, Item $item)
    {
        $data = [];
        $data['message'] = 'The item ' . $item->name . ' has been updated successfully.';
        $data['type'] = 'success';
        try {
            $result = $item->update($request->all());
        } catch(Exception $e) {
            $result = false;
        }
        if(!$result) {
            $data['message'] = 'The item cannot be updated.';
            $data['type'] = 'danger';
            return back()->withInput()->with($data);
        }
        return redirect('item')->with($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $data = [];
        $data['message'] = 'The item ' . $item->name . ' has been deleted successfully.';
        $data['type'] = 'success';
        try {
            $item->delete();
        } catch(\Exception $e) {
            $data['message'] = 'The item ' . $item->name . ' has NOT been deleted.';
            $data['type'] = 'danger';
        }
        return redirect('item')->with($data);
    }
}
