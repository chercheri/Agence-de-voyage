<?php

namespace App\Controller;

use App\Entity\Circuit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ProgrammationCircuit;

class FrontofficeHomeController extends AbstractController
{
    
    /**
     * @Route("/home", name="front_home")
     */
    public function liste_circuit()
    {
        $em=$this->getDoctrine()->getManager();
        $prog=$em->getRepository(ProgrammationCircuit::class)->findBy(array(),array('dateDepart' =>'desc'));
        $prognew=$em->getRepository(ProgrammationCircuit::class)->findBy(array(),array('dateDepart' =>'desc'),3,0);
        $circuit=$em->getRepository(Circuit::class)->findAll();
        $likes = $this->get('session')->get('likes');
        //dump($likes);
        //dump($prognew);
        return $this->render('front/home.html.twig', [
            'circuits_prog'=>$prog,
            'likes'=>$likes,
            'prognew'=>$prognew,
            'Ncircuits'=>$circuit,
        ]);
    }
    /**
    * @Route("/circuit/{id}", name="front_circuit_show")
    */
    public function circuitShow($id){
        $em=$this->getDoctrine()->getManager();
        $circuit_prog=$em->getRepository(ProgrammationCircuit::class)->find($id);
        return $this->render('front/circuit_show.html.twig',['circuit_prog'=>$circuit_prog,] );
    }
    /**
     * @Route("/likes/{id}", name="front_likes")
     */
    public function getLikes($id){       
        $likes = $this->get('session')->get('likes',[]);
        // si l'identifiant n'est pas présent dans le tableau des likes, l'ajouter
        if (! in_array($id, $likes) )
        {
            $likes[] = $id;
        }
        else
        // sinon, le retirer du tableau
        {
            $likes = array_diff($likes, array($id));
        }
        $likes = $this->get('session')->set('likes',$likes);
        return $this->redirectToRoute('front_home');
    }
    
    /**
     * @Route("/panier", name="panier")
     */
    public function panier()
    {
        $em=$this->getDoctrine()->getManager();
        $likes = $this->get('session')->get('likes');
        $circuits=array();
        if($likes==null){
            $this->get('session')->set('likes', []);
        }
        else{
            foreach($likes as $id)
            {
              array_push($circuits,$em->getRepository(ProgrammationCircuit::class)->find($id));
            }
        }
        return $this->render('front/panier.html.twig', [
            'circuits_like'=>$circuits,
            'likes'=>$likes,
        ]);
        
    }
}
