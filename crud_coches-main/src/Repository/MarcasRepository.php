<?php
namespace App\Repository;
use App\Entity\Coches;
use App\Entity\Marcas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

class MarcasRepository extends ServiceEntityRepository
{
    /**
     * @method Marcas|null find($id, $lockMode = null, $lockVersion = null)
     * @method Marcas|null findOneBy(array $criteria, array $orderBy = null)
     * @method Marcas[]    findAll()
     * @method Marcas[]    findTermActive(string $value)
     * @method Marcas[]    findTerm(string $value)
     * @method Marcas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Marcas::class);
    }


    // /**
    //  * @return Marcas[]
    //  */
    public function findTerm(string $value)
    {
        // busqueda campos: Campos: nombre, año, activo y marca.
        return $this->createQueryBuilder('c')
         //   ->innerJoin(Marcas::class,'m',join::WITH,'m.id = c.Marca')
            ->orWhere('c.nombre = :val')
            ->orWhere('c.descripcion = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();

    }

    // /**
    //  * @return Marcas[]
    //  */
    public function findTermActive(string $value)
    {
        // busqueda campos: Campos: nombre, año, activo y marca.
        return $this->createQueryBuilder('c')
          //  ->innerJoin(Marcas::class,'m',join::WITH,'m.id = c.Marca')
            ->orWhere('c.nombre = :val')
           // ->orWhere('c.ano = :val')
            ->orWhere('c.descripcion = :val')
            ->andWhere('c.activo = true')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function detailedSearch($nombre,$activo){

        $queryBuilder =  $this->createQueryBuilder('c');

        if (!empty($nombre)){

            $queryBuilder-> andWhere('c.modelo = :nombre');
            $queryBuilder->setParameter('nombre',$nombre);
        }
        if ($activo){
            $queryBuilder-> andWhere('c.activo = :activo');
            $queryBuilder->setParameter('activo',$activo);
        }

        return   $queryBuilder ->orderBy('c.id', 'ASC')->getQuery()->getResult();

    }

}