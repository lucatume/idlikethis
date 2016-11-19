<?php
/* Smarty version 3.1.30, created on 2016-11-10 13:42:31
  from "/Users/Luca/Sites/wp/wp-content/plugins/idlikethis/templates/shortcodes/simple.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58247947d2c180_28640926',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2392c3ba02d5194e80a1fd9a8b29418f99212eb1' => 
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
function content_58247947d2c180_28640926 (Smarty_Internal_Template $_smarty_tpl) {
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
