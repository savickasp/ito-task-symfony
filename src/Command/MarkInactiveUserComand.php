<?php


namespace App\Command;


use App\DateTime\MyDateTime;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MarkInactiveUserComand extends Command
{
    protected static $defaultName = 'user:mark-inactive';
    private $userRepository;
    private $em;
    private $dateTime;

    public function __construct(string $name = null, UserRepository $userRepository, EntityManagerInterface $em, MyDateTime $dateTime)
    {
        $this->userRepository = $userRepository;

        parent::__construct($name);
        $this->em = $em;
        $this->dateTime = $dateTime;
    }

    protected function configure()
    {
        $this
            ->setDescription('marks inactive users in DB')
            ->setHelp('Command check all users last login time and if it is more then 1 month it marks them in database as inactive users');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $date = date('Y-m-d H:i:s', strtotime(' -1 month'));

        $users = $this->em->getRepository(User::class)->findAll();

        $setActive = 0;
        $setInactive = 0;
        foreach ($users as $user) {
            $f = $user->getLastLogin();

            if ($user->getLastLogin()->format('Y-m-d H:i:s') < $date && $user->getActive()) {
                $user->setActive(0);
                $setInactive++;
            } elseif ($user->getLastLogin()->format('Y-m-d H:i:s') > $date && !$user->getActive()) {
                $user->setActive(1);
                $setActive++;
            }
        }

        $this->em->flush();

        $output->writeln([
            'Database updated',
            '-- ' . $setInactive .  ' users was set as inactive',
            '-- ' . $setActive .  ' users was set as active',
            'Command ended',
        ]);

        return 0;
    }
}