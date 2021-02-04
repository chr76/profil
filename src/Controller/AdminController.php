<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Knowledge;
use App\Form\ArticleType;
use App\Form\ExampleType;
use App\Form\CategoryType;
use App\Form\KnowledgeType;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\InputBag;

/**
 * Admin
 * @Route("/admin", name="admin")
 */
class AdminController extends AbstractController
{
    /**
     * Dashboard
     * @Route("/", name="_dashboard")
     * @return Response
     */
    public function dashboard(): Response
    {
        $em = $this->getDoctrine()->getManager();
 
        if (null === $competences = $em->getRepository(Knowledge::class)->findBy(['domain'=>'competence'])) {
            $competences = [];
            // throw $this->createNotFoundException("Erreur knowledge.");
        }
        if (null === $connaissances = $em->getRepository(Knowledge::class)->findBy(['domain'=>'connaissance'])) {
            $connaissances = [];
            // throw $this->createNotFoundException("Erreur knowledge.");
        }
        if (null === $knowledges = $em->getRepository(Knowledge::class)->findBy(['domain'=>null])) {
            $knowledges = [];
            // throw $this->createNotFoundException("Erreur knowledge.");
        }
        if (null === $articles = $em->getRepository(Article::class)->findBy(['type'=>'presentation'])) {
            $articles = [];
            // throw $this->createNotFoundException("Erreur article.");
        }
        if (null === $websites = $em->getRepository(Article::class)->findBy(['type'=>'website'])) {
            $websites = [];
            // throw $this->createNotFoundException("Erreur article.");
        }
        if (null === $examples = $em->getRepository(Article::class)->findBy(['type'=>'example'])) {
            $examples = [];
            // throw $this->createNotFoundException("Erreur article.");
        }
        return $this->render('admin/dashboard.html.twig', [
            'competences' => $competences,
            'connaissances' => $connaissances,
            'knowledges' => $knowledges,
            'articles' => $articles,
            'examples' => $examples,
            'websites' => $websites,
        ]);
    }

