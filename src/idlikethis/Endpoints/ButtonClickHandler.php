<?php

class idlikethis_Endpoints_ButtonClickHandler implements idlikethis_Endpoints_ButtonClickHandlerInterface
{
    /**
     * @var idlikethis_Endpoints_AuthHandlerInterface
     */
    protected $auth_handler;

    /**
     * @var idlikethis_Repositories_VotesRepositoryInterface
     */
    protected $comments_repository;

    public function __construct(idlikethis_Endpoints_AuthHandlerInterface $auth_handler, idlikethis_Repositories_VotesRepositoryInterface $comments_repository)
    {
        $this->auth_handler = $auth_handler;
        $this->comments_repository = $comments_repository;
    }

    /**
     * Handles a button click request.
     *
     * @return bool `true` if the request was successfully handled, `false` otherwise.
     */
    public function handle(WP_REST_Request $request)
    {
        $headers = array();

        if (!$this->auth_handler->verify_auth($request, 'button-click')) {
            return new WP_REST_Response('Invalid auth', 403, $headers);
        }

        $post_id = $request->get_param('post_id');
        $content = $request->get_param('content');

        if (empty($post_id) || empty($content)) {
            return new WP_REST_Response('Missing data', 400, $headers);
        }

        $comment_id = $this->comments_repository->add_vote_for_post($post_id, $content);

        $message = empty($comment_id) ? 'Could not register click' : $comment_id;
        $status = empty($comment_id) ? 400 : 200;

        return new WP_REST_Response($comment_id, $status, $headers);
    }
}
