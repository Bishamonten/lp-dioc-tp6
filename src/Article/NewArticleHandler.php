<?php

namespace App\Article;

use App\Entity\Article;
use App\Entity\ArticleStat;
use App\Slug\SlugGenerator;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class NewArticleHandler
{
    private $token;
    private $slugGenerator;
    private $articleStat;
    private $em;

    /**
     * NewArticleHandler constructor.
     * @param $token
     * @param $slugGenerator
     * @param $articleStat
     * @param $doctrine
     */
    public function __construct(Registry $doctrine, TokenStorage $token, SlugGenerator $slugGenerator, ArticleStat $articleStat)
    {
        $this->slugGenerator = $slugGenerator;
        $this->articleStat =$articleStat;
        $this->token = $token;
        $this->em = $doctrine->getManager();
    }


    public function handle(Article $article): void
    {
        $article->setSlug($this->slugGenerator->generate($article->getTitle()));
        $article->setAuthor($this->token->getToken()->getUser());
        $article->setCreatedAt( new \DateTime());
        $article->setUpdatedAt( new \DateTime());
        $this->em->persist($article);
        $this->em->flush();
        // Slugify le titre et ajoute l'utilisateur courant comme auteur de l'article
        // Log également un article stat avec pour action create.
    }
}
