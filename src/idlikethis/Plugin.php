<?php

class idlikethis_Plugin
{
    /**
     * @var string
     */
    protected $dir_path;

    /**
     * @var string
     */
    protected $dir_url;

    public function __construct()
    {
        $root_folder = dirname(dirname(dirname(__FILE__)));
        $root_file = $root_folder . '/idlikethis.php';
        $this->dir_path = plugin_dir_path($root_file);
        $this->dir_url = plugin_dir_url($root_file);
    }

    public function dir_path($frag = '')
    {
        if (empty($frag)) {
            return $this->dir_path;
        }

        if (!is_string($frag)) {
            throw new InvalidArgumentException('Frag must be a string');
        }
        return $this->dir_path . ltrim($frag, DIRECTORY_SEPARATOR);
    }

    public function dir_url($frag)
    {
        if (empty($frag)) {
            return $this->dir_url;
        }

        if (!is_string($frag)) {
            throw new InvalidArgumentException('Frag must be a string');
        }
        return $this->dir_url . ltrim($frag, DIRECTORY_SEPARATOR);
    }
}