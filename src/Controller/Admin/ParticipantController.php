<?php

namespace App\Controller\Admin;

use App\Entity\Contest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    /**
     * @Route("/admin/participant/{contest}", name="admin_participant")
     */
    public function index(Request $request, Contest $contest)
    {
        $participansts = $this->getDoctrine()->getRepository('App:ContestParticipant')->findBy([
            'contest' => $contest
        ]);

        return $this->render('admin/participant/index.html.twig', [
            'contest' => $contest,
            'participants' => $participansts,
        ]);
    }
}
