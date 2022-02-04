<?php

namespace App\Command\Html;

use simplehtmldom\HtmlDocument;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ParseCopyHtmlCommand extends Command
{
    protected static $defaultName = 'parse:html:simple';
    public string    $projectDir;
    public const columnsCount = 5;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
        parent::__construct(null);
    }

    protected function configure()
    {
        $this
            ->addOption('oldMarkup', null, InputOption::VALUE_REQUIRED, 'Filepath to old markup')
            ->addOption('newMarkup', null, InputOption::VALUE_REQUIRED, 'Filepath to new markup')
            ->addOption('withCnames', null, InputOption::VALUE_NONE, 'With comparing by cnames');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $oldFilePath = $input->getOption('oldMarkup');
        $newFilePath = $input->getOption('newMarkup');

        if (empty($oldFilePath)) {
            $io->success('Empty old markup filepath');

            return Command::FAILURE;
        }

        if (empty($newFilePath)) {
            $io->success('Empty new markup filepath');

            return Command::FAILURE;
        }

        $textUntil        = file_get_contents($this->projectDir . '/test statistic/until.html');
        $textAfter        = file_get_contents($this->projectDir . '/test statistic/after.html');
        $docUntil         = new HtmlDocument($textUntil);
        $docAfter         = new HtmlDocument($textAfter);
        $trsUntil         = $docUntil->find('tr');
        $trsAfter         = $docAfter->find('tr');
        $tableValuesUntil = [];
        $tableValuesAfter = [];
        $index            = 0;
        foreach ($trsUntil as $tr) {
            $index++;
            foreach ($tr->find('td') as $td) {
                $tableValuesUntil[$index][] = $td->plaintext;
            }
        }

        foreach ($trsAfter as $tr) {
            $index++;
            foreach ($tr->find('td') as $td) {
                $tableValuesAfter[$index][] = $td->plaintext;
            }
        }

        if (empty($trsUntil)) {
            $io->success('until data is empty');

            return Command::SUCCESS;
        }
        if (empty($trsAfter)) {
            $io->success('after data is empty');

            return Command::SUCCESS;
        }

        $tableDataUntil = $this->formatTableRows($tableValuesUntil, $input->getOption('withCnames'));
        $tableDataAfter = $this->formatTableRows($tableValuesAfter, $input->getOption('withCnames'));
        $errors         = $this->compareTables($tableDataUntil, $tableDataAfter);

        if ($errors) {
            dd($errors);
        }
        $io->success('Tables are equal!');

        return Command::SUCCESS;
    }

    public function formatTableRows(array $rows, bool $withCnames): array
    {
        $result   = [];
        $totalRow = array_pop($rows);
        foreach ($rows as $row) {
            if ($withCnames) {
                $projects = explode(',', str_replace(' ', '', $row[1]));
                sort($projects);
                $row[1] = implode(',', $projects);
            }

            $result['values'][] = implode(',', $row);
        }

        $result['total'] = implode(' | ', str_replace([PHP_EOL, "\r"], '', $totalRow));

        return $result;
    }

    public function compareTables(array $a, array $b): array
    {
        $aValues = $a['values'];
        $bValues = $b['values'];
        $errors  = [];
        if (count($aValues) !== count($bValues)) {
            $errors['invalid row count'] = [
                'until' => count($aValues),
                'after' => count($bValues)
            ];

            return $errors;
        }

        foreach ($aValues as $row) {
            if (!in_array($row, $bValues)) {
                $errors['not found row in new table'][] = [
                    'row'      => $row,
                    'a_values' => $aValues,
                    'b_values' => $bValues,
                ];
            }
        }

        foreach ($bValues as $row) {
            if (!in_array($row, $aValues)) {
                $errors['not found row in old table'][] = [
                    'row'      => $row,
                    'a_values' => $aValues,
                    'b_values' => $bValues,
                ];
            }
        }

        foreach ($aValues as $index => $row) {
            if (!isset($bValues[$index])) {
                $errors['different rows'] = [
                    sprintf('row %s does not exist in new table', $index)
                ];
            }

            if ($bValues[$index] !== $row) {
                $errors['different rows'] = [
                    'row number'       => $index,
                    'row in old table' => $row,
                    'row in new table' => $bValues[$index]
                ];
            }
        }

        foreach ($bValues as $index => $row) {
            if (!isset($aValues[$index])) {
                $errors['different rows'] = [
                    sprintf('row %s does not exist in new table', $index)
                ];
            }

            if ($aValues[$index] !== $row) {
                $errors['different rows'] = [
                    'row number'       => $index,
                    'row in old table' => $row,
                    'row in new table' => $aValues[$index]
                ];
            }
        }

        if ($b['total'] !== $a['total']) {
            $errors['total_rows'] = [
                'a' => $a['total'],
                'b' => $b['total']
            ];
        }

        return $errors;
    }
}
