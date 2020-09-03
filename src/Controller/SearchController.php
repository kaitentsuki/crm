<?php


namespace App\Controller;


use App\Entity\Customer;
use App\Entity\LoyaltyCard;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SearchForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{

    /**
     * @Route("/search", name="search")
     */

    public function renderSearch(Request $request) {
        $form = $this->createForm(SearchForm::class);

        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);

        $results = [];


        if ($form->isSubmitted() && $form->isValid()) {

            $form_choice = $form->getData();

            switch ($form_choice["search_by"]) {
                case 0:
                    $results = $em->getRepository(Customer::class)->findBy(['firstname' => $form_choice["search_input"]]);
                    break;
                case 1:
                    $results = $em->getRepository(Customer::class)->findBy(['lastname' => $form_choice["search_input"]]);
                    break;
                case 2:
                    $cardRepo = $em->getRepository(LoyaltyCard::class)->findOneBy(['number' => $form_choice["search_input"]]);

                    $results = $em->getRepository(Customer::class)->findBy(['loyalty_card' => $cardRepo]);
                    break;
            }

        }

        return $this->render(
            'search/search.html.twig',
            array('form' => $form->createView(), 'results' => $results)
        );
    }

}