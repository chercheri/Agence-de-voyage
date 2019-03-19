<?php

namespace App\Controller;

use App\Entity\Res;
use App\Form\ResType;
use App\Repository\ResRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\ProgrammationCircuit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;



/**
 * @Route("/res")
 */
class ResController extends AbstractController
{
    /**
     * @Route("/", name="res_index", methods="GET")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(ResRepository $resRepository): Response
    {
        return $this->render('res/index.html.twig', ['res' => $resRepository->findAll()]);
    }

    /**
     * @Route("/{id}/new", name="res_new", methods="GET|POST")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request ,$id,ProgrammationCircuit $circuit): Response
    {
        $re = new Res();
        $form = $this->createForm(ResType::class, $re);
        $form->handleRequest($request);
        $re->setProgCir($id);
        $repo = $this->getDoctrine()->getRepository('App:ProgrammationCircuit');
        $found = $repo->find($id);
        $found->setNombrePersonnes($found->getNombrePersonnes()-1);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($re);
            $em->flush();

            return $this->redirectToRoute('front_circuit_show', ['id'=> $id ] );
        }

        return $this->render('res/new.html.twig', [
            're' => $re,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="res_show", methods="GET")
     * @IsGranted("ROLE_ADMIN")
     */
    public function show(Res $re): Response
    {
        return $this->render('res/show.html.twig', ['re' => $re]);
    }

    /**
     * @Route("/{id}/edit", name="res_edit", methods="GET|POST")
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Res $re): Response
    {
        $form = $this->createForm(ResType::class, $re);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('res_edit', ['id' => $re->getId()]);
        }

        return $this->render('res/edit.html.twig', [
            're' => $re,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="res_delete", methods="DELETE")
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Res $re): Response
    {
        if ($this->isCsrfTokenValid('delete'.$re->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($re);
            $em->flush();
        }

        return $this->redirectToRoute('res_index');
    }
}
