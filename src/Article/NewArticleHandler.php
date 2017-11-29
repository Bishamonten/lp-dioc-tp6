<?php

namespace App\Article;

use App\Entity\Article;
use App\Entity\ArticleStat;
use App\Slug\SlugGenerator;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class NewArticleHandler
{
    private $token;
    private $slugGenerator;
    private $ArticleStat;

    /**
     * NewArticleHandler constructor.
     * @param $token
     * @param $slugGenerator
     * @param $ArticleStat
     */
    public function __construct( ArticleStat $ArticleStat)
    {
        $this->slugGenerator = new SlugGenerator();
    }


    public function handle(Article $article): void
    {

        // Slugify le titre et ajoute l'utilisateur courant comme auteur de l'article
        // Log également un article stat avec pour action create.
    }
}
