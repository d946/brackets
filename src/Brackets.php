<?php


namespace D946;


class Brackets
{

    protected $allowChar = ['(', ')', ' ', "\t", "\n", "\r"];

    protected $data = [];

    protected $nSets = [];

    public function load($expression)
    {
        if ('' === $expression) {
            throw new \InvalidArgumentException('Empty string');
        }
        $this->data = str_split($expression);
        if (!$this->validate()) {
            throw new \InvalidArgumentException('Wrong char in string');
        };
    }

    public function verify($withAST = false)
    {
        if (!$this->verifyCount()) {
            return false;
        };
        if ($withAST) {
            if (!$this->verifyOrderWithAST()) {
                return false;
            };
        } else {
            if (!$this->verifyOrder()) {
                return false;
            };
        }
        return true;
    }

    public function setAllowChar($allowChar)
    {
        $this->allowChar = $allowChar;
    }

    public function getAST()
    {
        return $this->nSets;
    }

    protected function validate()
    {
        $sArr = array_unique($this->data);
        $aDiff = array_diff($sArr, $this->allowChar);
        return empty($aDiff);
    }

    protected function verifyCount()
    {
        $itemCount = array_count_values($this->data);
        $countOpened = $itemCount['('] ?? 0;
        $countClosed = $itemCount[')'] ?? 0;
        return $countOpened == $countClosed;
    }

    protected function verifyOrder()
    {
        $level = 0;
        foreach ($this->data as $ch) {
            if ('(' == $ch) {
                $level++;

            } elseif (')' == $ch) {
                if ($level < 1) {
                    return false;
                }
                $level--;
            }
        }
        if ($level > 0) {
            return false;
        }
        return true;
    }

    protected function verifyOrderWithAST()
    {
        $level = 0;
        $this->nSet = [];
        $stack = [];
        $id = 1;
        foreach ($this->data as $key => $ch) {
            if ('(' == $ch) {
                $this->nSet[$id] = [
                    'begin' => $key,
                    'lgt' => $id,
                    'rgt' => null,
                    'level' => $level
                ];
                array_push($stack, $id);
                $id++;
                $level++;

            } elseif (')' == $ch) {
                if ($level < 1) {
                    return false;
                }
                $tempId = array_pop($stack);
                $this->nSet[$tempId]['end'] = $key;
                $this->nSet[$tempId]['rgt'] = $id;
                $id++;
                $level--;
            }
        }
        if ($level > 0) {
            return false;
        }
        return true;
    }
}