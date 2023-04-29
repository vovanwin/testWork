<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Article;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Model;

class ArticleService
{
    public function all(): CursorPaginator
    {
        return Article::query()
            ->where('is_private', false)
            ->cursorPaginate();
    }

    public function getArticle(string $articleId): Article|Model|null
    {
        return Article::query()
            ->where('is_private', false)
            ->where('id', $articleId)
            ->first();
    }
}
