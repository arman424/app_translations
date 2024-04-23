<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'file:translate',
    description: 'File translate',
)]
class TranslateFileCommand extends Command
{
    private string $filePath = 'public/assets/files/';

    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly Filesystem $filesystem
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Translate strings in a file')
            ->addArgument('inputFile', InputArgument::REQUIRED, 'Input file')
            ->addArgument('outputFile', InputArgument::REQUIRED, 'Output file')
            ->addArgument('locale', InputArgument::REQUIRED, 'Locale');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        [$inputFile, $outputFile, $locale] = $this->getArguments($input);
        // Read data from input file
        $lines = file($this->filePath . $inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $outputPath = $this->filePath . basename($outputFile);
        $this->filesystem->dumpFile($outputPath, $this->generateTranslatedLines($this->translatedLinesGenerator($lines, $locale)));

        $output->writeln('File successfully translated and saved at: ' . $outputPath);

        return Command::SUCCESS;
    }

    // Define a helper function to generate translated lines from the generator
    private function generateTranslatedLines(iterable $generator): string
    {
        $translatedLines = '';
        foreach ($generator as $translatedLine) {
            $translatedLines .= $translatedLine . PHP_EOL;
        }
        return $translatedLines;
    }

    // Define a generator function to yield translated lines
    private function translatedLinesGenerator($lines, $locale): \Generator
    {
        foreach ($lines as $line) {
            //TODO The translation logic can be here
            yield $this->translator->trans($line, [], null, $locale);
        }
    }

    private function getArguments(InputInterface $input): array
    {
        return [
            $input->getArgument('inputFile'),
            $input->getArgument('outputFile'),
            $input->getArgument('locale'),
        ];
    }
}
