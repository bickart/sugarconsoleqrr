<?php
// Copyright 2016 SugarCRM Inc.  Licensed by SugarCRM under the Apache 2.0 license.

namespace Sugarcrm\Sugarcrm\custom\Console\Command;

use LanguageManager;
use RepairAndClear;
use Sugarcrm\Sugarcrm\Console\CommandRegistry\Mode\InstanceModeInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

require_once 'modules/Administration/QuickRepairAndRebuild.php';

/**
 *
 * Simple Quick Repair command example
 *
 */
class QuickRepairCommand extends Command implements InstanceModeInterface
{
    /**
     * {inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('admin:qrr')
            ->setDescription('Run Quick Repair and Rebuild');
    }

    /**
     * {inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>Starting Quick Repair...</info>");
        $this->repair();
        $this->removeJsAndLanguages();
        $output->writeln("<fg=green;options=bold>Complete.</>");
    }

    /**
     * Execute QRR
     */
    protected function repair()
    {
        $GLOBALS['mod_strings'] = return_module_language('en_us', 'Administration');
        $repair = new RepairAndClear();
        $repair->repairAndClearAll(array('clearAll'), array(translate('LBL_ALL_MODULES')), true, false, '');
    }

    protected function removeJsAndLanguages()
    {
        // remove some stuff
        //remove the js language files
        LanguageManager::removeJSLanguageFiles();
        //remove language cache files
        LanguageManager::clearLanguageCache();
    }

}

