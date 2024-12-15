%extends('mail.layout')

%raw
$route = route('forum.question', [
  'slug' => $question->slug,
  'id' => $question->id
]);

$forum_route = route('forum.single', [
  'slug' => $curriculum->slug,
  'id' => $curriculum->id
]);
%endraw

%block('content')
{{ get_greeting_by_time() }} <b>{{ $user->name }}</b>,
<br>
<p>{{ $user->name }} a envoyé une question dans le forum <a href="{{ $forum_route }}">{{ $curriculum->title }}</a></p>
<p><a href="{{ $route }}">{{ $question->title }}</a></p>
<hr>
<p style="font-size: 16px; padding: 10px; margin-top: 10px">
	<img src="{{ gravatar($user->email, 20) }}" style="border-radius: 100px; position: relative; top: -5px; margin-right: 4px;"> {{ $question->content }}
</p>
%include('mail.reject-message')
%endblock
