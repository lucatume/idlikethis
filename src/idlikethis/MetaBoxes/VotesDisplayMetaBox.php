<?php

class idlikethis_MetaBoxes_VotesDisplayMetaBox implements idlikethis_MetaBoxes_VotesDisplayMetaBoxInterface
{
    /**
     * @var idlikethis_Repositories_CommentsRepositoryInterface
     */
    protected $comments_repository;

    /**
     * @var idlikethis_Texts_VotesMetaBoxTextProviderInterface
     */
    protected $texts;

    /**
     * @var idlikethis_Templates_RenderEngineInterface
     */
    protected $render_engine;

    /**
     * @var string
     */
    protected $template_slug;

    /**
     * @var array
     */
    protected $template_data;

    public function __construct(idlikethis_Repositories_CommentsRepositoryInterface $comments_repository, idlikethis_Templates_RenderEngineInterface $render_engine, idlikethis_Texts_VotesMetaBoxTextProviderInterface $texts)
    {
        $this->comments_repository = $comments_repository;
        $this->render_engine = $render_engine;
        $this->texts = $texts;

        $this->template_slug = 'metaboxes/votes';
        $this->template_data = array();
    }

    /**
     * Returns the meta box id.
     *
     * @return string
     */
    public function id()
    {
        return 'idlikethis-vote-display';
    }

    /**
     * Returns the meta box title.
     *
     * @return string
     */
    public function title()
    {
        return __("I'd like to see the votes", 'idlikethis');
    }

    /**
     * Returns the screen(s) the meta box should display on.
     *
     * @return string|array|WP_Screen
     */
    public function screen()
    {
        return array('post', 'page');
    }

    /**
     * Returns the context the meta box should display into.
     *
     * @return string
     */
    public function context()
    {
        return 'side';
    }

    /**
     * Returns the priority for the meta box.
     *
     * @return string
     */
    public function priority()
    {
        return 'high';
    }

    /**
     * Echoes the meta box markup to the page.
     *
     * @param string|WP_Post|array $object
     * @param array|mixed $box The meta box registration description.
     * @return void
     */
    public function render($object, $box)
    {
        $comments = $this->comments_repository->get_comments_for_post($object);
        if (empty($comments)) {
            $this->template_data['has_comments'] = false;
            $this->template_data['header_text'] = $this->texts->get_empty_comments_text();
        } else {
            $this->template_data['has_comments'] = true;
            $this->template_data['header_text'] = $this->texts->get_comments_title_text();
            array_walk($comments, array($this, 'count_comments'));
            arsort($comments);
            $this->template_data['rows'] = $comments;
        }

        echo $this->render_engine->render($this->template_slug, $this->template_data);
    }

    protected function count_comments(array &$comments, $text)
    {
        $comments = count($comments);
    }
}