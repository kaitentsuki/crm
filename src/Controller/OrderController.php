<?php


namespace App\Controller;

use App\Entity\Item;
use App\Form\OrderForm;
use App\Entity\Order;
use App\Entity\LoyaltyCard;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class OrderController extends AbstractController
{
    /**
     * @Route("order-create", name="order_create")
     */

    function createOrder(Request $request) {

        $order = new Order();
        $form = $this->createForm(OrderForm::class, $order);
        $entityManager = $this->getDoctrine()->getManager();
        $items = $entityManager->getRepository(Item::class)->findAll();
        $cards = $entityManager->getRepository(LoyaltyCard::class)->findAll();

        $form->add("loyalty_card", ChoiceType::class, [
            'choices' => $cards,
            'choice_value' => 'id',
            'choice_label' => 'number',
            'placeholder' => 'Choose a card'
        ]);

        $form->add("items", ChoiceType::class, [
            'choices' => $items,
            'choice_value' => 'id',
            'choice_label' => function(Item $item) {
                return $item->getAmount()."x  ".$item->getDescription()." - ".$item->getPricePerUnit()."Kč/ks";
            },
            'multiple' => true,
            'placeholder' => 'Choose items'
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $encoder = [new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];

            $serializer = new Serializer($normalizers, $encoder);
/*
            $serializedItems = $serializer->serialize($form->get("items")->getData(), 'json');

            $order->setItems($serializedItems);*/

            $entityManager->persist($order);
            $entityManager->flush();

//            return $this->redirectToRoute("order_create");
        }


        return $this->render(
            'order/order_create.html.twig',
            array('form' => $form->createView())
        );
    }
}