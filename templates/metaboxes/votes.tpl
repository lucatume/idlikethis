<div class="idlikethis-votesMetaBox">
    <h3 class="idlikethis-votesMetaBox__header">{$header_text}</h3>
    {if $has_comments}
        <ul class="idlikethis-votesMetaBox__rows idlikethis-votesList">
            {foreach $rows as $idea => $count}
                <li class="idlikethis-votesMetaBox__row idlikethis-votesList__line idlikethis-ideaVotesLine">
                    <span class="idlikethis-ideaVotesLine__idea">{$idea}</span>
                    <span class="idlikethis-ideaVotesLine__separator"> - </span>
                    <span class="idlikethis-ideaVotesLine__count">{$count}</span>
                </li>
            {/foreach}
        </ul>
    {/if}
</div>

