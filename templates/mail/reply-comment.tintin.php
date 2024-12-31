%extends('mail.layout')

%block('content')
  {{ get_greeting_by_time() }} <b>{{ $parent->user->name }}</b>,
  <br>
  <p>{{ $comment->user->name }} a répondu votre comment</p>
  <hr>
  <p style="font-size: 16px; padding: 10px; margin-top: 10px">
    <img src="{{ gravatar($parent->user->email, 20) }}" style="border-radius: 100px; position: relative; top: -5px; margin-right: 4px;"> {{ $parent->content }}
  </p>
  <p style="font-size: 16px; padding: 10px; margin-top: 10px; margin-left: 30px">
    <img src="{{ gravatar($comment->user->email, 20) }}" style="border-radius: 100px; position: relative; top: -5px; margin-right: 4px;"> {{ $comment->content }}
  </p>
  %include('mail.reject-message')
%endblock
