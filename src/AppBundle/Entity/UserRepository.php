<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function myFindByRoles($role)
    {
        $admin = 'ROLE_ADMIN';
        $qb = $this->_em->createQueryBuilder();
        $qb->select('user')
            ->from($this->_entityName, 'user');
            if (!empty($role)) {
                $qb->where('user.roles LIKE :roles');
                $qb->setParameter('roles', '%"'.$role.'"%');
            } else {
                $qb->where('user.roles NOT LIKE :admin');
                $qb->setParameter('admin', '%"'.$admin.'"%');
            }

        return $qb->getQuery()->getResult();
    }
}