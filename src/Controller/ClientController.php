<?php

namespace App\Controller;
use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{

#[Route('/client', name: 'app_client')]
   
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
         $jobRepository=$em->getRepository(Client::class);
        $client = new Client();
        $client->setnom('mohsen tounssi');
        $client->setnbrpersonne(4);
        $client->setemail("mohsen@gmail.com");
        return $this->render('client/index.html.twig', [
            'id' =>$client->getId(),
        ]);
    }
    #[Route('/client/{id}', name: 'client_show')]
    public function show()
    {
                $client = $this->getDoctrine()->getManager();
                $repo=$client ->getRepository( Client::class);
                $M=$repo->findAll();
        return $this->render('client/show.html.twig', [
            'M' => $M
     ]);
     }
   
}
