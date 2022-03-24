<?php
namespace App\Controller;
use App\Entity\Coches;
use App\Entity\Marcas;
use App\Form\CochesType;
use App\Form\FilterType;
use App\Repository\CochesRepository;
use App\Services\FileUploader;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;



/**
 * @ORM\Entity
 * @ORM\Table(name="coche_controller")
 */
class CocheController extends AbstractController
{
    public $doctrine;

    public function __construct(ManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/coche", name="coche")
     */
    public function index(): Response
    {
        return $this->render('coche/index.html.twig', [
            'controller_name' => 'CocheController',
        ]);
    }

    /**
     * @Route("/coches/list", name="coches_list")
     */
    public function list(Request $request , PaginatorInterface $paginator)
    {

        $cochesList =  Array();
        $coche = new Coches();
        $form = $this->createForm(FilterType::class, $coche, array('submit'=>'Filtrar'));
        $form->handleRequest($request);
        //dentro de la busqueda detallada buscamos filtrando con los parametros.
        // BUSQUEDA DETALLADA.
        if ($form->isSubmitted()&&$form->isValid()){

            // FILTROS DE BUSQUEDA DETALLADA:

            $nombre = $form->get('modelo')->getData();
            if (empty($nombre)){
                $nombre=null;
            }
            $ano = $form->get('ano')->getData();
            if (empty($ano)){
                $ano=null;
            }
            $activo = $form->get('activo')->getData();
            $marca= $form->get('marca')->getData();
            $marca=  $marca->getNombre();

            if (empty($marca)){
                $marca=null;
            }

            $query = $this->doctrine->getRepository(Coches::class)->detailedSearch($nombre,$ano,$activo,$marca);

            $coches = $paginator->paginate(
                $query, //mandamos la query.
                $request->query->getInt('page',1),
                $this->getParameter('paginas')
            );

            return $this->render('coche/list.html.twig',['coches' => $coches]);

        }

        return $this->render('coche/find.html.twig',
            array('form' => $form->createView(),'title'=>'Busqueda detallada')
        );

    }

    /**
     * @Route("/coches/listAll", name="coches_list_all")
     */
    public function listAll(Request $request , PaginatorInterface $paginator)
    {


        //dentro de la busqueda detallada buscamos filtrando con los parametros.
        // BUSQUEDA DETALLADA.

            $query = $this->doctrine->getRepository(Coches::class)->listAll();

            $coches = $paginator->paginate(
                $query,
                $request->query->getInt('page',1),
                $this->getParameter('paginas'));


            return $this->render('coche/list.html.twig',['coches' => $coches]);

        }







    /**
     * @Route("/coches/new",name="coches_new")
     */
    public function new (Request $request,SluggerInterface $slugger ,FileUploader $fileUploader){

        $coche = new Coches ();
        $form = $this->createForm(CochesType::class, $coche, array('submit'=>'Crear Coche'));

        $form->handleRequest($request);

       $coches =  $this->getDoctrine()->getRepository(Coches::class)->findAll();

        if ($form->isSubmitted()&&$form->isValid()){

            $em = $this->getDoctrine()->getManager();
            // gestionamos el timestamp:
           /* $now = date_create()->format('Y-m-d H:i:s');
            $datetime = \DateTime::createFromFormat($now);*/
            $dateTime = new \DateTime();
            $dateTime->format('Y-m-d H:i:s');

            if (empty($coche->getPropietario()) || !is_numeric($coche->getAno())){
                $this->addFlash('alert','Campo propietario incorrecto.');
                return $this->redirectToRoute('coches_new');
            }

            $archivo = $form['imagen']->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($archivo) {
                $originalFilename = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$archivo->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $archivo->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                  $str=  $e->getMessage();
                    echo ($str);
                    exit();
                }
                   $coche->setImagen($newFilename);
            }

            $coche->setFechaAlta($dateTime);
            $coche->setFechaModificacion($dateTime);

            $em->persist($coche);
            $em->flush();

            $this->addFlash(
                'notice',
                'Nuevo coche modelo :'.$coche->getModelo().'registrado.'
            );
            return  $this->redirectToRoute('coches_list');
        }
        return $this->render('coche/new.html.twig',
            array('form' => $form->createView(),'title'=>'Nuevo coche')
        );
    }

