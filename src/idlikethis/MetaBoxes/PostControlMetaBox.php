<?php

class idlikethis_MetaBoxes_PostControlMetaBox implements idlikethis_MetaBoxes_PostControlMetaBoxInterface
{
    /**
     * @var idlikethis_Repositories_VotesRepositoryInterface
     */
    protected $comments_repository;

    /**
     * @var idlikethis_Templates_RenderEngineInterface
     */
    protected $render_engine;

    /**
     * @var idlikethis_Texts_PostControlMetaBoxTextsProviderInterface
     */
    protected $texts;

    /**
     * @var string
     */
    protected $template_slug;

    /**
     * @var array
     */
    protected $template_data;

    /**
     * @var idlikethis_Contexts_MetaBoxContextInterface
     */
    protected $context;

    /**
     * idlikethis_MetaBoxes_PostControlMetaBox constructor.
     * @param idlikethis_Repositories_VotesRepositoryInterface $comments_repository
     * @param idlikethis_Templates_RenderEngineInterface $rendering_engine
     * @param idlikethis_Texts_PostControlMetaBoxTextsProviderInterface $texts_provider
     * @param idlikethis_Contexts_MetaBoxContextInterface $context
     */
    public function __construct(idlikethis_Repositories_VotesRepositoryInterface $comments_repository, idlikethis_Templates_RenderEngineInterface $rendering_engine, idlikethis_Texts_PostControlMetaBoxTextsProviderInterface $texts_provider, idlikethis_Contexts_MetaBoxContextInterface $context)
    {
        $this->comments_repository = $comments_repository;
        $this->render_engine = $rendering_engine;
        $this->texts = $texts_provider;

        $this->template_slug = 'metaboxes/post-control';
        $this->template_data = array();
        $this->context = $context;
    }

    /**
     * Returns the meta box id.
     *
     * @return string
     */
    public function id()
    {
        return 'idlikethis-post-control';
    }

    /**
     * Returns the meta box title.
     *
     * @return string
     */
    public function title()
    {
        return __("I'd like to control", 'idlikethis');
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
        $comments = $this->comments_repository->get_votes_for_post($object);
        if (empty($comments)) {
            $this->template_data['has_comments'] = false;
            $this->template_data['header_text'] = $this->texts->get_empty_comments_text();
        } else {
            $this->template_data['has_comments'] = true;
            $this->template_date['header_text'] = $this->texts->get_comments_title_text();
            $this->template_data['reset_all_text'] = $this->texts->get_reset_all_text();
            $this->template_data['consolidate_all_text'] = $this->texts->get_consolidate_all_text();
            $this->template_data['post_id'] = $this->context->get_post_id();
        }

        echo $this->render_engine->render($this->template_slug, $this->template_data);
    }
}