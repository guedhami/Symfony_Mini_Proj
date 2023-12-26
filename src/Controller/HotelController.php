<?php

namespace App\Controller;
use App\Entity\Client;
use App\Entity\Hotel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\HotelType;




class HotelController extends AbstractController
{
   
    #[Route('/Hotel/{id}', name: 'Hotel_show')]
    
    public function show($id)
{
                $em = $this->getDoctrine()->getManager();
                $hotelRepository=$em ->getRepository(Hotel::class);
                $hotel=$hotelRepository->findAll();

                $el = $this->getDoctrine()->getManager();
                $listClient=$el->getRepository(Client::class);
                $m=$hotelRepository->findby(['hotel'=>$hotel]);
                if (!$hotel) {
                    throw $this->createNotFoundException(
                    'No Hotel found for id '.$id
                    );
                    }

                 return $this->render('Hotel/show.html.twig', [
                  'listClient'=> $listClient,
                  'h' =>$hotel
 ]);
 }
     
 #[Route('/ajouter', name: 'Ajouter')]
public function ajouter(Request $request)

{
    $client = new Client();
    $fb = $this->createFormBuilder($client)
    ->add('Nom',TextType::class)
    ->add('nbrPersonne',IntegerType::class)
    ->add('email',TextType::class)
    ->add('Hotel',EntityType::class,['class'=>Hotel::class,'choice_label'=>'NomHôtel',])
    ->add('Valider',SubmitType::class);
    $form=$fb->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted()){
        $em = $this->getDoctrine()->getManager();
        $em->persist($client);
        $em->flush();
        return $this->redirectToRoute('home');
    }
    return $this->render('Hotel/ajout.html.twig',['f'=>$form->createView()]);
}
/**
 * @Route("/add", name="ajout_Hotel")
 */
public function ajouter2(Request $request)
{
    $hotel = new Hotel();
    $form = $this->createForm("App\Form\HotelType", $hotel);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($hotel);
        $em->flush();
        return $this->redirectToRoute('Accueil');
    }

    return $this->render('Hotel/ajout.html.twig', ['f' => $form->createView()]);
}




/**  
*@Route("/", name="home")*/
public function home(Request $request){
    $form = $this->createFormBuilder()
    ->add("critere",TextType::class)
    ->add("valider",SubmitType::class)
    ->getForm();
    $form->handleRequest($request);
    
    $em = $this->getDoctrine()->getManager();
    $repo = $em->getRepository(Client::class);
    $lesclients = $repo->findAll();
    if ($form->isSubmitted())
    {
        $data = $form->getData();
        $lesclients = $repo->recherche($data['critere']);
    }
return $this->render('Hotel/home.html.twig', ['lesClients' => $lesclients,'form'=>$form->createView()]);
}


/**
 *@Route("/supp{id}",name="cand_delete")
 */
public function delete(Request $request, $id): Response
    {$c = $this->getDoctrine()->getRepository(Client::class)->find($id);

    if (!$c) {
        throw $this->createNotFoundException('No Client found for id ' . $id);
    }
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($c);
    $entityManager->flush();

    return $this->redirectToRoute('home');
}
/**
 * @Route("/listehotel", name="liste")
 */
public function listehotel(){
    $em = $this->getDoctrine()->getManager();
    $repo = $em->getRepository(Hotel::class);
    $lesHotel = $repo->findAll();
    return $this->render('Hotel/liste.html.twig', [
        'leshotels' => $lesHotel
    ]);
}


/**
* @Route("/editU/{id}", name="edit_user")
* Method({"GET","POST"})
*/
public function edit(Request $request, $id)
{ $client = new Client();
    $client = $this->getDoctrine()
->getRepository(client::class)
->find($id);
if (!$client) {
throw $this->createNotFoundException(
'No client found for id '.$id
);
}
$fb = $this->createFormBuilder($client)
->add('nom', TextType::class)
->add('nbrpersonne', TextType::class)
->add('email', TextType::class)
->add('Hotel',EntityType::class,['class'=>Hotel::class,'choice_label'=>'NomHôtel',])
->add('Valider', SubmitType::class);
// générer le formulaire à partir du FormBuilder
$form = $fb->getForm();
$form->handleRequest($request);
if ($form->isSubmitted()) {
$entityManager = $this->getDoctrine()->getManager();
$entityManager->flush();
return $this->redirectToRoute('home');
}
return $this->render('Hotel/ajout.html.twig',
['f' => $form->createView()] );
}

}

