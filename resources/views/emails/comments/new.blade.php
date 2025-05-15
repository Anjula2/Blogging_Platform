@component('mail::message')
# New Comment on "{{ $comment->post->title }}"

{{ $comment->user->name }} commented:

> {{ $comment->body }}

@component('mail::button', ['url' => route('blog.show', $comment->post->slug)])
View Post
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
