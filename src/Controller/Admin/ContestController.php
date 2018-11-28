<?php

namespace App\Controller\Admin;

use App\Entity\Contest;
use phpDocumentor\Reflection\Types\This;
use App\Entity\Question;
use App\Entity\QuestionAnswer;
use App\Form\Admin\Type\ContestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContestController extends AbstractController
{
    /**
     * @Route("/admin/contest", name="admin_contest")
     */
    public function index()
    {
        $deleteForms = array();

        $contests = $this->getDoctrine()->getRepository('App:Contest')->findBy([], ['startDate' => 'asc']);

        foreach ($contests as $contest) {
            $deleteForms[$contest->getId()] = $this->createDeleteForm($contest)->createView();
        }

        return $this->render('admin/contest/index.html.twig', [
            'contests' => $contests,
            'deleteForms' => $deleteForms,
            'types' => array_flip(Contest::$types)
        ]);
    }

    /**
     * @Route("/admin/contest/create", name="admin_contest_create")
     */
    public function create(Request $request)
    {
        $form = $this->createForm(ContestType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            /** @var Contest $contest */
            $contest = $form->getData();

            if($contest->getType() === Contest::TYPE_DEFAULT){
                $contest->setQuestion(null);
            } elseif ($contest->getType() === Contest::TYPE_RADIO) {
                /** @var QuestionAnswer $answer */
                foreach ($contest->getQuestion()->getAnswers() as $answer) {
                    $answer->setQuestion($contest->getQuestion());
                }
            }

            $this->getDoctrine()->getManager()->persist($contest);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_contest');
        }

        return $this->render('admin/contest/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/contest/edit/{contest}", name="admin_contest_edit")
     */
    public function edit(Request $request, Contest $contest)
    {
        $form = $this->createForm(ContestType::class, $contest);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            /** @var Contest $contest */
            $contest = $form->getData();

            if($contest->getType() === Contest::TYPE_DEFAULT){
                $contest->setQuestion(null);
            } elseif ($contest->getType() === Contest::TYPE_RADIO) {
                /** @var QuestionAnswer $answer */
                foreach ($contest->getQuestion()->getAnswers() as $answer) {
                    $answer->setQuestion($contest->getQuestion());
                }
            }

            $this->getDoctrine()->getManager()->persist($contest);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_contest');
        }

        return $this->render('admin/contest/edit.html.twig', [
            'form' => $form->createView(),
            'contest' => $contest,
        ]);
    }

    /**
     * @Route("/admin/contest/delete/{contest}", name="admin_contest_delete")
     */
    public function deleteAction(Request $request, Contest $contest)
    {
        $form = $this->createDeleteForm($contest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->remove($contest);
            $em->flush($contest);

            return $this->redirectToRoute('admin_contest');
        }

        return $this->redirectToRoute('admin_contest');
    }

    private function createDeleteForm(Contest $contest)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_contest_delete', array('contest' => $contest->getId())))
            ->setMethod('POST')
            ->add('Löschen', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-sm btn-danger'
                ]
            ])
            ->getForm()
        ;
    }
}
