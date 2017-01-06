<?php
/**
 * Class PhanCest
 * Static code analyzer
 */
class PhanCest
{
    /**
     * @var string
     */
    protected $log = '${PWD}/phan_output.txt';
    /**
     * @var string
     */
    protected $phan = '${PWD}/vendor/bin/phan';

    /**
     * @param Static_analysisTester $I
     */
    public function _before(Static_analysisTester $I)
    {
        $I->runShellCommand('if [ ! -f "'.$this->phan.'" ]; then composer require etsy/phan --dev --no-scripts; fi;');
    }

    /**
     * @param Static_analysisTester $I
     */
    public function _after(Static_analysisTester $I)
    {
        $I->runShellCommand('if [ -f "'.$this->log.'" ]; then rm -f '.$this->log.'; fi;');
    }

    /**
     * @param Static_analysisTester $I
     */
    public function checkStaticAnalysisWithPhan(Static_analysisTester $I)
    {
        $I->wantTo('check the code with Phan static Analysis tool');
        $I->runShellCommand("{$this->phan} >> {$this->log}");
        $I->dontSeeInShellOutput("cat {$this->log}", "Phan");
    }
}
