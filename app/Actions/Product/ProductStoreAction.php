<?php

namespace App\Actions\Product;

use App\Actions\Action;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Tag;

class ProductStoreAction extends Action
{

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function __invoke()
    {
        $product = Product::create([
            'image' => request()->file('image')->store('public/products'),
            'category_id' => $this->data['category_id'],
            'name' => $this->data['name'],
            'description' => $this->data['description'] ?? null
        ]);

        if (isset($this->data['tags']) && !empty($this->data['tags'])) {
            $tagsIds = [];
            foreach (explode(',', $this->data['tags']) as $tag) {
                $tag = Tag::firstOrCreate([
                    'name' => trim($tag),
                ]);

                $tagsIds[] = $tag->id;
            }

            if (count($tagsIds)) {
                $product->tags()->attach($tagsIds);
            }
        }

        return $product;
    }

}
