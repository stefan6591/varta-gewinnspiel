<?php

namespace App\Controller\Admin;

use App\Entity\Contest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ParticipantController extends AbstractController
{
    /**
     * @Route("/admin/participant/{contest}/{page}", name="admin_participant")
     */
    public function index(Request $request, Contest $contest, int $page = 1)
    {
        $maxPerPage = 20;
        $qb = $this->getDoctrine()->getRepository('App:ContestParticipant')->createQueryBuilder('p')
            ->where('p.contest = :contest')->setParameter('contest', $contest)
            ->orderBy('p.createdAt', 'desc')
        ;

        $paginator = new Paginator($qb->getQuery());
        $maxPages = ceil($paginator->count() / $maxPerPage);

        if ($maxPages < 1) {
            $maxPages = $maxPerPage;
        }

        if ($page < 1) {
            $page = 1;
        }

        $participansts = $paginator
            ->getQuery()
            ->setMaxResults($maxPerPage)
            ->setFirstResult(($page - 1) * $maxPerPage)
            ->getResult()
        ;

        return $this->render('admin/participant/index.html.twig', [
            'contest' => $contest,
            'participants' => $participansts,
            'page' => $page,
            'maxPages' => $maxPages
        ]);
    }
}
