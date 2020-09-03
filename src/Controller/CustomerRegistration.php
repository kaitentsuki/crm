<?php


namespace App\Controller;

use App\Entity\Customer;
use App\Entity\LoyaltyCard;
use App\Form\CustomerForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CustomerRegistration extends AbstractController
{

    /**
     * @Route("/customer-register", name="customer_registration")
     */
    public function registerCustomer(Request $request) {
        $customer = new Customer();
        $form = $this->createForm(CustomerForm::class, $customer);
        $entityManager = $this->getDoctrine()->getManager();

        $cards = $entityManager->getRepository(LoyaltyCard::class)->findAll();
        $customers = $entityManager->getRepository(Customer::class)->findAll();

        /** Vyber pouze vernostnich karet ktere patri k zakaznikovi*/
        foreach ($cards as $index=>$card) {
            foreach ($customers as $item) {

                if($card->getId() === $item->getLoyaltyCard()->getId()) {
                    unset($cards[$index]);
                }
            }
        }

        $form->add("loyalty_card", ChoiceType::class, [
            'choices' => $cards,
            'choice_value' => 'id',
            'choice_label' => 'number',
            'placeholder' => 'Choose a card'
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** Nahrani entity do DB */
            $entityManager->persist($customer);
            $entityManager->flush();

            return $this->redirectToRoute("customer_registration");

        }

        return $this->render(
            'customer/registration.html.twig',
            array('form' => $form->createView())
        );
    }

}