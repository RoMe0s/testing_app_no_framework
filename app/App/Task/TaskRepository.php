<?php

namespace App\Task;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Domain\Task\Task;
use Domain\Task\TaskRepository as TaskRepositoryInterface;

class TaskRepository extends EntityRepository implements TaskRepositoryInterface
{
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, $em->getClassMetadata(Task::class));
    }

    public function paginate(string $orderBy, string $orderType): Paginator
    {
        $query = $this->createQueryBuilder('t')
            ->orderBy("t.$orderBy", $orderType)
            ->leftJoin('t.admin', 'a');

        return new Paginator($query);
    }

    public function findTask(int $id): ?Task
    {
        return $this->find($id);
    }

    public function save(Task $task): void
    {
        $this->_em->persist($task);
        $this->_em->flush();
        $this->_em->clear();
    }
}