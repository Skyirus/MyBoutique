<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function myFindAll()
    {
        $queryBuilder = $this->createQueryBuilder('p');
        $query = $queryBuilder->getQuery();
        $results = $query->getResult();

        return $results;
    }

    public function myFind($id)
    {
        $queryBuilder = $this->createQueryBuilder('p')
            ->where('p.id = :id')
            ->setParameter('id', $id);

        $query = $queryBuilder->getQuery();
        $results = $query->getResult();

        return $results;
    }

    public function myFindProductPrice($price1, $price2)
    {
        $price1 = $price1 * 100;
        $price2 = $price2 * 100;

        $queryBuilder = $this->createQueryBuilder('p')
            ->andWhere('p.price > :price1')
            ->setParameter('price1', $price1)
            ->andWhere('p.price < :price2')
            ->setParameter('price2', $price2)
            ->orderBy('p.price', 'DESC');

        $query = $queryBuilder->getQuery();
        $results = $query->getResult();

        //dd($results);

        //return $results;
    }

    public function myFindSearch($search)
    {

        $queryBuilder = $this->createQueryBuilder('p')
            ->join('p.category', 'c');
        //->addSelect('c')

        //dd($search->getString());

        if (!empty($search->getString())) {

            $mots = explode(" ", $search->getString());
            $i = 0;
            foreach ($mots as $mot) {
                $queryBuilder->andWhere('p.name LIKE :name' . $i . ' OR p.description LIKE :name' . $i . ' OR p.subtitle LIKE :name' . $i)
                    ->setParameter('name' . $i, '%' . $mot . '%');
                $i++;
            }
        }

        if (count($search->getCategories()) > 0) {

            $queryBuilder->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->getCategories());
        }

        $query = $queryBuilder->getQuery();
        $results = $query->getResult();

        //dd($query->getDQL());
        return  $results;
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
