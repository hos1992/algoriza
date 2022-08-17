<?php

namespace App\Actions\Product;

use App\Actions\Action;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;

class ProductUpdateAction extends Action
{
    private $model;
    private $data;

    public function __construct($model, $data)
    {
        $this->model = $model;
        $this->data = $data;
    }

    public function __invoke()
    {

        $updateArr = [
            'category_id' => $this->data['category_id'],
            'name' => $this->data['name'],
            'description' => $this->data['description'] ?? null
        ];

        if (isset($this->data['image']) && !empty($this->data['image'])) {

            try {
                // delete old image
                Storage::delete($this->model->image);
            } catch (\Exception $e) {

            }
            $updateArr['image'] = request()->file('image')->store('public/products');
        }

        $this->model->update($updateArr);

        if (isset($this->data['tags']) && !empty($this->data['tags'])) {
            $tagsIds = [];
            foreach (explode(',', $this->data['tags']) as $tag) {
                $tag = Tag::firstOrCreate([
                    'name' => trim($tag),
                ]);

                $tagsIds[] = $tag->id;
            }

            if (count($tagsIds)) {
                $this->model->tags()->sync($tagsIds);
            }
        }


        return $this->model;
    }
}
