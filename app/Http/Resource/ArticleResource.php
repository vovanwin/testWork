<?php

declare(strict_types=1);

namespace App\Http\Resource;

use App\Models\Tag;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $id
 * @property string $title
 * @property string $content
 * @property Tag[] $tags
 */
class ArticleResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function toArray(\Illuminate\Http\Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'tags' => TagResource::collection($this->tags),
        ];
    }
}
