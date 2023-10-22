<div wire:model.live="show" class="w-full py-4 flex text-light-text-color justify-between">
    @if ($showCommentButton && $post->isParent())
        <livewire:catalyst::replies-modal :post="$post" wire:key="replies-post-{{ $post->id }}" :show="$show"/>
    @endif

    @if ($showLikeButton)
        <livewire:catalyst::partials.like-button :model="$post"/>
    @endif
    @if ($showRepostButton)
        <livewire:catalyst::partials.repost-button :model="$post" :show="$show"/>
    @endif
    @if ($showShareButton)
        <livewire:catalyst::partials.share-button :model="$post" :show="$show"/>
    @endif

    @if ($showBookmarkButton)
        <livewire:catalyst::partials.bookmark-button :model="$post"/>
    @endif
</div>
