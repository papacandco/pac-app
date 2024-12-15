%raw
if (!isset($escaped)) {
  $escaped = true;
}
%endraw
%markdown
%if($escaped)
{{{ $content }}}
%else
{{{ $content }}}
%endif
%endmarkdown
