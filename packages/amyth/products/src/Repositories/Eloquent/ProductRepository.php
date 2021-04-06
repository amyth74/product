<?php 

namespace Amyth\Products\Repositories\Eloquent;


class ProductRepository extends Repository
{
    public function model()
	{
		return 'App\Models\Product';
	}

	public function products()
	{
		return $this->model;
    }

	public function store($request)
	{
		$inputs = $request->all();
		$product = $this->products()->create($inputs);
		return $product;
    }

    public function renew($request, $id)
	{
		$product = $this->requiredById($id);
		$inputs = $request->all();
		$product->update($inputs);
		return $product;
	}

	public function getLists($request)
	{
		$products = $this->products()
			->when($request->q, function($query, $q){
				return $query->where('name', 'like', "%{$q}%");
			})
			->orderBy('created_at','asc')
			->paginate(20);

		$items['total'] = $products->total();

		$items['items'] = $products->transform(function($item){
		    return [
		        'id' => $item->id,
		        'text' => strip_tags($item->name)
		    ];
		});

		return $items;
	}
}