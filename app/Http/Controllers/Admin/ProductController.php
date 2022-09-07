<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookAuthor;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\ProductImage;
use App\Models\ProductInventory;
use App\Models\ProductInventoryStock;
use App\Models\ProductPromotion;
use App\Models\ProductTag;
use App\Models\RelatedProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \App\Http\Requests;
use Image,DB,Auth,Validator,MyHelper,Route,DataLoad;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.'.Route::currentRouteName());
    }

    protected function getProductData()
    {

        $allData=Product::with('productStock')
            ->leftJoin('categories','products.category_id','categories.id')
            ->leftJoin('product_inventory_stocks','products.id','product_inventory_stocks.product_id')
            ->leftJoin('product_images','products.id','product_images.product_id')
            ->select('categories.category_name','product_inventory_stocks.sale_price','product_inventory_stocks.qty',
                'products.id','products.name','products.sku','products.status','products.show_home','products.is_feature','product_images.small')
            ->where(['product_images.is_thumbnail'=>Product::YES])
            ->orderBy('id','desc');

       return  DataTables::of($allData)
            ->addIndexColumn()
            ->addColumn('DT_RowIndex','')
            ->addColumn('qty',function (Product $product){
                return $balanceQty=($product->productStock->qty+$product->productStock->sold_return_qty)-($product->productStock->sold_qty+$product->productStock->purchase_return_qty);
            })
            ->addColumn('Image','
                    <img src="<?php echo asset($small);?>" alt="<?php echo $name;?>" width="50">
                ')

            ->addColumn('action','
            {!! Form::open(array(\'route\'=> [\'products.destroy\',$id],\'method\'=>\'DELETE\',\'class\'=>\'deleteForm\',\'id\'=>"deleteForm$id")) !!}
                {{ Form::hidden(\'id\',$id)}}
                 @can(\'product-edit\')
                <a href="{{route(\'products.edit\',$id)}}" class="btn btn-warning btn-sm" title="Click here to update"><i class="la la-pencil-square"></i> </a>
                @endcan
                
                @can(\'product-delete\')
                <button type="button" onclick=\'return deleteConfirm("deleteForm{{$id}}");\' class="deleteBtn btn btn-danger btn-sm" title="Click here to delete">
                  <i class="la la-trash"></i>
                </button>
                @endcan
            {!! Form::close() !!}
            ')
            ->rawColumns(['Image','qty','action'])
            ->toJson();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title='Create New Product';
        $status=[
            Product::PUBLISHED=>Product::PUBLISHED,
            Product::UNPUBLISHED=>Product::UNPUBLISHED,
            Product::DRAFT=>Product::DRAFT
        ];
        $yesNoStatus=[
            Product::YES=>Product::YES,
            Product::NO=>Product::NO
        ];
        $authorLists=DataLoad::authorList();
        $publisherLists=DataLoad::publisherList();
        $countryLists=DataLoad::countryList();
        $languageLists=DataLoad::languageList();

        $vatTaxes=DataLoad::vatTaxList();
        $brands=DataLoad::brandList();
        $categories=DataLoad::categoryList();


        $relatedProductLists=DataLoad::relatedProductList();

        $max_serial=Product::max('serial_num');
        return view('admin.'.Route::currentRouteName(),
            compact('title','status','yesNoStatus','max_serial','authorLists','publisherLists','countryLists','languageLists','vatTaxes','brands',
                'categories','relatedProductLists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\ProductRequest $request)
    {
        $input = $request->all();

        $input['link']= MyHelper::slugify($request->name);

        DB::beginTransaction();
        try{

            $input['created_by']=\Auth::user()->id;

            $input['promotion']=Product::NO;
            if ($request->promotion==Product::YES)
            {
                $input['promotion']=Product::YES;
            }

            $input['installation_gide']='';
            if ($request->hasFile('installation_gide'))
            {
                $input['installation_gide']=\MyHelper::fileUpload($request->file('installation_gide'),'files/products/installation-guide');
            }

            $product=Product::create($input);

            if ($request->has('child_id') && count($request->child_id)>0)
            {
               $this->relatedProducts($request, $product->id);
            }

            if ($request->has('author_id') && count($request->author_id)>0)
            {
               $this->storeProductAuthors($request, $product->id);
            }


            if ($request->hasFile('image'))
            {
                $this->multiPhotoUpload($request, $product->id);
            }


            $this->productInventoryStock($request, $product->id);

            if ($request->promotion==Product::YES)
            {
                $this->productPromotion($request, $product->id);
            }
            DB::commit();
            return redirect()->back()->with('success','Product Data Successfully Save');
        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }


    public function storeProductAuthors($request,$productId,$update=false)
    {

        if ($update==true)
        {
            BookAuthor::where('product_id',$productId)->delete();
        }

        foreach ($request->author_id as $key=>$author_id)
        {
            $bookAuthors[]=[
                'product_id'=>$productId,
                'author_id'=>$author_id,
            ];
        }
        BookAuthor::insert($bookAuthors);
    }

    public function productCollections($request,$productId,$update=false)
    {

        if ($update==true)
        {
            ProductCollection::where('product_id',$productId)->delete();
        }

        foreach ($request->collection_id as $key=>$collectionId)
        {
            $productCollections[]=[
                'product_id'=>$productId,
                'collection_id'=>$collectionId,
            ];
        }
        ProductCollection::insert($productCollections);
    }

    public function productPromotion($request,$productId,$update=false)
    {
        $dateStart=Carbon::now()->format('Y-m-d');
        if (@empty($request->date_start))
        {
            $dateStart=date('Y-m-d',strtotime($request->date_start));
        }

        $dateEnd=Carbon::now()->addMonth(1)->format('Y-m-d');
        if (!empty($request->date_end))
        {
            $dateEnd=date('Y-m-d',strtotime($request->date_end));
        }


        $productPromotion=ProductPromotion::where(['product_id'=>$productId])->first();

        if (empty($productPromotion))
        {
            ProductPromotion::create(
                [
                    'product_id'=>$productId,
                    'org_price'=>$request->sale_price,
                    'promotion_by_percent'=>$request->promotion_by_percent,
                    'promotion_by_value'=>$request->promotion_by_value,
                    'promotion_price'=>$request->promotion_price,
                    'date_start'=>$dateStart,
                    'date_end'=>$dateEnd,
                    'status'=>ProductPromotion::ACTIVE,
                    'created_by'=>\Auth::user()->id,
                    'updated_by'=>\Auth::user()->id,
                ]
            );
        }else{
            $productPromotion->update([
                'org_price'=>$request->sale_price,
                'promotion_by_percent'=>$request->promotion_by_percent,
                'promotion_by_value'=>$request->promotion_by_value,
                'promotion_price'=>$request->promotion_price,
                'date_start'=>$dateStart,
                'date_end'=>$dateEnd,
                'status'=>ProductPromotion::ACTIVE,
            ]);
        }

    }

    public function productInventoryStock($request,$productId,$update=false)
    {

        ProductInventory::create(
            [
            'product_id'=>$productId,
            'product_purchase_id'=>$request->product_purchase_id??null,
            'new_add_qty'=>$request->new_add_qty??0,
            'qty'=>$request->qty??0,
            'cost_price'=>$request->cost_price??0,
            'sale_price'=>$request->sale_price??0,
            'created_by'=>\Auth::user()->id,
            'updated_by'=>\Auth::user()->id,
            ]);

        $productInventoryStock=ProductInventoryStock::where(['product_id'=>$productId])->first();

        if (empty($productInventoryStock))
        {
            ProductInventoryStock::create(
                [
                    'product_id'=>$productId,
                    'qty'=>$request->qty,
                    'cost_price'=>$request->cost_price,
                    'sale_price'=>$request->sale_price,
                    'created_by'=>\Auth::user()->id,
                    'updated_by '=>\Auth::user()->id,
                ]);
        }else{

            $stockInput=[
                'cost_price'=>$request->cost_price,
                'sale_price'=>$request->sale_price,
                'updated_by '=>\Auth::user()->id,
            ];
//            if ($update==true)
//            {
//                $stockInput['qty']=$productInventoryStock->qty+$request->new_add_qty;
//            }

            $productInventoryStock->update($stockInput);
        }
    }
    public function relatedProducts($request,$productId,$update=false)
    {
        if ($update==true)
        {
            RelatedProduct::where('product_id',$productId)->delete();
        }

        foreach ($request->child_id as $key=>$child_id)
        {
            $relatedProducts[]=[
                'product_id'=>$productId,
                'child_id'=>$child_id,
            ];
        }
        RelatedProduct::insert($relatedProducts);
    }

    public function productTags($request,$productId,$update=false)
    {
        if ($update==true)
        {
            ProductTag::where('product_id',$productId)->delete();
        }

        foreach ($request->tag_id as $key=>$tagId)
        {
            $productTags[]=[
                'product_id'=>$productId,
                'tag_id'=>$tagId,
            ];
        }
        ProductTag::insert($productTags);
    }

    public function multiPhotoUpload($request,$productId,$update=false)
    {
        $productImages=[];
            foreach ($request->image as $key=>$imageData) {

                if ($update == true) {
                    $oldImage = ProductImage::where(['id' => $key, 'product_id' => $productId])->first();

                    if (!empty($oldImage))
                    {
                        if ($oldImage->big != null and file_exists($oldImage->big)) {
                            unlink($oldImage->big);
                        }

                        if ($oldImage->medium != null and file_exists($oldImage->medium)) {
                            unlink($oldImage->medium);
                        }

                        if ($oldImage->small != null and file_exists($oldImage->small)) {
                            unlink($oldImage->small);
                        }

                        $imagePaths = \MyHelper::multiPhotoUpload($imageData, 'images/products/big', 750);

                        $oldImage->update([
                            'big' => $imagePaths['big'],
                            'medium' => $imagePaths['medium'],
                            'small' => $imagePaths['small'],
                        ]);
                    }else{
                        $imagePaths = \MyHelper::multiPhotoUpload($imageData, 'images/products/big', 750);

                        $is_thumbnail = ProductImage::NO;
                        if ($key == 0) {
                            $is_thumbnail = ProductImage::YES;
                        }

                        $productImages[] = [
                            'product_id' => $productId,
                            'big' => $imagePaths['big'],
                            'medium' => $imagePaths['medium'],
                            'small' => $imagePaths['small'],
                            'is_thumbnail' => $is_thumbnail,
                        ];
                    }



                }else{

                    $imagePaths = \MyHelper::multiPhotoUpload($imageData, 'images/products/big', 750);

                    $is_thumbnail = ProductImage::NO;
                    if ($key == 0) {
                        $is_thumbnail = ProductImage::YES;
                    }

                    $productImages[] = [
                        'product_id' => $productId,
                        'big' => $imagePaths['big'],
                        'medium' => $imagePaths['medium'],
                        'small' => $imagePaths['small'],
                        'is_thumbnail' => $is_thumbnail,
                    ];
                }

            }

            if (count($productImages)>0)
            {
                ProductImage::insert($productImages);
            }

    }

    public function deleteUploadedPhoto($request,$productId){
        foreach ($request->delete_img as $key=>$id) {

            $oldImage = ProductImage::where(['id' => $id, 'product_id' => $productId])->first();

            if (!empty($oldImage)) {
                if ($oldImage->big != null and file_exists($oldImage->big)) {
                    unlink($oldImage->big);
                }

                if ($oldImage->medium != null and file_exists($oldImage->medium)) {
                    unlink($oldImage->medium);
                }

                if ($oldImage->small != null and file_exists($oldImage->small)) {
                    unlink($oldImage->small);
                }

                $oldImage->forceDelete();

            }
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $title='Update Product Information';
        $product=Product::with('productStock','productTags','productCollections','productPromotion','relatedProducts','productImages')->findOrFail($id);

        $status=[
            Product::PUBLISHED=>Product::PUBLISHED,
            Product::UNPUBLISHED=>Product::UNPUBLISHED,
            Product::DRAFT=>Product::DRAFT
        ];
        $yesNoStatus=[
            Product::YES=>Product::YES,
            Product::NO=>Product::NO
        ];
        $categories=DataLoad::categoryList();

        $subCategories=DataLoad::subCatList($product->category_id);

        $thirdSubCategories=[];
        if (!empty($product->subcategory_id))
        {
            $thirdSubCategories=DataLoad::thirdSubCatList($product->subcategory_id);
        }
        $fourthSubCategories=[];
        if (!empty($product->third_category_id))
        {
            $fourthSubCategories=DataLoad::fourthSubCatList($product->third_category_id);
        }

        $authorLists=DataLoad::authorList();
        $publisherLists=DataLoad::publisherList();
        $countryLists=DataLoad::countryList();
        $languageLists=DataLoad::languageList();

        $vatTaxes=DataLoad::vatTaxList();
        $brands=DataLoad::brandList();
        $categories=DataLoad::categoryList();

        $relatedProductLists=DataLoad::relatedProductList();

        $bookAuthors=$product->relProductAuthors->pluck('author_id');
        $relatedProducts=$product->relatedProducts->pluck('child_id');
        //$relatedProducts=$product->relatedProducts->pluck('pivot.child_id');


        $max_serial=Product::max('serial_num');
        return view('admin.'.Route::currentRouteName(),
            compact('title','status','yesNoStatus','product','max_serial','authorLists','bookAuthors','publisherLists','countryLists','languageLists',
                'vatTaxes','brands','categories','subCategories','thirdSubCategories','fourthSubCategories','relatedProductLists',
                'relatedProducts'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $input = $request->all();

        $input['link']= $request->name.$product->id;
        //$input['link']= MyHelper::slugify($request->name);

        $id=$product->id;

        DB::beginTransaction();
        try{
            $validator = Validator::make($input, [
                'name' => "required|max:200|unique:products,name,$id,id,deleted_at,NULL",
                'name_bn' => "required|max:200|unique:products,name_bn,$id,id,deleted_at,NULL",
                'keyword' => 'nullable|max:200',
                'origin_id'=>'nullable|exists:origins,id',
                'pack_size_unit_id'=>'nullable|exists:pack_size_units,id',
                'category_id'=>'required|exists:categories,id',
                'sub_cat_id'=>'nullable|exists:sub_categories,id',
                'third_category_id'=>'nullable|exists:third_sub_categories,id',
                'fourth_category_id'=>'nullable|exists:fourth_sub_categories,id',
                'brand_id'=>'nullable|exists:brands,id',
                'vat_tax_id'=>'nullable|exists:vat_taxes,id',
                'sku' => "required|max:200|unique:products,sku,$id,id,deleted_at,NULL",
                'cost_price' => 'required|numeric|max:99999999',
                'sale_price' => 'required|numeric|max:99999999',
                //'qty' => 'required|numeric|max:99999999',
                'serial_num' => 'required|numeric|max:99999999',
                //'link' => "required|unique:products,link,$id,id,deleted_at,NULL",
                'image' => 'nullable|array',
                'image.*' => 'image|mimes:jpg,jpeg,bmp,png,webp,gif|max:15240',
            ]);
            if ($validator->fails())
            {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $input['updated_by']=\Auth::user()->id;

            $input['promotion']=Product::NO;
            if ($request->promotion==Product::YES)
            {
                $input['promotion']=Product::YES;
            }

            $input['installation_gide']=$product->installation_gide;
            if ($request->hasFile('installation_gide'))
            {
                $input['installation_gide']=\MyHelper::fileUpload($request->file('installation_gide'),'files/products/installation-guide');

                if($product->installation_gide!=null and file_exists($product->installation_gide)){
                    unlink($product->installation_gide);
                }
            }

            $product->update($input);


            if ($request->has('child_id') && count($request->child_id)>0)
            {
                $this->relatedProducts($request, $id,true);
            }

            if ($request->has('author_id') && count($request->author_id)>0)
            {
                $this->storeProductAuthors($request, $product->id,true);
            }


            $productInventoryStock=ProductInventoryStock::where(['product_id'=>$id])->first();

            if (($request->has('new_add_qty') && $request->new_add_qty>0)
                ||  (!empty($productInventoryStock) && $productInventoryStock->cost_price!=$request->cost_price)
                ||  (!empty($productInventoryStock) && $productInventoryStock->sale_price!=$request->sale_price))
            {

                $this->productInventoryStock($request,$id,true);
            }

            if ($request->promotion==Product::YES)
            {
                $this->productPromotion($request, $id,true);
            }

            if ($request->hasFile('image'))
            {
                $this->multiPhotoUpload($request, $id,true);
            }

            if ($request->has('delete_img') && count($request->delete_img))
            {
                $this->deleteUploadedPhoto($request, $id);
            }

            DB::commit();
            return redirect()->back()->with('success','Product Data Successfully Update');
        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {

        DB::beginTransaction();
        try{

            ProductCollection::where('product_id',$product->id)->delete();
            ProductTag::where('product_id',$product->id)->delete();
            ProductImage::where('product_id',$product->id)->delete();
            ProductInventory::where('product_id',$product->id)->delete();
            ProductInventoryStock::where('product_id',$product->id)->delete();
            ProductPromotion::where('product_id',$product->id)->delete();
            RelatedProduct::where('product_id',$product->id)->delete();
            BookAuthor::where('product_id',$product->id)->delete();
            $product->delete();
            DB::commit();
            return redirect()->back()->with('success','Data has been Successfully Deleted!');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage());
        }

    }
}
