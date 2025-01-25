<section class="jumbotron jumbotron-gray text-left" style="padding-top: 10px; padding-bottom: 5px;">
  <header class="container">
    <div class="row" style="padding-bottom: 30px">
      %auth
        <div class="col-sm-12">
          %include("curriculum.partials.progression")
        </div>
      %endauth
      <div class="col-sm-4 hidden-xs">
        <img class="img-responsive" alt="{{ $curriculum->title }}" src="{{ $curriculum->cover }}"
          style="width: auto; height: auto; position: relative; top: 25px;">
      </div>
      <div class="col-sm-8">
        <img class="pull-right img-responsive visible-xs" alt="{{ $curriculum->title }}" src="{{ $curriculum->cover }}"
          style="width: 70px; height: 70px; position: relative; top: 0px;">
        <h2 style="font-size: 25px; font-weight: 700;">{{ $curriculum->title }}</h2>
        <p>{{ $curriculum->description }}</p>
        %raw $part = explode(' ', $curriculum->duration); %endraw
        <div class="row">
          <div class="col-xs-12 col-sm-8" style="position: relative; top: 8px">
            <p><b style="font-weight: bold">{{ $part[0] }} {{ strtolower($part[1]) }} de vidéos</b> &bull; <b style="font-weight: bold">{{ \App\Models\Curriculum::LEVEL[$curriculum->level] }}</b> %auth&bull; <b style="font-weight: bold">Terminé à {{ $curriculum->computeProgression(auth()->user()) }}%</b>%endauth</p>
          </div>
          <div class="col-xs-12 col-sm-4" style="position: relative; top: 8px">
            %if($curriculum->isOneTimePayment())
              <strong><i class="fa fa-star text-warning" title="Premium"></i> &nbsp; {{ $curriculum->price }} FCFA</strong>
            %endif
            %if($curriculum->isPremium())
              <strong><i class="fa fa-star text-warning" title="Premium"></i> &nbsp; Premium</strong>
            %endif
          </div>
        </div>
      </div>
    </div>
  </header>
</section>
%auth
  %include("curriculum.partials.follow-modal")
%endauth
