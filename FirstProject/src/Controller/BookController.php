<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchBookFormType;
use App\Form\SearchUserFormType;
use App\Repository\UserRepository;

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BookController extends AbstractController
{



    #[Route('/addbook', name: "add_book")]
    public function addBook(ManagerRegistry $manager, Request $req)
    {


        $em = $manager->getManager();
        $book = new Book();

        $book->setPublished(true);

        $form = $this->createForm(BookType::class,  $book);

        $form->handleRequest($req);
        if ($form->isSubmitted()) {

            $nb =  $book->getAuthor()->getNb_books() + 1;

            $book->getAuthor()->setNb_books($nb);

            $em->persist($book);
            $em->flush();
        }
        return $this->renderForm("book/add.html.twig", ["f" => $form]);
    }


    #[Route('/listBooks', name: "list_books")]
    public function listBooks(BookRepository $repo)
    {
        return $this->render("book/list.html.twig", ["books" => $repo->findAll()]);
    }



    #[Route('/update/{id}', name: "update")]
    public function update($id, ManagerRegistry $manager, Request $req, BookRepository $repo)
    {
        $em = $manager->getManager();
        $book = $repo->find($id);

        $book->setPublished(true);

        $form = $this->createForm(BookType::class,  $book);

        $form->handleRequest($req);
        if ($form->isSubmitted()) {

            $em->persist($book);
            $em->flush();
        }
        return $this->renderForm("book/update.html.twig", ["f" => $form]);
    }

   /* #[Route('/books', name: "book_list")]
    public function search(Request $request, BookRepository $bookRepository)
    {
        $searchForm = $this->createForm(SearchUserFormType::class);
        $searchForm->handleRequest($request);
    
        $user = null;
    
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $username = $searchForm->get('username')->getData();
            $user = $bookRepository->searchUserByUsername($username);
        }
    
        return $this->render('chercher.html.twig', [
            'user' => $user,
            'searchForm' => $searchForm->createView(),
        ]);
        
    }*/

    #[Route('/deleteBook/{id}', name: "delete_book")]
    public function delete($id, ManagerRegistry $manager, BookRepository $repo, AuthorRepository $authorRepo)
    {
        $em = $manager->getManager();
        $book = $repo->find($id);
    
        $author = $book->getAuthor();
        $nb = $author->getNb_books() - 1;
        $author->setNb_books($nb);
    


            $book->getAuthor()->setNb_books($nb);
            if ($nb === 0) {
                $em->remove($author);
            }

        $em->remove($book);
        $em->flush();
        return $this->redirectToRoute("list_books");
    }
    #[Route('/showBook/{id}', name: "show_book")]
    public function showBook($id, BookRepository $repo)
    {
        $book = $repo->find($id);
        return $this->render("book/show.html.twig", ["book" => $book]);
    }


   #[Route('/book/search', name: "book_search")]
    public function search(Request $request, BookRepository $bookRepository): Response
    {
        $query = $request->query->get('query'); // Récupère la chaîne de recherche depuis la requête GET

        // Utilisez la méthode de recherche du repository pour trouver les livres correspondants
        $books = $bookRepository->searchBooks($query);

        return $this->render("book/search.html.twig", [
            'books' => $books,
            'query' => $query,
        ]);
    }
   
}