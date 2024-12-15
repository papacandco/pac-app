%extends('mail.layout')

%raw
$route = route('forum.question', [
  'slug' => $question->slug,
  'id' => $question->id
]);
%endraw

%block('content')
{{ get_greeting_by_time() }} <b>{{ $bookmark->user->name }}</b>,
<br>
<p>{{ $comment->user->name }} a répondu à la question <a href="{{ $route }}">{{ $question->title }}</a></p>
<hr>
<p style="font-size: 16px; padding: 10px; margin-top: 10px">
	<img src="{{ gravatar($comment->user->email, 20) }}" style="border-radius: 100px; position: relative; top: -5px; margin-right: 4px;"> {{ $comment->content }}
</p>
%include('mail.reject-message')
%endblock
