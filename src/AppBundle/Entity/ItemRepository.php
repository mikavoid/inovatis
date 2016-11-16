<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ItemRepository extends EntityRepository
{
    public function findMySearch($search)
    {
        $search = urldecode($search);
        $qb = $this->_em->createQueryBuilder();
        $qb->select('item')
            ->from($this->_entityName, 'item');
            $qb->where('item.name LIKE :word OR item.description LIKE :word');
            $qb->setParameter('word', '%'.$search.'%');

        return $qb->getQuery()->getResult();
    }
}