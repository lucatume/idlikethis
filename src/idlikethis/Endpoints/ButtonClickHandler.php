<?php

class idlikethis_Endpoints_ButtonClickHandler implements idlikethis_Endpoints_ButtonClickHandlerInterface
{
    /**
     * @var idlikethis_Endpoints_AuthHandlerInterface
     */
    protected $auth_handler;

    /**
     * @var idlikethis_Repositories_CommentsRepositoryInterface
     */
    protected $comments_repository;

    public function __construct(idlikethis_Endpoints_AuthHandlerInterface $auth_handler, idlikethis_Repositories_CommentsRepositoryInterface $comments_repository)
    {
        $this->auth_handler = $auth_handler;
        $this->comments_repository = $comments_repository;
    }

    /**
     * Handles a button click request.
     *
     * @return bool `true` if the request was successfully handled, `false` otherwise.
     */
    public function handle()
    {
        $headers = array();

        if (!$this->auth_handler->verify_auth($_POST, 'button-click')) {
            return new WP_REST_Response('Invalid auth', 403, $headers);
        }

        if (empty($_POST['post_id']) || empty($_POST['content'])) {
            return new WP_REST_Response('Missing data', 400, $headers);
        }
        $post_id = $_POST['post_id'];
        $content = $_POST['content'];

        $exit = $this->comments_repository->add_for_post($post_id, $content);

        $message = empty($exit) ? 'Could not register click' : $exit;
        $status = empty($exit) ? 400 : 200;

        return new WP_REST_Response($exit, $status, $headers);
    }
}
