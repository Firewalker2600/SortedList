<?php

namespace App\Controller;

use App\Form\IntegerFormRequest;
use App\Form\IntegerFormType;
use App\Form\StringFormRequest;
use App\Form\StringFormType;
use App\Service\IntegerSortedLinkedList;
use App\Service\StringSortedLinkedList;
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
        $intList = $session->get('intList') ?? new IntegerSortedLinkedList();
        $strList = $session->get('strList') ?? new StringSortedLinkedList();
        $integerFormRequest = new IntegerFormRequest();
        $integerForm = $this->createForm(IntegerFormType::class, $integerFormRequest);
        $stringFormRequest = new StringFormRequest();
        $stringForm = $this->createForm(StringFormType::class, $stringFormRequest);
        $integerForm->handleRequest($request);
        $stringForm->handleRequest($request);

        try {
            if($integerForm->isSubmitted() && $integerForm->isValid()) {
                $integer = $integerFormRequest->integer;
                $intList->insert($integer);
                $session->set('intList', $intList);
            }

            if($stringForm->isSubmitted() && $stringForm->isValid()) {
                $string = $stringFormRequest->string;
                $strList->insert($string);
                $session->set('strList', $strList);
            }
        } catch (\InvalidArgumentException $exception) {
            $this->addFlash('error', $exception->getMessage());
        }

        unset($integerForm, $stringForm);
        $integerForm = $this->createForm(IntegerFormType::class, new IntegerFormRequest());
        $stringForm = $this->createForm(StringFormType::class, new StringFormRequest());
        return $this->render('sortedlist/home.html.twig', [
            'intList' => $intList,
            'strList' => $strList,
            'integer_form' => $integerForm->createView(),
            'string_form' => $stringForm->createView()
        ]);
    }
    #[Route('/api/int-remove/{integer<-?\d+>}', name: 'int-remove', methods: ['DELETE'])]
    public function intRemove(Request $request, int $integer): Response
    {
        $session = $request->getSession();

        /** @var IntegerSortedLinkedList $intList */
        $intList = $session->get('intList');
        $intList->remove($integer);
        $session->set('intList', $intList);
        return new Response();
    }

    #[Route('/api/str-remove/{string<\w+>}', name: 'str-remove', methods: ['DELETE'])]
    public function strRemove(Request $request, string $string): Response
    {
        $session = $request->getSession();

        /** @var StringSortedLinkedList $strList */
        $strList = $session->get('strList');
        $strList->remove($string);
        $session->set('strList', $strList);
        return new Response();
    }
}
