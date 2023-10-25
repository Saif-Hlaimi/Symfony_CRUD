<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AuthorRepository;
use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\AuthorType;

// src/Controller/AuthorController.php
// src/Controller/AuthorController.php





class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/author', name: 'app_author')]
    public function list()
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
            'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
            ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
            'taha.hussein@gmail.com', 'nb_books' => 300),
            );


            return $this->render('author/list.html.twig', [
                'authors' => $authors,
            ]);
    }



    #[Route('/authordet/{id}', name: 'app_authorid')]
    public function authorDetails($id)
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
            'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
            ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
            'taha.hussein@gmail.com', 'nb_books' => 300),
        );
    
        foreach ($authors as $author) {
            if ($author['id'] == $id)  {
                return $this->render('author/showAuthor.html.twig', [
                    'author' => $author,
                ]);
            }
        }
    
        // Handle case where no author is found with the given id
        throw $this->createNotFoundException('No author found for id '.$id);
    }

    #[Route('/authoraff', name: 'affauthor')]
    public function read(AuthorRepository $AuthorRepo){
        $author = $AuthorRepo->findAll();
         
    }


    #[Route("/authors", name:"author_index")]
    public function show(AuthorRepository $authorRepository): Response
    {
        $authors = $authorRepository->findAll();

        return $this->render('author/table.html.twig', [
            'affiche_donne' => $authors,
        ]);
    }

    #[Route("/addau", name:"author_add")]
    public function addAuthorStatic(EntityManagerInterface $entityManager): Response
    {
        // Créez un nouvel auteur avec des données statiques
        $author = new Author();
        $author->setUsername('Auteur Statique');
        $author->setEmail('auteur@example.com');

        // Persistez l'auteur en base de données
        $entityManager->persist($author);
        $entityManager->flush();

        return new Response('Auteur ajouté avec succès (statique) !');
    }


    #[Route("/addform", name:"addform")]
    public function adddStatic(ManagerRegistry $doctrine,Request $request)
    {
        $em=$doctrine -> getManager();
            $author=new Author();
          //  $author->setUsername('dali');
           // $author->setEmail('dalir@example.com');
           $form = $this->createForm(AuthorType::class, $author);

           $form->handleRequest($request);
           if ($form->isSubmitted())
           {
            $em->persist($author);
            $em->flush();

           }




           return $this->render('author/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
}


#[Route('/delete/{ide}', name: "delete")]
    public function deleteAuthor($ide, AuthorRepository $repo, ManagerRegistry $manager)
    {

        $author = $repo->find($ide);

        $em = $manager->getManager();   


        $em->remove($author);
        $em->flush();

        return $this->redirectToRoute("author_index");
    }


    #[Route('/edit/{ide}',name: "edit")]
    public function editAuthor($ide, AuthorRepository $repo,ManagerRegistry $manager,Request $req){
    
        $author = $repo->find($ide);
        $form = $this->createForm(AuthorType::class,$author);
        $form ->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
       $manager->getManager()->flush();
    return $this->redirectToRoute("author_index");
        }
    
    return $this->renderForm('author/edit.html.twig',[
        'forme'=>$form
    ]);
    
    }




}