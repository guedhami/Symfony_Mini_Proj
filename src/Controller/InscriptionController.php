<?php // src/Controller/InscriptionController.php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

Class InscriptionController extends AbstractController{
    /**
 * @Route("/number")
 */
public function voirAction($id){
    return $this->render('Inscription/voir.html.twig',
    array('id'=>$id));
    }
   
 public function number()
 {
 $number = random_int(0, 100);
 return $this->render('Inscription/accueil.html.twig', [
    'number' => $number,
    ]);
   ;
 }
}
?>