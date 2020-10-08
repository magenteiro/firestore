<?php
namespace Magenteiro\ConfigInfo\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetInfoCommand extends Command
{
    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    private $metaData;

    /**
     * GetInfoCommand constructor.
     *
     * @param string|null                                     $name
     * @param \Magento\Framework\App\ProductMetadataInterface $metaData
     */
    public function __construct(\Magento\Framework\App\ProductMetadataInterface $metaData, string $name = null)
    {
        parent::__construct($name);
        $this->metaData = $metaData;
    }

    protected function configure()
    {
        $this->setName('magenteiro:config:info')
            ->setDescription('Traz informações do php e do ambiente.');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fromPhpini = ['memory_limit', 'date.timezone', 'display_errors', 'log_errors'];

        $output->writeln('From php.ini: ');
        foreach ($fromPhpini as $config) {
            $output->writeln($config . ': ' . ini_get($config));
        }

        $output->writeln('Arquivos PHP carregados: ' . php_ini_loaded_file());

        $output->writeln('From Magento:');
        $output->writeln('Versão Magento: ' . $this->metaData->getVersion() . ' ' . $this->metaData->getEdition());

        $this->additionalInfo($output);
    }

    /**
     * Add plugins to this method to output additional information
     * @param OutputInterface $output
     */
    public function additionalInfo(OutputInterface $output)
    {
        return;
    }
}
