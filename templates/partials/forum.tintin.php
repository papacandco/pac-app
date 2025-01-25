<h3 class="font-weight-bolder">
  Communauté
</h3>
<p>Vous pouvez accéder au forum de la formation <a href="{{ $forum_link }}" target="_blank" style="text-decoration: underline;">ici</a>.</p>

%loop($questions as $question)
  %isset($simple_form)
  <div style="word-wrap: break-word; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
    <img src="{{ gravatar($question->author->email) }}"
      class="img-circle img-responsive" style="width: 25px; display: inline-block;">
     <span class="text-muted">
      <a href="{{ route('forum.question', ['id' => $question->id, 'slug' => $question->slug]) }}" style="text-decoration: underline;">
        {{ str_words($question->title, 100, '...') }}
      </a>
    </span>
  </div>
  %else
    %include('forum.partials.question', ['question' => $question, 'style' => isset($style) ? $style : '', 'type' => 'forum'])
  %endisset
%endloop

%if(count($questions) == 0)
  <div style="word-wrap: break-word; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
    {{ __('about.comment.no_data') }}
  </div>
%endif
