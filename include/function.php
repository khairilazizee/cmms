<?php

class fungsi {

function page($href, $limit, $rowstart, $numrows) {

            $n_info     = "<div align='center'>";

            if ($rowstart >= $limit) {

                $x = $rowstart-$limit;

                $n_info     = $n_info."<a href='$href&limit=$x'>Sebelum</a> | ";

            }

            $a = $numrows % $limit;

            $b = ($numrows - $a) / $limit;

            if($a != 0)

                $b++;

            $c = 1;

            while($c <= $b) {

                if($rowstart == (($c*$limit)-$limit))

                    $n_info     = $n_info."<span class='caltoday'>ms".$c."</span> ";

                else

                    $n_info     = $n_info."<a href='$href&limit=".(($c*$limit)-$limit)."'>ms".$c."</a> ";

                $c++;

            }

            if($rowstart+$limit<$numrows) {

                $x = $rowstart+$limit;

                $n_info     = $n_info." | <a href='$href&limit=$x'>Seterusnya</a>";

            }

            return $n_info."</div>";

        }

}

?>
