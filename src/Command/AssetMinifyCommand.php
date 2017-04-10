<?php

namespace Minifier\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use MatthiasMullie\Minify;

class AssetMinifyCommand extends Command
{
    protected function configure()
    {
        $this->setName('asset:minify')
            ->setDescription('Minify the js and css assets')
            ->setHelp('Normaly you don\'t have to use this command if your are not a dev');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $root = dirname(dirname(dirname(__FILE__)));
        $wwwjs = sprintf('%s/www/js', $root);
        $jsdir = sprintf('%s/js', $root);
        $jss = $this->searchFileinSubDir($jsdir);

        foreach ($jss as $js) {
            $output->writeln(sprintf('minify %s to %s', $js[0], $js[1]));
            $minifier = new Minify\JS($js[0]);
            $minifier->minify(sprintf('%s/%s', $wwwjs, $js[1]));
        }

    }

    private function searchFileinSubDir($dir)
    {
        $scanned_directory = array_diff(scandir($dir), array('..', '.'));
        $ret = array();

        foreach ($scanned_directory as $sdir) {

            $tmpdir = sprintf('%s/%s', $dir, $sdir);
            $dircontent = array_diff(scandir($tmpdir), array('..', '.'));

            foreach ($dircontent as $file) {
                array_push($ret, array(sprintf('%s/%s', $tmpdir, $file), sprintf('%s_%s', $sdir, $file)));
            }
        }
        return $ret;
    }
}