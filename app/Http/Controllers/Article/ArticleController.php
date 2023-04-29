<?php

declare(strict_types=1);

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Http\Resource\ArticleResource;
use App\Service\ArticleService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @tags Статьи
 */
class ArticleController extends Controller
{
    public function __construct(private readonly ArticleService $usersService)
    {
    }

    /**
     * Показать все статьи
     * @unauthenticated
     */
    public function index(): AnonymousResourceCollection
    {
        $articles = $this->usersService->all();

        return ArticleResource::collection($articles);
    }

    /**
     * Показать статью
     * @unauthenticated
     */
    public function show(string $article): ArticleResource
    {
        $articles = $this->usersService->getArticle(articleId: $article);

        abort_if(null === $articles, 404);

        return ArticleResource::make($articles);
    }
}
