<div wire:model.live="show" class="w-full py-4 flex text-light-text-color justify-between">
    @if ($showCommentButton && $post->isParent())
        <livewire:catalyst-social::replies-modal :post="$post" wire:key="replies-post-{{ $post->id }}" :show="$show"/>
    @endif

    @if ($showLikeButton)
        <livewire:catalyst-social::partials.like-button :model="$post"/>
    @endif
    @if ($showRepostButton)
        <livewire:catalyst-social::partials.repost-button :model="$post" :show="$show"/>
    @endif
    @if ($showShareButton)
        <livewire:catalyst-social::partials.share-button :model="$post" :show="$show"/>
    @endif

    @if ($showBookmarkButton)
        <livewire:catalyst-social::partials.bookmark-button :model="$post"/>
    @endif
</div>
