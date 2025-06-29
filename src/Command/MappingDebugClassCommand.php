<?php

namespace Vich\UploaderBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Completion\CompletionInput;
use Symfony\Component\Console\Completion\CompletionSuggestions;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Vich\UploaderBundle\Metadata\MetadataReader;

#[AsCommand(name: 'vich:mapping:debug-class', description: 'Debug a class.')]
final class MappingDebugClassCommand extends Command
{
    public function __construct(private readonly MetadataReader $metadataReader)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('fqcn', InputArgument::REQUIRED, 'The FQCN of the class to debug.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $fqcn = $input->getArgument('fqcn');

        if (!$this->metadataReader->isUploadable($fqcn)) {
            $output->writeln(\sprintf('<error>"%s" is not uploadable.</error>', $fqcn));

            return self::FAILURE;
        }

        $uploadableFields = $this->metadataReader->getUploadableFields($fqcn);

        $output->writeln(\sprintf('Introspecting class <info>%s</info>:', $fqcn));
        foreach ($uploadableFields as $data) {
            $output->writeln(\sprintf('Found field "<comment>%s</comment>":', $data['propertyName']));
            $output->writeln(\sprintf("\t<comment>mapping</comment>: %s", $data['mapping']));
            $output->writeln(\sprintf("\t<comment>file name</comment>: %s", $data['fileNameProperty'] ?? '<error>not set</error>'));
            $output->writeln(\sprintf("\t<comment>original name</comment>: %s", $data['originalName'] ?? '<error>not set</error>'));
            $output->writeln(\sprintf("\t<comment>size</comment>: %s", $data['size'] ?? '<error>not set</error>'));
            $output->writeln(\sprintf("\t<comment>mime type</comment>: %s", $data['mimeType'] ?? '<error>not set</error>'));
            $output->writeln(\sprintf("\t<comment>dimensions</comment>: %s", $data['dimensions'] ?? '<error>not set</error>'));
        }

        return self::SUCCESS;
    }

    public function complete(CompletionInput $input, CompletionSuggestions $suggestions): void
    {
        if ($input->mustSuggestArgumentValuesFor('fqcn')) {
            $suggestions->suggestValues($this->metadataReader->getUploadableClasses());
        }
    }
}
