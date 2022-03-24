<?php

namespace App\Controller;

use App\Entity\Coches;
use App\Entity\Marcas;
use App\Form\CochesType;
use App\Form\FilterMarcasType;
use App\Form\MarcasType;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarcaController extends AbstractController
{

    private $doctrine;

    public function __construct(ManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/marcas", name="marcas_list")
     */
    public function index(): Response
    {
        return $this->render('marca/list.html.twig', [
            'controller_name' => 'MarcaController',
        ]);
    }

    /**
     * @Route("/marcas/list", name="marcas_list")
     */
    public function list(Request $request , PaginatorInterface $paginator)
    {
      /*  $marcas = $this->doctrine
            ->getRepository(Marcas::class)
            ->findAll();*/

        //codi de prova per visualitzar l'array de clients
//        dump($coches);
        //      exit();
        $list = $this->doctrine->getRepository(Marcas::class)->findAll();

        $marcas = $paginator->paginate(
            $list,
            $request->query->getInt('page',1),
            $this->getParameter('paginas')
        );

        return $this->render('marca/list.html.twig', ['marcas' => $marcas]);

    }


    /**
     * @Route("/marcas/new",name="marcas_new")
     */
    public function new (Request  $request){

        $marca = new Marcas ();
        $form = $this->createForm(MarcasType::class, $marca, array('submit'=>'Crear Marca'));

        $form->handleRequest($request);

        $coches =  $this->getDoctrine()->getRepository(Marcas::class)->findAll();

        if ($form->isSubmitted()&&$form->isValid()){

            $em = $this->getDoctrine()->getManager();
            // gestionamos el timestamp:
            /* $now = date_create()->format('Y-m-d H:i:s');
             $datetime = \DateTime::createFromFormat($now);*/
            $dateTime = new \DateTime();
            $dateTime->format('Y-m-d H:i:s');

            $marca->setFechaAlta($dateTime);
            $marca->setFechaModificacion($dateTime);

            $em->persist($marca);
            $em->flush();

            $this->addFlash(
                'notice',
                'Nueva marca  :'.$marca->getNombre().'registrada.'
            );

            return  $this->redirectToRoute('marcas_list');
        }
            return $this->render('marca/new.html.twig',
                array('form' => $form->createView(),'title'=>'Nueva marca')
            );
    }

    /**
     * @Route("/marcas/delete/{id}", name="marcas_delete", requirements={"id"="\d+"})
     */
    public function delete($id, Request $request)
    {
        $marca = $this->getDoctrine()
            ->getRepository(Marcas::class)
            ->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($marca);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Compte '.$marca->getNombre().' eliminado'
        );

        return $this->redirectToRoute('marcas_list');
    }



    /**
     * @Route("/marcas/edit/{id<\d+>}", name="marcas_edit")
     */
    public function edit($id, Request $request)
    {
        $coche = $this->getDoctrine()
            ->getRepository(Marcas::class)
            ->find($id);

        //podem personalitzar el text del botó passant una opció 'submit' al builder de la classe CompteType
        $form = $this->createForm(MarcasType::class, $coche, array('submit'=>'Desar'));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // recollim els camps del formulari en l'objecte compte
            $coche = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($coche);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                ' '.$coche->getId().'cambios guardados'
            );

            return $this->redirectToRoute('marcas_list');
        }

        return $this->render('marca/new.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Edita coche',
        ));
    }


    /**
     * @Route("/marcas/busca", name="marcas_busca")
     */
    public function find (Request $request, PaginatorInterface $paginator){
        // busqueda campos: Campos: nombre, año, activo y marca.
        $activos=false;
        if (isset($_REQUEST['activos'])) {
            $activos=  $_REQUEST['activos'];
        }
        if (isset($_REQUEST['searchterm'])) {
            $particula =   $_REQUEST['searchterm'];
        }

        if (!empty($particula)){
            if ($activos){

                $marcasList  = $this->doctrine->getRepository(Marcas::class)->findTermActive($particula);
            }else {
                $marcasList = $this->doctrine->getRepository(Marcas::class)->findTerm($particula);
            }
        }
        else{
            $marcasList = $this->doctrine->getRepository(Marcas::class)->findAll();
        }
        $marcas = $paginator->paginate(
            $marcasList,
            $request->query->getInt('page',1),
            $this->getParameter('paginas')
        );
        return $this->render('marca/list.html.twig', ['marcas' => $marcas]);

    }




    /**
     * @Route("/marcas/detail", name="marcas_detail")
     */
    public function busquedaDetallada(Request $request, PaginatorInterface $paginator){


        $form = $this->createForm(FilterMarcasType::class, array('submit'=>'Desar'));
        $form->handleRequest($request);


        if ($form->isSubmitted()&&$form->isValid()){
            // FILTROS DE BUSQUEDA DETALLADA:
            $busqueda = $form->getData();

            $nombre = $form->get('nombre')->getData();
            if (empty($nombre)){
                $nombre=null;
            }

            $activo = $form->get('activo')->getData();

            $list = $this->doctrine->getRepository(Marcas::class)->detailedSearch($nombre,$activo);

            $marcas = $paginator->paginate(
                $list,
                $request->query->getInt('page',1),
                $this->getParameter('paginas')
            );
            return $this->render('marca/list',['marcas' => $marcas]);
        }

        return $this->render('marca/find', array('form' => $form->createView(),'title'=>'Busqueda detallada'));

    }




}
