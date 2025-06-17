 <?php       
    function sortArrayOfAssociativeArrays(&$array, $key, $order = 'asc') {
        usort($array, function($a, $b) use ($key, $order) {
            if (!isset($a[$key]) || !isset($b[$key])) return 0;

            $valA = $a[$key];
            $valB = $b[$key];

            // Check if both are numeric values
            if (is_numeric($valA) && is_numeric($valB)) {
                // Compare numerically
                $result = $valA - $valB;
            } else {
                // Compare as strings, case-insensitive (change to strcmp for case-sensitive)
                $result = strcasecmp((string)$valA, (string)$valB);
            }

            if ($result === 0) return 0;

            return ($order === 'asc') ? (($result < 0) ? -1 : 1) : (($result > 0) ? -1 : 1);
        });

        return $array;
    }