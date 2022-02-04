<?php

namespace App\Command\Html;

use simplehtmldom\HtmlDocument;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ParseHtmlCommand extends Command
{
    protected static $defaultName = 'parse:html';
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
            ->addOption('tableType', null, InputOption::VALUE_REQUIRED, 'Table type');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $oldFilePath = $input->getOption('oldMarkup');
        $newFilePath = $input->getOption('newMarkup');
        $tableType   = $input->getOption('tableType');
        if (empty($oldFilePath)) {
            $io->success('Empty old markup filepath');

            return Command::FAILURE;
        }

        if (empty($newFilePath)) {
            $io->success('Empty new markup filepath');

            return Command::FAILURE;
        }

        if (empty($tableType)) {
            $io->success('Empty table type');

            return Command::FAILURE;
        }

        $textUntil        = file_get_contents($this->projectDir . $oldFilePath);
        $textAfter        = file_get_contents($this->projectDir . $newFilePath);
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
            $io->success('No rows found in old markup');

            return Command::SUCCESS;
        }
        if (empty($trsAfter)) {
            $io->success('No rows found in new markup');

            return Command::SUCCESS;
        }

        $errors = [];
        switch (true) {
            case $tableType === 'admin':
                $tableDataUntil = $this->formatAdminTableRows($tableValuesUntil);
                $tableDataAfter = $this->formatAdminTableRows($tableValuesAfter);
                $errors         = $this->compareAdminTables($tableDataUntil, $tableDataAfter);
                break;
            case $tableType === 'client':
                $tableDataUntil = $this->formatClientTableRows($tableValuesUntil);
                $tableDataAfter = $this->formatClientTableRows($tableValuesAfter);
                $errors         = $this->compareClientTables($tableDataUntil, $tableDataAfter);
                break;
            case $tableType === 'project':
                $tableDataUntil = $this->formatProjectTableRows($tableValuesUntil);
                $tableDataAfter = $this->formatProjectTableRows($tableValuesAfter);
                $errors         = $this->compareProjectTables($tableDataUntil, $tableDataAfter);
                break;
            default:
                $io->success('Wrong table type. Enter \'admin\',\'client\' or \'project\'');

                return Command::FAILURE;

        }

        if ($errors) {
            dd($errors);
        }
        $io->success('Tables are equal!');

        return Command::SUCCESS;
    }

    public function formatAdminTableRows(array $rows): array
    {
        $result   = [];
        $client   = '';
        $day      = '';
        $totalRow = array_pop($rows);
        foreach ($rows as $row) {
            $elementsCount = count($row);
            if ($elementsCount === self::columnsCount + 3) {
                $day    = array_shift($row);
                $client = array_shift($row);
            }

            if ($elementsCount === self::columnsCount + 2) {
                $client = array_shift($row);
            }

            $result['values'][$day][$client][] = implode(',', $row);
        }

        $result['total'] = implode(' | ', str_replace([PHP_EOL, "\r"], '', $totalRow));

        return $result;
    }

    public function formatClientTableRows(array $rows): array
    {
        $result   = [];
        $day      = '';
        $totalRow = array_pop($rows);
        foreach ($rows as $row) {
            $elementsCount = count($row);
            if ($elementsCount === self::columnsCount + 2) {
                $day = array_shift($row);
            }

            $result['values'][$day][] = str_replace(' ', '', implode(',', $row));
        }

        $result['total'] = implode(' | ', str_replace([PHP_EOL, "\r"], '', $totalRow));

        return $result;
    }

    public function formatProjectTableRows(array $rows): array
    {
        $result   = [];
        $totalRow = array_pop($rows);
        foreach ($rows as $row) {
            $result['values'][] = str_replace(' ', '', implode(',', $row));
        }

        $result['total'] = implode(' | ', str_replace([PHP_EOL, "\r"], '', $totalRow));

        return $result;
    }

    public function compareClientTables(array $a, array $b): array
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

        foreach ($aValues as $day => $data) {

            if (!isset($bValues[$day])) {
                $errors['not found'][] = [
                    'day' => $day,
                ];
            }

            $values = $bValues[$day];
            foreach ($data as $row) {
                if (!in_array($row, $values)) {
                    $errors['not found'][] = [
                        'day'      => $day,
                        'values_a' => $row,
                        'values_b' => $values
                    ];
                }
            }

        }

        if ($b['total'] !== $a['total']) {
            $errors['total_rows'] = [
                'old' => $a['total'],
                'new' => $b['total']
            ];
        }

        return $errors;
    }

    public function compareProjectTables(array $a, array $b): array
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
                $errors['not found'][] = [
                    'row'      => $row,
                    'a_values' => $aValues,
                    'b_values' => $bValues,
                ];
            }
        }

        if ($b['total'] !== $a['total']) {
            $errors['total_rows'] = [
                'old' => $a['total'],
                'new' => $b['total']
            ];
        }

        return $errors;
    }

    public function compareAdminTables(array $a, array $b): array
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

        foreach ($aValues as $day => $data) {
            foreach ($data as $client => $values) {
                if (!isset($bValues[$day][$client])) {
                    $errors['not found in new table'][] = [
                        'day'    => $day,
                        'client' => $client
                    ];
                }

                $values = $bValues[$day][$client];
                foreach ($values as $row) {
                    if (!in_array($row, $values)) {
                        $errors['not found in new table'][] = [
                            'day'    => $day,
                            'client' => $client,
                            'values' => $row
                        ];
                    }
                }
            }
        }

        foreach ($bValues as $day => $data) {
            foreach ($data as $client => $values) {
                if (!isset($aValues[$day][$client])) {
                    $errors['not found in old table'][] = [
                        'day'    => $day,
                        'client' => $client
                    ];
                }

                $values = $aValues[$day][$client];
                foreach ($values as $row) {
                    if (!in_array($row, $values)) {
                        $errors['not found in old table'][] = [
                            'day'    => $day,
                            'client' => $client,
                            'values' => $row
                        ];
                    }
                }
            }
        }

        if ($b['total'] !== $a['total']) {
            $errors['total_rows'] = [
                'old' => $a['total'],
                'new' => $b['total']
            ];
        }

        return $errors;
    }
}
