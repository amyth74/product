<?php

namespace Amyth\Products\Controllers;

use Illuminate\Http\Request;
use Amyth\Products\Repositories\Eloquent\ProductRepository;

class ProductController extends Controller
{
    protected $productRepo;

    function __construct(ProductRepository $productRepo){
        $this->productRepo = $productRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate($request,[
            'name'=>'required|string|max:125',
        ]);
        $product = $this->productRepo->store($request);
        return redirect()->back()->withStatus('Product Created');
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
    public function update(Request $request, $id)
    {
        $id = base64_decode($id);
        $this->validate($request,[
            'name'=>'required|string|max:125',
        ]);
        $product = $this->productRepo->renew($request,$id);
        return redirect()->back()->withStatus('Product Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = base64_decode($id);
        $product = $this->productRepo->requiredById($id)->delete();
        if(request()->ajax() || request()->wantsJson()){
            return response()->json(['status'=>'Subscription Deleted']);
        }
        return redirect()->back()->withStatus('Product Deleted');
    }

    public function getLists(Request $request)
    {
        return $this->productRepo->getLists($request);
    }
}
