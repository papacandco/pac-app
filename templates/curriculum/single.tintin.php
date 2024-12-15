%extends('layouts.app', ['active' => 'curriculum'])

%block('title', $curriculum->title . ' - formation')

%block('seo')
  %include('partials.seo', [
    'title'         => $curriculum->title,
    'description'   => $curriculum->description,
    'image'         => $curriculum->cover ?? config('meta.image')
  ])
%endblock

%block('content')
%include('curriculum.partials.curriculum-header')
<section class="container">
  <div class="row" style="margin-left: unset; margin-right: unset">
    <section class="col-sm-8" style="margin-top: 10px;">
      <div class="video-mobile">
        %include('partials.video', ['url' => $curriculum->video, 'mode' => 'video'])
      </div>
      <div class="row" style="margin-top: 18px;">
        %if(strlen($curriculum->long_description) > 0)
        <div class="col-sm-12 text-justify" style="padding: 2px">
          %include('partials.markdown', ['content' => $curriculum->long_description])
        </div>
        %endif
        <div class="col-sm-12" style="margin-top: 10px; padding: 2px">
          %forelse($curriculum->sections as $key => $section)
            <h3><span class="font-weight-bold">Chapitre {{ $key + 1 }} </span> - {{ $section->title }}</h3>
            <p class="text-muted">{{ $section->description }}</p>
            %loop($section->tutorials as $tutorial)
              %include('curriculum.partials.tutorial', ['tutorial' => $tutorial, 'size' => 6])
            %endloop
          %empty
            %include('partials.no-data', ['message' => __('tutorial.no_data')])
          %endforelse
        </div>
      </div>
    </section>
    <aside class="col-sm-2 visible-xs" style="margin-top: 10px; padding: 10px">
      %include('layouts.content-sidebar', ['class' => 'nav-pills'])
    </aside>
    <aside class="col-sm-4" style="margin-top: 10px; padding: 10px">
      <div class="row">
        <div class="col-xs-12">
          %include('partials.social-sidebar', [
            'title' => $curriculum->title,
            'without_title' => false,
            'class' => 'nav-pills',
            'url' => route('curriculum.single', ['slug' => $curriculum->slug])
          ])
        </div>
      </div>
      <br />
      %include('partials.ads-sider')
      %if($curriculum->with_forum)
        <div class="row">
          <div class="col-sm-12">
            %include('partials.forum', [
              'questions' => $curriculum->lastQuestion(5),
              'title' => $curriculum->title,
              "style" => "padding-left: 5px; font-size: 14px;",
              'forum_link' => route('forum.single', ['slug' => $curriculum->slug, 'id' => $curriculum->id])
            ])
          </div>
        </div>
      %endif
      <div class="row">
        <div class="col-sm-12">
          %include('partials.about', ["disable_about" => true])
        </div>
      </div>
    </aside>
  </div>
</section>
%endblock
