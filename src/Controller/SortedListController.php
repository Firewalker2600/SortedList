<?php


namespace App\Controller;

use App\Form\Insert;
use App\Form\InsertFormType;
use App\Service\SortedLinkedList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortedListController extends AbstractController
{
    #[Route('/', name:'homepage', methods: ['GET', 'POST'])]
    public function home(Request $request): Response
    {
        $session = $request->getSession();
        $intList = $session->get('intList') ?? new SortedLinkedList();
        $strList = $session->get('strList') ?? new SortedLinkedList();
        $insertForm = $this->createForm(InsertFormType::class, new Insert);
        $insertForm->handleRequest($request);

        if($insertForm->isSubmitted() && $insertForm->isValid()) {
            $data = $insertForm->getData();
            $integer = $data->integer ?? null;
            $string = $data->string ?? null;
            if($integer !== null) {
                $intList->insert($integer);
                $session->set('intList', $intList);
            }
            if($string !== null) {
                $strList->insert($string);
                $session->set('strList', $strList);
            }
            unset($insertForm);
            $insertForm = $this->createForm(InsertFormType::class, new Insert);
        }
        return $this->render('sortedlist/home.html.twig', [
            'intList' => $intList,
            'strList' => $strList,
            'insert_form' => $insertForm->createView()
        ]);
    }
    #[Route('/api/int-remove/{integer<-?\d+>}', name: 'int-remove', methods: ['DELETE'])]
    public function intRemove(Request $request, int $integer): Response
    {
        $session = $request->getSession();
        $intList = $session->get('intList');
        $intList->remove($integer);
        $session->set('intList', $intList);
        return new Response();
    }

    #[Route('/api/str-remove/{string<\w+>}', name: 'str-remove', methods: ['DELETE'])]
    public function strRemove(Request $request, string $string): Response
    {
        $session = $request->getSession();
        $strList = $session->get('strList');
        $strList->remove($string);
        $session->set('strList', $strList);
        return new Response();
    }
}