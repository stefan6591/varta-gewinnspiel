<?php

namespace App\Controller\Admin;

use App\Entity\Contest;
use App\Form\Admin\Type\ContestType;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContestController extends AbstractController
{
    /**
     * @Route("/admin/contest", name="admin_contest")
     */
    public function index()
    {
        return $this->render('admin/contest/index.html.twig', [
            'contests' => $this->getDoctrine()->getRepository('App:Contest')->findBy([], ['date' => 'asc']),
        ]);
    }

    /**
     * @Route("/admin/contest/create", name="admin_contest_create")
     */
    public function create(Request $request)
    {
        $contest = new Contest();
        $form = $this->createForm(ContestType::class, $contest);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

//            $date = $form->get('date')->getData();
//            $startDatetime = \DateTime::createFromFormat('d.m.Y H:i:s', $date . ' 00:00:00');
//            $contest->setDate($date);

            $this->getDoctrine()->getManager()->persist($contest);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_contest');
        }

        return $this->render('admin/contest/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
