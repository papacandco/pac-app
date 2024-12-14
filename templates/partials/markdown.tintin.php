%php
if (!isset($escaped)) {
  $escaped = true;
}
%endphp
%markdown
%if ($escaped)
{{{ $content }}}
%else
{{{ $content }}}
%endif
%endmarkdown
