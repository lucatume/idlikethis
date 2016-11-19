<?php
/* Smarty version 3.1.30, created on 2016-11-10 13:42:35
  from "/Users/Luca/Sites/wp/wp-content/plugins/idlikethis/templates/metaboxes/votes.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5824794b795f30_06474079',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f9e007da80a9667559a9b2668b3bef45853de43f' => 
    array (
      0 => '/Users/Luca/Sites/wp/wp-content/plugins/idlikethis/templates/metaboxes/votes.tpl',
      1 => 1460639139,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5824794b795f30_06474079 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="idlikethis-votesMetaBox">
    <h3 class="idlikethis-votesMetaBox__header"><?php echo $_smarty_tpl->tpl_vars['header_text']->value;?>
</h3>
    <?php if ($_smarty_tpl->tpl_vars['has_comments']->value) {?>
        <ul class="idlikethis-votesMetaBox__rows idlikethis-votesList">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rows']->value, 'count', false, 'idea');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['idea']->value => $_smarty_tpl->tpl_vars['count']->value) {
?>
                <li class="idlikethis-votesMetaBox__row idlikethis-votesList__line idlikethis-ideaVotesLine">
                    <span class="idlikethis-ideaVotesLine__idea"><?php echo $_smarty_tpl->tpl_vars['idea']->value;?>
</span>
                    <span class="idlikethis-ideaVotesLine__separator"> - </span>
                    <span class="idlikethis-ideaVotesLine__count"><?php echo $_smarty_tpl->tpl_vars['count']->value;?>
</span>
                </li>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </ul>
    <?php }?>
</div>

<?php }
}
