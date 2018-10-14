<?php

namespace App;

use Spatie\MediaLibrary\Models\Media as BaseMedia;
use Storage;
use Illuminate\Support\Facades\Cache;

class Media extends BaseMedia
{
    public function getDropboxLink()
    {
        $link = Cache::remember("media-{$this->id}-temp-link", 60 * 3 ,function () {
            $adapter = Storage::disk('dropbox')->getAdapter();
            $client = $adapter->getClient();
            return $client->getTemporaryLink("/{$this->id}/{$this->file_name}");
        });
        return $link;
    }
}
