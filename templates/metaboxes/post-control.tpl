<div class="idlikethis-postControlMetaBox">
    <h3 class="idlikethis-postControlMetaBox__header">{$header_text}</h3>
    {if $has_comments}
        <div class="idlikethis-postControlMetaBox__controls">
            <div class="idlikethis-postControlMetaBox__control">
                <button id="idlikethis-reset-all" class="button button-primary button-large" data-post-id="{$post_id}">
                    {$reset_all_text}
                </button>
            </div>
            <div class="idlikethis-postControlMetaBox__control">
                <button id="idlikethis-consolidate-all" class="button button-primary button-large" data-post-id="{$post_id}">
                    {$consolidate_all_text}
                </button>
            </div>
        </div>
    {/if}
</div>

