<?php
namespace App\Repository;
use App\Entity\Coches;
use App\Entity\Marcas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

class CochesRepository extends ServiceEntityRepository
{
    /**
     * @method Coches|null find($id, $lockMode = null, $lockVersion = null)
     * @method Coches|null findOneBy(array $criteria, array $orderBy = null)
     * @method Coches[]    findAll()
     * @method Coches[]    findTermActive(string $value)
     * @method Coches[]    findTerm(string $value)
     * @method Coches[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
     * @method Coches[]    detailedSearch(string $nombre, int $ano , bool $activo, string $marca)
     */
    public function __construct(ManagerRegistry $registry)
    {

        parent::__construct($registry, Coches::class);
    }

    // /**
    //  * @return Coches[]
    //  */
    public function findTerm(string $value)
    {
        // busqueda campos: Campos: nombre, año, activo y marca.
        return $this->createQueryBuilder('c')
            ->innerJoin(Marcas::class,'m',join::WITH,'m.id = c.Marca')
            ->orWhere('c.modelo = :val')
            ->orWhere('c.ano = :val')
            ->orWhere('m.nombre = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->getQuery();


    }

    // /**
    //  * @return Coches[]
    //  */
    public function findTermActive(string $value)
    {
        // busqueda campos: Campos: nombre, año, activo y marca.
        return $this->createQueryBuilder('c')
            ->innerJoin(Marcas::class,'m',join::WITH,'m.id = c.Marca')
            ->orWhere('c.modelo = :val')
            ->orWhere('c.ano = :val')
            ->orWhere('m.nombre = :val')
            ->andWhere('c.activo = true')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->getQuery();

    }

    public function detailedSearch( $nombre,  $ano ,  $activo,  $marca){

         $queryBuilder =  $this->createQueryBuilder('c');
         $queryBuilder->innerJoin(Marcas::class,'m',join::WITH,'m.id = c.Marca');

            if (!empty($nombre)){

                $queryBuilder-> andWhere('c.modelo LIKE :nombre');
                $queryBuilder->setParameter('nombre',$nombre);
            }
             if (!empty($ano)){
                $queryBuilder->andWhere('c.ano = :ano');
                $queryBuilder->setParameter('ano',$ano);
             }
            if ($activo){
               $queryBuilder-> andWhere('c.activo = :activo');
               $queryBuilder->setParameter('activo',$activo);
            }
            if (!empty($marca)){
               $queryBuilder-> andWhere('m.nombre = :marca');
               $queryBuilder ->setParameter('marca',$marca);
            }

       $result = $queryBuilder ->orderBy('c.id', 'ASC')->getQuery();

        return  $result;

    }

    public function orderBy($param) {

        $queryBuilder =  $this->createQueryBuilder('c');
        $queryBuilder->innerJoin(Marcas::class,'m',join::WITH,'m.id = c.Marca');


        if ($param == 1){
            $queryBuilder->orderBy('c.id','ASC');
        }
        if ($param == 2){
            $queryBuilder->orderBy('m.nombre','ASC');
        }
        if($param == 3)
        {
            $queryBuilder->orderBy('c.modelo','ASC');
        }
        if($param == 4)
        {
            $queryBuilder->orderBy('c.fechaAlta','ASC');
        }
        if($param == 5)
        {
            $queryBuilder->orderBy('c.ano','ASC');
        }
        return $queryBuilder->getQuery()->getResult();
    }

    public function listAll(){

        $queryBuilder =  $this->createQueryBuilder('c');
        $queryBuilder->innerJoin(Marcas::class,'m',join::WITH,'m.id = c.Marca');

        return $queryBuilder->getQuery();


    }

}