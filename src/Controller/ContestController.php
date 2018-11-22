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
     * @Route("/contest/{contest}", name="contest")
     */
    public function contest(Request $request, Contest $contest)
    {
        if($contest === null){
            throw new NotFoundHttpException('Contest not found');
        }

        $now = new \DateTime();
        $from = \DateTime::createFromFormat('Y-m-d', $contest->getStartDate());
        $to = \DateTime::createFromFormat('Y-m-d', $contest->getEndDate());
        $from->setTime(0,0,0);
        $to->setTime(23,59,59);

        if($now >= $from && $now <= $to){

            $contestParticipant = new ContestParticipant();
            $contestParticipant->setContest($contest);
            $form = $this->createForm(ContestType::class, [
                'participant' => $contestParticipant
            ], [
                'type' => $contest->getType(),
                'questionId' => $contest->getQuestion() !== null ? $contest->getQuestion()->getId() : null
            ]);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){

                if($contest->getType() === Contest::TYPE_RADIO){
                    $contestParticipant->setProvidedAnswer($form->get('answer')->get('radio')->getData()->getTitle());
                }

                $this->getDoctrine()->getManager()->persist($contestParticipant);
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('contest_success');
            }

            return $this->render('contest/contest.html.twig', [
                'contest' => $contest,
                'form' => $form->createView()
            ]);
        }

        return $this->render('contest/no-contest.html.twig', [
            'contest' => $contest,
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
