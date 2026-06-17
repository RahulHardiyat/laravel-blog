@props(['title', 'subtitle', 'date', 'user', 'description', 'link'])
<!-- Post preview-->
<div class="post-preview">
    <a href="{{ $link }}">
        <h2 class="post-title">{{ $title }}</h2>

        <h3 class="post-subtitle">
            @isset($description)
                {{ $description }}
            @endisset
        </h3>
    </a>
    <p class="post-meta">
        Posted by
        <a href="#!">{{ $user }}</a>
        {{ $date }}
    </p>
</div>
<!-- Divider-->
<hr class="my-4" />
