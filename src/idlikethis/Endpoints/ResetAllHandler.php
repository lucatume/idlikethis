<?php

class idlikethis_Endpoints_ResetAllHandler implements idlikethis_Endpoints_ResetAllHandlerInterface
{
    /**
     * @var idlikethis_Endpoints_AuthHandlerInterface
     */
    protected $auth_handler;

    /**
     * @var idlikethis_Repositories_VotesRepositoryInterface
     */
    protected $comments_repository;

    public function __construct(idlikethis_Endpoints_PostAdminAuthHandlerInterface $auth_handler, idlikethis_Repositories_VotesRepositoryInterface $comments_repository)
    {
        $this->auth_handler = $auth_handler;
        $this->comments_repository = $comments_repository;
    }

    /**
     * Handles a request.
     *
     * @return bool `true` if the request was successfully handled, `false` otherwise.
     */
    public function handle(WP_REST_Request $request)
    {
        $headers = array();

        if (!$this->auth_handler->verify_auth($request, 'reset-all')) {
            return new WP_REST_Response('Invalid auth', 403, $headers);
        }

        $post_id = $request->get_param('post_id');

        if (empty($post_id)) {
            return new WP_REST_Response('Missing post ID', 400, $headers);
        }

        $exit = $this->comments_repository->reset_votes_for_post($post_id);

        $status = $exit === false ? 400 : 200;

        return new WP_REST_Response($exit, $status, $headers);
    }
}