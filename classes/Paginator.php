<?php

/**
 * Paginator
 *
 * Data for selecting a page of records
 */
class Paginator
{
    /**
     * Number of records to return
     * @var integer
     */
    public $limit;

    /**
     * Number of records to skip before the page
     * @var integer
     */
    public $offset;

    /**
     * Previous page number
     * @var integer
     */
    public $previous;

    /**
     * Next page number
     * @var integer
     */    
  
    public $next;
    
    /**
     * total no: of pages
     *
     * @var mixed
     */
    public $total;
    
    /**
     * current page
     *
     * @var mixed
     */
    public $current;

    /**
     * Constructor
     *
     * @param integer $page Page number
     * @param integer $records_per_page Number of records per page
     * @param integer $total Total number of records
     *
     * @return void
     */
    public function __construct($page, $records_per_page, $total_records)
    {
        $this->limit = $records_per_page;

        $page = filter_var($page, FILTER_VALIDATE_INT, [
            'options' => [
                'default' => 1,
                'min_range' => 1,
            ],
        ]);

        if ($page > 1) {
            $this->previous = $page - 1;
        }

        $this->total = ceil($total_records / $records_per_page);

        if ($page < $this->total) {
            $this->next = $page + 1;
        }
        $this->current = $page;
        $this->offset = $records_per_page * ($page - 1);
    }
}