<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Knowledge;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'knowledges' => [],
        ]);
    }
    /**
     * Home
     * @Route("/", name="home")
     * @return Response
     */
    public function dashboard(): Response
    {
        $em = $this->getDoctrine()->getManager();
 
        if (null === $competences = $em->getRepository(Knowledge::class)->findBy(['activate'=>true, 'domain'=>'competence'], ['title'=>'ASC'])) {
            $competences = [];
        }
        if (null === $connaissances = $em->getRepository(Knowledge::class)->findBy(['activate'=>true, 'domain'=>'connaissance'], ['title'=>'ASC'])) {
            $connaissances = [];
        }
        if (null === $presentation = $em->getRepository(Article::class)->findOneBy(['activate'=>true])) {
            $presentation = [];
        }
        return $this->render('home/index.html.twig', [
            'competences' => $competences,
            'connaissances' => $connaissances,
            'presentation' => $presentation,
        ]);
    }
}
