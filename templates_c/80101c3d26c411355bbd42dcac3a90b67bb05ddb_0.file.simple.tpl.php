<?php
/* Smarty version 3.1.29, created on 2016-07-04 12:44:31
  from "/Users/Luca/Sites/wp/wp-content/plugins/idlikethis/templates/shortcodes/simple.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_577a5a2f29a363_50088073',
  'file_dependency' => 
  array (
    '80101c3d26c411355bbd42dcac3a90b67bb05ddb' => 
    array (
      0 => '/Users/Luca/Sites/wp/wp-content/plugins/idlikethis/templates/shortcodes/simple.tpl',
      1 => 1460639139,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_577a5a2f29a363_50088073 ($_smarty_tpl) {
?>
<span class="idlikethis-button idlikethis-button--simple" data-post-id="<?php echo $_smarty_tpl->tpl_vars['post_id']->value;?>
" data-text="<?php echo $_smarty_tpl->tpl_vars['comment_text']->value;?>
">
    <button class="idlikethis-button__button">
        <span class="idlikethis-button__text"><?php echo $_smarty_tpl->tpl_vars['text']->value;?>
</span>
    </button>
</span>
<?php }
}
