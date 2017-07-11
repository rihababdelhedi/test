<?php

namespace FioulmarketBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * Description of importCommand
 *
 * @author user
 */
class ImportExcelCommand extends ContainerAwareCommand {

    protected function configure() {
        $this->setName('import:generate')
                ->setDescription("Cet outil permet d'extraire les prix moyen de fioul ")

        ;
    }

    protected function interact(InputInterface $input, OutputInterface $output) {
        // On affiche quelques infos
        $output->writeln(array(
            'Extraire les prix fioul '
        ));
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        // date de debut d'execution
        $now = new \DateTime();
        $output->writeln('Début : ' . $now->format('d-m-y G:i:s'));

        // importation du csv
        $this->import($input, $output);

        // date du fin d'execution
        $now = new \DateTime();
        $output->writeln('Fin :' . $now->format('d-m-y G:i:s'));
    }

    protected function import(InputInterface $input, OutputInterface $output) {
        
        ini_set("memory_limit", -1);
        
        // recuperer les données
        $data = $this->get($input, $output);
        // recuperer doctrine manager
        $em = $this->getContainer()->get('doctrine')->getManager();
        $size = count($data);
        $persistSize = 1000;
        $i = 0;

        // progress bar 
        $progress = new ProgressBar($output, $size);
        $progress->start();

        foreach ($data as $row) {

            $prices = new \FioulmarketBundle\Entity\prices();
            $prices->setPostalCodeId($row['postal_code_id']);
            $prices->setAmount($row['amount']);
            $prices->setDate($row['date']);
            $em->persist($prices);

            if ($i % $persistSize === 0) {

                $em->flush();
                // nettoyer de la mémoire
                $em->clear();

                // progress dans le console
                $progress->advance($persistSize);

                $now = new \DateTime();
                $output->writeln('Avancement :' . $now->format('d-m-y G:i:s'));
            }
            $i++;
            // flush
            $em->flush();
            $em->clear();
        }
        $progress->finish();
    }

    protected function get(InputInterface $input, OutputInterface $output) {
        // recuperer le file name 
        $filename = 'web/excel/prices.csv';

        // recuperer les données a partir du service 
        $csvToArray = $this->getContainer()->get('import.csvtoarray');
        $data = $csvToArray->convert($filename, ',');

        return $data;
    }

}
