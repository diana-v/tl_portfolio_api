<?php

namespace App\Controller;

use App\Entity\BlogPosts;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getRepository(BlogPosts::class);

        return $this->json($entityManager->findAll());
    }

    /**
     * @Route("/blog/new", name="new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function new(Request $request)
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $blog = new BlogPosts();
        $blog->setDate(new \DateTime());
        $blog->setTitle($request->get('title'));
        $blog->setContent($request->get('content'));
        $blog->setImage($request->get('image'));

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($blog);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->json([
            'message' => 'Success',
            'id' => $blog->getId(),
        ]);
    }
    /**
     * @Route("/blog/{id}", name="show")
     */
    public function show($id)
    {
        $blogEntry = $this->getDoctrine()
            ->getRepository(BlogPosts::class)
            ->find($id);

        if (!$blogEntry) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return $this->json([
            'id' => $blogEntry->getId(),
            'title' => $blogEntry->getTitle(),
            'date' => $blogEntry->getDate(),
            'image' => $blogEntry->getImage(),
            'content' => $blogEntry->getContent(),
        ]);

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }
}
