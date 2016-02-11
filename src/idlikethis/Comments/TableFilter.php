<?php

class idlikethis_Comments_TableFilter implements idlikethis_Comments_TableFilterInterface
{
    /**
     * @var string
     */
    protected $comment_type;
    /**
     * @var idlikethis_Comments_TableContextInterface
     */
    private $context;

    /**
     * idlikethis_Comments_TableFilter constructor.
     * @param string $comment_type
     * @param idlikethis_Comments_TableContextInterface $context
     */
    public function __construct($comment_type = 'idlikethis', idlikethis_Comments_TableContextInterface $context)
    {
        $this->comment_type = $comment_type;
        $this->context = $context;
    }

    /**
     * Sets some query var parameters on the comments query before comments are fetched.
     *
     * @param WP_Comment_Query $query
     * @return void
     */
    public function on_pre_get_comments(WP_Comment_Query $query)
    {
        if (!$this->context->is_comments_edit_screen()) {
            return;
        }
        $old = isset($query->query_vars['type__not_in']) ? $query->query_vars['type__not_in'] : array();
        $query->query_vars['type__not_in'] = array_merge($old, (array)$this->comment_type);
    }
}