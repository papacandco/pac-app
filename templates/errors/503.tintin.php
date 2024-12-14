%extends('errors.layout', ['code' => 503])

%block('error')
  <h1>503</h1>
  <p>{{{ __('error.503') }}}</p>
  <div class="col-sm-12 empty-data-container" style="margin-bottom: 0; margin-top: 0; padding: 0">
    <div class="empty-data">
      <img src="/img/misc/traffic-cone.svg" class="no-img-bg-color" style="width: 85px">
    </div>
  </div>
%endsection