    /**
     * @Route("/coches/delete/{id}", name="coches_delete", requirements={"id"="\d+"})
     */
    public function delete($id, Request $request)
    {
        $coche = $this->getDoctrine()
            ->getRepository(Coches::class)
            ->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($coche);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Compte '.$coche->getId().' eliminado'
        );

        return $this->redirectToRoute('coches_list');
    }

    /**
     * @Route("/coches/edit/{id<\d+>}", name="coches_edit")
     */
    public function edit($id, Request $request, SluggerInterface $slugger)
    {
        $coche = $this->getDoctrine()
            ->getRepository(Coches::class)
            ->find($id);

        //podem personalitzar el text del botó passant una opció 'submit' al builder de la classe CompteType
        $form = $this->createForm(CochesType::class, $coche, array('submit'=>'Desar'));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // recollim els camps del formulari en l'objecte compte
            $coche = $form->getData();

            $archivo = $form['imagen']->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($archivo) {
                $originalFilename = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$archivo->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $archivo->move(
                        $this->getParameter('img_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    $str=  $e->getMessage();
                    echo ($str);
                    exit();
                }
                $coche->setImagen($newFilename);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($coche);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                ' '.$coche->getId().'cambios guardados'
            );

            return $this->redirectToRoute('coches_list');
        }
        return $this->render('coche/new.html.twig', array(
            'form' => $form->createView(),
            'title' => 'Edita coche',
        ));
    }
    /**
     * @Route("/coches/find", name="coches_busca")
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

            $cochesList = $this->doctrine->getRepository(Coches::class)->findTermActive($particula);
        }else {
            $cochesList = $this->doctrine->getRepository(Coches::class)->findTerm($particula);
        }
    }
    else{
       $cochesList = $this->doctrine->getRepository(Coches::class)->listAll();
    }
       $coches = $paginator->paginate(
           $cochesList,
           $request->query->getInt('page',1),
           $this->getParameter('paginas')
       );
       return $this->render('coche/list.html.twig', ['coches' => $coches]);

   }

    /**
     * @Route("/coches/listDetails", name="list_details")
     */
   /* public function listDetails(Request $request , PaginatorInterface $paginator)
    {

      //  $marcas = $this->doctrine->getRepository(Marcas::class)->findAll();

        $form = $this->createForm(FilterType::class,null,array());
        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            // FILTROS DE BUSQUEDA DETALLADA:

           $busqueda = $form->getData();

            $nombre = $form->get('modelo')->getData();
            if (empty($nombre)){
                $nombre=null;
            }
            $ano = $form->get('ano')->getData();
            if (empty($ano)){
                $ano=null;
            }
            $activo = $form->get('activo')->getData();

            $marca= $form->get('marca')->getData();
            $marca=  $marca->getNombre();
            if (empty($marca)){
                $marca=null;
            }

            $list = $this->doctrine->getRepository(Coches::class)->detailedSearch($nombre,$ano,$activo,$marca);

            $coches = $paginator->paginate(
                $list,
                $request->query->getInt('page',1),
                $this->getParameter('paginas')
            );
            return $this->render('coche/list.html.twig',['coches' => $coches]);
        }
        return $this->render('coche/find.html.twig', array('form' => $form->createView(),'title'=>'Busqueda detallada'));
    }
   */

    /**
     * <\d+>
     * @Route("/coches/filtroColumnas/{option}", name="filtro_columnas")
     */
   /* public function filtroColumnas($option, Request $request,PaginatorInterface $paginator){

            $repo =   $this->doctrine->getRepository(Coches::class);

            switch ($option){
                case  1:
                    // orden por ID.
                     $listaOrdenada=$repo->orderBy(1);

                    break;
                case 2:
                    // orden por mdoelo(nombre).
                    $listaOrdenada=$repo->orderBy(2);

                    break;
                case 3:
                    // orden por fechaAlta
                    $listaOrdenada=$repo->orderBy(3);

                    break;
                case 4:
                    //Orden por año.
                    $listaOrdenada=$repo->orderBy(4);

                    break;
                case 5:
                    //Orden por año.
                    $listaOrdenada=$repo->orderBy(5);

                    break;

            }

        $coches = $paginator->paginate(
            $listaOrdenada,
            $request->query->getInt('page',1),
            $this->getParameter('paginas')
        );
        return $this->render('coche/list.html.twig',['coches' => $coches]);

    }
   */
}
