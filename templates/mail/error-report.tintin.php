%extends('mail.layout')

%block('content')
  <br>
  <p>
    <b>Url</b>: {{ $error_url }}<br/><br/>
    <b>Message</b>: {{{ $error_message }}}<br/><br/>
    <b>Filename</b>: {{{ $error_file }}}<br/><br/>
    <b>Line</b>: {{ $error_line }}<br/><br/>
  </p>
  %if(count($error_context) > 0)
    <p>
      <b>Context</b>
      ID: {{ $error_context['id'] }}<br>
      Username: {{ $error_context['name'] }}<br>
      email: {{ $error_context['email'] }}<br>
      Country: {{ $error_context['country'] ?? 'Undefined' }}<br>
    </p>
  %endif
  <hr>
  <p>{{{ preg_replace('/\s#/', '<br/><br/> #', $error_trace) }}}</p>
  %include('mail.reject-message')
%endblock
