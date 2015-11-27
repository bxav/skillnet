<?php

/*
 * This file is part of the BxMarket package.
 *
 * (c) Xavier Buillit
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Command;

use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use AppBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateClientCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:oauth-server:create-client')
            ->setDescription('Creates a new client')
            ->setHelp(<<<EOT
The <info>%command.name%</info>command creates a new client.
<info>php %command.full_name% name</info>
EOT
            );
    }
    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientManager = $this->getClientManager();
        $client = $clientManager->create();
        $output->writeln(
            sprintf(
                "{public_id: '%s', secret: '%s'}",
                $client['publicId'],
                $client['secret']
            )
        );
    }
    /**
     * @return ClientManagerInterface
     */
    private function getClientManager()
    {
        return $this->getContainer()->get('app.oauth2.client_creator');
    }
}
