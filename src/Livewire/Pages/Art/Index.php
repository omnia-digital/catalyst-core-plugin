<?php

namespace OmniaDigital\CatalystCore\Livewire\Pages\Art;

use Livewire\Component;
use OmniaDigital\CatalystCore\Models\Post;

class Index extends Component
{
    public function getMediaItemsProperty()
    {
        //        $media = Media::all();
        //        $postImages = Post::whereNotNull('image')->get('image');

        //        return $media->merge($postImages);

        return Post::withAnyTags(['art'])->get();
    }

    public function render()
    {
        return view('social::livewire.pages.art.index', [
            'media_items' => $this->media_items,
        ]);
    }
}
