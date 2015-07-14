<?php

namespace Knapsack;

class SlicedCollection extends Collection
{
    /**
     * @var int
     */
    private $index;

    /**
     * @var int
     */
    private $to;

    /**
     * @var int
     */
    private $from;

    /**
     * @param array|\Traversable $input
     * @param int $from
     * @param int $to
     */
    public function __construct($input, $from, $to = 0)
    {
        parent::__construct($input);
        $this->to = $to;
        $this->from = $from;
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        $valid = parent::valid();
        while ($valid && $this->index < $this->from) {
            $valid = parent::valid();
            $this->next();
        }

        if ($this->index > $this->to && $this->to !== 0) {
            return FALSE;
        }

        return $valid;
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        parent::next();
        $this->index++;
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        parent::rewind();
        $this->index = 1;
    }
}