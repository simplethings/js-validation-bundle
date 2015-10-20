<?php

namespace SimpleThings\JsValidationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @author david badura <badura@simplethings.de>
 */
class GenerateConstraintsCommand extends ContainerAwareCommand
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('simplethings:jsvalidation:generate')
            ->setDescription('Generates javascript validation constraints')
            ->addOption('target', null, InputOption::VALUE_OPTIONAL, 'The target directory', 'web/js')
            ->addOption('name', null, InputOption::VALUE_OPTIONAL, 'The file name', 'javascript-validation-constraints.js')
            ->addOption('variable', null, InputOption::VALUE_OPTIONAL, 'The javascript variable name', 'jsValidationConstraints')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $target = rtrim($input->getOption('target'), '/');

        if (!is_dir($target)) {
            $fs = new Filesystem();
            $fs->mkdir($target);
        }

        $objects = $this->getContainer()->getParameter('simple_things_js_validation.objects');
        $generator = $this->getContainer()->get('simple_things_js_validation.constraints_generator');
        $constraints = $generator->generate($objects);

        $file = $target . '/' . $input->getOption('name');
        $variable = $input->getOption('variable');

        file_put_contents($file, sprintf('var %s = ', $variable).$constraints);
        $output->writeln(sprintf('Generate javascript validation constraints in <comment>%s</comment>', $file));
        $output->writeln(sprintf('The javascript variable name is <comment>%s</comment>', $variable));
    }
}

