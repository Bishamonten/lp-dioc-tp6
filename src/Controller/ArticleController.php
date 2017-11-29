<?php

namespace App\Controller;

use App\Article\CountViewUpdater;
use App\Article\NewArticleHandler;
use App\Article\UpdateArticleHandler;
use App\Article\ViewArticleHandler;
use App\Entity\Article;
use App\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Flex\Response;


/**
 * @Route(path="/article")
 */
class ArticleController extends Controller
{
    /**
     * @Route(path="/show/{slug}", name="article_show")
     */
    public function showAction()
    {
    }

    /**
     * @Route(path="/new", name="article_new")
     * @param $handler
     * @param $request
     * @return
     */
    public function newAction(Request $request, NewArticleHandler $handler)
    {
        $form = $this->createForm(ArticleType::class);
        $form->handleRequest($request);
        // Seul les auteurs doivent avoir access.
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $handler->handle($article);
            return $this->redirectToRoute('homepage');
        }
        return $this->render('Article/new.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route(path="/update/{slug}", name="article_update")
     * @param $request
     * @param $article
     * @param $updateArticleHandler
     * @return
     */
    public function updateAction(Request $request,Article $article,UpdateArticleHandler $updateArticleHandler)
    {
        // Seul les auteurs doivent avoir access.
        // Seul l'auteur de l'article peut le modifier
        if($this->getUser() == $article->getAuthor())
        {
            $form = $this->createForm(ArticleType::class, $article);
            $form->handleRequest($request);
            if($form->isValid() && $form->isSubmitted())
            {
                $article = $form->getData();
                $updateArticleHandler->handle($article);
            }
            return $this->render('Article/update.html.twig', ['form' => $form->createView()]);
        }
        return $this->redirectToRoute('article_show', array('slug' => $article->getSlug()));
    }
}
