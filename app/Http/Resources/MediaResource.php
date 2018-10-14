<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $adapter = Storage::disk('dropbox')->getAdapter();
        $client = $adapter->getClient();
        $link = $client->getTemporaryLink("/{$this->id}/{$this->file_name}");

        return [
          'id' => $this->id,
          'src' => $link,
          'title' => $this->name,
          'custom' => $this->custom_properties
        ];
    }
}
