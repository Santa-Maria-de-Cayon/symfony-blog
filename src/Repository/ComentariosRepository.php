<?php

namespace App\Repository;

use App\Entity\Comentarios;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comentarios|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comentarios|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comentarios[]    findAll()
 * @method Comentarios[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComentariosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comentarios::class);
    }


    public function getLatestComments(){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT c.comentario, c.fecha_publicacion, posts.id, user.nombre
            FROM App\Entity\Comentarios c
            JOIN c.post posts 
            JOIN c.user user
            ORDER BY c.id ASC'
        ) ->setMaxResults(7)
        ;
        return $query->getResult();

     //  $entityManager = $this->getEntityManager();
     //  $query = $entityManager->createQuery(
     //      'SELECT c.id, c.comentario, c.fecha_publicacion, posts.id
     //      FROM App\Entity\Comentarios c
     //      JOIN c.post posts
     //      WHERE c.id > :value
     //      ORDER BY c.id ASC'
     //  )   ->setParameter('value', 5)
     //      ->setMaxResults(7)
     //  ;
     //  return $query->getResult();


     // return $this->getEntityManager()->
     // createQuery('
     // SELECT com.id, com.comentario, user.nombre
     // FROM App:Comentarios com
     // JOIN com.user user
     // ')->getResult() ;

      //  return $this
      //      ->createQueryBuilder("Comentarios")
      //      ->orderBy("Comentarios.id", "DESC")
      //      ->setMaxResults(7)
      //      ->getQuery()
      //      ->getResult();

    //    return $this->createQueryBuilder('Comentarios')
    //        ->andWhere('Comentarios.id = :val')
    //        ->setParameter('val', 3)
    //        ->orderBy('Comentarios.id', 'ASC')
    //        ->setMaxResults(10)
    //        ->getQuery()
    //        ->getResult()
    //        ;

   //     return $this->createQueryBuilder('Comentarios')
   //    //   ->andWhere('genus.isPublished = :isPublished')
   //    //   ->setParameter('isPublished', true)
   //    //   ->leftJoin('User.nombre', 'User')
   //        ->getQuery()
   //         ->execute();
    }
    // /**
    //  * @return Comentarios[] Returns an array of Comentarios objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comentarios
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
