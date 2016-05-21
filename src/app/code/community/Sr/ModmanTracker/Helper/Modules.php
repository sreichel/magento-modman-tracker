<?php

class Sr_ModmanTracker_Helper_Modules extends Sr_ModmanTracker_Helper_Data
{
    /**
     * Retrieve a collection of all modules
     *
     * @return Varien_Data_Collection Collection
     */
    public function getModulesCollection()
    {
        $sortValue = Mage::app()->getRequest()->getParam('sort', 'name');
        $sortValue = strtolower($sortValue);

        $sortDir = Mage::app()->getRequest()->getParam('dir', 'ASC');
        $sortDir = strtoupper($sortDir);

        $modules = $this->_loadModules();
        $modules = $this->sortMultiDimArr($modules, $sortValue, $sortDir);

        $collection = new Varien_Data_Collection();
        foreach ($modules as $key => $val) {
            $item = new Varien_Object($val);
            $collection->addItem($item);
        }

        return $collection;
    }

    /**
     * @return array Modules
     */
    protected function _loadModules()
    {
        $modules = array();

        $baseDir = Mage::getBaseDir();
        $path = './.modman/';
        foreach(glob($path . '*', GLOB_ONLYDIR) as $dir) {
            $_fail = false;
            $_info = '';

            $name = str_replace($path, '', $dir);
            $remoteUrl = $branchName = '';
            $commits = 'n/a';

            $remote = $url = $branches = $commitsBehind = $commitsBefore = array();

            chdir($dir);

            if (!is_dir('.git')) {
                $_fail = true;
                $_info = 'No GIT repository';
            }

            if (!$_fail) {
                // get remote url and name
                exec("git remote -v 2>&1", $remote, $returnVar);
                if (!sizeof($remote)) {
                    $_fail = true;
                    $_info = 'No Remote set';
                }

                // get remote url
                if (!$_fail) {
                    preg_match('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $remote[0], $url);
                    $remoteUrl = $url[0];

                    // get branch
                    exec("git branch -vv -v 2>&1", $branches, $returnVar);
                    foreach ($branches as $branch) {
                        $msg = explode(' ', $branch);
                        if ($msg[0] == '*') {
                            $branchName = $msg[1];
                            continue;
                        }
                    }

                    // get diff commits
                    $remoteName = strtok($remote[0], "\t");
                    exec("git rev-list HEAD...{$remoteName}/{$branchName} --right-only --count 2>&1", $commitsBehind, $returnVar);
                    exec("git rev-list HEAD...{$remoteName}/{$branchName} --left-only --count 2>&1", $commitsBefore, $returnVar);

                    if (isset($commitsBehind[0]) && isset($commitsBefore[0])) {
                        if (is_numeric($commitsBehind[0]) && is_numeric($commitsBefore[0])) {
                            $commits = (int) $commitsBehind[0] - (int) $commitsBefore[0];
                        } else {
                            $_fail = true;
                            $_info = 'No Remote commits found';
                        }
                    }
                }
            }

            $modules[] = array(
                'path'      => $dir,
                'name'      => $name,
                'commits'   => $commits,
                'url'       => $remoteUrl,
                'info'      => $_info,
            );

            chdir($baseDir);
        }
        return $modules;
    }
}
