<?php

namespace App\Controller;

use App\Entity\Contest;
use App\Entity\ContestParticipant;
use App\Event\ContestParticipationSuccessEvent;
use App\Form\Type\ContestParticipantType;
use phpDocumentor\Reflection\Types\This;
use App\Form\Type\ContestType;
use App\Listener\ContestParticipationListener;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ContestController extends AbstractController
{
    private $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

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
        $from = \DateTime::createFromFormat('Y-m-d', $contest->getStartDate())->setTime(0,0,0);
        $to = \DateTime::createFromFormat('Y-m-d', $contest->getEndDate())->setTime(23,59,59);

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

                /*if($form->get('newsletter')->getData() === true){
                    $this->dispatcher->dispatch(
                        ContestParticipationSuccessEvent::NAME,
                        new ContestParticipationSuccessEvent($contestParticipant)
                    );
                }*/

                return $this->redirectToRoute('contest_success', [
                    'contest' => $contest->getId()
                ]);
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
     * @Route("/contest/{contest}/success", name="contest_success")
     */
    public function success(Request $request, Contest $contest)
    {
        return $this->render('contest/success.html.twig', [
            'controller_name' => 'ContestController',
        ]);
    }
}
