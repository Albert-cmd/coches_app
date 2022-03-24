<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller\AbstractController
{
    /**
     * @Route("/",name="home")
     */
     public function indexAction(){

           return $this->render('default/home.html.twig');

     }

}