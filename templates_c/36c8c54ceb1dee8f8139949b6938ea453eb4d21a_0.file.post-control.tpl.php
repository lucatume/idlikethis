<?php
/* Smarty version 3.1.29, created on 2016-07-04 16:07:10
  from "/Users/Luca/Sites/wp/wp-content/plugins/idlikethis/templates/metaboxes/post-control.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_577a89ae3a78a8_21241179',
  'file_dependency' => 
  array (
    '36c8c54ceb1dee8f8139949b6938ea453eb4d21a' => 
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
function content_577a89ae3a78a8_21241179 ($_smarty_tpl) {
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
