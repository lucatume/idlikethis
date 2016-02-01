<?php

class idlikethis_Shortcodes_Simple implements idlikethis_Shortcodes_ShortcodeInterface
{
    /**
     * @var string
     */
    protected $template_slug;

    /**
     * @var array
     */
    protected $template_data;

    /**
     * @var idlikethis_Templates_RenderEngineInterface
     */
    protected $render_engine;

    /**
     * @var idlikethis_Texts_TextProviderInterface
     */
    protected $text_provider;

    /**
     * @param idlikethis_Templates_RenderEngineInterface $render_engine
     * @param idlikethis_Texts_ProviderInterface $text_provider
     */
    public function __construct(idlikethis_Templates_RenderEngineInterface $render_engine, idlikethis_Texts_ProviderInterface $text_provider)
    {
        $this->render_engine = $render_engine;
        $this->template_slug = 'shortcodes/simple';
        $this->text_provider = $text_provider;
        $this->template_data = array(
            'text' => $this->text_provider->get_button_text(),
        );
    }

    /**
     * Returns the shortcode tag.
     *
     * @return string
     */
    public function get_tag()
    {
        return 'idlikethis';
    }

    /**
     * Returns the shortcode rendered markup code.
     *
     * @param string|array $attributes An array of shortcode attributes.
     * @param string $content The shortcode content.
     *
     * @return string
     */
    public function render($attributes = array(), $content = '')
    {
        return $this->render_engine->render($this->template_slug, $this->template_data);
    }

    /**
     * @param $template_slug
     */
    public function set_template_slug($template_slug)
    {
        if (!is_string($template_slug) || empty($template_slug)) {
            throw new InvalidArgumentException('Template slug must be a non empty string');
        }
        $this->template_slug = $template_slug;
    }

    /**
     * @param array $data
     */
    public function set_template_data(array $data)
    {
        $this->template_data = $data;
    }
}