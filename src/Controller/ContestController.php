<?php

namespace App\Controller;

use App\Entity\Contest;
use App\Entity\ContestParticipant;
use App\Form\Type\ContestParticipantType;
use phpDocumentor\Reflection\Types\This;
use App\Form\Type\ContestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ContestController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('contest/index.html.twig', [
            'controller_name' => 'ContestController',
        ]);
    }

    /**
     * @Route("/contest", name="contest")
     */
    public function contest(Request $request)
    {
        /** @var Contest $contest */
        $contest = $this->getDoctrine()->getRepository('App:Contest')->findCurrentContest();

        if($contest === null){
            throw new NotFoundHttpException('Contest not found');
        }

        $contestParticipant = new ContestParticipant();
        $contestParticipant->setContest($contest);
        $form = $this->createForm(ContestType::class, [
            'participant' => $contestParticipant
        ], [
            'type' => $contest->getType()
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $this->getDoctrine()->getManager()->persist($contestParticipant);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contest_success');
        }

        return $this->render('contest/contest.html.twig', [
            'contest' => $contest,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/contest/success", name="contest_success")
     */
    public function success()
    {
        return $this->render('contest/success.html.twig', [
            'controller_name' => 'ContestController',
        ]);
    }
}
