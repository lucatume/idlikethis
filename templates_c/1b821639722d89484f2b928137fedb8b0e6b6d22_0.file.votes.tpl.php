<?php
/* Smarty version 3.1.29, created on 2016-07-04 16:07:10
  from "/Users/Luca/Sites/wp/wp-content/plugins/idlikethis/templates/metaboxes/votes.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_577a89ae392cb5_69597396',
  'file_dependency' => 
  array (
    '1b821639722d89484f2b928137fedb8b0e6b6d22' => 
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
function content_577a89ae392cb5_69597396 ($_smarty_tpl) {
?>
<div class="idlikethis-votesMetaBox">
    <h3 class="idlikethis-votesMetaBox__header"><?php echo $_smarty_tpl->tpl_vars['header_text']->value;?>
</h3>
    <?php if ($_smarty_tpl->tpl_vars['has_comments']->value) {?>
        <ul class="idlikethis-votesMetaBox__rows idlikethis-votesList">
            <?php
$_from = $_smarty_tpl->tpl_vars['rows']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_count_0_saved_item = isset($_smarty_tpl->tpl_vars['count']) ? $_smarty_tpl->tpl_vars['count'] : false;
$__foreach_count_0_saved_key = isset($_smarty_tpl->tpl_vars['idea']) ? $_smarty_tpl->tpl_vars['idea'] : false;
$_smarty_tpl->tpl_vars['count'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['idea'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['count']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['idea']->value => $_smarty_tpl->tpl_vars['count']->value) {
$_smarty_tpl->tpl_vars['count']->_loop = true;
$__foreach_count_0_saved_local_item = $_smarty_tpl->tpl_vars['count'];
?>
                <li class="idlikethis-votesMetaBox__row idlikethis-votesList__line idlikethis-ideaVotesLine">
                    <span class="idlikethis-ideaVotesLine__idea"><?php echo $_smarty_tpl->tpl_vars['idea']->value;?>
</span>
                    <span class="idlikethis-ideaVotesLine__separator"> - </span>
                    <span class="idlikethis-ideaVotesLine__count"><?php echo $_smarty_tpl->tpl_vars['count']->value;?>
</span>
                </li>
            <?php
$_smarty_tpl->tpl_vars['count'] = $__foreach_count_0_saved_local_item;
}
if ($__foreach_count_0_saved_item) {
$_smarty_tpl->tpl_vars['count'] = $__foreach_count_0_saved_item;
}
if ($__foreach_count_0_saved_key) {
$_smarty_tpl->tpl_vars['idea'] = $__foreach_count_0_saved_key;
}
?>
        </ul>
    <?php }?>
</div>

<?php }
}
