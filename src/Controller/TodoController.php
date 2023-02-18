<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'app_todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        // Afficher notre tableau de todo
        // sinon je l'initialise puis je l'affiche
        if (!$session->has('todos')) {
            $todos = [
                'achat'=>'acheter clé usb',
                'cours'=>'Finaliser mon cours',
                'correction'=>'corriger mes examens'
            ];
            $session->set('todos', $todos);
            $this->addFlash('info', "La liste des todos viens d'être initialisée");
        }
        // si j'ai mon tableau de todo dans ma session je ne fait que l'afficher
        return $this->render('todo/index.html.twig');
    }

    #[Route('/todo/add/{name}/{content}', name: 'app_add_todo')]
    public function addTodo(Request $request, $name, $content){
        $session = $request->getSession();
        // Vérifier si j'ai mon tableau de todo dans la session
        if ($session->has('todos')) {
            // si oui
            // Verifier si on a déjà un tableau de todo avec le meme name
            $todos = $session->get('todos');
            if (isset($todos[$name])){
                // si oui afficher erreur
                $this->addFlash('error', "Le todo d'id $name existe déjà dans la liste");
            } else {
                // si non on l'ajoute et on affiche un message de succés
                $todos[$name] = $content;
                $this->addFlash('success', "Le todo d'id $name a été ajouté avec succés");
                $session->set('todos', $todos);
            }

            

        } else {
            // si non 
            // afficher une erreur et on va rediriger vers le controlleur index
            $this->addFlash('error', "La liste des todos n'est pas encore initialisée");
        }
        return $this->redirectToRoute('app_todo');
    }

    #[Route('/todo/update/{name}/{content}', name: 'app_update_todo')]
    public function updateTodo(Request $request, $name, $content){
        $session = $request->getSession();
        // Vérifier si j'ai mon tableau de todo dans la session
        if ($session->has('todos')) {
            // si oui
            // Verifier si on a déjà un tableau de todo avec le meme name
            $todos = $session->get('todos');
            if (!isset($todos[$name])){
                // si oui afficher erreur
                $this->addFlash('error', "Le todo d'id $name n'existe pas dans la liste");
            } else {
                // si non on l'ajoute et on affiche un message de succés
                $todos[$name] = $content;
                $this->addFlash('success', "Le todo d'id $name a été modifié avec succés");
                
            }
            

        } else {
            // si non 
            // afficher une erreur et on va rediriger vers le controlleur index
            $this->addFlash('error', "La liste des todos n'est pas encore initialisée");
        }
        return $this->redirectToRoute('app_todo');
    }

    #[Route('/todo/delete/{name}', name: 'app_delete_todo')]
    public function deleteTodo(Request $request, $name){
        $session = $request->getSession();
        // Vérifier si j'ai mon tableau de todo dans la session
        if ($session->has('todos')) {
            // si oui
            // Verifier si on a déjà un tableau de todo avec le meme name
            $todos = $session->get('todos');
            if (!isset($todos[$name])){
                // si oui afficher erreur
                $this->addFlash('error', "Le todo d'id $name n'existe pas dans la liste");
            } else {
                // si non on l'ajoute et on affiche un message de succés
                unset($todos[$name]);
                $session->set('todos', $todos);
                $this->addFlash('success', "Le todo d'id $name a bien été supprimé avec succés");
            }

            

        } else {
            // si non 
            // afficher une erreur et on va rediriger vers le controlleur index
            $this->addFlash('error', "La liste des todos n'est pas encore initialisée");
        }
        return $this->redirectToRoute('app_todo');
    }

    #[Route('/todo/reset', name: 'app_reset_todo')]
    public function resetTodo(Request $request){
        $session = $request->getSession();
        $session->remove('todos');
        return $this->redirectToRoute('app_todo');
    }
}
