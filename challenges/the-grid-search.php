<?php

declare(strict_types=1);

/**
 * @url https://www.hackerrank.com/challenges/the-grid-search/problem
 */
class GridSearch
{
    private function pairMatches(int $rowNumber, array $matches): array
    {
        $cords = [];

        foreach($matches[0] as $match)
        {
            $charPosition = $match[1];
            $cords[] = [$rowNumber, $charPosition];
        }

        return $cords;
    }

    private function findHeadCandidates(array $G, array $P, int $R, int $r): array
    {
        $ret = [];

        $r1 = $R - $r;
        $regex = "/(?=(" . $P[0] . "))/";

        for ($i = 0; $i <= $r1; $i++) {
            if (preg_match_all($regex, $G[$i], $m, PREG_OFFSET_CAPTURE)) {
                $coords = $this->pairMatches($i, $m);
                $ret = array_merge($ret, $coords);
            }
        }

        return $ret;
    }

    private function findPattern(array $G, array $P, int $r, int $c, int $X, int $Y)
    {
        if (1 === $r) {
            return true;
        }

        $X1 = $X + 1;
        $X2 = $X1 + $r - 1;

        $x1 = 1;

        for ($i = $X1; $i < $X2; $i++) {

            $p = substr($G[$i], $Y, $c);

            if ($p !== $P[$x1]) {
                return false;
            }

            $x1++;
        }

        return true;
    }

    public function solve(array $G, array $P, int $R, int $r, int $c): bool
    {
        $headCandidates = $this->findHeadCandidates($G, $P, $R, $r);

        foreach ($headCandidates as list($X, $Y)) {
            if ($this->findPattern($G, $P, $r, $c, $X, $Y)) {
                return true;
            }
        }

        return false;
    }
}

$gridSearch = new GridSearch();

$handle = fopen ("php://stdin","r");
fscanf($handle,"%d",$t);
for($a0 = 0; $a0 < $t; $a0++){
    fscanf($handle,"%d %d",$R,$C);
    $G = array();
    for($G_i = 0; $G_i < $R; $G_i++){
        fscanf($handle,"%s",$G[]);
    }
    fscanf($handle,"%d %d",$r,$c);
    $P = array();
    for($P_i = 0; $P_i < $r; $P_i++){
        fscanf($handle,"%s",$P[]);
    }

    $result = $gridSearch->solve($G, $P, $R, $r, $c);
    echo ($result ? "YES" : "NO") . PHP_EOL;
}