    /**
     * Form Knowledge
     * @Route("/connaissance/{id?}", name="_knowledge")
     * @param int $id
     * @return Response
     */
    public function editKnowledge(?int $id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $webPath = realpath('../public/img/icons');
        $finder = new Finder();
        $finder->in($webPath);
        $filelist = [];
        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                $filelist[$file->getRelativePathname()] = $file->getRelativePathname();
            }
        }

        $knowledges = $em->getRepository(Knowledge::class)->findAllIndexed();

        if ($id) {
            $knowledge = $knowledges[$id];
            // if (null === $knowledge = $em->getRepository(Knowledge::class)->find($id)) {
            //     $knowledge = [];
            //     // throw $this->createNotFoundException("Erreur knowledge.");
            // }
        } else {
            $knowledge = new Knowledge();
        }
        $knowledge_form = $this->createForm(KnowledgeType::class, $knowledge);
        $knowledge_form->handleRequest($request);
        if ($knowledge_form->isSubmitted() && $knowledge_form->isValid()) {
            $em->persist($knowledge);
            $em->flush();
            $knowledge->getId();
            return $this->redirectToRoute('admin_dashboard', ['_fragment' => 'knowledge_' . $knowledge->getId()]);
        }

        $new_category = new Category();
        $category_form = $this->createForm(CategoryType::class, $new_category);
        $category_form->handleRequest($request);
        if ($category_form->isSubmitted() && $category_form->isValid()) {
            $em->persist($new_category);
            $em->flush();
        }
        return $this->render('admin/knowledge_form.html.twig', [
            'knowledge_form' => $knowledge_form->createView(),
            'category_form' => $category_form->createView(),
            'icons' => $filelist,
            'knowledges' => $knowledges,
        ]);
    }

    /**
     * Delete Knowledge
     * @Route("/connaissance/suppr/{id}", name="_knowledge_suppr")
     * @param int $id
     */
    public function deleteKnowledge(int $id)
    {
        $em = $this->getDoctrine()->getManager();

        if (null === $knowledge = $em->getRepository(Knowledge::class)->find($id)) {
            throw $this->createNotFoundException("Erreur knowledge.");
        } else {
            $em->remove($knowledge);
            $em->flush();
            return $this->redirectToRoute('admin_dashboard', ['_fragment' => 'knwoledges']);
        }
    }

    /**
     * Form Presentation
     * @Route("/presentation/{id?}", name="_presentation")
     * @param int $id
     * @return Response
     */
    public function editPresentation(?int $id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        if ($id) {
            if (null === $presentation = $em->getRepository(Article::class)->find($id)) {
                throw $this->createNotFoundException("Erreur article.");
            }
        } else {
            $presentation = new Article();
            $presentation->setType('presentation');
        }

        $presentation_form = $this->createForm(ArticleType::class, $presentation);
        $presentation_form->handleRequest($request);
        if ($presentation_form->isSubmitted() && $presentation_form->isValid()) {
            $em->persist($presentation);
            $em->flush();
            $presentation->getId();
            return $this->redirectToRoute('admin_dashboard', ['_fragment' => 'presentation_' . $presentation->getId()]);
        }

        return $this->render('admin/article_form.html.twig', [
            'title' => 'Ajouter une présentation',
            'type' => 'presentation',
            'article_form' => $presentation_form->createView(),
        ]);
    }

    /**
     * Form Website
     * @Route("/site/{id?}", name="_website")
     * @param int $id
     * @return Response
     */
    public function editWebsite(?int $id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        if ($id) {
            if (null === $website = $em->getRepository(Article::class)->find($id)) {
                throw $this->createNotFoundException("Erreur article.");
            }
        } else {
            $website = new Article();
            $website->setType('website');
        }

        $website_form = $this->createForm(ArticleType::class, $website);
        $website_form->handleRequest($request);
        if ($website_form->isSubmitted() && $website_form->isValid()) {
            $em->persist($website);
            $em->flush();
            $website->getId();
            return $this->redirectToRoute('admin_dashboard', ['_fragment' => 'website_' . $website->getId()]);
        }

        return $this->render('admin/article_form.html.twig', [
            'title' => 'Ajouter un site web',
            'type' => 'site',
            'article_form' => $website_form->createView(),
        ]);
    }

    /**
     * Form Example
     * @Route("/exemple/{id?}", name="_example")
     * @param int $id
     * @return Response
     */
    public function editExample(?int $id, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        if (null === $knowledge = $em->getRepository(Knowledge::class)->find($id)) {
            throw $this->createNotFoundException("Erreur knowledge.");
        }
        if (null === $example = $knowledge->getArticle()) {
            $example = new Article();
            $example->setTitle($knowledge->getTitle());
            $example->setType('example');
            $example->setKnowledge($knowledge);
        }

        $example_form = $this->createForm(ExampleType::class, $example);
        $example_form->handleRequest($request);
        if ($example_form->isSubmitted() && $example_form->isValid()) {
            $em->persist($example);
            $em->flush();
            $example->getId();
            return $this->redirectToRoute('admin_dashboard', ['_fragment' => 'exemple_' . $example->getId()]);
        }

        return $this->render('admin/example_form.html.twig', [
            'example_form' => $example_form->createView(),
        ]);
    }

    /**
     * Delete Article (presentation, website or example)
     * @Route("/{type}/suppr/{id}", name="_article_suppr")
     * @param int $id
     * @param string $type
     */
    public function deleteArticle(string $type, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        if (is_int($id)) {
            if (null === $article = $em->getRepository(Article::class)->find($id)) {
                throw $this->createNotFoundException("Erreur article.");
            } else {
                if ($type === 'exemple') {
                    $type_id = $article->getKnowledge()->getId();
                    $type = 'knowledge_' . $type_id;
                } else {
                    $type .= 's';
                }
                $em->remove($article);
                $em->flush();
                return $this->redirectToRoute('admin_dashboard', ['_fragment' => $type]);
            }
        } else {
            return $this->redirectToRoute('admin_dashboard');
        }
    }
}
