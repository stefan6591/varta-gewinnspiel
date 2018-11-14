<?php

namespace App\Controller;

use App\Entity\Contest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function contest()
    {
        $contest = $this->getDoctrine()->getRepository('App:Contest')->findCurrentContest();

        return $this->render('contest/contest.html.twig', [
            'contest' => $contest
        ]);
    }
}
