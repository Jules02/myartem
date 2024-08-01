<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

//    /**
//     * @return Student[] Returns an array of Student objects
//     */
//    public function findByName($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.firstName = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    /**
     * @return Student[] Returns an array of Student objects
     */
    public function findByName(string $value): array
    {
        $terms = array_filter(explode(' ', $value));

        $qb = $this->createQueryBuilder('s');
        $qb->where('1 = 0');

        foreach ($terms as $term) {
            $qb->orWhere($qb->expr()->like('LOWER(s.firstName)', ':term'))
                ->orWhere($qb->expr()->like('LOWER(s.lastName)', ':term'))
                ->setParameter('term', '%' . strtolower($term) . '%');
        }

        return $qb->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
