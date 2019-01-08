<?php

namespace SC\CommonBundle\Repository;

/**
 * StudentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StudentRepository extends \Doctrine\ORM\EntityRepository
{
	public function getStudentsByDepartment($departmentName)
  		{
    		$qb = $this->createQueryBuilder('s');
    		$qb->innerJoin('s.department', 'd')
      		->addSelect('d');
    		$qb->andWhere('d.name LIKE :departmentName')
    		->setParameter('departmentName', $departmentName .'%');

    		return $qb->getQuery()->getResult();
  }
}
