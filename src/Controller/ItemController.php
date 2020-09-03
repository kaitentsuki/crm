<?php


namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemForm;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{

    /**
     * @Route("/add-item", name="add_item")
     */
    public function createItem(Request $request) {
        $item = new Item();
        $form = $this->createForm(ItemForm::class, $item);

        $entityManager = $this->getDoctrine()->getManager();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($item);
            $entityManager->flush();


            return $this->redirectToRoute("add_item");
        }

        return $this->render(
            'item/item_add.html.twig',
            array('form' => $form->createView())
        );
    }

}