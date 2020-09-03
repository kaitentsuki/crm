<?php


namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    /**
    * @Route("/", name="dashboard")
    */
    public function dashboardRender()
    {

        return $this->render('homepage/dashboard.html.twig');
    }



}