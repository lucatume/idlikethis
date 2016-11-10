<?php
/* Smarty version 3.1.30, created on 2016-11-10 13:42:35
  from "/Users/Luca/Sites/wp/wp-content/plugins/idlikethis/templates/metaboxes/post-control.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5824794b79d349_80490565',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bc4f1f8a5d12f276a81f6b390a978e4e022578da' => 
    array (
      0 => '/Users/Luca/Sites/wp/wp-content/plugins/idlikethis/templates/metaboxes/post-control.tpl',
      1 => 1460639139,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5824794b79d349_80490565 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="idlikethis-postControlMetaBox">
    <h3 class="idlikethis-postControlMetaBox__header"><?php echo $_smarty_tpl->tpl_vars['header_text']->value;?>
</h3>
    <?php if ($_smarty_tpl->tpl_vars['has_comments']->value) {?>
        <div class="idlikethis-postControlMetaBox__controls">
            <div class="idlikethis-postControlMetaBox__control">
                <button id="idlikethis-reset-all" class="button button-primary button-large" data-post-id="<?php echo $_smarty_tpl->tpl_vars['post_id']->value;?>
">
                    <?php echo $_smarty_tpl->tpl_vars['reset_all_text']->value;?>

                </button>
            </div>
            <div class="idlikethis-postControlMetaBox__control">
                <button id="idlikethis-consolidate-all" class="button button-primary button-large" data-post-id="<?php echo $_smarty_tpl->tpl_vars['post_id']->value;?>
">
                    <?php echo $_smarty_tpl->tpl_vars['consolidate_all_text']->value;?>

                </button>
            </div>
        </div>
    <?php }?>
</div>

<?php }
}
