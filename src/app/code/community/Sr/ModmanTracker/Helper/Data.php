<?php

class Sr_ModmanTracker_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Sorts a multi-dimensional array with the given values
     *
     * Seen and modified from: http://www.firsttube.com/read/sorting-a-multi-dimensional-array-with-php/
     *
     * @param  array  $arr Array to sort
     * @param  string $key Field to sort
     * @param  string $dir Direction to sort
     * @return array  Sorted array
     */
    public function sortMultiDimArr($arr, $key, $dir = 'ASC')
    {
        foreach ($arr as $k => $v) {
            $b[$k] = strtolower($v[$key]);
        }

        if ($dir == 'ASC') {
            asort($b);
        } else {
            arsort($b);
        }
        foreach ($b as $key => $val) {
            $c[] = $arr[$key];
        }

        return $c;
    }
}
